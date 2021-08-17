@extends('master::layouts.master')

@section('title')
    {{ __('Slider') }}
@endsection

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-header text-primary custom-bg-gradient-info">
                <h3 class="card-title">Slider</h3>

                <div class="card-tools">
                    <div class="btn-group">
                        <a href="{{route('course_management::admin.sliders.edit', $slider)}}" class="btn btn-sm btn-outline-primary btn-rounded">
                            <i class="fas fa-plus-circle"></i> {{ __('Edit Slider') }}
                        </a>
                        <a href="{{route('course_management::admin.sliders.index')}}" class="btn btn-sm btn-outline-primary btn-rounded">
                            <i class="fas fa-backward"></i> {{ __('Back to list') }}
                        </a>
                    </div>
                </div>

            </div>
            <div class="row card-body">
                <div class="col-md-12">
                    <img src="{{ asset('storage/'.$slider->slider) }}" alt="slider image" height="200" width="100%">
                </div>
                <div class="col-md-6 custom-view-box">
                    <p class="label-text">{{ __('Title(EN)') }}</p>
                    <div class="input-box">
                        {{ $slider->title }}
                    </div>
                </div>

                <div class="col-md-6 custom-view-box">
                    <p class="label-text">{{ __('Sub-title') }}</p>
                    <div class="input-box">
                        {{ $slider->sub_title }}
                    </div>
                </div>

                <div class="col-md-6 custom-view-box">
                    <p class="label-text">{{ __('Link(Page Id)') }}</p>
                    <div class="input-box">
                        {{ $slider->link ?? 'N/A'}}
                    </div>
                </div>

                <div class="col-md-6 custom-view-box">
                    <p class="label-text">{{ __('Button Text') }}</p>
                    <div class="input-box">
                        {{ $slider->button_text ?? "N/A" }}
                    </div>
                </div>


                <div class="col-md-6 custom-view-box">
                    <p class="label-text">{{ __('Active Status') }}</p>
                    <div class="input-box">
                        {{ $slider->row_status == \Module\CourseManagement\App\Models\Slider::ROW_STATUS_ACTIVE ? "Active" : "Inactive" }}
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
