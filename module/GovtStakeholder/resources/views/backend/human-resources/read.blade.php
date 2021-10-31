@extends('master::layouts.master')

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-header text-primary custom-bg-gradient-info">
                <h3 class="card-title font-weight-bold">Human Resource</h3>

                <div class="card-tools">
                    <div class="btn-group">
                        @can('update', $humanResource )
                            <a href="{{route('govt_stakeholder::admin.human-resources.edit', $humanResource)}}"
                               class="btn btn-sm btn-outline-primary btn-rounded">
                                <i class="fas fa-plus-circle"></i> {{ __('Edit Human Resource') }}
                            </a>
                        @endcan
                        @can('viewAny', $humanResource)
                            <a href="{{route('govt_stakeholder::admin.human-resources.index')}}"
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
                        {{ $humanResource->title_en }}
                    </div>
                </div>

                <div class="col-md-6 custom-view-box">
                    <p class="label-text">{{ __('Title(BN)') }}</p>
                    <div class="input-box">
                        {{ $humanResource->title_bn }}
                    </div>
                </div>

                <div class="col-md-6 custom-view-box">
                    <p class="label-text">{{ __('Template Name') }}</p>
                    <div class="input-box">
                        {{ optional($humanResource->humanResourceTemplate)->title_en }}
                    </div>
                </div>

                <div class="col-md-6 custom-view-box">
                    <p class="label-text">{{ __('Industry Name') }}</p>
                    <div class="input-box">
                        {{ optional($humanResource->organization)->title_en }}
                    </div>
                </div>

                <div class="col-md-6 custom-view-box">
                    <p class="label-text">{{ __('Industry Unit Name') }}</p>
                    <div class="input-box">
                        {{ optional($humanResource->organizationUnit)->title_en }}
                    </div>
                </div>

                <div class="col-md-6 custom-view-box">
                    <p class="label-text">{{ __('Parent') }}</p>
                    <div class="input-box">
                        {{ optional($humanResource->parent)->title_en ?? 'N/A' }}
                    </div>
                </div>

                <div class="col-md-6 custom-view-box">
                    <p class="label-text">{{ __('Rank') }}</p>
                    <div class="input-box">
                        {{ optional($humanResource->rank)->title_en ?? 'N/A'}}
                    </div>
                </div>

                <div class="col-md-6 custom-view-box">
                    <p class="label-text">{{ __('Display Order') }}</p>
                    <div class="input-box">
                        {{ $humanResource->display_order }}
                    </div>
                </div>

                <div class="col-md-6 custom-view-box">
                    <p class="label-text">{{ __('Is a Designation') }}</p>
                    <div class="input-box">
                        {{ $humanResource->is_designation }}
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
