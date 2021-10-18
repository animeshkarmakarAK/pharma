<?php


namespace Module\CourseManagement\App\Services;

use App\Helpers\Classes\AuthHelper;
use App\Helpers\Classes\FileHandler;
use App\Helpers\Classes\Helper;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\Rule;
use Module\CourseManagement\App\Models\Institute;
use Module\CourseManagement\App\Models\Youth;
use Module\CourseManagement\App\Models\YouthComplainToOrganization;
use Module\CourseManagement\App\Models\YouthCourseEnroll;
use Module\CourseManagement\App\Models\YouthFamilyMemberInfo;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Database\Eloquent\Model;
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
        $youth = Arr::only($data, ['name_en', 'name_bn', 'mobile', 'email', 'ethnic_group', 'recommended_by_organization', 'recommended_org_name', 'current_employment_status', 'year_of_experience', 'personal_monthly_income', 'have_family_own_house', 'have_family_own_land', 'number_of_siblings', 'student_signature_pic', 'student_pic']);
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
            'name_en' => 'required|string|max:191',
            'name_bn' => 'required|string|max:191',
            'mobile' => 'required|string|max:20',
            'nid' => [
                'nullable',
                'string',
                Rule::unique('youths_family_member_info')->where(function ($query) {
                    return $query->where('relation_with_youth', 'self');
                }),
            ],
            'passport_number' => [
                'nullable',
                'string',
                Rule::unique('youths_family_member_info')->where(function ($query) {
                    return $query->where('relation_with_youth', 'self');
                }),
            ],

            'birth_certificate_no' => [
                'nullable',
                'string',
                Rule::unique('youths_family_member_info')->where(function ($query) {
                    return $query->where('relation_with_youth', 'self');
                }),
            ],

            'date_of_birth' => 'required|date',
            'email' => 'required|string|max:191|email|unique:youths',
            'address.present.present_address_division_id' => 'required|int',
            'address.present.present_address_district_id' => 'required|int',
            'address.present.present_address_upazila_id' => 'required|int',
            'address.present.present_address_house_address' => 'required|array',
            'address.permanent.permanent_address_division_id' => 'required|int',
            'address.permanent.permanent_address_district_id' => 'required|int',
            'address.permanent.permanent_address_upazila_id' => 'required|int',
            'address.permanent.permanent_address_house_address' => 'required|array',
            'familyMember.father.member_name_en' => 'required|string|max:191',
            'familyMember.father.nid' => 'required|string|max:191',
            'familyMember.father.date_of_birth' => 'required|date',
            'familyMember.father.mobile' => 'required|string',
            'familyMember.mother.member_name_en' => 'required|string|max:191',
            'familyMember.mother.nid' => 'required|string|max:191',
            'familyMember.mother.date_of_birth' => 'required|date',
            'familyMember.mother.mobile' => 'required|string',

            'familyMember.guardian.member_name_en' => 'nullable|string|max:191',
            'familyMember.guardian.nid' => 'nullable|string|max:191',
            'familyMember.guardian.date_of_birth' => 'nullable|date',
            'familyMember.guardian.mobile' => 'nullable|string',
            'familyMember.guardian.relation_with_youth' => 'nullable|string',
            'guardian' => 'nullable|int',
            'disable_status' => 'nullable',
            'physical_disabilities' => 'nullable',

            'gender' => 'required|int',
            'marital_status' => 'required|int',
            'branch_id' => 'nullable|int',
            'training_center_id' => 'nullable|int',
            'programme_id' => 'nullable|int',
            'publish_course_id' => 'required|int',
            'institute_id' => 'required|int',
            'religion' => 'required|int',
            'freedom_fighter_status' => 'sometimes|nullable|int',
            'nationality' => 'required|string',
            'student_pic' => 'required',
            'student_signature_pic' => 'required',
            'main_occupation' => 'nullable|string',
            'other_occupation' => 'nullable|string',
            'personal_monthly_income' => 'nullable|int',
            'year_of_experience' => 'nullable|int',
            'current_employment_status' => 'nullable|int',
            'have_family_own_house' => 'nullable|int',
            'have_family_own_land' => 'nullable|int',
            'recommended_by_organization' => 'nullable|int',
            'recommended_org_name' => 'nullable|string|max:191',
            'academicQualification' => 'nullable',
            'ethnic_group' => 'nullable',
            'other_occupations' => 'nullable',
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

    public function getListDataForDatatable(\Illuminate\Http\Request $request): JsonResponse
    {
        /** @var Builder|YouthCourseEnroll $youthCourseEnrolls */
        $youthCourseEnrolls = YouthCourseEnroll::select([
            'youth_course_enrolls.id as id',
            'youth_course_enrolls.youth_id',
            'youth_course_enrolls.publish_course_id',
            'youth_course_enrolls.enroll_status',
            'youth_course_enrolls.payment_status',
            'youth_course_enrolls.created_at as enroll_date',
            'youth_course_enrolls.updated_at as enroll_updated_date',
            'courses.title_bn as course_title_bn',
            'courses.course_fee as course_fee',
        ]);
        $youthCourseEnrolls->join('youths', 'youths.id', '=', 'youth_course_enrolls.youth_id');
        $youthCourseEnrolls->join('publish_courses', 'publish_courses.id', '=', 'youth_course_enrolls.publish_course_id');
        $youthCourseEnrolls->join('courses', 'courses.id', '=', 'publish_courses.course_id');
        $youthCourseEnrolls->where(['youths.id' => $request->id]);

        return DataTables::eloquent($youthCourseEnrolls)
            ->addColumn('enroll_status', static function (YouthCourseEnroll $youthCourseEnrolls) {
                $str = '';
                return $str .= '<span href="#" style="width:80px" class="badge ' . ($youthCourseEnrolls->enroll_status == YouthCourseEnroll::ENROLL_STATUS_PROCESSING ? 'badge-warning' : ($youthCourseEnrolls->enroll_status == YouthCourseEnroll::ENROLL_STATUS_ACCEPT ? 'badge-success' : 'badge-danger')) . '"> ' . ($youthCourseEnrolls->enroll_status == YouthCourseEnroll::ENROLL_STATUS_PROCESSING ? 'Processing' : ($youthCourseEnrolls->enroll_status == YouthCourseEnroll::ENROLL_STATUS_ACCEPT ? 'Accepted' : 'Rejected')) . ' </span>';
            })
            ->addColumn('payment_status', static function (YouthCourseEnroll $youthCourseEnrolls) {
                $str = '';
                return $str .= '<span href="#" style="width:80px" class="badge ' . ($youthCourseEnrolls->payment_status ? 'badge-success' : 'badge-warning') . '"> ' . ($youthCourseEnrolls->payment_status ? 'Paid' : 'Unpaid') . ' </span>';
            })
            ->addColumn('action', static function (YouthCourseEnroll $youthCourseEnrolls) {
                $str = '';
                if ($youthCourseEnrolls->enroll_status == YouthCourseEnroll::ENROLL_STATUS_ACCEPT and !$youthCourseEnrolls->payment_status and ( date("Y-m-d H:i:s") < date('Y-m-d H:i:s', strtotime($youthCourseEnrolls->enroll_updated_date. ' + 3 days'))) ) {
                    $str .= '<a href="#" data-action="' . route('course_management::youth-course-enroll-pay-now', $youthCourseEnrolls->id) . '" class="btn btn-info btn-sm pay-now"> <i class="fas fa-dollar-sign"></i> ' . __(' Pay Now') . ' </a>';
                }
                return $str;
            })
            ->addColumn('enroll_last_date', static function (YouthCourseEnroll $youthCourseEnrolls) {
                $str = '';
                if ($youthCourseEnrolls->enroll_status == YouthCourseEnroll::ENROLL_STATUS_ACCEPT and !$youthCourseEnrolls->payment_status) {
                    $str .= '<span href="#" class="badge badge-secondary"> ' .date('d M, Y h:i:s A', strtotime($youthCourseEnrolls->enroll_updated_date. ' + 3 days')) . ' </span>';
                }
                return $str;
            })
            ->rawColumns(['enroll_status', 'payment_status', 'action','enroll_last_date'])
            ->toJson();
    }

    public function validationYouthComplainToOrganization(Request $request): Validator
    {
        $rules = [
            'institute_id' => [
                'required',
                'integer',
                'exists:institutes,id'
            ],
            'organization_id' => [
                'required',
                'integer',
                'exists:organizations,id'
            ],
            'youth_id' => [
                'exists:youths,id'
            ],
            'complain_title' => [
                'required',
                'string',
            ],
            'complain_message' => [
                'required',
                'string',
            ],
        ];
        return \Illuminate\Support\Facades\Validator::make($request->all(), $rules);

    }

    public function addYouthComplainToOrganization(array $data): YouthComplainToOrganization
    {
        $data['created_by'] = $data['youth_id'];
        return YouthComplainToOrganization::create($data);
    }

}
