@php
    /** @var \App\Models\User $authUser */
    $authUser = \App\Helpers\Classes\AuthHelper::getAuthUser();
@endphp


@extends('master::layouts.master')

@section('title')
    {{ __('Album') }}
@endsection

@section('content')


    <div class="container-fluid">
        <div class="card">
            <div class="card-header text-primary custom-bg-gradient-info">
                <h3 class="card-title font-weight-bold">Album</h3>

                <div class="card-tools">
                    <div class="btn-group">
                        <a href="{{route('course_management::admin.gallery-categories.edit', [$galleryCategory->id])}}"
                           class="btn btn-sm btn-outline-primary btn-rounded">
                            <i class="fas fa-plus-circle"></i> {{ __('Edit Album') }}
                        </a>
                        <a href="{{route('course_management::admin.gallery-categories.index')}}"
                           class="btn btn-sm btn-outline-primary btn-rounded">
                            <i class="fas fa-backward"></i> {{__('course_management::admin.common.back')}}
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
                @if(!$authUser->isInstituteUser())
                    <div class="col-md-6 custom-view-box">
                        <p class="label-text">{{ __('Institute Name') }}</p>
                        <div class="input-box">
                            {{ $galleryCategory->institute->title_en }}
                        </div>
                    </div>
                @endif

                <div class="col-md-6 custom-view-box">
                    <p class="label-text">{{ __('Programme') }}</p>
                    <div class="input-box">
                        {{ !empty($galleryCategory->programme->title_en) }}
                    </div>
                </div>

                <div class="col-md-6 custom-view-box">
                    <p class="label-text">{{ __('Batch') }}</p>
                    <div class="input-box">
                        {{ !empty($galleryCategory->batch->title_en) }}
                    </div>
                </div>

                <div class="col-md-6 custom-view-box">
                    <p class="label-text">{{ __('Featured status') }}</p>
                    <div class="input-box">
                        {!! $galleryCategory->featured == 1 ? '<span class="badge badge-success">Yes</span>' : '<span class="badge badge-danger">No</span>' !!}
                    </div>
                </div>
                <div class="col-md-6 custom-view-box mt-2">
                    <p class="label-text">{{ __('Active status') }}</p>
                    <div class="input-box">
                        {!! $galleryCategory->row_status == 1 ? '<span class="badge badge-success">Yes</span>' : '<span class="badge badge-danger">No</span>' !!}
                    </div>
                </div>

                <div class="col-md-6 mt-2 custom-view-box">
                    <p class="label-text">{{ __('Cover Image') }}</p>
                    <div class="input-box">
                        <img src="{{ asset("storage/{$galleryCategory->image}") }}" alt="Cover Image" title="" height="22px"  />
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
