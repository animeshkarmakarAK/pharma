@extends('master::layouts.master')

@section('title')
    {{ __('course_management::admin.institute.index') }}
@endsection

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-header text-primary custom-bg-gradient-info">
                <h3 class="card-title font-weight-bold">{{ __('course_management::admin.institute.index') }}</h3>

                <div class="card-tools">
                    <div class="btn-group">
                        @can('update', $institute)
                            <a href="{{route('course_management::admin.institutes.edit', [$institute->id])}}"
                               class="btn btn-sm btn-outline-primary btn-rounded">
                                <i class="fas fa-plus-circle"></i>{{ __('course_management::admin.institute.edit') }}
                            </a>
                        @endcan
                        @can('viewAny', $institute)
                            <a href="{{route('course_management::admin.institutes.index')}}"
                               class="btn btn-sm btn-outline-primary btn-rounded">
                                <i class="fas fa-backward"></i> {{__('course_management::admin.common.back')}}
                            </a>
                        @endcan
                    </div>
                </div>

            </div>
            <div class="row card-body">
                <div class="col-md-6 custom-view-box">
                    <p class="label-text">{{ __('course_management::admin.institute.index') }}</p>
                    <div class="input-box">
                        {{ $institute->title_en }}
                    </div>
                </div>

                <div class="col-md-6 custom-view-box">
                    <p class="label-text">{{ __('course_management::admin.institute.code') }}</p>
                    <div class="input-box">
                        {{ $institute->code }}
                    </div>
                </div>


                <div class="col-md-6 custom-view-box">
                    <p class="label-text">{{ __('course_management::admin.institute.domain') }}</p>
                    <div class="input-box">
                        {{ $institute->domain }}
                    </div>
                </div>

                <div class="col-md-6 mt-2 custom-view-box">
                    <p class="label-text">{{ __('course_management::admin.institute.primary_phone') }}</p>
                    <div class="input-box">
                        {{ $institute->primary_phone }}
                    </div>
                </div>

                @if(!empty($institute->phone_numbers))
                    <div class="col-md-6 mt-2 custom-view-box">
                        <?php $sl = 0; ?>
                        @foreach($institute->phone_numbers as $phone)
                            <p class="label-text">{{ __('course_management::admin.institute.phone') }} # {{ ++$sl }}</p>
                            <div class="input-box">
                                {{ $phone }}
                            </div>
                        @endforeach
                    </div>
                @endif

                <div class="col-md-6 mt-2 custom-view-box">
                    <p class="label-text">{{ __('course_management::admin.institute.primary_mobile') }}</p>
                    <div class="input-box">
                        {{ $institute->primary_mobile }}
                    </div>
                </div>

                @if(!empty($institute->mobile_numbers))
                    <div class="col-md-6 mt-2 custom-view-box">
                        <?php $sl = 0; ?>
                        @foreach($institute->mobile_numbers as $mobile)
                            <p class="label-text">{{ __('course_management::admin.institute.mobile') }} # {{ ++$sl }}</p>
                            <div class="input-box">
                                {{ $mobile }}
                            </div>
                        @endforeach
                    </div>
                @endif

                <div class="col-md-6 custom-view-box">
                    <p class="label-text">{{ __('course_management::admin.institute.email') }}</p>
                    <div class="input-box">
                        {{ !empty($institute->email)? $institute->email: '' }}
                    </div>
                </div>

                <div class="col-md-6 custom-view-box">
                    <p class="label-text">{{ __('course_management::admin.institute.address') }}</p>
                    <div class="input-box">
                        {{ $institute->address }}
                    </div>
                </div>

                <div class="col-md-6 custom-view-box">
                    <p class="label-text">{{ __('course_management::admin.institute.google_map_src') }}</p>
                    <div class="input-box" style="min-height: 100px;">
                        {{ $institute->google_map_src }}
                    </div>
                </div>

                <div class="col-md-6 custom-view-box">
                    <p class="label-text">{{ __('course_management::admin.institute.description') }}</p>
                    <div class="input-box">
                        {{ !empty($institute->description)? $institute->description: '' }}
                    </div>
                </div>

                <div class="col-md-6 mt-2 custom-view-box">
                    <p class="label-text">{{ __('course_management::admin.institute.logo') }}</p>
                    <div class="input-box">
                        <img src="{{ asset("storage/{$institute->logo}") }}" alt="" title="" height="50px"/>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
