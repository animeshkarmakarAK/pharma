<?php

namespace App\Services;


use App\Helpers\Classes\DatatableHelper;
use App\Models\Batch;
use App\Models\LocDistrict;
use App\Models\LocDivision;
use App\Models\Trainee;
use App\Models\TraineeBatch;
use App\Models\TraineeCourseEnroll;
use App\Models\TraineeRegistration;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class TraineeManagementService
{
    public function validateAddTraineeToBatch(Request $request): Validator
    {
        $rules = [
            'batch_id' => ['bail', 'required'],
            'trainee_enroll_ids' => ['bail', 'required', 'array', 'min:1'],
        ];
        return \Illuminate\Support\Facades\Validator::make($request->all(), $rules);
    }


    public function getListDataForDatatable($request): JsonResponse
    {
        $trainee = Trainee::select([
            'trainees.id as id',
            'trainees.name',
            'trainees.mobile',
            DB::raw('DATE_FORMAT(trainees.created_at,"%d %b, %Y %h:%i %p") AS application_date'),
            'trainees.updated_at',
            'institutes.title as institutes.title',
            'branches.title as branches.title',
            'training_centers.title as training_centers.title',
            'programmes.title as programmes.title',
                'courses.title as courses.title',
            'trainee_course_enrolls.id as trainee_course_enroll_id',
            'trainee_course_enrolls.enroll_status',
            'trainee_course_enrolls.payment_status',
            'trainee_batches.id as trainee_batch_id',
            'trainee_batches.trainee_course_enroll_id as trainee_batch_trainee_course_enroll_id',
        ]);
        $trainee->join('trainee_course_enrolls', 'trainees.id', '=', 'trainee_course_enrolls.trainee_id');
        $trainee->join('institutes', 'institutes.id', '=', 'courses.institute_id');
        $trainee->leftJoin('branches', 'branches.id', '=', 'courses.branch_id');
        $trainee->leftJoin('training_centers', 'training_centers.id', '=', 'courses.training_center_id');
        $trainee->leftJoin('courses', 'courses.id', '=', 'courses.id');
        $trainee->leftJoin('trainee_batches', 'trainee_batches.trainee_course_enroll_id', '=', 'trainee_course_enrolls.id');
        $trainee->where('trainee_batches.trainee_course_enroll_id', null);
        $trainee->where('trainee_course_enrolls.enroll_status', TraineeCourseEnroll::ENROLL_STATUS_PROCESSING);


        $instituteId = $request->input('institute_id');
        $branchId = $request->input('branch_id');
        $trainingCenterId = $request->input('training_center_id');
        $courseId = $request->input('course_id');
        $programmeId = $request->input('programme_id');
        $applicationDate = $request->input('application_date');


        if ($instituteId) {
            $trainee->where('courses.institute_id', $instituteId);
        }
        if ($branchId) {
            $trainee->where('courses.branch_id', $branchId);
        }
        if ($trainingCenterId) {
            $trainee->where('courses.training_center_id', $trainingCenterId);
        }
        if ($courseId) {
            $trainee->where('courses.course_id', $courseId);
        }
        if ($programmeId) {
            $trainee->where('courses.programme_id', $programmeId);
        }
        if ($applicationDate) {
            $trainee->whereDate('trainees.created_at', Carbon::parse($applicationDate)->format('Y-m-d'));
        }


        return DataTables::eloquent($trainee)
            ->addColumn('action', DatatableHelper::getActionButtonBlock(static function (Trainee $trainee) {
                $str = '';
                $str .= '<a href="' . route('frontend.trainee-registrations.show', $trainee->id) . '" class="btn btn-outline-info btn-sm"> <i class="fas fa-eye"></i> ' . __('generic.read_button_label') . ' </a>';
                if ($trainee->enroll_status == TraineeCourseEnroll::ENROLL_STATUS_PROCESSING) {
                    $str .= '<a href="#" data-action="' . route('admin.trainee-course-enroll-accept', $trainee->trainee_course_enroll_id) . '"' . ' class="btn btn-outline-success btn-sm accept-application"> <i class="fas fa-check-circle"></i> ' . __('Accept Now') . ' </a>';
                    $str .= '<a href="#" data-action="' . route('admin.trainee-course-enroll-reject', $trainee->trainee_course_enroll_id) . '"' . ' class="btn btn-outline-danger btn-sm reject-application"> <i class="fas fa-times-circle"></i> ' . __('Reject') . ' </a>';
                }
                return $str;
            }))
            ->addColumn('enroll_status', DatatableHelper::getActionButtonBlock(static function (Trainee $trainee) {

                $str = '';
                $str .= '<span style="width:70px" ' . '" class="badge badge-' . ($trainee->enroll_status == TraineeCourseEnroll::ENROLL_STATUS_PROCESSING ? "warning enroll-processing" : ($trainee->enroll_status == TraineeCourseEnroll::ENROLL_STATUS_ACCEPT ? "success enroll-accept" : "danger enroll-reject")) . '">' . ($trainee->enroll_status == TraineeCourseEnroll::ENROLL_STATUS_PROCESSING ? "Processing" : ($trainee->enroll_status == TraineeCourseEnroll::ENROLL_STATUS_ACCEPT ? "Accepted" : "Rejected")) . ' </span>';
                return $str;
            }))
            ->addColumn('payment_status', DatatableHelper::getActionButtonBlock(static function (Trainee $trainee) {
                $str = '';
                $str .= '<span style="width:70px" ' . '" class="badge badge-' . ($trainee->payment_status ? "success payment-paid" : "danger payment-unpaid") . '">' . ($trainee->payment_status ? "Paid" : "Unpaid") . ' </span>';
                return $str;
            }))
            ->editColumn('registration_date', function (Trainee $trainee) {
                return date('d M Y', strtotime($trainee->registration_date));
            })
            ->addColumn('paid_or_unpaid', static function (Trainee $trainee) {
                return $trainee->payment_status;
            })
            ->addColumn('enroll_status_check', static function (Trainee $trainee) {
                return $trainee->enroll_status;
            })
            ->rawColumns(['action', 'enroll_status', 'payment_status', 'paid_or_unpaid', 'enroll_status_check'])
            ->toJson();
    }

    public function addTraineeToBatch(Batch $batch, array $traineeCourseEnrolls): bool
    {
        foreach ($traineeCourseEnrolls as $traineeCourseEnrollId) {
            /** @var TraineeRegistration $traineeCourseEnroll */
            $traineeCourseEnroll = TraineeCourseEnroll::findOrFail($traineeCourseEnrollId);

            TraineeBatch::updateOrCreate(
                [
                    'batch_id' => $batch->id,
                    'trainee_course_enroll_id' => $traineeCourseEnroll->id,
                ],
                [
                    'enrollment_date' => now(),
                    'enrollment_status' => TraineeBatch::ENROLLMENT_STATUS_ENROLLED,
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
