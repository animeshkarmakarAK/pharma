@php
    $edit = !empty($humanResourceTemplate->id);
@endphp

@extends('master::layouts.master')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card card-outline">
                    <div class="card-header text-primary custom-bg-gradient-info">
                        <h3 class="card-title font-weight-bold text-primary">{{ ! $edit ? 'Add Human Resource Template' : 'Update Human Resource Template' }}</h3>

                        <div class="card-tools">
                            @can('viewAny', \Module\GovtStakeholder\App\Models\HumanResourceTemplate::class)
                                <a href="{{route('govt_stakeholder::admin.human-resource-templates.index')}}"
                                   class="btn btn-sm btn-outline-primary btn-rounded">
                                    <i class="fas fa-backward"></i> Back to list
                                </a>
                            @endcan
                        </div>

                    </div>

                    <div class="card-body">
                        <form class="row edit-add-form" method="post"
                              enctype="multipart/form-data"
                              action="{{ $edit ? route('govt_stakeholder::admin.human-resource-templates.update', $humanResourceTemplate) : route('govt_stakeholder::admin.human-resource-templates.store')}}">
                            @csrf
                            @if($edit)
                                @method('put')
                            @endif
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="title_en">{{ __('Title') . ' (English)' }}<span
                                            style="color: red"> * </span></label>
                                    <input type="text" class="form-control" id="title_en"
                                           name="title_en"
                                           value="{{ $edit ? $humanResourceTemplate->title_en : old('title_en') }}"
                                           placeholder="{{ __('Title') . ' (English)' }}">
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="title_bn">{{ __('Title') . ' (Bangla)' }}<span
                                            style="color: red"> * </span></label>
                                    <input type="text" class="form-control" id="title_bn"
                                           name="title_bn"
                                           value="{{ $edit ? $humanResourceTemplate->title_bn : old('title_bn') }}"
                                           placeholder="{{ __('Title') . ' (Bangla)' }}">
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="organization_id">{{ __('Organization Name') }}<span
                                            class="required"> * </span></label>
                                    <select class="form-control select2-ajax-wizard"
                                            name="organization_id"
                                            id="organization_id"
                                            data-model="{{base64_encode(\Module\GovtStakeholder\App\Models\Organization::class)}}"
                                            data-label-fields="{title_en}"
                                            @if($edit && $humanResourceTemplate->organization)
                                            data-preselected-option="{{json_encode(['text' =>  $humanResourceTemplate->organization->title_en, 'id' => $humanResourceTemplate->organization->id])}}"
                                            @endif
                                            data-placeholder="{{ __('generic.select_placeholder') }}"
                                    >
                                    </select>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="organization_unit_type_id">{{ __('Organization Unit Type') }}<span
                                            class="required"> * </span></label>
                                    <select class="form-control select2-ajax-wizard"
                                            name="organization_unit_type_id"
                                            id="organization_unit_type_id"
                                            data-model="{{base64_encode(\Module\GovtStakeholder\App\Models\OrganizationUnitType::class)}}"
                                            data-label-fields="{title_en}"
                                            @if($edit)
                                            data-preselected-option="{{json_encode(['text' =>  $humanResourceTemplate->organizationUnitType->title_en, 'id' => $humanResourceTemplate->organizationUnitType->id])}}"
                                            @endif
                                            data-placeholder="{{ __('generic.select_placeholder') }}"
                                    >
                                    </select>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="parent_id">{{ __('Parent') }}</label>
                                    <select class="form-control select2-ajax-wizard"
                                            name="parent_id"
                                            id="parent_id"
                                            data-model="{{base64_encode(\Module\GovtStakeholder\App\Models\HumanResourceTemplate::class)}}"
                                            data-label-fields="{title_en}"
                                            @if($edit)
                                            data-filters="{{json_encode(['id' => ['type' => 'not-equal', 'value' => $humanResourceTemplate->id]])}}"
                                            @if($humanResourceTemplate->parent_id)
                                            data-preselected-option="{{json_encode(['text' =>  $humanResourceTemplate->parent->title_en, 'id' => $humanResourceTemplate->parent->id])}}"
                                            @endif
                                            @endif
                                            data-placeholder="{{ __('generic.select_placeholder') }}"
                                    >
                                    </select>
                                    <input type="text" name="parent_id" id="hidden_parent_id" disabled>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="rank_id">{{ __('Rank') }}</label>
                                    <select class="form-control select2-ajax-wizard"
                                            name="rank_id"
                                            id="rank_id"
                                            data-model="{{base64_encode(\Module\GovtStakeholder\App\Models\Rank::class)}}"
                                            data-label-fields="{title_en}"
                                            @if($edit && $humanResourceTemplate->rank)
                                            data-preselected-option="{{json_encode(['text' =>  $humanResourceTemplate->rank->title_en, 'id' => $humanResourceTemplate->rank->id])}}"
                                            @endif
                                            data-placeholder="{{ __('generic.select_placeholder') }}"
                                    >
                                    </select>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="display_order">{{ __('Display Order') }}<span
                                            style="color: red"> * </span></label>
                                    <input type="number" class="form-control" id="display_order"
                                           name="display_order"
                                           value="{{ $edit ? $humanResourceTemplate->display_order : old('display_order') }}"
                                           placeholder="{{ __('Display Order') }}">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="is_designation">Is A Designation?<span class="required">*</span></label>
                                    <div class="custom-control custom-radio">
                                        <input class="custom-control-input" type="radio" id="is_designation_yes"
                                               name="is_designation"
                                               value="1"
                                            {{ ($edit && $humanResourceTemplate->is_designation == 1) || !empty(old('is_designation')) && old('is_designation') == 1 ? 'checked' : '' }}>
                                        <label for="is_designation_yes" class="custom-control-label">Yes</label>
                                    </div>

                                    <div class="custom-control custom-radio">
                                        <input class="custom-control-input" type="radio" id="is_designation_no"
                                               name="is_designation"
                                               value="0"
                                            {{ ($edit && $humanResourceTemplate->is_designation == 0) || !empty(old('is_designation')) && old('is_designation') == 0 ? 'checked' : '' }}>
                                        <label for="is_designation_no"
                                               class="custom-control-label">No</label>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="skill_ids">{{ __('Skills') }}</label>
                                    <select class="form-control select2-ajax-wizard"
                                            multiple="multiple"
                                            name="skill_ids[]"
                                            id="skill_ids"
                                            data-model="{{base64_encode(\Module\GovtStakeholder\App\Models\Skill::class)}}"
                                            data-label-fields="{title_en}"
                                            @if($edit && $humanResourceTemplate->skills)
                                            data-preselected-option="{{json_encode(['text' =>  $humanResourceTemplate->skills->title_en, 'id' => $humanResourceTemplate->skills->id])}}"
                                            @endif
                                            data-placeholder="{{ __('generic.select_placeholder') }}"
                                    >
                                    </select>
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
                    pattern: /^[a-zA-Z0-9 ]*$/,
                },
                title_bn: {
                    required: true,
                    pattern: /^[\s'\u0980-\u09ff]+$/,
                },
                organization_id: {
                    required: true,
                },
                organization_unit_type_id: {
                    required: true,
                },
                "skill_ids[]": {
                    required: false,
                },
                display_order: {
                    required: true,
                    min: 0,
                },
                is_designation: {
                    required: true,
                },
            },
            messages: {
                title_en: {
                    pattern: "This field is required in English.",
                },
                title_bn: {
                    pattern: "This field is required in Bangla.",
                },
            },
            submitHandler: function (htmlForm) {
                $('.overlay').show();
                htmlForm.submit();
            }
        });

        $(document).ready(function () {
            $('#hidden_parent_id').val($('#parent_id').val()).prop('disabled', false);
            $('#parent_id').on('change', function () {
                $('#hidden_parent_id').val($('#parent_id').val()).prop('disabled', false);
            })
        })
    </script>
@endpush

@push('css')
    <style>
        .required {
            color: red;
        }

        #hidden_parent_id {
            display: none;
        }
    </style>
@endpush


