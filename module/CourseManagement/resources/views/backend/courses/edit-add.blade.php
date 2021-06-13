@php
    $edit = !empty($course->id);
    /** @var \App\Models\User $authUser */
    $authUser = \App\Helpers\Classes\AuthHelper::getAuthUser();
@endphp

@extends('master::layouts.master')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card card-outline">
                    <div class="card-header custom-bg-gradient-info">
                        <h3 class="card-title text-primary font-weight-bold">{{ ! $edit ? 'Add Course' : 'Update Course' }}</h3>

                        <div class="card-tools">
                            <a href="{{route('course_management::admin.courses.index')}}"
                               class="btn btn-sm btn-outline-primary btn-rounded">
                                <i class="fas fa-backward"></i> Back to list
                            </a>
                        </div>

                    </div>

                    <div class="card-body">
                        <form class="row edit-add-form" method="post" enctype="multipart/form-data"
                              action="{{ $edit ? route('course_management::admin.courses.update', [$course->id]) : route('course_management::admin.courses.store')}}">
                            @csrf
                            @if($edit)
                                @method('put')
                            @endif

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="cover_image">{{ __('Upload Cover Image') }}<span
                                            class="required">*</span></label>
                                    <div class="input-group">
                                        <div class="cover-image-upload-section">
                                            <div class="avatar-preview text-center">
                                                <label for="cover_image">
                                                    <img class="figure-img"
                                                         src={{ $edit && $course->cover_image ? asset('storage/'.$course->cover_image) : "https://via.placeholder.com/1080x300?text=Course+Cover-image"}}
                                                             height="300" width="100%"
                                                         alt="course cover_image"/>
                                                    <span class="p-1 bg-gray"
                                                          style="position: relative; right: 0; bottom: 50%; border: 2px solid #afafaf; border-radius: 50%;margin-left: -31px; overflow: hidden">
                                                        <i class="fa fa-pencil-alt text-white"></i>
                                                    </span>
                                                </label>
                                            </div>
                                            <input type="file" name="cover_image" style="display: none"
                                                   id="cover_image">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            @if($authUser->isInstituteUser())
                                <input type="hidden" id="institute_id" name="institute_id"
                                       value="{{$authUser->institute_id}}">
                            @else
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="institute_id">{{ __('Institute Name') }}<span
                                                style="color: red"> * </span></label>
                                        <select class="form-control select2-ajax-wizard"
                                                name="institute_id"
                                                id="institute_id"
                                                data-model="{{base64_encode(\Module\CourseManagement\App\Models\Institute::class)}}"
                                                data-label-fields="{title_en}"
                                                @if($edit)
                                                data-preselected-option="{{json_encode(['text' =>  $course->institute->title_en, 'id' =>  $course->institute->id])}}"
                                                @endif
                                                data-placeholder="Select Institute"
                                        >
                                            <option selected disabled>Select Institute</option>
                                        </select>
                                    </div>
                                </div>
                            @endif


                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="name">{{ __('Course Name') . '(English)' }}<span
                                            style="color: red"> * </span></label>
                                    <input type="text" class="form-control" id="title_en"
                                           name="title_en"
                                           value="{{ $edit ? $course->title_en : old('title_en') }}"
                                           placeholder="{{ __('Name') }}">
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="name">{{ __('Course Name') . '(Bangla)' }}<span
                                            style="color: red"> * </span></label>
                                    <input type="text" class="form-control" id="title_bn"
                                           name="title_bn"
                                           value="{{ $edit ? $course->title_bn : old('title_bn') }}"
                                           placeholder="{{ __('Name') }}">
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="name">{{ __('Course Code') }}<span
                                            style="color: red"> * </span></label>
                                    <input type="text" class="form-control" id="code"
                                           name="code"
                                           data-code="{{ $edit ? $course->code : '' }}"
                                           value="{{ $edit ? $course->code : old('code') }}"
                                           placeholder="{{ __('code') }}">
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="course_fee">{{ __('Course Fee') }}<span
                                            style="color: red"> * </span></label>
                                    <input type="text" class="form-control" id="course_fee"
                                           name="course_fee"
                                           value="{{ $edit ? $course->course_fee : old('course_fee') }}"
                                           placeholder="{{ __('Course Fee') }}">
                                </div>
                            </div>


                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="description">{{ __('Course Description')  }}<span
                                            class="required">*</span></label>
                                    <textarea class="form-control" id="description"
                                              name="description"
                                              rows="3"
                                              value="{{ $edit ? $course->description : old('description') }}"
                                              placeholder="{{ __('Description') }}">{{ $edit ? $course->description : old('description') }}</textarea>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="prerequisite">{{ __('Course Prerequisite') }}<span
                                            class="required">*</span></label>
                                    <textarea rows="3" class="form-control" id="prerequisite"
                                              name="prerequisite"
                                              value="{{ $edit ? $course->prerequisite : old('prerequisite') }}"
                                              placeholder="{{ __('Prerequisite') }}">{{ $edit ? $course->prerequisite : old('prerequisite') }}</textarea>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="eligibility">{{ __('Eligibility') }}<span
                                            class="required">*</span></label>
                                    <textarea rows="3" class="form-control" id="eligibility"
                                              name="eligibility"
                                              value="{{ $edit ? $course->eligibility : old('eligibility') }}"
                                              placeholder="{{ __('Eligibility') }}">{{ $edit ? $course->eligibility : old('eligibility') }}</textarea>
                                </div>
                            </div>

                            @if($edit)
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="row_status">Active Status</label>
                                        <div class="custom-control custom-radio">
                                            <input class="custom-control-input" type="radio" id="row_status_active"
                                                   name="row_status"
                                                   value="{{ \Module\CourseManagement\App\Models\Video::ROW_STATUS_ACTIVE }}"
                                                {{ ($edit && $course->row_status == \Module\CourseManagement\App\Models\Video::ROW_STATUS_ACTIVE) || old('row_status') == \Module\CourseManagement\App\Models\Video::ROW_STATUS_ACTIVE ? 'checked' : '' }}>
                                            <label for="row_status_active" class="custom-control-label">Active</label>
                                        </div>

                                        <div class="custom-control custom-radio">
                                            <input class="custom-control-input" type="radio" id="row_status_inactive"
                                                   name="row_status"
                                                   value="{{ \Module\CourseManagement\App\Models\Video::ROW_STATUS_INACTIVE }}"
                                                {{ ($edit && $course->row_status == \Module\CourseManagement\App\Models\Video::ROW_STATUS_INACTIVE) || old('row_status') == \Module\CourseManagement\App\Models\Video::ROW_STATUS_ACTIVE ? 'checked' : '' }}>
                                            <label for="row_status_inactive"
                                                   class="custom-control-label">Inactive</label>
                                        </div>
                                    </div>
                                </div>
                            @endif


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

