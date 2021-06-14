@php
    $edit = !empty($upazilaJobStatistic->id);
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
                        <h3 class="card-title font-weight-bold">{{ $edit?'Edit Upazila Job Statistic':'Create Upazila Job Statistic' }}</h3>
                        <div class="card-tools">
                            <a href="{{route('govt_stakeholder::admin.upazila-job-statistics.index')}}"
                               class="btn btn-sm btn-outline-primary btn-rounded">
                                <i class="fas fa-backward"></i> Back to list
                            </a>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <form
                            action="{{$edit ? route('govt_stakeholder::admin.upazila-job-statistics.update', $upazilaJobStatistic->id) : route('govt_stakeholder::admin.upazila-job-statistics.store')}}"
                            method="POST" class="row edit-add-form">
                            @csrf
                            @if($edit)
                                @method('put')
                            @endif

                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="survey_date">{{ __('Survey Date') }} <span
                                            style="color: red">*</span></label>
                                    <input type="text"
                                           class="form-control flat-month"
                                           name="survey_date"
                                           id="survey_date"
                                           value="{{$edit ? $upazilaJobStatistic->survey_date : old('survey_date')}}">
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="loc_upazila_id">{{ __('Upazila') }} <span
                                            style="color: red">*</span></label>
                                    <select class="form-control select2-ajax-wizard"
                                            name="loc_upazila_id"
                                            id="loc_upazila_id"
                                            data-model="{{base64_encode(\App\Models\LocUpazila::class)}}"
                                            data-label-fields="{title_en}"
                                            @if($edit)
                                            data-preselected-option="{{json_encode(['text' =>  $upazilaJobStatistic->LocUpazila->title_en, 'id' =>  $upazilaJobStatistic->loc_upazila_id])}}"
                                            @endif
                                            data-placeholder="Select option"
                                    >
                                        <option selected disabled>Select Upazila</option>
                                    </select>

                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="job_sector_id">{{ __('Job Sector') }} <span style="color: red">*</span></label>
                                    <select class="form-control select2-ajax-wizard"
                                            name="job_sector_id"
                                            id="job_sector_id"
                                            data-model="{{base64_encode(\Module\GovtStakeholder\App\Models\JobSector::class)}}"
                                            data-label-fields="{title_en}"
                                            @if($edit)
                                            data-preselected-option="{{json_encode(['text' =>  $upazilaJobStatistic->jobSector->title_en, 'id' =>  $upazilaJobStatistic->job_sector_id])}}"
                                            @endif
                                            data-placeholder="Select option"
                                    >
                                        <option selected disabled>Select Job Sector</option>
                                    </select>

                                </div>
                            </div>

                            <div class="survey_data row" id="survey_data" style="display: none">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="total_unemployed">{{ __('Total Unemployed') }} <span
                                                style="color: red">*</span></label>
                                        <input type="text" class="form-control custom-input-box" id="total_unemployed"
                                               name="total_unemployed"
                                               value="{{$edit ? $upazilaJobStatistic->total_unemployed : old('total_unemployed')}}"
                                               placeholder="{{ __('Total Unemployed') }}">

                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="total_employed">{{ __('Total Employed') }} <span style="color: red">*</span></label>
                                        <input type="text" class="form-control custom-input-box" id="total_employed"
                                               name="total_employed"
                                               value="{{$edit ? $upazilaJobStatistic->total_employed : old('total_employed')}}"
                                               placeholder="{{ __('Total Employed') }}">

                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="total_vacancy">{{ __('Total Vacancy') }} <span
                                                style="color: red">*</span></label>
                                        <input type="text" class="form-control custom-input-box" id="total_vacancy"
                                               name="total_vacancy"
                                               value="{{$edit ? $upazilaJobStatistic->total_vacancy : old('total_vacancy')}}"
                                               placeholder="{{ __('Total Vacancy') }}">

                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="total_new_recruitment">{{ __('Total New Recruitment') }} <span
                                                style="color: red">*</span></label>
                                        <input type="text" class="form-control custom-input-box"
                                               id="total_new_recruitment"
                                               name="total_new_recruitment"
                                               value="{{$edit ? $upazilaJobStatistic->total_new_recruitment : old('total_new_recruitment')}}"
                                               placeholder="{{ __('Total New Recruitment') }}">

                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="total_new_skilled_youth">{{ __('Total New Skilled Youth') }} <span
                                                style="color: red">*</span></label>
                                        <input type="text" class="form-control custom-input-box"
                                               id="total_new_skilled_youth"
                                               name="total_new_skilled_youth"
                                               value="{{$edit ? $upazilaJobStatistic->total_new_skilled_youth : old('total_new_skilled_youth')}}"
                                               placeholder="{{ __('Total New Skilled Youth') }}">

                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="total_skilled_youth">{{ __('Total Skilled Youth') }} <span
                                                style="color: red">*</span></label>
                                        <input type="text" class="form-control custom-input-box"
                                               id="total_skilled_youth"
                                               name="total_skilled_youth"
                                               value="{{$edit ? $upazilaJobStatistic->total_skilled_youth : old('total_skilled_youth')}}"
                                               placeholder="{{ __('Total Skilled Youth') }}">

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
                                                {{ ($edit && $upazilaJobStatistic->row_status == \Module\GovtStakeholder\App\Models\JobSector::ROW_STATUS_ACTIVE) || (!empty(old('row_status')) && old('row_status') == 1)  ? 'checked' : '' }}>
                                            <label for="active" class="custom-control-label">Active</label>
                                        </div>
                                        <div class="custom-control custom-radio col-sm-6">
                                            <input class="custom-control-input" type="radio" id="inactive"
                                                   name="row_status"
                                                   value="0"
                                                {{ ($edit && $upazilaJobStatistic->row_status == \Module\GovtStakeholder\App\Models\JobSector::ROW_STATUS_INACTIVE) || (!empty(old('row_status')) && old('row_status') == 0)  ? 'checked' : '' }}>
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
    @push('css')
        <style>
            #survey_date-error {
                position: absolute;
                left: 8px;
                bottom: -7px;
            }
        </style>
    @endpush
