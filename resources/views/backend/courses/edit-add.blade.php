@php
    $edit = !empty($course->id);
    /** @var \App\Models\User $authUser */
    $authUser = \App\Helpers\Classes\AuthHelper::getAuthUser();
@endphp

@extends('master::layouts.master')

@section('title')
    {{ ! $edit ? __('admin.course.edit') : __('admin.course.update') }}
@endsection


@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card card-outline">
                    <div class="card-header custom-bg-gradient-info">
                        <h3 class="card-title text-primary font-weight-bold">{{ $edit ? __('generic.course.edit') : __('generic.course.add') }}</h3>

                        <div class="card-tools">
                            <a href="{{route('admin.courses.index')}}"
                               class="btn btn-sm btn-outline-primary btn-rounded">
                                <i class="fas fa-backward"></i>{{__('admin.common.back')}}
                            </a>
                        </div>

                    </div>

                    <div class="card-body">
                        <form class="row edit-add-form" method="post" enctype="multipart/form-data"
                              action="{{ $edit ? route('admin.courses.update', [$course->id]) : route('admin.courses.store')}}">
                            @csrf
                            @if($edit)
                                @method('put')
                            @endif

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="cover_image">{{ __('admin.course.upload_cover_image') }}</label>
                                    <div class="input-group">
                                        <div class="cover-image-upload-section">
                                            <div class="avatar-preview text-center">
                                                <label for="cover_image">
                                                    <img class="figure-img"
                                                         src={{ $edit && $course->cover_image ? asset('storage/'.$course->cover_image) : "https://via.placeholder.com/1080x300?text=Course+Cover-image"}}
                                                             height="300" width="100%"
                                                         alt="course cover_image"/>
                                                    <span class="p-1 bg-gray"
                                                          style="position: relative; right: 0; bottom: 50%; /*border: 2px solid #afafaf;*/ border-radius: 50%;margin-left: -31px; overflow: hidden">
                                                        <i class="fa fa-pencil-alt text-white"></i>
                                                    </span>
                                                </label>
                                            </div>
                                            <input type="file" name="cover_image" style="display: none"
                                                   id="cover_image">
                                        </div>
                                    </div>
                                    <p class="font-italic text-secondary d-block">
                                        (Image max 500kb, size 820x312 & file type must be jpg,bmp,png,jpeg or svg)</p>
                                </div>
                            </div>

                            @if($authUser->isInstituteUser())
                                <input type="hidden" id="institute_id" name="institute_id"
                                       value="{{$authUser->institute_id}}">
                            @else
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="institute_id">{{ __('admin.course.institute_title') }}<span
                                                style="color: red"> * </span></label>
                                        <select class="form-control select2-ajax-wizard"
                                                name="institute_id"
                                                id="institute_id"
                                                data-model="{{base64_encode(\App\Models\Institute::class)}}"
                                                data-label-fields="{title}"
                                                data-dependent-fields="#branch_id"
                                                @if($edit)
                                                data-preselected-option="{{json_encode(['text' =>  $course->institute->title, 'id' =>  $course->institute->id])}}"
                                                @endif
                                                data-placeholder="{{ __('admin.course.institute_title') }}"
                                        >
                                        </select>
                                    </div>
                                </div>
                            @endif

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="branch_id">{{__('admin.course.branch')}}<span
                                            style="color: red"> * </span></label>
                                    <select class="form-control select2-ajax-wizard"
                                            name="branch_id"
                                            id="branch_id"
                                            data-model="{{base64_encode(\App\Models\Branch::class)}}"
                                            data-label-fields="{title}"
                                            data-depend-on="institute_id"
                                            @if($edit)
                                            data-preselected-option="{{json_encode(['text' =>  $course->branch->title, 'id' =>  $course->branch->id])}}"
                                            @endif
                                            data-placeholder="{{__('admin.course.branch')}}"
                                    >
                                    </select>
                                </div>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="training_center_id">{{__('admin.publish_course.training_center')}}<span
                                        style="color: red"> * </span></label>
                                <select class="form-control select2-ajax-wizard"
                                        name="training_center_id"
                                        id="training_center_id"
                                        data-model="{{base64_encode(App\Models\TrainingCenter::class)}}"
                                        data-label-fields="{title}"
                                        data-depend-on="institute_id"
                                        @if($edit)
                                        data-preselected-option="{{json_encode(['text' =>  $course->trainingCenter->title, 'id' =>  $course->trainingCenter->id])}}"
                                        @endif
                                        data-placeholder="{{__('admin.course.training_center')}}"
                                >
                                </select>
                            </div>


                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="title">{{ __('generic.course') }}<span
                                            style="color: red"> * </span></label>
                                    <input type="text" class="form-control" id="title"
                                           name="title"
                                           value="{{ $edit ? $course->title : old('title') }}"
                                           placeholder="{{ __('admin.course.title') }}">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="name">{{ __('admin.course.code') }}<span
                                            style="color: red"> * </span></label>
                                    <input type="text" class="form-control" id="code"
                                           name="code"
                                           data-code="{{ $edit ? $course->code : '' }}"
                                           value="{{ $edit ? $course->code : old('code') }}"
                                           placeholder="{{ __('admin.course.code') }}">
                                </div>
                            </div>

                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label for="course_fee">{{ __('admin.course.course_fee') }}<span
                                            style="color: red"> * </span></label>
                                    <input type="number" class="form-control" id="course_fee"
                                           name="course_fee"
                                           value="{{ $edit ? $course->course_fee : old('course_fee') }}"
                                           placeholder="{{ __('admin.course.course_fee') }}">
                                </div>
                            </div>

                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label for="duration">{{ __('admin.course.duration') }}</label>
                                    <input type="text" class="form-control" id="duration"
                                           name="duration"
                                           value="{{ $edit ? $course->duration : old('duration') }}"
                                           placeholder="{{ __('admin.course.duration') }}">
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label
                                        for="application_start_date">{{ __('admin.course.application_start_date') }}
                                        <span
                                            style="color: red"> * </span></label>
                                    <input type="text"
                                           class="flat-date flat-date-custom-bg form-control"
                                           name="application_start_date"
                                           id="application_start_date"
                                           value="{{ $edit ? $course->application_start_date : old('application_start_date') }}"
                                    >
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label
                                        for="application_end_date">{{ __('admin.course.application_end_date') }} <span
                                            style="color: red"> * </span></label>
                                    <input type="text"
                                           class="flat-date flat-date-custom-bg form-control"
                                           name="application_end_date"
                                           id="application_end_date"
                                           value="{{ $edit ? $course->application_end_date : old('application_end_date') }}"
                                    >
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label
                                        for="course_start_date">{{ __('admin.course.course_start_date') }} <span
                                            style="color: red"> * </span></label>
                                    <input type="text"
                                           class="flat-date flat-date-custom-bg form-control"
                                           name="course_start_date"
                                           id="course_start_date"
                                           value="{{ $edit ? $course->course_start_date : old('course_start_date') }}"
                                    >
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label
                                        for="course_end_date">{{ __('admin.course.course_end_date') }} <span
                                            style="color: red"> * </span></label>
                                    <input type="text"
                                           class="flat-date flat-date-custom-bg form-control"
                                           name="course_end_date"
                                           id="course_end_date"
                                           value="{{ $edit ? $course->course_end_date : old('course_end_date') }}"
                                    >
                                </div>
                            </div>


                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="target_group">{{ __('admin.course.target_group') }}</label>
                                    <textarea class="form-control" id="target_group"
                                              name="target_group"
                                              rows="3"
                                              placeholder="{{ __('admin.course.target_group') }}">{{ $edit ? $course->target_group : old('target_group') }}</textarea>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="objects">{{ __('admin.course.object') }}</label>
                                    <textarea class="form-control" id="objects"
                                              name="objects"
                                              rows="3"
                                              placeholder="{{ __('admin.course.object') }}">{{ $edit ? $course->objects : old('objects') }}</textarea>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="contents">{{ __('admin.course.content') }}</label>
                                    <textarea class="form-control" id="contents"
                                              name="contents"
                                              rows="3"
                                              placeholder="{{ __('admin.course.content') }}">{{ $edit ? $course->contents : old('contents') }}</textarea>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label
                                        for="training_methodology">{{ __('admin.course.training_methodology') }}</label>
                                    <textarea class="form-control" id="training_methodology"
                                              name="training_methodology"
                                              rows="3"
                                              placeholder="{{ __('admin.course.training_methodology') }}">{{ $edit ? $course->training_methodology : old('training_methodology') }}</textarea>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="evaluation_system">{{ __('admin.course.evaluation_system') }}</label>
                                    <textarea class="form-control" id="evaluation_system"
                                              name="evaluation_system"
                                              rows="3"
                                              placeholder="{{ __('admin.course.evaluation_system') }}">{{ $edit ? $course->evaluation_system : old('evaluation_system') }}</textarea>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="prerequisite">{{ __('admin.course.course_prerequisite') }}</label>
                                    <textarea rows="3" class="form-control" id="prerequisite"
                                              name="prerequisite"
                                              placeholder="{{ __('admin.course.course_prerequisite') }}">{{ $edit ? $course->prerequisite : old('prerequisite') }}</textarea>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="eligibility">{{ __('admin.course.eligibility') }}</label>
                                    <textarea rows="3" class="form-control" id="eligibility"
                                              name="eligibility"
                                              placeholder="{{ __('admin.course.eligibility') }}">{{ $edit ? $course->eligibility : old('eligibility') }}</textarea>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="description">{{ __('admin.course.description') }}</label>
                                    <textarea class="form-control" id="description"
                                              name="description"
                                              rows="3"
                                              placeholder="{{ __('admin.course.description') }}">{{ $edit ? $course->description : old('description') }}</textarea>
                                </div>
                            </div>

                            @if($edit)
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="row_status">{{ __('admin.course.status') }}</label>
                                        <div class="custom-control custom-radio">
                                            <input class="custom-control-input" type="radio" id="row_status_active"
                                                   name="row_status"
                                                   value="{{ \App\Models\Video::ROW_STATUS_ACTIVE }}"
                                                {{ ($edit && $course->row_status == \App\Models\Video::ROW_STATUS_ACTIVE) || old('row_status') == \App\Models\Video::ROW_STATUS_ACTIVE ? 'checked' : '' }}>
                                            <label for="row_status_active"
                                                   class="custom-control-label">{{ __('admin.status.active') }}</label>
                                        </div>

                                        <div class="custom-control custom-radio">
                                            <input class="custom-control-input" type="radio" id="row_status_inactive"
                                                   name="row_status"
                                                   value="{{ \App\Models\Video::ROW_STATUS_INACTIVE }}"
                                                {{ ($edit && $course->row_status == \App\Models\Video::ROW_STATUS_INACTIVE) || old('row_status') == \App\Models\Video::ROW_STATUS_INACTIVE ? 'checked' : '' }}>
                                            <label for="row_status_inactive"
                                                   class="custom-control-label">{{ __('admin.status.inactive') }}</label>
                                        </div>
                                    </div>
                                </div>
                            @endif


                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group form-inline">
                                                    <div class="form-check">
                                                        <input class="form-check-input" name="applicationFormSettings[ethnicGroup]['value']" type="checkbox" value="1" id="ethnic-group">
                                                        <label class="form-check-label" for="ethnic-group">
                                                            Ethnic group
                                                        </label>
                                                    </div>

                                                    <div class="custom-control custom-switch ml-5" style="display: none">
                                                        <input type="checkbox" name="applicationFormSettings[ethnicGroup][optionality]" class="custom-control-input" id="ethnic-group-optionality">
                                                        <label class="custom-control-label" for="ethnic-group-optionality">optional</label>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <div class="form-group form-inline">
                                                    <div class="form-check">
                                                        <input class="form-check-input" name="applicationFormSettings[freedomFighter]['value']" type="checkbox" value="1" id="freedom-fighter-status">
                                                        <label class="form-check-label" for="freedom-fighter-status">
                                                            Freedom fighter
                                                        </label>
                                                    </div>

                                                    <div class="custom-control custom-switch ml-5" style="display: none">
                                                        <input type="checkbox" name="applicationFormSettings[freedomFighter][optionality]" class="custom-control-input" id="freedom-fighter-optionality">
                                                        <label class="custom-control-label" for="freedom-fighter-optionality">optional</label>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <div class="form-group form-inline">
                                                    <div class="form-check">
                                                        <input class="form-check-input" name="applicationFormSettings[occupationInfo]['value']" type="checkbox" value="1" id="occupation-info">
                                                        <label class="form-check-label" for="occupation-info">
                                                            Occupation info
                                                        </label>
                                                    </div>

                                                    <div class="custom-control custom-switch ml-5" style="display: none">
                                                        <input type="checkbox" name="applicationFormSettings[occupationInfo][optionality]" class="custom-control-input" id="occupation-info-optionality">
                                                        <label class="custom-control-label" for="occupation-info-optionality">optional</label>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <div class="form-group form-inline">
                                                    <div class="form-check">
                                                        <input class="form-check-input" name="applicationFormSettings[othersInfo]['value']" type="checkbox" value="1" id="others-info">
                                                        <label class="form-check-label" for="others-info">
                                                            Others info
                                                        </label>
                                                    </div>

                                                    <div class="custom-control custom-switch ml-5" style="display: none">
                                                        <input type="checkbox" name="applicationFormSettings[othersInfo][optionality]" class="custom-control-input" id="others-info-optionality">
                                                        <label class="custom-control-label" for="occupation-info-optionality">optional</label>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group form-inline">
                                                    <div class="form-check">
                                                        <input class="form-check-input" name="applicationFormSettings[academicInfo]['value']" type="checkbox" value="1" id="academic-info">
                                                        <label class="form-check-label" for="academic-info">
                                                            Academic info
                                                        </label>
                                                    </div>

                                                    <div class="custom-control custom-switch ml-5" style="display: none">
                                                        <input type="checkbox" name="applicationFormSettings[academicInfo][optionality]" class="custom-control-input" id="academic-info-optionality">
                                                        <label class="custom-control-label" for="academic-info-optionality">optional</label>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <div class="form-group form-inline">
                                                    <div class="form-check">
                                                        <input class="form-check-input" name="applicationFormSettings[academicInfo]['jsc']" type="checkbox" value="1" id="jsc-info">
                                                        <label class="form-check-label" for="jsc-info">
                                                            SSC info
                                                        </label>
                                                    </div>

                                                    <div class="custom-control custom-switch ml-5" style="display: none">
                                                        <input type="checkbox" name="applicationFormSettings[academicInfo][optionality]" class="custom-control-input" id="jsc-info-optionality">
                                                        <label class="custom-control-label" for="jsc-info-optionality">optional</label>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <div class="form-group form-inline">
                                                    <div class="form-check">
                                                        <input class="form-check-input" name="applicationFormSettings[academicInfo]['ssc']" type="checkbox" value="1" id="ssc-info">
                                                        <label class="form-check-label" for="ssc-info">
                                                            HSC info
                                                        </label>
                                                    </div>

                                                    <div class="custom-control custom-switch ml-5" style="display: none">
                                                        <input type="checkbox" name="applicationFormSettings[academicInfo][optionality]" class="custom-control-input" id="ssc-info-optionality">
                                                        <label class="custom-control-label" for="ssc-info-optionality">optional</label>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <div class="form-group form-inline">
                                                    <div class="form-check">
                                                        <input class="form-check-input" name="applicationFormSettings[academicInfo]['hsc']" type="checkbox" value="1" id="hsc-info">
                                                        <label class="form-check-label" for="hsc-info">
                                                            HSC info
                                                        </label>
                                                    </div>

                                                    <div class="custom-control custom-switch ml-5" style="display: none">
                                                        <input type="checkbox" name="applicationFormSettings[academicInfo][optionality]" class="custom-control-input" id="hsc-info-optionality">
                                                        <label class="custom-control-label" for="hsc-info-optionality">optional</label>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <div class="form-group form-inline">
                                                    <div class="form-check">
                                                        <input class="form-check-input" name="applicationFormSettings[academicInfo]['honors']" type="checkbox" value="1" id="honors-info">
                                                        <label class="form-check-label" for="honors-info">
                                                            HSC info
                                                        </label>
                                                    </div>

                                                    <div class="custom-control custom-switch ml-5" style="display: none">
                                                        <input type="checkbox" name="applicationFormSettings[academicInfo][optionality]" class="custom-control-input" id="honors-info-optionality">
                                                        <label class="custom-control-label" for="honors-info-optionality">optional</label>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <div class="form-group form-inline">
                                                    <div class="form-check">
                                                        <input class="form-check-input" name="applicationFormSettings[academicInfo]['masters']" type="checkbox" value="1" id="masters-info">
                                                        <label class="form-check-label" for="masters-info">
                                                            Masters info
                                                        </label>
                                                    </div>

                                                    <div class="custom-control custom-switch ml-5" style="display: none">
                                                        <input type="checkbox" name="applicationFormSettings[academicInfo][optionality]" class="custom-control-input" id="masters-info-optionality">
                                                        <label class="custom-control-label" for="masters-info-optionality">optional</label>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>


                                </div>
                            </div>



                            <div class="col-sm-12 text-right">
                                <button type="submit"
                                        class="btn btn-success">{{ $edit ? __('admin.course.update')  : __('admin.course.add')  }}</button>
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
        .flat-date-custom-bg {
            background-color: #fafdff !important;
        }
    </style>
