@php
    /** @var \App\Models\User $authUser */
    $authUser = \App\Helpers\Classes\AuthHelper::getAuthUser();
@endphp
@extends('master::layouts.master')

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-header text-primary custom-bg-gradient-info">
                <h3 class="card-title font-weight-bold">Rank</h3>

                <div class="card-tools">
                    <div class="btn-group">
                        <a href="{{route('govt_stakeholder::admin.ranks.edit', [$rank->id])}}"
                           class="btn btn-sm btn-outline-primary btn-rounded">
                            <i class="fas fa-plus-circle"></i> {{ __('Edit Rank') }}
                        </a>
                        <a href="{{route('govt_stakeholder::admin.ranks.index')}}" class="btn btn-sm btn-outline-primary btn-rounded">
                            <i class="fas fa-backward"></i> {{ __('Back to list') }}
                        </a>
                    </div>
                </div>
            </div>

            <div class="row card-body">

                <div class="col-md-6 custom-view-box">
                    <p class="label-text">{{ __('Title(EN)') }}</p>
                    <div class="input-box">
                        {{$rank->title_en ? $rank->title_en: ''}}
                    </div>
                </div>

                <div class="col-md-6 custom-view-box">
                    <p class="label-text">{{ __('Title(BN)') }}</p>
                    <div class="input-box">
                        {{$rank->title_bn ? $rank->title_bn : ''}}
                    </div>
                </div>

                <div class="col-md-6  custom-view-box">
                    <p class="label-text">{{ __('Rank Type') }}</p>
                    <div class="input-box">
                        {{$rank->rank_type_id ? $rank->rankType->title_en: ''}}
                    </div>
                </div>

                <div class="col-md-6  custom-view-box">
                    <p class="label-text">{{ __('Organization Name') }}</p>
                    <div class="input-box">
                        {{$rank->organization_id ? $rank->organization->title_en: ''}}
                    </div>
                </div>

                <div class="col-md-6  custom-view-box">
                    <p class="label-text">{{ __('Grade') }}</p>
                    <div class="input-box">
                        {{$rank->grade ? $rank->grade: ''}}
                    </div>
                </div>

                <div class="col-md-6  custom-view-box">
                    <p class="label-text">{{ __('Order') }}</p>
                    <div class="input-box">
                        {{$rank->order ? $rank->order: '0'}}
                    </div>
                </div>


            </div>
        </div>
    </div>
@endsection
