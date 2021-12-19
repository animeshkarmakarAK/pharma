@php
    $edit = !empty($user->id);
    /** @var \App\Models\User $authUser */
    $authUser = \App\Helpers\Classes\AuthHelper::getAuthUser();


@endphp

@extends('master::layouts.master')

@section('title')
    {{ ! $edit ? __('admin.course.edit') : __('admin.course.update') }}
@endsection

@section('content')
    <div class="container-fluid">
        <div class="card card-outline">
            <div class="card-body">
                <form class="row edit-add-form" method="post"
                      action="{{$edit ? route('admin.users.update', $user->id) : route('admin.users.store')}}"
                      enctype="multipart/form-data">
                    @csrf
                    @if($edit)
                        @method('put')
                    @endif
                    <div class="col-md-12">
                        <div class="row justify-content-center align-content-center">
                            <div class="form-group" style="width: 200px; height: 200px">
                                <div class="input-group">
                                    <div class="profile-upload-section">
                                        <div class="avatar-preview text-center">
                                            <label for="profile_pic">
                                                <img class="img-thumbnail rounded-circle"
                                                     src="{{$edit && $user->profile_pic ? asset('storage/'.$user->profile_pic) : 'https://via.placeholder.com/350x350?text=Profile+Picture'}}"
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
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="name">Name <span style="color: red"> * </span></label>
                            <input type="text" class="form-control" id="name"
                                   name="name"
                                   value="{{$edit ? $user->name : old('name')}}"
                                   placeholder="Name">
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="email">{{ __('Email') }} <span style="color: red"> * </span></label>
                            <input type="email" class="form-control" id="email"
                                   name="email"
                                   data-unique-user-email="{{ $edit ? $user->email : '' }}"
                                   value="{{$edit ? $user->email : old('email')}}"
                                   placeholder="{{ __('Email') }}">
                        </div>
                    </div>

                    @if($authUser->isSuperUser() ||  $authUser->isSystemUser() || $authUser->isInstituteUser())
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="user_type_id">{{ __('User Type') }} <span
                                        style="color: red"> * </span></label>
                                <select class="form-control select2-ajax-wizard"
                                        name="user_type_id"
                                        id="user_type_id"
                                        data-model="{{base64_encode(App\Models\UserType::class)}}"
                                        data-label-fields="{title}"
                                        @if($authUser->isInstituteUser())
                                        data-filters="{{json_encode(['id' => \App\Models\User::USER_TYPE_TRAINER_USER_CODE])}}"
                                        @endif
                                        @if($authUser->isSuperUser())
                                        data-filters="{{json_encode(['id' => [\App\Models\User::USER_TYPE_TRAINER_USER_CODE, 'type' => 'not-equal']])}}"
                                        @endif
                                        @if($edit)
                                        data-preselected-option="{{json_encode(['text' =>  $user->userType->title, 'id' =>  $user->userType->code])}}"
                                        @endif
                                        data-placeholder="{{ __('generic.select_placeholder') }}"
                                >
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6" style="display: none;">
                            <div class="form-group">
                                <label for="institute_id">{{ __('Institute') }} <span
                                        style="color: red"> * </span></label>
                                <select class="form-control select2-ajax-wizard"
                                        name="institute_id"
                                        id="institute_id"
                                        data-model="{{base64_encode(\App\Models\Institute::class)}}"
                                        data-label-fields="{title}"
                                        @if($edit && $user->institute)
                                        data-preselected-option="{{json_encode(['text' =>  $user->institute->title, 'id' =>  $user->institute->id])}}"
                                        @endif
                                        data-placeholder="{{ __('generic.select_placeholder') }}"
                                >
                                </select>
                            </div>
                        </div>


                        <div class="col-sm-6" style="display: none;">
                            <div class="form-group">
                                <label for="loc_district_id">{{ __('District') }} <span
                                        style="color: red"> * </span></label>
                                <select class="form-control select2-ajax-wizard"
                                        name="loc_district_id"
                                        id="loc_district_id"
                                        data-model="{{base64_encode(\App\Models\LocDistrict::class)}}"
                                        data-label-fields="{title}"
                                        @if($edit && $user->locDistrict)
                                        data-preselected-option="{{json_encode(['text' =>  $user->locDistrict->title, 'id' =>  $user->locDistrict->id])}}"
                                        @endif
                                        data-placeholder="{{ __('generic.select_placeholder') }}"
                                >
                                </select>
                            </div>
                        </div>

                        <div class="col-sm-6" style="display: none;">
                            <div class="form-group">
                                <label for="loc_division_id">{{ __('Division') }} <span
                                        style="color: red"> * </span></label>
                                <select class="form-control select2-ajax-wizard"
                                        name="loc_division_id"
                                        id="loc_division_id"
                                        data-model="{{base64_encode(\App\Models\LocDivision::class)}}"
                                        data-label-fields="{title}"
                                        @if($edit && $user->locDivision)
                                        data-preselected-option="{{json_encode(['text' =>  $user->locDivision->title, 'id' =>  $user->locDivision->id])}}"
                                        @endif
                                        data-placeholder="{{ __('generic.select_placeholder') }}"
                                >
                                </select>
                            </div>
                        </div>
                    @elseif($authUser->isInstituteUser())
                        <input type="hidden" name="user_type_id" id="user_type_id"
                               value="{{\App\Models\UserType::USER_TYPE_INSTITUTE_USER_CODE}}">
                        <input type="hidden" name="institute_id" id="institute_id" value="{{$authUser->institute_id}}">
                    @elseif($authUser->isDCUser())
                        <input type="hidden" name="user_type_id" id="user_type_id"
                               value="{{\App\Models\UserType::USER_TYPE_BRANCH_USER_CODE}}">
                        <input type="hidden" name="loc_district_id" id="loc_district_id"
                               value="{{$authUser->loc_district_id}}">
                    @elseif($authUser->isDivcomUser())
                        <input type="hidden" name="user_type_id" id="user_type_id"
                               value="{{\App\Models\UserType::USER_TYPE_TRAINING_CENTER_USER_CODE}}">
                        <input type="hidden" name="loc_division_id" id="loc_division_id"
                               value="{{$authUser->loc_division_id}}">
                    @endif

                    @if($edit && $authUser->id == $user->id && $authUser->can('changePassword', $user))
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="old_password">{{ __('Old Password') }}<span
                                        style="color: red"> * </span></label>
                                <input type="password" class="form-control" id="old_password"
                                       name="old_password"
                                       value=""
                                       placeholder="{{ __('Old Password') }}">
                            </div>
                        </div>
                    @endif

                    @if(!$edit || $authUser->can('changePassword', $user))
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="password">{{ __($edit ? 'New Password' : 'Password') }} <span
                                        style="color: red"> * </span></label>
                                <input type="password" class="form-control" id="password"
                                       name="password"
                                       value=""
                                       placeholder="{{ __($edit ? 'New Password' : 'Password') }}">
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label
                                    for="password_confirmation">{{ __($edit ? 'Retype New Password' : 'Retype Password') }}
                                    <span style="color: red"> * </span></label>
                                <input type="password" class="form-control" id="password_confirmation"
                                       name="password_confirmation"
                                       value=""
                                       placeholder="{{ __($edit ? 'Retype New Password' : 'Retype Password') }}">
                            </div>
                        </div>

                    @endif
                    <div class="col-sm-12 text-right">
                        <button type="submit" class="btn btn-success j8">{{$edit ? 'Update' : 'Create'}}</button>
                    </div>
                </form>
            </div><!-- /.card-body -->
            <div class="overlay" style="display: none">
                <i class="fas fa-2x fa-sync-alt fa-spin"></i>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <x-generic-validation-error-toastr></x-generic-validation-error-toastr>

    <script>
        const EDIT = !!'{{$edit}}';
        const INSTITUTE_USER = parseInt('{{ \App\Models\UserType::USER_TYPE_INSTITUTE_USER_CODE }}');
        const isInstituteUser = {!! $authUser->isInstituteUser() !!}

        $(function () {

            function disabledHideFormFields(...fields) {
                fields.forEach(function (field) {
                    field.prop('disabled', true);
                    field.parent().parent().hide();
                });
            }

            function enableShowFormFields(...fields) {
                fields.forEach(function (field) {
                    field.prop('disabled', false);
                    field.parent().parent().show();
                });
            }

            $(document).on('change', "#user_type_id", function () {
                let userType = parseInt($(this).val());


                switch (userType) {
                    case {!! \App\Models\UserType::USER_TYPE_TRAINING_CENTER_USER_CODE !!}:
                        enableShowFormFields($('#institute_id'));
                        disabledHideFormFields($('#organization_id'), $('#loc_district_id'), $('#loc_division_id'));
                        break;
                    case {!! \App\Models\UserType::USER_TYPE_BRANCH_USER_CODE !!}:
                        enableShowFormFields($('#institute_id'));
                        disabledHideFormFields($('#organization_id'), $('#loc_district_id'), $('#loc_division_id'));
                        break;
                    case {!! \App\Models\UserType::USER_TYPE_INSTITUTE_USER_CODE !!}:
                        enableShowFormFields($('#institute_id'));
                        disabledHideFormFields($('#organization_id'), $('#loc_district_id'), $('#loc_division_id'));
                        break;
                    case {!! \App\Models\UserType::USER_TYPE_TRAINER_USER_CODE !!}:
                        enableShowFormFields($('#institute_id'));
                        disabledHideFormFields($('#organization_id'), $('#loc_district_id'), $('#loc_division_id'));
                        break;
                    default:
                        disabledHideFormFields($('#institute_id'), $('#loc_district_id'), $('#organization_id'), $('#loc_division_id'));
                }

            })

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


            $(".edit-add-form").validate({
                    rules: {
                        profile_pic: {
                            accept: "image/*",
                        },
                        name: {
                            required: true,
                            pattern: /^[a-zA-Z0-9 ]*$/,
                        },
                        email: {
                            required: true,
                            pattern: /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/,
                            /*remote: {
                                param: {
                                    type: "post",
                                    url: "{{ route('admin.users.check-unique-user-email') }}",
                                },
                                depends: function (element) {
                                    return $(element).val() !== $('#email').attr('data-unique-user-email');
                                }
                            },*/
                        },
                        user_type_id: {
                            required: true
                        },
                        institute_id: {
                            required: function () {
                                if($('#user_type_id').val() == {!! \App\Models\UserType::USER_TYPE_INSTITUTE_USER_CODE !!} ||
                                    $('#user_type_id').val() == {!! \App\Models\UserType::USER_TYPE_BRANCH_USER_CODE !!} ||
                                    $('#user_type_id').val() == {!! \App\Models\UserType::USER_TYPE_TRAINING_CENTER_USER_CODE !!}){
                                    return true;
                                }else return false;
                            }
                        },
                        old_password: {
                            required: function () {
                                return !!$('#password').val().length;
                            },
                        },
                        password: {
                            required: !EDIT,
                        },
                        password_confirmation: {
                            equalTo: '#password',
                        },
                    },
                    messages: {
                        profile_pic: {
                            accept: "Please input valid image file",
                        },
                        name: {
                            pattern: "Please fill this field in English."
                        },
                    },
                    submitHandler: function (htmlForm) {
                        $('.overlay').show();
                        let formData = new FormData(htmlForm);
                        let jForm = $(htmlForm);
                        $.ajax({
                            url: jForm.prop('action'),
                            method: jForm.prop('method'),
                            data: formData,
                            enctype: 'multipart/form-data',
                            cache: false,
                            contentType: false,
                            processData: false,
                        })
                            .done(function (responseData) {
                                console.log(responseData)
                                if (responseData.message == 'Something wrong. Please try again') {
                                    toastr.error(responseData.message);
                                } else {
                                    toastr.success(responseData.message);
                                }
                            })
                            .fail(window.ajaxFailedResponseHandler)
                            .always(function () {
                                //datatable.draw();
                                $('.overlay').hide();
                            });
                        return false;
                    }
                });


        });

    </script>
@endpush
