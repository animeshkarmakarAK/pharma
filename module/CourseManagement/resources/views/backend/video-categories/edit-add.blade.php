@php
    $edit = !empty($videoCategory->id);
    /** @var \App\Models\User $authUser */
    $authUser = \App\Helpers\Classes\AuthHelper::getAuthUser();
@endphp

@extends('master::layouts.master')

@section('title')
    {{ ! $edit ? 'Add Video Category' : 'Update Video Category' }}
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card card-outline">
                    <div class="card-header  custom-bg-gradient-info">
                        <h3 class="card-title text-primary font-weight-bold">{{ ! $edit ? 'Add Video Category' : 'Update Video Category' }}</h3>

                        <div class="card-tools">
                            <a href="{{route('course_management::admin.video-categories.index')}}"
                               class="btn btn-sm btn-outline-primary btn-rounded">
                                <i class="fas fa-backward"></i> Back to list
                            </a>
                        </div>

                    </div>

                    <div class="card-body">
                        <form class="row edit-add-form" method="post" enctype="multipart/form-data"
                              action="{{ $edit ? route('course_management::admin.video-categories.update', [$videoCategory->id]) : route('course_management::admin.video-categories.store')}}">
                            @csrf
                            @if($edit)
                                @method('put')
                            @endif
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="title_en">{{ __('Title') . '(English)' }}<span
                                            class="required"> * </span></label>
                                    <input type="text" class="form-control" id="title_en"
                                           name="title_en"
                                           value="{{ $edit ? $videoCategory->title_en : old('title_en') }}"
                                           placeholder="{{ __('Title') }}">
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="title_bn">{{ __('Title') . '(Bangla)' }}<span
                                            class="required"> * </span></label>
                                    <input type="text" class="form-control" id="title_bn"
                                           name="title_bn"
                                           value="{{ $edit ? $videoCategory->title_bn : old('title_bn') }}"
                                           placeholder="{{ __('Title in Bangla') }}">
                                </div>
                            </div>


                            @if($authUser->isInstituteUser())
                                <input type="hidden" id="institute_id" name="institute_id"
                                       value="{{$authUser->institute_id}}">
                            @else
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="institute_id">{{ __('Institute Name') }}<span
                                                class="required"> * </span></label>
                                        <select class="form-control select2-ajax-wizard"
                                                name="institute_id"
                                                id="institute_id"
                                                data-model="{{base64_encode(Module\CourseManagement\App\Models\Institute::class)}}"
                                                data-label-fields="{title_en}"
                                                data-dependent-fields="#video_category_id"
                                                @if($edit)
                                                data-preselected-option="{{json_encode(['text' =>  $videoCategory->institute->title_en, 'id' =>  $videoCategory->institute_id])}}"
                                                @endif
                                                data-placeholder="নির্বাচন করুন">
                                        </select>
                                    </div>
                                </div>
                            @endif

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="video_category_id">{{ __('Video Parent Category') }}</label>
                                    <select class="form-control select2-ajax-wizard"
                                            name="parent_id"
                                            id="video_category_id"
                                            data-model="{{base64_encode(Module\CourseManagement\App\Models\VideoCategory::class)}}"
                                            data-label-fields="{title_en}"
                                            data-depend-on="institute_id"
                                            @if($edit && !empty($videoCategory->parent_id))
                                            data-preselected-option="{{json_encode(['text' =>  optional(\Module\CourseManagement\App\Models\VideoCategory::find($videoCategory->parent_id))->title_en, 'id' =>  $videoCategory->parent_id ]) }}"
                                            data-filters="{{json_encode(['id' != $videoCategory->id])}}"
                                            @endif
                                            data-placeholder="নির্বাচন করুন">
                                        <option value=""></option>
                                    </select>
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
                                                {{ ($edit && $videoCategory->row_status == \Module\CourseManagement\App\Models\VideoCategory::ROW_STATUS_ACTIVE) || old('row_status') == \Module\CourseManagement\App\Models\VideoCategory::ROW_STATUS_ACTIVE ? 'checked' : '' }}>
                                            <label for="row_status_active" class="custom-control-label">Active</label>
                                        </div>

                                        <div class="custom-control custom-radio">
                                            <input class="custom-control-input" type="radio" id="row_status_inactive"
                                                   name="row_status"
                                                   value="{{ \Module\CourseManagement\App\Models\Video::ROW_STATUS_INACTIVE }}"
                                                {{ ($edit && $videoCategory->row_status == \Module\CourseManagement\App\Models\VideoCategory::ROW_STATUS_INACTIVE) || old('row_status') == \Module\CourseManagement\App\Models\VideoCategory::ROW_STATUS_INACTIVE ? 'checked' : '' }}>
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
                    required: true,
                    pattern: "^[a-zA-Z0-9$@$!%*?&#()[/{}^-_. +]+$",
                },
                title_bn: {
                    required: true,
                    pattern: "^[\\s-'\u0980-\u09ff!@#\$%\^\&*\)\(+=._-]{1,255}$",
                },
                parent_id: {
                    required: false,
                },
                institute_id: {
                    required: true,
                },
                row_status: {
                    required: EDIT,
                },
            },
            messages: {
                title_en: {
                    pattern: "This field is required in English.",
                },
                title_bn: {
                    pattern: "This field is required in Bangla.",
                }
            },
            submitHandler: function (htmlForm) {
                $('.overlay').show();
                htmlForm.submit();
            }
        });

        $(document).ready(function () {
            $('input[name="is_youtube_video').on('change', function () {
                if ($(this).val() == {!! \Module\CourseManagement\App\Models\Video::VIDEO_TYPE_YOUTUBE_VIDEO !!}) {
                    $('#youtube_video_id').parent().parent().show();
                    $('#video_path').parent().parent().hide();
                } else {
                    $('#video_path').parent().parent().show();
                    $('#youtube_video_id').parent().parent().hide();
                }
            });
        });
    </script>
@endpush


