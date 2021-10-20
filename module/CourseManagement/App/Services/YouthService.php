<?php

namespace Module\CourseManagement\App\Services;


use App\Helpers\Classes\AuthHelper;
use App\Helpers\Classes\DatatableHelper;
use App\Models\BaseModel as BaseModelAlias;
use App\Models\LocDistrict;
use App\Models\LocDivision;
use App\Models\LocUpazila;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Module\CourseManagement\App\Models\BaseModel;
use Module\CourseManagement\App\Models\Batch;
use Module\CourseManagement\App\Models\Youth;
use Module\CourseManagement\App\Models\YouthBatch;
use Module\CourseManagement\App\Models\YouthCourseEnroll;
use Module\CourseManagement\App\Models\YouthOrganization;
use Module\CourseManagement\App\Models\YouthRegistration;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

use Illuminate\Support\Carbon;
use Module\GovtStakeholder\App\Models\Organization;
use Yajra\DataTables\Facades\DataTables;

class YouthService
{
    public function validateAddYouthToOrganization(Request $request): Validator
    {
        $rules = [
            'organization_id' => ['bail', 'required'],
            'youth_ids' => ['bail', 'required', 'array', 'min:1'],
            'youth_ids.*' => [
                "required",
                Rule::notIn(DB::table('youth_organizations')->pluck('youth_id')->toArray())
            ]
        ];
        return \Illuminate\Support\Facades\Validator::make($request->all(), $rules);
    }

    public function getListDataForDatatable($request): JsonResponse
    {
        $instituteId = AuthHelper::getAuthUser()->institute_id;
        $youths = Youth::select([
            DB::raw('max(youths.id) AS id'),
            DB::raw('max(youths.youth_registration_no) AS youth_registration_no'),
            DB::raw('max(youths.name_en) AS name_en'),
            DB::raw('max(youths.name_bn) AS name_bn'),
            DB::raw('max(institutes.title_en) AS institute_title_en'),
            DB::raw('max(institutes.id) AS institute_id'),
            DB::raw('max(youth_organizations.organization_id) AS youth_organization_id'),
            DB::raw('max(organizations.title_en) AS organization_title_en'),
        ]);
        $youths->leftJoin('youth_course_enrolls', 'youths.id', '=', 'youth_course_enrolls.youth_id');
        $youths->leftJoin('publish_courses', 'publish_courses.id', '=', 'youth_course_enrolls.publish_course_id');
        $youths->leftJoin('institutes', 'institutes.id', '=', 'publish_courses.institute_id');

        $youths->leftJoin('youth_organizations', 'youth_organizations.youth_id', '=', 'youths.id');
        $youths->leftJoin('organizations', 'organizations.id', '=', 'youth_organizations.organization_id');
        $youths->groupBy('youth_registration_no');

        if ($instituteId) {
            $youths->where(['institutes.id' => $instituteId]);
        }

        $youthNameEn = $request->youth_name_en;
        $youthNameBn = $request->youth_name_bn;
        $youthRegNo = $request->reg_no;
        $organizationId = $request->input('organization_id');

        if ($organizationId) {
            $youths->where(['youth_organizations.organization_id' => $organizationId]);
        }
        if ($youthNameEn) {
            $youths->where('youths.name_en', 'LIKE', '%' . $youthNameEn . '%');
        }
        if ($youthNameBn) {
            $youths->where('youths.name_bn', 'LIKE', '%' . $youthNameBn . '%');
        }
        if ($youthRegNo) {
            $youths->where('youths.youth_registration_no', $youthRegNo);
        }


        return DataTables::eloquent($youths)
            ->addColumn('action', DatatableHelper::getActionButtonBlock(static function (Youth $youth) {
                $str = '';
                $str .= '<a href="' . route('course_management::youth-registrations.show', $youth->id) . '" class="btn btn-outline-info btn-sm"> <i class="fas fa-eye"></i> ' . __('generic.read_button_label') . ' </a>';
                /*$str .= '<a href="' . route('course_management::youth-registrations.show', $youth->id) . '" class="btn btn-outline-info btn-sm"> <i class="fas fa-eye"></i> ' . __('Remove From Organization') . ' </a>';*/
                return $str;
            }))
            ->addColumn('already_added_to_organization', static function (Youth $youth) {
                $youthOrganization = YouthOrganization::where(['youth_id' => $youth->id])->first();
                $str = '';
                $str .= '<span class="badge ' . (!empty($youthOrganization) ? "badge-success" : "badge-warning") . '"> <i class="fas ' . (!empty($youthOrganization) ? 'fa-paperclip' : 'fa-unlink') . '"></i> ' . (!empty($youthOrganization) ? $youthOrganization->organization->title_en : 'Not assigned') . ' </a>';
                return $str;
            })
            ->addColumn('already_added_check', static function (Youth $youth) {
                $youthOrganization = YouthOrganization::where(['youth_id' => $youth->id])->first();
                return !empty($youthOrganization) ? 1 : 0;
            })
            ->rawColumns(['action', 'already_added_to_organization', 'already_added_check'])
            ->toJson();
    }

