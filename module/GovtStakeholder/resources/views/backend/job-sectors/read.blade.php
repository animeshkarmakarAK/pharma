@php
    /** @var \App\Models\User $authUser */
    $authUser = \App\Helpers\Classes\AuthHelper::getAuthUser();
@endphp
@extends('master::layouts.master')

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-header text-primary custom-bg-gradient-info">
                <h3 class="card-title font-weight-bold">Job Sector</h3>

                <div class="card-tools">
                    <div class="btn-group">
                        <a href="{{route('govt_stakeholder::admin.job-sectors.edit', [$jobSector->id])}}"
                           class="btn btn-sm btn-outline-primary btn-rounded">
                            <i class="fas fa-plus-circle"></i> {{ __('Edit Job Sector') }}
                        </a>
                        <a href="{{route('govt_stakeholder::admin.job-sectors.index')}}" class="btn btn-sm btn-outline-primary btn-rounded">
                            <i class="fas fa-backward"></i> {{ __('Back to list') }}
                        </a>
                    </div>
                </div>
            </div>

            <div class="row card-body">

                <div class="col-md-6 custom-view-box">
                    <p class="label-text">{{ __('Title (EN)') }}</p>
                    <div class="input-box">
                        {{ $jobSector->title_en ? $jobSector->title_en : '' }}
                    </div>
                </div>

                <div class="col-md-6 custom-view-box">
                    <p class="label-text">{{ __('Title (BN)') }}</p>
                    <div class="input-box">
                        {{ $jobSector->title_bn ? $jobSector->title_bn : '' }}
                    </div>
                </div>

                <div class="col-md-6 custom-view-box">
                    <p class="label-text">{{ __('Active Status') }}</p>
                    <div class="input-box">
                        {!! $jobSector->getCurrentRowStatus(true)  !!}
                    </div>
                </div>



            </div>
        </div>
    </div>
@endsection
