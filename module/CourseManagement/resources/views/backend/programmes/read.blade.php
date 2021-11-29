@php
    /** @var \App\Models\User $authUser */
    $authUser = \App\Helpers\Classes\AuthHelper::getAuthUser();
@endphp

@extends('master::layouts.master')

@section('title')
    {{ __('Programmes') }}
@endsection

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-header text-primary custom-bg-gradient-info">
                <h3 class="card-title font-weight-bold">Programme</h3>

                <div class="card-tools">
                    <div class="btn-group">
                        <a href="{{route('course_management::admin.programmes.edit', [$programme->id])}}" class="btn btn-sm btn-outline-primary btn-rounded">
                            <i class="fas fa-edit"></i> {{ __('Edit Programme') }}
                        </a>
                        <a href="{{route('course_management::admin.programmes.index')}}" class="btn btn-sm btn-outline-primary btn-rounded">
                            <i class="fas fa-backward"></i> {{ __('Back to list') }}
                        </a>
                    </div>

                </div>

            </div>
            <div class="row card-body">
                <div class="col-md-6 custom-view-box">
                    <p class="label-text">{{ __('Title(EN)') }}</p>
                    <div class="input-box">
                        {{ $programme->title_en }}
                    </div>
                </div>

                @if(!$authUser->isInstituteUser())
                    <div class="col-md-6 mt-2 custom-view-box">
                        <p class="label-text">{{ __('Institute Name') }}</p>
                        <div class="input-box">
                            {{ $programme->institute->title_en }}
                        </div>
                    </div>
                @endif



                <div class="col-md-6 mt-2 custom-view-box">
                    <p class="label-text">{{ __('Code') }}</p>
                    <div class="input-box">
                        {{ $programme->code }}
                    </div>
                </div>

                <div class="col-md-6 mt-2 custom-view-box">
                    <p class="label-text">{{ __('Logo') }}</p>
                    <div class="input-box">
                        <img src="{{ asset("storage/{$programme->logo}") }}" alt="" title="" height="50px"  />
                    </div>
                </div>

                <div class="col-md-6 mt-2 custom-view-box">
                    <p class="label-text">{{ __('Description') }}</p>
                    <div class="input-box">
                        {{ $programme->description }}
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
