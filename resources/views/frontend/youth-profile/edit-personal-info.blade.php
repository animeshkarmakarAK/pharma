@php
    $currentInstitute = app('currentInstitute');
    $layout = 'master::layouts.front-end';
@endphp
@extends($layout)

@section('title')
    ইয়ুথ প্রোফাইল
@endsection

@push('css')
    <style>
    </style>

@endpush

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card mt-4">
                    <div class="card-header">
                        <div class="card-title">Edit Personal Information</div>
                        <div class="card-tools">
                            <a href="{{route('frontend.youth')}}"
                               class="btn btn-sm btn-outline-primary btn-rounded">
                                <i class="fas fa-backward"></i> {{ __('generic.back_to_list') }}
                            </a>
                        </div>
                    </div>

                    <div class="card-body">
                        <form action="{{ route('frontend.update-personal-info', ['id' => $trainee->id]) }}"
                              method="post"
                              enctype="multipart/form-data" class="edit-form">
                            @csrf
                            @method('put')

                            <div class="col-md-12">
                                <div class="row justify-content-center align-content-center">
                                    <div class="form-group" style="width: 200px; height: 200px">
                                        <div class="input-group">
                                            <div class="profile-upload-section">
                                                <div class="avatar-preview text-center">
                                                    <label for="profile_pic">
                                                        <img class="img-thumbnail rounded-circle"
                                                             src="{{$trainee->profile_pic ? asset('storage/'.$trainee->profile_pic) : 'https://via.placeholder.com/350x350?text=Profile+Picture'}}"
                                                             style="width: 200px; height: 200px"
                                                             alt="Profile pic"/>
                                                        <span class="p-1 bg-gray"
                                                              style="position: absolute; right: 0; bottom: 50%; border: 2px solid #afafaf; border-radius: 50%; overflow: hidden">
                                                        <i class="fa fa-pencil-alt text-white"></i>
                                                    </span>
                                                    </label>
                                                </div>
                                                <input type="file" name="profile_pic" style="display: none"
                                                       id="profile_pic">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="name">{{ __('generic.name') }}<span
                                            class="required">*</span> :</label>
                                    <input type="text" class="form-control" name="name" id="name"
                                           placeholder="{{ __('generic.name') }}" value="{{ $trainee->name }}">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="email">{{ __('generic.email') }}<span
                                            class="required">*</span> :</label>
                                    <input type="text" class="form-control" name="email" id="email"
                                           placeholder="{{ __('generic.email') }}" value="{{ $trainee->email }}">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="mobile">{{ __('generic.mobile') }}<span
                                            class="required">*</span> :</label>
                                    <input type="text" class="form-control" name="mobile" id="mobile"
                                           placeholder="{{ __('generic.mobile') }}" value="{{ $trainee->mobile  }}">
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="date_of_birth">{{ __('generic.date_of_birth') }}<span
                                            class="required">*</span> :</label>
                                    <input type="text" class="flat-date form-control" name="date_of_birth"
                                           id="date_of_birth"
                                           placeholder="{{ __('generic.date_of_birth') }}"
                                           value="{{ $trainee->date_of_birth }}">
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
                                                {{ $trainee->gender == \App\Models\YouthFamilyMemberInfo::GENDER_MALE ? 'checked' : ''}}>
                                            <label for="gender_male"
                                                   class="custom-control-label">{{ __('generic.gender.male') }}</label>
                                        </div>
                                        <div class="custom-control custom-radio mr-3">
                                            <input class="custom-control-input" type="radio" id="gender_female"
                                                   name="gender"
                                                   value="{{ \App\Models\YouthFamilyMemberInfo::GENDER_FEMALE }}"
                                                {{ $trainee->gender == \App\Models\YouthFamilyMemberInfo::GENDER_FEMALE ? 'checked' : ''}}>
                                            <label for="gender_female"
                                                   class="custom-control-label">{{__('generic.gender.female')}}</label>
                                        </div>
                                        <div class="custom-control custom-radio mr-3">
                                            <input class="custom-control-input" type="radio"
                                                   id="gender_transgender"
                                                   name="gender"
                                                   value="{{ \App\Models\YouthFamilyMemberInfo::GENDER_OTHER }}"
                                                {{$trainee->gender == \App\Models\YouthFamilyMemberInfo::GENDER_OTHER ? 'checked' : ''}}>
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
                                                {{$trainee->disable_status == \App\Models\YouthFamilyMemberInfo::PHYSICALLY_DISABLE_YES ? 'checked' : ''}}>
                                            <label for="physically_disable_yes"
                                                   class="custom-control-label">{{ __('generic.yes') }}</label>
                                        </div>
                                        <div class="custom-control custom-radio mr-3">
                                            <input class="custom-control-input" type="radio"
                                                   id="physically_disable_no"
                                                   name="disable_status"
                                                   value="{{ \App\Models\YouthFamilyMemberInfo::PHYSICALLY_DISABLE_NOT }}"
                                                {{ $trainee->disable_status == \App\Models\YouthFamilyMemberInfo::PHYSICALLY_DISABLE_NOT ? 'checked' : ''}}>
                                            <label for="physically_disable_no"
                                                   class="custom-control-label">{{__('generic.no')}}</label>
                                        </div>
                                    </div>
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
                                                data-preselected-option="{{json_encode(['text' => optional($trainee->locDivision)->title, 'id' => optional($trainee->locDivision)->id])}}"
                                                data-label-fields="{title}"
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
                                                data-label-fields="{title}"
                                                data-preselected-option="{{json_encode(['text' => optional($trainee->locDistrict)->title, 'id' => optional($trainee->locDistrict)->id])}}"
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
                                                data-label-fields="{title}"
                                                data-preselected-option="{{json_encode(['text' => optional($trainee->locUpazila)->title, 'id' => optional($trainee->locUpazila)->id])}}"
                                                data-depend-on="loc_district_id:#loc_district_id"
                                                data-placeholder="নির্বাচন করুন"
                                        >
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group col-md-6">
                                    <label
                                        for="password">{{ __('generic.old_password') }}</label>
                                    <input type="password" class="form-control" name="old_password"
                                           id="old_password"
                                           placeholder="{{ __('generic.old_password') }}"
                                    >
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
                                           value="{{ __('admin.common.edit') }}">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <x-generic-validation-error-toastr></x-generic-validation-error-toastr>

    <script>
        const editForm = $('.edit-form');

        editForm.validate({
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
                division: {
                    required: true,
                },
                district: {
                    required: true,
                },
                upazila: {
                    required: false,
                },
                old_password: {
                    required: false,
                },
                password: {
                    required: false,
                },
                password_confirmation: {
                    equalTo: '#password',
                },
            }
        });

        function readURL(input) {
            if (input.files && input.files[0]) {
                let reader = new FileReader();
                reader.onload = function (e) {
                    $('.avatar-preview img').attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]); // convert to base64 string
            }
        }

        $(document).on('change', "#profile_pic", function () {
            readURL(this);
        });
    </script>
@endpush
