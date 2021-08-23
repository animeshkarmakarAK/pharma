<?php


namespace Module\CourseManagement\App\Services;

use App\Helpers\Classes\FileHandler;
use Module\CourseManagement\App\Models\PublishCourse;
use Module\CourseManagement\App\Models\Youth;
use Module\CourseManagement\App\Models\YouthFamilyMemberInfo;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Validation\ValidationException;

class YouthRegistrationService
{
    private function guardian($p1, $p2) {
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
        $youth = Arr::only($data, ['name_en', 'name_bn', 'mobile','email', 'ethnic_group']);
        $youth = array_merge($youth, $presentAddress);
        $youth = array_merge($youth, $permanentAddress);

        $youth['access_key'] = Youth::getUniqueAccessKey();
        if(!$youth = Youth::create($youth)){
            throw ValidationException::withMessages(['publish_course_id' => 'Youth creation failed!']);
        }

        $youth_registration_info = Arr::only($data, ['institute_id', 'branch_id', 'programme_id', 'training_center_id',
            'course_id', 'recommended_by_organization', 'recommended_org_name', 'current_employment_status',
            'year_of_experience', 'personal_monthly_income', 'have_family_own_house', 'have_family_own_land',
            'number_of_siblings', 'student_signature_pic', 'student_pic']);

        $publishCourse = PublishCourse::where('id', $data['course_id'])->first();
        if (!$publishCourse) {
            throw ValidationException::withMessages(['publish_course_id' => 'course config not found.']);
        }

        $youth_registration_info['publish_course_id'] = $publishCourse->id;


        if (isset($data['student_signature_pic'])) {
            $filename = FileHandler::storePhoto($youth_registration_info['student_signature_pic'], 'student');
            $youth_registration_info['student_signature_pic'] = 'student/' . $filename;
        }
        if (isset($data['student_pic'])) {
            $filename = FileHandler::storePhoto($youth_registration_info['student_pic'], 'student', 'signature_' . $youth->access_key);
            $youth_registration_info['student_pic'] = 'student/' . $filename;
        }

        $youth->youthRegistration()->create($youth_registration_info);

        $skipGuardian = false;


        if(empty($data['guardian'])){
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


        $youth_self_info = Arr::only($data, ['mobile', 'personal_monthly_income',
            'gender', 'marital_status', 'main_occupation', 'other_occupations', 'physical_disabilities', 'disable_status',
            'freedom_fighter_status', 'nid', 'birth_certificate_no', 'passport_number', 'religion', 'nationality', 'date_of_birth']);
        $youth_self_info['relation_with_youth'] = "self";


        $disabilities = null;
        if (isset($youth_self_info['disable_status']) && $youth_self_info['disable_status'] == YouthFamilyMemberInfo::PHYSICALLY_DISABLE_YES) {
            $disabilities = $youth_self_info['physical_disabilities'];
            $youth_self_info['physical_disabilities'] = collect($disabilities)->toJson();
        }

        $youth->youthFamilyMemberInfo()->create($youth_self_info);

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
            'gender' => 'required|int',
            'marital_status' => 'required|int',
            'branch_id' => 'nullable|int',
            'training_center_id' => 'nullable|int',
            'programme_id' => 'nullable|int',
            'course_id' => 'required|int',
            'institute_id' => 'required|int',
            'religion' => 'required|int',
            'freedom_fighter_status' => 'sometimes|nullable|int',
            'nationality' => 'required|string',
            'student_pic' => 'required',
            'student_signature_pic' => 'required',
            'guardian' => 'nullable|int',
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
        ];

        return \Illuminate\Support\Facades\Validator::make($request->all(), $rules);
    }


    public function getYouthAcademicQualification(Youth $youth): Collection
    {
        return $youth->youthAcademicQualifications;
    }

    public function getYouthFamilyMemberInfo(Youth $youth): array
    {
        $father = $youth->youthFamilyMemberInfo->where('relation_with_youth', 'Father')->first();
        $mother = $youth->youthFamilyMemberInfo->where('relation_with_youth', 'Mother')->first();
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

}
