@php
    /** @var \App\Models\User $authUser */
    $authUser = \App\Helpers\Classes\AuthHelper::getAuthUser();
@endphp
@extends('master::layouts.master')

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-header text-primary custom-bg-gradient-info">
                <h3 class="card-title font-weight-bold">Service</h3>

                <div class="card-tools">
                    <div class="btn-group">
                        <a href="{{route('admin.services.edit', [$service->id])}}"
                           class="btn btn-sm btn-outline-primary btn-rounded">
                            <i class="fas fa-plus-circle"></i> {{ __('Edit Skill') }}
                        </a>
                        <a href="{{route('admin.services.index')}}" class="btn btn-sm btn-outline-primary btn-rounded">
                            <i class="fas fa-backward"></i> {{ __('Back to list') }}
                        </a>
                    </div>
                </div>
            </div>

            <div class="row card-body">

                <div class="col-md-6 custom-view-box">
                    <p class="label-text">{{ __('Title(EN)') }}</p>
                    <div class="input-box">
                        {{ $service->title_en ? $service->title_en : '' }}
                    </div>
                </div>

                <div class="col-md-6 custom-view-box">
                    <p class="label-text">{{ __('Title(BN)') }}</p>
                    <div class="input-box">
                        {{ $service->title_bn ? $service->title_bn : '' }}
                    </div>
                </div>

                <div class="col-md-6  custom-view-box">
                    <p class="label-text">{{ __('Organization Name') }}</p>
                    <div class="input-box">
                        {{$service->organization_id ? $service->organization->title_en : ''}}
                    </div>
                </div>



            </div>
        </div>
    </div>
@endsection
