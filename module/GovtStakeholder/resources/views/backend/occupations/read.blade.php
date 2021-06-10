@extends('master::layouts.master')


@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-header text-primary custom-bg-gradient-info">
                <h3 class="card-title">{{ __('Occupation') }}</h3>
            </div>
            <div class="row card-body">
                <div class="col-md-6 custom-view-box">
                    <p class="label-text">{{ __('Title(Bangla)') }}</p>
                    <div class="input-box">
                        {{ $occupation->title_bn }}
                    </div>
                </div>
                <div class="col-md-6 custom-view-box">
                    <p class="label-text">{{ __('Title(English)') }}</p>
                    <div class="input-box">
                        {{ $occupation->title_en }}
                    </div>
                </div>
                <div class="col-md-6 custom-view-box">
                    <p class="label-text">{{ __('Job Sector') }}</p>
                    <div class="input-box">
                        {{ $occupation->jobSector->title_en }}
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
