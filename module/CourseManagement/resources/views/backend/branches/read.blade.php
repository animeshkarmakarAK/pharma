@php
    /** @var \App\Models\User $authUser */
    $authUser = \App\Helpers\Classes\AuthHelper::getAuthUser();
@endphp
@extends('master::layouts.master')

@section('title')
    {{ __('Branch') }}
@endsection

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-header text-primary custom-bg-gradient-info">
                <h3 class="card-title font-weight-bold">Branch</h3>

                <div class="card-tools">
                    <div class="btn-group">
                        <a href="{{route('course_management::admin.branches.edit', [$branch->id])}}" class="btn btn-sm btn-outline-primary btn-rounded">
                            <i class="fas fa-plus-circle"></i> {{ __('Edit Branch') }}
                        </a>
                        <a href="{{route('course_management::admin.branches.index')}}" class="btn btn-sm btn-outline-primary btn-rounded">
                            <i class="fas fa-backward"></i> {{ __('Back to list') }}
                        </a>
                    </div>
                </div>
            </div>

            <div class="row card-body">

                <div class="col-md-6 custom-view-box">
                    <p class="label-text">{{ __('Title(EN)') }}</p>
                    <div class="input-box">
                        {{ $branch->title_en }}
                    </div>
                </div>

                <div class="col-md-6 custom-view-box">
                    <p class="label-text">{{ __('Title(BN)') }}</p>
                    <div class="input-box">
                        {{ $branch->title_bn }}
                    </div>
                </div>

                <div class="col-md-6 custom-view-box">
                    <p class="label-text">{{ __('Address') }}</p>
                    <div class="input-box" style="min-height: 100px;">
                        {{ $branch->address }}
                    </div>
                </div>

                <div class="col-md-6 custom-view-box">
                    <p class="label-text">{{ __('Google Map SRC') }}</p>
                    <div class="input-box" style="min-height: 100px;">
                        {{ $branch->google_map_src }}
                    </div>
                </div>

                @if(!$authUser->isInstituteUser())
                    <div class="col-md-6  custom-view-box">
                        <p class="label-text">{{ __('Institute Name') }}</p>
                        <div class="input-box">
                            {{$branch->institute->title_en}}
                        </div>
                    </div>
                @endif


            </div>
        </div>
    </div>
@endsection
