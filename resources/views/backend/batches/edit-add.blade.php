@php
    $edit = !empty($batch->id);
    /** @var \App\Models\User $authUser */
    $authUser = \App\Helpers\Classes\AuthHelper::getAuthUser();
@endphp

@extends('master::layouts.master')

@section('title')
    {{ ! $edit ? __('admin.batch.add') : __('admin.batch.update') }}
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card card-outline">
                    <div class="card-header d-flex justify-content-between custom-bg-gradient-info">
                        <h3 class="card-title font-weight-bold text-primary">{{ ! $edit ? __('admin.batch.add'): __('admin.batch.update') }}</h3>
                        <div>
                            <a href="{{route('admin.batches.index')}}"
                               class="btn btn-sm btn-rounded btn-outline-primary">
                                <i class="fas fa-backward"></i> {{__('admin.common.back')}}
                            </a>
                        </div>
                    </div>

                    <div class="card-body">
                        <form class="row edit-add-form" method="post"
                              action="{{ $edit ? route('admin.batches.update', [$batch->id]) : route('admin.batches.store')}}"
                              enctype="multipart/form-data">
                            @csrf
                            @if($edit)
                                @method('put')
                            @endif

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="title">{{__('admin.batch.title')}} <span
                                            style="color: red">*</span></label>
                                    <input type="text" class="form-control" id="title"
                                           name="title"
                                           placeholder="{{__('admin.batch.title')}} "
                                           value="{{ $edit ? $batch->title : old('title') }}">
                                    <input type="hidden" id="today">
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="course_id">{{__('admin.batch.course')}}  <span
                                            style="color: red">*</span></label>
                                    <select class="form-control select2-ajax-wizard"
                                            name="course_id"
                                            id="course_id"
                                            data-model="{{base64_encode(App\Models\Course::class)}}"
                                            data-label-fields="{institute.title} - {title}"
                                            @if($authUser->isInstituteUser())
                                            data-filters="{{json_encode(['institute_id' => $authUser->institute_id])}}"
                                            @endif
                                            @if($edit)
                                            data-preselected-option="{{json_encode(['text' => $batch->course->institute->title.' - '.  $batch->course->title, 'id' =>  $batch->course->id])}}"
                                            @endif
                                            data-placeholder="{{__('Select Course')}}"
                                    >
                                    </select>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="code">{{__('admin.batch.code')}} <span style="color: red">*</span></label>
                                    <input type="text" class="form-control" id="code"
                                           name="code"
                                           data-code="{{ $edit ? $batch->code : '' }}"
                                           value="{{ $edit ? $batch->code : old('code') }}"
                                           placeholder="{{__('admin.batch.code')}}">
                                </div>
                            </div>

                            <div class="col-sm-12 text-right">
                                <button type="submit"
                                        class="btn btn-success">{{ $edit ? __('admin.batch.update') : __('admin.batch.add')}}</button>
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
                title: {
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
                            url: "{{ route('admin.check-batch-code') }}",
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
                title: {
                    pattern: "This field is required in English."
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
                url: '{{route('admin.batch-training-centers')}}',
                data: {'publish_course_id': publishCourseId},
            }).then(function (res) {
                $("#training_center_id option").remove();
                $('#training_center_id').append('<option value="">' + 'Select' + '</option>');
                $.each(res, function (key, val) {
                    $('#training_center_id').append('<option value="' + val.id + '">' + val.title + '</option>');
                });
            });

            if (!publishCourseId) {
                $("#training_center_id option").remove();
            }
        });
    </script>
@endpush


