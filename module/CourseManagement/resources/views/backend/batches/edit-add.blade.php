@php
    $edit = !empty($batch->id);
    /** @var \App\Models\User $authUser */
    $authUser = \App\Helpers\Classes\AuthHelper::getAuthUser();
@endphp

@extends('master::layouts.master')

@section('title')
    {{ ! $edit ? 'Add Batch' : 'Update Batch' }}
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card card-outline">
                    <div class="card-header d-flex justify-content-between custom-bg-gradient-info">
                        <h3 class="card-title font-weight-bold text-primary">{{ ! $edit ? 'Add Batch' : 'Update Batch' }}</h3>
                        <div>
                            <a href="{{route('course_management::admin.batches.index')}}"
                               class="btn btn-sm btn-rounded btn-outline-primary">
                                <i class="fas fa-backward"></i> Back to list
                            </a>
                        </div>
                    </div>

                    <div class="card-body">
                        <form class="row edit-add-form" method="post"
                              action="{{ $edit ? route('course_management::admin.batches.update', [$batch->id]) : route('course_management::admin.batches.store')}}">
                            @csrf
                            @if($edit)
                                @method('put')
                            @endif

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="title_en">{{ __('Title (En) ') }} <span
                                            style="color: red">*</span></label>
                                    <input type="text" class="form-control" id="title_en"
                                           name="title_en"
                                           value="{{ $edit ? $batch->title_en : old('title_en') }}">
                                    <input type="hidden" id="today">
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="title_bn">{{ __('Title (Bn) ') }} <span
                                            style="color: red">*</span></label>
                                    <input type="text" class="form-control" id="title_bn"
                                           name="title_bn"
                                           value="{{ $edit ? $batch->title_bn : old('title_bn') }}">
                                </div>
                            </div>

                            @if($authUser->isInstituteUser())
                                <input type="hidden" id="institute_id" name="institute_id"
                                       value="{{$authUser->institute_id}}">
                            @else
                                <div class="form-group col-md-6">
                                    <label for="institute_id">Institute Name <span style="color: red">*</span></label>
                                    <select class="form-control select2-ajax-wizard"
                                            name="institute_id"
                                            id="institute_id"
                                            data-model="{{base64_encode(Module\CourseManagement\App\Models\Institute::class)}}"
                                            data-label-fields="{title_en}"
                                            data-dependent-fields="#course_id"
                                            @if($edit)
                                            data-preselected-option="{{json_encode(['text' =>  $batch->institute->title_en, 'id' =>  $batch->institute->id])}}"
                                            @endif
                                            data-placeholder="নির্বাচন করুন"
                                    >
                                    </select>
                                </div>
                            @endif


                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="course_id">{{ __('Course Name') }} <span
                                            style="color: red">*</span></label>
                                    <select class="form-control select2-ajax-wizard"
                                            name="course_id"
                                            id="course_id"
                                            data-model="{{base64_encode(Module\CourseManagement\App\Models\Course::class)}}"
                                            data-label-fields="{title_en}"
                                            data-depend-on="institute_id"
                                            @if($edit)
                                            data-preselected-option="{{json_encode(['text' =>  $batch->course->title_en, 'id' =>  $batch->course->id])}}"
                                            @endif
                                            data-placeholder="নির্বাচন করুন"
                                    >
                                    </select>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="code">{{ __('Code') }} <span style="color: red">*</span></label>
                                    <input type="text" class="form-control" id="code"
                                           name="code"
                                           data-code="{{ $edit ? $batch->code : '' }}"
                                           value="{{ $edit ? $batch->code : old('code') }}"
                                           placeholder="{{ __('Code') }}">
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="max_student_enrollment">{{ __('Max Student Enrollment') }} <span
                                            style="color: red">*</span></label>
                                    <input type="number" class="form-control" id="max_student_enrollment"
                                           name="max_student_enrollment"
                                           value="{{ $edit ? $batch->max_student_enrollment : old('max_student_enrollment') }}"
                                           placeholder="{{ __('Max Student Enrollment') }}">
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="start_date">{{ __('Batch Start Date') }} <span
                                            style="color: red">*</span></label>
                                    <input type="text" class="flat-date flat-date-custom-bg start_date" id="start_date"
                                           name="start_date"
                                           value="{{ $edit ? $batch->start_date : old('start_date') }}"
                                    >
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="end_date">{{ __('Batch End Date') }} <span
                                            style="color: red">*</span></label>
                                    <input type="date" class="flat-date flat-date-custom-bg" id="end_date"
                                           name="end_date"
                                           value="{{ $edit ? $batch->end_date : old('end_date') }}"
                                    >
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="start_time">{{ __('Batch Start Time') }} <span
                                            style="color: red">*</span></label>
                                    <input type="time" class="flat-time flat-time-custom-bg" id="start_time"
                                           name="start_time"
                                           value="{{ $edit ? $batch->start_time : old('start_time') }}"
                                    >
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="end_time">{{ __('Batch End Time') }} <span
                                            style="color: red">*</span></label>
                                    <input type="time" class="flat-time flat-time-custom-bg" id="end_time"
                                           name="end_time"
                                           value="{{ $edit ? $batch->end_time : old('end_time') }}">
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
@push('css')
    <style>
        .flat-date-custom-bg, .flat-time-custom-bg {
            background-color: #fafdff !important;
        }

        .has-error {
            position: relative;
            padding: 0 0 12px 0;
        }

        #institute_id-error, #application_form_type_id-error, #course_id-error, #start_date-error, #end_date-error, #start_time-error, #end_time-error {
            position: absolute;
            left: 6px;
            bottom: -9px;
        }
    </style>
