@php
    $edit = !empty($organizationType->id);
@endphp

@extends('core.main')

@section('content')
    <div class="container-fluid">
        <div class="card card-outline">
            <div class="card-header custom-bg-gradient-info">
                <h3 class="card-title font-weight-bold text-primary">{{!$edit ? 'Add Organization Type': 'Update Organization Type'}}</h3>
                <div class="card-tools">
                    <a href="{{route('admin.organization-types.index')}}"
                       class="btn btn-sm btn-rounded btn-outline-primary">
                        <i class="fas fa-backward"></i> Back to list
                    </a>
                </div>
            </div>

            <div class="card-body">
                <form class="row edit-add-form" method="post"
                      action="{{$edit ? route('admin.organization-types.update', $organizationType->id) : route('admin.organization-types.store')}}"
                      enctype="multipart/form-data">

                    @csrf
                    @if($edit)
                        @method('put')
                    @endif
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="title_en">Title (English) <span class="required"> * </span></label>
                            <input type="text" class="form-control" id="title_en"
                                   name="title_en"
                                   value="{{$edit ? $organizationType->title_en : old('title_en')}}"
                                   placeholder="Title (English)">
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="title_bn">Title (বাংলা) <span style="color: red"> * </span></label>
                            <input type="text" class="form-control" id="title_bn"
                                   name="title_bn"
                                   value="{{$edit ? $organizationType->title_bn : old('title_bn')}}"
                                   placeholder="Title (বাংলা)">
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="is_government">{{ __('Is Government') }}<span
                                    style="color: red"> * </span></label>
                            <div class="custom-control custom-radio col-6">
                                <input class="custom-control-input" type="radio" id="yes"
                                       name="is_government"
                                       value="1"
                                    {{ ($edit && $organizationType->is_government) || (!empty(old('is_government')) && old('is_government') == 1 )  ? 'checked' : '' }}>
                                <label for="yes" class="custom-control-label">Yes</label>
                            </div>
                            <div class="custom-control custom-radio col-6">
                                <input class="custom-control-input" type="radio" id="no"
                                       name="is_government"
                                       value="0"
                                    {{ ($edit && !$organizationType->is_government) || (!empty(old('is_government')) && old('is_government') == 0)   ? 'checked' : '' }}>
                                <label for="no" class="custom-control-label">No</label>
                            </div>
                        </div>
                    </div>
                    @if($edit)
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="row_status">{{ __('Status') }}<span
                                        style="color: red"> * </span></label>
                                <div class="custom-control custom-radio col-sm-6">
                                    <input class="custom-control-input" type="radio" id="active"
                                           name="row_status"
                                           value="1"
                                        {{ ($edit && $organizationType->row_status == \Module\GovtStakeholder\App\Models\OrganizationType::ROW_STATUS_ACTIVE) || (!empty(old('row_status')) && old('row_status') == 1)  ? 'checked' : '' }}>
                                    <label for="active" class="custom-control-label">Active</label>
                                </div>
                                <div class="custom-control custom-radio col-sm-6">
                                    <input class="custom-control-input" type="radio" id="inactive"
                                           name="row_status"
                                           value="0"
                                        {{ ($edit && $organizationType->row_status == \Module\GovtStakeholder\App\Models\OrganizationType::ROW_STATUS_INACTIVE) || (!empty(old('row_status')) && old('row_status') == 0)  ? 'checked' : '' }}>
                                    <label for="inactive" class="custom-control-label">Inactive</label>
                                </div>
                            </div>
                        </div>
                    @endif
                    <div class="col-sm-12 text-right">
                        <button type="submit" class="btn btn-success">{{$edit ? 'Update' : 'Create'}}</button>
                    </div>
                </form>
            </div><!-- /.card-body -->
            <div class="overlay" style="display: none">
                <i class="fas fa-2x fa-sync-alt fa-spin"></i>
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
                    maxlength: 191
                },
                title_bn: {
                    required: true,
                    pattern: "^[\\s-'\u0980-\u09ff]{1,255}$",
                    maxlength: 191
                },
                is_government: {
                    required: true
                },

                row_status: {
                    required: function () {
                        return EDIT;
                    },
                },
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

    </script>
@endpush
