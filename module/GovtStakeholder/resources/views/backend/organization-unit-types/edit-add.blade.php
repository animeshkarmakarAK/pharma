@php
    $edit = !empty($organizationUnitType->id);
@endphp

@extends('master::layouts.master')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card card-outline">
                    <div class="card-header text-primary custom-bg-gradient-info">
                        <h3 class="card-title font-weight-bold text-primary">{{ ! $edit ? 'Add Organization Unit Type' : 'Update Organization Unit Type' }}</h3>

                        <div class="card-tools">
                            @can('viewAny', \Module\GovtStakeholder\App\Models\OrganizationUnitType::class)
                                <a href="{{route('govt_stakeholder::admin.organization-unit-types.index')}}"
                                   class="btn btn-sm btn-outline-primary btn-rounded">
                                    <i class="fas fa-backward"></i> Back to list
                                </a>
                            @endcan
                        </div>

                    </div>

                    <div class="card-body">
                        <form class="row edit-add-form" method="post"
                              enctype="multipart/form-data"
                              action="{{ $edit ? route('govt_stakeholder::admin.organization-unit-types.update', $organizationUnitType) : route('govt_stakeholder::admin.organization-unit-types.store')}}">
                            @csrf
                            @if($edit)
                                @method('put')
                            @endif
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="title_en">{{ __('Title') . '(English)' }}<span
                                            style="color: red"> * </span></label>
                                    <input type="text" class="form-control" id="title_en"
                                           name="title_en"
                                           value="{{ $edit ? $organizationUnitType->title_en : old('title_en') }}"
                                           placeholder="{{ __('Name') }}">
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="title_bn">{{ __('Title') . '(Bangla)' }}<span
                                            style="color: red"> * </span></label>
                                    <input type="text" class="form-control" id="title_bn"
                                           name="title_bn"
                                           value="{{ $edit ? $organizationUnitType->title_bn : old('title_bn') }}"
                                           placeholder="{{ __('Name') }}">
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="organization_id">{{ __('Organization') }}<span
                                            class="required"> * </span></label>
                                    <select class="form-control select2-ajax-wizard"
                                            name="organization_id"
                                            id="organization_id"
                                            data-model="{{base64_encode(\Module\GovtStakeholder\App\Models\Organization::class)}}"
                                            data-label-fields="{title_en}"
                                            @if($edit && $organizationUnitType->organization)
                                            data-preselected-option="{{json_encode(['text' =>  $organizationUnitType->organization->title_en, 'id' => $organizationUnitType->organization->id])}}"
                                            @endif
                                            data-placeholder="নির্বাচন করুন"
                                    >
                                    </select>
                                </div>
                            </div>

                            @if($edit)
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="row_status">Active Status<span class="required">*</span>
                                            :</label>
                                        <div class="custom-control custom-radio ml-2">
                                            <input class="custom-control-input" type="radio"
                                                   id="organization_unit_type_active"
                                                   name="row_status"
                                                   value="{{ \Module\GovtStakeholder\App\Models\OrganizationUnitType::ROW_STATUS_ACTIVE }}"
                                                {{ ($edit && $organizationUnitType->row_status == \Module\GovtStakeholder\App\Models\OrganizationUnitType::ROW_STATUS_ACTIVE) || (old('row_status') == \Module\GovtStakeholder\App\Models\OrganizationUnitType::ROW_STATUS_ACTIVE) ? 'checked' : ''}}>
                                            <label for="organization_unit_type_active"
                                                   class="custom-control-label">Yes</label>
                                        </div>

                                        <div class="custom-control custom-radio ml-2">
                                            <input class="custom-control-input" type="radio"
                                                   id="organization_unit_type_inactive"
                                                   name="row_status"
                                                   value="{{ \Module\GovtStakeholder\App\Models\OrganizationUnitType::ROW_STATUS_INACTIVE }}"
                                                {{ ($edit && $organizationUnitType->row_status == \Module\GovtStakeholder\App\Models\OrganizationUnitType::ROW_STATUS_INACTIVE) || (old('row_status') == \Module\GovtStakeholder\App\Models\OrganizationUnitType::ROW_STATUS_INACTIVE) ? 'checked' : ''}}>
                                            <label for="organization_unit_type_inactive"
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
            rules: {
                title_en: {
                    required: true
                },
                title_bn: {
                    required: true,
                    pattern: "^[\\s-'\u0980-\u09ff!@#\$%\^\&*\)\(+=._-]{1,255}$",
                },
                row_status: {
                    required: EDIT
                }
            },
            messages: {
                title_bn: {
                    pattern: "This field is required in Bangla.",
                },
            },
            submitHandler: function (htmlForm) {
                $('.overlay').show();
                htmlForm.submit();
            }
        });
    </script>
@endpush


