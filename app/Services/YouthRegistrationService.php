<?php


namespace App\Services;

use App\Helpers\Classes\AuthHelper;
use App\Helpers\Classes\FileHandler;
use App\Helpers\Classes\Helper;
use App\Models\Batch;
use App\Models\Youth;
use App\Models\YouthCourseEnroll;
use App\Models\YouthFamilyMemberInfo;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Validation\ValidationException;
use Yajra\DataTables\Facades\DataTables;

class YouthRegistrationService
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
        $presentAddress = data_get($data, 'address.present');
        $permanentAddress = data_get($data, 'address.permanent');
        $youth = Arr::only($data, ['name_en','mobile', 'email', 'ethnic_group', 'recommended_by_organization', 'recommended_org_name', 'current_employment_status', 'year_of_experience', 'personal_monthly_income', 'have_family_own_house', 'have_family_own_land', 'number_of_siblings', 'student_signature_pic', 'student_pic']);
        $youth = array_merge($youth, $presentAddress);
        $youth = array_merge($youth, $permanentAddress);

        $youth['access_key'] = Youth::getUniqueAccessKey();
        $youth['youth_registration_no'] = Helper::randomPassword(10, true);


        if (isset($data['student_signature_pic'])) {
            $filename = FileHandler::storePhoto($youth['student_signature_pic'], 'student');
            $youth['student_signature_pic'] = 'student/' . $filename;
        }

        if (isset($data['student_pic'])) {
            $filename = FileHandler::storePhoto($youth['student_pic'], 'student', 'signature_' . $youth['access_key']);
            $youth['student_pic'] = 'student/' . $filename;
        }

        if (!$youth = Youth::create($youth)) {
            throw ValidationException::withMessages(['publish_course_id' => 'Youth creation failed!']);
        }

        $youthCourseEnrollInfo = Arr::only($data, ['publish_course_id']);

        $youth->youthCourseEnroll()->create($youthCourseEnrollInfo);
        $skipGuardian = false;

        if (empty($data['guardian'])) {
            $data['guardian'] = null;
        }

        foreach ($data['familyMember'] as $key => $familyMember) {
            if (($skipGuardian && $key == 'guardian') || (empty($data['guardian']) && $key == "guardian")) continue;

            if ($key == 'father') {
                if ($this->guardian($data['guardian'], YouthFamilyMemberInfo::GUARDIAN_FATHER)) {
                    $familyMember['is_guardian'] = YouthFamilyMemberInfo::GUARDIAN_FATHER;
                    $skipGuardian = true;
                }
                $familyMember['relation_with_youth'] = "father";

            } elseif ($key == 'mother') {
                if ($this->guardian($data['guardian'], YouthFamilyMemberInfo::GUARDIAN_MOTHER)) {
                    $familyMember['is_guardian'] = YouthFamilyMemberInfo::GUARDIAN_MOTHER;
                    $skipGuardian = true;
                }
                $familyMember['relation_with_youth'] = "mother";
            } elseif (!empty($data['guardian']) && $data['guardian'] == YouthFamilyMemberInfo::GUARDIAN_OTHER && $key == 'guardian') {
                $familyMember['is_guardian'] = YouthFamilyMemberInfo::GUARDIAN_OTHER;
            }
            $youth->youthFamilyMemberInfo()->create($familyMember);
        }


        /**
         * youth self info
         */

        $youthSelfInfo = Arr::only($data, ['mobile', 'personal_monthly_income',
            'gender', 'marital_status', 'main_occupation', 'other_occupations', 'physical_disabilities', 'disable_status',
            'freedom_fighter_status', 'nid', 'birth_certificate_no', 'passport_number', 'religion', 'nationality', 'date_of_birth']);
        $youthSelfInfo['relation_with_youth'] = "self";


        $disabilities = null;
        if (isset($youthSelfInfo['disable_status']) && $youthSelfInfo['disable_status'] == YouthFamilyMemberInfo::PHYSICALLY_DISABLE_YES) {
            $disabilities = $youthSelfInfo['physical_disabilities'];
            $youthSelfInfo['physical_disabilities'] = collect($disabilities)->toJson();
        }

        $youth->youthFamilyMemberInfo()->create($youthSelfInfo);

        foreach ($data['academicQualification'] as $key => $academicQualification) {
            if ($academicQualification['examination_name'] == null) continue;

            $youth->youthAcademicQualifications()->create($academicQualification);
        }

        return $youth;
    }

    public function validator(Request $request): Validator
    {
        $rules = [
            'name' => 'required|string|max:191',
            'mobile' => 'required|string|max:20',
            'date_of_birth' => 'required|date',
            'email' => 'required|string|max:191|email|unique:youths',
            'loc_division_id' => 'required|int',
            'loc_district_id' => 'required|int',
            'loc_upazila_id' => 'required|int',
            'physically_disable' => 'nullable',
            'physical_disabilities' => 'nullable',
            'gender' => 'required|int',
        ];

        return \Illuminate\Support\Facades\Validator::make($request->all(), $rules);
    }


    public function getYouthAcademicQualification(Youth $youth): Collection
    {
        return $youth->youthAcademicQualifications;
    }

    public function getYouthFamilyMemberInfo(Youth $youth): array
    {
        $father = $youth->youthFamilyMemberInfo->where('relation_with_youth', 'father')->first();
        $mother = $youth->youthFamilyMemberInfo->where('relation_with_youth', 'mother')->first();
        $guardian = $youth->youthFamilyMemberInfo->where('is_guardian', YouthFamilyMemberInfo::GUARDIAN_OTHER)->first();

        if (!empty($father) && empty($guardian) && $father->is_guardian == YouthFamilyMemberInfo::GUARDIAN_FATHER) {
            $guardian = $father;
        } else if (!empty($mother) && empty($guardian) && $mother->is_guardian == YouthFamilyMemberInfo::GUARDIAN_MOTHER) {
            $guardian = $mother;
        }

        $haveYouthFamilyMembersInfo = true;
        if (empty($father) && empty($mother) && empty($guardian)) {
            $haveYouthFamilyMembersInfo = false;
        }
        return [
            'father' => $father,
            'mother' => $mother,
            'guardian' => $guardian,
            'haveYouthFamilyMembersInfo' => $haveYouthFamilyMembersInfo,
        ];
    }

    public function getYouthInfo(Youth $youth): Model
    {
        return $youth->youthFamilyMemberInfo->where('relation_with_youth', 'self')->first();
    }

    public function changeYouthCourseEnrollStatusAccept(YouthCourseEnroll $youthCourseEnroll)
    {
        $data['enroll_status'] = YouthCourseEnroll::ENROLL_STATUS_ACCEPT;
        $youthCourseEnroll->update($data);
    }

    public function changeYouthCourseEnrollStatusReject(YouthCourseEnroll $youthCourseEnroll)
    {
        $data['enroll_status'] = YouthCourseEnroll::ENROLL_STATUS_REJECT;
        $youthCourseEnroll->update($data);
    }

    /**
     * @param Request $request
     * @return JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function getListDataForDatatable(Request $request)
    {
        $youth = AuthHelper::getAuthUser('youth');
        if (!$youth) {
            return redirect()->route('youth.login-form')->with([
                    'message' => 'You are not Auth user, Please login',
                    'alert-type' => 'error']
            );
        }

        /** @var Builder|YouthCourseEnroll $youthCourseEnrolls */
        $youthCourseEnrolls = YouthCourseEnroll::select([
            'youth_course_enrolls.id as id',
            'youth_course_enrolls.youth_id',
            'youth_course_enrolls.publish_course_id',
            'youth_course_enrolls.enroll_status',
            'youth_course_enrolls.payment_status',
            'youth_course_enrolls.created_at as enroll_date',
            'youth_course_enrolls.updated_at as enroll_updated_date',
            'courses.course_fee as course_fee',
            'youth_batches.batch_id as batch_id',
            'batches.batch_status as batch_status',
            'batches.title_en as batch_title_en',
        ]);

        $youthCourseEnrolls->join('courses', 'courses.id', '=', 'publish_courses.course_id');
        $youthCourseEnrolls->leftJoin('youth_batches', 'youth_batches.youth_course_enroll_id', '=', 'youth_course_enrolls.id');
        $youthCourseEnrolls->leftJoin('batches', 'youth_batches.batch_id', '=', 'batches.id');
        $youthCourseEnrolls->join('youths', 'youths.id', '=', 'youth_course_enrolls.youth_id');

        $youthCourseEnrolls->where('youth_course_enrolls.youth_id', $youth->id);

        return DataTables::eloquent($youthCourseEnrolls)
            ->addColumn('enroll_status', static function (YouthCourseEnroll $youthCourseEnroll) {
                $str = '';
                $str .= '<span href="#" style="width:80px" class="badge ' . ($youthCourseEnroll->enroll_status == YouthCourseEnroll::ENROLL_STATUS_PROCESSING ? 'badge-warning' : ($youthCourseEnroll->enroll_status == YouthCourseEnroll::ENROLL_STATUS_ACCEPT ? 'badge-success' : 'badge-danger')) . '"> ' . ($youthCourseEnroll->enroll_status == YouthCourseEnroll::ENROLL_STATUS_PROCESSING ? 'Processing' : ($youthCourseEnroll->enroll_status == YouthCourseEnroll::ENROLL_STATUS_ACCEPT ? 'Accepted' : 'Rejected')) . ' </span>';
                return $str;
            })
            ->addColumn('payment_status', static function (YouthCourseEnroll $youthCourseEnroll) {
                $str = '';
                return $str .= '<span href="#" style="width:80px" class="badge ' . ($youthCourseEnroll->payment_status ? 'badge-success' : 'badge-warning') . '"> ' . ($youthCourseEnroll->payment_status ? 'Paid' : 'Unpaid') . ' </span>';
            })
            ->addColumn('action', static function (YouthCourseEnroll $youthCourseEnroll) {
                $str = '';
                if ($youthCourseEnroll->enroll_status == YouthCourseEnroll::ENROLL_STATUS_ACCEPT and !$youthCourseEnroll->payment_status and (date("Y-m-d H:i:s") < date('Y-m-d H:i:s', strtotime($youthCourseEnroll->enroll_updated_date . ' + 3 days')))) {
                    $str .= '<a href="#" data-action="' . route('youth-course-enroll-pay-now', $youthCourseEnroll->id) . '" class="btn btn-info btn-sm pay-now"> <i class="fas fa-dollar-sign"></i> ' . __(' Pay Now') . ' </a>';
                }
                if ($youthCourseEnroll->batch_id != null && $youthCourseEnroll->batch_status == Batch::BATCH_STATUS_COMPLETE) {
                    $str .= '<a href="' . route('youth-certificate-view', $youthCourseEnroll->id) . '" data-action="' . route('youth-certificate-view', $youthCourseEnroll->id) . '" class="btn btn-info btn-sm" target="_blank"> <i class="fas fa-download"></i> ' . __(' Certificate') . ' </a>';
                }
                return $str;
            })
            ->addColumn('enroll_last_date', static function (YouthCourseEnroll $youthCourseEnroll) {
                $str = '';
                if ($youthCourseEnroll->enroll_status == YouthCourseEnroll::ENROLL_STATUS_ACCEPT and !$youthCourseEnroll->payment_status) {
                    $str .= '<span href="#" class="badge badge-secondary"> ' . date('d M, Y h:i:s A', strtotime($youthCourseEnroll->enroll_updated_date . ' + 3 days')) . ' </span>';
                }
                return $str;
            })
            ->addColumn('batch_status', static function (YouthCourseEnroll $youthCourseEnroll) {
                return '<span href="#" class="badge ' . ($youthCourseEnroll->batch_id ? ($youthCourseEnroll->batch_status ? ($youthCourseEnroll->batch_status == Batch::BATCH_STATUS_COMPLETE ? 'badge-success' : 'badge-info') : 'badge-secondary') : 'badge-secondary') . '"> '
                    . ($youthCourseEnroll->batch_id ? ($youthCourseEnroll->batch_status ? ($youthCourseEnroll->batch_status == Batch::BATCH_STATUS_COMPLETE ? 'Complete - ' . $youthCourseEnroll->batch_title_en : 'On Going - ' . $youthCourseEnroll->batch_title_en) : 'Assigned to - ' . $youthCourseEnroll->batch_title_en) : 'Not Assigned') . ' </span>';
            })
            ->rawColumns(['enroll_status', 'payment_status', 'action', 'enroll_last_date', 'batch_status'])
            ->toJson();
    }

}
