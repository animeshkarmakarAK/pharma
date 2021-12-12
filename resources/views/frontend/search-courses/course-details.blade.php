@php
    $currentInstitute = app('currentInstitute');
    $layout = 'master::layouts.front-end';

@endphp

@extends($layout)

@section('title')
    কোর্স সমূহ
@endsection

@section('content')
    <div class="container-fluid" id="fixed-scrollbar">
        <div class="row  justify-content-center">
            <div class="col-md-8 col-sm-8">
                <div class="card">
                    <div class="card-header d-flex justify-content-between custom-bg-gradient-info"
                         style="background: url('{{asset('storage/'. optional($publishCourse->course)->cover_image)}}') no-repeat center center;
                             background-size: cover; min-height: 40vh;"
                    >
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 custom-view-box">
                                <p class="label-text">{{__('admin.course.title')}} </p>
                                <div class="input-box" id="course_title">
                                    {{optional($publishCourse->course)->title_en}}
                                </div>
                            </div>

                            <div class="col-md-6 custom-view-box">
                                <p class="label-text">{{__('admin.course.course_fee')}}</p>
                                <div class="input-box" id="course_fee">
                                    {{optional($publishCourse->course)->course_fee}}
                                </div>
                            </div>

                            <div class="col-md-6 custom-view-box">
                                <p class="label-text">{{__('admin.course.duration')}}</p>
                                <div class="input-box" id="course_duration">
                                    {{optional($publishCourse->course)->duration}}
                                </div>
                            </div>

                            <div class="col-md-6 custom-view-box">
                                <p class="label-text">{{__('admin.course.target_group')}}</p>
                                <div class="input-box" id="target_group">
                                    {{optional($publishCourse->course)->target_group}}
                                </div>
                            </div>

                            <div class="col-md-6 custom-view-box">
                                <p class="label-text">{{__('admin.course.object')}}</p>
                                <div class="input-box" id="objects">
                                    {{optional($publishCourse->course)->objects}}
                                </div>
                            </div>

                            <div class="col-md-6 custom-view-box">
                                <p class="label-text">{{__('admin.course.content')}}</p>
                                <div class="input-box" id="contents">
                                    {{optional($publishCourse->course)->contents}}
                                </div>
                            </div>

                            <div class="col-md-6 custom-view-box">
                                <p class="label-text">{{__('admin.course.training_methodology')}}</p>
                                <div class="input-box" id="training_methodology">
                                    {{optional($publishCourse->course)->training_methodology}}
                                </div>
                            </div>

                            <div class="col-md-6 custom-view-box">
                                <p class="label-text">{{__('admin.course.evaluation_system')}}</p>
                                <div class="input-box" id="evaluation_system">
                                    {{optional($publishCourse->course)->evaluation_system}}
                                </div>
                            </div>

                            <div class="col-md-12 custom-view-box">
                                <p class="label-text">{{__('admin.course.description')}}</p>
                                <div class="input-box" id="description">
                                    <p>{{optional($publishCourse->course)->description}}</p>
                                </div>
                            </div>
                            <div class="col-md-6 custom-view-box">
                                <p class="label-text">{{__('admin.course.course_prerequisite')}} </p>
                                <div class="input-box" id="prerequisite">
                                    {{optional($publishCourse->course)->prerequisite}}
                                </div>
                            </div>
                            <div class="col-md-6 custom-view-box">
                                <p class="label-text">{{__('admin.course.eligibility')}}</p>
                                <div class="input-box" id="eligibility">
                                    {{optional($publishCourse->course)->eligibility}}
                                </div>
                            </div>
                            <div class="col-md-6 custom-view-box">
                                <p class="label-text">{{__('admin.common.status')}}</p>
                                <div class="input-box" id="active_status">
                                    {!! $publishCourse->getCurrentRowStatus(true) !!}
                                </div>
                            </div>
                            <div class="col-md-6 custom-view-box">
                                <p class="label-text">{{__('admin.course.institute_title')}} </p>
                                <div class="input-box" id="institute_name_field">
                                    {{optional($publishCourse->institute)->title}}
                                </div>
                            </div>
                            <div class="col-md-6 custom-view-box">
                                <p class="label-text">{{__('admin.course.institute_address')}}</p>
                                <div class="input-box" id="institute_address">
                                    {{optional($publishCourse->institute)->address}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h2 class="card-title">{{__('admin.course.course_session_list')}}</h2>
                    </div>
                    @if($publishCourse->courseSessions)
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-hover table-sm">
                                    <thead>
                                    <tr>
                                        <th>{{__('admin.course.enrollment_start')}}</th>
                                        <th>{{__('admin.course.enrollment_end')}}</th>
                                        <th>{{__('admin.course.class_start')}}</th>
                                        <th>{{__('admin.course.total_seat')}}</th>
                                        <th>&nbsp;</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($publishCourse->courseSessions as $session)
                                        <tr>
                                            {{--                                        <td>{{optional($session->application_start_date)->format('d/m/Y')}}</td>--}}
                                            {{--                                        <td>{{optional($session->application_end_date)->format('d/m/Y')}}</td>--}}
                                            {{--                                        <td>{{optional($session->course_start_date)->format('d/m/Y')}}</td>--}}
                                            {{--                                        <td>{{$session->max_seat_available}}</td>--}}
                                            {{--                                        <td colspan="3">--}}
                                            @if($session->application_start_date > \Carbon\Carbon::now())
                                                <td>{{optional($session->application_start_date)->format('d/m/Y')}}</td>
                                                <td>{{optional($session->application_end_date)->format('d/m/Y')}}</td>
                                                <td>{{optional($session->course_start_date)->format('d/m/Y')}}</td>
                                                <td>{{$session->max_seat_available}}</td>

                                            @elseif($session->course_start_date && $session->course_start_date->gt(now()))
                                                <td>{{optional($session->application_start_date)->format('d/m/Y')}}</td>
                                                <td>{{optional($session->application_end_date)->format('d/m/Y')}}</td>
                                                <td>{{optional($session->course_start_date)->format('d/m/Y')}}</td>
                                                <td>{{$session->max_seat_available}}</td>
                                                <td colspan="3">
                                                    <button type="button" style="min-width: 130px;"
                                                            class="btn btn-success btn-block course-apply-btn"
                                                            onclick="window.location.href = `{{route('frontend.youth-registrations.store')}}?publish_course_id={{$publishCourse->id}}`"
                                                    >{{__('admin.course.apply')}}
                                                    </button>
                                                </td>
                                            @endif
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @else
                        <div class="card-body">
                            <div class="col-md-12">
                                <div class="alert alert-warning">
                                    {{__('admin.course.not_found')}}.
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

@endsection
        @push('css')
            <style>
                .card-background-white {
                    background: #faf8fb;
                }

                .form-control {
                    border: 1px solid #671688;
                    color: #671688;
                }

                .form-control:focus {
                    border-color: #671688;
                }

                .button-bg {
                    background: #671688;
                    border-color: #671688;
                }

                .button-bg:hover {
                    color: #ffffff;
                    background-color: #671688 !important;;
                    border-color: #671688 !important;;
                }

                .button-bg:active {
                    color: #ffffff;
                    background-color: #671688 !important;
                    border-color: #671688 !important;;
                }

                .button-bg:focus {
                    color: #ffffff;
                    background-color: #671688 !important;;
                    border-color: #671688 !important;;
                }

                .button-bg:visited {
                    color: #ffffff;
                    background-color: #671688 !important;;
                    border-color: #671688 !important;;
                }

                .card-header-title {
                    min-height: 48px;
                }

                .card-bar-home-course img {
                    height: 14vw;
                }

                .gray-color {
                    color: #73727f;
                }
                .course-heading-wrap {
                    text-overflow: ellipsis;
                    white-space: nowrap;
                    overflow: hidden;
                }
                .course-heading-wrap:hover {
                    overflow: visible;
                    white-space: normal;
                    cursor: pointer;
                }
                .course-p {
                    font-size: 14px;
                    font-weight: 400;
                    color: #671688;
                }
                .header-bg {
                    background: #671688;
                    color:white;
                }
                .modal-header .close, .modal-header .mailbox-attachment-close {
                    padding: 1rem;
                    margin: -1rem -1rem -1rem auto;
                    color: white;
                    outline: none;
                }
                .card-p1 {
                    color: #671688;
                }
            </style>
        @endpush
        @push('js')

    @endpush
