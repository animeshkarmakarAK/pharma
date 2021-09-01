<?php

namespace Module\CourseManagement\App\Services;


use App\Helpers\Classes\DatatableHelper;
use Module\CourseManagement\App\Models\Batch;
use Module\CourseManagement\App\Models\Youth;
use Module\CourseManagement\App\Models\YouthBatch;
use Module\CourseManagement\App\Models\YouthRegistration;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

use Illuminate\Support\Carbon;
use Yajra\DataTables\Facades\DataTables;

class YouthManagementService
{
    public function validateAddYouthToBatch(Request $request): Validator
    {
        $rules = [
            'batch_id' => ['bail', 'required'],
            'youth_registration_ids' => ['bail', 'required', 'array', 'min:1', static function ($attribute, $value, $fail) {
//                if (Youth::whereIn('id', $value)->pluck('programme_id')->unique()->count() != 1) {
//                    $fail(__('Please select same programme type to process.'));
//                }
            }]
        ];
        return \Illuminate\Support\Facades\Validator::make($request->all(), $rules);
    }

    public function getListDataForDatatable($request): JsonResponse
    {
        $youth = Youth::select([
            'youths.id as id',
            'youths.name_en',
            'youths.name_bn',
            'youths.mobile',
            'youths.created_at as application_date',
            'youths.updated_at',
            'youth_registrations.id as youth_registration_id',
            'youth_registrations.youth_registration_no',
            'publish_courses.id as publish_courses.id',
            'institutes.title_en as institutes.title_en',
            'branches.title_en as branches.title_en',
            'training_centers.title_en as training_centers.title_en',
            'programmes.title_en as programmes.title_en',
            'courses.title_en as courses.title_en',
        ]);
        $youth->join('youth_registrations', 'youths.id', '=', 'youth_registrations.youth_id');
        $youth->join('publish_courses', 'publish_courses.id', '=', 'youth_registrations.publish_course_id');
        $youth->join('institutes', 'institutes.id', '=', 'publish_courses.institute_id');
        $youth->leftJoin('branches', 'branches.id', '=', 'publish_courses.branch_id');
        $youth->leftJoin('training_centers', 'training_centers.id', '=', 'publish_courses.training_center_id');
        $youth->leftJoin('programmes', 'programmes.id', '=', 'publish_courses.programme_id');
        $youth->leftJoin('courses', 'courses.id', '=', 'publish_courses.course_id');
        $youth->where('youth_registrations.youth_registration_no', null);

        $instituteId = $request->input('institute_id');
        $branchId = $request->input('branch_id');
        $trainingCenterId = $request->input('training_center_id');
        $courseId = $request->input('course_id');
        $programmeId = $request->input('programme_id');
        $applicationDate = $request->input('application_date');

        if ($instituteId) {
            $youth->where('publish_courses.institute_id', $instituteId);
        }
        if ($branchId) {
            $youth->where('publish_courses.branch_id', $branchId);
        }
        if ($trainingCenterId) {
            $youth->where('publish_courses.training_center_id', $trainingCenterId);
        }
        if ($courseId) {
            $youth->where('publish_courses.course_id', $courseId);
        }
        if ($programmeId) {
            $youth->where('publish_courses.programme_id', $programmeId);
        }
        if ($applicationDate) {
            $youth->whereDate('youths.created_at', Carbon::parse($applicationDate)->format('Y-m-d'));
        }

        return DataTables::eloquent($youth)
            ->addColumn('action', DatatableHelper::getActionButtonBlock(static function (Youth $youth) {
                $str = '';
                $str .= '<a href="' . route('course_management::youth-registrations.show', $youth->youth_registration_id) . '" class="btn btn-outline-info btn-sm"> <i class="fas fa-eye"></i> ' . __('generic.read_button_label') . ' </a>';
                return $str;
            }))
            ->editColumn('registration_date', function (Youth $youth) {
                return date('d M Y', strtotime($youth->registration_date));
            })
            ->rawColumns(['action'])
            ->toJson();
    }

    public function addYouthToBatch(Batch $batch, array $youths): bool
    {
        foreach ($youths as $youthRegistrationId) {
            /** @var YouthRegistration $youthRegistration */
            $youthRegistration = YouthRegistration::findOrFail($youthRegistrationId);
            YouthBatch::updateOrCreate(
                [
                    'batch_id' => $batch->id,
                    'youth_id' => $youthRegistration->youth_id,
                    'youth_registration_id' => $youthRegistrationId,
                ],
                [
                    'enrollment_date' => now(),
                    'enrollment_status' => YouthBatch::ENROLLMENT_STATUS_ENROLLED,
                ]
            );
            $youthRegistration->setYouthRegistrationNumber();
            $youthRegistration->save();
        }

        return true;
    }
}
