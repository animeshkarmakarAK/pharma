@php
    /** @var \App\Models\User $authUser */
    $authUser = \App\Helpers\Classes\AuthHelper::getAuthUser();
@endphp
@extends('master::layouts.master')

@section('title')
    {{ __('course_management::admin.publish_course.index') }}
@endsection

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-header d-flex justify-content-between custom-bg-gradient-info">
                <h3 class="card-title font-weight-bold text-primary">{{ __('course_management::admin.publish_course.index') }}</h3>
                <div class="card-tools">
                    <div class="btn-group">
                        <a href="{{route('course_management::admin.publish-courses.edit', [$publishCourse->id])}}"
                           class="btn btn-sm btn-outline-primary btn-rounded">
                            <i class="fas fa-plus-circle"></i> {{ __('course_management::admin.publish_course.edit') }}
                        </a>
                        <a href="{{route('course_management::admin.publish-courses.index')}}"
                           class="btn btn-sm btn-outline-primary btn-rounded">
                            <i class="fas fa-backward"></i>{{__('course_management::admin.common.back')}}
                        </a>
                    </div>
                </div>
            </div>
            <div class="row card-body">

                @if(!$authUser->isInstituteUser())
                    <div class="col-md-6 custom-view-box">
                        <p class="label-text">{{ __('course_management::admin.publish_course.institute_name') }}</p>
                        <div class="input-box">
                            {{ $publishCourse->institute->title_en }}
                        </div>
                    </div>
                @endif

                <div class="col-md-6 custom-view-box">
                    <p class="label-text">{{ __('course_management::admin.publish_course.application_form_type') }}</p>
                    <div class="input-box">
                        {{ $publishCourse->applicationFormType->title_en}}
                    </div>
                </div>


                @if(!empty($preSelectedTrainingCenters))
                    <div class="col-md-6 custom-view-box">
                        <p class="label-text">{{ __('course_management::admin.publish_course.training_center') }}</p>
                        <div class="input-box">
                            @foreach($preSelectedTrainingCenters as $preSelectedTrainingCenter)
                                <span class="badge badge-info">{{ $preSelectedTrainingCenter->title_en}}</span>
                            @endforeach
                        </div>
                    </div>
                @endif

                <div class="col-md-6 custom-view-box">
                    <p class="label-text">{{ __('course_management::admin.publish_course.programme') }}</p>
                    <div class="input-box">
                        {{ $publishCourse->programme ? $publishCourse->programme->title_en : '' }}
                    </div>
                </div>

                <div class="col-md-6 custom-view-box">
                    <p class="label-text">{{ __('course_management::admin.publish_course.course_name') }}</p>
                    <div class="input-box">
                        {{ $publishCourse->course->title_en }}
                    </div>
                </div>

                <div class="col-md-6 custom-view-box">
                    <p class="label-text">{{ __('course_management::admin.common.status') }}</p>
                    <div class="input-box">
                        {!! $publishCourse->getCurrentRowStatus(true) !!}
                    </div>
                </div>

                <div class="col-sm-12 course-sessions mt-5">
                    <div class="card">
                        <div class="card-header custom-bg-gradient-info">
                            <h3 class="card-title text-primary font-weight-bold">{{ __('course_management::admin.publish_course.course_sessions') }}</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12 course-session-contents">
                                    @php
                                        $session = 0;
                                    @endphp
                                    @foreach($courseSessions as $courseSession)
                                        <div class="card" id="session-no-0">
                                            <div class="card-header d-flex justify-content-between">
                                                <h5>{{ $courseSession->session_name_en }} </h5>
                                            </div>
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-md-6 custom-view-box">
                                                        <p class="label-text">{{ __('course_management::admin.publish_course.session_name') }}</p>
                                                        <div class="input-box">
                                                            {{ $courseSession->session_name_en }}
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6 custom-view-box">
                                                        <p class="label-text">{{ __('course_management::admin.publish_course.number_of_batches') }}</p>
                                                        <div class="input-box">
                                                            {{ $courseSession->number_of_batches }}
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6 custom-view-box">
                                                        <p class="label-text">{{ __('course_management::admin.publish_course.application_start_date') }}</p>
                                                        <div class="input-box">
                                                            {{ date('Y-m-d', strtotime($courseSession->application_start_date)) }}
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6 custom-view-box">
                                                        <p class="label-text">{{ __('course_management::admin.publish_course.application_end_date') }}</p>
                                                        <div class="input-box">
                                                            {{ date('Y-m-d', strtotime($courseSession->application_end_date)) }}
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6 custom-view-box">
                                                        <p class="label-text">{{ __('course_management::admin.publish_course.course_start_date') }}</p>
                                                        <div class="input-box">
                                                            {{ date('Y-m-d', strtotime($courseSession->course_start_date)) }}
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6 custom-view-box">
                                                        <p class="label-text">{{ __('course_management::admin.publish_course.max_student_enrollment') }}</p>
                                                        <div class="input-box">
                                                            {{ $courseSession->max_seat_available }}
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    @endforeach

                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
