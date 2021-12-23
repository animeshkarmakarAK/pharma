<?php

namespace App\Services;

use App\Helpers\Classes\DatatableHelper;
use App\Helpers\Classes\FileHandler;
use App\Models\Batch;
use App\Models\BatchCertificate;
use App\Models\Course;
use App\Models\TraineeCourseEnroll;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Support\Facades\DB;
use App\Models\TraineeBatch;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class TraineeCertificateService
{

    /**
     * @param Request $request
     * @param null $id
     * @return Validator
     */
    public function validator(Request $request, $id = null): Validator
    {
        $rules = [
            'authorized_by' => [
                'required',
                'string',
                'max:191'
            ],
            'issued_date' => [
                'required'
            ],
            'batch_id' => [
                'required',
                'int'
            ],
            'tamplate' => [
                'required'
            ],
            /*'signature' => [
                'image',
                'max:500',
                'mimes:jpg,bmp,png,jpeg,svg',

            ],*/

        ];

        return \Illuminate\Support\Facades\Validator::make($request->all(), $rules);
    }

    public function createBatchCertificate(array $data):BatchCertificate
    {

        //dd($data);
        $filename = null;
        if (!empty($data['signature'])) {
            $filename = FileHandler::storePhoto($data['signature'], 'signature');
        }

        if ($filename) {
            $data['signature'] = 'signature/' . $filename;
        } else {
            $data['signature'] = '';
        }

        //dd($data);
        return BatchCertificate::create($data);
    }


    public function getTraineeBatchLists(Request $request): JsonResponse
    {
        /** @var Builder $traineeBatches */


        //View batch table with is certificate design assign,
        // number of stuednts,
        // number of certificate assign edit update certificate tamplate informations,
        // see all student who received certificates

        $traineeCourseEnrolls = TraineeCourseEnroll::select(
            [
                'trainee_course_enrolls.batch_id as id',
                'batches.title as batch_title',
                'courses.title as course_title',
                //'batch_certificates.id as certificate',
                DB::raw('COUNT(trainee_course_enrolls.trainee_id) as trainee'),
                DB::raw('CASE WHEN EXISTS (SELECT Id FROM batch_certificates WHERE batch_certificates.batch_id = trainee_course_enrolls.batch_id) THEN TRUE  ELSE FALSE  END AS certificate ')
                //DB::raw('DATE_FORMAT(trainee_course_enrolls.enrollment_date,"%d %b, %Y %h:%i %p") AS enrollment_date'),
            ]
        );
        $traineeCourseEnrolls->join('batches', 'trainee_course_enrolls.batch_id', '=', 'batches.id');
        $traineeCourseEnrolls->join('courses', 'batches.course_id', '=', 'courses.id');
        $traineeCourseEnrolls->leftJoin('batch_certificates', 'batch_certificates.batch_id', '=', 'trainee_course_enrolls.batch_id');
        $traineeCourseEnrolls->where('batches.batch_status', Batch::BATCH_STATUS_COMPLETE);
        $traineeCourseEnrolls->groupBy('trainee_course_enrolls.batch_id');


        return DataTables::eloquent($traineeCourseEnrolls)
            ->addColumn('is_certificate', function (TraineeCourseEnroll $traineeCourseEnroll)  {
                if ($traineeCourseEnroll->certificate) {
                    return '<div class="btn-group btn-group-sm" role="group"><span class="badge badge-success">Created</span></div>';
                }else{
                    return '<div class="btn-group btn-group-sm" role="group"><span class="badge badge-warning">Not Created</span></div>';
                }
            })
            ->addColumn('action', DatatableHelper::getActionButtonBlock(static function (TraineeCourseEnroll $traineeCourseEnroll) {
                $str = '';
                $str .= '<a href="' . route('frontend.trainee-registrations.show', $traineeCourseEnroll->id) . '" class="btn btn-outline-info btn-sm"> <i class="fas fa-eye"></i> Read </a>';
                $str .= '<a href="' . route('admin.batches.certificates.edit', $traineeCourseEnroll->id) . '" class="btn btn-outline-warning btn-sm"> <i class="fas fa-eye"></i> Certificate </a>';
                return $str;
            }))
            ->rawColumns(['action','is_certificate'])
            ->toJson();
    }
}
