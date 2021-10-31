@extends('master::layouts.master')


@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-4">
                <div class="user-details card mb-3">
                    <div
                        class="card-header custom-bg-gradient-info font-weight-bold text-primary">{{ 'Industry\'s Logo' }}</div>
                        <div class="col-md-12 custom-view-box text-center mt-3">

                            <div class="card-header d-flex justify-content-between custom-bg-gradient-info">
                                <img src="{{asset('storage/' .$organization->logo)}}" class="img-fluid"
                                     alt="Industry Logo" style="height: 300px; width: 100%">
                            </div>
                            <p class="label-text">{{ __('Logo') }}</p>

                        </div>

                </div>

            </div>
            <div class="col-md-8">

                <div class="card">
                    <div class="card-header text-primary custom-bg-gradient-info">
                        <h3 class="card-title">{{ __('Industry') }}</h3>
                        <div class="card-tools">
                            <div class="btn-group">
                                <a href="{{route('govt_stakeholder::admin.organizations.edit', [$organization->id])}}"
                                   class="btn btn-sm btn-outline-primary btn-rounded">
                                    <i class="fas fa-plus-circle"></i> {{ __('Edit Industry') }}
                                </a>
                                <a href="{{route('govt_stakeholder::admin.organizations.index')}}"
                                   class="btn btn-sm btn-outline-primary btn-rounded">
                                    <i class="fas fa-backward"></i> Back to list
                                </a>
                            </div>
                        </div>

                    </div>
                    <div class="row card-body">
                        <div class="col-md-6 custom-view-box">
                            <p class="label-text">{{ __('Title (English)') }}</p>
                            <div class="input-box">
                                {{ $organization->title_en }}
                            </div>
                        </div>

                        <div class="col-md-6 custom-view-box">
                            <p class="label-text">{{ __('Title (Bangla)') }}</p>
                            <div class="input-box">
                                {{ $organization->title_bn }}
                            </div>
                        </div>

                        <div class="col-md-6 custom-view-box">
                            <p class="label-text">{{ __('Domain') }}</p>
                            <div class="input-box">
                                {{ $organization->domain }}
                            </div>
                        </div>
                        <div class="col-md-6 custom-view-box">
                            <p class="label-text">{{ __('Fax') }}</p>
                            <div class="input-box">
                                {{ $organization->fax_no }}
                            </div>
                        </div>
                        <div class="col-md-6 custom-view-box">
                            <p class="label-text">{{ __('Email') }}</p>
                            <div class="input-box">
                                {{ $organization->email }}
                            </div>
                        </div>
                        <div class="col-md-6 custom-view-box">
                            <p class="label-text">{{ __('Mobile') }}</p>
                            <div class="input-box">
                                {{ $organization->mobile }}
                            </div>
                        </div>
                        <div class="col-md-6 custom-view-box">
                            <p class="label-text">{{ __('Industry Type') }}</p>
                            <div class="input-box">
                                {{ $organization->organizationType->title_en }}
                            </div>
                        </div>
                        <div class="col-md-6 custom-view-box">
                            <p class="label-text">{{ __('Contact Person Name') }}</p>
                            <div class="input-box">
                                {{ $organization->contact_person_name }}
                            </div>
                        </div>
                        <div class="col-md-6 custom-view-box">
                            <p class="label-text">{{ __('Contact Person Mobile') }}</p>
                            <div class="input-box">
                                {{ $organization->contact_person_mobile }}
                            </div>
                        </div>
                        <div class="col-md-6 custom-view-box">
                            <p class="label-text">{{ __('Contact Person Email') }}</p>
                            <div class="input-box">
                                {{ $organization->contact_person_email }}
                            </div>
                        </div>
                        <div class="col-md-6 custom-view-box">
                            <p class="label-text">{{ __('Contact Person Designation') }}</p>
                            <div class="input-box">
                                {{ $organization->contact_person_designation }}
                            </div>
                        </div>
                        <div class="col-md-6 custom-view-box">
                            <p class="label-text">{{ __('Address') }}</p>
                            <div class="input-box">
                                {{ $organization->address }}
                            </div>
                        </div>
                        <div class="col-md-6 custom-view-box">
                            <p class="label-text">{{ __('Description') }}</p>
                            <div class="input-box">
                                {{ $organization->description }}
                            </div>
                        </div>

                    </div>
                </div>

            </div>

        </div>

    </div>
@endsection
