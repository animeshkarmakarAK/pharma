<?php


namespace App\Services;


use App\Helpers\Classes\FileHandler;
use App\Models\TrainerPersonalInformation;
use App\Models\User;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Validation\Rule;

class TrainerService
{
    public function storeTrainerInfo(array $data)
    {
        $trainer = User::findOrFail($data['trainer_id']);
        $trainerPersonalInfo = Arr::only($data, ['trainer_id', 'institute_id', 'name', 'mobile', 'date_of_birth', 'gender', 'nid_no', 'passport_no', 'birth_registration_no', 'marital_status', 'email', 'present_address', 'permanent_address', 'profile_pic', 'signature_pic']);

        $trainerPersonalInfo['mobile'] = 'xxxxxxxx-xxxxx';


        if (isset($data['signature_pic'])) {
            $filename = FileHandler::storePhoto($data['signature_pic'], 'trainer_signature');
            $trainerPersonalInfo['signature_pic'] = 'trainer/' . $filename;
        }

        if (isset($data['profile_pic'])) {
            $filename = FileHandler::storePhoto($data['profile_pic'], 'trainer',);
            $trainerPersonalInfo['profile_pic'] = 'trainer/' . $filename;
        }

        TrainerPersonalInformation::create($trainerPersonalInfo);

        foreach ($data['academicQualification'] as $key => $academicQualification) {
            if ($academicQualification['examination_name'] == null) continue;

            $trainer->youthAcademicQualifications()->create($academicQualification);
        }


        foreach ($data['trainer_experiences'] as $key => $trainerExperience) {
            if ($trainerExperience['organization_name'] == null) continue;

            $trainer->trainerExperiences()->create($trainerExperience);
        }

        return $trainer;
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
            'familyMember.father.nid' => 'nullable|string|max:191',
            'familyMember.father.date_of_birth' => 'required|date',
            'familyMember.father.mobile' => 'nullable|string',
            'familyMember.mother.member_name_en' => 'required|string|max:191',
            'familyMember.mother.nid' => 'nullable|string|max:191',
            'familyMember.mother.date_of_birth' => 'required|date',
            'familyMember.mother.mobile' => 'nullable|string',

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
            'training_center_id' => 'required|int',
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
}
