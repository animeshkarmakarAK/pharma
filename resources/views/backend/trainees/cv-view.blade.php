@extends('master::layouts.master')

@section('title')
    {{ __($traineeSelfInfo->name) }}
@endsection
@php
//dd($familyMembers);
@endphp
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
                    <a href="{{ route('admin.trainees.index') }}"
                        class="btn btn-sm btn-outline-primary btn-rounded">
                        <i class="fas fa-backward"></i> Back to list
                    </a>
                </div>
            </div>

           {{-- <div class="col-md-12">
                <h5 class="text-center">{{ $youth->publishCourse ? $youth->publishCourse->course->institute->title_en : ''}}</h5>
                <h6 class="text-center">{{  $youth->publishCourse ? $youth->publishCourse->course->title_en : '' }}</h6>
            </div>--}}
            <table class="table">
                <tr>
                    <td class="border-0"></td>
                    <td class="youth-profile-pic">
                        <img
                            src="{{ $traineeSelfInfo->profile_pic ? asset('/storage/' .$traineeSelfInfo->profile_pic) : asset('storage/default_student_pic.jpg')}}"
                            height="200" width="200" alt="trainee profile pic">
                    </td>
                    <td colspan="3">
                        <table class="table">
                            <tbody>
                            <tr>
                                <td class="text-bold custom-bg-gradient-info">Trainee Name :</td>
                                <td class="custom-bg-gradient-info">{{ $traineeSelfInfo->name }}</td>
                            </tr>
                            <tr>
                                <td class="text-bold custom-bg-gradient-info">Father's Name:</td>
                                <td class="custom-bg-gradient-info">{{ optional($familyMembers['father'])->name }}</td>
                            </tr>

                            <tr>
                                <td class="text-bold custom-bg-gradient-info">Mother's Name:</td>
                                <td class="custom-bg-gradient-info">{{ optional($familyMembers['mother'])->name }}</td>
                            </tr>

                            <tr>
                                <td class="text-bold custom-bg-gradient-info">Date of Birth:</td>
                                <td class="custom-bg-gradient-info">{{ optional($traineeSelfInfo)->date_of_birth }}
                                    [YYYY-MM-DD]
                                    {{  \Carbon\Carbon::parse($traineeSelfInfo->date_of_birth)->diff(\Carbon\Carbon::now())->format('%y years, %m months and %d days')}}
                                </td>
                            </tr>

                            <tr>
                                <td class="text-bold custom-bg-gradient-info">Gender:</td>
                                <td class="custom-bg-gradient-info">{{ $traineeSelfInfo->getUserGender() ?? '' }}</td>
                            </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>


                <tr class="custom-bg-gradient-info">
                    <td class="border-0"></td>
                    <td class="text-bold border-0">Mobile Number:</td>
                    <td class="border-top-0 border-bottom">{{ optional($traineeSelfInfo)->mobile }}</td>

