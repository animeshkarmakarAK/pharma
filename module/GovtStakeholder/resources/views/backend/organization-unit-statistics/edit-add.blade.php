@php
    $edit = !empty($organizationUnitStatistic->id);
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
                        <h3 class="card-title font-weight-bold">{{ $edit?'Edit Organization Unit Statistic for'.date("M Y", strtotime($organizationUnitStatistic->survey_date)):'Create Organization Unit Statistic For '.date('M Y') }}</h3>
                        <div class="card-tools">
                            <a href="{{route('govt_stakeholder::admin.organization-unit-statistics.index')}}"
                               class="btn btn-sm btn-outline-primary btn-rounded">
                                <i class="fas fa-backward"></i> Back to list
                            </a>
                        </div>
                    </div>

                    <!-- /.card-header -->
                    <div class="card-body">
                        <form
                            action="{{$edit ? route('govt_stakeholder::admin.organization-unit-statistics.update', $organizationUnitStatistic->id) : route('govt_stakeholder::admin.organization-unit-statistics.store')}}"
                            method="POST" class="row edit-add-form">
                            @csrf
                            @if($edit)
                                @method('put')
                            @endif
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="survey_date">{{ __('Reporting Date') }} <span
                                            style="color: red">*</span></label>
                                    <input type="text"
                                           class="form-control flat-month"
                                           name="survey_date"
                                           id="survey_date"
                                           value="{{$edit ? $organizationUnitStatistic->survey_date : old('survey_date')}}">
                                </div>
                            </div>


                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th>Organization Unit</th>
                                    <th>New Recruits</th>
                                    <th>Total Vacancy</th>
                                    <th>Total Occupied Position</th>
                                </tr>
                                </thead>
                                <tbody>


                                @foreach($organizationUnits as  $index => $organizationUnit)
                                    @php
                                        $statistic = $edit && !empty($organizationUnitStatistics[$organizationUnit->id]) ? $organizationUnitStatistics[$organizationUnit->id] : null;
                                    @endphp
                                    <tr>
                                        <th scope="row">
                                            {{ $organizationUnit->title_en }}
                                            <input type="hidden" name="monthly_reports[{{$index}}][id]"
                                                   value="{{ $statistic ? $statistic->id : '' }}">
                                            <input type="hidden" name="monthly_reports[{{$index}}][organization_unit_id]"
                                                   value="{{ $organizationUnit->id }}">
                                        </th>
                                        <td>
                                            <input type="number" class="form-control custom-input-box"
                                                   id="total_new_recruits"
                                                   name="monthly_reports[{{$index}}][total_new_recruits]"
                                                   value="{{
                                                            empty($statistic['total_new_recruits'])
                                                            ? old('monthly_reports.'.$index.'.total_new_recruits')
                                                            ? old('monthly_reports.'.$index.'.total_new_recruits'):0
                                                            :$statistic['total_new_recruits']}}">


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
                                                   id="total_occupied_position"
                                                   name="monthly_reports[{{$index}}][total_occupied_position]"

                                                   value="{{
                                                        empty($statistic['total_occupied_position'])
                                                        ? old('monthly_reports.'.$index.'.total_occupied_position')
                                                        ? old('monthly_reports.'.$index.'.total_occupied_position'):0
                                                        :$statistic['total_occupied_position']}}">
                                        </td>
                                    </tr>
                                @endforeach

                                </tbody>
                            </table>


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
                total_vacancy: {
                    required: true,
                    number: true,
                },
                total_occupied_position: {
                    required: true,
                    number: true,
                },
                total_new_recruits: {
                    required: true,
                    number: true,
                },
                survey_date: {
                    required: true,
                }
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




