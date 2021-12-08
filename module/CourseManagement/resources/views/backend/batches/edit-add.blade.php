@php
    $edit = !empty($batch->id);
    /** @var \App\Models\User $authUser */
    $authUser = \App\Helpers\Classes\AuthHelper::getAuthUser();
@endphp

@extends('master::layouts.master')

@section('title')
    {{ ! $edit ? __('course_management::admin.batch.add') : __('course_management::admin.batch.update') }}
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card card-outline">
                    <div class="card-header d-flex justify-content-between custom-bg-gradient-info">
                        <h3 class="card-title font-weight-bold text-primary">{{ ! $edit ? __('course_management::admin.batch.add'): __('course_management::admin.batch.update') }}</h3>
                        <div>
                            <a href="{{route('course_management::admin.batches.index')}}"
                               class="btn btn-sm btn-rounded btn-outline-primary">
                                <i class="fas fa-backward"></i> {{__('course_management::admin.common.back')}}
                            </a>
                        </div>
                    </div>

                    <div class="card-body">
                        <form class="row edit-add-form" method="post"
                              action="{{ $edit ? route('course_management::admin.batches.update', [$batch->id]) : route('course_management::admin.batches.store')}}"
                              enctype="multipart/form-data">
                            @csrf
                            @if($edit)
                                @method('put')
                            @endif

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="title_en">{{__('course_management::admin.batch.title')}} <span
                                            style="color: red">*</span></label>
                                    <input type="text" class="form-control" id="title_en"
                                           name="title_en"
                                           placeholder="{{__('course_management::admin.batch.title')}} "
                                           value="{{ $edit ? $batch->title_en : old('title_en') }}">
                                    <input type="hidden" id="today">
                                </div>
                            </div>

                            @if($authUser->isInstituteUser())
                                <input type="hidden" id="institute_id" name="institute_id"
                                       value="{{$authUser->institute_id}}">
                            @else
                                <div class="form-group col-md-6">
                                    <label for="institute_id">{{__('course_management::admin.batch.institute_name')}} <span style="color: red">*</span></label>
                                    <select class="form-control select2-ajax-wizard"
                                            name="institute_id"
                                            id="institute_id"
                                            data-model="{{base64_encode(Module\CourseManagement\App\Models\Institute::class)}}"
                                            data-label-fields="{title_en}"
                                            data-dependent-fields="#course_id"
                                            @if($edit)
                                            data-preselected-option="{{json_encode(['text' =>  $batch->institute->title_en, 'id' =>  $batch->institute->id])}}"
                                            @endif
                                            data-placeholder="{{__('course_management::admin.batch.institute_name')}}"
                                    >
                                    </select>
                                </div>
                            @endif

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="publish_course_id">{{__('course_management::admin.batch.publish_course')}}  <span
                                            style="color: red">*</span></label>
                                    <select class="form-control select2-ajax-wizard"d
                                            name="publish_course_id"
                                            id="publish_course_id"
                                    >
                                        <option value="">Select</option>
                                        @foreach($publishCourses as $publishCourse)
                                            <option
                                                value="{{ $publishCourse->id}}" {{ $edit && $batch->publish_course_id == $publishCourse->id? 'selected':''}}>{{ $publishCourse->course->title_en }}</option>
                                        @endforeach

                                    </select>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="publish_course_id">{{__('course_management::admin.batch.training_center')}}
                                        <span style="color: red">*</span></label>
                                    <select class="form-control select2-ajax-wizard"
                                            name="training_center_id"
                                            id="training_center_id">
                                        <option value="">Select</option>
                                        @if($edit)
                                            @foreach($publishCourseTrainingCenters as $publishCourseTrainingCenter)
                                                <option
                                                    value="{{ $publishCourseTrainingCenter->id}}" {{ $batch->training_center_id == $publishCourseTrainingCenter->id? 'selected':''}} {{ $publishCourseTrainingCenter->title_en }}</option>
                                            @endforeach
                                        @else
                                            @foreach($trainingCenters as $trainingCenter)
                                                <option value="{{$trainingCenter->id}}">{{$trainingCenter->title_en}}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="code">{{__('course_management::admin.batch.code')}} <span style="color: red">*</span></label>
                                    <input type="text" class="form-control" id="code"
                                           name="code"
                                           data-code="{{ $edit ? $batch->code : '' }}"
                                           value="{{ $edit ? $batch->code : old('code') }}"
                                           placeholder="{{__('course_management::admin.batch.code')}}">
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="max_student_enrollment">{{__('course_management::admin.batch.max_student_enrollment')}}<span
                                            style="color: red">*</span></label>
                                    <input type="number" class="form-control" id="max_student_enrollment"
                                           name="max_student_enrollment"
                                           value="{{ $edit ? $batch->max_student_enrollment : old('max_student_enrollment') }}"
                                           placeholder="{{__('course_management::admin.batch.max_student_enrollment')}}">
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="start_date">{{__('course_management::admin.batch.start_date')}} <span
                                            style="color: red">*</span></label>
                                    <input type="text" class="flat-date flat-date-custom-bg start_date" id="start_date"
                                           name="start_date"
                                           value="{{ $edit ? $batch->start_date : old('start_date') }}"
                                    >
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="end_date">{{__('course_management::admin.batch.end_date')}} <span
                                            style="color: red">*</span></label>
                                    <input type="date" class="flat-date flat-date-custom-bg" id="end_date"
                                           name="end_date"
                                           value="{{ $edit ? $batch->end_date : old('end_date') }}"
                                    >
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="start_time">{{__('course_management::admin.batch.start_time')}} <span
                                            style="color: red">*</span></label>
                                    <input type="time" class="flat-time flat-time-custom-bg" id="start_time"
                                           name="start_time"
                                           value="{{ $edit ? $batch->start_time : old('start_time') }}"
                                    >
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="end_time">{{__('course_management::admin.batch.end_time')}}  <span
                                            style="color: red">*</span></label>
                                    <input type="time" class="flat-time flat-time-custom-bg" id="end_time"
                                           name="end_time"
                                           value="{{ $edit ? $batch->end_time : old('end_time') }}">
                                </div>
                            </div>


                            <div class="col-sm-12 text-right">
                                <button type="submit"
                                        class="btn btn-success">{{ $edit ? __('course_management::admin.batch.update') : __('course_management::admin.batch.add')}}</button>
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

        #publish_course_id-error, #training_center_id-error {
            position: absolute;
            left: 0;
            bottom: -12px;
        }
    </style>
