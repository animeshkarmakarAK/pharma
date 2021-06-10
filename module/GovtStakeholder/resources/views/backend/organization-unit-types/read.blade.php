@extends('core.main')

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-header text-primary custom-bg-gradient-info">
                <h3 class="card-title font-weight-bold">Organization Unit Type</h3>

                <div class="card-tools">
                    <div class="btn-group">
                        @can('update', $organizationUnitType )
                            <a href="{{route('admin.organization-unit-types.edit', $organizationUnitType)}}"
                               class="btn btn-sm btn-outline-primary btn-rounded">
                                <i class="fas fa-plus-circle"></i> {{ __('Edit Organization Unit type') }}
                            </a>
                        @endcan
                        @can('viewAny', $organizationUnitType)
                            <a href="{{route('admin.organization-unit-types.index')}}"
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
                        {{ $organizationUnitType->title_en }}
                    </div>
                </div>

                <div class="col-md-6 custom-view-box">
                    <p class="label-text">{{ __('Title(BN)') }}</p>
                    <div class="input-box">
                        {{ $organizationUnitType->title_bn }}
                    </div>
                </div>

                <div class="col-md-6 custom-view-box">
                    <p class="label-text">{{ __('Active Status') }}</p>
                    <div class="input-box">
                        {!! $organizationUnitType->getCurrentRowStatus(true) !!}
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
