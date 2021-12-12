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
                <form action="{{ route('frontend.trainee-registrations.store') }}" method="post"
                      class="trainee-registration-form">
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
                                                   placeholder="{{ __('generic.email') }}" l value="{{ old('email') }}">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="mobile">{{ __('generic.mobile') }}</label>
                                            <input type="text" class="form-control" name="mobile" id="mobile"
                                                   placeholder="{{ __('generic.mobile') }}" value="{{ old('mobile') }}">
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label for="date_of_birth">{{ __('generic.date_of_birth') }}</label>
                                            <input type="text" class="flat-date form-control" name="date_of_birth"
                                                   id="date_of_birth"
                                                   placeholder="{{ __('generic.date_of_birth') }}"
                                                   value="{{ old('date_of_birth') }}">
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label for="gender">{{ __('generic.gender') }}<span
                                                    class="required">*</span> :</label>
                                            <div
                                                class="d-md-flex form-control"
                                                style="display: inline-table;">
                                                <div class="custom-control custom-radio mr-3">
                                                    <input class="custom-control-input" type="radio" id="gender_male"
                                                           name="gender"
                                                           value="{{ \App\Models\YouthFamilyMemberInfo::GENDER_MALE }}"
                                                        {{old('gender') == \App\Models\YouthFamilyMemberInfo::GENDER_MALE ? 'checked' : ''}}>
                                                    <label for="gender_male"
                                                           class="custom-control-label">{{ __('generic.gender.male') }}</label>
                                                </div>
                                                <div class="custom-control custom-radio mr-3">
                                                    <input class="custom-control-input" type="radio" id="gender_female"
                                                           name="gender"
                                                           value="{{ \App\Models\YouthFamilyMemberInfo::GENDER_FEMALE }}"
                                                        {{ old('gender') == \App\Models\YouthFamilyMemberInfo::GENDER_FEMALE ? 'checked' : ''}}>
                                                    <label for="gender_female"
                                                           class="custom-control-label">{{__('generic.gender.female')}}</label>
                                                </div>
                                                <div class="custom-control custom-radio mr-3">
                                                    <input class="custom-control-input" type="radio"
                                                           id="gender_transgender"
                                                           name="gender"
                                                           value="{{ \App\Models\YouthFamilyMemberInfo::GENDER_OTHER }}"
                                                        {{old('gender') == \App\Models\YouthFamilyMemberInfo::GENDER_OTHER ? 'checked' : ''}}>
                                                    <label for="gender_transgender"
                                                           class="custom-control-label">{{ __('generic.other') }}</label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label for="disable_status">{{ __('generic.disability') }}<span
                                                    class="required">*</span> :</label>
                                            <div
                                                class="d-md-flex form-control"
                                                style="display: inline-table;">
                                                <div class="custom-control custom-radio mr-3">
                                                    <input class="custom-control-input" type="radio"
                                                           id="physically_disable_yes"
                                                           name="disable_status"
                                                           value="{{ \App\Models\YouthFamilyMemberInfo::PHYSICALLY_DISABLE_YES }}"
                                                        {{old('disable_status') == \App\Models\YouthFamilyMemberInfo::PHYSICALLY_DISABLE_YES ? 'checked' : ''}}>
                                                    <label for="physically_disable_yes"
                                                           class="custom-control-label">{{ __('generic.yes') }}</label>
                                                </div>
                                                <div class="custom-control custom-radio mr-3">
                                                    <input class="custom-control-input" type="radio"
                                                           id="physically_disable_no"
                                                           name="disable_status"
                                                           value="{{ \App\Models\YouthFamilyMemberInfo::PHYSICALLY_DISABLE_NOT }}"
                                                        {{ old('disable_status') == \App\Models\YouthFamilyMemberInfo::PHYSICALLY_DISABLE_NOT ? 'checked' : ''}}>
                                                    <label for="physically_disable_no"
                                                           class="custom-control-label">{{__('generic.no')}}</label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-6 form-group">
                                            <label for="physical_disabilities">{{__('generic.physical_disabilities')}}
                                                <span style="color: red"> * </span>
                                            </label>
                                            <select name="physical_disabilities[]" id="physical_disabilities"
                                                    class="form-control select2" multiple>
                                                @foreach(\App\Models\YouthFamilyMemberInfo::getPhysicalDisabilityOptions() as $key => $value)
                                                    <option
                                                        value="{{ $key }}" {{ $key == old('physical_disabilities[]') ? 'selected': '' }}>{{ $value }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="loc_division_id">{{__('generic.division')}} <span
                                                        class="required">*</span> :</label>
                                                <select class="form-control select2-ajax-wizard"
                                                        name="loc_division_id"
                                                        id="loc_division_id"
                                                        data-model="{{base64_encode(\App\Models\LocDivision::class)}}"
                                                        data-dependent-fields="#loc_district_id"
                                                        data-label-fields="{title_en}"
                                                        data-placeholder="নির্বাচন করুন"
                                                >
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="loc_district_id">{{__('generic.district')}} <span
                                                        class="required">*</span> :</label>
                                                <select class="form-control select2-ajax-wizard"
                                                        name="loc_district_id"
                                                        id="loc_district_id"
                                                        data-model="{{base64_encode(\App\Models\LocDistrict::class)}}"
                                                        data-label-fields="{title_en}"
                                                        data-depend-on-optional="loc_division_id:#loc_division_id"
                                                        data-placeholder="নির্বাচন করুন"
                                                >
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="loc_upazila_id">{{__('generic.upazila')}} <span
                                                        class="required">*</span> :</label>
                                                <select class="form-control select2-ajax-wizard"
                                                        name="loc_upazila_id"
                                                        id="loc_upazila_id"
                                                        data-model="{{base64_encode(\App\Models\LocUpazila::class)}}"
                                                        data-label-fields="{title_en}"
                                                        data-depend-on="loc_district_id:#loc_district_id"
                                                        data-placeholder="নির্বাচন করুন"
                                                >
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label
                                                for="password">{{ __('generic.password') }}</label>
                                            <input type="password" class="form-control" name="password"
                                                   id="password"
                                                   placeholder="{{ __('generic.password') }}"
                                                   value="{{old('password')}}">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label
                                                for="password_confirmation">{{ __('generic.retype_password') }}</label>
                                            <input type="password" class="form-control"
                                                   name="password_confirmation"
                                                   id="password_confirmation"
                                                   placeholder="{{ __('generic.retype_password') }}"
                                                   value="{{ old('password_confirmation') }}">
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
        const SSPRegistrationForm = $('.trainee-registration-form');

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
                date_of_birth: {
                    required: true,
                },
                gender: {
                    required: true,
                },
                physical_disability: {
                    required: true,
                },
                "physical_disabilities[]": {
                    required: false,
                },

                division: {
                    required: true,
                },
                district: {
                    required: true,
                },
                upazila: {
                    required: false,
                },
                password: {
                    required: true,
                },
                password_confirmation: {
                    equalTo: '#password',
                },
            }
        })

        $(document).ready(function () {
            $('#physical_disabilities').parent().hide();
        });

        $('[name = "physically_disable"]').on('change', function () {
            if (this.value == {!! \App\Models\YouthFamilyMemberInfo::PHYSICALLY_DISABLE_YES !!}) {
                $('#physical_disabilities').parent().show();
            } else {
                $('#physical_disabilities').parent().hide();
            }
        })
    </script>
@endpush

