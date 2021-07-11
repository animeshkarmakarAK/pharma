@extends('master::layouts.master')

@section('content')
    <div class="container-fluid">
        <div class="row user-profile">

            <div class="col-md-12">
                <div class="card bg-white">
                    <div class="card-header custom-bg-gradient-info text-primary">
                        <h3 class="card-title font-weight-bold">{{ __('Organization Type') }}</h3>

                        <div class="card-tools">
                            <div class="btn-group">
                                <a href="{{route('govt_stakeholder::admin.organization-types.edit', [$organizationType->id])}}"
                                   class="btn btn-sm btn-outline-primary btn-rounded">
                                    <i class="fas fa-plus-circle"></i> {{ __('Edit Job Sector') }}
                                </a>
                                <a href="{{route('govt_stakeholder::admin.organization-types.index')}}"
                                   class="btn btn-sm btn-outline-primary btn-rounded">
                                    <i class="fas fa-backward"></i> Back to list
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="card-body row">
                        <div class="col-md-6 custom-view-box">
                            <p class="label-text">{{ __('Title(EN)') }}</p>
                            <div class="input-box">
                                {{ $organizationType->title_en ?? "N/A" }}
                            </div>
                        </div>

                        <div class="col-md-6 custom-view-box">
                            <p class="label-text">{{ __('Title(BN)') }}</p>
                            <div class="input-box">
                                {{ $organizationType->title_bn ?? "N/A"}}
                            </div>
                        </div>
                        <div class="col-md-6 custom-view-box">
                            <p class="label-text">{{ __('Is Government') }}</p>
                            <div class="input-box">
                                {{ $organizationType ? 'Government':'Non Government'}}
                            </div>
                        </div>

                        <div class="col-md-6 custom-view-box">
                            <p class="label-text">{{ __('Status') }}</p>
                            <div class="input-box">
                                {!! $organizationType->getCurrentRowStatus(true) !!}

                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


