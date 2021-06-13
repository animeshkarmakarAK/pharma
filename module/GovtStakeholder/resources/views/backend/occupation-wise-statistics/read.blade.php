@php
    /** @var \App\Models\User $authUser */
    $authUser = \App\Helpers\Classes\AuthHelper::getAuthUser();
@endphp
@extends('master::layouts.master')

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-header text-primary custom-bg-gradient-info">
                <h3 class="card-title font-weight-bold">Occupation Wise Statistic</h3>

                <div class="card-tools">
                    <div class="btn-group">
                        <a href="{{route('admin.occupation-wise-statistics.edit', [$occupationWiseStatistic->id])}}"
                           class="btn btn-sm btn-outline-primary btn-rounded">
                            <i class="fas fa-plus-circle"></i> {{ __('Edit Occupation Wise Statistic') }}
                        </a>
                        <a href="{{route('admin.occupation-wise-statistics.index')}}" class="btn btn-sm btn-outline-primary btn-rounded">
                            <i class="fas fa-backward"></i> {{ __('Back to list') }}
                        </a>
                    </div>
                </div>
            </div>

            <div class="row card-body">

                <div class="col-md-6 custom-view-box">
                    <p class="label-text">{{ __('Institute') }}</p>
                    <div class="input-box">
                        {{ $occupationWiseStatistic->institute->title_en ? $occupationWiseStatistic->institute->title_en : '' }}
                    </div>
                </div>

                <div class="col-md-6 custom-view-box">
                    <p class="label-text">{{ __('Occupation') }}</p>
                    <div class="input-box">
                        {{ $occupationWiseStatistic->occupation->title_en ? $occupationWiseStatistic->occupation->title_en : '' }}
                    </div>
                </div>

                <div class="col-md-6 custom-view-box">
                    <p class="label-text">{{ __('Current Month Skilled Youth') }}</p>
                    <div class="input-box">
                        {{ $occupationWiseStatistic->current_month_skilled_youth ? $occupationWiseStatistic->current_month_skilled_youth : '0' }}
                    </div>
                </div>

                <div class="col-md-6 custom-view-box">
                    <p class="label-text">{{ __('Next Month Skilled Youth') }}</p>
                    <div class="input-box">
                        {{ $occupationWiseStatistic->next_month_skill_youth ? $occupationWiseStatistic->next_month_skill_youth : '0' }}
                    </div>
                </div>

                <div class="col-md-6 custom-view-box">
                    <p class="label-text">{{ __('Status') }}</p>
                    <div class="input-box">
                        {{ $occupationWiseStatistic->row_status ? 'Active' : 'Inactive' }}
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
