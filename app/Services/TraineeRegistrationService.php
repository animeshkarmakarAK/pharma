<?php


namespace App\Services;

use App\Helpers\Classes\AuthHelper;
use App\Helpers\Classes\FileHandler;
use App\Models\Batch;
use App\Models\Trainee;
use App\Models\TraineeCourseEnroll;
use App\Models\TraineeFamilyMemberInfo;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\RequiredIf;
use Yajra\DataTables\Facades\DataTables;

class TraineeRegistrationService
{
    private function guardian($p1, $p2)
    {
        if (empty($p1)) {
            return false;
        }
        if ($p1 == $p2) {
            return true;
        } else {
            return false;
        }
    }

    public function createRegistration(array $data)
    {
        $data['password'] = Hash::make($data['password']);

        if (isset($data['student_signature_pic'])) {
            $filename = FileHandler::storePhoto($data['student_signature_pic'], 'student');
            $trainee['student_signature_pic'] = 'student/' . $filename;
        }

        if (isset($data['student_pic'])) {
            $filename = FileHandler::storePhoto($data['student_pic'], 'student', 'signature_' . $data['access_key']);
            $trainee['student_pic'] = 'student/' . $filename;
        }

        return Trainee::create($data);
    }

    public function validator(Request $request, $id = null): Validator
    {
        $rules = [
            'name' => 'required|string|max:191',
            'mobile' => 'required|string|max:20',
            'date_of_birth' => 'required|date',
            'email' => 'required|string|max:191|email|unique:trainees',
            'loc_division_id' => 'required|int',
            'loc_district_id' => 'required|int',
            'loc_upazila_id' => 'required|int',
            'physically_disable' => 'nullable',
            'disable_status' => 'nullable',
            'physical_disabilities' => 'nullable',
            'gender' => 'required|int',
            'password' => [
                'bail',
                new RequiredIf($id == null),
                'confirmed'
            ]
        ];

        return \Illuminate\Support\Facades\Validator::make($request->all(), $rules);
    }


    public function getTraineeAcademicQualification(Trainee $trainee): Collection
    {
        return $trainee->traineeAcademicQualifications;
    }

    public function getTraineeFamilyMemberInfo(Trainee $trainee): array
    {
        $father = $trainee->traineeFamilyMemberInfo->where('relation_with_trainee', 'father')->first();
        $mother = $trainee->traineeFamilyMemberInfo->where('relation_with_trainee', 'mother')->first();
        $guardian = $trainee->traineeFamilyMemberInfo->where('is_guardian', TraineeFamilyMemberInfo::GUARDIAN_OTHER)->first();

        if (!empty($father) && empty($guardian) && $father->is_guardian == TraineeFamilyMemberInfo::GUARDIAN_FATHER) {
            $guardian = $father;
        } else if (!empty($mother) && empty($guardian) && $mother->is_guardian == TraineeFamilyMemberInfo::GUARDIAN_MOTHER) {
            $guardian = $mother;
        }

        $haveTraineeFamilyMembersInfo = true;
        if (empty($father) && empty($mother) && empty($guardian)) {
            $haveTraineeFamilyMembersInfo = false;
        }
        return [
            'father' => $father,
            'mother' => $mother,
            'guardian' => $guardian,
            'haveTraineeFamilyMembersInfo' => $haveTraineeFamilyMembersInfo,
        ];
    }

    public function getTraineeInfo(Trainee $trainee): Model
    {
        return $trainee;
    }

    public function changeTraineeCourseEnrollStatusAccept(TraineeCourseEnroll $traineeCourseEnroll)
    {
        $data['enroll_status'] = TraineeCourseEnroll::ENROLL_STATUS_ACCEPT;
        $traineeCourseEnroll->update($data);
    }

    public function changeTraineeCourseEnrollStatusReject(TraineeCourseEnroll $traineeCourseEnroll)
    {
        $data['enroll_status'] = TraineeCourseEnroll::ENROLL_STATUS_REJECT;
        $traineeCourseEnroll->update($data);
    }

    /**
     * @param Request $request
     * @return JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function getListDataForDatatable(Request $request)
    {
        $trainee = AuthHelper::getAuthUser('trainee');
        if (!$trainee) {
            return redirect()->route('frontend.trainee.login-form')->with([
                    'message' => 'You are not Auth user, Please login',
                    'alert-type' => 'error']
            );
        }

        /** @var Builder|TraineeCourseEnroll $traineeCourseEnrolls */
        $traineeCourseEnrolls = TraineeCourseEnroll::select([
            'trainee_course_enrolls.id as id',
            'trainee_course_enrolls.trainee_id',
            'trainee_course_enrolls.publish_course_id',
            'trainee_course_enrolls.enroll_status',
            'trainee_course_enrolls.payment_status',
            'trainee_course_enrolls.created_at as enroll_date',
            'trainee_course_enrolls.updated_at as enroll_updated_date',
            'courses.course_fee as course_fee',
            'trainee_batches.batch_id as batch_id',
            'batches.batch_status as batch_status',
            'batches.title as batch_title',
        ]);

