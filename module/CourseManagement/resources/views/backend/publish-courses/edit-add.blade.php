@php
    $edit = !empty($publishCourse->id);
    /** @var \App\Models\User $authUser */
    $authUser = \App\Helpers\Classes\AuthHelper::getAuthUser();
@endphp

@extends('master::layouts.master')

@section('title')
    {{ ! $edit ? 'Create Config Course' : 'Update Course Config' }}
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card card-outline">
                    <div class="card-header d-flex justify-content-between custom-bg-gradient-info">
                        <h3 class="card-title font-weight-bold text-primary">{{ ! $edit ? 'Create Config Course' : 'Update Course Config' }}</h3>
                        <div>
                            <a href="{{route('course_management::admin.publish-courses.index')}}"
                               class="btn btn-sm btn-rounded btn-outline-primary">
                                <i class="fas fa-backward"></i> Back to list
                            </a>
                        </div>
                    </div>

                    <div class="card-body">
                        <form class="row edit-add-form" method="post"
                              action="{{ $edit ? route('course_management::admin.publish-courses.update', $publishCourse->id) : route('course_management::admin.publish-courses.store')}}">
                            @csrf
                            @if($edit)
                                @method('put')
                            @endif

                            @if($authUser->isInstituteUser())
                                <input type="hidden" id="institute_id" name="institute_id"
                                       value="{{$authUser->institute_id}}">
                            @else
                                <div class="form-group col-md-6">
                                    <label for="institute_id">Institute Name <span style="color: red"> * </span></label>
                                    <input type="hidden" id="today" name="today">
                                    <select class="form-control select2-ajax-wizard"
                                            name="institute_id"
                                            id="institute_id"
                                            data-model="{{base64_encode(Module\CourseManagement\App\Models\Institute::class)}}"
                                            data-label-fields="{title_en}"
                                            data-dependent-fields="#application_form_type_id|#branch_id|#training_center_id|#programme_id|#course_id"
                                            @if($edit)
                                            data-preselected-option="{{json_encode(['text' =>  $publishCourse->institute->title_en, 'id' =>  $publishCourse->institute->id])}}"
                                            @endif
                                            data-placeholder="নির্বাচন করুন"
                                    >
                                    </select>
                                </div>
                            @endif


                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="application_form_type_id">{{ __('Application Form Type') }}<span
                                            style="color: red"> * </span></label>
                                    <select class="form-control select2-ajax-wizard"
                                            name="application_form_type_id"
                                            id="application_form_type_id"
                                            data-model="{{base64_encode(\Module\CourseManagement\App\Models\ApplicationFormType::class)}}"
                                            data-label-fields="{title_en}"
                                            data-depend-on="institute_id"
                                            @if($edit)
                                            data-preselected-option="{{json_encode(['text' =>  $publishCourse->applicationFormType->title_en, 'id' =>  $publishCourse->applicationFormType->id])}}"
                                            @endif
                                            data-placeholder="নির্বাচন করুন"
                                    >
                                    </select>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="branch_id">{{ __('Branch') }}</label>
                                    <select class="form-control select2-ajax-wizard"
                                            name="branch_id"
                                            id="branch_id"
                                            data-model="{{base64_encode(\Module\CourseManagement\App\Models\Branch::class)}}"
                                            data-label-fields="{title_en}"
                                            data-depend-on="institute_id"
                                            @if($edit && $publishCourse->branch)
                                            data-preselected-option="{{json_encode(['text' =>  $publishCourse->branch->title_en, 'id' =>  $publishCourse->branch->id])}}"
                                            @endif
                                            data-placeholder="নির্বাচন করুন"
                                    >
                                    </select>
                                </div>
                            </div>


                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="training_center_id">{{ __('Training Center') }}</label>
                                    <select class="form-control select2-ajax-wizard"
                                            name="training_center_id"
                                            id="training_center_id"
                                            data-model="{{base64_encode(\Module\CourseManagement\App\Models\TrainingCenter::class)}}"
                                            data-label-fields="{title_en}"
                                            data-depend-on="institute_id"
                                            data-depend-on-optional="branch_id"
                                            @if($edit && $publishCourse->trainingCenter)
                                            data-preselected-option="{{json_encode(['text' =>  $publishCourse->trainingCenter->title_en, 'id' =>  $publishCourse->trainingCenter->id])}}"
                                            @endif
                                            data-placeholder="নির্বাচন করুন"
                                    >
                                    </select>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="programme_id">{{ __('Programme') }}</label>
                                    <select class="form-control select2-ajax-wizard"
                                            name="programme_id"
                                            id="programme_id"
                                            data-model="{{base64_encode(\Module\CourseManagement\App\Models\Programme::class)}}"
                                            data-label-fields="{title_en}"
                                            data-depend-on="institute_id"
                                            @if($edit && $publishCourse->programme)
                                            data-preselected-option="{{json_encode(['text' =>  $publishCourse->programme->title_en, 'id' =>  $publishCourse->programme->id])}}"
                                            @endif
                                            data-placeholder="নির্বাচন করুন"
                                    >
                                    </select>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="course_id">{{ __('Course Name') }}<span
                                            style="color: red"> * </span></label>
                                    <select class="form-control select2-ajax-wizard"
                                            name="course_id"
                                            id="course_id"
                                            data-model="{{base64_encode(\Module\CourseManagement\App\Models\Course::class)}}"
                                            data-label-fields="{title_en}"
                                            data-depend-on="institute_id"
                                            @if($edit)
                                            data-preselected-option="{{json_encode(['text' =>  $publishCourse->course->title_en, 'id' =>  $publishCourse->course->id])}}"
                                            @endif
                                            data-placeholder="নির্বাচন করুন"
                                    >
                                    </select>
                                </div>
                            </div>


                            @if($edit)
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="row_status">Active Status</label>
                                        <div class="custom-control custom-radio">
                                            <input class="custom-control-input" type="radio" id="row_status_active"
                                                   name="row_status"
                                                   value="{{ \Module\CourseManagement\App\Models\Video::ROW_STATUS_ACTIVE }}"
                                                {{ ($edit && $publishCourse->row_status == \Module\CourseManagement\App\Models\PublishCourse::ROW_STATUS_ACTIVE) || old('row_status') == \Module\CourseManagement\App\Models\PublishCourse::ROW_STATUS_ACTIVE ? 'checked' : '' }}>
                                            <label for="row_status_active" class="custom-control-label">Active</label>
                                        </div>

                                        <div class="custom-control custom-radio">
                                            <input class="custom-control-input" type="radio" id="row_status_inactive"
                                                   name="row_status"
                                                   value="{{ \Module\CourseManagement\App\Models\Video::ROW_STATUS_INACTIVE }}"
                                                {{ ($edit && $publishCourse->row_status == \Module\CourseManagement\App\Models\PublishCourse::ROW_STATUS_INACTIVE) || old('row_status') == \Module\CourseManagement\App\Models\PublishCourse::ROW_STATUS_ACTIVE ? 'checked' : '' }}>
                                            <label for="row_status_inactive"
                                                   class="custom-control-label">Inactive</label>
                                        </div>
                                    </div>
                                </div>
                            @endif


                            <div class="col-sm-12 course-sessions mt-5">
                                <div class="card">
                                    <div class="card-header custom-bg-gradient-info">
                                        <h3 class="card-title text-primary font-weight-bold">Course Sessions</h3>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-12 course-session-contents"></div>
                                            <div class="col-md-12">
                                                <button type="button"
                                                        class="btn btn-primary add-more-sessions-btn float-right">
                                                    <i class="fa fa-plus-circle fa-fw"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-12 text-right">
                                <button type="submit"
                                        class="btn btn-success">{{ $edit ? __('Update') : __('Publish') }}
                                </button>
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
        .has-error{
            position: relative;
            padding: 0px 0 12px 0;
        }
        #institute_id-error, #application_form_type_id-error, #course_id-error{
            position: absolute;
            left: 6px;
            bottom: -9px;
        }
    </style>
    @endphp


    @push('js')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/lodash.js/4.17.21/lodash.js"></script>

        <x-generic-validation-error-toastr></x-generic-validation-error-toastr>

        <script>
            const EDIT = !!'{{$edit}}';
            let SL = 0;

            let today = new Date();
            today = today.getFullYear()+'-'+("0" + (today.getMonth() + 1)).slice(-2)+'-'+("0" + (today.getDate()-1)).slice(-2);
            console.log('Today: '+today)
            $('#today').val(today);


            $('.application_start_date').on('change', function (){
                console.log($('.application_start_date').val())
            })

            function addRow(data = {}) {
                let courseSession = _.template($('#course-sessions').html());
                console.table('course session template:', courseSession);
                let courseSessionContentElm = $(".course-session-contents");
                courseSessionContentElm.append(courseSession({sl: SL, data: data, edit: EDIT}))
                courseSessionContentElm.find('.flat-date').each(function () {
                    $(this).flatpickr({
                        altInput: false,
                        altFormat: "j F, Y",
                        dateFormat: "Y-m-d",
                    });
                });

                $.validator.addMethod(
                    "sessionNameEn",
                    function (value, element) {
                        let regexp = "^[a-zA-Z0-9!@#\$%\^\&*\)\(+=._ -]+$";
                        let re = new RegExp(regexp);
                        return this.optional(element) || re.test(value);
                    },
                    "Please fill this field in English."
                );
                $.validator.addMethod(
                    "sessionNameBn",
                    function (value, element) {
                        let regexp = "^[\\s-'\u0980-\u09ff!@#\$%\^\&*\)\(+=._-]{1,255}$";
                        let re = new RegExp(regexp);
                        return this.optional(element) || re.test(value);
                    },
                    "This field is required in Bangla."
                );

                $.validator.addMethod("cGreaterThan", $.validator.methods.greaterThan,
                    "Application start date must be greater than today");
                $.validator.addMethod("cApplicationEndDate", $.validator.methods.greaterThan,
                    "Application end date must be greater than Application start date");
                $.validator.addMethod("cCourseStartDate", $.validator.methods.greaterThan,
                    "Course start date must be greater than Application end date");

                $.validator.addClassRules("number_of_batches", {required: true});
                $.validator.addClassRules("application_start_date", {
                    required: true,
                    cGreaterThan: '#today',
                });

                $.validator.addClassRules("application_end_date", {
                    required: true,
                    cApplicationEndDate: ".application_start_date",
                });

                $.validator.addClassRules("course_start_date", {
                    required: true,
                    cCourseStartDate: ".application_end_date",
                });
                $.validator.addClassRules("max_seat_available", {required: true});

                $.validator.addClassRules("session_name_en", {
                    required: true,
                    sessionNameEn: true,
                });
                $.validator.addClassRules("session_name_bn", {
                    required: true,
                    sessionNameBn: true,
                });
                SL++;
            }

            function deleteRow(slNo) {
                let sessionELm = $("#session-no-" + slNo);
                if (sessionELm.find('.delete_status').length) {
                    sessionELm.find('.delete_status').val(1);
                    sessionELm.hide();
                } else {
                    sessionELm.remove();
                }
            }

            $(document).ready(function () {
                @if($edit && $publishCourse->courseSessions->count())
                @foreach($publishCourse->courseSessions as $session)
                addRow(@json($session));
                @endforeach
                @else
                addRow();
                @endif

                $(document).on('click', '.add-more-sessions-btn', function () {
                    addRow();
                });
            });

            const editAddForm = $('.edit-add-form');
            editAddForm.validate({
                rules: {
                    institute_id: {
                        required: true
                    },
                    course_id: {
                        required: true
                    },
                    application_form_type_id: {
                        required: true
                    },
                    max_seat_available: {
                        required: true,
                        number: true,
                        min: 1,
                    },
                },
                submitHandler: function (htmlForm) {
                    $('.overlay').show();
                    htmlForm.submit();
                }
            });

        </script>

        <script type="text/template" id="course-sessions">
            <div class="card" id="session-no-<%=sl%>">
                <div class="card-header d-flex justify-content-between">
                    <h5 class="session-name-english"><%= edit ? data.session_name_en : "Session " + sl+1%></h5>
                    <div class="card-tools">
                        <button type="button"
                                onclick="deleteRow(<%=sl%>)"
                                class="btn btn-warning less-session-btn float-right mr-2"><i
                                class="fa fa-minus-circle fa-fw"></i></button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <% if(edit && data.id) { %>
                        <input type="hidden" id="course_session_<%=data.id%>" name="course_sessions[<%=sl%>][id]"
                               value="<%=data.id%>">
                        <input type="hidden" name="course_sessions[<%=sl%>][delete]" class="delete_status" value="0"/>
                        <% } %>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="session_name_en">{{ __('Session Name(English)') }} <span
                                        style="color: red"> * </span></label>
                                <input type="text"
                                       class="form-control session_name_en"
                                       name="course_sessions[<%=sl%>][session_name_en]"
                                       value="<%=edit ? data.session_name_en : ''%>"
                                       onkeyup="$('.session-name-english').html($(this).val())">
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="session_name_bn">{{ __('Session Name(Bangla)') }} <span
                                        style="color: red"> * </span></label>
                                <input type="text"
                                       class="form-control session_name_bn"
                                       name="course_sessions[<%=sl%>][session_name_bn]"
                                       value="<%=edit ? data.session_name_bn : ''%>"
                                >
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="number_of_batches">{{ __('Number of Batches') }} <span
                                        style="color: red"> * </span></label>
                                <input type="number"
                                       class="form-control number_of_batches"
                                       name="course_sessions[<%=sl%>][number_of_batches]"
                                       value="<%=edit ? data.number_of_batches : ''%>">
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label
                                    for="application_start_date">{{ __('Application Start Date') }} <span
                                        style="color: red"> * </span></label>
                                <input type="text"
                                       class="flat-date flat-date-custom-bg form-control application_start_date"
                                       name="course_sessions[<%=sl%>][application_start_date]"
                                       id="course_sessions[<%=sl%>][application_start_date]"
                                       value="<%=edit ? data.application_start_date : ''%>">
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label
                                    for="application_end_date">{{ __('Application End Date') }} <span
                                        style="color: red"> * </span></label>
                                <input type="text"
                                       class="flat-date flat-date-custom-bg form-control application_end_date"
                                       name="course_sessions[<%=sl%>][application_end_date]"
                                       value="<%=edit ? data.application_end_date : ''%>"
                                >
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="course_start_date">{{ __('Course Start Date') }} <span
                                        style="color: red"> * </span></label>
                                <input type="text"
                                       class="flat-date flat-date-custom-bg form-control course_start_date"
                                       name="course_sessions[<%=sl%>][course_start_date]"
                                       value="<%=edit ? data.course_start_date : ''%>"
                                >
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label
                                    for="max_seat_available">{{ __('Max Student Enrollment') }} <span
                                        style="color: red"> * </span></label>
                                <input type="number"
                                       class="form-control max_seat_available"
                                       name="course_sessions[<%=sl%>][max_seat_available]"
                                       value="<%=edit ? data.max_seat_available : ''%>"
                                >
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </script>
    @endpush


