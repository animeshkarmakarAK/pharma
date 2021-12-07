@extends('master::layouts.master')

@section('title')
    {{ __('Application Form Type') }}
@endsection

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-header d-flex justify-content-between custom-bg-gradient-info">
                <h3 class="card-title font-weight-bold text-primary">{{__('course_management::admin.application_form_type.index')}}</h3>

                <div class="card-tools">
                    <div class="btn-group">
                        <a href="{{route('course_management::admin.application-form-types.edit', [$applicationFormType->id])}}" class="btn btn-sm btn-outline-primary btn-rounded">
                            <i class="fas fa-plus-circle"></i> {{__('course_management::admin.common.edit')}}
                        </a>
                        <a href="{{route('course_management::admin.application-form-types.index')}}" class="btn btn-sm btn-outline-primary btn-rounded">
                            <i class="fas fa-backward"></i> {{__('course_management::admin.common.back')}}
                        </a>
                    </div>
                </div>
            </div>
            <div class="row card-body">

                <div class="col-md-6 custom-view-box">
                    <p class="label-text"> {{__('course_management::admin.application_form_type.title')}}</p>
                    <div class="input-box">
                        {{ $applicationFormType->title_en }}
                    </div>
                </div>
                <div class="col-md-6 custom-view-box">
                    <p class="label-text"> {{__('course_management::admin.application_form_type.institute_name')}}</p>
                    <div class="input-box">
                        {{ $applicationFormType->institute->title_en }}
                    </div>
                </div>
                <div class="col-md-6 custom-view-box">
                    <p class="label-text"> {{__('course_management::admin.application_form_type.jsc_exam')}}</p>
                    <div class="input-box">
                        {{$applicationFormType->jsc=='1'?'Yes':'No' }}
                    </div>
                </div>
                <div class="col-md-6 custom-view-box">
                    <p class="label-text"> {{__('course_management::admin.application_form_type.ssc_exam')}}</p>
                    <div class="input-box">
                        {{$applicationFormType->ssc=='1'?'Yes':'No' }}
                    </div>
                </div>
                <div class="col-md-6 custom-view-box">
                    <p class="label-text"> {{__('course_management::admin.application_form_type.hsc_exam')}}</p>
                    <div class="input-box">
                        {{$applicationFormType->hsc=='1'?'Yes':'No' }}
                    </div>
                </div>
                <div class="col-md-6 custom-view-box">
                    <p class="label-text"> {{__('course_management::admin.application_form_type.honors_exam')}}</p>
                    <div class="input-box">
                        {{$applicationFormType->honors=='1'?'Yes':'No' }}
                    </div>
                </div>
                <div class="col-md-6 custom-view-box">
                    <p class="label-text"> {{__('course_management::admin.application_form_type.masters_exam')}}</p>
                    <div class="input-box">
                        {{$applicationFormType->masters=='1'?'Yes':'No' }}
                    </div>
                </div>

                <div class="col-md-6 custom-view-box">
                    <p class="label-text"> {{__('course_management::admin.application_form_type.physical_disability')}}</p>
                    <div class="input-box">
                        {{$applicationFormType->disable_status=='1'?'Yes':'No' }}
                    </div>
                </div>

                <div class="col-md-6 custom-view-box">
                    <p class="label-text"> {{__('course_management::admin.application_form_type.other_information_show')}}</p>
                    <div class="input-box">
                        {{$applicationFormType->occupation=='1'?'Yes':'No' }}
                    </div>
                </div>

                <div class="col-md-6 custom-view-box">
                    <p class="label-text">{{__('course_management::admin.application_form_type.ethnic_group')}}</p>
                    <div class="input-box">
                        {{$applicationFormType->ethnic=='1'?'Yes':'No' }}
                    </div>
                </div>
                <div class="col-md-6 custom-view-box">
                    <p class="label-text">{{__('course_management::admin.application_form_type.freedom_fighter')}}</p>
                    <div class="input-box">
                        {{$applicationFormType->freedom_fighter=='1'?'Yes':'No' }}
                    </div>
                </div>

                <div class="col-md-6 custom-view-box">
                    <p class="label-text">{{__('course_management::admin.application_form_type.guardian')}}</p>
                    <div class="input-box">
                        {{$applicationFormType->guardian=='1'?'Yes':'No' }}
                    </div>
                </div>


            </div>
        </div>
    </div>
@endsection
