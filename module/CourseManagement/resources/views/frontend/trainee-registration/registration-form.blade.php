@php
    $layout = 'master::layouts.front-end';
@endphp

@extends($layout)

@section('title')
    ssp-registration
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <form action="{{ route('course_management::ssp-registration') }}" method="post" class="ssp-registration-form">
                    @csrf
                    <div class="row justify-content-center py-4">
                        <div class="col-md-8">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <h3 class="ml-2 font-weight-bold">Registration</h3>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label for="name">{{ __('generic.name') }}</label>
                                            <input type="text" class="form-control" name="name" id="name"
                                                   placeholder="{{ __('generic.name') }}" value="{{old('name')}}">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="email">{{ __('generic.email') }}</label>
                                            <input type="text" class="form-control" name="email" id="email"
                                                   placeholder="{{ __('generic.email') }}"l value="{{ old('email') }}">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="mobile">{{ __('generic.mobile') }}</label>
                                            <input type="text" class="form-control" name="mobile" id="mobile"
                                                   placeholder="{{ __('generic.mobile') }}" value="{{ old('mobile') }}">
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label for="date_of_birth">{{ __('generic.date_of_birth') }}</label>
                                            <input type="text" class="flat-date form-control" name="date_of_birth" id="date_of_birth"
                                                   placeholder="{{ __('generic.date_of_birth') }}" value="{{ old('date_of_birth') }}">
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label for="gender">{{ __('generic.gender') }}<span class="required">*</span> :</label>
                                            <div
                                                class="d-md-flex form-control"
                                                style="display: inline-table;">
                                                <div class="custom-control custom-radio mr-3">
                                                    <input class="custom-control-input" type="radio" id="gender_male"
                                                           name="gender"
                                                           value="{{ \Module\CourseManagement\App\Models\YouthFamilyMemberInfo::GENDER_MALE }}"
                                                        {{old('gender') == \Module\CourseManagement\App\Models\YouthFamilyMemberInfo::GENDER_MALE ? 'checked' : ''}}>
                                                    <label for="gender_male" class="custom-control-label">{{ __('generic.gender.male') }}</label>
                                                </div>
                                                <div class="custom-control custom-radio mr-3">
                                                    <input class="custom-control-input" type="radio" id="gender_female"
                                                           name="gender"
                                                           value="{{ \Module\CourseManagement\App\Models\YouthFamilyMemberInfo::GENDER_FEMALE }}"
                                                        {{ old('gender') == \Module\CourseManagement\App\Models\YouthFamilyMemberInfo::GENDER_FEMALE ? 'checked' : ''}}>
                                                    <label for="gender_female" class="custom-control-label">{{__('generic.gender.female')}}</label>
                                                </div>
                                                <div class="custom-control custom-radio mr-3">
                                                    <input class="custom-control-input" type="radio" id="gender_transgender"
                                                           name="gender"
                                                           value="{{ \Module\CourseManagement\App\Models\YouthFamilyMemberInfo::GENDER_OTHER }}"
                                                        {{old('gender') == \Module\CourseManagement\App\Models\YouthFamilyMemberInfo::GENDER_OTHER ? 'checked' : ''}}>
                                                    <label for="gender_transgender"
                                                           class="custom-control-label">{{ __('generic.other') }}</label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label for="physically_disable">{{ __('generic.disability') }}<span class="required">*</span> :</label>
                                            <div
                                                class="d-md-flex form-control"
                                                style="display: inline-table;">
                                                <div class="custom-control custom-radio mr-3">
                                                    <input class="custom-control-input" type="radio" id="physically_disable_yes"
                                                           name="physically_disable"
                                                           value="{{ \Module\CourseManagement\App\Models\YouthFamilyMemberInfo::PHYSICALLY_DISABLE_YES }}"
                                                        {{old('physically_disable') == \Module\CourseManagement\App\Models\YouthFamilyMemberInfo::PHYSICALLY_DISABLE_YES ? 'checked' : ''}}>
                                                    <label for="physically_disable_yes" class="custom-control-label">{{ __('generic.yes') }}</label>
                                                </div>
                                                <div class="custom-control custom-radio mr-3">
                                                    <input class="custom-control-input" type="radio" id="physically_disable_no"
                                                           name="physically_disable"
                                                           value="{{ \Module\CourseManagement\App\Models\YouthFamilyMemberInfo::PHYSICALLY_DISABLE_NOT }}"
                                                        {{ old('physically_disable') == \Module\CourseManagement\App\Models\YouthFamilyMemberInfo::PHYSICALLY_DISABLE_NOT ? 'checked' : ''}}>
                                                    <label for="physically_disable_no" class="custom-control-label">{{__('generic.no')}}</label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-6 form-group">
                                                <label for="physical_disabilities">{{__('generic.physical_disabilities')}}
                                                    <span style="color: red"> * </span>
                                                </label>
                                                <select name="physical_disabilities[]" id="physical_disabilities"
                                                        class="form-control select2" multiple>
                                                    @foreach(\Module\CourseManagement\App\Models\YouthFamilyMemberInfo::getPhysicalDisabilityOptions() as $key => $value)
                                                        <option
                                                            value="{{ $key }}" {{ $key == old('physical_disabilities[]') ? 'selected': '' }}>{{ $value }}</option>
                                                    @endforeach
                                                </select>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="division">{{__('generic.division')}} <span
                                                        class="required">*</span> :</label>
                                                <select class="form-control select2-ajax-wizard"
                                                        name="division"
                                                        id="division"
                                                        data-model="{{base64_encode(\App\Models\LocDivision::class)}}"
                                                        data-dependent-fields="#district"
                                                        data-label-fields="{title_en}"
                                                        data-placeholder="নির্বাচন করুন"
                                                >
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="district">{{__('generic.district')}} <span
                                                        class="required">*</span> :</label>
                                                <select class="form-control select2-ajax-wizard"
                                                        name="district"
                                                        id="district"
                                                        data-model="{{base64_encode(\App\Models\LocDistrict::class)}}"
                                                        data-label-fields="{title_en}"
                                                        data-depend-on-optional="loc_division_id:#division"
                                                        data-placeholder="নির্বাচন করুন"
                                                >
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="upazila">{{__('generic.upazila')}} <span
                                                        class="required">*</span> :</label>
                                                <select class="form-control select2-ajax-wizard"
                                                        name="upazila"
                                                        id="upazila"
                                                        data-model="{{base64_encode(\App\Models\LocUpazila::class)}}"
                                                        data-label-fields="{title_en}"
                                                        data-depend-on="loc_upazila_id:#district"
                                                        data-placeholder="নির্বাচন করুন"
                                                >
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label
                                                for="contact_person_password">{{ __('generic.password') }}</label>
                                            <input type="password" class="form-control" name="contact_person_password"
                                                   id="contact_person_password"
                                                   placeholder="{{ __('generic.password') }}" value="{{old('contact_person_password')}}">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label
                                                for="contact_person_password_confirmation">{{ __('generic.retype_password') }}</label>
                                            <input type="password" class="form-control"
                                                   name="contact_person_password_confirmation"
                                                   id="contact_person_password_confirmation"
                                                   placeholder="{{ __('generic.retype_password') }}" value="{{ old('contact_person_password_confirmation') }}">
                                        </div>
                                        <div class="col-md-12">
                                            <input type="submit" class="btn btn-primary float-right ml-2"
                                                   value="{{ __('generic.registration') }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <x-generic-validation-error-toastr></x-generic-validation-error-toastr>
    <script>
        const SSPRegistrationForm = $('.ssp-registration-form');

        SSPRegistrationForm.validate({
            rules: {
                name: {
                    required: true,
                    maxLength: 30,
                },
                email: {
                    required: true,
                    pattern: /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/,
                },
                mobile: {
                    required: true,
                },
                address: {
                    required: false,
                },
                office_head: {
                    required: true,
                },
                office_head_post: {
                    required: true,
                },
                contact_person_name: {
                    required: true,
                },
                contact_person_post: {
                    required: true,
                },
                contact_person_email: {
                    required: true,
                },
                contact_person_mobile: {
                    required: true,
                },
                contact_person_password: {
                    required: true,
                },
                contact_person_password_confirmation: {
                    equalTo: '#contact_person_password',
                },
            }
        })

        $( document ).ready(function() {
            $('#physical_disabilities').parent().hide();
        });

        $('[name = "physically_disable"]').on('change', function () {
            if (this.value == {!! \Module\CourseManagement\App\Models\YouthFamilyMemberInfo::PHYSICALLY_DISABLE_YES !!}) {
                $('#physical_disabilities').parent().show();
            }else {
                $('#physical_disabilities').parent().hide();
            }
        })
    </script>
@endpush