@endpush

@push('js')
    <x-generic-validation-error-toastr></x-generic-validation-error-toastr>

    <script>
        const EDIT = !!'{{$edit}}';

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
                /*course_id: {
                    required: true
                },*/
                publish_course_id: {
                    required: true
                },
                training_center_id: {
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
                    greaterThan: "#start_time"
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
                    greaterThan: function () {
                        if (!EDIT) {
                            return 'Start Date will be greater than Today'
                        }
                    },
                },
                end_date: {
                    greaterThan: 'End Date will not be less than Start Date',
                },
                end_time: {
                    greaterThan: 'End Time will be greater than Start Time',
                },
            },
            submitHandler: function (htmlForm) {
                $('.overlay').show();
                htmlForm.submit();
            }
        });


        if (!EDIT) {
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

        $('#publish_course_id').change(function () {
            let publishCourseId = $(this).val();
            $.ajax({
                type: 'post',
                url: '{{route('course_management::admin.batch-training-centers')}}',
                data: {'publish_course_id': publishCourseId},
            }).then(function (res) {
                $("#training_center_id option").remove();
                $('#training_center_id').append('<option value="">' + 'Select' + '</option>');
                $.each(res, function (key, val) {
                    $('#training_center_id').append('<option value="' + val.id + '">' + val.title_en + '</option>');
                });
            });

            if (!publishCourseId) {
                $("#training_center_id option").remove();
            }
        });
    </script>
@endpush