        $traineeCourseEnrolls->join('courses', 'courses.id', '=', 'publish_courses.course_id');
        $traineeCourseEnrolls->leftJoin('trainee_batches', 'trainee_batches.trainee_course_enroll_id', '=', 'trainee_course_enrolls.id');
        $traineeCourseEnrolls->leftJoin('batches', 'trainee_batches.batch_id', '=', 'batches.id');
        $traineeCourseEnrolls->join('trainees', 'trainees.id', '=', 'trainee_course_enrolls.trainee_id');

        $traineeCourseEnrolls->where('trainee_course_enrolls.trainee_id', $trainee->id);

        return DataTables::eloquent($traineeCourseEnrolls)
            ->addColumn('enroll_status', static function (TraineeCourseEnroll $traineeCourseEnroll) {
                $str = '';
                $str .= '<span href="#" style="width:80px" class="badge ' . ($traineeCourseEnroll->enroll_status == TraineeCourseEnroll::ENROLL_STATUS_PROCESSING ? 'badge-warning' : ($traineeCourseEnroll->enroll_status == TraineeCourseEnroll::ENROLL_STATUS_ACCEPT ? 'badge-success' : 'badge-danger')) . '"> ' . ($traineeCourseEnroll->enroll_status == TraineeCourseEnroll::ENROLL_STATUS_PROCESSING ? 'Processing' : ($traineeCourseEnroll->enroll_status == TraineeCourseEnroll::ENROLL_STATUS_ACCEPT ? 'Accepted' : 'Rejected')) . ' </span>';
                return $str;
            })
            ->addColumn('payment_status', static function (TraineeCourseEnroll $traineeCourseEnroll) {
                $str = '';
                return $str .= '<span href="#" style="width:80px" class="badge ' . ($traineeCourseEnroll->payment_status ? 'badge-success' : 'badge-warning') . '"> ' . ($traineeCourseEnroll->payment_status ? 'Paid' : 'Unpaid') . ' </span>';
            })
            ->addColumn('action', static function (TraineeCourseEnroll $traineeCourseEnroll) {
                $str = '';
                if ($traineeCourseEnroll->enroll_status == TraineeCourseEnroll::ENROLL_STATUS_ACCEPT and !$traineeCourseEnroll->payment_status and (date("Y-m-d H:i:s") < date('Y-m-d H:i:s', strtotime($traineeCourseEnroll->enroll_updated_date . ' + 3 days')))) {
                    $str .= '<a href="#" data-action="' . route('frontend.trainee-course-enroll-pay-now', $traineeCourseEnroll->id) . '" class="btn btn-info btn-sm pay-now"> <i class="fas fa-dollar-sign"></i> ' . __(' Pay Now') . ' </a>';
                }
                if ($traineeCourseEnroll->batch_id != null && $traineeCourseEnroll->batch_status == Batch::BATCH_STATUS_COMPLETE) {
                    $str .= '<a href="' . route('frontend.trainee-certificate-view', $traineeCourseEnroll->id) . '" data-action="' . route('trainee-certificate-view', $traineeCourseEnroll->id) . '" class="btn btn-info btn-sm" target="_blank"> <i class="fas fa-download"></i> ' . __(' Certificate') . ' </a>';
                }
                return $str;
            })
            ->addColumn('enroll_last_date', static function (TraineeCourseEnroll $traineeCourseEnroll) {
                $str = '';
                if ($traineeCourseEnroll->enroll_status == TraineeCourseEnroll::ENROLL_STATUS_ACCEPT and !$traineeCourseEnroll->payment_status) {
                    $str .= '<span href="#" class="badge badge-secondary"> ' . date('d M, Y h:i:s A', strtotime($traineeCourseEnroll->enroll_updated_date . ' + 3 days')) . ' </span>';
                }
                return $str;
            })
            ->addColumn('batch_status', static function (TraineeCourseEnroll $traineeCourseEnroll) {
                return '<span href="#" class="badge ' . ($traineeCourseEnroll->batch_id ? ($traineeCourseEnroll->batch_status ? ($traineeCourseEnroll->batch_status == Batch::BATCH_STATUS_COMPLETE ? 'badge-success' : 'badge-info') : 'badge-secondary') : 'badge-secondary') . '"> '
                    . ($traineeCourseEnroll->batch_id ? ($traineeCourseEnroll->batch_status ? ($traineeCourseEnroll->batch_status == Batch::BATCH_STATUS_COMPLETE ? 'Complete - ' . $traineeCourseEnroll->batch_title : 'On Going - ' . $traineeCourseEnroll->batch_title) : 'Assigned to - ' . $traineeCourseEnroll->batch_title) : 'Not Assigned') . ' </span>';
            })
            ->rawColumns(['enroll_status', 'payment_status', 'action', 'enroll_last_date', 'batch_status'])
            ->toJson();
    }

}
