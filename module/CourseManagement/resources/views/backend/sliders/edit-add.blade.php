@php
    $edit = !empty($slider->id);
@endphp

@extends('master::layouts.master')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card card-outline">
                    <div class="card-header text-primary custom-bg-gradient-info">
                        <h3 class="card-title">{{ $edit ? 'Update Slider' : 'Add Slider' }}</h3>

                        <div class="card-tools">
                            @can('viewAny', \App\Models\Slider::class)
                                <a href="{{route('admin.sliders.index')}}"
                                   class="btn btn-sm btn-outline-primary btn-rounded">
                                    <i class="fas fa-backward"></i> Back to list
                                </a>
                            @endcan
                        </div>

                    </div>

                    <div class="card-body">
                        <form class="row edit-add-form" method="post"
                              action="{{ $edit ? route('admin.sliders.update', $slider) : route('admin.sliders.store')}}"
                              enctype="multipart/form-data">
                            @csrf
                            @if($edit)
                                @method('put')
                            @endif

                            <div class="col-md-12">
                                <div class="row justify-content-center align-content-center">
                                    <div class="form-group" style="width: 50vw; height: 200px">
                                        <div class="input-group">
                                            <div class="slider-upload-section">
                                                <div class="avatar-preview text-center">
                                                    <label for="slider">
                                                        <img class=""
                                                             src="{{$edit && $slider->slider ? asset('storage/'.$slider->slider) : 'https://via.placeholder.com/850x350?text=Slider+Picture'}}"
                                                             style="width: 100%; height: 200px"
                                                             alt="Slider Image"/>
                                                        <span class="p-1 bg-gray"
                                                              style="position: absolute; right: 0; bottom: 50%; border: 2px solid #afafaf; border-radius: 50%; overflow: hidden">
                                                        <i class="fa fa-pencil-alt text-white"></i>
                                                    </span>
                                                    </label>
                                                </div>
                                                <input type="file" name="slider" style="display: none"
                                                       id="slider">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="title">{{ __('Slider Title') }}<span
                                            class="required">*</span></label>
                                    <input type="text" class="form-control" id="title"
                                           name="title"
                                           value="{{ $edit ? $slider->title : old('title') }}"
                                           placeholder="{{ __('Title') }}">
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="name">{{ __('Slider Sub-title') }}<span
                                            class="required">*</span></label>
                                    <input type="text" class="form-control" id="sub_title"
                                           name="sub_title"
                                           value="{{ $edit ? $slider->sub_title : old('sub_title') }}"
                                           placeholder="{{ __('Sub-title') }}">
                                </div>
                            </div>

                            @if(auth()->user()->isInstituteUser())
                                <input type="hidden" id="institute_id" name="institute_id"
                                       value="{{auth()->user()->institute_id}}">
                            @else
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="institute_id">Institute(প্রতিষ্ঠান)<span
                                                class="required">*</span></label>
                                        <select class="form-control select2-ajax-wizard"
                                                name="institute_id"
                                                id="institute_id"
                                                data-model="{{base64_encode(App\Models\Institute::class)}}"
                                                data-label-fields="{title_en}"
                                                @if($edit)
                                                data-preselected-option="{{json_encode(['text' =>  $slider->institute->title_en, 'id' =>  $slider->institute->id])}}"
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
                                    <label for="is_button_available">Is Button Available
                                        <span class="required">*</span>:</label>
                                    <div class="custom-control custom-radio ml-2">
                                        <input class="custom-control-input" type="radio"
                                               id="is_button_available_yes"
                                               name="is_button_available"
                                               value="{{ \App\Models\Slider::IS_BUTTON_AVAILABLE_YES }}"
                                            {{ ($edit && $slider->is_button_available == \App\Models\Slider::IS_BUTTON_AVAILABLE_YES) || (old('is_button_available') == \App\Models\Slider::IS_BUTTON_AVAILABLE_YES) ? 'checked' : ''}}>
                                        <label for="is_button_available_yes"
                                               class="custom-control-label">Yes</label>
                                    </div>

                                    <div class="custom-control custom-radio ml-2">
                                        <input class="custom-control-input" type="radio"
                                               id="is_button_available_no"
                                               name="is_button_available"
                                               value="{{ \App\Models\Slider::IS_BUTTON_AVAILABLE_NO }}"
                                            {{ ($edit && $slider->is_button_available === \App\Models\Slider::IS_BUTTON_AVAILABLE_NO) || (!empty(old('is_button_available')) && old('is_button_available') == \App\Models\Slider::IS_BUTTON_AVAILABLE_NO) ? 'checked' : ''}}>
                                        <label for="is_button_available_no"
                                               class="custom-control-label">No</label>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="button_text">Button Text<span class="required">*</span></label>
                                    <input type="text"
                                           name="button_text" id="button_text" class="form-control"
                                           value="{{ $edit ? $slider->button_text : old('button_text') }}"
                                           placeholder="{{ __('Button Text') }}">
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="link">{{ __('Link') }}<span class="required">*</span></label> (Page ID)
                                    <input type="text" class="form-control" id="link"
                                           name="link"
                                           value="{{ $edit ? $slider->link : old('link') }}"
                                           placeholder="{{ __('Link') }}">
                                </div>
                            </div>

                            @if($edit)
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="row_status">Active Status<span class="required">*</span>
                                            :</label>
                                        <div class="custom-control custom-radio ml-2">
                                            <input class="custom-control-input" type="radio"
                                                   id="slider_active_status_yes"
                                                   name="row_status"
                                                   value="{{ \App\Models\Slider::ROW_STATUS_ACTIVE }}"
                                                {{ ($edit && $slider->row_status == \App\Models\Slider::ROW_STATUS_ACTIVE) || (old('row_status') == \App\Models\Slider::ROW_STATUS_ACTIVE) ? 'checked' : ''}}>
                                            <label for="slider_active_status_yes"
                                                   class="custom-control-label">Yes</label>
                                        </div>

                                        <div class="custom-control custom-radio ml-2">
                                            <input class="custom-control-input" type="radio"
                                                   id="slider_active_status_no"
                                                   name="row_status"
                                                   value="{{ \App\Models\Slider::ROW_STATUS_INACTIVE }}"
                                                {{ ($edit && $slider->row_status == \App\Models\Slider::ROW_STATUS_INACTIVE) || (old('row_status') == \App\Models\Slider::ROW_STATUS_INACTIVE) ? 'checked' : ''}}>
                                            <label for="slider_active_status_no"
                                                   class="custom-control-label">No</label>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="description">{{ __('Slider Description') }}<span
                                            class="required">*</span></label>
                                    <textarea class="form-control" id="description" name="description"
                                              rows="3"
                                              placeholder="{{ __('Description') }}">{{ $edit ? $slider->description : old('description') }}</textarea>
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

