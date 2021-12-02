@php
    /** @var \App\Models\User $authUser */
    $authUser = \App\Helpers\Classes\AuthHelper::getAuthUser();
@endphp
@extends('master::layouts.master')

@section('title')
    {{ __('course_management::admin.examination_result.list') }} :: {{ __('course_management::admin.common.read') }}
@endsection

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-header text-primary custom-bg-gradient-info">
                <h3 class="card-title font-weight-bold">{{ __('course_management::admin.common.read') }}</h3>

                <div class="card-tools">
                    <div class="btn-group">
                        <a href="{{route('course_management::admin.examination-results.edit', [$examinationResult->id])}}" class="btn btn-sm btn-outline-primary btn-rounded">
                            <i class="fas fa-plus-circle"></i> {{ __('course_management::admin.common.edit') }}
                        </a>
                        <a href="{{route('course_management::admin.examination-results.index')}}" class="btn btn-sm btn-outline-primary btn-rounded">
                            <i class="fas fa-backward"></i> {{ __('course_management::admin.common.back') }}
                        </a>
                    </div>
                </div>
            </div>

            <div class="row card-body">

                <div class="col-md-6 custom-view-box">
                    <p class="label-text">{{__('course_management::admin.examination_result.achieved_marks')}}</p>
                    <div class="input-box">
                        {{ $examinationResult->achieved_marks }}
                    </div>
                </div>

                <div class="col-md-6 custom-view-box">
                    <p class="label-text">{{__('course_management::admin.examination_result.feedback')}}</p>
                    <div class="input-box">
                        {{ $examinationResult->feedback }}
                    </div>
                </div>



                <div class="col-md-6 custom-view-box">
                    <p class="label-text">{{__('course_management::admin.examination_result.examination')}}</p>
                    <div class="input-box">
                        {{ $examinationResult->examination->examinationType->title }}
                    </div>
                </div>

                <div class="col-md-6 custom-view-box">
                    <p class="label-text">{{__('course_management::admin.examination_result.training_center')}}</p>
                    <div class="input-box">
                        {{ $examinationResult->trainingCenter->title_en }}
                    </div>
                </div>

                <div class="col-md-6 custom-view-box">
                    <p class="label-text">{{__('course_management::admin.examination_result.batch_title')}}</p>
                    <div class="input-box">
                        {{ $examinationResult->batch->title_en }}
                    </div>
                </div>

                <div class="col-md-6 custom-view-box">
                    <p class="label-text">{{__('course_management::admin.examination_result.youth')}}</p>
                    <div class="input-box">
                        {{ $examinationResult->youth->name_en }}
                    </div>
                </div>



            </div>
        </div>
    </div>
@endsection
