@php
    /** @var \App\Models\User $authUser */
    $authUser = \App\Helpers\Classes\AuthHelper::getAuthUser();
@endphp


@extends('master::layouts.master')

@section('title')
    {{ __('Batch') }}
@endsection

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-header d-flex justify-content-between custom-bg-gradient-info">
                <h3 class="card-title font-weight-bold text-primary">{{__('course_management::admin.batch.index')}}</h3>
                <div class="card-tools">
                    <div class="btn-group">
                        <a href="{{route('course_management::admin.batches.edit', [$batch->id])}}" class="btn btn-sm btn-outline-primary btn-rounded">
                            <i class="fas fa-plus-circle"></i> {{__('course_management::admin.batch.edit')}}
                        </a>
                        <a href="{{route('course_management::admin.batches.index')}}" class="btn btn-sm btn-outline-primary btn-rounded">
                            <i class="fas fa-backward"></i> {{__('course_management::admin.common.back')}}
                        </a>
                    </div>
                </div>
            </div>
            <div class="row card-body">

                <div class="col-md-6 custom-view-box">
                    <p class="label-text">{{__('course_management::admin.batch.title')}}</p>
                    <div class="input-box">
                        {{ $batch->title_en }}
                    </div>
                </div>
                @if(!$authUser->isInstituteUser())
                <div class="col-md-6 custom-view-box">
                    <p class="label-text">{{__('course_management::admin.batch.institute_name')}}</p>
                    <div class="input-box">
                        {{ $batch->institute->title_en }}
                    </div>
                </div>
                @endif

                <div class="col-md-6 custom-view-box">
                    <p class="label-text">{{__('course_management::admin.batch.publish_course')}}</p>
                    <div class="input-box">
                        {{ $batch->course->title_en }}
                    </div>
                </div>

                <div class="col-md-6 custom-view-box">
                    <p class="label-text">{{__('course_management::admin.batch.training_center')}}</p>
                    <div class="input-box">
                        {{ $batch->trainingCenter->title_en }}
                    </div>
                </div>

                <div class="col-md-6 custom-view-box">
                    <p class="label-text">{{__('course_management::admin.batch.code')}}</p>
                    <div class="input-box">
                        {{ $batch->code }}
                    </div>
                </div>

                <div class="col-md-6 custom-view-box">
                    <p class="label-text">{{__('course_management::admin.batch.max_student_enrollment')}}</p>
                    <div class="input-box">
                        {{ $batch->max_student_enrollment }}
                    </div>
                </div>

                <div class="col-md-6 custom-view-box">
                    <p class="label-text">{{__('course_management::admin.batch.start_date')}}</p>
                    <div class="input-box">
                        {{ date("d M, Y", strtotime($batch->start_date)) }}
                    </div>
                </div>

                <div class="col-md-6 custom-view-box">
                    <p class="label-text">{{__('course_management::admin.batch.end_date')}}</p>
                    <div class="input-box">
                        {{ date("d M, Y", strtotime($batch->end_date)) }}
                    </div>
                </div>

                <div class="col-md-6 custom-view-box">
                    <p class="label-text">{{__('course_management::admin.batch.start_time')}}</p>
                    <div class="input-box">
                        {{ date("g:i A", strtotime($batch->start_time)) }}
                    </div>
                </div>

                <div class="col-md-6 custom-view-box">
                    <p class="label-text">{{__('course_management::admin.batch.end_time')}}</p>
                    <div class="input-box">
                        {{ date("g:i A", strtotime($batch->end_time)) }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
