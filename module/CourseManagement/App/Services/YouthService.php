<?php

namespace Module\CourseManagement\App\Services;


use App\Helpers\Classes\AuthHelper;
use App\Helpers\Classes\DatatableHelper;
use App\Models\BaseModel as BaseModelAlias;
use App\Models\LocDistrict;
use App\Models\LocDivision;
use App\Models\LocUpazila;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rule;
use Module\CourseManagement\App\Models\BaseModel;
use Module\CourseManagement\App\Models\Batch;
use Module\CourseManagement\App\Models\Youth;
use Module\CourseManagement\App\Models\YouthAcademicQualification;
use Module\CourseManagement\App\Models\YouthBatch;
use Module\CourseManagement\App\Models\YouthCourseEnroll;
use Module\CourseManagement\App\Models\YouthFamilyMemberInfo;
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
            'youth_ids' => ['required', 'array', 'min:1'],
            'youth_ids.*' => [
                "required"
            ]
        ];
        return \Illuminate\Support\Facades\Validator::make($request->all(), $rules);
    }


    public function validateAcceptNowAll(Request $request): Validator
    {
        $rules = [
            'youth_ids' => ['bail', 'required', 'array', 'min:1'],
        ];
        return \Illuminate\Support\Facades\Validator::make($request->all(), $rules);
    }

    public function validateRejectNowAll(Request $request): Validator
    {
        $rules = [
            'youth_ids' => ['bail', 'required', 'array', 'min:1'],
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
        //$youths->groupBy('institute_title_en');

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
                $str .= '<a href="' . route('course_management::admin.youths.certificate.course', $youth->id) . '" class="btn btn-outline-warning btn-sm"> <i class="fas fa-user-graduate"></i> ' . __('View Certificate') . ' </a>';
                return $str;
            }))
            ->addColumn('already_added_to_organization', static function (Youth $youth) {
                $youthOrganization = YouthOrganization::where(['youth_id' => $youth->id])->where(['current_employment_status' => 1])->first();
                $str = '';
                $str .= '<span class="badge ' . (!empty($youthOrganization) ? "badge-success" : "badge-warning") . '"> <i class="fas ' . (!empty($youthOrganization) ? 'fa-paperclip' : 'fa-unlink') . '"></i> ' . (!empty($youthOrganization) ? $youthOrganization->organization->title_en : 'Not assigned') . ' </a>';
                return $str;
            })
            ->addColumn('already_added_check', static function (Youth $youth) {
                $youthOrganization = YouthOrganization::where(['youth_id' => $youth->id])->first();
                return !empty($youthOrganization) ? 0 : 0;
            })
            ->rawColumns(['action', 'already_added_to_organization', 'already_added_check'])
            ->toJson();
    }

    public function addYouthToOrganization(Organization $organization, array $youthIds): bool
    {
        $currentDate = Carbon::now()->toDateTimeString();

        foreach ($youthIds as $youthId) {
            $youthOrgCheck = YouthOrganization::where('youth_id', $youthId)->get();
            if ($youthOrgCheck) {
                $youthOrg = YouthOrganization::where('youth_id', $youthId)->update(['current_employment_status' => 0]);
            }
            /** @var Youth $youth */
            $youth = Youth::findOrFail($youthId);
            YouthOrganization::updateOrCreate(
                [
                    'organization_id' => $organization->id,
                    'youth_id' => $youth->id,
                    'current_employment_status' => 1,
                    'started_at' => $currentDate
                ]
            );
            $youtEndDate = YouthOrganization::where('youth_id', $youthId)
                ->where('current_employment_status', 0)
                ->orderByDesc('created_at')->take(1)->update(['ended_at' => $currentDate]);

            $youth->save();
        }
        return true;
    }

    public function addToTraineeAcceptedList(array $youthAcceptListNowIds): bool
    {
        foreach ($youthAcceptListNowIds as $youthAcceptListNowId) {

            /** @var YouthRegistration $youthCourseEnroll */
            $youthCourseEnroll = YouthCourseEnroll::where('youth_id', $youthAcceptListNowId)->first();

            $youth = Youth::findOrFail($youthAcceptListNowId);

            $data = [
                'enroll_status' => YouthCourseEnroll::ENROLL_STATUS_ACCEPT,
            ];

            if ($youthCourseEnroll->update($data)) {
                if (!empty($youth->mobile)) {
                    try {
                        $link = route('course_management::youth-enrolled-courses');
                        $youthName = strtoupper($youth->name_en);
                        $messageBody = "Dear $youthName, Your course enrolment is accepted. Please payment within 72 hours. visit " . $link . " for payment";
                        $smsResponse = sms()->send($youth->mobile, $messageBody);
                        if (!$smsResponse->is_successful()) {
                            sms()->send($youth->mobile, $messageBody);
                        }
                    } catch (\Throwable $exception) {
                        Log::debug($exception->getMessage());
                    }
                };

                if (!empty($youth->email)) {
                    $link = route('course_management::youth-enrolled-courses');
                    $youthEmailAddress = $youth->email;
                    $mailMsg = "Congratulations! Your application has been accepted, Please pay now within 72 hours.<p>Payment Link: $link </p>";
                    $mailSubject = "Congratulations! Your application has been accepted";
                    $youthName = $youth->name_en;
                    try {
                        Mail::to($youthEmailAddress)->send(new \Module\CourseManagement\App\Mail\YouthApplicationAcceptMail($mailSubject, $youth->access_key, $mailMsg, $youthName));
                    } catch (\Throwable $exception) {
                        Log::debug($exception->getMessage());
                    }
                };
            }


        }
        return true;
    }

    public function rejectTraineeAll(array $youthAcceptListNowId): bool
    {
        foreach ($youthAcceptListNowId as $youthAcceptListNowIds) {

            /** @var YouthRegistration $youthCourseEnroll */
            $youthCourseEnroll = YouthCourseEnroll::where('youth_id', $youthAcceptListNowIds)->first();
            $youthCourseEnroll->update([
                'enroll_status' => YouthCourseEnroll::ENROLL_STATUS_REJECT,
            ]);
            $youthCourseEnroll->save();
        }
        return true;
    }

    public static function isDate($value): bool
    {
        if (!$value) {
            return false;
        }

        try {
            new \DateTime($value);
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function youthImportDataValidate(array $data, $row_number): Validator
    {
        $row_number = $row_number + 1;
        $messages = [
            'required' => "The :attribute in row " . $row_number . " is required",
            'string' => 'The :attribute in row ' . $row_number . ' must be text format',
            'numeric' => 'The :attribute in row ' . $row_number . ' must be numeric format',
            'unique' => "The :attribute in row " . $row_number . " is already taken(youth)",
            "in" => "The :attribute in row " . $row_number . " is either HAVE OR HAVE NO ",
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
                "array"
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
                "array"
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
                //Rule::in([Youth::HAVE_NO_FAMILY_OWN_HOUSE, Youth::HAVE_FAMILY_OWN_HOUSE]),
                Rule::in([0,1,2,3]),
            ],
            "have_family_own_land" => [
                "nullable",
                //Rule::in([Youth::HAVE_FAMILY_OWN_LAND, Youth::HAVE_NO_FAMILY_OWN_LAND]),
                Rule::in([0,1,2,3]),
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
            ]
        ];
        return \Illuminate\Support\Facades\Validator::make($data, $rules, $messages);

    }

    public function youthAcademicInfoImportDataValidate(array $data, $row_number): Validator
    {
        $row_number = $row_number + 1;
        $messages = [
            'required' => "The :attribute in row " . $row_number . " is required",
            'string' => 'The :attribute in row ' . $row_number . ' must be text format',
            'numeric' => 'The :attribute in row ' . $row_number . ' must be numeric format',
            'unique' => "The :attribute of in row " . $row_number . " is already taken",
            "in" => "The :attribute in row " . $row_number . " is not within :fields",
            "mobile.regex" => "The :attribute in row " . $row_number . " is not valid format as like 1XXXXXXXXXXX",
            "member_mobile.regex" => "The :attribute in row " . $row_number . " is not valid format as like 01XXXXXXXXXXX",
            "lte" => "The :attribute in row " . $row_number . " must be less than or equal :value.",
            "gte" => "The :attribute in row " . $row_number . " must be greater than or equal :value."
        ];

        $rules = [
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
                "integer"
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
                    return !empty($data['result']) && in_array($data['result'], [Youth::EXAMINATION_RESULT_GPA_OUT_OF_FIVE, Youth::EXAMINATION_RESULT_GPA_OUT_OF_FIVE]);
                }),
                "nullable",
                "numeric",
                "lte:5",
                "gt:0"
            ],
            "group" => [
                Rule::requiredIf(function () use ($data) {
                    return in_array($data['examination'], [Youth::EXAMINATION_SSC, Youth::EXAMINATION_HSC]);
                }),
                "nullable",
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

    public function youthFamilyInfoImportDataValidate(array $data, $row_number): Validator
    {
        $row_number = $row_number + 1;
        $messages = [
            'required' => "The :attribute in row " . $row_number . " is required",
            'string' => 'The :attribute in row ' . $row_number . ' must be text format',
            'numeric' => 'The :attribute in row ' . $row_number . ' must be numeric format',
            'unique' => "The :attribute in row " . $row_number . " is already taken",
            "in" => "The :attribute in row " . $row_number . " is not within :fields",
            "mobile.regex" => "The :attribute in row " . $row_number . " is not valid format as like 1XXXXXXXXXXX",
            "member_mobile.regex" => "The :attribute in row " . $row_number . " is not valid format as like 1XXXXXXXXXXX"
        ];
        $rules = [
            "member_name_en" => [
                "nullable",
                "string"
            ],
            "member_name_bn" => [
                "nullable",
                "string"
            ],
            "mobile" => [
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
                function ($attr, $value, $fails) use ($data, $row_number) {
                    if ($value == YouthFamilyMemberInfo::GUARDIAN_OTHER && !$data['is_guardian_data_exist']) {
                        $fails("Guardian information is required for row " . $row_number);
                    }
                }
            ],
            "personal_monthly_income" => [
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
                //"string"
                Rule::in([0,1,2,3]),
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
        ];
        return \Illuminate\Support\Facades\Validator::make($data, $rules, $messages);

    }

    public function getListForAcceptListDatatable($request): JsonResponse
    {
        $youth = Youth::select([
            'youths.id as id',
            'youths.name_en',
            'youths.name_bn',
            'youths.mobile',
            DB::raw('DATE_FORMAT(youths.created_at,"%d %b, %Y %h:%i %p") AS application_date'),
            'youths.updated_at',
            'youths.youth_registration_no as youth_registration_id',
            'youths.youth_registration_no',
            'publish_courses.id as publish_courses.id',
            'institutes.title_en as institutes.title_en',
            'branches.title_en as branches.title_en',
            'training_centers.title_en as training_centers.title_en',
            'programmes.title_en as programmes.title_en',
            'courses.title_en as courses.title_en',
            'youth_course_enrolls.id as youth_course_enroll_id',
            'youth_course_enrolls.enroll_status',
            'youth_course_enrolls.payment_status',
            'youth_batches.id as youth_batch_id',
            'youth_batches.youth_course_enroll_id as youth_batch_youth_course_enroll_id',
        ]);
        $youth->join('youth_course_enrolls', 'youths.id', '=', 'youth_course_enrolls.youth_id');
        $youth->join('publish_courses', 'publish_courses.id', '=', 'youth_course_enrolls.publish_course_id');
        $youth->join('institutes', 'institutes.id', '=', 'publish_courses.institute_id');
        $youth->leftJoin('branches', 'branches.id', '=', 'publish_courses.branch_id');
        $youth->leftJoin('training_centers', 'training_centers.id', '=', 'publish_courses.training_center_id');
        $youth->leftJoin('programmes', 'programmes.id', '=', 'publish_courses.programme_id');
        $youth->leftJoin('courses', 'courses.id', '=', 'publish_courses.course_id');
        $youth->leftJoin('youth_batches', 'youth_batches.youth_course_enroll_id', '=', 'youth_course_enrolls.id');
        $youth->where('youth_batches.youth_course_enroll_id', null);
        $youth->where('youth_course_enrolls.enroll_status', '=', YouthCourseEnroll::ENROLL_STATUS_ACCEPT);


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
                $str .= '<a href="' . route('course_management::youth-registrations.show', $youth->id) . '" class="btn btn-outline-info btn-sm"> <i class="fas fa-eye"></i> ' . __('generic.read_button_label') . ' </a>';
                if ($youth->payment_status == YouthCourseEnroll::PAYMENT_STATUS_PAID) {
                    $str .= '<a href="#" data-action="' . route('course_management::admin.youth.add-single-youth-to-batch', $youth->id) . '"' . ' class="btn btn-outline-success btn-sm accept-to-batch"><i class="fas fa-plus-circle"></i> ' . __('Add to Batch') . ' </a>';
                }


                return $str;
            }))
            ->editColumn('registration_date', function (Youth $youth) {
                return date('d M Y', strtotime($youth->registration_date));
            })
            ->addColumn('payment_status', DatatableHelper::getActionButtonBlock(static function (Youth $youth) {
                $str = '';
                $str .= '<span style="width:70px" ' . '" class="badge badge-' . ($youth->payment_status ? "success payment-paid" : "danger payment-unpaid") . '">' . ($youth->payment_status ? "Paid" : "Unpaid") . ' </span>';
                return $str;
            }))
            ->addColumn('paid_or_unpaid', static function (Youth $youth) {
                return $youth->payment_status;
            })
            ->addColumn('enroll_status_check', static function (Youth $youth) {
                return $youth->enroll_status;
            })
            ->rawColumns(['action', 'enroll_status', 'payment_status', 'paid_or_unpaid', 'enroll_status_check'])
            ->toJson();
    }

}
