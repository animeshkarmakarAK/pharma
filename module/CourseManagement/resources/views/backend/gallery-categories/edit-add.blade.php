@php
    $edit = !empty($galleryCategory->id);
    /** @var \App\Models\User $authUser */
    $authUser = \App\Helpers\Classes\AuthHelper::getAuthUser();


@endphp

@extends('master::layouts.master')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card card-outline">
                    <div class="card-header text-primary custom-bg-gradient-info">
                        <h3 class="card-title">{{ ! $edit ? 'Add Album' : 'Update Album' }}</h3>

                        <div class="card-tools">
                            <a href="{{route('course_management::admin.gallery-categories.index')}}"
                               class="btn btn-sm btn-outline-primary btn-rounded">
                                <i class="fas fa-backward"></i> Back to list
                            </a>
                        </div>

                    </div>


                    <div class="card-body">
                        <form class="row edit-add-form" method="post" enctype="multipart/form-data"
                              action="{{ $edit ? route('course_management::admin.gallery-categories.update', [$galleryCategory->id]) : route('course_management::admin.gallery-categories.store')}}">
                            @csrf
                            @if($edit)
                                @method('put')
                            @endif

                            {{--<input type="hidden" name="created_by" value="{{ $authUser? $authUser->id : '' }}">--}}

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="content_title">{{ __('Title (En)') }}<span
                                            style="color: red"> * </span></label>
                                    <input type="text" class="form-control" id="title_en"
                                           name="title_en"
                                           value="{{ $edit ? $galleryCategory->title_en : old('title_en') }}"
                                           placeholder="{{ __('Title (En)') }}">
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="content_title">{{ __('Title (Bn)') }}<span
                                            style="color: red"> * </span></label>
                                    <input type="text" class="form-control" id="title_bn"
                                           name="title_bn"
                                           value="{{ $edit ? $galleryCategory->title_bn : old('title_bn') }}"
                                           placeholder="{{ __('Title (Bn)') }}">
                                </div>
                            </div>

                            @if($authUser->isInstituteUser())
                                <input type="hidden" id="institute_id" name="institute_id"
                                       value="{{$authUser->institute_id}}">
                            @else
                                <div class="form-group col-md-6">
                                    <label for="institute_id">Institute Name <span
                                            style="color: red"> * </span></label>
                                    <select class="form-control select2-ajax-wizard"
                                            name="institute_id"
                                            id="institute_id"
                                            data-model="{{base64_encode(\Module\CourseManagement\App\Models\Institute::class)}}"
                                            data-label-fields="{title_en}"
                                            data-dependent-fields="#programme_id|#batch_id"
                                            @if($edit && $galleryCategory->institute_id)
                                            data-preselected-option="{{json_encode(['text' => $galleryCategory->institute->title_en, 'id' => $galleryCategory->institute_id])}}"
                                            @endif
                                            data-placeholder="নির্বাচন করুন"
                                    >
                                    </select>
                                </div>
                            @endif


                            <div class="form-group col-md-6">
                                <label for="programme_id">Programme</label>
                                <select class="form-control select2-ajax-wizard"
                                        name="programme_id"
                                        id="programme_id"
                                        data-model="{{base64_encode(\Module\CourseManagement\App\Models\Programme::class)}}"
                                        data-label-fields="{title_en}"
                                        data-depend-on-optional="institute_id"
                                        data-dependent-fields="#batch_id"
                                        @if($edit && $galleryCategory->programme_id)
                                        data-preselected-option="{{json_encode(['text' => $galleryCategory->programme->title_en, 'id' => $galleryCategory->programme_id])}}"
                                        @endif
                                        data-placeholder="নির্বাচন করুন"
                                >
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="batch_id">Batch</label>
                                <select class="form-control select2-ajax-wizard"
                                        name="batch_id"
                                        id="batch_id"
                                        data-model="{{base64_encode(\Module\CourseManagement\App\Models\Batch::class)}}"
                                        data-label-fields="{title_en}"
                                        data-depend-on-optional="institute_id|programme_id"
                                        @if($edit && $galleryCategory->batch_id)
                                        data-preselected-option="{{json_encode(['text' => $galleryCategory->batch->title_en, 'id' => $galleryCategory->batch_id])}}"
                                        @endif
                                        data-placeholder="নির্বাচন করুন"
                                >
                                </select>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="image">{{ __('Cover Image') }}</label>
                                    <div class="input-group">
                                        <div class="programme-image-upload-section">
                                            <div class="avatar-preview text-center">
                                                <label for="image">
                                                    <img class="figure-img"
                                                         src={{ $edit && $galleryCategory->image ? asset('storage/'.$galleryCategory->image) : "https://via.placeholder.com/350x350?text=Photo+Album"}}
                                                             height="200" width="200"
                                                         alt="Photo Album"/>
                                                    <span class="p-1 bg-gray"
                                                          style="position: relative; right: 0; bottom: 50%; border: 2px solid #afafaf; border-radius: 50%;margin-left: -31px; overflow: hidden">
                                                        <i class="fa fa-pencil-alt text-white"></i>
                                                    </span>
                                                </label>
                                                <div class="imgRemove" style="display: none">
                                                </div>
                                            </div>
                                            <input type="file" name="image" style="display: none"
                                                   id="image">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            @if($edit)
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="row_status">Active Status</label>
                                        <div class="custom-control custom-radio">
                                            <input class="custom-control-input" type="radio" id="row_status_active"
                                                   name="row_status"
                                                   value="{{ \Module\CourseManagement\App\Models\GalleryCategory::ROW_STATUS_ACTIVE }}"
                                                {{ ($edit && $galleryCategory->row_status == \Module\CourseManagement\App\Models\GalleryCategory::ROW_STATUS_ACTIVE) || old('row_status') == \Module\CourseManagement\App\Models\GalleryCategory::ROW_STATUS_ACTIVE ? 'checked' : '' }}>
                                            <label for="row_status_active" class="custom-control-label">Active</label>
                                        </div>

                                        <div class="custom-control custom-radio">
                                            <input class="custom-control-input" type="radio" id="row_status_inactive"
                                                   name="row_status"
                                                   value="{{ \Module\CourseManagement\App\Models\GalleryCategory::ROW_STATUS_INACTIVE }}"
                                                {{ ($edit && $galleryCategory->row_status == \Module\CourseManagement\App\Models\GalleryCategory::ROW_STATUS_INACTIVE) || old('row_status') == \Module\CourseManagement\App\Models\GalleryCategory::ROW_STATUS_INACTIVE ? 'checked' : '' }}>
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
        const content_types = @json(\Module\CourseManagement\App\Models\Gallery::CONTENT_TYPES);

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
                },
                title_bn: {
                    required: true,
                    pattern: "^[\\s-'\u0980-\u09ff]{1,255}$",
                },
                institute_id: {
                    required: true,
                },

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
            $('#image').change(function () {
                readURL(this); //preview image

                setTimeout(function () {
                    editAddForm.validate().element('#image');
                }, 200);

                $('.imgRemove').css('display', 'block');
            });

            $('.imgRemove').on('click', function () {
                $('#image').parent().find('.avatar-preview img').attr('src', "https://via.placeholder.com/350x350?text=Photo+Album");
                $('#image').val("").valid();
                $(this).css('display', 'none');
            })
        })
    </script>
@endpush


