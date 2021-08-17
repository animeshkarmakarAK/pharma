@extends('master::layouts.master')

@section('title')
    {{ __('Static Page') }}
@endsection

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-header text-primary custom-bg-gradient-info">
                <h3 class="card-title">Static Page</h3>

                <div class="card-tools">
                    <div class="btn-group">
                        <a href="{{route('course_management::admin.static-page.edit', [$staticPage->id])}}" class="btn btn-sm btn-outline-primary btn-rounded">
                            <i class="fas fa-plus-circle"></i> {{ __('Edit Static Page') }}
                        </a>
                        <a href="{{route('course_management::admin.static-page.index')}}" class="btn btn-sm btn-outline-primary btn-rounded">
                            <i class="fas fa-backward"></i> {{ __('Back to list') }}
                        </a>
                    </div>
                </div>

            </div>
            <div class="row card-body">
                <div class="col-md-6 custom-view-box">
                    <p class="label-text">{{ __('Content Title(EN)') }}</p>
                    <div class="input-box">
                        {{ $staticPage->title_en }}
                    </div>
                </div>

                <div class="col-md-6 custom-view-box">
                    <p class="label-text">{{ __('Content Title(BN)') }}</p>
                    <div class="input-box">
                        {{ $staticPage->title_bn }}
                    </div>
                </div>

                <div class="col-md-6 custom-view-box">
                    <p class="label-text">{{ __('Page Id') }}</p>
                    <div class="input-box">
                        {{ $staticPage->page_id }}
                    </div>
                </div>


                <div class="col-md-6 custom-view-box">
                    <p class="label-text">{{ __('Static Page') }}</p>
                    <div class="input-box">
                        {{ $staticPage->institute->title_en  }}
                    </div>
                </div>

                <div class="col-md-12 custom-view-box">
                    <p class="label-text">{{ __('Static Page Details') }}</p>
                    <div class="input-box">
                        {!!  $staticPage->page_contents !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
