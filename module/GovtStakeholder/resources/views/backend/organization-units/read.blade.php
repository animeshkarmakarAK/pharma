@extends('core.main')

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-header text-primary custom-bg-gradient-info">
                <h3 class="card-title font-weight-bold">Organization Unit</h3>

                <div class="card-tools">
                    <div class="btn-group">
                        @can('update', $organizationUnit)
                            <a href="{{route('admin.organization-units.edit', [$organizationUnit->id])}}"
                               class="btn btn-sm btn-outline-primary btn-rounded">
                                <i class="fas fa-plus-circle"></i> {{ __('Edit Organization Unit') }}
                            </a>
                        @endcan
                        @can('viewAny', $organizationUnit)
                            <a href="{{route('admin.organization-units.index')}}"
                               class="btn btn-sm btn-outline-primary btn-rounded">
                                <i class="fas fa-backward"></i> {{ __('Back to list') }}
                            </a>
                        @endcan
                    </div>
                </div>

            </div>
            <div class="row card-body">
                <div class="col-md-6 custom-view-box">
                    <p class="label-text">{{ __('Title(EN)') }}</p>
                    <div class="input-box">
                        {{ $organizationUnit->title_en }}
                    </div>
                </div>

                <div class="col-md-6 custom-view-box">
                    <p class="label-text">{{ __('Title(BN)') }}</p>
                    <div class="input-box">
                        {{ $organizationUnit->title_bn }}
                    </div>
                </div>

                <div class="col-md-6 custom-view-box">
                    <p class="label-text">{{ __('Organization Name') }}</p>
                    <div class="input-box">
                        {{ optional($organizationUnit->organization)->title_en }}
                    </div>
                </div>

                <div class="col-md-6 custom-view-box">
                    <p class="label-text">{{ __('Organization Unit Type') }}</p>
                    <div class="input-box">
                        {{ optional($organizationUnit->organizationUnitType)->title_en }}
                    </div>
                </div>

                <div class="col-md-6 custom-view-box">
                    <p class="label-text">{{ __('Division') }}</p>
                    <div class="input-box">
                        {{ optional($organizationUnit->division)->title_en ?? 'N/A' }}
                    </div>
                </div>

                <div class="col-md-6 custom-view-box">
                    <p class="label-text">{{ __('Division') }}</p>
                    <div class="input-box">
                        {{ optional($organizationUnit->district)->title_en ?? 'N/A'}}
                    </div>
                </div>

                <div class="col-md-6 custom-view-box">
                    <p class="label-text">{{ __('Upazila') }}</p>
                    <div class="input-box">
                        {{ optional($organizationUnit->upazila)->title_en ?? 'N/A' }}
                    </div>
                </div>

                <div class="col-md-6 custom-view-box">
                    <p class="label-text">{{ __('Address') }}</p>
                    <div class="input-box">
                        {{ $organizationUnit->address ?? 'N/A'}}
                    </div>
                </div>

                <div class="col-md-6 custom-view-box">
                    <p class="label-text">{{ __('Mobile') }}</p>
                    <div class="input-box">
                        {{ $organizationUnit->mobile ?? 'N/A'}}
                    </div>
                </div>

                <div class="col-md-6 custom-view-box">
                    <p class="label-text">{{ __('Email') }}</p>
                    <div class="input-box">
                        {{ $organizationUnit->email ?? 'N/A'}}
                    </div>
                </div>

                <div class="col-md-6 custom-view-box">
                    <p class="label-text">{{ __('Fax Number') }}</p>
                    <div class="input-box">
                        {{ $organizationUnit->fax_no ?? 'N/A'}}
                    </div>
                </div>

                <div class="col-md-6 custom-view-box">
                    <p class="label-text">{{ __('Contact Person Name') }}</p>
                    <div class="input-box">
                        {{ $organizationUnit->contact_person_name ?? 'N/A' }}
                    </div>
                </div>

                <div class="col-md-6 custom-view-box">
                    <p class="label-text">{{ __('Contact Person Mobile') }}</p>
                    <div class="input-box">
                        {{ $organizationUnit->contact_person_mobile ?? 'N/A' }}
                    </div>
                </div>

                <div class="col-md-6 custom-view-box">
                    <p class="label-text">{{ __('Contact Person Email') }}</p>
                    <div class="input-box">
                        {{ $organizationUnit->contact_person_email ?? 'N/A' }}
                    </div>
                </div>

                <div class="col-md-6 custom-view-box">
                    <p class="label-text">{{ __('Contact Person Designation') }}</p>
                    <div class="input-box">
                        {{ $organizationUnit->contact_person_designation ?? 'N/A' }}
                    </div>
                </div>

                <div class="col-md-6 custom-view-box">
                    <p class="label-text">{{ __('Employee Size') }}</p>
                    <div class="input-box">
                        {{ $organizationUnit->employee_size ?? 'N/A' }}
                    </div>
                </div>

                <div class="col-md-6 custom-view-box">
                    <p class="label-text">{{ __('Active Status') }}</p>
                    <div class="input-box">
                        {!! $organizationUnit->getCurrentRowStatus(true)  !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
