@php
    $currentInstitute = domainConfig('institute');
    $layout = 'master::layouts.front-end';

    $authYouth = App\Helpers\Classes\AuthHelper::getAuthUser('youth');
@endphp
@extends($layout)

@section('title')
    কোর্স নিবন্ধন
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row mt-2">
            @if(!$authYouth || !empty($publishCourse))
                <div class="col-md-12">
                    <div class="card card mb-0">
                        <div class="card-body">
                            @if(!$authYouth)
                            <div class="text-info text-center">
                                আপনি যদি পূর্বে নিবন্ধন করে থাকেন তাহলে <a href="{{ route('course_management::youth.login-form') }}">লগইন</a> করে কোর্স এ আবেদন করুন
                            </div>
                            @endif

                            @if(!empty($publishCourse))
                            <div class="text-info text-center">
                                ( আপনি এখন <strong>{{optional($publishCourse->course)->title_bn}}</strong> কোর্স এ আবেদন
                                করছেন )
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endif

            <div class="col-md-12">
                <div class="card card-success card mb-0">
                    <div class="card-header text-center pt-4 pb-4">
                        <h3>কোর্স নিবন্ধন</h3>
                    </div>
                </div>
            </div>
            <form action="{{ route('course_management::youth-registrations.store') }}" method="POST"
                  class="youthRegistrationForm"
                  enctype="multipart/form-data">
                @csrf
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header d-flex custom-bg-gradient-info mt-2">
                            <h3 class="card-title font-weight-bold text-primary">
                                <i class="fab fa-wpforms"> </i> ব্যক্তিগত তথ্য</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="name_en">নাম (ইংরেজি) <span class="required">*</span> :</label>
                                    <input type="text" class="form-control" name="name_en" id="name_en" {{ $authYouth?'readonly':'' }}
                                           value="{{ $authYouth?$authYouth->name_en: old('name_en') }}"
                                           placeholder="নাম">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="name_bn">নাম (বাংলা) <span class="required">*</span> :</label>
                                    <input type="text" class="form-control" name="name_bn" id="name_bn"
                                           value="{{ old('name_bn') }}" placeholder="নাম">
                                </div>

                                @if(!empty($publishCourse))
                                    <input type="hidden" name="institute_id" id="institute_id"
                                           value="{{$publishCourse->institute_id}}">
                                    <input type="hidden" name="branch_id" id="branch_id"
                                           value="{{$publishCourse->branch_id}}">
                                    <input type="hidden" name="training_center_id" id="training_center_id"
                                           value="{{$publishCourse->training_center_id}}">
                                    <input type="hidden" name="programme_id" id="programme_id"
                                           value="{{$publishCourse->programme_id}}">
                                    <input type="hidden" name="publish_course_id" id="publish_course_id"
                                           value="{{$publishCourse->id}}">
                                    <input type="hidden" name="application_form_type_id" id=""
                                           value="{{$publishCourse->application_form_type_id}}">
                                @else
                                    @if(!empty(domainConfig('institute')))
                                        <input type="hidden" name="institute_id" id="institute_id"
                                               value="{{ domainConfig('institute')->id }}">
                                    @else
                                        <div class="form-group col-md-6">
                                            <label for="institute_id">প্রতিষ্ঠান<span
                                                    class="required">*</span> :</label>
                                            <select class="form-control select2-ajax-wizard"
                                                    name="institute_id"
                                                    id="institute_id"
                                                    data-model="{{base64_encode(\Module\CourseManagement\App\Models\Institute::class)}}"
                                                    data-label-fields="{title_bn}"
                                                    data-dependent-fields="#branch_id|#training_center_id|#programme_id|#publish_course_id"
                                                    data-placeholder="নির্বাচন করুন"
                                            >
                                            </select>
                                        </div>
                                    @endif

                                    <div class="form-group col-md-6 d-none">
                                        <label for="branch_id">ব্রাঞ্চ :</label>
                                        <select class="form-control select2-ajax-wizard"
                                                name="branch_id"
                                                id="branch_id"
                                                data-model="{{base64_encode(\Module\CourseManagement\App\Models\Branch::class)}}"
                                                data-label-fields="{title_bn}"
                                                data-depend-on-optional="institute_id"
                                                data-placeholder="নির্বাচন করুন"
                                        >
                                        </select>
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label for="training_center_id">প্রশিক্ষণ কেন্দ্র :</label>
                                        <select class="form-control select2-ajax-wizard"
                                                name="training_center_id"
                                                id="training_center_id"
                                                data-model="{{base64_encode(\Module\CourseManagement\App\Models\TrainingCenter::class)}}"
                                                data-label-fields="{title_bn}"
                                                data-depend-on-optional="branch_id|institute_id"
                                                data-placeholder="নির্বাচন করুন"
                                        >
                                        </select>
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label for="programme_id">প্রোগ্রাম :</label>
                                        <select class="form-control select2-ajax-wizard"
                                                name="programme_id"
                                                id="programme_id"
                                                data-model="{{base64_encode(\Module\CourseManagement\App\Models\Programme::class)}}"
                                                data-label-fields="{title_bn}"
                                                data-depend-on-optional="institute_id"
                                                data-placeholder="নির্বাচন করুন"
                                        >
                                        </select>
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label for="publish_course_id">কোর্স<span class="required">*</span> :</label>
                                        <select class="form-control select2-ajax-wizard"
                                                name="publish_course_id"
                                                id="publish_course_id"
                                                data-model="{{base64_encode(\Module\CourseManagement\App\Models\PublishCourse::class)}}"
                                                data-label-fields="{course.title_bn}"
                                                data-depend-on-optional="institute_id|branch_id|training_center_id|programme_id"
                                                data-placeholder="নির্বাচন করুন"
                                        >
                                        </select>
                                    </div>
                                @endif


                                <div class="form-group col-md-6">
                                    <label for="gender">লিঙ্গ<span class="required">*</span> :</label>
                                    <div class="d-md-flex form-control" style="display: inline-table;">
                                        <div class="custom-control custom-radio mr-3">
                                            <input class="custom-control-input" type="radio" id="gender_male"
                                                   name="gender"
                                                   value="{{ \Module\CourseManagement\App\Models\YouthFamilyMemberInfo::GENDER_MALE }}"
                                                {{old('gender') == \Module\CourseManagement\App\Models\YouthFamilyMemberInfo::GENDER_MALE ? 'checked' : ''}}>
                                            <label for="gender_male" class="custom-control-label">পুরুষ</label>
                                        </div>
                                        <div class="custom-control custom-radio mr-3">
                                            <input class="custom-control-input" type="radio" id="gender_female"
                                                   name="gender"
                                                   value="{{ \Module\CourseManagement\App\Models\YouthFamilyMemberInfo::GENDER_FEMALE }}"
                                                {{ old('gender') == \Module\CourseManagement\App\Models\YouthFamilyMemberInfo::GENDER_FEMALE ? 'checked' : ''}}>
                                            <label for="gender_female" class="custom-control-label">নারী</label>
                                        </div>
                                        {{--<div class="custom-control custom-radio mr-3">
                                            <input class="custom-control-input" type="radio" id="gender_hermaphrodite"
                                                   name="gender"
                                                   value="{{ \Module\CourseManagement\App\Models\YouthFamilyMemberInfo::GENDER_HERMAPHRODITE }}"
                                                {{ old('gender') == \Module\CourseManagement\App\Models\YouthFamilyMemberInfo::GENDER_HERMAPHRODITE ? 'checked' : ''}}>
                                            <label for="gender_hermaphrodite"
                                                   class="custom-control-label">উভলিঙ্গ</label>
                                        </div>--}}
                                        <div class="custom-control custom-radio mr-3">
                                            <input class="custom-control-input" type="radio" id="gender_transgender"
                                                   name="gender"
                                                   value="{{ \Module\CourseManagement\App\Models\YouthFamilyMemberInfo::GENDER_TRANSGENDER }}"
                                                {{old('gender') == \Module\CourseManagement\App\Models\YouthFamilyMemberInfo::GENDER_TRANSGENDER ? 'checked' : ''}}>
                                            <label for="gender_transgender"
                                                   class="custom-control-label">হিজড়া</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="mobile">মোবাইল নাম্বার <span class="required">*</span>
                                        :</label>
                                    <input type="text" class="form-control" name="mobile" id="mobile"
                                           value="{{ old('mobile') }}" placeholder="মোবাইল">
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="email">ইমেইল <span class="required">*</span>
                                        :</label>
                                    <input type="text" class="form-control" name="email" id="email"
                                           value="{{ old('email') }}" placeholder="ইমেল">
                                </div>


                                <div class="form-group col-md-6">
                                    <label for="date_of_birth">জন্ম তারিখ <span
                                            class="required">*</span> :</label>
                                    <input type="text" class="form-control flat-date" name="date_of_birth"
                                           id="date_of_birth" value="{{ old('date_of_birth') }}"
                                           placeholder="জন্ম তারিখ">
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="marital_status">বৈবাহিক অবস্থা <span
                                            class="required">*</span> :</label>
                                    <div class="form-control">
                                        <div class="custom-control  custom-radio d-inline-block mr-3">
                                            <input class="custom-control-input" type="radio" id="marital_status_married"
                                                   name="marital_status"
                                                   value="{{ \Module\CourseManagement\App\Models\YouthFamilyMemberInfo::MARITAL_STATUS_MARRIED }}"
                                                {{ old('marital_status') == \Module\CourseManagement\App\Models\YouthFamilyMemberInfo::MARITAL_STATUS_MARRIED ? 'checked' : '' }}>
                                            <label for="marital_status_married"
                                                   class="custom-control-label">বিবাহিত</label>
                                        </div>
                                        <div class="custom-control custom-radio d-inline-block mr-3">
                                            <input class="custom-control-input" type="radio" id="marital_status_single"
                                                   name="marital_status"
                                                   value="{{ \Module\CourseManagement\App\Models\YouthFamilyMemberInfo:: MARITAL_STATUS_SINGLE}}"
                                                {{ old('marital_status') == \Module\CourseManagement\App\Models\YouthFamilyMemberInfo::MARITAL_STATUS_SINGLE ? 'checked' : '' }}>
                                            <label for="marital_status_single"
                                                   class="custom-control-label">অবিবাহিত</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="religion">ধর্ম<span class="required">*</span> :</label>
                                    <div class="d-md-flex form-control" style="display: inline-table;">
                                        <div class="custom-control custom-radio mr-3">
                                            <input class="custom-control-input" type="radio" id="religion_islam"
                                                   name="religion"
                                                   value="{{ \Module\CourseManagement\App\Models\YouthFamilyMemberInfo::RELIGION_ISLAM }}"
                                                {{ old('religion') == \Module\CourseManagement\App\Models\YouthFamilyMemberInfo::RELIGION_ISLAM ? 'checked' : '' }}>
                                            <label for="religion_islam" class="custom-control-label">ইসলাম</label>
                                        </div>
                                        <div class="custom-control custom-radio mr-3">
                                            <input class="custom-control-input" type="radio" id="religion_hindu"
                                                   name="religion"
                                                   value="{{ \Module\CourseManagement\App\Models\YouthFamilyMemberInfo::RELIGION_HINDU }}"
                                                {{ old('religion') == \Module\CourseManagement\App\Models\YouthFamilyMemberInfo::RELIGION_HINDU ? 'checked' : '' }}>

                                            <label for="religion_hindu" class="custom-control-label">হিন্দু</label>
                                        </div>
                                        <div class="custom-control custom-radio mr-3">
                                            <input class="custom-control-input" type="radio" id="religion_christian"
                                                   name="religion"
                                                   value="{{ \Module\CourseManagement\App\Models\YouthFamilyMemberInfo::RELIGION_CHRISTIAN }}"
                                                {{ old('religion') == \Module\CourseManagement\App\Models\YouthFamilyMemberInfo::RELIGION_CHRISTIAN ? 'checked' : '' }}>
                                            <label for="religion_christian"
                                                   class="custom-control-label">খ্রিস্টান</label>
                                        </div>

                                        <div class="custom-control custom-radio mr-3">
                                            <input class="custom-control-input" type="radio" id="religion_buddhist"
                                                   name="religion"
                                                   value="{{ \Module\CourseManagement\App\Models\YouthFamilyMemberInfo::RELIGION_BUDDHIST }}"
                                                {{ old('religion') == \Module\CourseManagement\App\Models\YouthFamilyMemberInfo::RELIGION_BUDDHIST ? 'checked' : '' }}>
                                            <label for="religion_buddhist" class="custom-control-label">বৌদ্ধ</label>
                                        </div>

                                        <div class="custom-control custom-radio mr-3">
                                            <input class="custom-control-input" type="radio" id="religion_jain"
                                                   name="religion"
                                                   value="{{ \Module\CourseManagement\App\Models\YouthFamilyMemberInfo::RELIGION_JAIN }}"
                                                {{ old('religion') == \Module\CourseManagement\App\Models\YouthFamilyMemberInfo::RELIGION_JAIN ? 'checked' : '' }}>
                                            <label for="religion_jain" class="custom-control-label">জৈন</label>
                                        </div>

                                        <div class="custom-control custom-radio mr-3">
                                            <input class="custom-control-input" type="radio" id="religion_other"
                                                   name="religion"
                                                   value="{{ \Module\CourseManagement\App\Models\YouthFamilyMemberInfo::RELIGION_OTHERS }}"
                                                {{ old('religion') == \Module\CourseManagement\App\Models\YouthFamilyMemberInfo::RELIGION_OTHERS ? 'checked' : '' }}>
                                            <label for="religion_other" class="custom-control-label">অন্যান্য</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="nationality"> জাতীয়তা <span class="required">*</span>
                                        :</label>
                                    <select class="select2" name="nationality" id="nationality">
                                        <option value=""></option>
                                        <option value="bd">বাংলাদেশী</option>
                                        <option value="others">অন্যান্য</option>
                                    </select>
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="nid">এন.আই.ডি নাম্বার/জন্ম সনদ/পাসপোর্ট নাম্বার [যেকোনো একটি ঘর পূর্ণ
                                        করুন] <span class="required">*</span>:</label>
                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <input type="text" class="form-control mb-2" name="nid" id="nid"
                                                   value="{{ old('nid') }}"
                                                   placeholder="এন.আই.ডি নাম্বার">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <input type="text" class="form-control mb-2" name="birth_certificate_no"
                                                   id="birth_certificate_no"
                                                   value="{{ old('birth_certificate_no') }}"
                                                   placeholder="জন্ম সনদ নাম্বার">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <input type="text" class="form-control mb-2" name="passport_number"
                                                   id="passport_number"
                                                   value="{{ old('passport_number') }}" placeholder="পাসপোর্ট নাম্বার">
                                        </div>

                                    </div>
                                </div>


                                @if(!empty($publishCourse))
                                    <div class="form-group col-md-6 freedom-fighter-status-information">
                                        <label for="freedom_fighter_status">মুক্তিযোদ্ধা তথ্য<span
                                                class="required">*</span>
                                            :</label>
                                        <select name="freedom_fighter_status" id="freedom_fighter_status"
                                                class="select2">
                                            <option value=""></option>
                                            @foreach(\Module\CourseManagement\App\Models\YouthFamilyMemberInfo::getFreedomFighterStatusOptions() as $key=>$value)
                                                <option
                                                    value="{{ $key }}" {{ $key == old('freedom_fighter_status') ? 'selected' : '' }}>{{ $value }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                @else
                                    <div class="form-group col-md-6 freedom-fighter-status-information">
                                        <label for="freedom_fighter_status">মুক্তিযোদ্ধা তথ্য<span
                                                class="required">*</span>
                                            :</label>
                                        <select name="freedom_fighter_status" id="freedom_fighter_status"
                                                class="select2">
                                            <option value=""></option>
                                            @foreach(\Module\CourseManagement\App\Models\YouthFamilyMemberInfo::getFreedomFighterStatusOptions() as $key=>$value)
                                                <option
                                                    value="{{ $key }}" {{ $key == old('freedom_fighter_status') ? 'selected' : '' }}>{{ $value }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                @endif


                                <div class="form-group col-md-6 physical-disability-information">
                                    <label for="disable_status">শারীরিক প্রতিবন্ধী?
                                        <span class="required">*</span>:</label>
                                    <div class="input-group form-control">
                                        <div class="custom-control custom-radio mr-3">
                                            <input type="radio" name="disable_status"
                                                   class="custom-control-input"
                                                   value="{{ \Module\CourseManagement\App\Models\YouthFamilyMemberInfo::PHYSICALLY_DISABLE_YES }}"
                                                   id="physically_disable" {{ old('disable_status') == \Module\CourseManagement\App\Models\YouthFamilyMemberInfo::PHYSICALLY_DISABLE_YES ? 'checked' : '' }}>
                                            <label class="custom-control-label" for="physically_disable">হ্যাঁ</label>
                                        </div>
                                        <div class="custom-control custom-radio mr-3">
                                            <input type="radio" name="disable_status"
                                                   class="custom-control-input"
                                                   value="{{ \Module\CourseManagement\App\Models\YouthFamilyMemberInfo::PHYSICALLY_DISABLE_NOT }}"
                                                   id="physically_not_disable" {{ old('disable_status') == \Module\CourseManagement\App\Models\YouthFamilyMemberInfo::PHYSICALLY_DISABLE_NOT ? 'checked' : '' }}>

                                            <label class="custom-control-label" for="physically_not_disable">না</label>
                                        </div>
                                    </div>
                                    <div class="mt-2">
                                        <select name="physical_disabilities" id="physical_disabilities"
                                                class="select2" multiple>
                                            @foreach(\Module\CourseManagement\App\Models\YouthFamilyMemberInfo::getPhysicalDisabilityOptions() as $key => $value)
                                                <option
                                                    value="{{ $key }}" {{ $key == old('physical_disabilities') ? 'selected': '' }}>{{ $value }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group col-md-6 ethnic-group-information">
                                    <label for="ethnic_group">ক্ষুদ্র নৃগোষ্ঠী?<span
                                            class="required">*</span>:</label>
                                    <div class="form-control">
                                        <div class="input-group">
                                            <div class="custom-control custom-radio d-inline-block mr-3">
                                                <input type="radio" name="ethnic_group"
                                                       class="custom-control-input"
                                                       value="{{ \Module\CourseManagement\App\Models\Youth::ETHNIC_GROUP_YES }}"
                                                       id="ethnic_group_yes" {{ old('ethnic_group') == \Module\CourseManagement\App\Models\Youth::ETHNIC_GROUP_YES? 'checked' : '' }}>
                                                <label class="custom-control-label" for="ethnic_group_yes">হ্যাঁ</label>
                                            </div>
                                            <div class="custom-control custom-radio d-inline-block mr-3">
                                                <input type="radio" name="ethnic_group"
                                                       class="custom-control-input"
                                                       value="{{ \Module\CourseManagement\App\Models\Youth::ETHNIC_GROUP_NO }}"
                                                       id="ethnic_group_no" {{ old('ethnic_group') == \Module\CourseManagement\App\Models\Youth::ETHNIC_GROUP_NO? 'checked' : '' }}>
                                                <label class="custom-control-label" for="ethnic_group_no">না</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="form-row justify-content-between">
                                <div class="form-group col-md-6">
                                    <label for="student_pic"> পাসপোর্ট সাইজের ছবি <span
                                            class="required">*</span></label>
                                    <p class="font-italic font-weight-light" style="font-size: 12px;">(ছবি আকার অবশ্যই
                                        ৩০০ <i
                                            class="fa fa-times" style="color: #CCCCCC"></i> ৩০০ হতে হবে)</p>
                                    <div class="input-group">
                                        <div class="profile-upload-section">
                                            <div class="avatar-preview student_pic text-center">
                                                <label for="student_pic">
                                                    <img class="figure-img"
                                                         src="https://via.placeholder.com/350x350?text=Student+Picture"
                                                         style="width: 200px; height: 200px;"
                                                         alt="Profile pic"/>
                                                    <span class="p-1 bg-gray"
                                                          style="position: relative; right: 0; bottom: 50%; border: 2px solid #afafaf; border-radius: 50%;margin-left: -31px; overflow: hidden">
                                                        <i class="fa fa-pencil-alt text-white"></i>
                                                    </span>
                                                </label>
                                            </div>
                                            <input type="file" name="student_pic" style="display: none"
                                                   id="student_pic">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="student_signature_pic">স্বাক্ষর<span
                                            class="required">*</span></label>
                                    <p class=" font-italic font-weight-light text-small" style="font-size: 12px;">(ছবি
                                        আকার অবশ্যই ৩০০ <i
                                            class="fa fa-times" style="color: #CCCCCC"></i> ৮০ হতে হবে)</p>
                                    <div class="input-group">
                                        <div class="profile-upload-section">
                                            <div class="avatar-preview student_signature_pic text-center">
                                                <label for="student_signature_pic">
                                                    <img class="loading-img"
                                                         src="https://via.placeholder.com/350x350?text=Student+Signature"
                                                         style="width: 250px; height: 100px"
                                                         alt="Signature pic"/>
                                                    <span class="p-1 bg-gray"
                                                          style="position: relative; right: 0; bottom: 50%; border: 2px solid #afafaf; border-radius: 50%;margin-left: -31px; overflow: hidden">
                                                        <i class="fa fa-pencil-alt text-white"></i>
                                                    </span>
                                                </label>
                                            </div>
                                            <input type="file" name="student_signature_pic" style="display: none"
                                                   id="student_signature_pic">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header custom-bg-gradient-info">
                            <h3 class="card-title font-weight-bold text-primary"><i class="fa fa-address-book"> </i>
                                বর্তমান ঠিকানা</h3>
                        </div>
                        <div class="card-body">
                            <div class="form-row col-md-12">
                                <div class="form-group col-md-4">
                                    <label for="present_address_division_id">বিভাগ <span
                                            class="required">*</span> :</label>
                                    <select class="form-control select2-ajax-wizard"
                                            name="address[present][present_address_division_id]"
                                            id="present_address_division_id"
                                            data-model="{{base64_encode(\App\Models\LocDivision::class)}}"
                                            data-label-fields="{title}"
                                            {{--                                            data-dependent-fields="#present_address_district_id|#present_address_upazila_id"--}}
                                            data-placeholder="নির্বাচন করুন"
                                    >
                                    </select>

                                    <input type="number" name="address[present][present_address_division_id]"
                                           id="hidden_present_address_division_id" hidden disabled>
                                </div>

                                <div class="col-md-4 form-group">
                                    <label for="present_address_district_id">জেলা<span
                                            class="required">*</span> :</label>
                                    <select class="form-control select2-ajax-wizard" disabled
                                            name="address[present][present_address_district_id]"
                                            id="present_address_district_id"
                                            data-model="{{base64_encode(\App\Models\LocDistrict::class)}}"
                                            data-label-fields="{title}"
                                            data-depend-on="loc_division_id:#present_address_division_id"
                                            data-dependent-fields="#present_address_upazila_id"
                                            data-placeholder="নির্বাচন করুন"
                                    >
                                    </select>
                                    <input type="number" id="hidden_present_address_district_id"
                                           name="address[present][present_address_district_id]" hidden disabled>
                                </div>

                                <div class="col-md-4 form-group">
                                    <label for="present_address_upazila_id">উপজেলা/থানা<span
                                            class="required">*</span> :</label>
                                    <select class="form-control select2-ajax-wizard" disabled
                                            name="address[present][present_address_upazila_id]"
                                            id="present_address_upazila_id"
                                            data-model="{{base64_encode(\App\Models\LocUpazila::class)}}"
                                            data-label-fields="{title}"
                                            data-depend-on="loc_district_id:#present_address_district_id"
                                            data-placeholder="নির্বাচন করুন"
                                    >
                                    </select>
                                    <input type="number" id="hidden_present_address_upazila_id"
                                           name="address[present][present_address_upazila_id]" hidden disabled>
                                </div>

                                <div class="col-md-4 form-group">
                                    <label for="present_address_postal_code">ডাকঘর<span
                                            class="required">*</span> :</label>
                                    <input type="text"
                                           name="address[present][present_address_house_address][postal_code]"
                                           id="present_address_postal_code" class="form-control"
                                           value="{{ old('address.present.present_address_house_address.postal_code') }}"
                                           placeholder="ডাকঘর">
                                </div>

                                <div class="col-md-4 form-group">
                                    <label for="present_address_village_name">গ্রাম/মহল্লা/এলাকা<span
                                            class="required">*</span> :</label>
                                    <input type="text"
                                           name="address[present][present_address_house_address][village_name]"
                                           id="present_address_village_name" class="form-control"
                                           value="{{ old('address.present.present_address_house_address.village_name') }}"
                                           placeholder="গ্রাম/মহল্লা/এলাকা">
                                </div>

                                <div class="col-md-4 form-group">
                                    <label for="present_address_house_and_road">বাড়ি নং/রোড<span
                                            class="required">*</span> :</label>
                                    <input type="text"
                                           name="address[present][present_address_house_address][house_and_road]"
                                           id="present_address_house_and_road" class="form-control"
                                           value="{{ old('address.present.present_address_house_address.house_and_road') }}"
                                           placeholder="বাড়ি নং/রোড">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header custom-bg-gradient-info">
                            <div class="form-inline">
                                <h3 class="card-title font-weight-bold text-primary"><i class="fa fa-address-book"> </i>
                                    স্থায়ী ঠিকানা</h3>
                                <div class="custom-control custom-checkbox ml-2">
                                    <input class="custom-control-input" type="checkbox"
                                           id="permanent_address_same_as_present_address"
                                           name="permanent_address_same_as_present_address">
                                    <label for="permanent_address_same_as_present_address" class="custom-control-label">
                                        (বর্তমান ঠিকানা হিসাবে একই)</label>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="form-row col-md-12 permanent-addresses">
                                <div class="col-md-4 form-group">
                                    <label for="permanent_address_division_id">বিভাগ<span
                                            class="required">*</span> :</label>
                                    <select class="form-control select2-ajax-wizard"
                                            name="address[permanent][permanent_address_division_id]"
                                            id="permanent_address_division_id"
                                            data-model="{{base64_encode(\App\Models\LocDivision::class)}}"
                                            data-label-fields="{title}"
                                            {{--                                            data-dependent-fields="#permanent_address_district_id|#permanent_address_upazila_id"--}}
                                            data-placeholder="নির্বাচন করুন"
                                    >
                                    </select>
                                    <input type="number" name="address[permanent][permanent_address_division_id]"
                                           id="hidden_permanent_address_division_id" hidden disabled>
                                </div>

                                <div class="col-md-4 form-group">
                                    <label for="permanent_address_district_id">জেলা<span
                                            class="required">*</span> :</label>
                                    <select class="form-control select2-ajax-wizard" disabled
                                            name="address[permanent][permanent_address_district_id]"
                                            id="permanent_address_district_id"
                                            data-model="{{base64_encode(\App\Models\LocDistrict::class)}}"
                                            data-label-fields="{title}"
                                            data-depend-on="loc_division_id:#permanent_address_division_id"
                                            data-dependent-fields="#permanent_address_upazila_id"
                                            data-placeholder="নির্বাচন করুন"
                                    >
                                    </select>
                                    <input type="number" name="address[permanent][permanent_address_district_id]"
                                           id="hidden_permanent_address_district_id" hidden disabled>

                                </div>

                                <div class="col-md-4 form-group">
                                    <label for="permanent_address_upazila_id">উপজেলা/থানা<span
                                            class="required">*</span> :</label>
                                    <select class="form-control select2-ajax-wizard" disabled
                                            name="address[permanent][permanent_address_upazila_id]"
                                            id="permanent_address_upazila_id"
                                            data-model="{{base64_encode(\App\Models\LocUpazila::class)}}"
                                            data-label-fields="{title}"
                                            data-depend-on="loc_district_id:#permanent_address_district_id"
                                            data-placeholder="নির্বাচন করুন"
                                    >
                                    </select>
                                    <input type="hidden" name="address[permanent][permanent_address_upazila_id]"
                                           id="hidden_permanent_address_upazila_id" disabled>
                                </div>

                                <div class="col-md-4 form-group">
                                    <label for="permanent_address_postal_code">ডাকঘর<span
                                            class="required">*</span> :</label>
                                    <input type="text"
                                           name="address[permanent][permanent_address_house_address][postal_code]"
                                           id="permanent_address_postal_code" class="form-control"
                                           value="{{ old('address.permanent.permanent_address_house_address.postal_code') }}"
                                           placeholder="ডাকঘর">
                                </div>

                                <div class="col-md-4 form-group">
                                    <label for="permanent_address_village_name">গ্রাম/মহল্লা/এলাকা<span
                                            class="required">*</span> :</label>
                                    <input type="text"
                                           name="address[permanent][permanent_address_house_address][village_name]"
                                           id="permanent_address_village_name" class="form-control"
                                           value="{{ old('address.permanent.permanent_address_house_address.village_name') }}"
                                           placeholder="গ্রাম/মহল্লা/এলাকা">
                                </div>

                                <div class="col-md-4 form-group">
                                    <label for="permanent_address_house_and_road">বাড়ি নং/রোড<span
                                            class="required">*</span> :</label>
                                    <input type="text"
                                           name="address[permanent][permanent_address_house_address][house_and_road]"
                                           id="permanent_address_house_and_road" class="form-control"
                                           value="{{ old('address.permanent.permanent_address_house_address.house_and_road') }}"
                                           placeholder="বাড়ি নং/রোড">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header custom-bg-gradient-info academic-qualifications">
                            <h3 class="card-title font-weight-bold text-primary"><i
                                    class="fa fa-address-book"> </i> শিক্ষাগত যোগ্যতা </h3>
                        </div>
                        <div class="card-body row">
                            <div class="col-md-6 academic-qualification-jsc mb-2">
                                <div class="card col-md-12 custom-bg-gradient-info" style="height: 100%;">
                                    <div class="card-header">
                                        <h3 class="card-title text-primary d-inline-flex">জে.এস.সি/সমমান (পাস)</h3>
                                    </div>
                                    <div class="card-body jsc_collapse hide">

                                        <input type="hidden" name="academicQualification[jsc][examination]"
                                               value="{{ \Module\CourseManagement\App\Models\YouthAcademicQualification::EXAMINATION_JSC }}">

                                        <div class="form-row form-group">
                                            <label for="jsc_examination_name"
                                                   class="col-md-4 col-form-label">পরীক্ষা<span
                                                    class="required">*</span></label>
                                            <div class="col-md-8">
                                                <select name="academicQualification[jsc][examination_name]"
                                                        id="jsc_examination_name" class="select2 form-control">
                                                    <option value=""></option>
                                                    <option value="1">JSC</option>
                                                    <option value="2">JDC</option>
                                                </select>
                                            </div>
                                            <div class="col-md-4"></div>
                                        </div>

                                        <div class="form-row form-group mt-2">
                                            <label for="jsc_board" class="col-md-4 col-form-label">বোর্ড<span
                                                    class="required">*</span></label>
                                            <div class="col-md-8">
                                                <select name="academicQualification[jsc][board]" id="jsc_board"
                                                        class="select2">
                                                    @foreach(\Module\CourseManagement\App\Models\YouthAcademicQualification::getExaminationBoardOptions() as $key => $value)
                                                        <option value=""></option>
                                                        <option
                                                            value="{{ $key }}" {{ old('academicQualification.jsc.board') == $key ? 'selected' : '' }}>{{ $value }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-4"></div>
                                        </div>

                                        <div class="form-row form-group mt-2">
                                            <label for="jsc_roll" class="col-md-4 col-form-label">রোল নং<span
                                                    class="required">*</span></label>
                                            <div class="col-md-8">
                                                <input type="text" name="academicQualification[jsc][roll_no]"
                                                       id="jsc_roll" class="form-control"
                                                       value="{{ old('academicQualification.jsc.roll_no') }}">
                                            </div>
                                            <div class="col-md-4"></div>
                                        </div>

                                        <div class="form-row form-group mt-2">
                                            <label for="jsc_reg_no" class="col-md-4 col-form-label">
                                                রেজিস্ট্রেশান নং <span class="required">*</span></label>
                                            <div class="col-md-8">
                                                <input type="text" id="jsc_reg_no"
                                                       name="academicQualification[jsc][reg_no]"
                                                       class="form-control"
                                                       value="{{ old('academicQualification.jsc.reg_no') }}">
                                            </div>
                                            <div class="col-md-4"></div>
                                        </div>

                                        <input type="hidden" name="academicQualification[jsc][result]"
                                               value="5">
                                        <div class="form-row form-group mt-2">
                                            <label for="jsc_result" class="col-md-4 col-form-label">ফলাফল<span
                                                    class="required">*</span></label>
                                            <div class="col-md-8">
                                                <input type="number" name="academicQualification[jsc][grade]"
                                                       id="jsc_gpa" class="form-control"
                                                       width="10" placeholder="জি.পি.এ"
                                                       value="{{ old('academicQualification.jsc.grade') }}">
                                            </div>
                                            <div class="col-md-4"></div>
                                        </div>

                                        <div class="form-row form-group mt-2">
                                            <label for="jsc_passing_year" class="col-md-4 col-form-label">
                                                পাসের বছর<span class="required">*</span></label>
                                            <div class="col-md-8">
                                                <select name="academicQualification[jsc][passing_year]"
                                                        id="jsc_passing_year" class="select2">
                                                    <option value=""></option>
                                                    @for($i = now()->format('Y') - 50; $i <= now()->format('Y'); $i++)
                                                        <option
                                                            value="{{ $i }}" {{ old('academicQualification.jsc.passing_year') == $i ? 'selected' : '' }}>{{ $i }}</option>
                                                    @endfor
                                                </select>
                                            </div>
                                            <div class="col-md-4"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 academic-qualification-ssc mb-2">
                                <div class="card col-md-12 custom-bg-gradient-info" style="height: 100%;">
                                    <div class="card-header">
                                        <h3 class="card-title text-primary d-inline-flex">এস.এস.সি/সমমান/A-লেভেল
                                            (পাস) </h3>
                                    </div>
                                    <div class="card-body ssc_collapse {{--collapse--}} hide">

                                        <input type="hidden" name="academicQualification[ssc][examination]"
                                               value="{{ \Module\CourseManagement\App\Models\YouthAcademicQualification::EXAMINATION_SSC }}">

                                        <div class="form-row form-group">
                                            <label for="ssc_examination_name"
                                                   class="col-md-4 col-form-label">পরীক্ষা<span
                                                    class="required">*</span></label>
                                            <div class="col-md-8">
                                                <select name="academicQualification[ssc][examination_name]"
                                                        id="ssc_examination_name" class="select2 form-control">
                                                    <option value=""></option>
                                                    @foreach(\Module\CourseManagement\App\Models\YouthAcademicQualification::getSSCExaminationOptions() as $key => $value)
                                                        <option
                                                            value="{{ $key }}" {{ old('academicQualification.ssc.examination_name') == $key ? 'selected' : '' }}>{{ $value }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-4"></div>
                                        </div>

                                        <div class="form-row form-group mt-2">
                                            <label for="ssc_board" class="col-md-4 col-form-label">বোর্ড<span
                                                    class="required">*</span></label>
                                            <div class="col-md-8">
                                                <select name="academicQualification[ssc][board]" id="ssc_board"
                                                        class="select2">
                                                    @foreach(\Module\CourseManagement\App\Models\YouthAcademicQualification::getExaminationBoardOptions() as $key => $value)
                                                        <option value=""></option>
                                                        <option
                                                            value="{{ $key }}" {{ old('academicQualification.ssc.board') == $key ? 'selected' : '' }}>{{ $value }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-4"></div>
                                        </div>

                                        <div class="form-row form-group mt-2">
                                            <label for="ssc_roll" class="col-md-4 col-form-label">রোল নং<span
                                                    class="required">*</span></label>
                                            <div class="col-md-8">
                                                <input type="text" name="academicQualification[ssc][roll_no]"
                                                       id="ssc_roll" class="form-control"
                                                       value="{{ old('academicQualification.ssc.roll_no') }}">
                                            </div>
                                            <div class="col-md-4"></div>
                                        </div>

                                        <div class="form-row form-group mt-2">
                                            <label for="ssc_reg_no" class="col-md-4 col-form-label">রেজিস্ট্রেশান
                                                নং<span
                                                    class="required">*</span></label>
                                            <div class="col-md-8">
                                                <input type="text" id="ssc_reg_no"
                                                       name="academicQualification[ssc][reg_no]"
                                                       class="form-control"
                                                       value="{{ old('academicQualification.ssc.reg_no') }}">
                                            </div>
                                            <div class="col-md-4"></div>
                                        </div>

                                        <div class="form-row form-group mt-2">
                                            <label for="ssc_result" class="col-md-4 col-form-label">ফলাফল<span
                                                    class="required">*</span></label>
                                            <div class="col-md-8" id="ssc_result_div">
                                                <select name="academicQualification[ssc][result]"
                                                        id="ssc_result"
                                                        class="select2">
                                                    <option value=""></option>
                                                    @foreach(\Module\CourseManagement\App\Models\YouthAcademicQualification::getExaminationResultOptions() as $key => $value)
                                                        @if($key == \Module\CourseManagement\App\Models\YouthAcademicQualification::EXAMINATION_RESULT_PASSED_MBBS_BDS)
                                                            @continue;
                                                        @endif
                                                        <option
                                                            value="{{ $key }}" {{ old('academicQualification.ssc.result') == $key ? 'selected' : '' }}> {{ $value }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="" id="ssc_gpa_div">
                                                <input type="number" name="academicQualification[ssc][grade]"
                                                       id="ssc_gpa" class="form-control"
                                                       width="10" placeholder="জি.পি.এ"
                                                       value="{{ old('academicQualification.ssc.grade') }}"
                                                       hidden>
                                            </div>
                                            <div class="col-md-4"></div>
                                        </div>

                                        <div class="form-row form-group mt-2">
                                            <label for="ssc_group" class="col-md-4 col-form-label">বিভাগ<span
                                                    class="required">*</span></label>
                                            <div class="col-md-8">
                                                <select name="academicQualification[ssc][group]" class="select2"
                                                        id="ssc_group">
                                                    <option value=""></option>
                                                    @foreach(\Module\CourseManagement\App\Models\YouthAcademicQualification::getExaminationGroupOptions() as $key => $value)
                                                        <option
                                                            value="{{ $key }}" {{ old('academicQualification.ssc.group') == $key ? 'selected' : '' }}>{{ $value }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-4"></div>
                                        </div>

                                        <div class="form-row form-group mt-2">
                                            <label for="ssc_passing_year" class="col-md-4 col-form-label">পাসের
                                                বছর<span
                                                    class="required">*</span></label>
                                            <div class="col-md-8">
                                                <select name="academicQualification[ssc][passing_year]"
                                                        id="ssc_passing_year" class="select2">
                                                    <option value=""></option>
                                                    @for($i = now()->format('Y') - 50; $i <= now()->format('Y'); $i++)
                                                        <option
                                                            value="{{ $i }}" {{ old('academicQualification.ssc.passing_year') == $i ? 'selected' : '' }}>{{ $i }}</option>
                                                    @endfor
                                                </select>
                                            </div>
                                            <div class="col-md-4"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 academic-qualification-hsc mb-2">
                                <div class="card custom-bg-gradient-info col-md-12" style="height: 100%;">
                                    <div class="card-header">
                                        <h3 class="card-title text-primary d-inline-flex">এইচ.এস.সি/সমমান (পাস) </h3>
                                    </div>
                                    <div class="card-body hsc_collapse {{--collapse--}} hide">

                                        <input type="hidden" name="academicQualification[hsc][examination]"
                                               value="{{ \Module\CourseManagement\App\Models\YouthAcademicQualification::EXAMINATION_HSC }}">
                                        <div class="form-row form-group">
                                            <label for="hsc_examination_name"
                                                   class="col-md-4 col-form-label">পরীক্ষা<span
                                                    class="required">*</span></label>

                                            <div class="col-md-8">
                                                <select name="academicQualification[hsc][examination_name]"
                                                        id="hsc_examination_name" class="select2">
                                                    <option></option>
                                                    @foreach(\Module\CourseManagement\App\Models\YouthAcademicQualification::getHSCExaminationOptions() as $key => $value)
                                                        <option
                                                            value="{{ $key }}" {{ old('academicQualification.hsc.examination_name') == $key ? 'selected' : '' }}>{{ $value }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-4"></div>
                                        </div>

                                        <div class="form-row form-group mt-2">
                                            <label for="hsc_board" class="col-md-4 col-form-label">বোর্ড<span
                                                    class="required">*</span></label>
                                            <div class="col-md-8">
                                                <select name="academicQualification[hsc][board]" id="hsc_board"
                                                        class="select2">
                                                    <option></option>
                                                    @foreach(\Module\CourseManagement\App\Models\YouthAcademicQualification::getExaminationBoardOptions() as $key => $value)
                                                        <option
                                                            value="{{ $key }}" {{ old('academicQualification.hsc.board') == $key ? 'selected' : '' }}>{{ $value }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-4"></div>
                                        </div>

                                        <div class="form-row form-group mt-2">
                                            <label for="hsc_roll" class="col-md-4 col-form-label">রোল নং<span
                                                    class="required">*</span></label>
                                            <div class="col-md-8">
                                                <input type="text" name="academicQualification[hsc][roll_no]"
                                                       id="hsc_roll" class="form-control"
                                                       value="{{ old('academicQualification.hsc.roll_no')}}">
                                            </div>
                                            <div class="col-md-4"></div>
                                        </div>

                                        <div class="form-row form-group mt-2">
                                            <label for="hsc_reg_no" class="col-md-4 col-form-label">রেজিস্ট্রেশান
                                                নং<span
                                                    class="required">*</span></label>
                                            <div class="col-md-8">
                                                <input type="text" name="academicQualification[hsc][reg_no]"
                                                       id="hsc_reg_no" class="form-control"
                                                       value="{{ old('academicQualification.hsc.reg_no') }}">
                                            </div>
                                            <div class="col-md-4"></div>
                                        </div>

                                        <div class="form-row form-group mt-2">
                                            <label for="hsc_result" class="col-md-4 col-form-label">ফলাফল<span
                                                    class="required">*</span></label>
                                            <div class="col-md-8" id="hsc_result_div">
                                                <select name="academicQualification[hsc][result]"
                                                        id="hsc_result"
                                                        class="select2">
                                                    <option></option>
                                                    @foreach(\Module\CourseManagement\App\Models\YouthAcademicQualification::getExaminationResultOptions() as $key => $value)
                                                        @if($key == \Module\CourseManagement\App\Models\YouthAcademicQualification::EXAMINATION_RESULT_PASSED_MBBS_BDS)
                                                            @continue;
                                                        @endif
                                                        <option
                                                            value="{{ $key }}" {{ old('academicQualification.hsc.result') == $key ? 'selected' : '' }}>{{ $value }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="" id="hsc_gpa_div">
                                                <input type="number" name="academicQualification[hsc][grade]"
                                                       id="hsc_gpa" class="form-control"
                                                       width="10" placeholder="জি.পি.এ"
                                                       value="{{ old('academicQualification.hsc.grade') }}"
                                                       hidden>
                                            </div>
                                            <div class="col-md-4"></div>
                                        </div>

                                        <div class="form-row form-group mt-2">
                                            <label for="hsc_group" class="col-md-4 col-form-label">বিভাগ<span
                                                    class="required">*</span></label>
                                            <div class="col-md-8">
                                                <select name="academicQualification[hsc][group]" id="hsc_group"
                                                        class="select2">
                                                    <option></option>
                                                    @foreach(\Module\CourseManagement\App\Models\YouthAcademicQualification::getExaminationGroupOptions() as $key => $value)
                                                        <option
                                                            value="{{ $key }}" {{ old('academicQualification.hsc.group') == $key ? 'selected' : '' }}>{{ $value }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-4"></div>
                                        </div>

                                        <div class="form-row form-group mt-2">
                                            <label for="hsc_passing_year" class="col-md-4 col-form-label">
                                                পাসের বছর
                                                <span class="required">*</span></label>
                                            <div class="col-md-8">
                                                <select name="academicQualification[hsc][passing_year]"
                                                        id="hsc_passing_year" class="select2">
                                                    <option value=""></option>
                                                    @for($i = now()->format('Y') - 50; $i <= now()->format('Y'); $i++)
                                                        <option
                                                            value="{{ $i }}" {{ old('academicQualification.hsc.passing_year') == $i ? 'selected' : '' }}>{{ $i }}</option>
                                                    @endfor
                                                </select>
                                            </div>
                                            <div class="col-md-4"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 academic-qualification-graduation mb-2">
                                <div class="card col-md-12 custom-bg-gradient-info" style="height: 100%;">
                                    <div class="card-header">
                                        <h3 class="card-title text-primary d-inline-flex">স্নাতক লেভেল (পাস)</h3>
                                    </div>
                                    <div class="card-body graduation_collapse hide">
                                        <input type="hidden"
                                               name="academicQualification[graduation][examination]"
                                               value="{{ \Module\CourseManagement\App\Models\YouthAcademicQualification::EXAMINATION_GRADUATION }}">

                                        <div class="form-row form-group">
                                            <label for="graduation_examination_name"
                                                   class="col-md-4 col-form-label">পরীক্ষা<span
                                                    class="required">*</span></label>
                                            <div class="col-md-8">
                                                <select
                                                    name="academicQualification[graduation][examination_name]"
                                                    id="graduation_examination_name" class="select2">
                                                    <option value=""></option>
                                                    @foreach(\Module\CourseManagement\App\Models\YouthAcademicQualification::getGraduationExaminationOptions() as $key => $value)
                                                        <option
                                                            value="{{ $key }}" {{ old('academicQualification.graduation.examination_name') == $key ? 'selected' : '' }}>{{ $value }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-4"></div>
                                        </div>

                                        <div class="form-row form-group mt-2">
                                            <label for="graduation_subject" class="col-md-4 col-form-label">বিষয়/ডিগ্রি<span
                                                    class="required">*</span></label>
                                            <div class="col-md-8">
                                                <input type="text"
                                                       name="academicQualification[graduation][subject]"
                                                       id="graduation_subject" class="form-control"
                                                       value="{{ old('academicQualification.graduation.subject')}}">
                                            </div>
                                            <div class="col-md-4"></div>
                                        </div>

                                        <div class="form-row form-group mt-2">
                                            <label for="graduation_institute" class="col-md-4 col-form-label">প্রতিষ্ঠান/বিশ্ববিদ্যালয়<span
                                                    class="required">*</span></label>
                                            <div class="col-md-8">
                                                <select name="academicQualification[graduation][institute]"
                                                        id="graduation_institute"
                                                        class="select2">
                                                    <option value=""></option>
                                                    @foreach(\Module\CourseManagement\App\Models\YouthAcademicQualification::getUniversities() as $key => $value)
                                                        <option
                                                            value="{{ $key }}" {{ old('academicQualification.graduation.institute') == $key ? 'selected' : '' }}>{{ __($value) }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-4"></div>
                                        </div>


                                        <div class="form-row form-group mt-2">
                                            <label for="graduation_result"
                                                   class="col-md-4 col-form-label">ফলাফল<span
                                                    class="required">*</span></label>
                                            <div class="col-md-8" id="graduation_result_div">
                                                <select name="academicQualification[graduation][result]"
                                                        id="graduation_result"
                                                        class="select2">
                                                    <option value=""></option>
                                                    @foreach(\Module\CourseManagement\App\Models\YouthAcademicQualification::getExaminationResultOptions() as $key => $value)
                                                        <option
                                                            value="{{ $key }}" {{ old('academicQualification.graduation.result') == $key ? 'selected' : '' }}>{{ $value }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="" id="graduation_cgpa_div">
                                                <input type="number"
                                                       name="academicQualification[graduation][grade]"
                                                       id="graduation_cgpa"
                                                       class="form-control" width="10" placeholder="সি.জি.পি.এ"
                                                       value="{{ old('academicQualification.graduation.grade')}}"
                                                       hidden>
                                            </div>
                                            <div class="col-md-4"></div>
                                        </div>

                                        <div class="form-row form-group mt-2">
                                            <label for="graduation_passing_year"
                                                   class="col-md-4 col-form-label">
                                                পাসের বছর<span class="required">*</span></label>
                                            <div class="col-md-8">
                                                <select name="academicQualification[graduation][passing_year]"
                                                        id="graduation_passing_year" class="select2">
                                                    <option></option>
                                                    @for($i = now()->format('Y') - 50; $i <= now()->format('Y'); $i++)
                                                        <option
                                                            value="{{ $i }}" {{ old('academicQualification.graduation.passing_year') == $i ? 'selected' : '' }}>{{ $i }}</option>
                                                    @endfor
                                                </select>
                                            </div>
                                            <div class="col-md-4"></div>
                                        </div>

                                        <div class="form-row form-group mt-2">
                                            <label for="graduation_course_duration"
                                                   class="col-md-4 col-form-label">
                                                কোর্স সময়কাল<span class="required">*</span></label>
                                            <div class="col-md-8">
                                                <select
                                                    name="academicQualification[graduation][course_duration]"
                                                    id="graduation_course_duration" class="select2">
                                                    <option></option>
                                                    @foreach(\Module\CourseManagement\App\Models\YouthAcademicQualification::getExaminationCourseDurationOptions() as $key => $value)
                                                        <option
                                                            value="{{ $key }}" {{ old('academicQualification.graduation.course_duration') == $key ? 'selected' : '' }}>{{ $value }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-4"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 academic-qualification-masters mb-2">
                                <div class="card col-md-12 custom-bg-gradient-info" style="height: 100%;">
                                    <div class="card-header">
                                        <h3 class="card-title text-primary d-inline-flex">স্নাতকোত্তর লেভেল (পাস) </h3>
                                    </div>
                                    <div class="card-body masters_collapse {{--collapse--}} hide">
                                        <input type="hidden" name="academicQualification[masters][examination]"
                                               value="{{ \Module\CourseManagement\App\Models\YouthAcademicQualification::EXAMINATION_MASTERS }}">
                                        <div class="form-row form-group">
                                            <label for="masters_examination_name"
                                                   class="col-md-4 col-form-label">পরীক্ষা<span
                                                    class="required">*</span></label>
                                            <div class="col-md-8">
                                                <select name="academicQualification[masters][examination_name]"
                                                        id="masters_examination_name" class="select2">
                                                    <option></option>
                                                    @foreach(\Module\CourseManagement\App\Models\YouthAcademicQualification::getMastersExaminationOptions() as $key => $value)
                                                        <option
                                                            value="{{ $key }}" {{ old('academicQualification.masters.examination_name') == $key ? 'selected' : '' }}>{{ $value }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-4"></div>
                                        </div>

                                        <div class="form-row form-group mt-2">
                                            <label for="masters_subject"
                                                   class="col-md-4 col-form-label">বিষয়/ডিগ্রি<span
                                                    class="required">*</span></label>
                                            <div class="col-md-8">
                                                <input type="text"
                                                       name="academicQualification[masters][subject]"
                                                       id="masters_subject"
                                                       class="form-control" {{ old('academicQualification.masters.subject') }}>
                                            </div>
                                            <div class="col-md-4"></div>
                                        </div>

                                        <div class="form-row form-group mt-2">
                                            <label for="masters_institute" class="col-md-4 col-form-label">প্রতিষ্ঠান/বিশ্ববিদ্যালয়<span
                                                    class="required">*</span></label>
                                            <div class="col-md-8">
                                                <select name="academicQualification[masters][institute]"
                                                        id="masters_institute" class="select2">
                                                    <option value=""></option>
                                                    @foreach(\Module\CourseManagement\App\Models\YouthAcademicQualification::getUniversities() as $key => $value)
                                                        <option
                                                            value="{{ $key }}" {{ old('academicQualification.masters.institute') == $key ? 'selected' : '' }}>{{ __($value) }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-4"></div>
                                        </div>


                                        <div class="form-row form-group mt-2">
                                            <label for="masters_result"
                                                   class="col-md-4 col-form-label">ফলাফল<span
                                                    class="required">*</span></label>
                                            <div class="col-md-8" id="masters_result_div">
                                                <select name="academicQualification[masters][result]"
                                                        id="masters_result"
                                                        class="select2">
                                                    <option></option>
                                                    @foreach(\Module\CourseManagement\App\Models\YouthAcademicQualification::getExaminationResultOptions() as $key => $value)
                                                        <option
                                                            value="{{ $key }}" {{ old('academicQualification.masters.result') == $key ? 'selected' : '' }}>{{ $value  }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="" id="masters_cgpa_div">
                                                <input type="number"
                                                       name="academicQualification[masters][grade]"
                                                       id="masters_cgpa"
                                                       class="form-control" width="10" placeholder="সি.জি.পি.এ"
                                                       value="{{ old('academicQualification.masters.grade') }}"
                                                       hidden>
                                            </div>
                                            <div class="col-md-4"></div>
                                        </div>

                                        <div class="form-row form-group mt-2">
                                            <label for="masters_passing_year" class="col-md-4 col-form-label">
                                                পাসের বছর<span class="required">*</span></label>
                                            <div class="col-md-8">
                                                <select name="academicQualification[masters][passing_year]"
                                                        class="select2" id="masters_passing_year">
                                                    <option></option>
                                                    @for($i = now()->format('Y') - 50; $i <= now()->format('Y'); $i++)
                                                        <option
                                                            value="{{ $i }}" {{ old('academicQualification.masters.passing_year') == $i ? 'selected' : '' }}>{{ $i }}</option>
                                                    @endfor
                                                </select>
                                            </div>
                                            <div class="col-md-4"></div>

                                        </div>

                                        <div class="form-row form-group mt-2">
                                            <label for="masters_course_duration"
                                                   class="col-md-4 col-form-label">
                                                কোর্স সময়কাল<span class="required">*</span></label>
                                            <div class="col-md-8">
                                                <select name="academicQualification[masters][course_duration]"
                                                        id="masters_course_duration" class="select2">
                                                    <option></option>
                                                    @foreach(\Module\CourseManagement\App\Models\YouthAcademicQualification::getExaminationCourseDurationOptions() as $key => $value)
                                                        <option
                                                            value="{{ $key }}" {{ old('academicQualification.masters.course_duration') == $key ? 'selected' : '' }}>{{ $value }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-4"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-12 occupation-information">
                    <div class="card">
                        <div class="card-header custom-bg-gradient-info">
                            <h3 class="card-title font-weight-bold text-primary"><i
                                    class="fa fa-address-book fa-fw"> </i> পেশাগত তথ্য</h3>
                        </div>
                        <div class="card-body">
                            <div class="form-row">
                                <div class="col-md-4 mb-2">
                                    <label for="main_occupation">প্রধান পেশা</label>
                                    <input type="text" name="main_occupation" class="form-control"
                                           value="{{ old('main_occupation') }}">
                                </div>

                                <div class="col-md-4 mb-2">
                                    <label for="other_occupation">অন্যান্য পেশা</label>
                                    <input type="text" name="other_occupations" class="form-control"
                                           value="{{ old('other_occupations') }}">
                                </div>

                                <div class="col-md-4 mb-2">
                                    <label for="personal_monthly_income">মাসিক আয়</label>
                                    <input type="number" name="personal_monthly_income" class="form-control"
                                           value="{{ old('personal_monthly_income') }}">
                                </div>

                                <div class="col-md-4 mb-2">
                                    <label for="year_of_experience">অভিজ্ঞতার বছর</label>
                                    <input type="number" name="year_of_experience" class="form-control"
                                           value="{{ old('year_of_experience') }}">
                                </div>

                                <div class="col-md-4 mb-2">
                                    <div class="form-group">
                                        <label for="current_employment_status">বর্তমানে
                                            কর্মরত? <span class="required">*</span></label>
                                        <div class="form-control">
                                            <div class="input-group">
                                                <div class="custom-control custom-radio d-inline-block mr-3">
                                                    <input type="radio" name="current_employment_status"
                                                           class="custom-control-input"
                                                           value="{{ \Module\CourseManagement\App\Models\YouthRegistration::CURRENT_EMPLOYMENT_STATUS_YES }}"
                                                           id="currently_employed_yes" {{ old('current_employment_status') == \Module\CourseManagement\App\Models\YouthRegistration::CURRENT_EMPLOYMENT_STATUS_YES ? 'checked' : '' }}>
                                                    <label class="custom-control-label"
                                                           for="currently_employed_yes">হ্যাঁ</label>
                                                </div>
                                                <div class="custom-control custom-radio d-inline-block mr-3">
                                                    <input type="radio" name="current_employment_status"
                                                           class="custom-control-input"
                                                           value="{{ \Module\CourseManagement\App\Models\YouthRegistration::CURRENT_EMPLOYMENT_STATUS_NO }}"
                                                           id="currently_employed_no" {{ old('current_employment_status') == \Module\CourseManagement\App\Models\YouthRegistration::CURRENT_EMPLOYMENT_STATUS_NO ? 'checked' : '' }}>

                                                    <label class="custom-control-label"
                                                           for="currently_employed_no">না</label>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header custom-bg-gradient-info">
                            <h3 class="card-title font-weight-bold text-primary"><i
                                    class="fa fa-address-book fa-fw"> </i> অভিভাবকের তথ্য</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="card">
                                        <div class="card-header">
                                            <h3 class="card-title font-weight-bold text-primary">পিতার তথ্য</h3>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="father_name">নাম:<span
                                                                class="required">*</span></label>
                                                        <input type="text"
                                                               name="familyMember[father][member_name_en]"
                                                               id="father_name"
                                                               value="{{ old('familyMember.father.member_name_en') }}"
                                                               class="form-control">
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="fathers_date_of_birth">জন্মতারিখ:<span
                                                                class="required">*</span></label>
                                                        <input type="text"
                                                               name="familyMember[father][date_of_birth]"
                                                               id="fathers_date_of_birth"
                                                               value="{{ old('familyMember.father.date_of_birth') }}"
                                                               class="flat-date form-control">
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="fathers_nid">এন.আই.ডি নাম্বার:</label>
                                                        <input type="text" name="familyMember[father][nid]"
                                                               id="fathers_nid"
                                                               value="{{ old('familyMember.father.nid') }}"
                                                               class="form-control">
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="fathers_mobile">মোবাইল:</label>
                                                        <input type="text" name="familyMember[father][mobile]"
                                                               id="fathers_mobile"
                                                               value="{{ old('familyMember.father.mobile') }}"
                                                               class="form-control">
                                                    </div>
                                                </div>
                                                <input type="hidden"
                                                       name="familyMember[father][relation_with_youth]"
                                                       value="Father">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card">
                                        <div class="card-header">
                                            <h3 class="card-title font-weight-bold text-primary">মাতার তথ্য</h3>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="mother_name">নাম:<span
                                                                class="required">*</span></label>
                                                        <input type="text"
                                                               name="familyMember[mother][member_name_en]"
                                                               value="{{ old('familyMember.mother.member_name_en') }}"
                                                               id="mother_name"
                                                               class="form-control">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="mothers_date_of_birth">জন্মতারিখ:<span
                                                                class="required">*</span></label>
                                                        <input type="text"
                                                               name="familyMember[mother][date_of_birth]"
                                                               id="mothers_date_of_birth"
                                                               value="{{ old('familyMember.mother.date_of_birth') }}"
                                                               class="flat-date form-control">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="mothers_nid">এন.আই.ডি নাম্বার:</label>
                                                        <input type="text" name="familyMember[mother][nid]"
                                                               id="mothers_nid"
                                                               value="{{ old('familyMember.mother.nid') }}"
                                                               class="form-control">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="mothers_mobile">মোবাইল:</label>
                                                        <input type="text" name="familyMember[mother][mobile]"
                                                               id="mothers_mobile"
                                                               value="{{ old('familyMember.mother.mobile') }}"
                                                               class="form-control">
                                                    </div>
                                                </div>
                                                <input type="hidden"
                                                       name="familyMember[mother][relation_with_youth]"
                                                       value="Mother">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 guardian-information">
                                    <div class="card">
                                        <div class="card-header">
                                            <div class="form-group">
                                                <label for="guardian"
                                                       class="font-weight-bold">অভিভাবক:<span
                                                        class="required">*</span>
                                                </label>
                                                <div class="input-group form-control">
                                                    <div class="custom-control custom-radio mr-3">
                                                        <input class="custom-control-input" type="radio"
                                                               value="{{ \Module\CourseManagement\App\Models\YouthFamilyMemberInfo::GUARDIAN_FATHER }}"
                                                               id="guardian-father"
                                                               name="guardian" {{ old('guardian') == \Module\CourseManagement\App\Models\YouthFamilyMemberInfo::GUARDIAN_FATHER ? 'checked' : ''}}>
                                                        <label for="guardian-father"
                                                               class="custom-control-label">পিতা</label>
                                                    </div>

                                                    <div class="custom-control custom-radio mr-3">
                                                        <input class="custom-control-input" type="radio"
                                                               value="{{ \Module\CourseManagement\App\Models\YouthFamilyMemberInfo::GUARDIAN_MOTHER }}"
                                                               id="guardian-mother"
                                                               name="guardian" {{ old('guardian') == \Module\CourseManagement\App\Models\YouthFamilyMemberInfo::GUARDIAN_MOTHER ? 'checked' : ''}}>
                                                        <label for="guardian-mother"
                                                               class="custom-control-label">মাতা</label>
                                                    </div>

                                                    <div class="custom-control custom-radio mr-3">
                                                        <input class="custom-control-input" type="radio"
                                                               value="{{ \Module\CourseManagement\App\Models\YouthFamilyMemberInfo::GUARDIAN_OTHER }}"
                                                               id="guardian-other"
                                                               name="guardian" {{ old('guardian') == \Module\CourseManagement\App\Models\YouthFamilyMemberInfo::GUARDIAN_OTHER ? 'checked' : ''}}>
                                                        <label for="guardian-other"
                                                               class="custom-control-label">অন্যান্য</label>
                                                    </div>
                                                </div>

                                            </div>

                                        </div>
                                        <div class="card-body guardian-info" style="display: none">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="guardian_name">অভিভাবকের নাম<span
                                                                class="required">*</span>:</label>
                                                        <input type="text"
                                                               name="familyMember[guardian][member_name_en]"
                                                               value="{{old('familyMember.guardian.member_name_en')}}"
                                                               id="guardian_name"
                                                               class="form-control">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="guardian_date_of_birth">অভিভাবকের
                                                            জন্মতারিখ<span
                                                                class="required">*</span>:</label>
                                                        <input type="text"
                                                               name="familyMember[guardian][date_of_birth]"
                                                               value="{{ old('familyMember.guardian.date_of_birth') }}"
                                                               id="guardian_date_of_birth"
                                                               class="flat-date form-control">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="guardian_nid">অভিভাবকের এন.আই.ডি নাম্বার:</label>
                                                        <input type="text"
                                                               name="familyMember[guardian][nid]"
                                                               value="{{ old('familyMember.guardian.nid]') }}"
                                                               id="guardian_nid"
                                                               class="form-control">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="guardian_mobile">অভিভাবকের মোবাইল:</label>
                                                        <input type="text"
                                                               name="familyMember[guardian][mobile]"
                                                               id="guardian_mobile"
                                                               value="{{ old('familyMember.guardian.mobile') }}"
                                                               class="form-control">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="guardian_relation_with_youth">যুবকের সাথে
                                                            সম্পর্ক<span
                                                                class="required">*</span>:</label>
                                                        <input type="text"
                                                               name="familyMember[guardian][relation_with_youth]"
                                                               id="guardian_relation_with_youth"
                                                               value="{{ old('familyMember.guardian.relation_with_youth') }}"
                                                               class="form-control">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header custom-bg-gradient-info">
                            <h3 class="card-title font-weight-bold text-primary"><i
                                    class="fa fa-address-book fa-fw"> </i> অন্যান্য তথ্য</h3>
                        </div>
                        <div class="card-body">
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <div class="custom-control custom-checkbox ml-2">
                                        <input class="custom-control-input" type="checkbox"
                                               id="have_family_own_house"
                                               name="have_family_own_house"
                                               value="{{ \Module\CourseManagement\App\Models\YouthRegistration::HAVE_FAMILY_OWN_HOUSE }}" {{ old('have_family_own_house') == \Module\CourseManagement\App\Models\YouthRegistration::HAVE_FAMILY_OWN_HOUSE ? 'selected' : '' }}>
                                        <label for="have_family_own_house" class="custom-control-label">
                                            পরিবারের নিজস্ব বাড়ি আছে?</label>
                                    </div>
                                </div>

                                <div class="form-group col-md-4">
                                    <div class="custom-control custom-checkbox ml-2">
                                        <input class="custom-control-input" type="checkbox"
                                               id="have_family_own_land"
                                               name="have_family_own_land"
                                               value="{{ \Module\CourseManagement\App\Models\YouthRegistration::HAVE_FAMILY_OWN_LAND }}" {{ old('have_family_own_land') == \Module\CourseManagement\App\Models\YouthRegistration::HAVE_FAMILY_OWN_LAND ? 'selected' : ''}}>
                                        <label for="have_family_own_land" class="custom-control-label">
                                            পরিবারের নিজস্ব জমি আছে?</label>
                                    </div>
                                </div>

                                <div class="form-group col-md-4">
                                    <div class="form-group">
                                        <label for="number_of_siblings">ভাই-বোনের সংখ্যা</label>
                                        <input type="number" class="form-control w-50" name="number_of_siblings"
                                               id="number_of_siblings" value="{{ old('number_of_siblings') }}">
                                    </div>
                                </div>

                                <div class="form-group col-md-4">
                                    <div class="custom-control custom-checkbox ml-2">
                                        <input class="custom-control-input" type="checkbox"
                                               id="recommended_by_organization"
                                               name="recommended_by_organization"
                                               value="{{ \Module\CourseManagement\App\Models\YouthRegistration::RECOMMENDED_BY_ORGANIZATION }}" {{ old('recommended_by_organization') == \Module\CourseManagement\App\Models\YouthRegistration::RECOMMENDED_BY_ORGANIZATION ? 'selected' : '' }}>
                                        <label for="recommended_by_organization" class="custom-control-label">
                                            কোন প্রতিষ্ঠান/সংস্থা দ্বারা প্রস্তাবিত?</label>
                                    </div>
                                </div>

                                <div class=" form-group col-md-4 recommended_org_name_field">
                                    <label for="recommended_org_name">প্রতিষ্ঠান/সংস্থা নাম <span
                                            class="required">*</span>:</label>
                                    <input type="text" name="recommended_org_name" id="recommended_org_name"
                                           class="form-control w-50" value="{{ old('recommended_org_name') }}">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <input type="submit" class="btn btn-primary float-right" value="আবেদন করুন">
                        </div>
                        <div class="overlay" style="display: none">
                            <i class="fas fa-2x fa-sync-alt fa-spin"></i>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

@endsection

@push('js')
    <x-generic-validation-error-toastr></x-generic-validation-error-toastr>
    <script>
        const youthRegistrationForm = $('.youthRegistrationForm');
        const GUARDIAN_INFO_OTHER = {!! \Module\CourseManagement\App\Models\YouthFamilyMemberInfo::GUARDIAN_OTHER !!};

        let applicationFormTypeData;

        $.validator.addMethod(
            "langBN",
            function (value, element) {
                let regexp = /^[\s\u0980-\u09ff]+$/i;
                let re = new RegExp(regexp);
                return this.optional(element) || re.test(value);
            },
            "Please fill this field in Bangla."
        );

        $.validator.addMethod(
            "textEnBnWithoutSpecialChar",
            function (value, element) {
                let en = /^[a-zA-Z\s'\u0980-\u09ff ]*$/i;
                let reEn = new RegExp(en);
                return this.optional(element) || reEn.test(value);
            },
            "textEnBnWithoutSpecialChar is require"
        );

        $.validator.addMethod(
            "youthPictureSize",
            function (value, element) {
                let isHeightMatched = $('.figure-img')[0].naturalHeight == 300;
                let isWidthMatched = $('.figure-img')[0].naturalWidth == 300;
                return this.optional(element) || (isHeightMatched && isWidthMatched);
            },
            "৩০০x৩০০ পিক্সেল ইমেজ আপলোড করুন",
        );

        $.validator.addMethod(
            "youthSignatureSize",
            function (value, element) {
                let isHeightMatched = $('.loading-img')[0].naturalHeight == 80;
                let isWidthMatched = $('.loading-img')[0].naturalWidth == 300;
                return this.optional(element) || (isHeightMatched && isWidthMatched);
            },
            "৩০০x৮০ পিক্সেল ইমেজ আপলোড করুন",
        );

        $.validator.addMethod(
            "nidBn",
            function (value, element) {
                let regexp = /^([০-৯]{10}|[০-৯]{14}|[০-৯]{17})$/i;
                let regexp1 = /^(\d{10}|\d{14}|\d{17})$/i;
                let re = new RegExp(regexp);
                let re1 = new RegExp(regexp1);
                return this.optional(element) || re.test(value) || re1.test(value);
            },
            "সঠিক এন.আই.ডি ব্যবহার করুন [শুধুমাত্র ১০/১৪/১৭ সংখ্যার এন.আই.ডি প্রদান করুন] "
        );

        $.validator.addMethod(
            "houseOrRoadNumber",
            function (value, element) {
                let en = /^[a-zA-Z0-9\s'\u0980-\u09ff\n\r ,./।-]*$/i;
                let reEn = new RegExp(en);
                return this.optional(element) || reEn.test(value);
            },
            "addressWithoutSpecialChar is require"
        );
        $.validator.addMethod(
            "birthRegNo",
            function (value, element) {
                let en = /^[0-9]*$/i;
                let bn = /^[০-৯]*$/i;
                let reEn = new RegExp(en);
                let reBn = new RegExp(bn);
                return this.optional(element) || reEn.test(value) || reBn.test(value);
            },
            "birthOrPassport is true"
        );

        $.validator.addMethod(
            "passport",
            function (value, element) {
                let en = /^[0-9a-zA-Z]*$/i;
                let reEn = new RegExp(en);
                return this.optional(element) || reEn.test(value);
            },
            "birthOrPassport is true"
        );

        $.validator.addMethod(
            "villageName",
            function (value, element) {
                let regexp = /^[a-zA-Z0-9$@$!%*?&#()[/{}^-_. +]+$/i;
                let regexp1 = /^[\s-'\u0980-\u09ff!@#$%^&*)(+=._-]{1,255}$/i;
                let re = new RegExp(regexp);
                let re1 = new RegExp(regexp1);
                return this.optional(element) || re.test(value) || re1.test(value);
            },
            "Please input valid information"
        );

        $.validator.addMethod(
            "mobileValidation",
            function (value, element) {
                let regexp1 = /^(?:\+88|88)?(01[3-9]\d{8})$/i;
                let regexp = /^(?:\+৮৮|৮৮)?(০১[৩-৯][০-৯]{8})$/i;
                let re = new RegExp(regexp);
                let re1 = new RegExp(regexp1);
                return this.optional(element) || re.test(value) || re1.test(value);
            },
            "আপনার সঠিক মোবাইল নাম্বার লিখুন"
        );

        youthRegistrationForm.validate({
            errorElement: "em",
            onkeyup: false,
            errorPlacement: function (error, element) {
                error.addClass("help-block");
                element.parents(".form-group").addClass("has-feedback");

                if (element.parents(".form-group").length) {
                    error.insertAfter(element.parents(".form-group").first().children().last());
                } else if (element.hasClass('select2') || element.hasClass('select2-ajax-custom') || element.hasClass('select2-ajax')) {
                    error.insertAfter(element.parents(".form-group").first().find('.select2-container'));
                } else {
                    error.insertAfter(element);
                }
            },
            highlight: function (element, errorClass, validClass) {
                $(element).parents(".form-group").addClass("has-error").removeClass("has-success");
                $(element).closest('.help-block').remove();
            },
            unhighlight: function (element, errorClass, validClass) {
                $(element).parents(".form-group").addClass("has-success").removeClass("has-error");
            },
            rules: {
                name_en: {
                    required: true,
                    pattern: /^[a-zA-Z0-9 ]*$/,
                    maxlength: 30,
                },
                name_bn: {
                    required: true,
                    pattern: /^[\s'\u0980-\u09ff]+$/,
                    maxlength: 30,
                },
                number_of_siblings: {
                    max: 99,
                },
                father_name: {
                    required: true,
                },
                mother_name: {
                    required: true,
                },
                mobile: {
                    required: true,
                    //pattern: /^(?:\+88|88)?(01[3-9]\d{8})$/,
                    mobileValidation: true,
                },
                email: {
                    required: true,
                    pattern: /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/,
                    remote: "{!! route('course_management::youth.check-unique-email') !!}",
                },
                institute_id: {
                    required: true,
                },
                publish_course_id: {
                    required: true,
                },
                gender: {
                    required: true,
                },
                religion: {
                    required: true,
                },
                nationality: {
                    required: true,
                },
                date_of_birth: {
                    required: true,
                },
                marital_status: {
                    required: true,
                },
                freedom_fighter_status: {
                    required: function () {
                        return $('.freedom-fighter-status-information').css('display') == 'block';
                    },
                },
                disable_status: {
                    required: function () {
                        return $('.physical-disability-information').css('display') == 'block';
                    },
                },
                physical_disabilities: {
                    required: function () {
                        return $("input[name = 'disable_status']:checked").val() == {!! \Module\CourseManagement\App\Models\YouthFamilyMemberInfo::PHYSICALLY_DISABLE_YES !!};
                    }
                },
                nid: {
                    required: function () {
                        return $('#passport_number').val() == "" && $('#birth_certificate_no').val() == "";
                    },
                    nidBn: true,
                    remote: "{!! route('course_management::youth.check-unique-nid') !!}",

                },
                birth_certificate_no: {
                    required: function () {
                        return $('#passport_number').val() == "" && $('#nid').val() == "";
                    },
                    birthRegNo: true,
                    remote: "{!! route('course_management::youth.check-unique-birth_certificate_no') !!}"
                },
                passport_number: {
                    required: function () {
                        return $('#birth_certificate_no').val() == "" && $('#nid').val() == "";
                    },
                    passport: true,
                    remote: "{!! route('course_management::youth.check-unique-passport-no') !!}"
                },

                student_pic: {
                    required: true,
                    accept: "image/*",
                    youthPictureSize: true,
                },

                student_signature_pic: {
                    required: true,
                    accept: "image/*",
                    youthSignatureSize: true,
                },

                "academicQualification[jsc][examination_name]": {
                    required: function () {
                        return !!applicationFormTypeData?.jsc;
                    },
                },
                "academicQualification[jsc][board]": {
                    required: function () {
                        return !!applicationFormTypeData?.jsc;
                    },
                },
                "academicQualification[jsc][roll_no]": {
                    required: function () {
                        return !!applicationFormTypeData?.jsc;
                    },
                    pattern: "^[1-9]\\d*$",
                },

                "academicQualification[jsc][reg_no]": {
                    required: function () {
                        return !!applicationFormTypeData?.jsc;
                    },
                    pattern: "^[1-9]\\d*$",
                },
                "academicQualification[jsc][result]": {
                    required: function () {
                        return !!applicationFormTypeData?.jsc;
                    },
                },
                "academicQualification[jsc][group]": {
                    required: function () {
                        return !!applicationFormTypeData?.jsc;
                    },
                },
                "academicQualification[jsc][passing_year]": {
                    required: function () {
                        return !!applicationFormTypeData?.jsc;
                    },
                },
                "academicQualification[jsc][grade]": {
                    required: function () {
                        return !!applicationFormTypeData?.jsc;
                    },
                    min: 1,
                    max: 5
                },

                "academicQualification[ssc][examination_name]": {
                    required: function () {
                        return !!applicationFormTypeData?.ssc;
                    },
                },
                "academicQualification[ssc][board]": {
                    required: function () {
                        return !!applicationFormTypeData?.ssc;
                    },
                },
                "academicQualification[ssc][roll_no]": {
                    required: function () {
                        return !!applicationFormTypeData?.ssc;
                    },
                    pattern: "^[1-9]\\d*$",
                },

                "academicQualification[ssc][reg_no]": {
                    required: function () {
                        return !!applicationFormTypeData?.ssc;
                    },
                    pattern: "^[1-9]\\d*$",
                },
                "academicQualification[ssc][result]": {
                    required: function () {
                        return !!applicationFormTypeData?.ssc;
                    },
                },
                "academicQualification[ssc][group]": {
                    required: function () {
                        return !!applicationFormTypeData?.ssc;
                    },
                },
                "academicQualification[ssc][passing_year]": {
                    required: function () {
                        return !!applicationFormTypeData?.ssc;
                    },
                },
                "academicQualification[ssc][grade]": {
                    required: function () {
                        return !$('#ssc_gpa').prop('hidden') && !!applicationFormTypeData?.ssc;
                    },
                    min: 1,
                    max: function () {
                        if ($('#ssc_result').val() == {!! \Module\CourseManagement\App\Models\YouthAcademicQualification::EXAMINATION_RESULT_GPA_OUT_OF_FOUR !!}) {
                            return 4
                        }
                        if ($('#ssc_result').val() == {!! \Module\CourseManagement\App\Models\YouthAcademicQualification::EXAMINATION_RESULT_GPA_OUT_OF_FIVE !!}) {
                            return 5;
                        }
                    },
                },

                "academicQualification[hsc][examination_name]": {
                    required: function () {
                        return !!applicationFormTypeData?.hsc;
                    },
                },
                "academicQualification[hsc][board]": {
                    required: function () {
                        return !!applicationFormTypeData?.hsc;
                    },
                },

                "academicQualification[hsc][roll_no]": {
                    required: function () {
                        return !!applicationFormTypeData?.hsc;
                    },
                    pattern: "^[1-9]\\d*$",
                },
                "academicQualification[hsc][reg_no]": {
                    required: function () {
                        return !!applicationFormTypeData?.hsc;
                    },
                    pattern: "^[1-9]\\d*$",
                },
                "academicQualification[hsc][group]": {
                    required: function () {
                        return !!applicationFormTypeData?.hsc;
                    },
                },
                "academicQualification[hsc][passing_year]": {
                    required: function () {
                        return !!applicationFormTypeData?.hsc;
                    },
                },
                "academicQualification[hsc][result]": {
                    required: function () {
                        return !!applicationFormTypeData?.hsc;
                    },
                },
                "academicQualification[hsc][grade]": {
                    required: function () {
                        return !$('#hsc_gpa').prop('hidden') && !!applicationFormTypeData?.hsc;
                    },
                    min: 1,
                    max: function () {
                        if ($('#hsc_result').val() == {!! \Module\CourseManagement\App\Models\YouthAcademicQualification::EXAMINATION_RESULT_GPA_OUT_OF_FOUR !!}) {
                            return 4
                        }
                        if ($('#hsc_result').val() == {!! \Module\CourseManagement\App\Models\YouthAcademicQualification::EXAMINATION_RESULT_GPA_OUT_OF_FIVE !!}) {
                            return 5;
                        }
                    },
                },
                "academicQualification[graduation][examination_name]": {
                    required: function () {
                        return !!applicationFormTypeData?.honors;
                    },
                },

                "academicQualification[graduation][institute]": {
                    required: function () {
                        return !!applicationFormTypeData?.honors;
                    },
                },

                "academicQualification[graduation][subject]": {
                    required: function () {
                        return !!applicationFormTypeData?.honors;
                    },
                },

                "academicQualification[graduation][result]": {
                    required: function () {
                        return !!applicationFormTypeData?.honors;
                    },
                },


                "academicQualification[graduation][grade]": {
                    required: function () {
                        return !$('#graduation_cgpa').prop('hidden') && !!applicationFormTypeData?.honors;
                    },
                    min: 1,
                    max: function () {
                        if ($('#graduation_result').val() == {!! \Module\CourseManagement\App\Models\YouthAcademicQualification::EXAMINATION_RESULT_GPA_OUT_OF_FOUR !!}) {
                            return 4
                        }
                        if ($('#graduation_result').val() == {!! \Module\CourseManagement\App\Models\YouthAcademicQualification::EXAMINATION_RESULT_GPA_OUT_OF_FIVE !!}) {
                            return 5;
                        }
                    },
                },
                "academicQualification[graduation][passing_year]": {
                    required: function () {
                        return !!applicationFormTypeData?.honors;
                    },
                },
                "academicQualification[graduation][course_duration]": {
                    required: function () {
                        return !!applicationFormTypeData?.honors;
                    },
                },

                "academicQualification[masters][examination_name]": {
                    required: function () {
                        return !!applicationFormTypeData?.masters;
                    },
                },
                "academicQualification[masters][institute]": {
                    required: function () {
                        return !!applicationFormTypeData?.masters;
                    },
                },
                "academicQualification[masters][subject]": {
                    required: function () {
                        return !!applicationFormTypeData?.masters;
                    },
                },
                "academicQualification[masters][result]": {
                    required: function () {
                        return !!applicationFormTypeData?.masters;
                    },
                },
                "academicQualification[masters][grade]": {
                    required: function () {
                        return !$('#masters_cgpa').prop('hidden') && !!applicationFormTypeData?.masters;
                    },
                    min: 1,
                    max: function () {
                        if ($('#masters_result').val() == {!! \Module\CourseManagement\App\Models\YouthAcademicQualification::EXAMINATION_RESULT_GPA_OUT_OF_FOUR !!}) {
                            return 4
                        }
                        if ($('#masters_result').val() == {!! \Module\CourseManagement\App\Models\YouthAcademicQualification::EXAMINATION_RESULT_GPA_OUT_OF_FIVE !!}) {
                            return 5;
                        }
                    },
                },
                "academicQualification[masters][passing_year]": {
                    required: function () {
                        return !!applicationFormTypeData?.masters;
                    },
                },
                "academicQualification[masters][course_duration]": {
                    required: function () {
                        return !!applicationFormTypeData?.masters;
                    },
                },

                "address[present][present_address_division_id]": {
                    required: true,
                },
                "address[present][present_address_district_id]": {
                    required: true,
                },
                "address[present][present_address_upazila_id]": {
                    required: true,
                },
                "address[present][present_address_house_address][postal_code]": {
                    required: true,
                    textEnBnWithoutSpecialChar: true,
                    maxlength: 50,
                },
                "address[present][present_address_house_address][village_name]": {
                    required: true,
                    textEnBnWithoutSpecialChar: true,
                    maxlength: 50,

                },
                "address[present][present_address_house_address][house_and_road]": {
                    required: true,
                    houseOrRoadNumber: true,
                    maxlength: 50,
                },
                "address[permanent][permanent_address_division_id]": {
                    required: true,
                },
                "address[permanent][permanent_address_district_id]": {
                    required: true,
                },
                "address[permanent][permanent_address_upazila_id]": {
                    required: true,
                },
                "address[permanent][permanent_address_house_address][postal_code]": {
                    required: true,
                    textEnBnWithoutSpecialChar: true,
                    maxlength: 50,
                },
                "address[permanent][permanent_address_house_address][village_name]": {
                    required: true,
                    textEnBnWithoutSpecialChar: true,
                    maxlength: 50,
                },
                "address[permanent][permanent_address_house_address][house_and_road]": {
                    required: true,
                    houseOrRoadNumber: true,
                    maxlength: 50,
                },
                ethnic_group: {
                    required: function () {
                        return $('.ethnic-group-information').css('display') == 'block';
                    },
                },
                "familyMember[father][member_name_en]": {
                    required: true,
                    textEnBnWithoutSpecialChar: true,
                },
                "familyMember[father][nid]": {
                    nidBn: true,
                },
                "familyMember[father][mobile]": {
                    mobileValidation: true,
                },
                "familyMember[father][date_of_birth]": {
                    required: true,
                },
                "familyMember[mother][member_name_en]": {
                    required: true,
                    textEnBnWithoutSpecialChar: true,
                },
                "familyMember[mother][nid]": {
                    nidBn: true,
                },
                "familyMember[mother][mobile]": {
                    mobileValidation: true,
                },
                "familyMember[mother][date_of_birth]": {
                    required: true,
                },
                guardian: {
                    required: function () {
                        return $(".guardian-information").css('display') == 'block';
                    }
                },
                "familyMember[guardian][member_name_en]": {
                    required: function () {
                        return $("input[name = 'guardian']:checked").val() == {!! \Module\CourseManagement\App\Models\YouthFamilyMemberInfo::GUARDIAN_OTHER !!};
                    },
                    textEnBnWithoutSpecialChar: true,
                },
                "familyMember[guardian][date_of_birth]": {
                    required: function () {
                        return $("input[name = 'guardian']:checked").val() == {!! \Module\CourseManagement\App\Models\YouthFamilyMemberInfo::GUARDIAN_OTHER !!};
                    }
                },
                "familyMember[guardian][mobile]": {
                    mobileValidation: true,
                },
                "familyMember[guardian][relation_with_youth]": {
                    required: function () {
                        return $("input[name = 'guardian']:checked").val() == {!! \Module\CourseManagement\App\Models\YouthFamilyMemberInfo::GUARDIAN_OTHER !!};
                    }
                },
                "familyMember[guardian][nid]": {
                    nidBn: true,
                },

                current_employment_status: {
                    required: function () {
                        return $('.occupation-information').css('display') == 'block';
                    },
                },
                recommended_org_name: {
                    required: function (value) {
                        return $('#recommended_by_organization').prop('checked') == true;
                    }
                },
                year_of_experience: {
                    number: true,
                },
            },
            messages: {
                name_en: {
                    required: "এখানে আপনার নাম ইংরেজিতে লিখুন",
                    pattern: "এখানে আপনার সঠিক নামটি ইংরেজিতে লিখুন",
                    maxlength: "এখানে সর্বোচ্চ ৩০ টির অক্ষর লিখবেন",
                },
                name_bn: {
                    required: "এখানে আপনার নাম বাংলায় লিখুন",
                    pattern: "এখানে আপনার সঠিক নামটি বাংলায় লিখুন",
                    maxlength: "এখানে সর্বোচ্চ ৩০ টির অক্ষর লিখবেন",
                },
                mobile: {
                    required: "এখানে আপনার মোবাইল নাম্বারটি দিন",
                },
                gender: {
                    required: "লিঙ্গ নির্বাচন করুন",
                },
                religion: {
                    required: "আপনার ধর্ম নির্বাচন করুন",
                },
                marital_status: {
                    required: "আপনার বৈবাহিক অবস্থা  নির্বাচন করুন",
                },
                nationality: {
                    required: "আপনার জাতীয়তা প্রদান করুন",
                },
                nid: {
                    required: "এখানে এনআইডি নাম্বার প্রদান করুন",
                },
                birth_certificate_no: {
                    required: "এখানে জন্ম সনদ নাম্বার প্রদান করুন",
                    birthRegNo: "এখানে আপনার সঠিক জন্ম সনদ নাম্বার লিখুন ",
                },
                passport_number: {
                    required: "এখানে পাসপোর্ট নাম্বার প্রদান করুন",
                    passport: "এখানে আপনার সঠিক পাসপোর্ট নাম্বার লিখুন ",
                },
                email: {
                    required: "এখানে আপনার ই-মেইল এড্রেস লিখুন।",
                    pattern: "এখানে আপনার সঠিক ই-মেইল এড্রেস লিখুন",
                    email: "এখানে আপনার সঠিক ই-মেইল এড্রেস লিখুন",
                },
                institute_id: {
                    required: "একটি ইনস্টিটিউট সিলেক্ট করুন",
                },
                publish_course_id: {
                    required: "একটি কোর্সে সিলেক্ট করুন",
                },
                disable_status: {
                    required: "যেকোনো একটি সিলেক্ট  করুন",
                },
                ethnic_group: {
                    required: "যেকোনো একটি সিলেক্ট  করুন",
                },
                freedom_fighter_status: {
                    required: "মুক্তিযোদ্ধা তথ্য সিলেক্ট  করুন",
                },
                date_of_birth: {
                    required: "এখানে আপনার জন্ম তারিখ দিন",
                },
                student_pic: {
                    required: "এখানে আপনার ছবি যুক্ত করুন",
                    accept: "এখানে বৈধ ছবি যুক্ত করুন",
                    //youthPictureSize: "৩০০x৩০০ পিক্সেল ছবি উপলোড করুন",
                },
                student_signature_pic: {
                    required: "এখানে আপনার সাক্ষর যুক্ত করুন",
                    accept: "এখানে বৈধ ছবি যুক্ত করুন",
                    //youthSignatureSize: "৩০০x৮০ পিক্সেল ছবি উপলোড করুন",
                },
                "address[present][present_address_division_id]": {
                    required: "বিভাগ নির্বাচন করুন",
                },
                "address[present][present_address_district_id]": {
                    required: "জেলা নির্বাচন করুন",
                },
                "address[present][present_address_upazila_id]": {
                    required: "উপজেলা/থানা নির্বাচন করুন",
                },

                "address[present][present_address_house_address][postal_code]": {
                    required: "এখানে ডাকঘর প্রদান করুন",
                    textEnBnWithoutSpecialChar: "এখানে সঠিক ডাকঘর প্রদান করুন",
                    maxlength: "এখানে ৫০ এর চেয়ে কম বা সমান একটি মান লিখুন।"
                },

                "address[present][present_address_house_address][village_name]": {
                    required: "এখানে গ্রাম/মহল্লা/এলাকা প্রদান করুন",
                    textEnBnWithoutSpecialChar: "এখানে সঠিক গ্রাম/মহল্লা/এলাকা প্রদান করুন",
                    maxlength: "এখানে ৫০ এর চেয়ে কম বা সমান একটি মান লিখুন।"
                },
                "address[present][present_address_house_address][house_and_road]": {
                    required: "এখানে বাড়ি নং/রোড প্রদান করুন",
                    houseOrRoadNumber: "এখানে সঠিক বাড়ি নং/রোড প্রদান করুন",
                    maxlength: "এখানে ৫০ এর চেয়ে কম বা সমান একটি মান লিখুন।"
                },

                "address[permanent][permanent_address_house_address][postal_code]": {
                    required: "এখানে ডাকঘর প্রদান করুন",
                    textEnBnWithoutSpecialChar: "এখানে সঠিক ডাকঘর প্রদান করুন",
                    maxlength: "এখানে ৫০ এর চেয়ে কম বা সমান একটি মান লিখুন।"
                },
                "address[permanent][permanent_address_house_address][village_name]": {
                    required: "এখানে গ্রাম/মহল্লা/এলাকা প্রদান করুন",
                    textEnBnWithoutSpecialChar: "এখানে সঠিক গ্রাম/মহল্লা/এলাকা প্রদান করুন",
                    maxlength: "এখানে ৫০ এর চেয়ে কম বা সমান একটি মান লিখুন।"
                },
                "address[permanent][permanent_address_house_address][house_and_road]": {
                    required: "এখানে বাড়ি নং/রোড প্রদান করুন",
                    houseOrRoadNumber: "এখানে সঠিক বাড়ি নং/রোড প্রদান করুন",
                    maxlength: "এখানে ৫০ এর চেয়ে কম বা সমান একটি মান লিখুন।"
                },

                "address[permanent][permanent_address_division_id]": {
                    required: "বিভাগ নির্বাচন করুন",
                },
                "address[permanent][permanent_address_district_id]": {
                    required: "জেলা নির্বাচন করুন",
                },
                "address[permanent][permanent_address_upazila_id]": {
                    required: "উপজেলা/থানা নির্বাচন করুন",
                },

                "academicQualification[jsc][examination_name]": {
                    required: "এই ঘরটি অবশ্যই পূরণ করতে হবে",
                },
                "academicQualification[ssc][examination_name]": {
                    required: "এই ঘরটি অবশ্যই পূরণ করতে হবে",
                },
                "academicQualification[hsc][examination_name]": {
                    required: "এই ঘরটি অবশ্যই পূরণ করতে হবে",
                },
                "academicQualification[graduation][examination_name]": {
                    required: "এই ঘরটি অবশ্যই পূরণ করতে হবে",
                },
                "academicQualification[masters][examination_name]": {
                    required: "এই ঘরটি অবশ্যই পূরণ করতে হবে",
                },
                "academicQualification[jsc][board]": {
                    required: "এই ঘরটি অবশ্যই পূরণ করতে হবে",
                },
                "academicQualification[ssc][board]": {
                    required: "এই ঘরটি অবশ্যই পূরণ করতে হবে",
                },
                "academicQualification[hsc][board]": {
                    required: "এই ঘরটি অবশ্যই পূরণ করতে হবে",
                },
                "academicQualification[ssc][result]": {
                    required: "এই ঘরটি অবশ্যই পূরণ করতে হবে",
                },
                "academicQualification[hsc][result]": {
                    required: "এই ঘরটি অবশ্যই পূরণ করতে হবে",
                },
                "academicQualification[graduation][result]": {
                    required: "এই ঘরটি অবশ্যই পূরণ করতে হবে",
                },
                "academicQualification[masters][result]": {
                    required: "এই ঘরটি অবশ্যই পূরণ করতে হবে",
                },

                "academicQualification[jsc][passing_year]": {
                    required: "এই ঘরটি অবশ্যই পূরণ করতে হবে",
                },
                "academicQualification[ssc][passing_year]": {
                    required: "এই ঘরটি অবশ্যই পূরণ করতে হবে",
                },
                "academicQualification[hsc][passing_year]": {
                    required: "এই ঘরটি অবশ্যই পূরণ করতে হবে",
                },
                "academicQualification[graduation][passing_year]": {
                    required: "এই ঘরটি অবশ্যই পূরণ করতে হবে",
                },
                "academicQualification[masters][passing_year]": {
                    required: "এই ঘরটি অবশ্যই পূরণ করতে হবে",
                },
                "academicQualification[jsc][grade]": {
                    required: "এই ঘরটি অবশ্যই পূরণ করতে হবে",
                    min: "সর্বনিন্ম 1.00",
                    max: "সর্বোচ্চ 5.00",
                },

                "academicQualification[ssc][grade]": {
                    required: "এই ঘরটি অবশ্যই পূরণ করতে হবে",

                    min: "সর্বনিন্ম 1.00",
                    max: function () {
                        if ($('#ssc_result').val() == {!! \Module\CourseManagement\App\Models\YouthAcademicQualification::EXAMINATION_RESULT_GPA_OUT_OF_FOUR !!}) {
                            return "সর্বোচ্চ 4.00"
                        }
                        if ($('#ssc_result').val() == {!! \Module\CourseManagement\App\Models\YouthAcademicQualification::EXAMINATION_RESULT_GPA_OUT_OF_FIVE !!}) {
                            return "সর্বোচ্চ 5.00";
                        }
                    },
                },

                "academicQualification[hsc][grade]": {
                    required: "এই ঘরটি অবশ্যই পূরণ করতে হবে",

                    min: "সর্বনিন্ম 1.00",
                    max: function () {
                        if ($('#hsc_result').val() == {!! \Module\CourseManagement\App\Models\YouthAcademicQualification::EXAMINATION_RESULT_GPA_OUT_OF_FOUR !!}) {
                            return "সর্বোচ্চ 4.00"
                        }
                        if ($('#hsc_result').val() == {!! \Module\CourseManagement\App\Models\YouthAcademicQualification::EXAMINATION_RESULT_GPA_OUT_OF_FIVE !!}) {
                            return "সর্বোচ্চ 5.00";
                        }
                    },
                },

                "academicQualification[graduation][grade]": {
                    required: "এই ঘরটি অবশ্যই পূরণ করতে হবে",

                    min: "সর্বনিন্ম 1.00",
                    max: function () {
                        if ($('#graduation_result').val() == {!! \Module\CourseManagement\App\Models\YouthAcademicQualification::EXAMINATION_RESULT_GPA_OUT_OF_FOUR !!}) {
                            return "সর্বোচ্চ 4.00"
                        }
                        if ($('#graduation_result').val() == {!! \Module\CourseManagement\App\Models\YouthAcademicQualification::EXAMINATION_RESULT_GPA_OUT_OF_FIVE !!}) {
                            return "সর্বোচ্চ 5.00";
                        }
                    },
                },

                "academicQualification[masters][grade]": {
                    required: "এই ঘরটি অবশ্যই পূরণ করতে হবে",
                    min: "সর্বনিন্ম 1.00",
                    max: function () {
                        if ($('#masters_result').val() == {!! \Module\CourseManagement\App\Models\YouthAcademicQualification::EXAMINATION_RESULT_GPA_OUT_OF_FOUR !!}) {
                            return "সর্বোচ্চ 4.00"
                        }
                        if ($('#masters_result').val() == {!! \Module\CourseManagement\App\Models\YouthAcademicQualification::EXAMINATION_RESULT_GPA_OUT_OF_FIVE !!}) {
                            return "সর্বোচ্চ 5.00";
                        }
                    },
                },

                "academicQualification[ssc][group]": {
                    required: "এই ঘরটি অবশ্যই পূরণ করতে হবে",
                },
                "academicQualification[hsc][group]": {
                    required: "এই ঘরটি অবশ্যই পূরণ করতে হবে",
                },
                "academicQualification[jsc][roll_no]": {
                    required: "এই ঘরটি অবশ্যই পূরণ করতে হবে",
                    pattern: "এখানে সঠিক রোল নাম্বার দিন"
                },
                "academicQualification[ssc][roll_no]": {
                    required: "এই ঘরটি অবশ্যই পূরণ করতে হবে",
                    pattern: "এখানে সঠিক রোল নাম্বার দিন"
                },
                "academicQualification[hsc][roll_no]": {
                    required: "এই ঘরটি অবশ্যই পূরণ করতে হবে",
                    pattern: "এখানে সঠিক রোল নাম্বার দিন"
                },
                "academicQualification[jsc][reg_no]": {
                    required: "এই ঘরটি অবশ্যই পূরণ করতে হবে",
                    pattern: "এখানে সঠিক রেজিস্ট্রেশন নাম্বার দিন"
                },
                "academicQualification[ssc][reg_no]": {
                    required: "এই ঘরটি অবশ্যই পূরণ করতে হবে",
                    pattern: "এখানে সঠিক রেজিস্ট্রেশন নাম্বার দিন"
                },
                "academicQualification[hsc][reg_no]": {
                    required: "এই ঘরটি অবশ্যই পূরণ করতে হবে",
                    pattern: "এখানে সঠিক রেজিস্ট্রেশন নাম্বার দিন"
                },
                "academicQualification[graduation][subject]": {
                    required: "এই ঘরটি অবশ্যই পূরণ করতে হবে",
                },
                "academicQualification[masters][subject]": {
                    required: "এই ঘরটি অবশ্যই পূরণ করতে হবে",
                },
                "academicQualification[graduation][institute]": {
                    required: "এই ঘরটি অবশ্যই পূরণ করতে হবে",
                },
                "academicQualification[masters][institute]": {
                    required: "এই ঘরটি অবশ্যই পূরণ করতে হবে",
                },
                "academicQualification[graduation][course_duration]": {
                    required: "এই ঘরটি অবশ্যই পূরণ করতে হবে",
                },
                "academicQualification[masters][course_duration]": {
                    required: "এই ঘরটি অবশ্যই পূরণ করতে হবে",
                },
                current_employment_status: {
                    required: "যেকোনো একটি সিলেক্ট করুন",
                },
                "familyMember[father][member_name_en]": {
                    required: "এখানে আপনার পিতার নাম লিখুন",
                    textEnBnWithoutSpecialChar: "এখানে আপনার পিতার সঠিক নাম লিখুন",
                },
                "familyMember[father][date_of_birth]": {
                    required: "এখানে আপনার পিতার জন্ম তারিখ লিখুন",
                },
                "familyMember[father][nid]": {
                    required: "এখানে আপনার পিতার এনআইডি লিখুন",
                },
                "familyMember[father][mobile]": {
                    required: "এখানে আপনার পিতার মোবাইল নাম্বার লিখুন",
                },
                "familyMember[mother][member_name_en]": {
                    required: "এখানে আপনার মাতার নাম লিখুন",
                    textEnBnWithoutSpecialChar: "এখানে আপনার মাতার সঠিক নাম লিখুন",
                },
                "familyMember[mother][date_of_birth]": {
                    required: "এখানে আপনার মাতার জন্ম তারিখ লিখুন",
                },
                "familyMember[mother][nid]": {
                    required: "এখানে আপনার মাতার এনআইডি লিখুন",
                },
                "familyMember[mother][mobile]": {
                    required: "এখানে আপনার মাতার মোবাইল নাম্বার লিখুন",
                },
                guardian: {
                    required: "আপনার অভিভাবক সিলেক্ট করুন",
                },

                "familyMember[guardian][member_name_en]": {
                    required: "এখানে আপনার অভিভাবকের নাম লিখুন",
                    textEnBnWithoutSpecialChar: "এখানে আপনার অভিভাবকের সঠিক নাম লিখুন",
                },
                "familyMember[guardian][date_of_birth]": {
                    required: "অভিভাবকের জন্মতারিখ লিখুন"
                },
                "familyMember[guardian][mobile]": {
                    required: "অভিভাবকের মোবাইল লিখুন",
                },
                "familyMember[guardian][relation_with_youth]": {
                    required: "অভিভাবকের আপনার সাথে সম্পর্ক লিখুন"
                },
                "familyMember[guardian][nid]": {
                    required: "অভিভাবকের এন.আই.ডি লিখুন"
                },
                year_of_experience: {
                    number: "সঠিক অভিজ্ঞতার বছর লিখুন"
                },
                recommended_org_name: {
                    required: "এই ঘরটি অবশ্যই পূরণ করতে হবে",
                },


            },
            submitHandler: function (htmlForm) {
                $('.overlay').show();

                // Get some values from elements on the page:
                const form = $(htmlForm);
                const formData = new FormData(htmlForm);
                const url = form.attr("action");

                // Send the data using post
                $.ajax({
                    url: url,
                    data: formData,
                    type: 'POST',
                    processData: false,
                    contentType: false,
                    success: function (response) {
                        $('.overlay').hide();
                        let alertType = response.alertType;
                        let alertMessage = response.message;
                        let alerter = toastr[alertType];
                        alerter ? alerter(alertMessage) : toastr.error("toastr alert-type " + alertType + " is unknown");

                        if (response.accessKey) {
                            window.location.href = response.redirectTo;
                        }
                    },
                });

                return false;
            }
        });

        $(document).ready(function () {
            $("#student_pic").change(async function () {
                await readURL(this); //preview image
                youthRegistrationForm.validate().element("#student_pic");
            });

            $("#student_signature_pic").change(async function () {
                await readURL(this);
                youthRegistrationForm.validate().element("#student_signature_pic");
            });
        })

        function readURL(input) {
            return new Promise(function (resolve, reject) {
                let reader = new FileReader();
                reader.onload = (e) => {
                    $("." + input.id + ' img').attr('src', e.target.result);
                    resolve(e.target.result);
                };
                reader.onerror = reject;
                reader.readAsDataURL(input.files[0]); // convert to base64 string
            });
        }

        function setFormFields(restrictedField) {
            const ON = 1;
            const OFF = 0;

            if (restrictedField.jsc === ON || restrictedField.jsc === undefined) {
                $('.jsc_collapse').parent().parent().show();
            } else {
                $('.jsc_collapse').parent().parent().hide();
            }

            if (restrictedField.ssc === ON || restrictedField.ssc === undefined) {
                $('.ssc_collapse').parent().parent().show();
            } else {
                $('.ssc_collapse').parent().parent().hide();
            }

            if (restrictedField.hsc === ON || restrictedField.hsc === undefined) {
                $('.hsc_collapse').parent().parent().show();
            } else {
                $('.hsc_collapse').parent().parent().hide();
            }

            if (restrictedField.honors === ON || restrictedField.honors === undefined) {
                $('.graduation_collapse').parent().parent().show();
            } else {
                $('.graduation_collapse').parent().parent().hide();
            }

            if (restrictedField.masters == ON || restrictedField == undefined) {
                $('.masters_collapse').parent().parent().show();
            } else {
                $('.masters_collapse').parent().parent().hide();
            }

            restrictedField.occupation === ON || restrictedField.occupation === undefined ? $('.occupation-information').show() : $('.occupation-information').hide();
            restrictedField.guardian === ON || restrictedField.guardian === undefined ? $('.guardian-information').show() : $('.guardian-information').hide();
            restrictedField.ethnic !== OFF || restrictedField.ethnic == undefined ? $('.ethnic-group-information').show() : $('.ethnic-group-information').hide();
            restrictedField.freedom_fighter !== OFF || restrictedField.freedom_fighter == undefined ? $('.freedom-fighter-status-information').show() : $('.freedom-fighter-status-information').hide();
            restrictedField.disable_status !== OFF || restrictedField.disable_status == undefined ? $('.physical-disability-information').show() : $('.physical-disability-information').hide();
        }

        function showAllFormFields() {
            $('.academic-qualification-jsc').show();
            $('.academic-qualification-ssc').show();
            $('.academic-qualification-hsc').show();
            $('.academic-qualification-graduation').show();
            $('.academic-qualification-masters').show();
            $('.occupation-information').show();
            $('.guardian-information').show();
            $('.ethnic-group-information').show()
            $('.freedom-fighter-status-information').show()
            $('.physical-disability-information').show()
        }


        const searchAPI = function ({model, columns}) {
            const config = {
                url: '{{route('web-api.model-resources')}}',
            }
            return function (filters = {}, url = null) {
                if (!config.url?.length) {
                    console.log('stop execute')
                    return false;
                }

                return $.ajax({
                    url: config.url,
                    type: "POST",
                    data: {
                        _token: '{{csrf_token()}}',
                        resource: {
                            model: model,
                            columns: columns,
                            filters
                        }
                    }
                }).done(function (response) {
                    return response;
                });
            };
        };

        const applicationFormTypeFetch = searchAPI({
            model: "{{base64_encode(\Module\CourseManagement\App\Models\ApplicationFormType::class)}}",
            columns: 'id|freedom_fighter|ethnic|disable_status|jsc|ssc|hsc|honors|masters|occupation|guardian|row_status',
        });

        const publishCourseFetch = searchAPI({
            model: "{{base64_encode(\Module\CourseManagement\App\Models\PublishCourse::class)}}",
            columns: 'id|application_form_type_id',
        });

        function getApplicationFormType(applicationFormTypeId) {
            if (!applicationFormTypeId) {
                showAllFormFields();
                return false;
            }

            let filters = {};
            filters['id'] = applicationFormTypeId;

            applicationFormTypeFetch(filters)?.then(function (response) {
                let data = response.data[0];
                applicationFormTypeData = data;
                if (data?.length <= 0) {
                    showAllFormFields();
                } else {
                    setFormFields(data);
                }
                console.log(applicationFormTypeData)
            });
        }

        function setPermanentAddressValue() {
            let present_address_division_value = $('#present_address_division_id option:selected').val();
            let present_address_division_text = $('#present_address_division_id option:selected').text();
            $('#permanent_address_division_id').append(new Option(present_address_division_text, present_address_division_value, true, true)).trigger('change');

            let present_address_district_value = $('#present_address_district_id option:selected').val();
            let present_address_district_text = $('#present_address_district_id option:selected').text();
            $('#permanent_address_district_id').append(new Option(present_address_district_text, present_address_district_value, true, true)).trigger('change');

            let present_address_upazila_value = $('#present_address_upazila_id option:selected').val();
            let present_address_upazila_text = $('#present_address_upazila_id option:selected').text();
            $('#permanent_address_upazila_id').append(new Option(present_address_upazila_text, present_address_upazila_value, true, true)).trigger('change');

            $('#permanent_address_postal_code').val($('#present_address_postal_code').val());
            $('#permanent_address_village_name').val($('#present_address_village_name').val());
            $('#permanent_address_house_and_road').val($('#present_address_house_and_road').val());
        }

        function disablePresentAddressFields() {
            $('#hidden_present_address_division_id').val($('#present_address_division_id').val()).prop('disabled', false);
            $('#present_address_division_id').prop('disabled', true);

            $('#hidden_present_address_district_id').val($('#present_address_district_id').val()).prop('disabled', false);
            $('#present_address_district_id').prop('disabled', true);

            let upazila_code = $('#present_address_upazila_id').val() != null ? $('#present_address_upazila_id').val().trim() : $('#present_address_upazila_id').val();
            $('#hidden_present_address_upazila_id').val(upazila_code).prop('disabled', false);
            $('#present_address_upazila_id').prop('disabled', true);

            $('#present_address_postal_code').prop('readonly', true);
            $('#present_address_village_name').prop('readonly', true);
            $('#present_address_house_and_road').prop('readonly', true);
        }

        function disablePermanetAddressFields() {
            $('#hidden_permanent_address_division_id').val($('#permanent_address_division_id').val()).prop('disabled', false);
            $('#permanent_address_division_id').prop('disabled', true);

            $('#hidden_permanent_address_district_id').val($('#present_address_district_id').val()).prop('disabled', false);
            $('#permanent_address_district_id').prop('disabled', true);

            $('#hidden_permanent_address_upazila_id').val($('#present_address_upazila_id').val()).prop('disabled', false);
            $('#permanent_address_upazila_id').prop('disabled', true);

            $('#permanent_address_postal_code').prop('readonly', true);
            $('#permanent_address_village_name').prop('readonly', true);
            $('#permanent_address_house_and_road').prop('readonly', true);
        }

        function enablePermanentAddressFields() {
            $("#permanent_address_division_id").val('').trigger('change');
            $('#permanent_address_division_id').prop('disabled', false);

            $('#permanent_address_district_id').prop('disabled', true);
            $('#permanent_address_upazila_id').prop('disabled', true);

            $('#permanent_address_postal_code').prop('readonly', false);
            $('#permanent_address_village_name').prop('readonly', false);
            $('#permanent_address_house_and_road').prop('readonly', false);
            // make fields empty-- cause its now not coming from present address
            $('#permanent_address_postal_code').val("");
            $('#permanent_address_village_name').val("");
            $('#permanent_address_house_and_road').val("");
        }

        function enablePresentAddressFields() {
            //also enable present address
            $('#present_address_division_id').prop('disabled', false);
            $('input[name = "present_address_division_id"]').prop('disabled', true);

            $('#present_address_district_id').prop('disabled', true);
            $('input[name = "present_address_district_id"]').prop('disabled', true);

            $('#present_address_upazila_id').prop('disabled', true);
            $('input[name = "present_address_upazila_id"]').prop('disabled', true);

            $('#present_address_postal_code').prop('readonly', false);
            $('#present_address_village_name').prop('readonly', false);
            $('#present_address_house_and_road').prop('readonly', false);
        }

        $(document).ready(function () {
            $('#physical_disabilities').parent().hide();
            let applicationFormType = {!! !empty($publishCourse) ? $publishCourse->applicationFormType: 0 !!};

            if (applicationFormType) {
                setFormFields(applicationFormType);
            }


            if ($('input[name="application_form_type_id"]').val() !== "") {
                let applicationFormTypeId = $('input[name="application_form_type_id"]').val();
                getApplicationFormType(applicationFormTypeId);
            }

            $('#publish_course_id').on('change', function () {
                let publishCourseId = $(this).val();
                console.log("publishCourseId: " + publishCourseId);
                let filters = {};
                filters['id'] = publishCourseId;

                publishCourseFetch(filters)?.then(function (response) {
                    let applicationFormTypeId = response.data[0].application_form_type_id;
                    getApplicationFormType(applicationFormTypeId);
                });

            });

            $('.recommended_org_name_field').css('visibility', 'hidden');

            $('#recommended_by_organization').on('change', function () {
                $('#recommended_by_organization').prop('checked') == true ? $('.recommended_org_name_field').css('visibility', 'visible') : $('.recommended_org_name_field').css('visibility', 'hidden');
            });


            $("input[name='disable_status']").change(function () {
                let checkedValue = $("input[name='disable_status']:checked").val();
                if (checkedValue == {!! \Module\CourseManagement\App\Models\YouthFamilyMemberInfo::PHYSICALLY_DISABLE_NOT !!}) {
                    $("#physical_disabilities").parent().hide();
                } else {
                    $("#physical_disabilities").parent().show();
                }
            });

            $('#permanent_address_same_as_present_address').on('click', function () {
                if ($(this).prop('checked')) {
                    setPermanentAddressValue();
                    disablePresentAddressFields();
                    disablePermanetAddressFields();


                    if ($('#present_address_division_id').val() != "") {
                        $('#permanent_address_division_id').valid();
                    } else {
                        $('#present_address_division_id').valid(false);
                        $('#permanent_address_division_id').valid(false);

                    }

                    if ($('#present_address_district_id').val() != "") {
                        $('#permanent_address_district_id').valid();
                    } else {
                        $('#present_address_district_id').valid(false);
                        $('#permanent_address_district_id').valid(false);
                    }

                    if ($('#present_address_upazila_id').val() != "") {
                        $('#permanent_address_upazila_id').valid();
                    } else {
                        $('#permanent_address_upazila_id').valid(false);
                    }


                    if ($('#present_address_postal_code').val() != "") {
                        $('#permanent_address_postal_code').valid();
                    } else {
                        $('#present_address_postal_code').valid(false);
                        $('#permanent_address_postal_code').valid(false);
                    }

                    if ($('#present_address_village_name').val() != "") {
                        $('#permanent_address_village_name').valid();
                    } else {
                        $('#present_address_village_name').valid(false);
                        $('#permanent_address_village_name').valid(false);
                    }

                    if ($('#present_address_house_and_road').val() != "") {
                        $('#permanent_address_house_and_road').valid();
                    } else {
                        $('#present_address_house_and_road').valid(false);
                        $('#permanent_address_house_and_road').valid(false);
                    }

                } else {
                    enablePermanentAddressFields();
                    enablePresentAddressFields();

                    if ($('#permanent_address_division_id').val() != "") {
                        $(this).valid();
                    } else {
                        $(this).valid(false);
                    }

                    if ($('#permanent_address_district_id').val() != "") {
                        $(this).valid();
                    } else {
                        $(this).valid(false);
                    }

                    if ($('#permanent_address_upazila_id').val() != "") {
                        $(this).valid();
                    } else {
                        $(this).valid(false);
                    }


                    if ($('#permanent_address_postal_code').val() != "") {
                        $(this).valid();
                    } else {
                        $(this).valid(false);
                    }

                    if ($('#permanent_address_village_name').val() != "") {
                        $(this).valid();
                    } else {
                        $(this).valid(false);
                    }

                    if ($('#permanent_address_house_and_road').val() != "") {
                        $(this).valid();
                    } else {
                        $(this).valid(false);
                    }
                }
            })

            $('.jsc_collapse').on('show.bs.collapse', function () {
                $('#jsc_examination_info').prop('checked', true);
            })

            $('.jsc_collapse').on('hide.bs.collapse', function () {
                $('#jsc_examination_info').prop('checked', false);
                $('.ssc_collapse').collapse('hide');
                $('.hsc_collapse').collapse('hide');
                $('.graduation_collapse').collapse('hide');
                $('.masters_collapse').collapse('hide');
            })

            $('.ssc_collapse').on('show.bs.collapse', function () {
                $('#ssc_examination_info').prop('checked', true);
                $('.jsc_collapse').collapse('show');
            })
            $('.ssc_collapse').on('hide.bs.collapse', function () {
                $('#ssc_examination_info').prop('checked', false);
                $('.hsc_collapse').collapse('hide');
                $('.graduation_collapse').collapse('hide');
                $('.masters_collapse').collapse('hide');
            })

            $('.hsc_collapse').on('show.bs.collapse', function () {
                $('#hsc_examination_info').prop('checked', true);
                $('.ssc_collapse').collapse('show');
                $('.jsc_collapse').collapse('show');

            })
            $('.hsc_collapse').on('hide.bs.collapse', function () {
                $('#hsc_examination_info').prop('checked', false);
                $('.graduation_collapse').collapse('hide');
                $('.masters_collapse').collapse('hide');

            })

            $('.graduation_collapse').on('show.bs.collapse', function () {
                $('#graduation_examination_info').prop('checked', true);
                $('.jsc_collapse').collapse('show');
                $('.ssc_collapse').collapse('show');
                $('.hsc_collapse').collapse('show');
            })
            $('.graduation_collapse').on('hide.bs.collapse', function () {
                $('#graduation_examination_info').prop('checked', false);
                $('.jsc_collapse').collapse('show');
                $('.masters_collapse').collapse('hide');
            })

            $('.masters_collapse').on('show.bs.collapse', function () {
                $('#masters_examination_info').prop('checked', true);
                $('.ssc_collapse').collapse('show');
                $('.hsc_collapse').collapse('show');
                $('.graduation_collapse').collapse('show');

            })
            $('.masters_collapse').on('hide.bs.collapse', function () {
                $('#masters_examination_info').prop('checked', false);
            })


            $("input[name = 'guardian']").on('change', function () {
                if ($(this).val() == {!! \Module\CourseManagement\App\Models\YouthFamilyMemberInfo::GUARDIAN_OTHER !!}) {
                    ;
                    $('.guardian-info').show(500);
                } else {
                    $('.guardian-info').hide(500);
                }
            });


            $("#ssc_result").on('change', function () {
                if ($(this).val() == {!! \Module\CourseManagement\App\Models\YouthAcademicQualification::EXAMINATION_RESULT_GPA_OUT_OF_FOUR !!}
                    || $(this).val() == {!! \Module\CourseManagement\App\Models\YouthAcademicQualification::EXAMINATION_RESULT_GPA_OUT_OF_FIVE !!}) {
                    $('#ssc_gpa').removeAttr('hidden');
                    $('#ssc_result_div').removeAttr('class');
                    $('#ssc_result_div').addClass('col-md-6');
                    $('#ssc_gpa_div').addClass('col-md-2');

                } else {
                    $('#ssc_gpa').attr('hidden', true);
                    $('#ssc_result_div').removeAttr('class');
                    $('#ssc_result_div').addClass('col-md-8');
                    $('#ssc_gpa_div').removeAttr('class');
                }
            });

            $("#hsc_result").on('change', function () {
                if ($(this).val() == {!! \Module\CourseManagement\App\Models\YouthAcademicQualification::EXAMINATION_RESULT_GPA_OUT_OF_FOUR !!}
                    || $(this).val() == {!! \Module\CourseManagement\App\Models\YouthAcademicQualification::EXAMINATION_RESULT_GPA_OUT_OF_FIVE !!}) {
                    $('#hsc_gpa').removeAttr('hidden');
                    $('#hsc_result_div').removeAttr('class');
                    $('#hsc_result_div').addClass('col-md-6');
                    $('#hsc_gpa_div').addClass('col-md-2');
                } else {
                    $('#hsc_gpa').attr('hidden', true);
                    $('#hsc_result_div').removeAttr('class');
                    $('#hsc_result_div').addClass('col-md-8');
                    $('#hsc_gpa_div').removeAttr('class');
                }
            });

            $("#graduation_result").on('change', function () {
                if ($(this).val() == {!! \Module\CourseManagement\App\Models\YouthAcademicQualification::EXAMINATION_RESULT_GPA_OUT_OF_FOUR !!}
                    || $(this).val() == {!! \Module\CourseManagement\App\Models\YouthAcademicQualification::EXAMINATION_RESULT_GPA_OUT_OF_FIVE !!}) {
                    $('#graduation_cgpa').removeAttr('hidden');

                    $('#graduation_result_div').removeAttr('class');
                    $('#graduation_result_div').addClass('col-md-6');
                    $('#graduation_cgpa_div').addClass('col-md-2');
                } else {
                    $('#graduation_cgpa').attr('hidden', true);

                    $('#graduation_result_div').removeAttr('class');
                    $('#graduation_result_div').addClass('col-md-8');
                    $('#graduation_cgpa_div').removeAttr('class');
                }
            });

            $("#masters_result").on('change', function () {
                if ($(this).val() == {!! \Module\CourseManagement\App\Models\YouthAcademicQualification::EXAMINATION_RESULT_GPA_OUT_OF_FOUR !!}
                    || $(this).val() == {!! \Module\CourseManagement\App\Models\YouthAcademicQualification::EXAMINATION_RESULT_GPA_OUT_OF_FIVE !!}) {
                    $('#masters_cgpa').removeAttr('hidden');

                    $('#masters_result_div').removeAttr('class');
                    $('#masters_result_div').addClass('col-md-6');
                    $('#masters_cgpa_div').addClass('col-md-2');
                } else {
                    $('#masters_cgpa').attr('hidden', true);

                    $('#masters_result_div').removeAttr('class');
                    $('#masters_result_div').addClass('col-md-8');
                    $('#masters_cgpa_div').removeAttr('class');
                }
            });


            $(function () {
                $('#present_address_division_id').on('change', function () {
                    if ($('#present_address_district_id').prop('disabled', true)) {
                        $('#present_address_district_id').prop('disabled', false);
                    }

                    $("#present_address_district_id").val('').trigger('change');
                    $("#present_address_upazila_id").val('').trigger('change');

                    if ($(this).val() == null || $(this).val() == "") {
                        $('#present_address_district_id').prop("disabled", true);
                        $('#present_address_upazila_id').prop("disabled", true);
                    }

                });

                $('#present_address_district_id').on('change', function () {
                    if ($('#present_address_upazila_id').prop('disabled', true)) {
                        $('#present_address_upazila_id').prop('disabled', false);
                    }

                    $("#present_address_upazila_id").val('').trigger('change');

                    if ($(this).val() == null || $(this).val() == "") {
                        $('#present_address_upazila_id').prop("disabled", true);
                    }
                });

                $('#permanent_address_division_id').on('change', function () {
                    if ($(this).val() == null || $(this).val() == "") {
                        $("#permanent_address_district_id").val('').trigger('change');
                        $("#permanent_address_upazila_id").val('').trigger('change');
                        $('#permanent_address_district_id').prop("disabled", true);
                        $('#permanent_address_upazila_id').prop("disabled", true);
                    } else {
                        $("#permanent_address_district_id").val('').trigger('change');
                        $('#permanent_address_district_id').prop("disabled", false);
                        $('#permanent_address_upazila_id').prop("disabled", true);
                    }
                });

                $('#permanent_address_district_id').on('change', function () {
                    $("#permanent_address_upazila_id").val('').trigger('change');

                    if ($(this).val() == null || $(this).val() == "") {

                        $('#permanent_address_upazila_id').prop("disabled", true);
                    } else {
                        $('#permanent_address_upazila_id').prop("disabled", false);
                    }
                });
            });
        });

        function validationCheckSelect2(n) {
            if ($(n).val() != "") {
                $(n).valid();
            } else {
                $(n).valid(false);
            }
        }


        $('#date_of_birth').on('change', function () {
            validationCheckSelect2(this);
        });
        $('#nationality').on('change', function () {
            validationCheckSelect2(this);
        });
        $('#fathers_date_of_birth').on('change', function () {
            validationCheckSelect2(this);
        });
        $('#mothers_date_of_birth').on('change', function () {
            validationCheckSelect2(this);
        });
        $('#guardian_date_of_birth').on('change', function () {
            validationCheckSelect2(this);
        });

        $('#jsc_examination_name').on('change', function () {
            validationCheckSelect2(this);
        });
        $('#jsc_board').on('change', function () {
            validationCheckSelect2(this);
        });
        $('#jsc_passing_year').on('change', function () {
            validationCheckSelect2(this);
        });

        $('#ssc_examination_name').on('change', function () {
            validationCheckSelect2(this);
        });
        $('#ssc_board').on('change', function () {
            validationCheckSelect2(this);
        });
        $('#ssc_result').on('change', function () {
            validationCheckSelect2(this);
        });
        $('#ssc_group').on('change', function () {
            validationCheckSelect2(this);
        });
        $('#ssc_passing_year').on('change', function () {
            validationCheckSelect2(this);
        });

        $('#hsc_examination_name').on('change', function () {
            validationCheckSelect2(this);
        });
        $('#hsc_board').on('change', function () {
            validationCheckSelect2(this);
        });
        $('#hsc_result').on('change', function () {
            validationCheckSelect2(this);
        });
        $('#hsc_group').on('change', function () {
            validationCheckSelect2(this);
        });
        $('#hsc_passing_year').on('change', function () {
            validationCheckSelect2(this);
        });

        $('#graduation_examination_name').on('change', function () {
            validationCheckSelect2(this);
        });
        $('#graduation_institute').on('change', function () {
            validationCheckSelect2(this);
        });
        $('#graduation_result').on('change', function () {
            validationCheckSelect2(this);
        });
        $('#graduation_passing_year').on('change', function () {
            validationCheckSelect2(this);
        });
        $('#graduation_course_duration').on('change', function () {
            validationCheckSelect2(this);
        });

        $('#masters_examination_name').on('change', function () {
            validationCheckSelect2(this);
        });
        $('#masters_institute').on('change', function () {
            validationCheckSelect2(this);
        });
        $('#masters_result').on('change', function () {
            validationCheckSelect2(this);
        });
        $('#masters_passing_year').on('change', function () {
            validationCheckSelect2(this);
        });
        $('#masters_course_duration').on('change', function () {
            validationCheckSelect2(this);
        });


        $('#freedom_fighter_status').on('change', function () {
            validationCheckSelect2(this);
        });

        $('#present_address_division_id').on('change', function () {
            validationCheckSelect2(this);
        });
        $('#present_address_district_id').on('change', function () {
            validationCheckSelect2(this);
        });
        $('#present_address_upazila_id').on('change', function () {
            validationCheckSelect2(this);
        });

        $('#permanent_address_division_id').on('change', function () {
            validationCheckSelect2(this);
        });
        $('#permanent_address_district_id').on('change', function () {
            validationCheckSelect2(this);
        });
        $('#permanent_address_upazila_id').on('change', function () {
            validationCheckSelect2(this);
        });


    </script>
@endpush

@push('css')
    <style>
        .required {
            color: red;
        }

        .form-control[readonly].flat-date {
            background-color: #fafdff;
        }
    </style>
@endpush