@push('js')
    <x-generic-validation-error-toastr></x-generic-validation-error-toastr>

    <script>
        const EDIT = !!'{{$edit}}';

        const editAddForm = $('.edit-add-form');
        editAddForm.validate({
            rules: {
                title_en: {
                    required: true
                },
                title_bn: {
                    required: true,
                    pattern: "^[\\s-'\u0980-\u09ff]{1,255}$",
                },
                code: {
                    required: true,
                    remote: {
                        param: {
                            type: "post",
                            url: "{{ route('course_management::admin.check-course-code') }}",
                        },
                        depends: function (element) {
                            return $(element).val() !== $('#code').attr('data-code');
                        }
                    },
                },
                institute_id: {
                    required: true,
                },
                course_fee: {
                    required: true,
                    min: 1
                },
                cover_image: {
                    required: !EDIT,
                    accept: "image/*",
                },
                description: {
                    required: true,
                },
                eligibility: {
                    required: true,
                },
                prerequisite: {
                    required: true,
                },


            },
            messages: {
                title_bn: {
                    pattern: "This field is required in Bangla.",
                },
                code: {
                    remote: "Code already in use!",
                }
            },
            submitHandler: function (htmlForm) {
                $('.overlay').show();
                htmlForm.submit();
            }
        });

        function readURL(input) {
            if (input.files && input.files[0]) {
                let reader = new FileReader();
                reader.onload = function (e) {
                    $(input).parent().find('.avatar-preview img').attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]); // convert to base64 string
            }
        }

        $(document).ready(function () {
            $('#cover_image').change(function () {
                readURL(this); //preview image
                editAddForm.validate().element("#cover_image");
            });
        })
    </script>
@endpush


