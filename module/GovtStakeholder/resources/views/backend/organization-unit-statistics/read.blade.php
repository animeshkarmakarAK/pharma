@php
    /** @var \App\Models\User $authUser */
    $authUser = \App\Helpers\Classes\AuthHelper::getAuthUser();
@endphp
@extends('master::layouts.master')

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-header text-primary custom-bg-gradient-info">
                <h3 class="card-title font-weight-bold">Industry Unit Statistics</h3>

                <div class="card-tools">
                    <div class="btn-group">
                        <a href="{{route('govt_stakeholder::admin.organization-unit-statistics.edit', [$organizationUnitStatistic->id])}}"
                           class="btn btn-sm btn-outline-primary btn-rounded">
                            <i class="fas fa-plus-circle"></i> {{ __('Edit Industry Unit Statistics') }}
                        </a>
                        <a href="{{route('govt_stakeholder::admin.organization-unit-statistics.index')}}" class="btn btn-sm btn-outline-primary btn-rounded">
                            <i class="fas fa-backward"></i> {{ __('Back to list') }}
                        </a>
                    </div>
                </div>
            </div>

            <div class="row card-body">

                <div class="col-md-6 custom-view-box">
                    <p class="label-text">{{ __('Industry Unit Name') }}</p>
                    <div class="input-box">
                        {{ $organizationUnitStatistic->organizationUnit->title_en ? $organizationUnitStatistic->organizationUnit->title_en : '' }}
                    </div>
                </div>

                <div class="col-md-6 custom-view-box">
                    <p class="label-text">{{ __('Total Vacancy') }}</p>
                    <div class="input-box">
                        {{ $organizationUnitStatistic->total_vacancy ?? '0' }}
                    </div>
                </div>

                <div class="col-md-6 custom-view-box">
                    <p class="label-text">{{ __('Total Occupied Position') }}</p>
                    <div class="input-box">
                        {{ $organizationUnitStatistic->total_occupied_position ?? '0' }}
                    </div>
                </div>

                <div class="col-md-6 custom-view-box">
                    <p class="label-text">{{ __('Total New Recruits') }}</p>
                    <div class="input-box">
                        {{ $organizationUnitStatistic->total_new_recruits ?? '0' }}

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
