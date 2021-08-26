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

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="survey_date">{{ __('Reporting Month') }} <span
                                            style="color: red">*</span></label>
                                    <input type="text"
                                           class="form-control flat-month"
                                           name="{{ !$edit? 'survey_date':'' }}"
                                           id="survey_date"
                                           value="{{$edit ? $upazilaJobStatistic->survey_date : old('survey_date')}}"
                                        {{ $edit? 'disabled':'' }}
                                    >
                                    @if($edit)
                                        <input type="hidden" name="loc_upazila_id"
                                               value="{{ $upazilaJobStatistic->loc_upazila_id }}">
                                        <input type="hidden" name="survey_date"
                                               value="{{ $upazilaJobStatistic->survey_date }}">
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="loc_upazila_id">{{ __('Upazila') }} <span
                                            style="color: red">*</span></label>
                                    <select class="form-control select2-ajax-wizard"
                                            name="{{ !$edit? 'loc_upazila_id':'' }}"
                                            id="loc_upazila_id"
                                            data-model="{{base64_encode(\App\Models\LocUpazila::class)}}"
                                            data-label-fields="{title_en}"
                                            data-filters="{{json_encode(['loc_district_id' => $authUser->loc_district_id])}}"
                                            @if($edit)
                                            data-preselected-option="{{json_encode(['text' =>  $upazilaJobStatistic->LocUpazila->title_en, 'id' =>  $upazilaJobStatistic->loc_upazila_id])}}"
                                            @endif
                                            data-placeholder="নির্বাচন করুন"
                                        {{ $edit? 'disabled':'' }}
                                    >
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <table class="table table-bordered">
                                    <thead>
                                    <tr>
                                        <th scope="col">Job Sector</th>
                                        <th scope="col">Total Unemployed</th>
                                        <th scope="col">Total Employed</th>
                                        <th scope="col">Total Vacancy</th>
                                        <th scope="col">Total New Recruitment</th>
                                        <th scope="col">Total New Skilled Youth</th>
                                        <th scope="col">Total Skilled Youth</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($jobSectors as  $index=>$jobSector)
                                        @php
                                            $statistic = $edit && !empty($upazilaJobStatistics[$jobSector->id]) ? $upazilaJobStatistics[$jobSector->id] : null;
                                        @endphp
                                        <tr>
                                            <th scope="row">
                                                {{ $jobSector->title_en }}
                                                <input type="hidden" name="monthly_reports[{{$index}}][id]"
                                                       value="{{ $statistic ? $statistic->id : '' }}">
                                                <input type="hidden" name="monthly_reports[{{$index}}][job_sector_id]"
                                                       value="{{ $jobSector->id }}">
                                            </th>
                                            <td>
                                                <input type="number" class="form-control custom-input-box"
                                                       id="total_unemployed"
                                                       name="monthly_reports[{{$index}}][total_unemployed]"
                                                       {{--value="{{$statistic ? $statistic->total_unemployed : 0 }}"--}}
                                                       value="{{
                                                            empty($statistic['total_unemployed'])
                                                            ? old('monthly_reports.'.$index.'.total_unemployed')
                                                            ? old('monthly_reports.'.$index.'.total_unemployed'):0
                                                            :$statistic['total_unemployed']}}">
                                                {{--<span class="text-danger" id="total_unemployed">100</span>--}}


                                            </td>
                                            <td>
                                                <input type="number" class="form-control custom-input-box"
                                                       id="total_employed"
                                                       name="monthly_reports[{{$index}}][total_employed]"
                                                       value="{{
                                                            empty($statistic['total_employed'])
                                                            ? old('monthly_reports.'.$index.'.total_employed')
                                                            ? old('monthly_reports.'.$index.'.total_employed'):0
                                                            :$statistic['total_employed']}}">
                                            </td>
                                            <td>
                                                <input type="number" class="form-control custom-input-box"
                                                       id="total_vacancy"
                                                       name="monthly_reports[{{$index}}][total_vacancy]"

                                                       value="{{
                                                        empty($statistic['total_vacancy'])
                                                        ? old('monthly_reports.'.$index.'.total_vacancy')
                                                        ? old('monthly_reports.'.$index.'.total_vacancy'):0
                                                        :$statistic['total_vacancy']}}">
                                            </td>
                                            <td>
                                                <input type="number" class="form-control custom-input-box"
                                                       id="total_new_recruitment"
                                                       name="monthly_reports[{{$index}}][total_new_recruitment]"
                                                       value="{{
                                                        empty($statistic['total_new_recruitment'])
                                                        ? old('monthly_reports.'.$index.'.total_new_recruitment')
                                                        ? old('monthly_reports.'.$index.'.total_new_recruitment'):0
                                                        :$statistic['total_new_recruitment']}}">
                                            </td>
                                            <td>
                                                <input type="number" class="form-control custom-input-box"
                                                       id="total_new_skilled_youth"
                                                       name="monthly_reports[{{$index}}][total_new_skilled_youth]"
                                                       value="{{
                                                        empty($statistic['total_new_skilled_youth'])
                                                        ? old('monthly_reports.'.$index.'.total_new_skilled_youth')
                                                        ? old('monthly_reports.'.$index.'.total_new_skilled_youth'):0
                                                        :$statistic['total_new_skilled_youth']}}">
                                            </td>
                                            <td>
                                                <input type="number" class="form-control custom-input-box"
                                                       id="total_skilled_youth"
                                                       name="monthly_reports[{{$index}}][total_skilled_youth]"
                                                       value="{{
                                                        empty($statistic['total_skilled_youth'])
                                                        ? old('monthly_reports.'.$index.'.total_skilled_youth')
                                                        ? old('monthly_reports.'.$index.'.total_skilled_youth'):0
                                                        :$statistic['total_skilled_youth']}}">
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
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


        $('#loc_upazila_id').on('change', function () {
            let date = $('#survey_date').val();
            let d = new Date(date);
            let preMonth = d.getMonth();
            let currentYear = d.getFullYear();
            let locUpazilaId = $('#loc_upazila_id').val();
            let jobSectorId = $('#job_sector_id').val();

            const filters = {};
            filters['loc_upazila_id'] = {
                value: locUpazilaId
            };
            filters["job_sector_id"] = {
                value: jobSectorId
            };
            filters["survey_date"] = {
                value: currentYear + '-' + preMonth + '-' + "01"
            };

            $.ajax({
                type: 'post',
                url: '{{route('web-api.model-resources')}}',
                data: {
                    resource: {
                        model: "{{base64_encode(\Module\GovtStakeholder\App\Models\UpazilaJobStatistic::class)}}",
                        columns: 'loc_upazila_id|job_sector_id|survey_date|total_unemployed|total_employed|total_vacancy|total_new_recruitment|total_new_skilled_youth|total_new_skilled_youth|total_skilled_youth',
                        filters,
                    }
                }
            }).then(
                function (res) {
                    let data = JSON.parse(res.data);
                    console.log(data);
                    data = data[0];

                    $("#total_unemployed_old").text(data.total_unemployed);
                    $("#total_employed_old").text(data.total_employed);
                    $("#total_vacancy_old").text(data.total_vacancy);
                    $("#total_new_recruitment_old").text(data.total_new_recruitment);
                    $("#total_new_skilled_youth_old").text(data.total_new_skilled_youth);
                    $("#total_skilled_youth_old").text(data.total_skilled_youth);

                    $(".old_survey_data_area").show();
                },
            ).fail(function (data) {
                $(".old_survey_data_area").css({'display': 'none'});
                console.log("Ajax failed: ");
            });
        });
    </script>
@endpush




