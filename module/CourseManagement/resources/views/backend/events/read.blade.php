@php
    /** @var \App\Models\User $authUser */
    $authUser = \App\Helpers\Classes\AuthHelper::getAuthUser();
@endphp

@extends('master::layouts.master')

@section('title')
    {{ __('Training Center') }}
@endsection

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-header text-primary custom-bg-gradient-info">
                <h3 class="card-title font-weight-bold">Training Center</h3>

                <div class="card-tools">
                    <div class="btn-group">
                        <a href="{{route('course_management::admin.training-centers.edit', [$trainingCenter->id])}}" class="btn btn-sm btn-outline-primary btn-rounded">
                            <i class="fas fa-plus-circle"></i> {{ __('Edit Training Center') }}
                        </a>
                        <a href="{{route('course_management::admin.training-centers.index')}}" class="btn btn-sm btn-outline-primary btn-rounded">
                            <i class="fas fa-backward"></i> {{ __('Back to list') }}
                        </a>
                    </div>
                </div>

            </div>
            <div class="row card-body">
                <div class="col-md-6 custom-view-box">
                    <p class="label-text">{{ __('Title(EN)') }}</p>
                    <div class="input-box">
                        {{ $trainingCenter->title_en }}
                    </div>
                </div>
                <div class="col-md-6 custom-view-box">
                    <p class="label-text">{{ __('Title(BN)') }}</p>
                    <div class="input-box">
                        {{ $trainingCenter->title_bn }}
                    </div>
                </div>

                <div class="col-md-6 custom-view-box">
                    <p class="label-text">{{ __('Address') }}</p>
                    <div class="input-box" style="min-height: 100px;">
                        {{ $trainingCenter->address }}
                    </div>
                </div>

                <div class="col-md-6 custom-view-box">
                    <p class="label-text">{{ __('Google Map src') }}</p>
                    <div class="input-box" style="min-height: 100px;">
                        {{ $trainingCenter->google_map_src }}
                    </div>
                </div>

                @if(!$authUser->isInstituteUser())
                    <div class="col-md-6 mt-2 custom-view-box">
                        <p class="label-text">{{ __('Institute Name') }}</p>
                        <div class="input-box">
                            {{ $trainingCenter->institute->title_en }}
                        </div>
                    </div>
                @endif


                <div class="col-md-6 mt-2 custom-view-box">
                    <p class="label-text">{{ __('Branch') }}</p>
                    <div class="input-box">
                        {{ !empty($trainingCenter->branch)?$trainingCenter->branch->title_en:'' }}
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
