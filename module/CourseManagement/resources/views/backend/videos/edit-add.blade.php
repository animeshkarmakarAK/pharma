@php
    $edit = !empty($video->id);
    /** @var \App\Models\User $authUser */
    $authUser = \App\Helpers\Classes\AuthHelper::getAuthUser();
@endphp

@extends('master::layouts.master')

@section('title')
    {{ ! $edit ? 'Add Video' : 'Update Video' }}
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card card-outline">
                    <div class="card-header  custom-bg-gradient-info">
                        <h3 class="card-title text-primary font-weight-bold">{{ ! $edit ? 'Add Video' : 'Update Video' }}</h3>

                        <div class="card-tools">
                            <a href="{{route('course_management::admin.videos.index')}}"
                               class="btn btn-sm btn-outline-primary btn-rounded">
                                <i class="fas fa-backward"></i> Back to list
                            </a>
                        </div>
                    </div>

                    <div class="card-body">
                        <form class="row edit-add-form" method="post" enctype="multipart/form-data"
                              action="{{ $edit ? route('course_management::admin.videos.update', [$video->id]) : route('course_management::admin.videos.store')}}">
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
                                           value="{{ $edit ? $video->title_en : old('title_en') }}"
                                           placeholder="{{ __('Title') }}">
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="title_bn">{{ __('Title') . '(Bangla)' }}<span
                                            class="required"> * </span></label>
                                    <input type="text" class="form-control" id="title_bn"
                                           name="title_bn"
                                           value="{{ $edit ? $video->title_bn : old('title_bn') }}"
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
                                                data-preselected-option="{{json_encode(['text' =>  $video->institute->title_en, 'id' =>  $video->institute->id])}}"
                                                @endif
                                                data-placeholder="নির্বাচন করুন"
                                        >
                                        </select>
                                    </div>
                                </div>
                            @endif

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="video_category_id">{{ __('Video Category') }}</label>
                                    <select class="form-control select2-ajax-wizard"
                                            name="video_category_id"
                                            id="video_category_id"
                                            data-model="{{base64_encode(Module\CourseManagement\App\Models\VideoCategory::class)}}"
                                            data-label-fields="{title_en}"
                                            data-depend-on="institute_id"
                                            @if($edit && $video->videoCategory)
                                            data-preselected-option="{{json_encode(['text' =>  $video->videoCategory->title_en, 'id' =>  $video->videoCategory->id])}}"
                                            @endif
                                            data-placeholder="নির্বাচন করুন"
                                    >
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="video_type">Video Type<span
                                            class="required">*</span> :</label>
                                    <div class="custom-control custom-radio">
                                        <input class="custom-control-input" type="radio" id="video_type_youtube_video"
                                               name="video_type"
                                               value="{{ \Module\CourseManagement\App\Models\Video::VIDEO_TYPE_YOUTUBE_VIDEO }}"
                                            {{ ($edit && $video->video_type == \Module\CourseManagement\App\Models\Video::VIDEO_TYPE_YOUTUBE_VIDEO) || old('video_type') == \Module\CourseManagement\App\Models\Video::VIDEO_TYPE_YOUTUBE_VIDEO ? 'checked' : '' }}>
                                        <label for="video_type_youtube_video" class="custom-control-label">Youtube
                                            Video</label>
                                    </div>

                                    <div class="custom-control custom-radio">
                                        <input class="custom-control-input" type="radio" id="video_type_uploaded_video"
                                               name="video_type"
                                               value="{{ \Module\CourseManagement\App\Models\Video::VIDEO_TYPE_UPLOADED_VIDEO }}"
                                            {{ ($edit && $video->video_type == \Module\CourseManagement\App\Models\Video::VIDEO_TYPE_UPLOADED_VIDEO) || old('video_type') == \Module\CourseManagement\App\Models\Video::VIDEO_TYPE_UPLOADED_VIDEO ? 'checked' : '' }}>
                                        <label for="video_type_uploaded_video" class="custom-control-label">Upload
                                            Video</label>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6" style="display: none;">
                                <div class="form-group">
                                    <label for="youtube_video_url">Youtube Video URL <span
                                            class="required">*</span></label>
                                    <input type="text"
                                           class="form-control"
                                           name="youtube_video_url"
                                           id="youtube_video_url"
                                           value="{{ $edit ? $video->youtube_video_url : old('youtube_video_url') }}">
                                </div>
                            </div>

                            <div class="col-md-6" style="display: none;">
                                <div class="form-group">
                                    <label for="uploaded_video_path">Upload Video <span
                                            class="required">*</span></label>
                                    <input type="file"
                                           class="form-control"
                                           name="uploaded_video_path"
                                           id="uploaded_video_path"
                                           data-value="{{ $edit ? $video->uploaded_video_path : old('uploaded_video_path') }}"
                                    >
                                </div>
                            </div>

                            @if($edit)
                                <div class="col-md-6">
                                    <label>Video Content</label>
                                    @if($video->video_type == \Module\CourseManagement\App\Models\Video::VIDEO_TYPE_YOUTUBE_VIDEO)
                                        <div class="embed-responsive embed-responsive-16by9"
                                             style="height: 200px; width: 100%;">
                                            <iframe class="embed-responsive-item"
                                                    src="{{ 'https://www.youtube.com/embed/'. $video->youtube_video_id .'?rel=0' }}"
                                                    allowfullscreen></iframe>
                                        </div>
                                    @elseif($video->video_type == \Module\CourseManagement\App\Models\Video::VIDEO_TYPE_UPLOADED_VIDEO)
                                        <div class="embed-responsive embed-responsive-16by9"
                                             style="height: 200px; width: 100%;">
                                            <video controls>
                                                <source src="{{ '/storage/'.$video->uploaded_video_path }}"
                                                        type="video/mp4">
                                            </video>
                                        </div>
                                    @endif
                                </div>
                            @endif

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name">{{ __('Video Description')  }}</label>
                                    <textarea class="form-control" id="description"
                                              name="description"
                                              rows="3"
                                              placeholder="{{ __('Description') }}">{{ $edit ? $video->description : old('description') }}</textarea>
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
                                                {{ ($edit && $video->row_status == \Module\CourseManagement\App\Models\Video::ROW_STATUS_ACTIVE) || old('row_status') == \Module\CourseManagement\App\Models\Video::ROW_STATUS_ACTIVE ? 'checked' : '' }}>
                                            <label for="row_status_active" class="custom-control-label">Active</label>
                                        </div>

                                        <div class="custom-control custom-radio">
                                            <input class="custom-control-input" type="radio" id="row_status_inactive"
                                                   name="row_status"
                                                   value="{{ \Module\CourseManagement\App\Models\Video::ROW_STATUS_INACTIVE }}"
                                                {{ ($edit && $video->row_status == \Module\CourseManagement\App\Models\Video::ROW_STATUS_INACTIVE) || old('row_status') == \Module\CourseManagement\App\Models\Video::ROW_STATUS_ACTIVE ? 'checked' : '' }}>
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
            errorElement: "em",
            onkeyup: false,
            errorPlacement: function (error, element) {
                error.addClass("help-block");
                element.parents(".form-group").addClass("has-feedback");

                if (element.parents(".form-group").length) {
                    error.insertAfter(element.parents(".form-group").first().children().last());
                } else if (element.hasClass('select2') || element.hasClass('select2-ajax-custom') || element.hasClass('select2-ajax')) {
                    error.insertAfter(element.parents(".form-group").first().find('.select2-container'));
                } else {
                    error.insertAfter(element);
                }
            },
            highlight: function (element, errorClass, validClass) {
                $(element).parents(".form-group").addClass("has-error").removeClass("has-success");
                $(element).closest('.help-block').remove();
            },
            unhighlight: function (element, errorClass, validClass) {
                $(element).parents(".form-group").addClass("has-success").removeClass("has-error");
            },
            rules: {
                title_en: {
                    required: true,
                    pattern: "^[a-zA-Z0-9$@$!%*?&#()[/{}^-_. +]+$",
                },
                title_bn: {
                    required: true,
                    pattern: "^[\\s-'\u0980-\u09ff!@#\$%\^\&*\)\(+=._-]{1,255}$",
                },
                video_type: {
                    required: true
                },
                youtube_video_url: {
                    required: function () {
                        return $('input[name = "video_type"]:checked').val() == {!! \Module\CourseManagement\App\Models\Video::VIDEO_TYPE_YOUTUBE_VIDEO !!};
                    },
                    pattern: /^(?:https?:\/\/)?(?:www\.)?(?:youtu\.be\/|youtube\.com\/(?:embed\/|v\/|watch\?v=|watch\?.+&v=))((\w|-){11})(?:\S+)?$/
                },
                uploaded_video_path: {
                    required: function () {
                        return !$('input[name="uploaded_video_path"]').data('value') && $('input[name = "video_type"]:checked').val() == {!! \Module\CourseManagement\App\Models\Video::VIDEO_TYPE_UPLOADED_VIDEO !!};
                    },
                    accept: "video/*",
                },
                institute_id: {
                    required: true,
                },

                active_status: {
                    required: false,
                },
            },
            messages: {
                title_en: {
                    pattern: "This field is required in English.",
                },
                title_bn: {
                    pattern: "This field is required in Bangla.",
                },
                youtube_video_id: {
                    pattern: "invalid youtube video url",
                },
                uploaded_video_path: {
                    accept: "Please upload valid video file"
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

                }
                reader.onprogress = function () {
                    $('.overlay').show();
                }
                reader.onloadend = function () {
                    $('.overlay').hide();
                }
                reader.readAsDataURL(input.files[0]); // convert to base64 string
            }
        }

        $(document).ready(function () {
            let videoType = $('input[name="video_type"]:checked').val();
            if (videoType == {!! \Module\CourseManagement\App\Models\Video::VIDEO_TYPE_YOUTUBE_VIDEO !!}) {
                $('#youtube_video_url').parent().parent().show();
                $('#uploaded_video_path').parent().parent().hide();
            }
            if (videoType == {!! \Module\CourseManagement\App\Models\Video::VIDEO_TYPE_UPLOADED_VIDEO !!}) {
                $('#uploaded_video_path').parent().parent().show();
                $('#youtube_video_url').parent().parent().hide();
            }

            $('input[name="video_type').on('change', function () {
                if ($(this).val() == {!! \Module\CourseManagement\App\Models\Video::VIDEO_TYPE_YOUTUBE_VIDEO !!}) {
                    $('#youtube_video_url').parent().parent().show();
                    $('#uploaded_video_path').parent().parent().hide();
                } else {
                    $('#uploaded_video_path').parent().parent().show();
                    $('#youtube_video_url').parent().parent().hide();
                }
            });

            $('#uploaded_video_path').change(function () {
                readURL(this);
            })
        });
    </script>
@endpush


