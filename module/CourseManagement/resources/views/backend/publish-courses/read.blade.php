@php
    /** @var \App\Models\User $authUser */
    $authUser = \App\Helpers\Classes\AuthHelper::getAuthUser();
@endphp
@extends('master::layouts.master')

@section('title')
    {{ __('Course Config') }}
@endsection

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-header d-flex justify-content-between custom-bg-gradient-info">
                <h3 class="card-title font-weight-bold text-primary">Course Config</h3>
                <div class="card-tools">
                    <div class="btn-group">
                        <a href="{{route('course_management::admin.publish-courses.edit', [$publishCourse->id])}}"
                           class="btn btn-sm btn-outline-primary btn-rounded">
                            <i class="fas fa-plus-circle"></i> {{ __('Edit Permission') }}
                        </a>
                        <a href="{{route('course_management::admin.publish-courses.index')}}"
                           class="btn btn-sm btn-outline-primary btn-rounded">
                            <i class="fas fa-backward"></i> {{ __('Back to list') }}
                        </a>
                    </div>
                </div>
            </div>
            <div class="row card-body">

                @if(!$authUser->isInstituteUser())
                    <div class="col-md-6 custom-view-box">
                        <p class="label-text">{{ __('Institute Name') }}</p>
                        <div class="input-box">
                            {{ $publishCourse->institute->title_en }}
                        </div>
                    </div>
                @endif

                <div class="col-md-6 custom-view-box">
                    <p class="label-text">{{ __('Application Form Type') }}</p>
                    <div class="input-box">
                        {{ $publishCourse->applicationFormType->title_en}}
                    </div>
                </div>

                <div class="col-md-6 custom-view-box">
                    <p class="label-text">{{ __('Branch Name') }}</p>
                    <div class="input-box">
                        {{ $publishCourse->branch ? $publishCourse->branch->title_en : '' }}
                    </div>
                </div>

                <div class="col-md-6 custom-view-box">
                    <p class="label-text">{{ __('Training Center') }}</p>
                    <div class="input-box">
                        {{ $publishCourse->trainingCenter ? $publishCourse->trainingCenter->title_en : ''}}
                    </div>
                </div>

                <div class="col-md-6 custom-view-box">
                    <p class="label-text">{{ __('Programme') }}</p>
                    <div class="input-box">
                        {{ $publishCourse->programme ? $publishCourse->programme->title_en : '' }}
                    </div>
                </div>

                <div class="col-md-6 custom-view-box">
                    <p class="label-text">{{ __('Course Name') }}</p>
                    <div class="input-box">
                        {{ $publishCourse->course->title_en }}
                    </div>
                </div>

                <div class="col-md-6 custom-view-box">
                    <p class="label-text">{{ __('Course Publish Status') }}</p>
                    <div class="input-box">
                        {{ $publishCourse->rowStatus->title }}
                    </div>
                </div>

                <div class="col-sm-12 course-sessions mt-5">
                    <div class="card">
                        <div class="card-header custom-bg-gradient-info">
                            <h3 class="card-title text-primary font-weight-bold">Course Sessions</h3>
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
                                                        <p class="label-text">{{ __('Session Name(English)') }}</p>
                                                        <div class="input-box">
                                                            {{ $courseSession->session_name_en }}
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6 custom-view-box">
                                                        <p class="label-text">{{ __('Session Name(Bangla)') }}</p>
                                                        <div class="input-box">
                                                            {{ $courseSession->session_name_bn }}
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6 custom-view-box">
                                                        <p class="label-text">{{ __('Number of Batches') }}</p>
                                                        <div class="input-box">
                                                            {{ $courseSession->number_of_batches }}
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6 custom-view-box">
                                                        <p class="label-text">{{ __('Application Start Date') }}</p>
                                                        <div class="input-box">
                                                            {{ date('Y-m-d', strtotime($courseSession->application_start_date)) }}
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6 custom-view-box">
                                                        <p class="label-text">{{ __('Application End Date') }}</p>
                                                        <div class="input-box">
                                                            {{ date('Y-m-d', strtotime($courseSession->application_end_date)) }}
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6 custom-view-box">
                                                        <p class="label-text">{{ __('Course Start Date') }}</p>
                                                        <div class="input-box">
                                                            {{ date('Y-m-d', strtotime($courseSession->course_start_date)) }}
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6 custom-view-box">
                                                        <p class="label-text">{{ __('Max Student Enrollment') }}</p>
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
