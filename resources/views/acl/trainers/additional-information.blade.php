@php
    $edit = !empty($institute->id);
@endphp

@extends('master::layouts.master')

@section('title')
    {{ 'Trainer Information' }}
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-outline">
                    <div class="card-header text-primary custom-bg-gradient-info">
                        <h3 class="card-title font-weight-bold text-primary">{{ 'Trainer Information'}}</h3>
                        <div class="card-tools">
                            @can('viewAny', App\Models\User::class)
                                <a href="{{route('admin.users.trainers', $trainerInstitute->id)}}"
                                   class="btn btn-sm btn-outline-primary btn-rounded">
                                    <i class="fas fa-backward"></i> {{__('generic.back')}}
                                </a>
                            @endcan
                        </div>
                    </div>

                    <div class="card-body">
                        <form class="row edit-add-form" method="post"
                              enctype="multipart/form-data"
                              action="{{route('admin.trainer-info.store')}}">
                            @csrf
                            @if($edit)
                                @method('put')
                            @endif

                            <div class="col-md-12">
                                <div class="card card-outline">
                                    <div class="card-header text-primary custom-bg-gradient-info">
                                        <h3 class="card-title font-weight-bold text-primary">{{ 'Personal Information'}}</h3>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-row">
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="name">{{ __('Name') }}<span
                                                            style="color: red"> * </span></label>
                                                    <input type="text" class="form-control" id="name"
                                                           name="name"
                                                           value="{{ $trainer ? $trainer->name_en : old('title_en') }}"
                                                           placeholder="{{ __('Name') }}">
                                                </div>
                                            </div>

                                            <input type="hidden" name="institute_id" id="institute_id"
                                                   value="{{ $trainer->institute_id }}">
                                            <input type="hidden" name="trainer_id" id="trainer_id"
                                                   value="{{ $trainer->id }}">

                                            <div
                                                class="form-group col-md-6 {{ !empty($authYouth)? ($authYouth->email?'read-only-input-field':''):'' }}">
                                                <label for="email">ইমেইল <span class="required">*</span>
                                                    :</label>
                                                <input type="text" class="form-control" name="email" id="email"
                                                       value="{{ $trainer ? $trainer->email :old('email') }}"
                                                       placeholder="ইমেল">
                                            </div>

                                            <div
                                                class="form-group col-md-6 {{ !empty($authYouth)? ($authYouth->mobile?'read-only-input-field':''):'' }}">
                                                <label for="mobile">মোবাইল নাম্বার <span class="required">*</span>
                                                    :</label>
                                                <input type="text" class="form-control" name="mobile" id="mobile"
                                                       value="{{ !empty($trainer->trainerPersonalInformation) ? $trainer->trainerPersonalInformation->mobile :old('mobile') }}"
                                                       placeholder="মোবাইল">
                                            </div>

                                            <div class="form-group col-md-6">
                                                <label for="gender">লিঙ্গ<span class="required">*</span> :</label>
                                                <div
                                                    class="d-md-flex form-control {{ !empty($youthSelfInfo)? ($youthSelfInfo->gender?'read-only-input-field':''):'' }}"
                                                    style="display: inline-table;">
                                                    <div class="custom-control custom-radio mr-3">
                                                        <input class="custom-control-input" type="radio"
                                                               id="gender_male"
                                                               {{ !empty($trainer->trainerPersonalInformation) && $trainer->trainerPersonalInformation->gender == 1?' checked' : '' }}
                                                               name="gender"
                                                               value="{{ \Module\CourseManagement\App\Models\YouthFamilyMemberInfo::GENDER_MALE }}"
                                                            {{old('gender') == \Module\CourseManagement\App\Models\YouthFamilyMemberInfo::GENDER_MALE ? 'checked' : ''}}>
                                                        <label for="gender_male"
                                                               class="custom-control-label">পুরুষ</label>
                                                    </div>
                                                    <div class="custom-control custom-radio mr-3">
                                                        <input class="custom-control-input" type="radio"
                                                               id="gender_female"
                                                               {{ !empty($trainer->trainerPersonalInformation) && $trainer->trainerPersonalInformation->gender == 2?' checked' : '' }}
                                                               name="gender"
                                                               value="{{ \Module\CourseManagement\App\Models\YouthFamilyMemberInfo::GENDER_FEMALE }}"
                                                            {{ old('gender') == \Module\CourseManagement\App\Models\YouthFamilyMemberInfo::GENDER_FEMALE ? 'checked' : ''}}>
                                                        <label for="gender_female"
                                                               class="custom-control-label">নারী</label>
                                                    </div>
                                                    <div class="custom-control custom-radio mr-3">
                                                        <input class="custom-control-input" type="radio"
                                                               id="gender_transgender"
                                                               {{ !empty($trainer->trainerPersonalInformation) && $trainer->trainerPersonalInformation->gender == 4?' checked' : '' }}
                                                               name="gender"
                                                               value="{{ \Module\CourseManagement\App\Models\YouthFamilyMemberInfo::GENDER_TRANSGENDER }}"
                                                            {{old('gender') == \Module\CourseManagement\App\Models\YouthFamilyMemberInfo::GENDER_TRANSGENDER ? 'checked' : ''}}>
                                                        <label for="gender_transgender"
                                                               class="custom-control-label">হিজড়া</label>
                                                    </div>
                                                </div>
                                            </div>

                                            <div
                                                class="form-group col-md-6 {{ !empty($trainer->trainerPersonalInformation)? ($trainer->trainerPersonalInformation->date_of_birth?'read-only-input-field':''):'' }}">
                                                <label for="date_of_birth">জন্ম তারিখ <span
                                                        class="required">*</span> :</label>
                                                <input type="text" class="form-control flat-date" name="date_of_birth"
                                                       id="date_of_birth"
                                                       value="{{ !empty($trainer->trainerPersonalInformation)? $trainer->trainerPersonalInformation->date_of_birth :old('date_of_birth') }}"
                                                       placeholder="জন্ম তারিখ">
                                            </div>

                                            <div class="form-group col-md-6">
                                                <label for="marital_status">বৈবাহিক অবস্থা <span
                                                        class="required">*</span> :</label>
                                                <div class="form-control">
                                                    <div class="custom-control  custom-radio d-inline-block mr-3">
                                                        <input class="custom-control-input" type="radio"
                                                               id="marital_status_married"
                                                               name="marital_status"
                                                               value="{{ \Module\CourseManagement\App\Models\YouthFamilyMemberInfo::MARITAL_STATUS_MARRIED }}"
                                                            {{ old('marital_status') == \Module\CourseManagement\App\Models\YouthFamilyMemberInfo::MARITAL_STATUS_MARRIED ? 'checked' : '' }}
                                                            {{ !empty($trainer->trainerPersonalInformation) && $trainer->trainerPersonalInformation->marital_status == \Module\CourseManagement\App\Models\YouthFamilyMemberInfo::MARITAL_STATUS_MARRIED?' checked' : '' }}
                                                        >
                                                        <label for="marital_status_married"
                                                               class="custom-control-label">বিবাহিত</label>
                                                    </div>
                                                    <div class="custom-control custom-radio d-inline-block mr-3">
                                                        <input class="custom-control-input" type="radio"
                                                               id="marital_status_single"
                                                               name="marital_status"
                                                               value="{{ \Module\CourseManagement\App\Models\YouthFamilyMemberInfo:: MARITAL_STATUS_SINGLE}}"
                                                            {{ old('marital_status') == \Module\CourseManagement\App\Models\YouthFamilyMemberInfo::MARITAL_STATUS_SINGLE ? 'checked' : '' }}
                                                            {{ !empty($trainer->trainerPersonalInformation) && $trainer->trainerPersonalInformation->marital_status == \Module\CourseManagement\App\Models\YouthFamilyMemberInfo::MARITAL_STATUS_SINGLE?' checked' : '' }}
                                                        >
                                                        <label for="marital_status_single"
                                                               class="custom-control-label">অবিবাহিত</label>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group col-md-6">
                                                <label for="religion">ধর্ম<span class="required">*</span> :</label>
                                                <div class="d-md-flex form-control" style="display: inline-table;">
                                                    <div class="custom-control custom-radio mr-3">
                                                        <input class="custom-control-input" type="radio"
                                                               id="religion_islam"
                                                               name="religion"
                                                               value="{{ \Module\CourseManagement\App\Models\YouthFamilyMemberInfo::RELIGION_ISLAM }}"
                                                            {{ old('religion') == \Module\CourseManagement\App\Models\YouthFamilyMemberInfo::RELIGION_ISLAM ? 'checked' : '' }}
                                                            {{ !empty($trainer->trainerPersonalInformation) && $trainer->trainerPersonalInformation->religion == \Module\CourseManagement\App\Models\YouthFamilyMemberInfo::RELIGION_ISLAM ?' checked' : '' }}
                                                        >
                                                        <label for="religion_islam"
                                                               class="custom-control-label">ইসলাম</label>
                                                    </div>
                                                    <div class="custom-control custom-radio mr-3">
                                                        <input class="custom-control-input" type="radio"
                                                               id="religion_hindu"
                                                               name="religion"
                                                               value="{{ \Module\CourseManagement\App\Models\YouthFamilyMemberInfo::RELIGION_HINDU }}"
                                                            {{ old('religion') == \Module\CourseManagement\App\Models\YouthFamilyMemberInfo::RELIGION_HINDU ? 'checked' : '' }}
                                                            {{ !empty($trainer->trainerPersonalInformation) && $trainer->trainerPersonalInformation->religion == \Module\CourseManagement\App\Models\YouthFamilyMemberInfo::RELIGION_HINDU ?' checked' : '' }}
                                                        >

                                                        <label for="religion_hindu"
                                                               class="custom-control-label">হিন্দু</label>
                                                    </div>
                                                    <div class="custom-control custom-radio mr-3">
                                                        <input class="custom-control-input" type="radio"
                                                               id="religion_christian"
                                                               name="religion"
                                                               value="{{ \Module\CourseManagement\App\Models\YouthFamilyMemberInfo::RELIGION_CHRISTIAN }}"
                                                            {{ old('religion') == \Module\CourseManagement\App\Models\YouthFamilyMemberInfo::RELIGION_CHRISTIAN ? 'checked' : '' }}
                                                            {{ !empty($trainer->trainerPersonalInformation) && $trainer->trainerPersonalInformation->religion == \Module\CourseManagement\App\Models\YouthFamilyMemberInfo::RELIGION_CHRISTIAN ?' checked' : '' }}
                                                        >
                                                        <label for="religion_christian"
                                                               class="custom-control-label">খ্রিস্টান</label>
                                                    </div>

                                                    <div class="custom-control custom-radio mr-3">
                                                        <input class="custom-control-input" type="radio"
                                                               id="religion_buddhist"
                                                               name="religion"
                                                               value="{{ \Module\CourseManagement\App\Models\YouthFamilyMemberInfo::RELIGION_BUDDHIST }}"
                                                            {{ old('religion') == \Module\CourseManagement\App\Models\YouthFamilyMemberInfo::RELIGION_BUDDHIST ? 'checked' : '' }}
                                                            {{ !empty($trainer->trainerPersonalInformation) && $trainer->trainerPersonalInformation->religion == \Module\CourseManagement\App\Models\YouthFamilyMemberInfo::RELIGION_BUDDHIST ?' checked' : '' }}
                                                        >
                                                        <label for="religion_buddhist"
                                                               class="custom-control-label">বৌদ্ধ</label>
                                                    </div>

                                                    <div class="custom-control custom-radio mr-3">
                                                        <input class="custom-control-input" type="radio"
                                                               id="religion_jain"
                                                               name="religion"
                                                               value="{{ \Module\CourseManagement\App\Models\YouthFamilyMemberInfo::RELIGION_JAIN }}"
                                                            {{ old('religion') == \Module\CourseManagement\App\Models\YouthFamilyMemberInfo::RELIGION_JAIN ? 'checked' : '' }}
                                                            {{ !empty($trainer->trainerPersonalInformation) && $trainer->trainerPersonalInformation->religion == \Module\CourseManagement\App\Models\YouthFamilyMemberInfo::RELIGION_JAIN ?' checked' : '' }}
                                                        >
                                                        <label for="religion_jain"
                                                               class="custom-control-label">জৈন</label>
                                                    </div>

                                                    <div class="custom-control custom-radio mr-3">
                                                        <input class="custom-control-input" type="radio"
                                                               id="religion_other"
                                                               name="religion"
                                                               value="{{ \Module\CourseManagement\App\Models\YouthFamilyMemberInfo::RELIGION_OTHERS }}"
                                                            {{ old('religion') == \Module\CourseManagement\App\Models\YouthFamilyMemberInfo::RELIGION_OTHERS ? 'checked' : '' }}
                                                            {{ !empty($trainer->trainerPersonalInformation) && $trainer->trainerPersonalInformation->religion == \Module\CourseManagement\App\Models\YouthFamilyMemberInfo::RELIGION_OTHERS ?' checked' : '' }}
                                                        >
                                                        <label for="religion_other"
                                                               class="custom-control-label">অন্যান্য</label>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group col-md-6">
                                                <label for="nationality"> জাতীয়তা <span class="required">*</span>
                                                    :</label>
                                                <select class="select2" name="nationality" id="nationality">
                                                    <option value=""></option>
                                                    <option
                                                        value="bd" {{ !empty($trainer->trainerPersonalInformation) && $trainer->trainerPersonalInformation->nationality == 'bd' ? ' checked' : '' }}
                                                    >বাংলাদেশী
                                                    </option>
                                                    <option
                                                        value="others" {{ !empty($trainer->trainerPersonalInformation) && $trainer->trainerPersonalInformation->nationality == 'bd' ? ' checked' : '' }}>
                                                        অন্যান্য
                                                    </option>
                                                </select>
                                            </div>

                                            <div class="form-group col-md-6">
                                                <label for="nid_no">এন.আই.ডি নাম্বার/জন্ম সনদ/পাসপোর্ট নাম্বার <span
                                                        class="required">*</span>:</label>
                                                <div class="row">
                                                    <div class="form-group col-md-6">
                                                        <input type="text" class="form-control mb-2" name="nid_no"
                                                               id="nid_no"
                                                               value="{{ !empty($trainer->trainerPersonalInformation) ? $trainer->trainerPersonalInformation->nid_no : old('nid_no') }}"
                                                               placeholder="এন.আই.ডি নাম্বার">
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <input type="text" class="form-control mb-2"
                                                               name="birth_registration_no"
                                                               id="birth_registration_no"
                                                               value="{{ !empty($trainer->trainerPersonalInformation) ? $trainer->trainerPersonalInformation->birth_registration_no : old('birth_registration_no') }}"
                                                               placeholder="জন্ম সনদ নাম্বার">
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <input type="text" class="form-control mb-2"
                                                               name="passport_no"
                                                               id="passport_no"
                                                               value="{{ !empty($trainer->trainerPersonalInformation) ? $trainer->trainerPersonalInformation->passport_no : old('passport_no') }}"
                                                               placeholder="পাসপোর্ট নাম্বার">
                                                    </div>

                                                </div>
                                            </div>

                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="present_address">Present Address</label>
                                                    <textarea id="present_address" name="present_address"
                                                              class="form-control" rows="3"
                                                              placeholder="Ex: holding No./village/road/upazila/district">{{ $trainer->trainerPersonalInformation->present_address }}</textarea>
                                                </div>
                                            </div>

                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="permanent_address">Permanent Address</label>
                                                    <textarea id="permanent_address" name="permanent_address"
                                                              class="form-control" rows="3"
                                                              placeholder="Ex: holding No./village/road/upazila/district">{{ $trainer->trainerPersonalInformation->permanent_address }}</textarea>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="form-row justify-content-between">
                                            <div class="form-group col-md-6">
                                                <label for="profile_pic"> পাসপোর্ট সাইজের ছবি <span
                                                        class="required">*</span></label>
                                                <p class="font-italic font-weight-light" style="font-size: 12px;">(ছবি
                                                    আকার অবশ্যই
                                                    ৩০০ <i
                                                        class="fa fa-times" style="color: #CCCCCC"></i> ৩০০ হতে হবে)</p>
                                                <div class="input-group">
                                                    <div class="profile-upload-section">
                                                        <div class="avatar-preview profile_pic text-center">
                                                            <label for="profile_pic">
                                                                <img class="figure-img"
                                                                     src={{ $trainer->trainerPersonalInformation && $trainer->trainerPersonalInformation->profile_pic ? asset('storage/'. $trainer->trainerPersonalInformation->profile_pic) :  "https://via.placeholder.com/350x350?text=Trainer+Profile_pic"}}
                                                                         width="300" height="300"
                                                                     alt="Profile pic"/>
                                                                <span class="p-1 bg-gray"
                                                                      style="position: relative; right: 0; bottom: 50%; border: 2px solid #afafaf; border-radius: 50%;margin-left: -31px; overflow: hidden">
                                                        <i class="fa fa-pencil-alt text-white"></i>
                                                    </span>
                                                            </label>
                                                        </div>
                                                        <input type="file" name="profile_pic" style="display: none"
                                                               id="profile_pic">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="signature_pic">স্বাক্ষর<span
                                                        class="required">*</span></label>
                                                <p class=" font-italic font-weight-light text-small"
                                                   style="font-size: 12px;">(ছবি
                                                    আকার অবশ্যই ৩০০ <i
                                                        class="fa fa-times" style="color: #CCCCCC"></i> ৮০ হতে হবে)</p>
                                                <div class="input-group">
                                                    <div class="profile-upload-section">
                                                        <div class="avatar-preview signature_pic text-center">
                                                            <label for="signature_pic">
                                                                <img class="loading-img"
                                                                     src={{ $trainer->trainerPersonalInformation && $trainer->trainerPersonalInformation->signature_pic ? asset('storage/'. $trainer->trainerPersonalInformation->signature_pic) :  "https://via.placeholder.com/350x350?text=Trainer+signature"}}
                                                                         width="250" height="100"
                                                                     alt="Signature pic"/>
                                                                <span class="p-1 bg-gray"
                                                                      style="position: relative; right: 0; bottom: 50%; border: 2px solid #afafaf; border-radius: 50%;margin-left: -31px; overflow: hidden">
                                                        <i class="fa fa-pencil-alt text-white"></i> </span>
                                                            </label>
                                                        </div>
                                                        <input type="file" name="signature_pic"
                                                               style="display: none"
                                                               id="signature_pic">
                                                    </div>
                                                </div>
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
                                                    <h3 class="card-title text-primary d-inline-flex">জে.এস.সি/সমমান
                                                        (পাস)</h3>
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
                                                                    id="jsc_examination_name"
                                                                    class="select2 form-control">
                                                                <option value=""></option>
                                                                @foreach(\Module\CourseManagement\App\Models\YouthAcademicQualification::getJSCExaminationOptions() as $key => $value)
                                                                    <option
                                                                        value="{{ $key }}" {{ isset($academicQualifications[\Module\CourseManagement\App\Models\YouthAcademicQualification::EXAMINATION_JSC]) && $academicQualifications[\Module\CourseManagement\App\Models\YouthAcademicQualification::EXAMINATION_JSC]->examination_name == $key ? 'selected' : ''}} {{ old('academicQualification.jsc.examination_name') == $key ? 'selected' : '' }}>
                                                                        {{ $value }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col-md-4"></div>
                                                    </div>

                                                    <div class="form-row form-group mt-2">
                                                        <label for="jsc_board"
                                                               class="col-md-4 col-form-label">বোর্ড<span
                                                                class="required">*</span></label>
                                                        <div class="col-md-8">
                                                            <select name="academicQualification[jsc][board]"
                                                                    id="jsc_board"
                                                                    class="select2">
                                                                @foreach(\Module\CourseManagement\App\Models\YouthAcademicQualification::getExaminationBoardOptions() as $key => $value)
                                                                    <option value=""></option>
                                                                    <option
                                                                        value="{{ $key }}" {{ isset($academicQualifications[\Module\CourseManagement\App\Models\YouthAcademicQualification::EXAMINATION_JSC]) && $academicQualifications[\Module\CourseManagement\App\Models\YouthAcademicQualification::EXAMINATION_JSC]->board == $key ? 'selected' : ''}} {{ old('academicQualification.jsc.board') == $key ? 'selected' : '' }}>
                                                                        {{ $value }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col-md-4"></div>
                                                    </div>

                                                    <div class="form-row form-group mt-2">
                                                        <label for="jsc_roll" class="col-md-4 col-form-label">রোল
                                                            নং<span
                                                                class="required">*</span></label>
                                                        <div class="col-md-8">
                                                            <input type="text"
                                                                   name="academicQualification[jsc][roll_no]"
                                                                   id="jsc_roll" class="form-control"
                                                                   value="{{ isset($academicQualifications[\Module\CourseManagement\App\Models\YouthAcademicQualification::EXAMINATION_JSC]) ? $academicQualifications[\Module\CourseManagement\App\Models\YouthAcademicQualification::EXAMINATION_JSC]->roll_no :  old('academicQualification.jsc.roll_no') }}">
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
                                                                   value="{{ isset($academicQualifications[\Module\CourseManagement\App\Models\YouthAcademicQualification::EXAMINATION_JSC]) ? $academicQualifications[\Module\CourseManagement\App\Models\YouthAcademicQualification::EXAMINATION_JSC]->reg_no :  old('academicQualification.jsc.reg_no') }}">
                                                        </div>
                                                        <div class="col-md-4"></div>
                                                    </div>

                                                    <input type="hidden" name="academicQualification[jsc][result]"
                                                           value="5">
                                                    <div class="form-row form-group mt-2">
                                                        <label for="jsc_result"
                                                               class="col-md-4 col-form-label">ফলাফল<span
                                                                class="required">*</span></label>
                                                        <div class="col-md-8">
                                                            <input type="number"
                                                                   name="academicQualification[jsc][grade]"
                                                                   id="jsc_gpa" class="form-control"
                                                                   width="10" placeholder="জি.পি.এ"
                                                                   value="{{ isset($academicQualifications[\Module\CourseManagement\App\Models\YouthAcademicQualification::EXAMINATION_JSC]) ? $academicQualifications[\Module\CourseManagement\App\Models\YouthAcademicQualification::EXAMINATION_JSC]->grade :  old('academicQualification.jsc.grade') }}">
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
                                                                        value="{{ $i }}" {{ isset($academicQualifications[\Module\CourseManagement\App\Models\YouthAcademicQualification::EXAMINATION_JSC]) && $academicQualifications[\Module\CourseManagement\App\Models\YouthAcademicQualification::EXAMINATION_JSC]->passing_year == $i ? 'selected' : ''}} >{{ $i }}</option>
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
                                                    <h3 class="card-title text-primary d-inline-flex">
                                                        এস.এস.সি/সমমান/A-লেভেল
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
                                                                    id="ssc_examination_name"
                                                                    class="select2 form-control">
                                                                <option value=""></option>
                                                                @foreach(\Module\CourseManagement\App\Models\YouthAcademicQualification::getSSCExaminationOptions() as $key => $value)
                                                                    <option
                                                                        value="{{ $key }}" {{ isset($academicQualifications[\Module\CourseManagement\App\Models\YouthAcademicQualification::EXAMINATION_SSC]) && $academicQualifications[\Module\CourseManagement\App\Models\YouthAcademicQualification::EXAMINATION_SSC]->examination_name == $key ? 'selected' : ''}} {{ old('academicQualification.ssc.examination_name') == $key ? 'selected' : '' }}>
                                                                        {{ $value }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col-md-4"></div>
                                                    </div>

                                                    <div class="form-row form-group mt-2">
                                                        <label for="ssc_board"
                                                               class="col-md-4 col-form-label">বোর্ড<span
                                                                class="required">*</span></label>
                                                        <div class="col-md-8">
                                                            <select name="academicQualification[ssc][board]"
                                                                    id="ssc_board"
                                                                    class="select2">
                                                                <option value=""></option>

                                                                @foreach(\Module\CourseManagement\App\Models\YouthAcademicQualification::getExaminationBoardOptions() as $key => $value)
                                                                    <option
                                                                        value="{{ $key }}" {{ isset($academicQualifications[\Module\CourseManagement\App\Models\YouthAcademicQualification::EXAMINATION_SSC]) && $academicQualifications[\Module\CourseManagement\App\Models\YouthAcademicQualification::EXAMINATION_SSC]->board == $key ? 'selected' : ''}} {{ old('academicQualification.jsc.board') == $key ? 'selected' : '' }}>
                                                                        {{ $value }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col-md-4"></div>
                                                    </div>

                                                    <div class="form-row form-group mt-2">
                                                        <label for="ssc_roll" class="col-md-4 col-form-label">রোল
                                                            নং<span
                                                                class="required">*</span></label>
                                                        <div class="col-md-8">
                                                            <input type="text"
                                                                   name="academicQualification[ssc][roll_no]"
                                                                   id="ssc_roll" class="form-control"
                                                                   value="{{ isset($academicQualifications[\Module\CourseManagement\App\Models\YouthAcademicQualification::EXAMINATION_SSC]) ? $academicQualifications[\Module\CourseManagement\App\Models\YouthAcademicQualification::EXAMINATION_SSC]->roll_no :  old('academicQualification.ssc.roll_no') }}">
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
                                                                   value="{{ isset($academicQualifications[\Module\CourseManagement\App\Models\YouthAcademicQualification::EXAMINATION_SSC]) ? $academicQualifications[\Module\CourseManagement\App\Models\YouthAcademicQualification::EXAMINATION_SSC]->reg_no :  old('academicQualification.ssc.reg_no') }}">
                                                        </div>
                                                        <div class="col-md-4"></div>
                                                    </div>

                                                    <div class="form-row form-group mt-2">
                                                        <label for="ssc_result"
                                                               class="col-md-4 col-form-label">ফলাফল<span
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
                                                                        value="{{ $key }}" {{ isset($academicQualifications[\Module\CourseManagement\App\Models\YouthAcademicQualification::EXAMINATION_SSC]) && $academicQualifications[\Module\CourseManagement\App\Models\YouthAcademicQualification::EXAMINATION_SSC]->result == $key ? 'selected' : ''}} {{ old('academicQualification.ssc.result') == $key ? 'selected' : '' }}>
                                                                        {{ $value }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="" id="ssc_gpa_div">
                                                            <input type="number"
                                                                   name="academicQualification[ssc][grade]"
                                                                   id="ssc_gpa" class="form-control"
                                                                   width="10" placeholder="জি.পি.এ"
                                                                   value="{{ isset($academicQualifications[\Module\CourseManagement\App\Models\YouthAcademicQualification::EXAMINATION_SSC]) ? $academicQualifications[\Module\CourseManagement\App\Models\YouthAcademicQualification::EXAMINATION_SSC]->grade :  old('academicQualification.ssc.grade') }}"
                                                                   hidden>
                                                        </div>
                                                        <div class="col-md-4"></div>
                                                    </div>

                                                    <div class="form-row form-group mt-2">
                                                        <label for="ssc_group"
                                                               class="col-md-4 col-form-label">বিভাগ<span
                                                                class="required">*</span></label>
                                                        <div class="col-md-8">
                                                            <select name="academicQualification[ssc][group]"
                                                                    class="select2"
                                                                    id="ssc_group">
                                                                <option value=""></option>
                                                                @foreach(\Module\CourseManagement\App\Models\YouthAcademicQualification::getExaminationGroupOptions() as $key => $value)
                                                                    <option
                                                                        value="{{ $key }}" {{ isset($academicQualifications[\Module\CourseManagement\App\Models\YouthAcademicQualification::EXAMINATION_SSC]) && $academicQualifications[\Module\CourseManagement\App\Models\YouthAcademicQualification::EXAMINATION_SSC]->group == $key ? 'selected' : ''}} {{ old('academicQualification.ssc.group') == $key ? 'selected' : '' }}>
                                                                        {{ $value }}
                                                                    </option>
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
                                                                        value="{{ $i }}" {{ isset($academicQualifications[\Module\CourseManagement\App\Models\YouthAcademicQualification::EXAMINATION_SSC]) && $academicQualifications[\Module\CourseManagement\App\Models\YouthAcademicQualification::EXAMINATION_SSC]->passing_year == $i ? 'selected' : ''}} {{ old('academicQualification.ssc.passing_year') == $i ? 'selected' : '' }}>
                                                                        {{ $i }}
                                                                    </option>
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
                                                    <h3 class="card-title text-primary d-inline-flex">
                                                        এইচ.এস.সি/সমমান(পাস)
                                                    </h3>
                                                </div>
                                                <div class="card-body hsc_collapse hide">
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
                                                                        value="{{ $key }}" {{ isset($academicQualifications[\Module\CourseManagement\App\Models\YouthAcademicQualification::EXAMINATION_HSC]) && $academicQualifications[\Module\CourseManagement\App\Models\YouthAcademicQualification::EXAMINATION_HSC]->examination_name == $key ? 'selected' : ''}} {{ old('academicQualification.hsc.examination_name') == $key ? 'selected' : '' }}>
                                                                        {{ $value }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col-md-4"></div>
                                                    </div>

                                                    <div class="form-row form-group mt-2">
                                                        <label for="hsc_board"
                                                               class="col-md-4 col-form-label">বোর্ড<span
                                                                class="required">*</span></label>
                                                        <div class="col-md-8">
                                                            <select name="academicQualification[hsc][board]"
                                                                    id="hsc_board"
                                                                    class="select2">
                                                                <option></option>
                                                                @foreach(\Module\CourseManagement\App\Models\YouthAcademicQualification::getExaminationBoardOptions() as $key => $value)
                                                                    <option
                                                                        value="{{ $key }}" {{ isset($academicQualifications[\Module\CourseManagement\App\Models\YouthAcademicQualification::EXAMINATION_HSC]) && $academicQualifications[\Module\CourseManagement\App\Models\YouthAcademicQualification::EXAMINATION_HSC]->board == $key ? 'selected' : ''}} {{ old('academicQualification.hsc.board') == $key ? 'selected' : '' }}>
                                                                        {{ $value }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col-md-4"></div>
                                                    </div>

                                                    <div class="form-row form-group mt-2">
                                                        <label for="hsc_roll" class="col-md-4 col-form-label">রোল
                                                            নং<span
                                                                class="required">*</span></label>
                                                        <div class="col-md-8">
                                                            <input type="text"
                                                                   name="academicQualification[hsc][roll_no]"
                                                                   id="hsc_roll" class="form-control"
                                                                   value="{{ isset($academicQualifications[\Module\CourseManagement\App\Models\YouthAcademicQualification::EXAMINATION_HSC]) ? $academicQualifications[\Module\CourseManagement\App\Models\YouthAcademicQualification::EXAMINATION_HSC]->roll_no :  old('academicQualification.hsc.roll_no') }}">
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
                                                                   value="{{ isset($academicQualifications[\Module\CourseManagement\App\Models\YouthAcademicQualification::EXAMINATION_HSC]) ? $academicQualifications[\Module\CourseManagement\App\Models\YouthAcademicQualification::EXAMINATION_HSC]->reg_no :  old('academicQualification.hsc.reg_no') }}"

                                                            >
                                                        </div>
                                                        <div class="col-md-4"></div>
                                                    </div>

                                                    <div class="form-row form-group mt-2">
                                                        <label for="hsc_result"
                                                               class="col-md-4 col-form-label">ফলাফল<span
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
                                                                        value="{{ $key }}" {{ isset($academicQualifications[\Module\CourseManagement\App\Models\YouthAcademicQualification::EXAMINATION_HSC]) && $academicQualifications[\Module\CourseManagement\App\Models\YouthAcademicQualification::EXAMINATION_HSC]->result == $key ? 'selected' : ''}} {{ old('academicQualification.hsc.result') == $key ? 'selected' : '' }}>
                                                                        {{ $value }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="" id="hsc_gpa_div">
                                                            <input type="number"
                                                                   name="academicQualification[hsc][grade]"
                                                                   id="hsc_gpa" class="form-control"
                                                                   width="10" placeholder="জি.পি.এ"
                                                                   value="{{ isset($academicQualifications[\Module\CourseManagement\App\Models\YouthAcademicQualification::EXAMINATION_HSC]) ? $academicQualifications[\Module\CourseManagement\App\Models\YouthAcademicQualification::EXAMINATION_HSC]->grade :  old('academicQualification.hsc.grade') }}"
                                                                   hidden>
                                                        </div>
                                                        <div class="col-md-4"></div>
                                                    </div>

                                                    <div class="form-row form-group mt-2">
                                                        <label for="hsc_group"
                                                               class="col-md-4 col-form-label">বিভাগ<span
                                                                class="required">*</span></label>
                                                        <div class="col-md-8">
                                                            <select name="academicQualification[hsc][group]"
                                                                    id="hsc_group"
                                                                    class="select2">
                                                                <option></option>
                                                                @foreach(\Module\CourseManagement\App\Models\YouthAcademicQualification::getExaminationGroupOptions() as $key => $value)
                                                                    <option
                                                                        value="{{ $key }}" {{ isset($academicQualifications[\Module\CourseManagement\App\Models\YouthAcademicQualification::EXAMINATION_HSC]) && $academicQualifications[\Module\CourseManagement\App\Models\YouthAcademicQualification::EXAMINATION_HSC]->group == $key ? 'selected' : ''}} {{ old('academicQualification.hsc.group') == $key ? 'selected' : '' }}>
                                                                        {{ $value }}
                                                                    </option>
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
                                                                        value="{{ $i }}" {{ isset($academicQualifications[\Module\CourseManagement\App\Models\YouthAcademicQualification::EXAMINATION_HSC]) && $academicQualifications[\Module\CourseManagement\App\Models\YouthAcademicQualification::EXAMINATION_HSC]->passing_year == $i ? 'selected' : ''}} {{ old('academicQualification.hsc.passing_year') == $i ? 'selected' : '' }}>
                                                                        {{ $i }}
                                                                    </option>
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
                                                    <h3 class="card-title text-primary d-inline-flex">স্নাতক লেভেল
                                                        (পাস)</h3>
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
                                                                        value="{{ $key }}" {{ isset($academicQualifications[\Module\CourseManagement\App\Models\YouthAcademicQualification::EXAMINATION_GRADUATION]) && $academicQualifications[\Module\CourseManagement\App\Models\YouthAcademicQualification::EXAMINATION_GRADUATION]->examination_name == $key ? 'selected' : ''}} {{ old('academicQualification.graduation.examination_name') == $key ? 'selected' : '' }}>
                                                                        {{ $value }}
                                                                    </option>
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
                                                                   value="{{ isset($academicQualifications[\Module\CourseManagement\App\Models\YouthAcademicQualification::EXAMINATION_GRADUATION]) ? $academicQualifications[\Module\CourseManagement\App\Models\YouthAcademicQualification::EXAMINATION_GRADUATION]->subject :  old('academicQualification.graduation.subject') }}">
                                                        </div>
                                                        <div class="col-md-4"></div>
                                                    </div>

                                                    <div class="form-row form-group mt-2">
                                                        <label for="graduation_institute"
                                                               class="col-md-4 col-form-label">প্রতিষ্ঠান/বিশ্ববিদ্যালয়<span
                                                                class="required">*</span></label>
                                                        <div class="col-md-8">
                                                            <select name="academicQualification[graduation][institute]"
                                                                    id="graduation_institute"
                                                                    class="select2">
                                                                <option value=""></option>
                                                                @foreach(\Module\CourseManagement\App\Models\YouthAcademicQualification::getUniversities() as $key => $value)
                                                                    <option
                                                                        value="{{ $key }}" {{ isset($academicQualifications[\Module\CourseManagement\App\Models\YouthAcademicQualification::EXAMINATION_GRADUATION]) && $academicQualifications[\Module\CourseManagement\App\Models\YouthAcademicQualification::EXAMINATION_GRADUATION]->institute == $key ? 'selected' : ''}} {{ old('academicQualification.graduation.institute') == $key ? 'selected' : '' }}>
                                                                        {{ $value }}
                                                                    </option>
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
                                                                        value="{{ $key }}" {{ isset($academicQualifications[\Module\CourseManagement\App\Models\YouthAcademicQualification::EXAMINATION_GRADUATION]) && $academicQualifications[\Module\CourseManagement\App\Models\YouthAcademicQualification::EXAMINATION_GRADUATION]->result == $key ? 'selected' : ''}} {{ old('academicQualification.graduation.result') == $key ? 'selected' : '' }}>
                                                                        {{ $value }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="" id="graduation_cgpa_div">
                                                            <input type="number"
                                                                   name="academicQualification[graduation][grade]"
                                                                   id="graduation_cgpa"
                                                                   class="form-control" width="10"
                                                                   placeholder="সি.জি.পি.এ"
                                                                   value="{{ isset($academicQualifications[\Module\CourseManagement\App\Models\YouthAcademicQualification::EXAMINATION_GRADUATION]) ? $academicQualifications[\Module\CourseManagement\App\Models\YouthAcademicQualification::EXAMINATION_GRADUATION]->grade :  old('academicQualification.graduation.grade') }}"
                                                                   hidden>
                                                        </div>
                                                        <div class="col-md-4"></div>
                                                    </div>

                                                    <div class="form-row form-group mt-2">
                                                        <label for="graduation_passing_year"
                                                               class="col-md-4 col-form-label">
                                                            পাসের বছর<span class="required">*</span></label>
                                                        <div class="col-md-8">
                                                            <select
                                                                name="academicQualification[graduation][passing_year]"
                                                                id="graduation_passing_year" class="select2">
                                                                <option></option>
                                                                @for($i = now()->format('Y') - 50; $i <= now()->format('Y'); $i++)
                                                                    <option
                                                                        value="{{ $i }}" {{ isset($academicQualifications[\Module\CourseManagement\App\Models\YouthAcademicQualification::EXAMINATION_GRADUATION]) && $academicQualifications[\Module\CourseManagement\App\Models\YouthAcademicQualification::EXAMINATION_GRADUATION]->passing_year == $i ? 'selected' : ''}} {{ old('academicQualification.graduation.passing_year') == $i ? 'selected' : '' }}>
                                                                        {{ $i }}
                                                                    </option>
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
                                                                        value="{{ $key }}" {{ isset($academicQualifications[\Module\CourseManagement\App\Models\YouthAcademicQualification::EXAMINATION_GRADUATION]) && $academicQualifications[\Module\CourseManagement\App\Models\YouthAcademicQualification::EXAMINATION_GRADUATION]->course_duration == $key ? 'selected' : ''}} {{ old('academicQualification.graduation.course_duration') == $key ? 'selected' : '' }}>
                                                                        {{ $value }}
                                                                    </option>
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
                                                    <h3 class="card-title text-primary d-inline-flex">স্নাতকোত্তর লেভেল
                                                        (পাস) </h3>
                                                </div>
                                                <div class="card-body masters_collapse {{--collapse--}} hide">
                                                    <input type="hidden"
                                                           name="academicQualification[masters][examination]"
                                                           value="{{ \Module\CourseManagement\App\Models\YouthAcademicQualification::EXAMINATION_MASTERS }}">
                                                    <div class="form-row form-group">
                                                        <label for="masters_examination_name"
                                                               class="col-md-4 col-form-label">পরীক্ষা<span
                                                                class="required">*</span></label>
                                                        <div class="col-md-8">
                                                            <select
                                                                name="academicQualification[masters][examination_name]"
                                                                id="masters_examination_name" class="select2">
                                                                <option></option>
                                                                @foreach(\Module\CourseManagement\App\Models\YouthAcademicQualification::getMastersExaminationOptions() as $key => $value)
                                                                    <option
                                                                        value="{{ $key }}" {{ isset($academicQualifications[\Module\CourseManagement\App\Models\YouthAcademicQualification::EXAMINATION_MASTERS]) && $academicQualifications[\Module\CourseManagement\App\Models\YouthAcademicQualification::EXAMINATION_MASTERS]->examination_name == $key ? 'selected' : ''}} {{ old('academicQualification.masters.examination_name') == $key ? 'selected' : '' }}>
                                                                        {{ $value }}
                                                                    </option>
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
                                                                   class="form-control"
                                                                   value="{{ isset($academicQualifications[\Module\CourseManagement\App\Models\YouthAcademicQualification::EXAMINATION_MASTERS]) ? $academicQualifications[\Module\CourseManagement\App\Models\YouthAcademicQualification::EXAMINATION_MASTERS]->subject :  old('academicQualification.graduation.subject') }}"
                                                            >
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
                                                                        value="{{ $key }}" {{ isset($academicQualifications[\Module\CourseManagement\App\Models\YouthAcademicQualification::EXAMINATION_MASTERS]) && $academicQualifications[\Module\CourseManagement\App\Models\YouthAcademicQualification::EXAMINATION_MASTERS]->institute == $key ? 'selected' : ''}} {{ old('academicQualification.masters.institute') == $key ? 'selected' : '' }}>
                                                                        {{ $value }}
                                                                    </option>
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
                                                                        value="{{ $key }}" {{ isset($academicQualifications[\Module\CourseManagement\App\Models\YouthAcademicQualification::EXAMINATION_MASTERS]) && $academicQualifications[\Module\CourseManagement\App\Models\YouthAcademicQualification::EXAMINATION_MASTERS]->result == $key ? 'selected' : ''}} {{ old('academicQualification.masters.result') == $key ? 'selected' : '' }}>
                                                                        {{ $value }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="" id="masters_cgpa_div">
                                                            <input type="number"
                                                                   name="academicQualification[masters][grade]"
                                                                   id="masters_cgpa"
                                                                   class="form-control" width="10"
                                                                   placeholder="সি.জি.পি.এ"
                                                                   value="{{ old('academicQualification.masters.grade') }}"
                                                                   hidden>
                                                        </div>
                                                        <div class="col-md-4"></div>
                                                    </div>

                                                    <div class="form-row form-group mt-2">
                                                        <label for="masters_passing_year"
                                                               class="col-md-4 col-form-label">
                                                            পাসের বছর<span class="required">*</span></label>
                                                        <div class="col-md-8">
                                                            <select name="academicQualification[masters][passing_year]"
                                                                    class="select2" id="masters_passing_year">
                                                                <option></option>
                                                                @for($i = now()->format('Y') - 50; $i <= now()->format('Y'); $i++)
                                                                    <option
                                                                        value="{{ $i }}" {{ isset($academicQualifications[\Module\CourseManagement\App\Models\YouthAcademicQualification::EXAMINATION_MASTERS]) && $academicQualifications[\Module\CourseManagement\App\Models\YouthAcademicQualification::EXAMINATION_MASTERS]->passing_year == $i ? 'selected' : ''}} {{ old('academicQualification.masters.passing_year') == $i ? 'selected' : '' }}>
                                                                        {{ $i }}
                                                                    </option>
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
                                                            <select
                                                                name="academicQualification[masters][course_duration]"
                                                                id="masters_course_duration" class="select2">
                                                                <option></option>
                                                                @foreach(\Module\CourseManagement\App\Models\YouthAcademicQualification::getExaminationCourseDurationOptions() as $key => $value)
                                                                    <option
                                                                        value="{{ $key }}" {{ isset($academicQualifications[\Module\CourseManagement\App\Models\YouthAcademicQualification::EXAMINATION_MASTERS]) && $academicQualifications[\Module\CourseManagement\App\Models\YouthAcademicQualification::EXAMINATION_MASTERS]->course_duration == $key ? 'selected' : ''}} {{ old('academicQualification.masters.course_duration') == $key ? 'selected' : '' }}>
                                                                        {{ $value }}
                                                                    </option>
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
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-header custom-bg-gradient-info experiences">
                                        <h3 class="card-title font-weight-bold text-primary"><i
                                                class="fa fa-address-book"> </i> Experience </h3>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-12 trainer-experience-contents"></div>
                                            <div class="col-md-12">
                                                <button type="button"
                                                        class="btn btn-primary add-more-experience-btn float-right">
                                                    <i class="fa fa-plus-circle fa-fw"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="col-sm-12 text-right">
                                <button type="submit"
                                        class="btn btn-success">{{ $edit ? __('Update') : __('Add') }}</button>
                            </div>
                        </form>
                    </div><!-- /.card-body -->
                    <div class="overlay" style="display: none">
                        <i class="fas fa-2x fa-sync-alt fa-spin"></i>
                    </div>
                </div>
            </div>
        </div>

    </div>

@endsection

@push('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lodash.js/4.17.21/lodash.js"></script>

    <x-generic-validation-error-toastr></x-generic-validation-error-toastr>

    <script>
        const EDIT = !!'{{$edit}}';
        let SL = 0;

        $(document).ready(function () {
            $("#profile_pic").change(async function () {
                await readURL(this); //preview image
                youthRegistrationForm.validate().element("#profile_pic");
            });

            $("#signature_pic").change(async function () {
                await readURL(this);
                youthRegistrationForm.validate().element("#signature_pic");
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


        function addRow(data = {}) {
            console.log('SL: ' + SL)
            console.log(data);
            const EDIT = !!data.id;
            let trainerExperience = _.template($('#trainer-experiences').html());
            console.table('course session template:', trainerExperience);
            let experienceContentElm = $(".trainer-experience-contents");
            experienceContentElm.append(trainerExperience({sl: SL, data: data, edit: EDIT}))
            experienceContentElm.find('.flat-date').each(function () {
                $(this).flatpickr({
                    altInput: false,
                    altFormat: "j F, Y",
                    dateFormat: "Y-m-d",
                });
            });

            $.validator.addMethod(
                "sessionNameEn",
                function (value, element) {
                    let regexp = /^[a-zA-Z0-9 ]*$/;
                    let re = new RegExp(regexp);
                    return this.optional(element) || re.test(value);
                },
                "Please fill this field in English."
            );

            $.validator.addMethod("cGreaterThan", $.validator.methods.greaterThan,
                "Application start date must be greater than today");
            $.validator.addMethod("cApplicationEndDate", $.validator.methods.greaterThan,
                "Application end date must be greater than Application start date");
            $.validator.addMethod("cCourseStartDate", $.validator.methods.greaterThan,
                "Course start date must be greater than Application end date");
            $.validator.addClassRules("number_of_batches", {required: true});
            $.validator.addClassRules("application_start_date", {
                required: true,
                //cGreaterThan: '#today',
            });

            for (let i = 0; i <= SL; i++) {
                $.validator.addClassRules("application_end_date" + i, {
                    required: true,
                    cApplicationEndDate: '.application_start_date' + i,
                });
                $.validator.addClassRules("course_start_date" + i, {
                    required: true,
                    cCourseStartDate: ".application_end_date" + i,
                });
            }


            $.validator.addClassRules("max_seat_available", {required: true});
            $.validator.addClassRules("session_name_en", {
                required: true,
                sessionNameEn: true,
            });
            SL++;
        }

        function deleteRow(slNo) {
            let sessionELm = $("#session-no-" + slNo);
            if (sessionELm.find('.delete_status').length) {
                sessionELm.find('.delete_status').val(1);
                sessionELm.hide();
            } else {
                sessionELm.remove();
            }
            SL--;
        }

        $(document).ready(function () {
            @if($trainer->trainerExperiences->count())
            @foreach($trainer->trainerExperiences as $experience)
            addRow(@json($experience));
            @endforeach
            @else
            addRow();
            @endif

            $(document).on('click', '.add-more-experience-btn', function () {
                addRow();
            });
        });

        const editAddForm = $('.edit-add-form');
        editAddForm.validate({
            rules: {
                institute_id: {
                    required: true
                },
                course_id: {
                    required: true
                },
                application_form_type_id: {
                    required: true
                },
                max_seat_available: {
                    required: true,
                    number: true,
                    min: 1,
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

    </script>

    <script type="text/template" id="trainer-experiences">
        <div class="card" id="session-no-<%=sl%>">
            <div class="card-header d-flex justify-content-between">
                <h5 class="session-name-english<%=sl%>"><%= "Experience " + (sl+1)%></h5>
                <div class="card-tools">
                    <button type="button"
                            onclick="deleteRow(<%=sl%>)"
                            class="btn btn-warning less-experience-btn float-right mr-2"><i
                            class="fa fa-minus-circle fa-fw"></i></button>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <% if(data.id) { %>
                    <input type="hidden" id="trainer_experience_<%=data.id%>" name="trainer_experiences[<%=sl%>][id]"
                           value="<%=data.id%>">
                    <input type="hidden" name="trainer_experiences[<%=sl%>][delete]" class="delete_status" value="0"/>
                    <% } %>

                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="session_name_en">{{ __('Organization Name') }} <span
                                    style="color: red"> * </span></label>
                            <input type="text"
                                   class="form-control organization_name"
                                   name="trainer_experiences[<%=sl%>][organization_name]"
                                   placeholder="{{ __('Organization name') }}"
                                   value="<%=edit ? data.organization_name : ''%>"
                            >
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="job_position">{{ __('Position') }} <span
                                    style="color: red"> * </span></label>
                            <input type="text"
                                   class="form-control position"
                                   name="trainer_experiences[<%=sl%>][position]"
                                   placeholder="{{ __('Position') }}"
                                   value="<%=edit ? data.position : ''%>"
                            >
                        </div>
                    </div>

                    <div class="col-sm-12">
                        <div class="form-check">
                            <input class="form-check-input trainer_experience_current_work_status<%=sl%>"
                                   type="checkbox"
                                   name="trainer_experiences[<%=sl%>][current_working_status]"
                                   id="trainer_experiences[<%=sl%>][current_working_status]"
                                   value="1"
                            <%=data.current_working_status ? "checked" : ''%>
                            >
                            <label class="form-check-label" for="trainer_experience_current_work_status">
                                Currently working?
                            </label>
                        </div>
                    </div>


                    <div class="col-sm-6">
                        <div class="form-group">
                            <label
                                for="job_start_date">{{ __('Start Date') }} <span
                                    style="color: red"> * </span></label>
                            <input type="text"
                                   class="flat-date flat-date-custom-bg form-control job_start_date job_start_date<%=sl%> "
                                   name="trainer_experiences[<%=sl%>][job_start_date]"
                                   id="trainer_experiences[<%=sl%>][job_start_date]"
                                   value="<%=edit ? data.job_start_date : ''%>">
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="form-group">
                            <label
                                for="job_end_date">{{ __('End Date') }} <span
                                    style="color: red"> * </span></label>
                            <input type="text"
                                   class="flat-date flat-date-custom-bg form-control job_end_date job_end_date<%=sl%>"
                                   name="trainer_experiences[<%=sl%>][job_end_date]"
                                   value="<%=edit ? data.job_end_date : ''%>"
                            >
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </script>
@endpush


