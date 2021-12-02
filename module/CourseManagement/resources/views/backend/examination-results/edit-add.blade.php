@php
    $edit = !empty($examinationResult->id);
    /** @var \App\Models\User $authUser */
    $authUser = \App\Helpers\Classes\AuthHelper::getAuthUser();
@endphp

@extends('master::layouts.master')

@section('title')
    {{ $edit? __('course_management::admin.examination_result.list')  .' :: '. __('course_management::admin.common.edit') : __('course_management::admin.examination_result.list')  .' :: '.  __('course_management::admin.common.add')  }}
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header text-primary custom-bg-gradient-info">
                        <h3 class="card-title font-weight-bold">{{ $edit? __('course_management::admin.common.edit'):__('course_management::admin.common.add') }}</h3>
                        <div class="card-tools">
                            <a href="{{route('course_management::admin.examination-results.index')}}"
                               class="btn btn-sm btn-outline-primary btn-rounded">
                                <i class="fas fa-backward"></i> {{__('course_management::admin.common.back')}}
                            </a>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <form
                            action="{{$edit ? route('course_management::admin.examination-results.update', $examinationResult->id) : route('course_management::admin.examination-results.store')}}"
                            method="POST" class="row edit-add-form">
                            @csrf
                            @if($edit)
                                @method('put')
                            @endif

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="achieved_marks">{{__('course_management::admin.examination_result.achieved_marks')}} <span
                                            style="color: red">*</span></label>
                                    <input type="number" class="form-control" id="achieved_marks" required
                                           name="achieved_marks"
                                           value="{{ $edit ? $examinationResult->achieved_marks : old('achieved_marks') }}"
                                           placeholder="{{__('course_management::admin.examination_result.achieved_marks')}}">
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="name">{{__('course_management::admin.examination_result.feedback')}} <span
                                            style="color: red">*</span></label>
                                    <input type="text" class="form-control custom-input-box" id="feedback"
                                           name="feedback"
                                           value="{{$edit ? $examinationResult->feedback : old('feedback')}}"
                                           placeholder="{{__('course_management::admin.examination_result.feedback')}}">
                                </div>
                            </div>



                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="examination_id">
                                        {{__('course_management::admin.examination_result.examination')}}
                                        <span class="required"></span>
                                    </label>

                                    <select class="form-control select2 examination_id" id="examination_id"
                                            name="examination_id" required>
                                        <option value=""
                                                selected>{{__('course_management::admin.common.select')}}</option>
                                        @foreach($examinations as $key => $examination)
                                            @if ($edit)
                                                <option {{ $edit && $examinationResult->examination_id == $examination->id ? 'selected' : ''}}
                                                        value="{{ $examination->id }}">{{ $examination->exam_details }}</option>
                                            @else
                                                <option {{ old('examination_id') == $examination->id ? 'selected' : '' }}
                                                        value="{{ $examination->id }}">{{ $examination->exam_details }}</option>
                                            @endif

                                        @endforeach
                                    </select>

                                </div>
                            </div>



                            {{--<div class="col-lg-6">
                                <div class="form-group">
                                    <label for="training_center_id">
                                        {{__('course_management::admin.examination_result.training_center')}}
                                        <span class="required"></span>
                                    </label>

                                    <select class="form-control select2-ajax-wizard"
                                            name="training_center_id" required
                                            id="training_center_id"
                                            data-model="{{base64_encode(Module\CourseManagement\App\Models\TrainingCenter::class)}}"
                                            data-label-fields="{title_en}"
                                            data-dependent-fields="#batch_id"
                                            data-filters="{{json_encode(['institute_id' => $authUser->institute_id])}}"
                                            @if($edit)
                                            data-preselected-option="{{json_encode(['text' =>  $examinationResult->trainingCenter->title_en, 'id' =>  $examinationResult->training_center_id])}}"
                                            @endif
                                            data-placeholder="{{ __('generic.select_placeholder') }}"
                                    >
                                    </select>

                                </div>
                            </div>


                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="batch_id">
                                        {{__('course_management::admin.examination_result.batch_title')}}
                                        <span class="required"></span>
                                    </label>

                                    <select class="form-control select2-ajax-wizard batch_id"
                                            name="batch_id" required
                                            id="batch_id"
                                            data-model="{{base64_encode(Module\CourseManagement\App\Models\Batch::class)}}"
                                            data-label-fields="{title_en}"
                                            data-depend-on-optional="training_center_id"
                                            data-filters="{{json_encode(['institute_id' => $authUser->institute_id, 'batch_status'=>1 ])}}"
                                            @if($edit)
                                            data-preselected-option="{{json_encode(['text' =>  $examinationResult->batch->title_en, 'id' =>  $examinationResult->batch_id])}}"
                                            @endif
                                            data-placeholder="{{ __('generic.select_placeholder') }}"
                                    >
                                    </select>

                                </div>
                            </div>--}}


                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label for="youth_id">
                                        {{__('course_management::admin.examination_result.youth')}}
                                        <span class="required"></span>
                                    </label>
                                    <select class="form-control select2" id="youth_id" name="youth_id" required>
                                        <option value="">{{__('course_management::admin.common.select')}}</option>

                                        @if($edit)
                                            @foreach($youths as $key => $youth)
                                                <option  {{ $examinationResult->youth_id == $key ? 'selected' : ''}}
                                                         value="{{ $key }}">{{ $youth }}</option>
                                            @endforeach
                                        @endif
                                    </select>
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
        #institute_id-error{
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
                feedback: {
                    required: true,
                    //pattern: /^[a-zA-Z0-9 ]*$/,
                },
            },
            messages: {
                feedback: {
                        pattern: "This field is required",
                },
            },
            submitHandler: function (htmlForm) {
                $('.overlay').show();
                htmlForm.submit();
            }
        });


        /*$(document).ready(function() {
            $('.batch_id').on('change', function(e){
                let batch_id = e.target.value;
                if (!batch_id) {
                    batch_id = 0;
                }
                var route = "{{route('course_management::admin.examination-results.get-youths')}}/"+batch_id;
                $.get(route, function(data) {
                    console.log(data);
                    $('#youth_id').empty();
                    $('#youth_id').append('<option value="'+'">{{__('course_management::admin.common.select')}}</option>');
                    $.each(data, function(index,data){
                        console.log(data);
                        $('#youth_id').append('<option value="' + data.id + '">' + data.youth_name_en + '</option>');
                    });
                });

            });

            // For presetting feedback value
            $('#feedback').val('Good');
        });*/


        $(document).ready(function() {
            $('.examination_id').on('change', function(e){
                let examination_id = e.target.value;
                if (!examination_id) {
                    examination_id = 0;
                }
                var route = "{{route('course_management::admin.examination-results.get-youths')}}/"+examination_id;
                $.get(route, function(data) {
                    console.log(data);
                    $('#youth_id').empty();
                    $('#youth_id').append('<option value="'+'">{{__('course_management::admin.common.select')}}</option>');
                    $.each(data, function(index,data){
                        console.log(data);
                        $('#youth_id').append('<option value="' + data.id + '">' + data.youth_name_en + '</option>');
                    });
                });

            });

            // For presetting feedback value
            $('#feedback').val('Good');
        });


    </script>
@endpush


