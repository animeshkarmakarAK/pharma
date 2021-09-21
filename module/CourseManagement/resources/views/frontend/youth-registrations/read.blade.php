@extends('master::layouts.master')

@section('title')
    {{ __('Youth(') .$youth->name_en.')' }}
@endsection

@section('content')
    <style>
        youth-profile-pic img {
            margin-left: 14vw;
        }

        .table table {
            font-size: 18px;
        }

        .table td {
            border: 5px solid #f4f6f9;
            padding: 0 !important;
        }

        .table .youth-profile-pic img {
            float: left;
            margin-left: 6vh;
        }

        .custom-small-line-height {
            line-height: 1.2;
        }
    </style>

    <div class="container">
        <div class="row ">
            <div class="col-md-12">
                <div class="card-tools float-right">
                    <a
                       onclick="window.history.go(-1); return false;"
                       class="btn btn-sm btn-outline-primary btn-rounded">
                        <i class="fas fa-backward"></i> Back to list
                    </a>
                </div>
            </div>

            <div class="col-md-12">
                <h5 class="text-center">{{ $youthRegistrationData->publishCourse ? $youthRegistrationData->publishCourse->course->institute->title_en : ''}}</h5>
                <h6 class="text-center">{{  $youthRegistrationData->publishCourse ? $youthRegistrationData->publishCourse->course->title_en : '' }}</h6>
            </div>
            <table class="table">
                <tr>
                    <td class="border-0"></td>
                    <td><span
                            class="text-bold">Registration Number: </span>{{ $youthRegistrationData->registration_no ?? 'N/A' }}
                    </td>
                    <td colspan="3"></td>
                </tr>

                <tr>
                    <td class="border-0"></td>
                    <td class="youth-profile-pic">
                        <img
                            src="{{ $youthRegistrationData->student_pic ? asset('/storage/' .$youthRegistrationData->student_pic) : asset('storage/default_student_pic.jpg')}}"
                            height="200" width="200" alt="youth profile pic">
                    </td>
                    <td colspan="3">
                        <table class="table">
                            <tbody>
                            <tr>
                                <td class="text-bold custom-bg-gradient-info">candidate Name (En):</td>
                                <td class="custom-bg-gradient-info">{{ $youth->name_en }}</td>
                            </tr>
                            <tr>
                                <td class="text-bold custom-bg-gradient-info">candidate Name (Bn):</td>
                                <td class="custom-bg-gradient-info">{{ $youth->name_bn }}</td>
                            </tr>

                            <tr>
                                <td class="text-bold custom-bg-gradient-info">Father's Name:</td>
                                <td class="custom-bg-gradient-info">{{ optional($father)->member_name_en }}</td>
                            </tr>

                            <tr>
                                <td class="text-bold custom-bg-gradient-info">Mother's Name:</td>
                                <td class="custom-bg-gradient-info">{{ optional($mother)->member_name_en }}</td>
                            </tr>

                            <tr>
                                <td class="text-bold custom-bg-gradient-info">Date of Birth:</td>
                                <td class="custom-bg-gradient-info">{{ optional($youthSelfInfo)->date_of_birth }}
                                    [YYYY-MM-DD]
                                    {{  \Carbon\Carbon::parse($youthSelfInfo->date_of_birth)->diff(\Carbon\Carbon::now())->format('%y years, %m months and %d days')}}
                                </td>
                            </tr>

                            <tr>
                                <td class="text-bold custom-bg-gradient-info">Gender:</td>
                                <td class="custom-bg-gradient-info">{{ $youthSelfInfo->getUserGender() ?? '' }}</td>
                            </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>


                <tr class="custom-bg-gradient-info">
                    <td class="border-0"></td>
                    <td class="text-bold border-0">Mobile Number:</td>
                    <td class="border-top-0 border-bottom">{{ optional($youthSelfInfo)->mobile }}</td>

                    <td class="text-bold border-0">Marital Status:</td>
                    <td class="border-top-0 border-bottom">{{ $youthSelfInfo->currentMaritalStatus() ?? '' }}</td>
                </tr>

                <tr class="custom-bg-gradient-info">
                    <td class="border-0"></td>
                    <td class="text-bold border-0">Religion:</td>
                    <td class="border-top-0 border-bottom">{{ $youthSelfInfo->getUserReligion() ?? ''}}</td>

                    <td class="text-bold border-0">Nationality:</td>
                    <td class="border-top-0 border-bottom">{{ !empty($youthSelfInfo->nationality)? ($youthSelfInfo->nationality=='bd'?'Bangladeshi':''):'' }}</td>
                </tr>

                <tr class="custom-bg-gradient-info">
                    <td class="border-0"></td>
                    <td class="text-bold border-0">NID:</td>
                    <td class="border-top-0 border-bottom">{{ $youthSelfInfo->nid ?? 'N/A' }}</td>

                    <td class="text-bold border-0">Birth Certificate Number:</td>
                    <td class="border-top-0 border-bottom">{{ $youthSelfInfo->birth_certificate_no ?? 'N/A' }}</td>
                </tr>

                <tr class="custom-bg-gradient-info">
                    <td class="border-0"></td>
                    <td class="text-bold border-0">Passport Number:</td>
                    <td class="border-top-0 border-bottom">{{ $youthSelfInfo->passport_number ?? 'N/A' }}</td>

                    <td class="text-bold border-0">Freedom Fighter Status:</td>
                    <td class="border-top-0 border-bottom">{{ $youthSelfInfo->getYouthFreedomFighterStatus() ? $youthSelfInfo->getYouthFreedomFighterStatus(): 'Non freedom fighter'}}</td>
                </tr>

                <tr class="custom-bg-gradient-info">
                    <td class="border-0"></td>
                    <td class="text-bold border-0">Physically Disable:</td>
                    <td class="border-top-0 border-bottom">
                        {{ $youthSelfInfo->disable_status == \Module\CourseManagement\App\Models\YouthFamilyMemberInfo::PHYSICALLY_DISABLE_YES ? 'Yes' : 'No' }}
                    </td>

                    <td class="text-bold border-0">Ethnic Minority:</td>
                    <td class="border-top-0 border-bottom">{{ $youth->ethnic_group == \Module\CourseManagement\App\Models\Youth::ETHNIC_GROUP_YES ? 'Yes' : 'No' }}</td>
                </tr>

                <tr>
                    <td class="border-0"></td>
                    <td colspan="2" class="text-bold custom-bg-gradient-info"></td>
                    <td colspan="2" class="text-bold custom-bg-gradient-info"></td>
                </tr>

                <tr>
                    <td class="border-0"></td>
                    <td colspan="2" class="text-bold custom-bg-gradient-info lead">Present Address</td>
                    <td colspan="2" class="text-bold custom-bg-gradient-info lead">permanent Address</td>
                </tr>

                <tr>
                    <td class="border-0"></td>
                    <td colspan="2" class="custom-bg-gradient-info">
                        <p class="custom-small-line-height">
                            <span
                                class="font-weight-bold">Village/Road/House:</span> {{ !empty($youth->present_address_house_address) ? $youth->present_address_house_address['village_name'] .'/'. $youth->present_address_house_address['house_and_road']: 'N/A' }}
                            <br>
                            <span
                                class="font-weight-bold">Post Office:</span> {{ !empty($youth->present_address_house_address) ? $youth->present_address_house_address['postal_code'] : 'N/A' }}
                            <br>
                            <span
                                class="font-weight-bold">Upazila/Thana:</span> {{  optional($youth->presentAddressUpazila)->title_en }}
                            <br>
                            <span
                                class="font-weight-bold">District:</span> {{  optional($youth->presentAddressDistrict)->title_en }}
                            <br>
                            <span
                                class="font-weight-bold">Division:</span> {{ optional($youth->presentAddressDivision)->title_en }}
                            <br>
                        </p>
                    </td>
                    <td colspan="2" class="custom-bg-gradient-info">
                        <p class="custom-small-line-height">
                            <span
                                class="font-weight-bold">Village/Road/House:</span> {{ !empty($youth->permanent_address_house_address) ? $youth->permanent_address_house_address['village_name'] .'/'. $youth->permanent_address_house_address['house_and_road']: 'N/A' }}
                            <br>
                            <span
                                class="font-weight-bold">Post Office:</span> {{ !empty($youth->permanent_address_house_address) ? $youth->permanent_address_house_address['postal_code'] : 'N/A' }}
                            <br>
                            <span
                                class="font-weight-bold">Upazila/Thana:</span> {{ optional($youth->permanentAddressUpazila)->title_en }}
                            <br>
                            <span
                                class="font-weight-bold">District:</span> {{optional($youth->permanentAddressDistrict)->title_en }}
                            <br>
                            <span
                                class="font-weight-bold">Division:</span> {{ optional($youth->permanentAddressDivision)->title_en }}
                            <br>
                        </p>
                    </td>
                </tr>

                <tr>
                    <td class="border-0"></td>
                    <td colspan="4" class="custom-bg-gradient-info text-bold lead">Academic Qualification</td>
                </tr>
                <tr>
                    <table class="table table-bordered custom-bg-gradient-info">
                        <tr>
                            <td class="border-0"></td>
                            <th class="text-center">Examination</th>
                            <th class="text-center">Board/Institute</th>
                            <th class="text-center">Group/Subject/Degree</th>
                            <th class="text-center">Result/Grade</th>
                            <th class="text-center">Year</th>
                            <th class="text-center">Roll</th>
                            <th class="text-center">Duration</th>
                        </tr>

                        @if(count($academicQualifications) > 0)
                            @foreach($academicQualifications as $key => $academicQualification)
                                <tr>
                                    <td class="border-0"></td>
                                    <td class="text-center">
                                        @switch($academicQualification->examination)
                                            @case(\Module\CourseManagement\App\Models\YouthAcademicQualification::EXAMINATION_JSC)
                                            {{ $academicQualification->getExamination() .'/'. $academicQualification->getJSCExaminationName() }}
                                            @break
                                            @case(\Module\CourseManagement\App\Models\YouthAcademicQualification::EXAMINATION_SSC)
                                            {{ $academicQualification->getExamination() .'/'. $academicQualification->getSSCExaminationName() }}
                                            @break
                                            @case(\Module\CourseManagement\App\Models\YouthAcademicQualification::EXAMINATION_HSC)
                                            {{ $academicQualification->getExamination() .'/'. $academicQualification->getHSCExaminationName() }}
                                            @break
                                            @case(\Module\CourseManagement\App\Models\YouthAcademicQualification::EXAMINATION_GRADUATION)
                                            {{ $academicQualification->getExamination() .'/'. $academicQualification->getGraduationExaminationName() }}
                                            @break
                                            @case(\Module\CourseManagement\App\Models\YouthAcademicQualification::EXAMINATION_MASTERS)
                                            {{ $academicQualification->getExamination() .'/'. $academicQualification->getMastersExaminationName() }}
                                            @break
                                        @endswitch
                                    </td>

                                    <td class="text-center">
                                        @if($academicQualification->examination == \Module\CourseManagement\App\Models\YouthAcademicQualification::EXAMINATION_JSC || $academicQualification->examination == \Module\CourseManagement\App\Models\YouthAcademicQualification::EXAMINATION_SSC || $academicQualification->examination == \Module\CourseManagement\App\Models\YouthAcademicQualification::EXAMINATION_HSC)
                                            {{ $academicQualification->getExaminationTakingBoard() }}
                                        @else
                                            {{ $academicQualification->getCurrentUniversity() }}
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        {{ ($academicQualification->getExaminationGroup() ? $academicQualification->getExaminationGroup() : $academicQualification->subject) ?:'N/A' }}
                                    </td>

                                    <td class="text-center">
                                        {{ $academicQualification->grade == null ? $academicQualification->getExaminationResult() :$academicQualification->grade . ($academicQualification->getExaminationResult()? '/'.$academicQualification->getExaminationResult():'') }}
                                    </td>

                                    <td class="text-center">
                                        {{ $academicQualification->passing_year }}
                                    </td>

                                    <td class="text-center">
                                        {{ $academicQualification->roll_no ?? 'N/A'}}
                                    </td>

                                    <td class="text-center">
                                        {{ $academicQualification->course_duration ? $academicQualification->course_duration . ' Years' : 'N/A' }}
                                    </td>
                                </tr>
                            @endforeach
                        @endif

                        <tr>
                            <td colspan="8"></td>
                        </tr>
                        <tr>
                            <td colspan="8"></td>
                        </tr>
                        <tr>
                            <td colspan="8"></td>
                        </tr>
                        <tr>
                            <td colspan="8"></td>
                        </tr>
                        <tr>
                            <td class="border-0"></td>
                            <td colspan="7" class="custom-bg-gradient-info text-bold lead">Additional Information</td>
                        </tr>
                        <tr>
                            <td class="border-0"></td>
                            <td class="text-bold">Guradian:</td>
                            <td>{{!empty($guardian) ? $guardian->member_name_en : 'N/A' }}</td>
                        </tr>

                        <tr>
                            <td class="border-0"></td>
                            <td class="text-bold">Relation with Youth:</td>
                            <td>{{ !empty($guardian) ? $guardian->relation_with_youth : "N/A" }}</td>
                        </tr>

                        <tr>
                            <td class="border-0"></td>
                            <td class="text-bold">Guradian Mobile Number:</td>
                            <td>{{ !empty($guardian) ? $guardian->mobile : 'N/A'}}</td>
                        </tr>
                        <tr>
                            <td class="border-0"></td>
                            <td class="text-bold">Guradian NID:</td>
                            <td>{{ !empty($guardian) ? $guardian->nid : 'N/A'}}</td>
                        </tr>
                        <tr>
                            <td colspan="8"></td>
                        </tr>
                        <tr>
                            <td colspan="8"></td>
                        </tr>
                        <tr>
                            <td colspan="8"></td>
                        </tr>
                        <tr>
                            <td colspan="8"></td>
                        </tr>
                        <tr>
                            <td class="border-0"></td>
                            <td colspan="7" class="custom-bg-gradient-info text-bold lead">Work Information</td>
                        </tr>

                        <tr>
                            <td class="border-0"></td>
                            <td class="text-bold">Main occupation:</td>
                            <td colspan="6">{{ $youthSelfInfo->main_occupation ?? 'Not specified' }}</td>
                        </tr>

                        <tr>
                            <td class="border-0"></td>
                            <td class="text-bold">Other occupation:</td>
                            <td colspan="6">{{ $youthSelfInfo->other_occupations ?? 'Not specified' }}</td>
                        </tr>

                        <tr>
                            <td class="border-0"></td>
                            <td class="text-bold">Personal Monthly Income:</td>
                            <td colspan="6">{{ $youthSelfInfo->personal_monthly_income ?? 'Not specified' }}</td>
                        </tr>

                        <tr>
                            <td class="border-0"></td>
                            <td class="text-bold">Currently Employed:</td>
                            <td colspan="6">{{ $youthRegistrationData->getYouthCurrentEmploymentStatus() ?? 'N/A' }}</td>
                        </tr>

                    </table>
                </tr>
                <tr>
                    <td class="border-0"></td>
                    <td class="text-bold">Youth signature</td>
                </tr>
                <tr>
                    <td class="border-0"></td>
                    <td>
                        <img
                            src="{{ asset('storage/'. $youthRegistrationData->student_signature_pic)}}"
                            height="50" width="200" alt="youth signature"></td>
                </tr>
            </table>
        </div>
    </div>

@endsection
