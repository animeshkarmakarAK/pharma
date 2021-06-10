@php
    $edit = !empty($organization->id);
@endphp

@extends('master::layouts.master')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card card-outline">
                    <div class="card-header text-primary custom-bg-gradient-info">
                        <h3 class="card-title font-weight-bold text-primary">{{ ! $edit ? 'Add Organization' : 'Update Organization' }}</h3>

                        <div class="card-tools">
                            @can('viewAny', \Module\GovtStakeholder\App\Models\Organization::class)
                                <a href="{{route('admin.organizations.index')}}"
                                   class="btn btn-sm btn-outline-primary btn-rounded">
                                    <i class="fas fa-backward"></i> Back to list
                                </a>
                            @endcan
                        </div>

                    </div>

                    <div class="card-body">
                        <form class="row edit-add-form" method="post"
                              enctype="multipart/form-data"
                              action="{{ $edit ? route('admin.organizations.update', [$organization->id]) : route('admin.organizations.store')}}">
                            @csrf
                            @if($edit)
                                @method('put')
                            @endif
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="title_en">{{ __('Organization Name') . '(English)' }}<span
                                            style="color: red"> * </span></label>
                                    <input type="text" class="form-control" id="title_en"
                                           name="title_en"
                                           value="{{ $edit ? $organization->title_en : old('title_en') }}"
                                           placeholder="{{ __('Name') }}">
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="title_bn">{{ __('Organization Name') . '(Bangla)' }}<span
                                            style="color: red"> * </span></label>
                                    <input type="text" class="form-control" id="title_bn"
                                           name="title_bn"
                                           value="{{ $edit ? $organization->title_bn : old('title_bn') }}"
                                           placeholder="{{ __('Name') }}">
                                </div>
                            </div>


                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="domain">{{ __('Domain') }}<span
                                            style="color: red"> * </span></label>
                                    <input type="text" class="form-control" id="domain"
                                           name="domain"
                                           value="{{ $edit ? $organization->domain : old('domain') }}"
                                           placeholder="{{ __('Domain') }}">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="fax_no">{{ __('Organization Fax ') }}</label>
                                    <input type="text" class="form-control" id="fax_no"
                                           name="fax_no"
                                           value="{{ $edit ? $organization->fax_no : old('fax_no') }}"
                                           placeholder="{{ __('fax_no') }}">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="email">{{ __('Email') }}<span
                                            style="color: red"> * </span></label>
                                    <input type="text" class="form-control" id="email"
                                           name="email"
                                           value="{{ $edit ? $organization->email : old('email') }}"
                                           placeholder="{{ __('Email') }}">
                                </div>
                            </div>


                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="primary_mobile">{{ __('Mobile') }}<span
                                            style="color: red"> * </span></label>
                                    <input type="text" class="form-control" id="mobile"
                                           name="mobile"
                                           value="{{ $edit ? $organization->mobile : old('mobile') }}"
                                           placeholder="{{ __('Mobile') }}">
                                </div>
                            </div>


                            <div class="form-group col-md-6">
                                <label for="institute_id">Organization Type <span style="color: red">*</span></label>
                                <select class="form-control select2-ajax-wizard"
                                        name="organization_type_id"
                                        id="organization_type_id"
                                        data-model="{{base64_encode(\Module\GovtStakeholder\App\Models\OrganizationType::class)}}"
                                        data-label-fields="{title_en}"
                                        @if($edit)
                                        data-preselected-option="{{json_encode(['text' =>  $organization->organizationType->title_en, 'id' =>  $organization->organizationType->id])}}"
                                        @endif
                                        data-placeholder="Select option"
                                >
                                    <option selected disabled>Select Institute</option>
                                </select>
                            </div>


                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="contact_person_name">{{ __('Contact Person Name') }}<span
                                            style="color: red"> * </span></label>
                                    <input type="text" class="form-control" id="contact_person_name"
                                           name="contact_person_name"
                                           value="{{ $edit ? $organization->contact_person_name : old('contact_person_name') }}"
                                           placeholder="{{ __('Contact Person Name') }}">
                                </div>
                            </div>


                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="contact_person_mobile">{{ __('Contact Person Mobile') }}<span
                                            style="color: red"> * </span></label>
                                    <input type="text" class="form-control" id="contact_person_mobile"
                                           name="contact_person_mobile"
                                           value="{{ $edit ? $organization->contact_person_mobile : old('contact_person_mobile') }}"
                                           placeholder="{{ __('Contact Person Mobile') }}">
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="contact_person_email">{{ __('Contact Person Email') }}<span
                                            style="color: red"> * </span></label>
                                    <input type="text" class="form-control" id="contact_person_email"
                                           name="contact_person_email"
                                           value="{{ $edit ? $organization->contact_person_email : old('contact_person_email') }}"
                                           placeholder="{{ __('Contact Person Email') }}">
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="contact_person_designation">{{ __('Contact Person Designation') }}<span
                                            style="color: red"> * </span></label>
                                    <input type="text" class="form-control" id="contact_person_designation"
                                           name="contact_person_designation"
                                           value="{{ $edit ? $organization->contact_person_designation : old('contact_person_designation') }}"
                                           placeholder="{{ __('Contact Person Designation') }}">
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="address">{{ __('Address') }}<span
                                            style="color: red"> * </span></label>
                                    <textarea class="form-control" id="address" name="address"
                                              rows="3">{{ $edit ? $organization->address : old('address') }}</textarea>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="description">{{ __('Description') }}</label>
                                    <textarea class="form-control" id="description" name="description"
                                              rows="3">{{ $edit ? $organization->description : old('description') }}</textarea>

                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="logo">{{ __('Logo') }} <span style="color: red"> * </span></label>
                                    <div class="input-group">
                                        <div class="logo-upload-section">
                                            <div class="avatar-preview text-center">
                                                <label for="logo">
                                                    <img class="figure-img"
                                                         src={{ $edit && $organization->logo ? asset('storage/'. $organization->logo) :  "https://via.placeholder.com/350x350?text=Organization+Logo"}}
                                                             width="200" height="200"
                                                         alt="logo"/>
                                                    <span class="p-1 bg-gray"
                                                          style="position: relative; right: 0; bottom: 50%; border: 2px solid #afafaf; border-radius: 50%;margin-left: -31px; overflow: hidden">
                                                        <i class="fa fa-pencil-alt text-white"></i>
                                                    </span>
                                                </label>
                                            </div>
                                            <input type="file" name="logo" style="display: none"
                                                   id="logo">
                                        </div>
                                    </div>
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
    <x-generic-validation-error-toastr></x-generic-validation-error-toastr>

    <script>
        const EDIT = !!'{{$edit}}';


        const editAddForm = $('.edit-add-form');

        $.validator.addMethod(
            "logoSize",
            function (value, element) {
                let isHeightMatched = $('.avatar-preview').find('img')[0].naturalHeight === 80;
                let isWidthMatched = $('.avatar-preview').find('img')[0].naturalWidth === 80;
                return this.optional(element) || (isHeightMatched && isWidthMatched);
            },
            "Invalid logo size. Size must be 80 * 80",
        );

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
                    maxlength: 191
                },
                title_bn: {
                    required: true,
                    pattern: "^[\\s-'\u0980-\u09ff]{1,255}$",
                    maxlength: 191
                },
                domain: {
                    required: true,
                    pattern: /^(http|https):\/\/[a-zA-Z-\-\.0-9]+$/,
                    maxlength: 191
                },
                description: {
                    required: true,
                    maxlength: 255
                },
                organization_type_id: {
                    required: true,
                },
                fax_no: {
                    maxlength: 50,
                    pattern: /^\+?[0-9]{6,}$/
                },
                contact_person_designation: {
                    required: true,
                    maxlength: 191,
                },
                contact_person_email: {
                    required: true,
                    pattern: /\S+@\S+\.\S+/
                },
                contact_person_mobile: {
                    required: true,
                },
                contact_person_name: {
                    required: true,
                },

                mobile: {
                    required: true,
                    pattern: /^(?:\+88|88)?(01[3-9]\d{8})$/,
                },
                email: {
                    required: true,
                    pattern: /^[^\s@]+@[^\s@]+$/
                },
                logo: {
                    required: !EDIT,
                    accept: 'image/*',
                    logoSize: true,
                },
                address: {
                    required: true,
                    maxlength: 191
                }
            },
            messages: {
                title_bn: {
                    pattern: "Please fill this field in Bangla."
                },
            },
            submitHandler: function (htmlForm) {
                $('.overlay').show();
                htmlForm.submit();
            }
        });
        $(document).ready(function () {

            function readURL(input) {
                if (input.files && input.files[0]) {
                    let reader = new FileReader();
                    reader.onload = function (e) {
                        $(input).parent().find('.avatar-preview img').attr('src', e.target.result);
                    }
                    reader.readAsDataURL(input.files[0]); // convert to base64 string
                }
            }

            $("#logo").change(function () {
                readURL(this); //preview image
                editAddForm.validate().element("#logo");
            });

        });

    </script>
@endpush