{{--                    <td class="text-bold border-0">Marital Status:</td>
                    <td class="border-top-0 border-bottom">{{ $traineeSelfInfo->currentMaritalStatus() ?? '' }}</td>
               --}} </tr>

                <tr class="custom-bg-gradient-info">
                    <td class="border-0"></td>
                    <td class="text-bold border-0">Physically Disable:</td>
                    <td class="border-top-0 border-bottom">
                        {{ $traineeSelfInfo->disable_status == \App\Models\Trainee::IS_DISABLE_YES? 'Yes' : 'No' }}
                    </td>

                    <td class="text-bold border-0">Ethnic Minority:</td>
                    <td class="border-top-0 border-bottom">{{ $traineeSelfInfo->ethnic_group == \App\Models\Trainee::ETHNIC_GROUP_YES ? 'Yes' : 'No' }}</td>
                </tr>
                {{--

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
                                                class="font-weight-bold">Village/Road/House:</span> {{ !empty($trainee->present_address_house_address) ? $trainee->present_address_house_address['village_name'] .'/'. $trainee->present_address_house_address['house_and_road']: 'N/A' }}
                                            <br>
                                            <span
                                                class="font-weight-bold">Post Office:</span> {{ !empty($trainee->present_address_house_address) ? $trainee->present_address_house_address['postal_code'] : 'N/A' }}
                                            <br>
                                            <span
                                                class="font-weight-bold">Upazila/Thana:</span> {{  optional($trainee->presentAddressUpazila)->title_en }}
                                            <br>
                                            <span
                                                class="font-weight-bold">District:</span> {{  optional($trainee->presentAddressDistrict)->title_en }}
                                            <br>
                                            <span
                                                class="font-weight-bold">Division:</span> {{ optional($trainee->presentAddressDivision)->title_en }}
                                            <br>
                                        </p>
                                    </td>
                                    <td colspan="2" class="custom-bg-gradient-info">
                                        <p class="custom-small-line-height">
                                            <span
                                                class="font-weight-bold">Village/Road/House:</span> {{ !empty($trainee->permanent_address_house_address) ? $trainee->permanent_address_house_address['village_name'] .'/'. $trainee->permanent_address_house_address['house_and_road']: 'N/A' }}
                                            <br>
                                            <span
                                                class="font-weight-bold">Post Office:</span> {{ !empty($trainee->permanent_address_house_address) ? $trainee->permanent_address_house_address['postal_code'] : 'N/A' }}
                                            <br>
                                            <span
                                                class="font-weight-bold">Upazila/Thana:</span> {{ optional($trainee->permanentAddressUpazila)->title_en }}
                                            <br>
                                            <span
                                                class="font-weight-bold">District:</span> {{optional($trainee->permanentAddressDistrict)->title_en }}
                                            <br>
                                            <span
                                                class="font-weight-bold">Division:</span> {{ optional($trainee->permanentAddressDivision)->title_en }}
                                            <br>
                                        </p>
                                    </td>
                                </tr>
                                --}}
                                <tr>
                                    <td class="border-0"></td>
                                    <td colspan="4" class="custom-bg-gradient-info text-bold lead text-center">Academic Qualification</td>
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

                                        @if(count($traineeAcademicQualifications) > 0)
                                            @foreach($traineeAcademicQualifications as $key => $academicQualification)
                                                <tr>
                                                    <td class="border-0"></td>
                                                    <td class="text-center">
                                                        @switch($academicQualification->examination)
                                                            @case(\App\Models\Trainee::EXAMINATION_JSC)
                                                            {{ $academicQualification->getExamination() .'/'. $academicQualification->getJSCExaminationName() }}
                                                            @break
                                                            @case(\App\Models\Trainee::EXAMINATION_SSC)
                                                            {{ $academicQualification->getExamination() .'/'. $academicQualification->getSSCExaminationName() }}
                                                            @break
                                                            @case(\App\Models\Trainee::EXAMINATION_HSC)
                                                            {{ $academicQualification->getExamination() .'/'. $academicQualification->getHSCExaminationName() }}
                                                            @break
                                                            @case(\App\Models\Trainee::EXAMINATION_GRADUATION)
                                                            {{ $academicQualification->getExamination() .'/'. $academicQualification->getGraduationExaminationName() }}
                                                            @break
                                                            @case(\App\Models\Trainee::EXAMINATION_MASTERS)
                                                            {{ $academicQualification->getExamination() .'/'. $academicQualification->getMastersExaminationName() }}
                                                            @break
                                                        @endswitch
                                                    </td>

                                                    <td class="text-center">
                                                        @if($academicQualification->examination == \App\Models\Trainee::EXAMINATION_JSC || $academicQualification->examination == \App\Models\Trainee::EXAMINATION_SSC || $academicQualification->examination == \App\Models\Trainee::EXAMINATION_HSC)
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
                                        @if(!empty($familyMembers['guardian']))
                                            <tr>
                                                <td class="border-0"></td>
                                                <td colspan="7" class="custom-bg-gradient-info text-bold lead">Additional Information</td>
                                            </tr>
                                            <tr>
                                                <td class="border-0"></td>
                                                <td class="text-bold">Guradian:</td>
                                                <td>{{!empty($familyMembers['guardian']) ? $familyMembers['guardian']->name : 'N/A' }}</td>
                                            </tr>

                                            <tr>
                                                <td class="border-0"></td>
                                                <td class="text-bold">Relation with Youth:</td>
                                                <td>{{!empty($familyMembers['guardian']) ? $familyMembers['guardian']->relation_with_trainee : "N/A" }}</td>
                                            </tr>

                                            <tr>
                                                <td class="border-0"></td>
                                                <td class="text-bold">Guradian Mobile Number:</td>
                                                <td>{{!empty($familyMembers['guardian']) ? $familyMembers['guardian']->mobile : 'N/A'}}</td>
                                            </tr>
                                            {{--<tr>
                                                <td class="border-0"></td>
                                                <td class="text-bold">Guradian NID:</td>
                                                <td>{{!empty($familyMembers['guardian']) ? $familyMembers['guardian']->nid : 'N/A'}}</td>
                                            </tr>--}}
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

                                {{--
                                   <tr>
                                       <td class="border-0"></td>
                                       <td class="text-bold">Youth signature</td>
                                   </tr>

                                <tr>
                                    <td class="border-0"></td>
                                    <td>
                                        <img
                                            src="{{ asset('storage/'. $trainee->signature_pic)}}"
                                            height="50" width="200" alt="trainee signature"></td>
                                </tr>--}}

                                    </table>>
            </table>
        </div>
    </div>

@endsection
