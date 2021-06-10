@extends('core.main')

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-header text-primary custom-bg-gradient-info">
                <h3 class="card-title font-weight-bold">Human Resource Template</h3>

                <div class="card-tools">
                    <div class="btn-group">
                        @can('update', $humanResourceTemplate )
                            <a href="{{route('admin.human-resource-templates.edit', $humanResourceTemplate)}}"
                               class="btn btn-sm btn-outline-primary btn-rounded">
                                <i class="fas fa-plus-circle"></i> {{ __('Edit Human Resource Template') }}
                            </a>
                        @endcan
                        @can('viewAny', $humanResourceTemplate)
                            <a href="{{route('admin.human-resource-templates.index')}}"
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
                        {{ $humanResourceTemplate->title_en }}
                    </div>
                </div>

                <div class="col-md-6 custom-view-box">
                    <p class="label-text">{{ __('Title(BN)') }}</p>
                    <div class="input-box">
                        {{ $humanResourceTemplate->title_bn }}
                    </div>
                </div>

                <div class="col-md-6 custom-view-box">
                    <p class="label-text">{{ __('Organization Title') }}</p>
                    <div class="input-box">
                        {{ optional($humanResourceTemplate->organization)->title_en }}
                    </div>
                </div>

                <div class="col-md-6 custom-view-box">
                    <p class="label-text">{{ __('Organization Unit Type') }}</p>
                    <div class="input-box">
                        {{ optional($humanResourceTemplate->organizationUnitType)->title_en }}
                    </div>
                </div>

                <div class="col-md-6 custom-view-box">
                    <p class="label-text">{{ __('Parent') }}</p>
                    <div class="input-box">
                        {{ optional($humanResourceTemplate->parent)->title_en }}
                    </div>
                </div>

                <div class="col-md-6 custom-view-box">
                    <p class="label-text">{{ __('Rank') }}</p>
                    <div class="input-box">
                        {{ optional($humanResourceTemplate->rank)->title_en }}
                    </div>
                </div>

                <div class="col-md-6 custom-view-box">
                    <p class="label-text">{{ __('Display Order') }}</p>
                    <div class="input-box">
                        {{ $humanResourceTemplate->display_order }}
                    </div>
                </div>

                <div class="col-md-6 custom-view-box">
                    <p class="label-text">{{ __('Is a Designation') }}</p>
                    <div class="input-box">
                        {{ $humanResourceTemplate->is_designation }}
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
