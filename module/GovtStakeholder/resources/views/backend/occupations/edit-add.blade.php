@php
    $edit = !empty($occupation->id);
@endphp

@extends('master::layouts.master')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card card-outline">
                    <div class="card-header text-primary custom-bg-gradient-info">
                        <h3 class="card-title font-weight-bold text-primary">{{ ! $edit ? 'Add Occupation' : 'Update Occupation' }}</h3>

                        <div class="card-tools">
                            @can('viewAny', \Module\GovtStakeholder\App\Models\Occupation::class)
                                <a href="{{route('govt_stakeholder::admin.occupations.index')}}"
                                   class="btn btn-sm btn-outline-primary btn-rounded">
                                    <i class="fas fa-backward"></i> Back to list
                                </a>
                            @endcan
                        </div>

                    </div>

                    <div class="card-body">
                        <form class="row edit-add-form" method="post"
                              enctype="multipart/form-data"
                              action="{{ $edit ? route('govt_stakeholder::admin.occupations.update', [$occupation->id]) : route('govt_stakeholder::admin.occupations.store')}}">
                            @csrf
                            @if($edit)
                                @method('put')
                            @endif
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="title_en">{{ __('Occupation Name') . '(English)' }}<span
                                            style="color: red"> * </span></label>
                                    <input type="text" class="form-control" id="title_en"
                                           name="title_en"
                                           value="{{ $edit ? $occupation->title_en : old('title_en') }}"
                                           placeholder="{{ __('Name') }}">
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="title_bn">{{ __('Occupation Name') . '(Bangla)' }}<span
                                            style="color: red"> * </span></label>
                                    <input type="text" class="form-control" id="title_bn"
                                           name="title_bn"
                                           value="{{ $edit ? $occupation->title_bn : old('title_bn') }}"
                                           placeholder="{{ __('Name') }}">
                                </div>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="institute_id">Job Sector <span style="color: red">*</span></label>
                                <select class="form-control select2-ajax-wizard"
                                        name="job_sector_id"
                                        id="job_sector_id"
                                        data-model="{{base64_encode(\Module\GovtStakeholder\App\Models\JobSector::class)}}"
                                        data-label-fields="{title_en}"
                                        @if($edit)
                                        data-preselected-option="{{json_encode(['text' =>  $occupation->jobSector->title_en, 'id' =>  $occupation->jobSector->id])}}"
                                        @endif
                                        data-placeholder="নির্বাচন করুন"
                                >
                                </select>
                            </div>

                            @if($edit)
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="row_status">Active Status<span class="required">*</span>
                                            :</label>
                                        <div class="custom-control custom-radio ml-2">
                                            <input class="custom-control-input" type="radio"
                                                   id="organization_unit_active"
                                                   name="row_status"
                                                   value="{{ \Module\GovtStakeholder\App\Models\Occupation::ROW_STATUS_ACTIVE }}"
                                                {{ ($edit && $occupation->row_status == \Module\GovtStakeholder\App\Models\Occupation::ROW_STATUS_ACTIVE) || (old('row_status') == \Module\GovtStakeholder\App\Models\Occupation::ROW_STATUS_ACTIVE) ? 'checked' : ''}}>
                                            <label for="organization_unit_active"
                                                   class="custom-control-label">Yes</label>
                                        </div>

                                        <div class="custom-control custom-radio ml-2">
                                            <input class="custom-control-input" type="radio"
                                                   id="organization_unit_inactive"
                                                   name="row_status"
                                                   value="{{ \Module\GovtStakeholder\App\Models\Occupation::ROW_STATUS_INACTIVE }}"
                                                {{ ($edit && $occupation->row_status == \Module\GovtStakeholder\App\Models\Occupation::ROW_STATUS_INACTIVE) || (old('row_status') == \Module\GovtStakeholder\App\Models\Occupation::ROW_STATUS_INACTIVE) ? 'checked' : ''}}>
                                            <label for="organization_unit_inactive"
                                                   class="custom-control-label">No</label>
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
                    maxlength: 191
                },
                title_bn: {
                    required: true,
                    pattern: "^[\\s-'\u0980-\u09ff]{1,255}$",
                    maxlength: 191
                },

                job_sector_id: {
                    required: true,
                },
                row_status: {
                    required: EDIT
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