    public function addYouthToOrganization(Organization $organization, array $youthIds): bool
    {
        foreach ($youthIds as $youthId) {
            /** @var Youth $youth */
            $youth = Youth::findOrFail($youthId);
            YouthOrganization::updateOrCreate(
                [
                    'organization_id' => $organization->id,
                    'youth_id' => $youth->id,
                ]
            );
            $youth->save();
        }
        return true;
    }

    public function youthImportDataValidate(array $data, $row_number): Validator
    {
        $row_number = $row_number + 1;
        $messages = [
            'required' => "The :attribute in row " . $row_number . " is required",
            'string' => 'The :attribute in row ' . $row_number . ' must be text format',
            'numeric' => 'The :attribute in row ' . $row_number . ' must be numeric format',
            'unique' => "The :attribute in row " . $row_number . " is already taken",
            "in" => "The :attribute in row " . $row_number . " is not within :fields",
            "mobile.regex" => "The :attribute in row " . $row_number . " is not valid format as like 01XXXXXXXXXXX",
            "member_mobile.regex" => "The :attribute in row " . $row_number . " is not valid format as like 01XXXXXXXXXXX"
        ];

        $rules = [
            "access_key" => [
                "required",
                "unique:youths,access_key"
            ],
            "name_en" => [
                "nullable",
                "string"
            ],
            "name_bn" => [
                "nullable",
                "string"
            ],
            "mobile" => [
                "required",
                BaseModel::MOBILE_REGEX
            ],
            "email" => [
                "required",
                "unique:youths,email"
            ],
            "present_address_division_id" => [
                "required",
                function ($attr, $value, $fails) use ($row_number) {
                    $locDivision = LocDivision::where('id', $value)->first();
                    if ($locDivision) {
                        return true;
                    } else {
                        $locDivision = LocDivision::all()->pluck('title_en')->toArray();
                        $fails("The present address division name in row " . $row_number . " will be " . implode(', ', $locDivision));
                    }
                },
                "numeric"
            ],
            "present_address_district_id" => [
                "required",
                function ($attr, $value, $fails) use ($row_number, $data) {
                    $locDistrict = LocDistrict::where('id', $value)->first();
                    if ($locDistrict) {
                        return true;
                    } else {
                        $locDistrict = LocDistrict::where('loc_division_id', $data['present_address_division_id'])->pluck('title_en')->toArray();
                        $fails("The present address district name in row " . $row_number . " will be " . implode(', ', $locDistrict ?? []));
                    }
                },
                "numeric"
            ],
            "present_address_upazila_id" => [
                "required",
                function ($attr, $value, $fails) use ($row_number, $data) {
                    $locUpazila = LocUpazila::where('id', $value)->first();
                    if ($locUpazila) {
                        return true;
                    } else {
                        $locUpazila = LocUpazila::where('loc_district_id', $data['present_address_district_id'])->pluck('title_en')->toArray();
                        $fails("The present address upazila name in row " . $row_number . " will be " . implode(', ', $locUpazila ?? []));
                    }
                },
                "numeric"
            ],
            "present_address_house_address" => [
                "required",
                "string"
            ],
            "permanent_address_division_id" => [
                "required",
                function ($attr, $value, $fails) use ($row_number) {
                    $locDivision = LocDivision::where('id', $value)->first();
                    if ($locDivision) {
                        return true;
                    } else {
                        $locDivision = LocDivision::all()->pluck('title_en')->toArray();
                        $fails("The permanent address division name in row " . $row_number . " will be " . implode(', ', $locDivision));
                    }
                },
                "numeric"
            ],
            "permanent_address_district_id" => [
                "required",
                function ($attr, $value, $fails) use ($row_number, $data) {
                    $locDistrict = LocDistrict::where('id', $value)->first();
                    if ($locDistrict) {
                        return true;
                    } else {
                        $locDistrict = LocDistrict::where('loc_division_id', $data['permanent_address_division_id'])->pluck('title_en')->toArray();
                        $fails("The permanent address district name in row " . $row_number . " will be " . implode(', ', $locDistrict ?? []));
                    }
                },
                "numeric"
            ],
            "permanent_address_upazila_id" => [
                "required",
                function ($attr, $value, $fails) use ($row_number, $data) {
                    $locUpazila = LocUpazila::where('id', $value)->first();
                    if ($locUpazila) {
                        return true;
                    } else {
                        $locUpazila = LocUpazila::where('loc_district_id', $data['permanent_address_district_id'])->pluck('title_en')->toArray();
                        $fails("The permanent address upazila name in row " . $row_number . " will be " . implode(', ', $locUpazila ?? []));
                    }
                },
                "numeric"
            ],
            "permanent_address_house_address" => [
                "required",
                "string"
            ],
            "ethnic_group" => [
                "nullable",
                Rule::in(Youth::ETHNIC_GROUP_YES, Youth::ETHNIC_GROUP_NO)
            ],
            "youth_registration_no" => [
                "nullable"
            ],
            "recommended_by_organization" => [
                "nullable",
                "numeric",
            ],
            "recommended_org_name" => [
                "nullable",
                "string"
            ],
            "current_employment_status" => [
                "nullable",
                Rule::in([Youth::CURRENT_EMPLOYMENT_STATUS_YES, Youth::CURRENT_EMPLOYMENT_STATUS_NO])
            ],
            "year_of_experience" => [
                "nullable",
                "numeric"
            ],
            "personal_monthly_income" => [
                "nullable",
                "numeric"
            ],
            "have_family_own_house" => [
                "nullable",
                Rule::in([Youth::HAVE_NO_FAMILY_OWN_HOUSE, Youth::HAVE_FAMILY_OWN_HOUSE])
            ],
            "have_family_own_land" => [
                "nullable",
                Rule::in([Youth::HAVE_FAMILY_OWN_LAND, Youth::HAVE_NO_FAMILY_OWN_LAND])
            ],
            "number_of_siblings" => [
                "nullable",
                "numeric"
            ],
            "student_signature_pic" => [
                "nullable",
                "string"
            ],
            "student_pic" => [
                "nullable",
                "string"
            ],

            /** Family Information Validation Rule */
            "member_name_en" => [
                "nullable",
                "string"
            ],
            "member_name_bn" => [
                "nullable",
                "string"
            ],
            "member_mobile" => [
                "required",
                BaseModel::MOBILE_REGEX
            ],
            "educational_qualification" => [
                "nullable"
            ],
            "relation_with_youth" => [
                "required",
                "string"
            ],
            "is_guardian" => [
                "nullable",
                "numeric",
                Rule::in([Youth::IS_GUARDIAN_NO, Youth::IS_GUARDIAN_YES])
            ],
            "member_personal_monthly_income" => [
                "nullable",
                "numeric"
            ],
            "gender" => [
                "nullable",
                "numeric",
                Rule::in([Youth::GENDER_MALE, Youth::GENDER_FEMALE, Youth::GENDER_OTHERS])
            ],
            "marital_status" => [
                "nullable",
                "numeric",
                Rule::in([Youth::IS_Marit_YES, Youth::IS_Marit_NO])
            ],
            "main_occupation" => [
                "nullable",
                "string"
            ],
            "other_occupations" => [
                "nullable",
                "string"
            ],
            "physical_disabilities" => [
                "nullable",
                "string"
            ],
            "disable_status" => [
                "nullable",
                "numeric",
                Rule::in([
                    Youth::IS_DISABLE_YES,
                    Youth::IS_DISABLE_NO
                ])
            ],
            "freedom_fighter_status" => [
                "nullable",
                "numeric",
                Rule::in([Youth::IS_FREEDOM_NO, Youth::IS_FREEDOM_YES])
            ],
            "nid" => [
                "nullable"
            ],
            "birth_certificate_no" => [
                "nullable"
            ],
            "passport_number" => [
                "nullable"
            ],
            "religion" => [
                "nullable",
                "numeric"
            ],
            "nationality" => [
                "nullable",
                "string"
            ],
            "date_of_birth" => [
                "nullable",
                'date_format:Y-m-d'
            ],

            /** Youth Academic Qualifications */
            "examination" => [
                "required",
                "numeric"
            ],
            "examination_name" => [
                "required",
                "string"
            ],
            "board" => [
                "nullable",
                "numeric"
            ],
            "institute" => [
                "nullable",
                "string"
            ],
            "roll_no" => [
                "nullable"
            ],
            "reg_no" => [
                "nullable"
            ],
            "result" => [
                "required",
                "numeric"
            ],
            "grade" => [
                Rule::requiredIf(function () use ($data) {
                    return in_array($data['result'], [Youth::EXAMINATION_RESULT_GPA_OUT_OF_FIVE, Youth::EXAMINATION_RESULT_GPA_OUT_OF_FIVE]);
                }),
                "numeric"
            ],
            "group" => [
                Rule::requiredIf(function () use ($data) {
                    return in_array($data['examination'], [Youth::EXAMINATION_SSC, Youth::EXAMINATION_HSC]);
                }),
                "numeric"
            ],
            "passing_year" => [
                "nullable"
            ],
            "subject" => [
                "nullable"
            ],
            "course_duration" => [
                "nullable",
                "numeric"
            ]
        ];
        return \Illuminate\Support\Facades\Validator::make($data, $rules, $messages);

    }

}
