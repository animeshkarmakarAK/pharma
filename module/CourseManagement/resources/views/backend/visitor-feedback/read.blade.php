@php
    /** @var \App\Models\User $authUser */
    $authUser = \App\Helpers\Classes\AuthHelper::getAuthUser();
@endphp
@extends('master::layouts.master')

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-header text-primary custom-bg-gradient-info">
                <h3 class="card-title font-weight-bold">Branch</h3>

                <div class="card-tools">
                    <div class="btn-group">
                        <a href="{{route('admin.visitor-feedback.index')}}" class="btn btn-sm btn-outline-primary btn-rounded">
                            <i class="fas fa-backward"></i> {{ __('Back to list') }}
                        </a>
                    </div>
                </div>
            </div>

            <div class="row card-body">

                <div class="col-md-6 custom-view-box">
                    <p class="label-text">{{ __('Name') }}</p>
                    <div class="input-box">
                        {{ $visitorFeedback->name }}
                    </div>
                </div>

                <div class="col-md-6 custom-view-box">
                    <p class="label-text">{{ __('Mobile') }}</p>
                    <div class="input-box">
                        {{ $visitorFeedback->mobile }}
                    </div>
                </div>

                <div class="col-md-6 custom-view-box">
                    <p class="label-text">{{ __('Email') }}</p>
                    <div class="input-box">
                        {{ $visitorFeedback->email }}
                    </div>
                </div>

                @if($visitorFeedback->address)
                <div class="col-md-6 custom-view-box">
                    <p class="label-text">{{ __('Address') }}</p>
                    <div class="input-box">
                        {{ $visitorFeedback->address }}
                    </div>
                </div>
                @endif

                @if(!$authUser->isInstituteUser())
                    <div class="col-md-6  custom-view-box">
                        <p class="label-text">{{ __('Institute Name') }}</p>
                        <div class="input-box">
                            {{$visitorFeedback->institute->title_en}}
                        </div>
                    </div>
                @endif

                <div class="col-md-6 custom-view-box">
                    <p class="label-text">{{ __('Type') }}</p>
                    <div class="input-box">
                        {{ $visitorFeedback->type==\App\Models\VisitorFeedback::FORM_TYPE_FEEDBACK?'Feedback':'Contact' }}
                    </div>
                </div>

                <div class="col-md-6 custom-view-box">
                    <p class="label-text">{{ __('Comment') }}</p>
                    <div class="input-box" style="min-height: 130px">
                        {{ $visitorFeedback->comment }}
                    </div>
                </div>


            </div>
        </div>
    </div>
@endsection
