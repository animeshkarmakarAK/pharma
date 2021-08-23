@extends('master::layouts.master')

@section('title')
    {{ __('Application Form Type') }}
@endsection

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-header d-flex justify-content-between custom-bg-gradient-info">
                <h3 class="card-title font-weight-bold text-primary">{{ __('Application Form Type') }}</h3>

                <div class="card-tools">
                    <div class="btn-group">
                        <a href="{{route('course_management::admin.application-form-types.edit', [$applicationFormType->id])}}" class="btn btn-sm btn-outline-primary btn-rounded">
                            <i class="fas fa-plus-circle"></i> {{ __('Edit Application Form Type') }}
                        </a>
                        <a href="{{route('course_management::admin.application-form-types.index')}}" class="btn btn-sm btn-outline-primary btn-rounded">
                            <i class="fas fa-backward"></i> {{ __('Back to list') }}
                        </a>
                    </div>
                </div>
            </div>
            <div class="row card-body">

                <div class="col-md-6 custom-view-box">
                    <p class="label-text">{{ __('Title(EN)') }}</p>
                    <div class="input-box">
                        {{ $applicationFormType->title_en }}
                    </div>
                </div>

                <div class="col-md-6 custom-view-box">
                    <p class="label-text">{{ __('Title(BN)') }}</p>
                    <div class="input-box">
                        {{ $applicationFormType->title_bn }}
                    </div>
                </div>

                <div class="col-md-6 custom-view-box">
                    <p class="label-text">{{ __('Institute') }}</p>
                    <div class="input-box">
                        {{ $applicationFormType->institute->title_en }}
                    </div>
                </div>
                <div class="col-md-6 custom-view-box">
                    <p class="label-text">SSC Exam Field Show</p>
                    <div class="input-box">
                        {{$applicationFormType->ssc=='1'?'Yes':'No' }}
                    </div>
                </div>
                <div class="col-md-6 custom-view-box">
                    <p class="label-text">HSC Exam Field Show</p>
                    <div class="input-box">
                        {{$applicationFormType->hsc=='1'?'Yes':'No' }}
                    </div>
                </div>
                <div class="col-md-6 custom-view-box">
                    <p class="label-text">Honors Exam Field Show</p>
                    <div class="input-box">
                        {{$applicationFormType->honors=='1'?'Yes':'No' }}
                    </div>
                </div>
                <div class="col-md-6 custom-view-box">
                    <p class="label-text">Masters Exam Field Show</p>
                    <div class="input-box">
                        {{$applicationFormType->masters=='1'?'Yes':'No' }}
                    </div>
                </div>

                <div class="col-md-6 custom-view-box">
                    <p class="label-text">Physical Disability Field Show</p>
                    <div class="input-box">
                        {{$applicationFormType->disable_status=='1'?'Yes':'No' }}
                    </div>
                </div>

                <div class="col-md-6 custom-view-box">
                    <p class="label-text">Occupation Information Field</p>
                    <div class="input-box">
                        {{$applicationFormType->occupation=='1'?'Yes':'No' }}
                    </div>
                </div>

                <div class="col-md-6 custom-view-box">
                    <p class="label-text">Ethnic Group Field Show</p>
                    <div class="input-box">
                        {{$applicationFormType->ethnic=='1'?'Yes':'No' }}
                    </div>
                </div>
                <div class="col-md-6 custom-view-box">
                    <p class="label-text">Freedom Fighter Field Show</p>
                    <div class="input-box">
                        {{$applicationFormType->freedom_fighter=='1'?'Yes':'No' }}
                    </div>
                </div>

                <div class="col-md-6 custom-view-box">
                    <p class="label-text">Guardian Information Field</p>
                    <div class="input-box">
                        {{$applicationFormType->guardian=='1'?'Yes':'No' }}
                    </div>
                </div>


            </div>
        </div>
    </div>
@endsection