@endsection
@push('js')
    <x-generic-validation-error-toastr></x-generic-validation-error-toastr>

    <script>
        const EDIT = !!'{{$edit}}';

        const editAddForm = $('.edit-add-form');
        editAddForm.validate({
            rules: {
                loc_upazila_id: {
                    required: true
                },
                job_sector_id: {
                    required: true,
                },
                total_unemployed: {
                    required: true,
                    number: true,
                    min: 1,
                },
                total_employed: {
                    required: true,
                    number: true,
                    min: 1,
                },
                total_vacancy: {
                    required: true,
                    number: true,
                    min: 1,
                },
                total_new_recruitment: {
                    required: true,
                    number: true,
                    min: 1,
                },
                total_new_skilled_youth: {
                    required: true,
                    number: true,
                    min: 1,
                },
                total_skilled_youth: {
                    required: true,
                    number: true,
                    min: 1,
                },
                survey_date: {
                    required: true,
                    date: true
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


        $('#job_sector_id').on('change', function () {
            let date = $('#survey_date').val();
            let d = new Date(date);
            let preMonth = d.getMonth();
            let currentYear = d.getFullYear();
            let locUpazilaId = $('#loc_upazila_id').val();
            let jobSectorId = $('#job_sector_id').val();
            $('#survey_data').show();

            const filters = {};
            filters['loc_upazila_id'] = {
                value: locUpazilaId
            };
            filters["job_sector_id"] = {
                value: jobSectorId
            };
            filters["survey_date"] = {
                value: currentYear+'-'+preMonth+'-'+"01"
            };

            $.ajax({
                type: 'post',
                url: '{{route('web-api.model-resources')}}',
                data: {
                    resource: {
                        model: "{{base64_encode(\Module\GovtStakeholder\App\Models\UpazilaJobStatistic::class)}}",
                        columns: 'loc_upazila_id|job_sector_id|survey_date',
                        filters,
                    }
                }
            }).then(function (res) {
                console.log(res);
            });
        });
    </script>
@endpush




