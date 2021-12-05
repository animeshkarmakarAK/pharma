@extends('master::layouts.master')

@section('title')
    {{ __('course_management::admin.static_page.index') }}
@endsection

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-header text-primary custom-bg-gradient-info">
                <h3 class="card-title font-weight-bold">Static Page</h3>
                <div class="card-tools">
                    <div class="btn-group">
                        <a href="{{route('course_management::admin.static-page.edit', [$staticPage->id])}}" class="btn btn-sm btn-outline-primary btn-rounded">
                            <i class="fas fa-plus-circle"></i> {{ __('course_management::admin.static_page.edit') }}
                        </a>
                        <a href="{{route('course_management::admin.static-page.index')}}" class="btn btn-sm btn-outline-primary btn-rounded">
                            <i class="fas fa-backward"></i> {{__('course_management::admin.common.back')}}
                        </a>
                    </div>
                </div>

            </div>
            <div class="row card-body">
                <div class="col-md-6 custom-view-box">
                    <p class="label-text">{{ __('course_management::admin.static_page.content_title') }}}</p>
                    <div class="input-box">
                        {{ $staticPage->title_en }}
                    </div>
                </div>


                <div class="col-md-6 custom-view-box">
                    <p class="label-text">{{ __('course_management::admin.static_page.link') }}</p>
                    <div class="input-box">
                        {{ $staticPage->page_id }}
                    </div>
                </div>


                <div class="col-md-6 custom-view-box">
                    <p class="label-text">{{ __('course_management::admin.static_page.index') }}</p>
                    <div class="input-box">
                        {{ $staticPage->institute->title_en  }}
                    </div>
                </div>

                <div class="col-md-12 custom-view-box">
                    <p class="label-text">{{ __('course_management::admin.static_page.detail') }}</p>
                    <div class="input-box">
                        {!!  $staticPage->page_contents !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
