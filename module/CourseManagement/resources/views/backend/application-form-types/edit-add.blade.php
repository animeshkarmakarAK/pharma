@php
    $edit = !empty($applicationFormType->id);
    /** @var \App\Models\User $authUser */
    $authUser = \App\Helpers\Classes\AuthHelper::getAuthUser();
@endphp

@extends('master::layouts.master')

@section('title')
    {{ ! $edit ? __('course_management::admin.application_form_type.add') : __('course_management::admin.application_form_type.update') }}
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card card-outline">
                    <div class="card-header d-flex justify-content-between custom-bg-gradient-info">
                        <h3 class="card-title font-weight-bold text-primary">{{ ! $edit ? __('course_management::admin.application_form_type.add') : __('course_management::admin.application_form_type.update') }}</h3>
                        <div>
                            <a href="{{route('course_management::admin.application-form-types.index')}}"
                               class="btn btn-sm btn-rounded btn-outline-primary">
                                <i class="fas fa-backward"></i>{{__('course_management::admin.common.back')}}
                            </a>
                        </div>
                    </div>

                    <div class="card-body">
                        <form class="row edit-add-form" method="post"
                              action="{{ $edit ? route('course_management::admin.application-form-types.update', [$applicationFormType->id]) : route('course_management::admin.application-form-types.store')}}">
                            @csrf
                            @if($edit)
                                @method('put')
                            @endif
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="title_en">{{ __('course_management::admin.application_form_type.name') }} <span
                                            style="color: red"> * </span></label>
                                    <input type="text" class="form-control" id="title_en"
                                           name="title_en"
                                           value="{{ $edit ? $applicationFormType->title_en : old('title_en') }}"
                                           placeholder="{{ __('Name') . ' (English)' }}">
                                </div>
                            </div>

                            @if($authUser->isInstituteUser())
                                <input type="hidden" id="institute_id" name="institute_id"
                                       value="{{$authUser->institute_id}}">
                            @else
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="institute_id">{{ __('course_management::admin.application_form_type.institute_name') }} <span
                                                style="color: red"> * </span></label>
                                        <select class="form-control select2-ajax-wizard"
                                                name="institute_id"
                                                id="institute_id"
                                                data-model="{{base64_encode(\Module\CourseManagement\App\Models\Institute::class)}}"
                                                data-label-fields="{title_en}"
                                                @if($edit)
                                                data-preselected-option="{{json_encode(['text' =>  $applicationFormType->institute->title_en, 'id' =>  $applicationFormType->institute->id])}}"
                                                @endif
                                                data-placeholder="{{ __('generic.select_placeholder') }}"
                                        >
                                        </select>
                                    </div>
                                </div>
                            @endif

                            <div class="col-12">
                                <div class="card card-outline">
                                    <div class="card-header d-flex justify-content-between custom-bg-gradient-info">
                                        <h3 class="card-title font-weight-bold text-primary">{{ __('course_management::admin.application_form_type.education_information_show') }} </h3>
                                    </div>

                                    <div class="card-body">
                                        <div class="col-12 card-body row">
                                            <div class="col-sm-2">
                                                <div class="form-group">
                                                    <input type="hidden" name="jsc" id="jsc"
                                                           value="{{ $edit ? $applicationFormType->jsc:0 }}">
                                                    <input type="checkbox"
                                                           id="jsc_c" {{ $edit ? $applicationFormType->jsc=='1'?'checked': '' : '' }}>
                                                    <label for="jsc_c">{{ __('course_management::admin.application_form_type.jsc_exam') }} </label>

                                                </div>
                                            </div>

                                            <div class="col-sm-2">
                                                <div class="form-group">
                                                    <input type="hidden" name="ssc" id="ssc"
                                                           value="{{ $edit ? $applicationFormType->ssc:0 }}">
                                                    <input type="checkbox"
                                                           id="ssc_c" {{ $edit ? $applicationFormType->ssc=='1'?'checked': '' : '' }}>
                                                    <label for="ssc_c">{{ __('course_management::admin.application_form_type.ssc_exam') }}  </label>

                                                </div>
                                            </div>

                                            <div class="col-sm-2">
                                                <div class="form-group">
                                                    <input type="hidden" name="hsc" id="hsc"
                                                           value="{{ $edit ? $applicationFormType->hsc:0 }}">
                                                    <input type="checkbox"
                                                           id="hsc_c"{{ $edit ? $applicationFormType->hsc=='1'?'checked': '' : '' }}>
                                                    <label for="hsc_c">{{ __('course_management::admin.application_form_type.hsc_exam') }} </label>

                                                </div>
                                            </div>

                                            <div class="col-sm-3">
                                                <div class="form-group">
                                                    <input type="hidden" name="honors" id="honors"
                                                           value="{{ $edit ? $applicationFormType->honors:0 }}">
                                                    <input type="checkbox"
                                                           id="honors_c"{{ $edit ? $applicationFormType->honors=='1'?'checked': '' : '' }}>
                                                    <label for="honors_c">{{ __('course_management::admin.application_form_type.honors_exam') }} </label>
                                                </div>
                                            </div>

                                            <div class="col-sm-3">
                                                <div class="form-group">
                                                    <input type="hidden" name="masters" id="masters"
                                                           value="{{ $edit ? $applicationFormType->masters:0 }}">
                                                    <input type="checkbox"
                                                           id="masters_c" {{ $edit ? $applicationFormType->masters=='1'?'checked': '' : '' }}>
                                                    <label for="masters_c"> {{ __('course_management::admin.application_form_type.masters_exam') }}</label>

                                                </div>
                                            </div>

                                        </div>

                                    </div><!-- /.card-body -->

                                </div>
                            </div>
                            <div class="col-12">
                                <div class="card card-outline ">
                                    <div class="card-header d-flex justify-content-between custom-bg-gradient-info">
                                        <h3 class="card-title font-weight-bold text-primary">{{ __('course_management::admin.application_form_type.additional_information_show') }}</h3>
                                    </div>

                                    <div class="card-body">

                                        <div class="col-12 card-body row">


                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <input type="hidden" name="disable_status" id="disable_status"
                                                           value="{{ $edit ? $applicationFormType->disable_status:0 }}">
                                                    <input type="checkbox"
                                                           id="disable_status_c" {{ $edit ? $applicationFormType->disable_status=='1'?'checked': '' : '' }}>
                                                    <label for="disable_status_c">{{ __('course_management::admin.application_form_type.physical_disability') }} </label>

                                                </div>
                                            </div>

                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <input type="hidden" name="occupation" id="occupation"
                                                           value="{{ $edit ? $applicationFormType->occupation:0 }}">
                                                    <input type="checkbox"
                                                           id="occupation_c" {{ $edit ? $applicationFormType->occupation=='1'?'checked': '' : '' }}>
                                                    <label for="occupation_c"> {{ __('course_management::admin.application_form_type.occupation_information') }}</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="card card-outline">
                                    <div class="card-header d-flex justify-content-between custom-bg-gradient-info">
                                        <h3 class="card-title font-weight-bold text-primary">
                                            {{ __('course_management::admin.application_form_type.other_information_show') }}
                                        </h3>
                                    </div>

                                    <div class="card-body">

                                        <div class="col-12 card-body row">

                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <input type="hidden" name="ethnic" id="ethnic"
                                                           value="{{ $edit ? $applicationFormType->ethnic:0 }}">
                                                    <input type="checkbox"
                                                           id="ethnic_c" {{ $edit ? $applicationFormType->ethnic=='1'?'checked': '' : '' }}>
                                                    <label for="ethnic_c">{{ __('course_management::admin.application_form_type.ethnic_group') }}</label>
                                                </div>
                                            </div>

                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <input type="hidden" name="freedom_fighter" id="freedom_fighter"
                                                           value="{{ $edit ? $applicationFormType->freedom_fighter:0 }}">
                                                    <input type="checkbox"
                                                           id="freedom_fighter_c" {{ $edit ? $applicationFormType->freedom_fighter=='1'?'checked': '' : '' }}>
                                                    <label for="freedom_fighter_c">{{ __('course_management::admin.application_form_type.freedom_fighter') }} </label>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <input type="hidden" name="guardian" id="guardian"
                                                           value="{{ $edit ? $applicationFormType->guardian:0 }}">
                                                    <input type="checkbox"
                                                           id="guardian_c" {{ $edit ? $applicationFormType->guardian=='1'?'checked': '' : '' }}>
                                                    <label for="guardian_c"> {{ __('course_management::admin.application_form_type.guardian') }} </label>
                                                </div>
                                            </div>

                                        </div>

                                    </div><!-- /.card-body -->

                                </div>
                            </div>

                            <div class="col-sm-12 text-right">
                                <button type="submit"
                                        class="btn btn-success">{{ $edit ? __('course_management::admin.common.update')  : __('course_management::admin.common.add')  }}</button>
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
    <x-generic-validation-error-toastr></x-generic-validation-error-toastr>

    <script>
        const EDIT = !!'{{$edit}}';

        $('input[type="checkbox"]').change(function () {
            $(this).siblings('input').val(Number(this.checked));
        });


        const editAddForm = $('.edit-add-form');
        editAddForm.validate({
            rules: {
                title_en: {
                    required: true,
                    pattern: /^[a-zA-Z0-9 ]*$/,
                },
                institute_id: {
                    required: true
                },
            },
            messages: {
                title_en: {
                    pattern: "Please fill this field in English"
                }
            },
            submitHandler: function (htmlForm) {
                $('.overlay').show();
                htmlForm.submit();
            }
        });

        $(document).ready(function () {
            $('#jsc_c').on('click', function () {
                if ($(this).prop('checked') == false) {
                    $('#ssc_c').prop('checked', false);
                    $('#hsc_c').prop('checked', false);
                    $('#honors_c').prop('checked', false);
                    $('#masters_c').prop('checked', false);

                    $("#jsc").val(0);
                    $("#ssc").val(0);
                    $("#hsc").val(0);
                    $("#honors").val(0);
                    $("#masters").val(0);
                }else{
                    $('#jsc_c').prop('checked', true);
                    $("#jsc").val(1);
                }
            })

            $('#ssc_c').on('click', function () {
                if ($(this).prop('checked') == true) {
                    $('#jsc_c').prop('checked', true);

                    $("#jsc").val(1);
                    $("#ssc").val(1);
                }else{
                    $('#hsc_c').prop('checked', false);
                    $('#honors_c').prop('checked', false);
                    $('#masters_c').prop('checked', false);

                    $("#ssc").val(0);
                    $("#hsc").val(0);
                    $("#honors").val(0);
                    $("#masters").val(0);
                }
            })

            $('#hsc_c').on('click', function () {
                if ($(this).prop('checked') == true) {
                    $('#jsc_c').prop('checked', true);
                    $('#ssc_c').prop('checked', true);

                    $("#jsc").val(1);
                    $("#ssc").val(1);
                    $("#hsc").val(1);
                } else {
                    $('#honors_c').prop('checked', false);
                    $('#masters_c').prop('checked', false);

                    $("#honors").val(0);
                    $("#masters").val(0);
                }
            })

            $('#honors_c').on('click', function () {
                if ($(this).prop('checked') == true) {
                    $('#jsc_c').prop('checked', true);
                    $('#ssc_c').prop('checked', true);
                    $('#hsc_c').prop('checked', true);

                    $("#jsc").val(1);
                    $("#ssc").val(1);
                    $("#hsc").val(1);
                    $("#honors").val(1);
                } else {
                    $('#masters_c').prop('checked', false);

                    $("#masters").val(0);
                }
            })

            $('#masters_c').on('click', function () {
                if ($(this).prop('checked') == true) {
                    $('#jsc_c').prop('checked', true);
                    $('#ssc_c').prop('checked', true);
                    $('#hsc_c').prop('checked', true);
                    $('#honors_c').prop('checked', true);

                    $("#jsc").val(1);
                    $("#ssc").val(1);
                    $("#hsc").val(1);
                    $("#honors").val(1);
                    $("#masters").val(1);
                }
            })
        });
    </script>
@endpush


