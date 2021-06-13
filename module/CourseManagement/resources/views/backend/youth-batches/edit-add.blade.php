@php
    $edit = !empty($batch->id);
    /** @var \App\Models\User $authUser */
    $authUser = \App\Helpers\Classes\AuthHelper::getAuthUser();
@endphp

@extends('master::layouts.master')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card card-outline">
                    <div class="card-header d-flex justify-content-between custom-bg-gradient-info">
                        <h3 class="card-title font-weight-bold text-primary">{{ ! $edit ? 'Add Batch' : 'Update Batch' }}</h3>
                        <div>
                            <a href="{{route('course_management::admin.batches.index')}}" class="btn btn-sm btn-rounded btn-outline-primary">
                                <i class="fas fa-backward"></i> Back to list
                            </a>
                        </div>
                    </div>

                    <div class="card-body">
                        <form class="row edit-add-form" method="post"
                              action="{{ $edit ? route('course_management::admin.batches.update', [$batch->id]) : route('course_management::admin.batches.store')}}">
                            @csrf
                            @if($edit)
                                @method('put')
                            @endif

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="title_en">{{ __('Title (En) ') }}</label>
                                    <input type="text" class="form-control" id="title_en"
                                           name="title_en"
                                           value="{{ $edit ? $batch->title_en : old('title_en') }}">
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="title_bn">{{ __('Title (Bn) ') }}</label>
                                    <input type="text" class="form-control" id="title_bn"
                                           name="title_bn"
                                           value="{{ $edit ? $batch->title_bn : old('title_bn') }}">
                                </div>
                            </div>

                            @if($authUser->isInstituteUser())
                                <input type="hidden" id="institute_id" name="institute_id" value="{{$authUser->institute_id}}">
                            @else
                                <div class="form-group col-md-6">
                                    <label for="institute_id">Institute Name</label>
                                    <select class="form-control custom-input-box select2" name="institute_id"
                                            id="institute_id" required>
                                        <option value="" selected>Select Institute</option>
                                        @foreach($institutes as $institute)
                                            <option
                                                value="{{ $institute->id}}" {{ $edit && $batch->institute_id == $institute->id ? 'selected':''}}>{{ $institute->title_en }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            @endif


                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="course_id">{{ __('Course Name') }}</label>

                                        <select name="course_id" id="course_id" class="form-control select2">
                                            @if($edit && !empty($batch->course->id))
                                                @foreach($courses as $course)
                                                    <option value="{{ $course->id }}" {{ $course->id == $batch->course->id ? 'selected':''}}>{{ $course->title_en }}</option>
                                                @endforeach
                                            @else
                                                <select name="course_id" id="course_id" class="form-control select2">
                                                </select>
                                            @endif
                                        </select>

                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="code">{{ __('Code') }}</label>
                                    <input type="number" class="form-control" id="code"
                                           name="code"
                                           value="{{ $edit ? $batch->code : old('code') }}"
                                           placeholder="{{ __('Code') }}">
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="max_student_enrollment">{{ __('Max Student Enrollment') }}</label>
                                    <input type="number" class="form-control" id="max_student_enrollment"
                                           name="max_student_enrollment"
                                           value="{{ $edit ? $batch->max_student_enrollment : old('max_student_enrollment') }}"
                                           placeholder="{{ __('Max Student Enrollment') }}">
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="start_date">{{ __('Batch Start Date') }}</label>
                                    <input type="text" class="flat-date flat-date-custom-bg" id="start_date"
                                           name="start_date"
                                           value="{{ $edit ? $batch->start_date : old('start_date') }}"
                                    >
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="end_date">{{ __('Batch End Date') }}</label>
                                    <input type="date" class="flat-date flat-date-custom-bg" id="end_date"
                                           name="end_date"
                                           value="{{ $edit ? $batch->end_date : old('end_date') }}"
                                    >
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="start_time">{{ __('Batch Start Time') }}</label>
                                    <input type="time" class="flat-time flat-time-custom-bg" id="start_time"
                                           name="start_time"
                                           value="{{ $edit ? $batch->start_time : old('start_time') }}"
                                    >
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="end_time">{{ __('Batch End Time') }}</label>
                                    <input type="time" class="flat-time flat-time-custom-bg" id="end_time"
                                           name="end_time"
                                           value="{{ $edit ? $batch->end_time : old('end_time') }}">
                                </div>
                            </div>


                            <div class="col-sm-12 text-right">
                                <button type="submit"
                                        class="btn btn-success">{{ $edit ? __('Update') : __('Add') }}</button>
                            </div>
                        </form>
                    </div><!-- /.card-body -->
                    <div class="overlay" style="display: none">
                        <i class="fas fa-2x fa-sync-alt fa-spin"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@push('css')
    <style>
        .flat-date-custom-bg, .flat-time-custom-bg{
            background-color: #fafdff !important;
        }
    </style>
@endpush

@push('js')
    <script>
        const EDIT = !!'{{$edit}}';


        const editAddForm = $('.edit-add-form');
        editAddForm.validate({
            rules: {
                title_en: {
                    required: true
                },
                title_bn: {
                    required: true
                },
                institute_id: {
                    required: true
                },
                course_id: {
                    required: true
                },
                code: {
                    required: true,
                    number: true,
                    min: 1,
                },
                max_student_enrollment: {
                    required: true,
                    number: true,
                    min: 1,
                },
                start_date: {
                    required: true,
                },
                end_date: {
                    required: true,
                },
                start_time: {
                    required: true,
                },
                end_time: {
                    required: true,
                },

            },
            messages: {
                start_date: {
                  min: "Not valid",
                },
                end_date: {
                    min: "batch end date should be after batch start date",
                }
            },
            submitHandler: function (htmlForm) {
                $('.overlay').show();
                htmlForm.submit();
            }
        });


        $('#institute_id').on('change', function () {
            let id = $(this).val();
            $('#course_id').empty();
            $('#course_id').append(`<option value="0" disabled selected>Processing...</option>`);
            $.ajax({
                type: 'GET',
                url: '/getCourses/' + id,
                success: function (response) {
                    $('#course_id').empty();
                    $('#course_id').append(`<option value=""></option>`);
                    response.forEach(element => {
                        $('#course_id').append(`<option value="${element['id']}">${element['title_en']}</option>`);
                    });
                }
            });
        });


    </script>
@endpush


