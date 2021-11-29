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
                    </div>
                    <div class="row p-2">
                        <div class="col-md-12">
                            <div class="card card-outline">
                                <div class="card-header text-primary custom-bg-gradient-info">
                                    <h3 class="card-title font-weight-bold text-primary">{{ 'Personal Information'}}</h3>

                                    <div class="card-tools">
                                        @can('viewAny', \Module\CourseManagement\App\Models\Institute::class)
                                            <a href="{{route('course_management::admin.institutes.index')}}"
                                               class="btn btn-sm btn-outline-primary btn-rounded">
                                                <i class="fas fa-backward"></i> Back to list
                                            </a>
                                        @endcan
                                    </div>

                                </div>

                                <div class="card-body">
                                    <form class="row edit-add-form" method="post"
                                          enctype="multipart/form-data"
                                          action="{{ $edit ? route('course_management::admin.institutes.update', [$institute->id]) : route('course_management::admin.institutes.store')}}">
                                        @csrf
                                        @if($edit)
                                            @method('put')
                                        @endif
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="name">{{ __('Name') }}<span
                                                        style="color: red"> * </span></label>
                                                <input type="text" class="form-control" id="title_en"
                                                       name="title_en"
                                                       value="{{ $edit ? $institute->title_en : old('title_en') }}"
                                                       placeholder="{{ __('Name') }}">
                                            </div>
                                        </div>

                                        <div
                                            class="form-group col-md-6 {{ !empty($authYouth)? ($authYouth->email?'read-only-input-field':''):'' }}">
                                            <label for="email">ইমেইল <span class="required">*</span>
                                                :</label>
                                            <input type="text" class="form-control" name="email" id="email"
                                                   value="{{ !empty($authYouth)? $authYouth->email :old('email') }}"
                                                   placeholder="ইমেল">
                                        </div>

                                        <div
                                            class="form-group col-md-6 {{ !empty($authYouth)? ($authYouth->mobile?'read-only-input-field':''):'' }}">
                                            <label for="mobile">মোবাইল নাম্বার <span class="required">*</span>
                                                :</label>
                                            <input type="text" class="form-control" name="mobile" id="mobile"
                                                   value="{{ !empty($authYouth)? $authYouth->mobile :old('mobile') }}"
                                                   placeholder="মোবাইল">
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label for="gender">লিঙ্গ<span class="required">*</span> :</label>
                                            <div
                                                class="d-md-flex form-control {{ !empty($youthSelfInfo)? ($youthSelfInfo->gender?'read-only-input-field':''):'' }}"
                                                style="display: inline-table;">
                                                <div class="custom-control custom-radio mr-3">
                                                    <input class="custom-control-input" type="radio" id="gender_male"
                                                           {{ !empty($youthSelfInfo) && $youthSelfInfo->gender==1?' checked':'' }}
                                                           name="gender"
                                                           value="{{ \Module\CourseManagement\App\Models\YouthFamilyMemberInfo::GENDER_MALE }}"
                                                        {{old('gender') == \Module\CourseManagement\App\Models\YouthFamilyMemberInfo::GENDER_MALE ? 'checked' : ''}}>
                                                    <label for="gender_male" class="custom-control-label">পুরুষ</label>
                                                </div>
                                                <div class="custom-control custom-radio mr-3">
                                                    <input class="custom-control-input" type="radio" id="gender_female"
                                                           {{ !empty($youthSelfInfo) &&  $youthSelfInfo->gender==2?' checked':'' }}
                                                           name="gender"
                                                           value="{{ \Module\CourseManagement\App\Models\YouthFamilyMemberInfo::GENDER_FEMALE }}"
                                                        {{ old('gender') == \Module\CourseManagement\App\Models\YouthFamilyMemberInfo::GENDER_FEMALE ? 'checked' : ''}}>
                                                    <label for="gender_female" class="custom-control-label">নারী</label>
                                                </div>
                                                <div class="custom-control custom-radio mr-3">
                                                    <input class="custom-control-input" type="radio"
                                                           id="gender_transgender"
                                                           {{ !empty($youthSelfInfo) && $youthSelfInfo->gender==4?' checked':'' }}
                                                           name="gender"
                                                           value="{{ \Module\CourseManagement\App\Models\YouthFamilyMemberInfo::GENDER_TRANSGENDER }}"
                                                        {{old('gender') == \Module\CourseManagement\App\Models\YouthFamilyMemberInfo::GENDER_TRANSGENDER ? 'checked' : ''}}>
                                                    <label for="gender_transgender"
                                                           class="custom-control-label">হিজড়া</label>
                                                </div>
                                            </div>
                                        </div>

                                        <div
                                            class="form-group col-md-6 {{ !empty($youthSelfInfo)? ($youthSelfInfo->date_of_birth?'read-only-input-field':''):'' }}">
                                            <label for="date_of_birth">জন্ম তারিখ <span
                                                    class="required">*</span> :</label>
                                            <input type="text" class="form-control flat-date" name="date_of_birth"
                                                   id="date_of_birth"
                                                   value="{{ !empty($youthSelfInfo)? $youthSelfInfo->date_of_birth :old('date_of_birth') }}"
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
                                                        {{ old('marital_status') == \Module\CourseManagement\App\Models\YouthFamilyMemberInfo::MARITAL_STATUS_MARRIED ? 'checked' : '' }}>
                                                    <label for="marital_status_married"
                                                           class="custom-control-label">বিবাহিত</label>
                                                </div>
                                                <div class="custom-control custom-radio d-inline-block mr-3">
                                                    <input class="custom-control-input" type="radio"
                                                           id="marital_status_single"
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
                                                    <label for="religion_islam"
                                                           class="custom-control-label">ইসলাম</label>
                                                </div>
                                                <div class="custom-control custom-radio mr-3">
                                                    <input class="custom-control-input" type="radio" id="religion_hindu"
                                                           name="religion"
                                                           value="{{ \Module\CourseManagement\App\Models\YouthFamilyMemberInfo::RELIGION_HINDU }}"
                                                        {{ old('religion') == \Module\CourseManagement\App\Models\YouthFamilyMemberInfo::RELIGION_HINDU ? 'checked' : '' }}>

                                                    <label for="religion_hindu"
                                                           class="custom-control-label">হিন্দু</label>
                                                </div>
                                                <div class="custom-control custom-radio mr-3">
                                                    <input class="custom-control-input" type="radio"
                                                           id="religion_christian"
                                                           name="religion"
                                                           value="{{ \Module\CourseManagement\App\Models\YouthFamilyMemberInfo::RELIGION_CHRISTIAN }}"
                                                        {{ old('religion') == \Module\CourseManagement\App\Models\YouthFamilyMemberInfo::RELIGION_CHRISTIAN ? 'checked' : '' }}>
                                                    <label for="religion_christian"
                                                           class="custom-control-label">খ্রিস্টান</label>
                                                </div>

                                                <div class="custom-control custom-radio mr-3">
                                                    <input class="custom-control-input" type="radio"
                                                           id="religion_buddhist"
                                                           name="religion"
                                                           value="{{ \Module\CourseManagement\App\Models\YouthFamilyMemberInfo::RELIGION_BUDDHIST }}"
                                                        {{ old('religion') == \Module\CourseManagement\App\Models\YouthFamilyMemberInfo::RELIGION_BUDDHIST ? 'checked' : '' }}>
                                                    <label for="religion_buddhist"
                                                           class="custom-control-label">বৌদ্ধ</label>
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
                                                <option value="bd">বাংলাদেশী</option>
                                                <option value="others">অন্যান্য</option>
                                            </select>
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label for="nid">এন.আই.ডি নাম্বার/জন্ম সনদ/পাসপোর্ট নাম্বার [যেকোনো একটি ঘর
                                                পূর্ণ
                                                করুন] <span class="required">*</span>:</label>
                                            <div class="row">
                                                <div class="form-group col-md-6">
                                                    <input type="text" class="form-control mb-2" name="nid" id="nid"
                                                           value="{{ old('nid') }}"
                                                           placeholder="এন.আই.ডি নাম্বার">
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <input type="text" class="form-control mb-2"
                                                           name="birth_certificate_no"
                                                           id="birth_certificate_no"
                                                           value="{{ old('birth_certificate_no') }}"
                                                           placeholder="জন্ম সনদ নাম্বার">
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <input type="text" class="form-control mb-2" name="passport_number"
                                                           id="passport_number"
                                                           value="{{ old('passport_number') }}"
                                                           placeholder="পাসপোর্ট নাম্বার">
                                                </div>

                                            </div>
                                        </div>

                                        <div class="form-group col-md-6 physical-disability-information">
                                            <label for="disable_status">শারীরিক প্রতিবন্ধী?
                                                <span class="required">*</span>:</label>
                                            <div class="input-group form-control">
                                                <div class="custom-control custom-radio mr-3">
                                                    <input type="radio" name="disable_status"
                                                           class="custom-control-input"
                                                           value="{{ \Module\CourseManagement\App\Models\YouthFamilyMemberInfo::PHYSICALLY_DISABLE_YES }}"
                                                           id="physically_disable" {{ old('disable_status') == \Module\CourseManagement\App\Models\YouthFamilyMemberInfo::PHYSICALLY_DISABLE_YES ? 'checked' : '' }}>
                                                    <label class="custom-control-label"
                                                           for="physically_disable">হ্যাঁ</label>
                                                </div>
                                                <div class="custom-control custom-radio mr-3">
                                                    <input type="radio" name="disable_status"
                                                           class="custom-control-input"
                                                           value="{{ \Module\CourseManagement\App\Models\YouthFamilyMemberInfo::PHYSICALLY_DISABLE_NOT }}"
                                                           id="physically_not_disable" {{ old('disable_status') == \Module\CourseManagement\App\Models\YouthFamilyMemberInfo::PHYSICALLY_DISABLE_NOT ? 'checked' : '' }}>

                                                    <label class="custom-control-label"
                                                           for="physically_not_disable">না</label>
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

                                        <div class="form-row justify-content-between">
                                            <div class="form-group col-md-6">
                                                <label for="student_pic"> পাসপোর্ট সাইজের ছবি <span
                                                        class="required">*</span></label>
                                                <p class="font-italic font-weight-light" style="font-size: 12px;">(ছবি
                                                    আকার অবশ্যই
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
                                                <p class=" font-italic font-weight-light text-small"
                                                   style="font-size: 12px;">(ছবি
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
                                                        <i class="fa fa-pencil-alt text-white"></i> </span>
                                                            </label>
                                                        </div>
                                                        <input type="file" name="student_signature_pic"
                                                               style="display: none"
                                                               id="student_signature_pic">
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

            </div>
        </div>
    </div>

@endsection

@push('js')
    <x-generic-validation-error-toastr></x-generic-validation-error-toastr>
@endpush


