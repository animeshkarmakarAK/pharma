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
                        <a href="{{route('govt_stakeholder::admin.upazila-job-statistics.edit', [$upazilaJobStatistic->id])}}"
                           class="btn btn-sm btn-outline-primary btn-rounded">
                            <i class="fas fa-plus-circle"></i> {{ __('Edit Job Sector') }}
                        </a>
                        <a href="{{route('govt_stakeholder::admin.upazila-job-statistics.index')}}" class="btn btn-sm btn-outline-primary btn-rounded">
                            <i class="fas fa-backward"></i> {{ __('Back to list') }}
                        </a>
                    </div>
                </div>
            </div>

            <div class="row card-body">

                <div class="col-md-6 custom-view-box">
                    <p class="label-text">{{ __('Upazila') }}</p>
                    <div class="input-box">
                        {{ $upazilaJobStatistic->LocUpazila->title_en ? $upazilaJobStatistic->LocUpazila->title_en : '' }}
                    </div>
                </div>

                <div class="col-md-6 custom-view-box">
                    <p class="label-text">{{ __('Job Sector') }}</p>
                    <div class="input-box">
                        {{ $upazilaJobStatistic->jobSector->title_en ? $upazilaJobStatistic->jobSector->title_en : '' }}
                    </div>
                </div>

                <div class="col-md-6 custom-view-box">
                    <p class="label-text">{{ __('Total Unemployed') }}</p>
                    <div class="input-box">
                        {{ $upazilaJobStatistic->total_unemployed ? $upazilaJobStatistic->total_unemployed : '' }}
                    </div>
                </div>
                <div class="col-md-6 custom-view-box">
                    <p class="label-text">{{ __('Total Employed') }}</p>
                    <div class="input-box">
                        {{ $upazilaJobStatistic->total_employed ? $upazilaJobStatistic->total_employed : '' }}
                    </div>
                </div>
                <div class="col-md-6 custom-view-box">
                    <p class="label-text">{{ __('Total Vacancy') }}</p>
                    <div class="input-box">
                        {{ $upazilaJobStatistic->total_vacancy ? $upazilaJobStatistic->total_vacancy : '' }}
                    </div>
                </div>
                <div class="col-md-6 custom-view-box">
                    <p class="label-text">{{ __('Total New Recruitment') }}</p>
                    <div class="input-box">
                        {{ $upazilaJobStatistic->total_new_recruitment ? $upazilaJobStatistic->total_new_recruitment : '' }}
                    </div>
                </div>
                <div class="col-md-6 custom-view-box">
                    <p class="label-text">{{ __('Total New Skilled Youth') }}</p>
                    <div class="input-box">
                        {{ $upazilaJobStatistic->total_new_skilled_youth ? $upazilaJobStatistic->total_new_skilled_youth : '' }}
                    </div>
                </div>
                <div class="col-md-6 custom-view-box">
                    <p class="label-text">{{ __('Total Skilled Youth') }}</p>
                    <div class="input-box">
                        {{ $upazilaJobStatistic->total_skilled_youth ? $upazilaJobStatistic->total_skilled_youth : '' }}
                    </div>
                </div>
                <div class="col-md-6 custom-view-box">
                    <p class="label-text">{{ __('Survey Date') }}</p>
                    <div class="input-box">
                        {{ $upazilaJobStatistic->survey_date ? \Carbon\Carbon::parse($upazilaJobStatistic->survey_date)->format('d M, Y') : '' }}
                    </div>
                </div>
                <div class="col-md-6 custom-view-box">
                    <p class="label-text">{{ __('Status') }}</p>
                    <div class="input-box">
                        {{ $upazilaJobStatistic->row_status ? 'Active' : 'Inactive' }}
                    </div>
                </div>






            </div>
        </div>
    </div>
@endsection