@push('js')
    <x-generic-validation-error-toastr/>

    <script>

        const EDIT = !!'{{$edit}}';

        $.validator.addMethod(
            "sliderSize",
            function (value, element) {
                let isHeightMatched = $('.avatar-preview').find('img')[0].naturalHeight == 1080;
                let isWidthMatched = $('.avatar-preview').find('img')[0].naturalWidth == 1920;
                return this.optional(element) || (isHeightMatched && isWidthMatched);
            },
            "Invalid picture size. Size must be  1080 * 1920",
        );

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
                title: {
                    required: true
                },
                sub_title: {
                    required: true
                },
                institute_id: {
                    required: true,
                },
                link: {
                    required: function () {
                        return $("input[name = 'is_button_available']:checked").val() == {!! \App\Models\Slider::IS_BUTTON_AVAILABLE_YES !!};
                    }
                },
                description: {
                    required: true
                },
                is_button_available: {
                    required: true,
                },
                button_text: {
                    required: function () {
                        return $("input[name = 'is_button_available']:checked").val() == {!! \App\Models\Slider::IS_BUTTON_AVAILABLE_YES !!};
                    }
                },
                row_status: {
                    required: true
                },
                slider: {
                    required: function () {
                        return !EDIT;
                    },
                    accept: "image/*",
                    sliderSize: true,
                },
            },

            submitHandler: function (htmlForm) {
                $('.overlay').show();
                htmlForm.submit();
            }
        });

        function readURL(input) {
            return new Promise(function (resolve, reject) {
                let reader = new FileReader();
                reader.onload = (e) => {
                    $('.avatar-preview img').attr('src', e.target.result);
                    resolve(e.target.result);
                };
                reader.onerror = reject;
                reader.readAsDataURL(input.files[0]); // convert to base64 string
            });
        }

        $(document).ready(function () {
            $("#slider").change(async function () {
                await readURL(this);
                editAddForm.validate().element("#slider");
            });

            if ($('input[name="is_button_available"]:checked').val() == {!! \App\Models\Slider::IS_BUTTON_AVAILABLE_YES !!}) {
                $('#button_text').parent().parent().show();
                $('#link').parent().parent().show();
            } else {
                $('#button_text').parent().parent().hide();
                $('#link').parent().parent().hide();
            }

            $('input[name="is_button_available"]').on('change', function () {
                if ($(this).val() == {{ \App\Models\Slider::IS_BUTTON_AVAILABLE_YES }}) {
                    $('#button_text').parent().parent().show();
                    $('#link').parent().parent().show();
                } else {
                    $('#button_text').parent().parent().hide();
                    $('#link').parent().parent().hide();
                }
            });
        });
    </script>
@endpush


