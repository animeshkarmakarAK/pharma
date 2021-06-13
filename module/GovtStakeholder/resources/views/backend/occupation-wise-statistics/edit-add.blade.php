@php
    $edit = !empty($occupationWiseStatistic->id);
    /** @var \App\Models\User $authUser */
    $authUser = \App\Helpers\Classes\AuthHelper::getAuthUser();
@endphp

@extends('master::layouts.master')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header text-primary custom-bg-gradient-info">
                        <h3 class="card-title font-weight-bold">{{ $edit?'Edit Occupation Wise Statistic':'Create Occupation Wise Statistic' }}</h3>
                        <div class="card-tools">
                            <a href="{{route('admin.occupation-wise-statistics.index')}}"
                               class="btn btn-sm btn-outline-primary btn-rounded">
                                <i class="fas fa-backward"></i> Back to list
                            </a>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <form
                            action="{{$edit ? route('admin.occupation-wise-statistics.update', $occupationWiseStatistic->id) : route('admin.occupation-wise-statistics.store')}}"
                            method="POST" class="row edit-add-form">
                            @csrf
                            @if($edit)
                                @method('put')
                            @endif

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="institute_id">{{ __('Institute') }} <span
                                            style="color: red">*</span></label>
                                    <select class="form-control select2-ajax-wizard"
                                            name="institute_id"
                                            id="institute_id"
                                            data-model="{{base64_encode(\Module\CourseManagement\App\Models\Institute::class)}}"
                                            data-label-fields="{title_en}"
                                            @if($edit)
                                            data-preselected-option="{{json_encode(['text' =>  $occupationWiseStatistic->institute->title_en, 'id' =>  $occupationWiseStatistic->institute_id])}}"
                                            @endif
                                            data-placeholder="Select option"
                                    >
                                    </select>

                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="occupation_id">{{ __('Occupation') }} <span style="color: red">*</span></label>
                                    <select class="form-control select2-ajax-wizard"
                                            name="occupation_id"
                                            id="occupation_id"
                                            data-model="{{base64_encode(\Module\GovtStakeholder\App\Models\Occupation::class)}}"
                                            data-label-fields="{title_en}"
                                            @if($edit)
                                            data-preselected-option="{{json_encode(['text' =>  $occupationWiseStatistic->occupation->title_en, 'id' =>  $occupationWiseStatistic->occupation_id])}}"
                                            @endif
                                            data-placeholder="Select option"
                                    >
                                    </select>

                                </div>
                            </div>

                            <div class="col-md-12 row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="current_month_skilled_youth">{{ __('Current Month Skilled Youth') }} <span
                                                style="color: red">*</span></label>
                                        <input type="text" class="form-control custom-input-box" id="current_month_skilled_youth"
                                               name="current_month_skilled_youth"
                                               value="{{$edit ? $occupationWiseStatistic->current_month_skilled_youth : old('current_month_skilled_youth')}}"
                                               placeholder="{{ __('Current Month Skilled Youth') }}">

                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="next_month_skill_youth">{{ __('Next Month Skilled Youth') }} <span style="color: red">*</span></label>
                                        <input type="text" class="form-control custom-input-box" id="next_month_skill_youth"
                                               name="next_month_skill_youth"
                                               value="{{$edit ? $occupationWiseStatistic->next_month_skill_youth : old('next_month_skill_youth')}}"
                                               placeholder="{{ __('Next Month Skilled Youth') }}">

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
                                                {{ ($edit && $occupationWiseStatistic->row_status == \Module\GovtStakeholder\App\Models\OccupationWiseStatistic::ROW_STATUS_ACTIVE) || (!empty(old('row_status')) && old('row_status') == 1)  ? 'checked' : '' }}>
                                            <label for="active" class="custom-control-label">Active</label>
                                        </div>
                                        <div class="custom-control custom-radio col-sm-6">
                                            <input class="custom-control-input" type="radio" id="inactive"
                                                   name="row_status"
                                                   value="0"
                                                {{ ($edit && $occupationWiseStatistic->row_status == \Module\GovtStakeholder\App\Models\OccupationWiseStatistic::ROW_STATUS_INACTIVE) || (!empty(old('row_status')) && old('row_status') == 0)  ? 'checked' : '' }}>
                                            <label for="inactive" class="custom-control-label">Inactive</label>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            <div class="col-sm-12 text-right">
                                <button type="submit"
                                        class="btn btn-success">{{ $edit ? __('Update') : __('Add') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div id="test"></div>
    </div>
    @include('master::utils.delete-confirm-modal')
@endsection
@push('js')
    <x-generic-validation-error-toastr></x-generic-validation-error-toastr>

    <script>
        const EDIT = !!'{{$edit}}';

        const editAddForm = $('.edit-add-form');
        editAddForm.validate({
            rules: {
                institute_id: {
                    required: true
                },
                occupation_id: {
                    required: true,
                },
                current_month_skilled_youth: {
                    required: true,
                    number: true,
                },
                next_month_skill_youth: {
                    required: true,
                    number: true,
                },

            },
            messages: {
                title_bn: {
                    pattern: "This field is required in Bangla.",
                }
            },
            submitHandler: function (htmlForm) {
                $('.overlay').show();
                htmlForm.submit();
            }
        });

    </script>
@endpush