@endpush

@push('js')
    <x-generic-validation-error-toastr></x-generic-validation-error-toastr>

    <script>
        const EDIT = !!'{{$edit}}';

        const editAddForm = $('.edit-add-form');

        jQuery.validator.setDefaults({
            focusInvalid: false,
            invalidHandler: function (form, validator) {
                if (!validator.numberOfInvalids()) {
                    return;
                }
                $('html, body').animate({
                    scrollTop: $(validator.errorList[0].element).offset().top
                }, 200);
            }
        });


        $('#application_start_date').change(function () {
            if ($(this).val() != "") {
                $(this).valid();
            }
        });

        $('#application_end_date').change(function () {
            if ($(this).val() != "") {
                $(this).valid();
            }
        });

        $('#course_start_date').change(function () {
            if ($(this).val() != "") {
                $(this).valid();
            }
        });
        $('#course_end_date').change(function () {
            if ($(this).val() != "") {
                $(this).valid();
            }
        });


        $.validator.addMethod(
            "imageSize",
            function (value, element) {
                let isHeightMatched = $('.avatar-preview').find('img')[0].naturalHeight === 312;
                let isWidthMatched = $('.avatar-preview').find('img')[0].naturalWidth === 820;
                return this.optional(element) || (isHeightMatched && isWidthMatched);
            },
            "Invalid logo size. Size must be 820 x 312",
        );

        $.validator.addMethod('filesize', function (value, element, param) {
            return this.optional(element) || (element.files[0].size <= param)
        }, 'File size must be less than {0} bytes');

        editAddForm.validate({
            rules: {
                title: {
                    required: true,
                },
                code: {
                    required: true,
                    remote: {
                        param: {
                            type: "post",
                            url: "{{ route('admin.check-course-code') }}",
                        },
                        depends: function (element) {
                            return $(element).val() !== $('#code').attr('data-code');
                        }
                    },
                },
                institute_id: {
                    required: true,
                },
                training_center_id: {
                    required: true,
                },
                course_fee: {
                    required: true,
                    number: true,
                },
                duration: {
                    required: false,
                    maxlength: 30,
                },
                target_group: {
                    required: false,
                    maxlength: 5000,
                },
                objects: {
                    required: false,
                    maxlength: 5000,
                },
                contents: {
                    required: false,
                    maxlength: 5000,
                },
                training_methodology: {
                    required: false,
                    maxlength: 5000,
                },
                evaluation_system: {
                    required: false,
                    maxlength: 5000,
                },
                description: {
                    required: false,
                    maxlength: 5000,
                },
                eligibility: {
                    required: false,
                },
                prerequisite: {
                    required: false,
                },
                application_start_date: {
                    required: true

                },
                application_end_date: {
                    required: true,
                    greaterThan: '#application_start_date'
                },
                course_start_date: {
                    required: true,
                    greaterThan: '#application_end_date'
                },
                course_end_date: {
                    required: true,
                    greaterThan: '#course_start_date'
                },
                cover_image: {
                    required: false,
                    accept: 'image/*'
                }
            },
            messages: {
                cover_image: {
                    required: "Cover image is required",
                    accept: "Upload valid image file",
                },
                title: {
                    pattern: "This field is required in English.",
                },
                course_fee: {
                    number: 'Please enter your course fee [Only number]',
                },
                application_end_date: {
                    greaterThan: "This should be greater than Application Start Date"
                },
                course_start_date: {
                    greaterThan: "This should be greater than Application End Date"
                },
                course_end_date: {
                    greaterThan: "This should be greater than Course Start Date"
                }
            },
            submitHandler: function (htmlForm) {
                $('.overlay').show();
                htmlForm.submit();
            }
        });

        function readURL(input) {
            if (input.files && input.files[0]) {
                let reader = new FileReader();
                reader.onload = function (e) {
                    $(input).parent().find('.avatar-preview img').attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]); // convert to base64 string
            }
        }

        $(document).ready(function () {
            $('#cover_image').change(async function () {
                await readURL(this); //preview image
                editAddForm.validate().element("#cover_image");
            });
        })

        function toggleApplicationSettings(checked, target) {
            checked ? target.show() : target.hide();
        }

        $(document).ready(function () {

            $('#ethnic-group').on('change', function () {
                const target = $('#ethnic-group-optionality');
                toggleApplicationSettings(this.checked, target.parent());

                if (target.attr('checked')) {
                    console.log(true);
                }
            });

            $('#freedom-fighter-status').on('change', function () {
                const target = $('#freedom-fighter-optionality').parent();
                toggleApplicationSettings(this.checked, target);
            });

            $('#occupation-info').on('change', function () {
                const target = $('#occupation-info-optionality').parent();
                toggleApplicationSettings(this.checked, target);
            });

            $('#others-info').on('change', function () {
                const target = $('#others-info-optionality').parent();
                toggleApplicationSettings(this.checked, target);
            });
        });
    </script>
@endpush
