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
                        <a href="{{route('course_management::admin.gallery-categories.edit', [$galleryCategory->id])}}" class="btn btn-sm btn-outline-primary btn-rounded">
                            <i class="fas fa-plus-circle"></i> {{ __('Edit Branch') }}
                        </a>
                        <a href="{{route('course_management::admin.gallery-categories.index')}}" class="btn btn-sm btn-outline-primary btn-rounded">
                            <i class="fas fa-backward"></i> {{ __('Back to list') }}
                        </a>
                    </div>
                </div>
            </div>

            <div class="row card-body">

                <div class="col-md-6 custom-view-box">
                    <p class="label-text">{{ __('Title (En)') }}</p>
                    <div class="input-box">
                        {{ $galleryCategory->title_en }}
                    </div>
                </div>

                <div class="col-md-6 custom-view-box">
                    <p class="label-text">{{ __('Title (Bn)') }}</p>
                    <div class="input-box">
                        {{ $galleryCategory->title_bn }}
                    </div>
                </div>

                @if(!$authUser->isInstituteUser())
                    <div class="col-md-6 custom-view-box">
                        <p class="label-text">{{ __('Institute Name') }}</p>
                        <div class="input-box">
                            {{ $galleryCategory->institute->title_en }}
                        </div>
                    </div>
                @endif


            </div>
        </div>
    </div>
@endsection
