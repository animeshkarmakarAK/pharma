@php
    $edit = !empty($applicationFormType->id);
    /** @var \App\Models\User $authUser */
    $authUser = \App\Helpers\Classes\AuthHelper::getAuthUser();
@endphp

@extends('master::layouts.master')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card card-outline">
                    <div class="card-header d-flex justify-content-between custom-bg-gradient-info">
                        <h3 class="card-title font-weight-bold text-primary">{{ ! $edit ? 'Add Application Form Type' : 'Update application Form Type' }}</h3>
                        <div>
                            <a href="{{route('course_management::admin.application-form-types.index')}}"
                               class="btn btn-sm btn-rounded btn-outline-primary">
                                <i class="fas fa-backward"></i> Back to list
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
                                    <label for="title_en">{{ __('Name') . '(English)' }} <span
                                            style="color: red"> * </span></label>
                                    <input type="text" class="form-control" id="title_en"
                                           name="title_en"
                                           value="{{ $edit ? $applicationFormType->title_en : old('title_en') }}"
                                           placeholder="{{ __('Name') }}">
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="title_bn">{{ __('Name') . '(Bangla)' }} <span
                                            style="color: red"> * </span></label>
                                    <input type="text" class="form-control" id="title_bn"
                                           name="title_bn"
                                           value="{{ $edit ? $applicationFormType->title_bn : old('title_bn') }}"
                                           placeholder="{{ __('Name') }}">
                                </div>
                            </div>

                            @if($authUser->isInstituteUser())
                                <input type="hidden" id="institute_id" name="institute_id"
                                       value="{{$authUser->institute_id}}">
                            @else
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="institute_id">{{ __('Institute Name') }}<span
                                                style="color: red"> * </span></label>
                                        <select class="form-control select2-ajax-wizard"
                                                name="institute_id"
                                                id="institute_id"
                                                data-model="{{base64_encode(\Module\CourseManagement\App\Models\Institute::class)}}"
                                                data-label-fields="{title_en}"
                                                @if($edit)
                                                data-preselected-option="{{json_encode(['text' =>  $applicationFormType->institute->title_en, 'id' =>  $applicationFormType->institute->id])}}"
                                                @endif
                                                data-placeholder="নির্বাচন করুন"
                                        >
                                        </select>
                                    </div>
                                </div>
                            @endif

                            <div class="col-12">
                                <div class="card card-outline">
                                    <div class="card-header d-flex justify-content-between custom-bg-gradient-info">
                                        <h3 class="card-title font-weight-bold text-primary">Educational Information To
                                            Show</h3>
                                    </div>

                                    <div class="card-body">

                                        <div class="col-12 card-body row">


                                            <div class="col-sm-3">
                                                <div class="form-group">
                                                    <input type="hidden" name="ssc" id="ssc"
                                                           value="{{ $edit ? $applicationFormType->ssc:0 }}">
                                                    <input type="checkbox"
                                                           id="ssc_c" {{ $edit ? $applicationFormType->ssc=='1'?'checked': '' : '' }}>
                                                    <label for="ssc_c">SSC Exam </label>

                                                </div>
                                            </div>

                                            <div class="col-sm-3">
                                                <div class="form-group">
                                                    <input type="hidden" name="hsc" id="hsc"
                                                           value="{{ $edit ? $applicationFormType->hsc:0 }}">
                                                    <input type="checkbox"
                                                           id="hsc_c"{{ $edit ? $applicationFormType->hsc=='1'?'checked': '' : '' }}>
                                                    <label for="hsc_c">HSC Exam </label>

                                                </div>
                                            </div>

                                            <div class="col-sm-3">
                                                <div class="form-group">
                                                    <input type="hidden" name="honors" id="honors"
                                                           value="{{ $edit ? $applicationFormType->honors:0 }}">
                                                    <input type="checkbox"
                                                           id="honors_c"{{ $edit ? $applicationFormType->honors=='1'?'checked': '' : '' }}>
                                                    <label for="honors_c">Honors Exam </label>
                                                </div>
                                            </div>

                                            <div class="col-sm-3">
                                                <div class="form-group">
                                                    <input type="hidden" name="masters" id="masters"
                                                           value="{{ $edit ? $applicationFormType->masters:0 }}">
                                                    <input type="checkbox"
                                                           id="masters_c" {{ $edit ? $applicationFormType->masters=='1'?'checked': '' : '' }}>
                                                    <label for="masters_c"> Masters Exam </label>

                                                </div>
                                            </div>

                                        </div>

                                    </div><!-- /.card-body -->

                                </div>
                            </div>
                            <div class="col-12">
                                <div class="card card-outline ">
                                    <div class="card-header d-flex justify-content-between custom-bg-gradient-info">
                                        <h3 class="card-title font-weight-bold text-primary">Additional information to
                                            show</h3>
                                    </div>

                                    <div class="card-body">

                                        <div class="col-12 card-body row">


                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <input type="hidden" name="disable_status" id="disable_status"
                                                           value="{{ $edit ? $applicationFormType->disable_status:0 }}">
                                                    <input type="checkbox"
                                                           id="disable_status_c" {{ $edit ? $applicationFormType->disable_status=='1'?'checked': '' : '' }}>
                                                    <label for="disable_status_c">Physical Disability </label>

                                                </div>
                                            </div>

                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <input type="hidden" name="occupation" id="occupation"
                                                           value="{{ $edit ? $applicationFormType->occupation:0 }}">
                                                    <input type="checkbox"
                                                           id="occupation_c" {{ $edit ? $applicationFormType->occupation=='1'?'checked': '' : '' }}>
                                                    <label for="occupation_c"> Occupation Information </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="card card-outline">
                                    <div class="card-header d-flex justify-content-between custom-bg-gradient-info">
                                        <h3 class="card-title font-weight-bold text-primary">Guardian information to
                                            show</h3>
                                    </div>

                                    <div class="card-body">

                                        <div class="col-12 card-body row">

                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <input type="hidden" name="ethnic" id="ethnic"
                                                           value="{{ $edit ? $applicationFormType->ethnic:0 }}">
                                                    <input type="checkbox"
                                                           id="ethnic_c" {{ $edit ? $applicationFormType->ethnic=='1'?'checked': '' : '' }}>
                                                    <label for="ethnic_c">Ethnic Group </label>
                                                </div>
                                            </div>

                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <input type="hidden" name="freedom_fighter" id="freedom_fighter"
                                                           value="{{ $edit ? $applicationFormType->freedom_fighter:0 }}">
                                                    <input type="checkbox"
                                                           id="freedom_fighter_c" {{ $edit ? $applicationFormType->freedom_fighter=='1'?'checked': '' : '' }}>
                                                    <label for="freedom_fighter_c">Freedom Fighter </label>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <input type="hidden" name="guardian" id="guardian"
                                                           value="{{ $edit ? $applicationFormType->guardian:0 }}">
                                                    <input type="checkbox"
                                                           id="guardian_c" {{ $edit ? $applicationFormType->guardian=='1'?'checked': '' : '' }}>
                                                    <label for="guardian_c"> Guardian Information </label>
                                                </div>
                                            </div>

                                        </div>

                                    </div><!-- /.card-body -->

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
                    required: true
                },
                title_bn: {
                    required: true,
                    pattern: "^[\\s-'\u0980-\u09ff]{1,255}$",

                },
                institute_id: {
                    required: true
                },
            },
            messages: {
                title_bn: {
                    pattern: "Please fill this field in Bangla"
                },
            },
            submitHandler: function (htmlForm) {
                $('.overlay').show();
                htmlForm.submit();
            }
        });

        $(document).ready(function () {
            $('#ssc_c').on('click', function () {
                if ($(this).prop('checked') == false) {
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
                    $('#ssc_c').prop('checked', true);

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
                    $('#ssc_c').prop('checked', true);
                    $('#hsc_c').prop('checked', true);

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
                    $('#ssc_c').prop('checked', true);
                    $('#hsc_c').prop('checked', true);
                    $('#honors_c').prop('checked', true);

                    $("#ssc").val(1);
                    $("#hsc").val(1);
                    $("#honors").val(1);
                    $("#masters").val(1);
                }
            })
        });
    </script>
@endpush


