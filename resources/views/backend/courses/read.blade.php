@extends('master::layouts.master')

@section('title')
    {{ __('Course') }}
@endsection

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-header text-primary custom-bg-gradient-info">
                <h3 class="card-title font-weight-bold">{{ __('admin.course.index') }}</h3>

                <div class="card-tools">
                    <div class="btn-group">
                        <a href="{{route('admin.courses.edit', [$course->id])}}" class="btn btn-sm btn-outline-primary btn-rounded">
                            <i class="fas fa-plus-circle"></i> {{ __('admin.course.edit') }}
                        </a>
                        <a href="{{route('admin.courses.index')}}" class="btn btn-sm btn-outline-primary btn-rounded">
                            <i class="fas fa-backward"></i> {{__('admin.common.back')}}
                        </a>
                    </div>
                </div>

            </div>
            <div class="row card-body">
                <div class="col-md-12 custom-view-box">
                    <div class="card-header d-flex justify-content-between custom-bg-gradient-info">
                        <img src="{{asset('storage/' .$course->cover_image)}}" class="img-fluid" alt="Responsive image" style="height: 300px; width: 100%">
                    </div>
                </div>


                <div class="col-md-6 custom-view-box">
                    <p class="label-text">{{ __('admin.course.institute_title') }}</p>
                    <div class="input-box">
                        {{ $course->institute->title }}
                    </div>
                </div>
                <div class="col-md-6 custom-view-box">
                    <p class="label-text">{{ __('admin.course.branch') }}</p>
                    <div class="input-box">
                        {{ $course->branch->title }}
                    </div>
                </div>

                <div class="col-md-6 custom-view-box">
                    <p class="label-text">{{ __('admin.course.training_center') }}</p>
                    <div class="input-box">
                        {{ $course->trainingCenter->title }}
                    </div>
                </div>
                <div class="col-md-6 custom-view-box">
                    <p class="label-text">{{ __('admin.course.application_form_type') }}</p>
                    <div class="input-box">
                        {{ $course->applicationFormType->title }}
                    </div>
                </div>

                <div class="col-md-6 custom-view-box">
                    <p class="label-text">{{ __('admin.course.title') }}</p>
                    <div class="input-box">
                        {{ $course->title }}
                    </div>
                </div>

                <div class="col-md-6 custom-view-box">
                    <p class="label-text">{{ __('admin.course.code') }}</p>
                    <div class="input-box">
                        {{ $course->code }}
                    </div>
                </div>

                <div class="col-md-6 custom-view-box">
                    <p class="label-text">{{ __('admin.course.course_fee') }}</p>
                    <div class="input-box">
                        {{ $course->course_fee }}
                    </div>
                </div>
                <div class="col-md-6 custom-view-box">
                    <p class="label-text">{{ __('admin.course.application_start_date') }}</p>
                    <div class="input-box flat">
                        {{ $course->application_start_date }}
                    </div>
                </div>
                <div class="col-md-6 custom-view-box">
                    <p class="label-text">{{ __('admin.course.application_end_date') }}</p>
                    <div class="input-box">
                        {{ $course->application_end_date }}
                    </div>
                </div>
                <div class="col-md-6 custom-view-box">
                    <p class="label-text">{{ __('admin.course.course_start_date') }}</p>
                    <div class="input-box">
                        {{ $course->course_start_date }}
                    </div>
                </div> <div class="col-md-6 custom-view-box">
                    <p class="label-text">{{ __('admin.course.course_end_date') }}</p>
                    <div class="input-box">
                        {{ $course->course_end_date }}
                    </div>
                </div>
                <div class="col-md-6 custom-view-box">
                    <p class="label-text">{{ __('admin.course.duration') }}</p>
                    <div class="input-box">
                        {{ $course->duration }}
                    </div>
                </div>


                <div class="col-md-6 custom-view-box">
                    <p class="label-text">{{ __('admin.course.target_group') }}</p>
                    <div class="input-box">
                        {{ $course->target_group }}
                    </div>
                </div>

                <div class="col-md-6 custom-view-box">
                    <p class="label-text">{{ __('admin.course.object') }}</p>
                    <div class="input-box">
                        {{ $course->objects }}
                    </div>
                </div>

                <div class="col-md-6 custom-view-box">
                    <p class="label-text">{{ __('admin.course.content') }}</p>
                    <div class="input-box">
                        {{ $course->contents }}
                    </div>
                </div>

                <div class="col-md-6 custom-view-box">
                    <p class="label-text">{{ __('admin.course.training_methodology') }}</p>
                    <div class="input-box">
                        {{ $course->training_methodology }}
                    </div>
                </div>

                <div class="col-md-6 custom-view-box">
                    <p class="label-text">{{ __('admin.course.evaluation_system') }}</p>
                    <div class="input-box">
                        {{ $course->evaluation_system }}
                    </div>
                </div>

                <div class="col-md-6 custom-view-box">
                    <p class="label-text">{{ __('admin.course.course_prerequisite') }}</p>
                    <div class="input-box">
                        {{ $course->prerequisite ?? ""}}
                    </div>
                </div>
                <div class="col-md-6 custom-view-box">
                    <p class="label-text">{{ __('admin.course.eligibility') }}</p>
                    <div class="input-box">
                        {{ $course->eligibility ?? ""}}
                    </div>
                </div>

                <div class="col-md-6 custom-view-box">
                    <p class="label-text">{{ __('admin.course.description') }}</p>
                    <div class="input-box">
                        {{ $course->description ?? "" }}
                    </div>
                </div>

                <div class="col-md-6 custom-view-box">
                    <p class="label-text">{{ __('admin.course.status') }}</p>
                    <div class="input-box">
                        {!! $course->getCurrentRowStatus(true) !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
