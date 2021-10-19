@php
    /** @var \App\Models\User $authUser */
    $authUser = \App\Helpers\Classes\AuthHelper::getAuthUser();
@endphp
@extends('master::layouts.master')

@section('title')
    Organization Complain
@endsection

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-header text-primary custom-bg-gradient-info">
                <h3 class="card-title font-weight-bold">
                    Complain from
                    {{ !empty($organizationComplainToYouth)? $organizationComplainToYouth->organization->title_en : '' }}</h3>

                <div class="card-tools">
                    <div class="btn-group">
                        <a href="{{route('course_management::admin.organization-complains')}}"
                           class="btn btn-sm btn-outline-primary btn-rounded">
                            <i class="fas fa-backward"></i> {{ __('Back to list') }}
                        </a>
                    </div>
                </div>
            </div>

            <div class="row card-body">

                <div class="col-md-6 custom-view-box">
                    <p class="label-text">{{ __('Complain From (Industry)') }}</p>
                    <div class="input-box">
                        {{ !empty($organizationComplainToYouth)? $organizationComplainToYouth->organization->title_en:''}}
                    </div>
                </div>
                <div class="col-md-6 custom-view-box">
                    <p class="label-text">{{ __('Complain against (Youth)') }}</p>
                    <div class="input-box">
                        {{ !empty($organizationComplainToYouth)? $organizationComplainToYouth->youth->name_en : ''}}
                    </div>
                </div>

                @if(!$authUser->isInstituteUser())
                    <div class="col-md-6  custom-view-box">
                        <p class="label-text">{{ __('Institute Name') }}</p>
                        <div class="input-box">
                            {{ !empty($organizationComplainToYouth)? $organizationComplainToYouth->institute->title_en : ''}}
                        </div>
                    </div>
                @endif


                <div class="col-md-6 custom-view-box">
                    <p class="label-text">{{ __('Complain Message') }}</p>
                    <div class="input-box" style="min-height: 130px">
                        {{ !empty($organizationComplainToYouth)? $organizationComplainToYouth->complain_message : ''}}
                    </div>
                </div>


            </div>
        </div>
    </div>
@endsection
