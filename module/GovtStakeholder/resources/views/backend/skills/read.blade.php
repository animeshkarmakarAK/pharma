@php
    /** @var \App\Models\User $authUser */
    $authUser = \App\Helpers\Classes\AuthHelper::getAuthUser();
@endphp
@extends('master::layouts.master')

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-header text-primary custom-bg-gradient-info">
                <h3 class="card-title font-weight-bold">Skill</h3>

                <div class="card-tools">
                    <div class="btn-group">
                        <a href="{{route('govt_stakeholder::admin.skills.edit', [$skill->id])}}"
                           class="btn btn-sm btn-outline-primary btn-rounded">
                            <i class="fas fa-plus-circle"></i> {{ __('Edit Skill') }}
                        </a>
                        <a href="{{route('govt_stakeholder::admin.skills.index')}}" class="btn btn-sm btn-outline-primary btn-rounded">
                            <i class="fas fa-backward"></i> {{ __('Back to list') }}
                        </a>
                    </div>
                </div>
            </div>

            <div class="row card-body">

                <div class="col-md-6 custom-view-box">
                    <p class="label-text">{{ __('Title(EN)') }}</p>
                    <div class="input-box">
                        {{ $skill->title_en ? $skill->title_en : '' }}
                    </div>
                </div>

                <div class="col-md-6 custom-view-box">
                    <p class="label-text">{{ __('Title(BN)') }}</p>
                    <div class="input-box">
                        {{ $skill->title_bn ? $skill->title_bn : '' }}
                    </div>
                </div>

                <div class="col-md-6  custom-view-box">
                    <p class="label-text">{{ __('Industry Name') }}</p>
                    <div class="input-box">
                        {{$skill->organization_id ? $skill->organization->title_en : ''}}
                    </div>
                </div>

                <div class="col-md-6  custom-view-box">
                    <p class="label-text">{{ __('Description') }}</p>
                    <div class="input-box" style="min-height: 100px">
                        {{$skill->description? $skill->description:''}}
                    </div>
                </div>


            </div>
        </div>
    </div>
@endsection
