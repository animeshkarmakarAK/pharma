@php
    $edit = !empty($examination->id);
    /** @var \App\Models\User $authUser */
    $authUser = \App\Helpers\Classes\AuthHelper::getAuthUser();
@endphp

@extends('master::layouts.master')

@section('title')
    {{ $edit? __('course_management::admin.examination.list')  .' :: '. __('course_management::admin.common.edit') : __('course_management::admin.examination.list')  .' :: '.  __('course_management::admin.common.add')  }}
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header text-primary custom-bg-gradient-info">
                        <h3 class="card-title font-weight-bold">{{ $edit? __('course_management::admin.common.edit'):__('course_management::admin.common.add') }}</h3>
                        <div class="card-tools">
                            <a href="{{route('course_management::admin.examinations.index')}}"
                               class="btn btn-sm btn-outline-primary btn-rounded">
                                <i class="fas fa-backward"></i> {{__('course_management::admin.common.back')}}
                            </a>
                        </div>
        </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <form
                            action="{{$edit ? route('course_management::admin.examinations.update', $examination->id) : route('course_management::admin.examinations.store')}}"
                            method="POST" class="row edit-add-form">
                            @csrf
                            @if($edit)
                                @method('put')
                            @endif

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="total_mark">{{__('course_management::admin.examination.total_mark')}} <span
                                            style="color: red">*</span></label>
                                    <input type="number" class="form-control" id="total_mark"
                                           name="total_mark"
                                           value="{{ $edit ? $examination->total_mark : old('total_mark') }}"
                                           placeholder="{{__('course_management::admin.examination.total_mark')}}">
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="pass_mark">{{__('course_management::admin.examination.pass_mark')}} <span
                                            style="color: red">*</span></label>
                                    <input type="number" class="form-control" id="pass_mark"
                                           name="pass_mark"
                                           value="{{ $edit ? $examination->pass_mark : old('pass_mark') }}"
                                           placeholder="{{__('course_management::admin.examination.pass_mark')}}">
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="examination_type_id">
                                        {{__('course_management::admin.examination.examination_type')}}
                                        <span class="required"></span>
                                    </label>

                                    <select class="form-control select2" id="examination_type_id"
                                            name="examination_type_id" required>
                                        <option value=""
                                                selected>{{__('course_management::admin.common.select')}}</option>
                                        @foreach($examinationTypes as $keyId => $examinationType)
                                            @if ($edit)
                                                <option {{ $edit && $examination->examination_type_id == $keyId ? 'selected' : ''}}
                                                        value="{{ $keyId }}">{{ $examinationType }}</option>
                                            @else
                                                <option {{ old('examination_type_id') == $keyId ? 'selected' : '' }}
                                                        value="{{ $keyId }}">{{ $examinationType }}</option>
                                            @endif

                                        @endforeach
                                    </select>

                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="training_center_id">
                                        {{__('course_management::admin.examination.training_center')}}
                                        <span class="required"></span>
                                    </label>

                                    <select class="form-control select2-ajax-wizard"
                                            name="training_center_id"
                                            id="training_center_id"
                                            data-model="{{base64_encode(Module\CourseManagement\App\Models\TrainingCenter::class)}}"
                                            data-label-fields="{title_en}"
                                            data-dependent-fields="#batch_id"
                                            data-filters="{{json_encode(['institute_id' => $authUser->institute_id])}}"
                                            @if($edit)
                                            data-preselected-option="{{json_encode(['text' =>  $examination->trainingCenter->title_en, 'id' =>  $examination->training_center_id])}}"
                                            @endif
                                            data-placeholder="{{ __('generic.select_placeholder') }}"
                                    >
                                    </select>

                                </div>
                            </div>


                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="batch_id">
                                        {{__('course_management::admin.examination.batch_title')}}
                                        <span class="required"></span>
                                    </label>

                                    <select class="form-control select2-ajax-wizard"
                                            name="batch_id"
                                            id="batch_id"
                                            data-model="{{base64_encode(Module\CourseManagement\App\Models\Batch::class)}}"
                                            data-label-fields="{title_en}"
                                            data-depend-on-optional="training_center_id"
                                            data-filters="{{json_encode(['institute_id' => $authUser->institute_id, 'batch_status'=>1 ])}}"
                                            @if($edit)
                                            data-preselected-option="{{json_encode(['text' =>  $examination->batch->title_en, 'id' =>  $examination->batch_id])}}"
                                            @endif
                                            data-placeholder="{{ __('generic.select_placeholder') }}"
                                    >
                                    </select>

                                </div>
                            </div>


                            {{--<div class="col-lg-6">
                                <div class="form-group">
                                    <label for="training_center_id">
                                        {{__('course_management::admin.examination.training_center')}}
                                        <span class="required"></span>
                                    </label>

                                    <select class="form-control select2-ajax-wizard"
                                            name="training_center_id"
                                            id="training_center_id"
                                            data-model="{{base64_encode(Module\CourseManagement\App\Models\TrainingCenter::class)}}"
                                            data-label-fields="{title_en}"
                                            data-dependent-fields="#batch_id"
                                            @if($edit)
                                            data-preselected-option="{{json_encode(['text' =>  $batch->training_center->title_en, 'id' =>  $batch->training_center->id])}}"
                                            @endif
                                            data-placeholder="{{ __('generic.select_placeholder') }}"
                                    >
                                    </select>

                                </div>
                            </div>--}}

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="exam_details">
                                        {{__('course_management::admin.examination.exam_details')}}
                                        <span class="required"></span>
                                    </label>

                                    <textarea required="required" class="form-control" placeholder="{{__('course_management::admin.examination.exam_details')}}"
                                              name="exam_details" id=""  rows="1">{{ $edit?$examination->exam_details:old('exam_details') }}</textarea>
                                </div>
                            </div>


                            <div class="col-sm-12 text-right">
                                <button type="submit"
                                        class="btn btn-success">{{ $edit ? __('course_management::admin.common.update') : __('course_management::admin.common.add') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('utils.delete-confirm-modal')

@endsection

@push('css')
    <style>
        .has-error{
            position: relative;
            padding: 0px 0 12px 0;
        }
        #training_center_id-error{
            position: absolute;
            left: 6px;
            bottom: -9px;
        }
    </style>
@endpush

@push('js')
    <x-generic-validation-error-toastr></x-generic-validation-error-toastr>

    <script>
        const EDIT = !!'{{$edit}}';

        const editAddForm = $('.edit-add-form');
        editAddForm.validate({
            rules: {
                total_mark: {
                    required: true,
                },

                pass_mark: {
                    required: true,
                },
                exam_details: {
                    required: true,
                },

                examination_type_id: {
                    required: true
                },
                batch_id: {
                    required: true
                },
                training_center_id: {
                    required: true
                },
            },
            messages: {
                title: {
                        pattern: "This field is required in English.",
                },
            },
            submitHandler: function (htmlForm) {
                $('.overlay').show();
                htmlForm.submit();
            }
        });
    </script>
@endpush


