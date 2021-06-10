@php
    $edit = !empty($organizationUnit->id);
@endphp

@extends('master::layouts.master')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card card-outline">
                    <div class="card-header text-primary custom-bg-gradient-info">
                        <h3 class="card-title font-weight-bold text-primary">{{ ! $edit ? 'Add Organization Unit' : 'Update Organization Unit' }}</h3>

                        <div class="card-tools">
                            @can('viewAny', \Module\GovtStakeholder\App\Models\OrganizationUnit::class)
                                <a href="{{route('admin.organization-units.index')}}"
                                   class="btn btn-sm btn-outline-primary btn-rounded">
                                    <i class="fas fa-backward"></i> Back to list
                                </a>
                            @endcan
                        </div>

                    </div>

                    <div class="card-body">
                        <form class="row edit-add-form" method="post"
                              enctype="multipart/form-data"
                              action="{{ $edit ? route('admin.organization-units.update', [$organizationUnit->id]) : route('admin.organization-units.store')}}">
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
                                           value="{{ $edit ? $organizationUnit->title_en : old('title_en') }}"
                                           placeholder="{{ __('Name') }}">
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="title_bn">{{ __('Title') . '(Bangla)' }}<span
                                            style="color: red"> * </span></label>
                                    <input type="text" class="form-control" id="title_bn"
                                           name="title_bn"
                                           value="{{ $edit ? $organizationUnit->title_bn : old('title_bn') }}"
                                           placeholder="{{ __('Name') }}">
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
                                            @if($edit && $organizationUnit->organization)
                                            data-preselected-option="{{json_encode(['text' =>  $organizationUnit->organization->title_en, 'id' => $organizationUnit->organization->id])}}"
                                            @endif
                                            data-placeholder="Select Organization"
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
                                            data-preselected-option="{{json_encode(['text' =>  $organizationUnit->organizationUnitType->title_en, 'id' => $organizationUnit->organizationUnitType->id])}}"
                                            @endif
                                            data-placeholder="Select Organization Unit Type"
                                    >
                                    </select>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="loc_division_id">{{ __('Division') }}<span
                                            class="required"> * </span></label>
                                    <select class="form-control select2-ajax-wizard"
                                            name="loc_division_id"
                                            id="loc_division_id"
                                            data-model="{{base64_encode(\App\Models\LocDivision::class)}}"
                                            data-label-fields="{title_en}"
                                            data-dependent-fields="#loc_district_id|#loc_upazila_id"
                                            @if($edit && $organizationUnit->division)
                                            data-preselected-option="{{json_encode(['text' =>  $organizationUnit->division->title_en, 'id' => $organizationUnit->division->id])}}"
                                            @endif
                                            data-placeholder="Select Division"
                                    >
                                    </select>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="loc_district_id">{{ __('District') }}<span
                                            class="required"> * </span></label>
                                    <select class="form-control select2-ajax-wizard"
                                            name="loc_district_id"
                                            id="loc_district_id"
                                            data-model="{{base64_encode(\App\Models\LocDistrict::class)}}"
                                            data-label-fields="{title_en}"
                                            data-depend-on-optional="loc_division_id"
                                            data-dependent-fields="#loc_upazila_id"
                                            @if($edit && $organizationUnit->district)
                                            data-preselected-option="{{json_encode(['text' =>  $organizationUnit->district->title_en, 'id' => $organizationUnit->district->id])}}"
                                            @endif
                                            data-placeholder="Select District"
                                    >
                                    </select>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="loc_upazila_id">{{ __('Upazila') }}<span
                                            class="required"> * </span></label>
                                    <select class="form-control select2-ajax-wizard"
                                            name="loc_upazila_id"
                                            id="loc_upazila_id"
                                            data-model="{{base64_encode(\App\Models\LocUpazila::class)}}"
                                            data-label-fields="{title_en}"
                                            data-depend-on-optional="loc_division_id|loc_district_id"
                                            @if($edit && $organizationUnit->upazila)
                                            data-preselected-option="{{json_encode(['text' =>  $organizationUnit->upazila->title_en, 'id' => $organizationUnit->upazila->id])}}"
                                            @endif
                                            data-placeholder="Select Upazila"
                                    >
                                    </select>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="address">{{ __('Address') }}</label>
                                    <input type="text" class="form-control" id="address"
                                           name="address"
                                           value="{{ $edit ? $organizationUnit->address : old('address') }}"
                                           placeholder="{{ __('Address') }}">
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="mobile">{{ __('Mobile') }}</label>
                                    <input type="text" class="form-control" id="mobile"
                                           name="mobile"
                                           value="{{ $edit ? $organizationUnit->mobile : old('mobile') }}"
                                           placeholder="{{ __('Mobile') }}">
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="email">{{ __('Email') }}</label>
                                    <input type="email" class="form-control" id="email"
                                           name="email"
                                           value="{{ $edit ? $organizationUnit->email : old('email') }}"
                                           placeholder="{{ __('Email') }}">
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="fax_no">{{ __('Fax Number') }}</label>
                                    <input type="text" class="form-control" id="fax_no"
                                           name="fax_no"
                                           value="{{ $edit ? $organizationUnit->fax_no : old('fax_no') }}"
                                           placeholder="{{ __('Fax Number') }}">
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="contact_person_name">{{ __('Contact Person Name') }}</label>
                                    <input type="text" class="form-control" id="contact_person_name"
                                           name="contact_person_name"
                                           value="{{ $edit ? $organizationUnit->contact_person_name : old('contact_person_name') }}"
                                           placeholder="{{ __('Contact Person Name') }}">
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="contact_person_mobile">{{ __('Contact Person Mobile') }}</label>
                                    <input type="text" class="form-control" id="contact_person_mobile"
                                           name="contact_person_mobile"
                                           value="{{ $edit ? $organizationUnit->contact_person_mobile : old('contact_person_mobile') }}"
                                           placeholder="{{ __('Contact Person Mobile') }}">
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="contact_person_email">{{ __('Contact Person Email') }}</label>
                                    <input type="email" class="form-control" id="contact_person_email"
                                           name="contact_person_email"
                                           value="{{ $edit ? $organizationUnit->contact_person_email : old('contact_person_email') }}"
                                           placeholder="{{ __('Contact Person Email') }}">
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label
                                        for="contact_person_designation">{{ __('Contact Person Designation') }}</label>
                                    <input type="text" class="form-control" id="contact_person_designation"
                                           name="contact_person_designation"
                                           value="{{ $edit ? $organizationUnit->contact_person_designation : old('contact_person_designation') }}"
                                           placeholder="{{ __('Contact Person Designation') }}">
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="employee_size">{{ __('Employee Size') }}<span class="required">*</span></label>
                                    <input type="number" class="form-control" id="employee_size"
                                           name="employee_size"
                                           value="{{ $edit ? $organizationUnit->employee_size : old('employee_size') }}"
                                           placeholder="{{ __('Employee Size') }}">
                                </div>
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
                                                   value="{{ \Module\GovtStakeholder\App\Models\OrganizationUnit::ROW_STATUS_ACTIVE }}"
                                                {{ ($edit && $organizationUnit->row_status == \Module\GovtStakeholder\App\Models\OrganizationUnit::ROW_STATUS_ACTIVE) || (old('row_status') == \Module\GovtStakeholder\App\Models\OrganizationUnit::ROW_STATUS_ACTIVE) ? 'checked' : ''}}>
                                            <label for="organization_unit_active"
                                                   class="custom-control-label">Yes</label>
                                        </div>

                                        <div class="custom-control custom-radio ml-2">
                                            <input class="custom-control-input" type="radio"
                                                   id="organization_unit_inactive"
                                                   name="row_status"
                                                   value="{{ \Module\GovtStakeholder\App\Models\OrganizationUnit::ROW_STATUS_INACTIVE }}"
                                                {{ ($edit && $organizationUnit->row_status == \Module\GovtStakeholder\App\Models\OrganizationUnit::ROW_STATUS_INACTIVE) || (old('row_status') == \Module\GovtStakeholder\App\Models\OrganizationUnit::ROW_STATUS_INACTIVE) ? 'checked' : ''}}>
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
            rules: {
                title_en: {
                    required: true
                },
                title_bn: {
                    required: true,
                    pattern: "^[\\s-'\u0980-\u09ff]{1,255}$",
                },
                organization_id: {
                    required: true,
                },
                organization_unit_id: {
                    required: true,
                },
                loc_division_id: {
                    required: true,
                },
                loc_district_id: {
                    required: true,
                },
                loc_upazila_id: {
                    required: true,
                },
                address: {
                    required: false,
                },
                mobile: {
                    required: false,
                    pattern: /^(?:\+88|88)?(01[3-9]\d{8})$/,
                },
                email: {
                    required: false,
                },
                fax_no: {
                    required: false,
                },
                contact_person_name: {
                    required: false,
                },
                contact_person_mobile: {
                    required: false,
                    pattern: /^(?:\+88|88)?(01[3-9]\d{8})$/,
                },
                contact_person_email: {
                    required: false,
                },
                contact_person_designation: {
                    required: false,
                },
                employee_size: {
                    required: true,
                    min: 0,
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


