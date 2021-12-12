<?php

namespace App\Services;


use App\Helpers\Classes\DatatableHelper;
use App\Models\Batch;
use App\Models\LocDistrict;
use App\Models\LocDivision;
use App\Models\Youth;
use App\Models\YouthBatch;
use App\Models\YouthCourseEnroll;
use App\Models\YouthRegistration;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class YouthManagementService
{
    public function validateAddYouthToBatch(Request $request): Validator
    {
        $rules = [
            'batch_id' => ['bail', 'required'],
            'youth_enroll_ids' => ['bail', 'required', 'array', 'min:1'],
        ];
        return \Illuminate\Support\Facades\Validator::make($request->all(), $rules);
    }


    public function getListDataForDatatable($request): JsonResponse
    {
        $youth = Youth::select([
            'youths.id as id',
            'youths.name',
            'youths.mobile',
            DB::raw('DATE_FORMAT(youths.created_at,"%d %b, %Y %h:%i %p") AS application_date'),
            'youths.updated_at',
            'institutes.title as institutes.title',
            'branches.title as branches.title',
            'training_centers.title as training_centers.title',
            'programmes.title as programmes.title',
            'courses.title as courses.title',
            'youth_course_enrolls.id as youth_course_enroll_id',
            'youth_course_enrolls.enroll_status',
            'youth_course_enrolls.payment_status',
            'youth_batches.id as youth_batch_id',
            'youth_batches.youth_course_enroll_id as youth_batch_youth_course_enroll_id',
        ]);
        $youth->join('youth_course_enrolls', 'youths.id', '=', 'youth_course_enrolls.youth_id');
        $youth->join('institutes', 'institutes.id', '=', 'courses.institute_id');
        $youth->leftJoin('branches', 'branches.id', '=', 'courses.branch_id');
        $youth->leftJoin('training_centers', 'training_centers.id', '=', 'courses.training_center_id');
        $youth->leftJoin('courses', 'courses.id', '=', 'courses.id');
        $youth->leftJoin('youth_batches', 'youth_batches.youth_course_enroll_id', '=', 'youth_course_enrolls.id');
        $youth->where('youth_batches.youth_course_enroll_id', null);
        $youth->where('youth_course_enrolls.enroll_status', YouthCourseEnroll::ENROLL_STATUS_PROCESSING);


        $instituteId = $request->input('institute_id');
        $branchId = $request->input('branch_id');
        $trainingCenterId = $request->input('training_center_id');
        $courseId = $request->input('course_id');
        $programmeId = $request->input('programme_id');
        $applicationDate = $request->input('application_date');


        if ($instituteId) {
            $youth->where('courses.institute_id', $instituteId);
        }
        if ($branchId) {
            $youth->where('courses.branch_id', $branchId);
        }
        if ($trainingCenterId) {
            $youth->where('courses.training_center_id', $trainingCenterId);
        }
        if ($courseId) {
            $youth->where('courses.course_id', $courseId);
        }
        if ($programmeId) {
            $youth->where('courses.programme_id', $programmeId);
        }
        if ($applicationDate) {
            $youth->whereDate('youths.created_at', Carbon::parse($applicationDate)->format('Y-m-d'));
        }


        return DataTables::eloquent($youth)
            ->addColumn('action', DatatableHelper::getActionButtonBlock(static function (Youth $youth) {
                $str = '';
                $str .= '<a href="' . route('frontend.youth-registrations.show', $youth->id) . '" class="btn btn-outline-info btn-sm"> <i class="fas fa-eye"></i> ' . __('generic.read_button_label') . ' </a>';
                if ($youth->enroll_status == YouthCourseEnroll::ENROLL_STATUS_PROCESSING) {
                    $str .= '<a href="#" data-action="' . route('admin.youth-course-enroll-accept', $youth->youth_course_enroll_id) . '"' . ' class="btn btn-outline-success btn-sm accept-application"> <i class="fas fa-check-circle"></i> ' . __('Accept Now') . ' </a>';
                    $str .= '<a href="#" data-action="' . route('admin.youth-course-enroll-reject', $youth->youth_course_enroll_id) . '"' . ' class="btn btn-outline-danger btn-sm reject-application"> <i class="fas fa-times-circle"></i> ' . __('Reject') . ' </a>';
                }
                return $str;
            }))
            ->addColumn('enroll_status', DatatableHelper::getActionButtonBlock(static function (Youth $youth) {

                $str = '';
                $str .= '<span style="width:70px" ' . '" class="badge badge-' . ($youth->enroll_status == YouthCourseEnroll::ENROLL_STATUS_PROCESSING ? "warning enroll-processing" : ($youth->enroll_status == YouthCourseEnroll::ENROLL_STATUS_ACCEPT ? "success enroll-accept" : "danger enroll-reject")) . '">' . ($youth->enroll_status == YouthCourseEnroll::ENROLL_STATUS_PROCESSING ? "Processing" : ($youth->enroll_status == YouthCourseEnroll::ENROLL_STATUS_ACCEPT ? "Accepted" : "Rejected")) . ' </span>';
                return $str;
            }))
            ->addColumn('payment_status', DatatableHelper::getActionButtonBlock(static function (Youth $youth) {
                $str = '';
                $str .= '<span style="width:70px" ' . '" class="badge badge-' . ($youth->payment_status ? "success payment-paid" : "danger payment-unpaid") . '">' . ($youth->payment_status ? "Paid" : "Unpaid") . ' </span>';
                return $str;
            }))
            ->editColumn('registration_date', function (Youth $youth) {
                return date('d M Y', strtotime($youth->registration_date));
            })
            ->addColumn('paid_or_unpaid', static function (Youth $youth) {
                return $youth->payment_status;
            })
            ->addColumn('enroll_status_check', static function (Youth $youth) {
                return $youth->enroll_status;
            })
            ->rawColumns(['action', 'enroll_status', 'payment_status', 'paid_or_unpaid', 'enroll_status_check'])
            ->toJson();
    }

    public function addYouthToBatch(Batch $batch, array $youthCourseEnrolls): bool
    {
        foreach ($youthCourseEnrolls as $youthCourseEnrollId) {
            /** @var YouthRegistration $youthCourseEnroll */
            $youthCourseEnroll = YouthCourseEnroll::findOrFail($youthCourseEnrollId);

            YouthBatch::updateOrCreate(
                [
                    'batch_id' => $batch->id,
                    'youth_course_enroll_id' => $youthCourseEnroll->id,
                ],
                [
                    'enrollment_date' => now(),
                    'enrollment_status' => YouthBatch::ENROLLMENT_STATUS_ENROLLED,
                ]
            );
        }
        return true;
    }

    public function getDivisionId($title): int
    {
        return (LocDivision::where("title", $title)->first())->id ?? 0;
    }

    public function getDistrictId($title, $divisionTitle = null): int
    {
        $locDistrict = LocDistrict::where("title", $title);
        if ($divisionTitle) {
            $locDistrict->where("loc_division_id", $this->getDivisionId($divisionTitle));
        }
        $locDistrict = $locDistrict->first();

        return $locDistrict->id ?? 0;
    }
}
