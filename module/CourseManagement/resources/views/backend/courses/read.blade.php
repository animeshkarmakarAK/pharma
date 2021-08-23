@extends('master::layouts.master')

@section('title')
    {{ __('Course') }}
@endsection

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-header text-primary custom-bg-gradient-info">
                <h3 class="card-title font-weight-bold">{{ __('Course') }}</h3>

                <div class="card-tools">
                    <div class="btn-group">
                        <a href="{{route('course_management::admin.courses.edit', [$course->id])}}" class="btn btn-sm btn-outline-primary btn-rounded">
                            <i class="fas fa-plus-circle"></i> {{ __('Edit Course') }}
                        </a>
                        <a href="{{route('course_management::admin.courses.index')}}" class="btn btn-sm btn-outline-primary btn-rounded">
                            <i class="fas fa-backward"></i> {{ __('Back to list') }}
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
                    <p class="label-text">{{ __('Title(EN)') }}</p>
                    <div class="input-box">
                        {{ $course->title_en }}
                    </div>
                </div>

                <div class="col-md-6 custom-view-box">
                    <p class="label-text">{{ __('Title(BN)') }}</p>
                    <div class="input-box">
                        {{ $course->title_bn }}
                    </div>
                </div>

                <div class="col-md-6 custom-view-box">
                    <p class="label-text">{{ __('Institute Name') }}</p>
                    <div class="input-box">
                        {{ $course->institute->title_en }}
                    </div>
                </div>

                <div class="col-md-6 custom-view-box">
                    <p class="label-text">{{ __('Course Code') }}</p>
                    <div class="input-box">
                        {{ $course->code }}
                    </div>
                </div>

                <div class="col-md-6 custom-view-box">
                    <p class="label-text">{{ __('Course Fee') }}</p>
                    <div class="input-box">
                        {{ $course->course_fee }}
                    </div>
                </div>

                <div class="col-md-6 custom-view-box">
                    <p class="label-text">{{ __('Course Duration') }}</p>
                    <div class="input-box">
                        {{ $course->duration }}
                    </div>
                </div>


                <div class="col-md-6 custom-view-box">
                    <p class="label-text">{{ __('Target Group')  }}</p>
                    <div class="input-box">
                        {{ $course->target_group }}
                    </div>
                </div>

                <div class="col-md-6 custom-view-box">
                    <p class="label-text">{{ __('Course Objects')  }}</p>
                    <div class="input-box">
                        {{ $course->objects }}
                    </div>
                </div>

                <div class="col-md-6 custom-view-box">
                    <p class="label-text">{{ __('Course Contents')  }}</p>
                    <div class="input-box">
                        {{ $course->contents }}
                    </div>
                </div>

                <div class="col-md-6 custom-view-box">
                    <p class="label-text">{{ __('Course Methodology')  }}</p>
                    <div class="input-box">
                        {{ $course->training_methodology }}
                    </div>
                </div>

                <div class="col-md-6 custom-view-box">
                    <p class="label-text">{{ __('Evaluation System')  }}</p>
                    <div class="input-box">
                        {{ $course->evaluation_system }}
                    </div>
                </div>

                <div class="col-md-6 custom-view-box">
                    <p class="label-text">{{ __('Course Prerequisite') }}</p>
                    <div class="input-box">
                        {{ $course->prerequisite ?? ""}}
                    </div>
                </div>
                <div class="col-md-6 custom-view-box">
                    <p class="label-text">{{ __('Eligibility') }}</p>
                    <div class="input-box">
                        {{ $course->eligibility ?? ""}}
                    </div>
                </div>

                <div class="col-md-6 custom-view-box">
                    <p class="label-text">{{ __('Course Description')  }}</p>
                    <div class="input-box">
                        {{ $course->description ?? "" }}
                    </div>
                </div>

                <div class="col-md-6 custom-view-box">
                    <p class="label-text">{{ __('Active Status') }}</p>
                    <div class="input-box">
                        {!! $course->getCurrentRowStatus(true) !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