@endpush

@push('js')
    <x-generic-validation-error-toastr></x-generic-validation-error-toastr>

    <script>
        const EDIT = !!'{{$edit}}';


        console.log('Edit: '+ !EDIT? "#today":'test',)

        const editAddForm = $('.edit-add-form');
        editAddForm.validate({
            rules: {
                title_en: {
                    required: true,
                    pattern: /^[a-zA-Z0-9 ]*$/,
                },
                title_bn: {
                    required: true,
                    pattern: /^[\s'\u0980-\u09ff]+$/,
                },
                institute_id: {
                    required: true
                },
                course_id: {
                    required: true
                },
                code: {
                    required: true,
                    remote: {
                        param: {
                            type: "post",
                            url: "{{ route('course_management::admin.check-batch-code') }}",
                        },
                        depends: function (element) {
                            return $(element).val() !== $('#code').attr('data-code');
                        }
                    },

                },
                max_student_enrollment: {
                    required: true,
                    number: true,
                    min: 1,
                },
                start_date: {
                    required: true,
                    greaterThan: "#today"
                },
                end_date: {
                    required: true,
                    greaterThan: ".start_date"
                },
                start_time: {
                    required: true,
                },
                end_time: {
                    required: true,
                },

            },
            messages: {
                title_en: {
                    pattern: "This field is required in English."
                },
                title_bn: {
                    pattern: "This field is required in Bangla."
                },
                start_date: {
                    greaterThan: function (){
                        if(!EDIT){
                            return 'Start Date will be greater than Today'
                        }
                    },
                },
                end_date: {
                    greaterThan: 'End Date will not be less than Start Date',
                }
            },
            submitHandler: function (htmlForm) {
                $('.overlay').show();
                htmlForm.submit();
            }
        });


        if(!EDIT){
            let today = new Date();
            today = today.getFullYear() + '-' + ("0" + (today.getMonth() + 1)).slice(-2) + '-' + ("0" + (today.getDate() - 0)).slice(-2);
            $('#today').val(today);
            console.log($('#today').val())
        }

        $('#start_date').on('change', function () {
            console.log($('.start_date').val());
        })


        $('#start_date').change(function () {
            if ($(this).val() != "") {
                $(this).valid();
            }
        });

        $('#end_date').change(function () {
            if ($(this).val() != "") {
                $(this).valid();
            }
        });

        $('#start_time').change(function () {
            if ($(this).val() != "") {
                $(this).valid();
            }
        });
        $('#end_time').change(function () {
            if ($(this).val() != "") {
                $(this).valid();
            }
        });

    </script>
@endpush


