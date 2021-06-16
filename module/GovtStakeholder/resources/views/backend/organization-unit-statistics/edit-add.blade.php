@php
    $edit = !empty($organizationUnitStatistics->id) ;
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
                        <h3 class="card-title font-weight-bold">{{ $edit?'Edit Organization Unit Statistic for'.date("M Y", strtotime($organizationUnitStatistics->survey_date)):'Create Organization Unit Statistic For '.date('M Y') }}</h3>
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
                            action="{{$edit ? route('govt_stakeholder::admin.organization-unit-statistics.update', $organizationUnitStatistics->id) : route('govt_stakeholder::admin.organization-unit-statistics.store')}}"
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


                                @foreach($organizationUnits as $index => $organizationUnit)

                                    <tr>
                                        <th scope="row">{{$organizationUnit->title_en}}</th>
                                        <td>
                                            <input type="hidden"
                                                   name="monthly_reports[{{$index}}][organization_unit_id]"
                                                   value="{{$organizationUnit->id}}">
                                            @if($edit &&  !empty($organizationUnit['id']))
                                                <input type="hidden"
                                                       name="monthly_reports[{{$index}}][organization_unit_id]"
                                                       value="{{$organizationUnit->id}}">
                                            @endif
                                            @if($edit &&  !empty($organizationUnit['survey_date']))
                                                <input type="hidden" name="monthly_reports[{{$index}}][survey_date]"
                                                       value="{{$organizationUnit['survey_date']}}">
                                            @endif
                                            <input type="number" class="form-control custom-input-box"
                                                   id="total_new_recruits[{{ $index }}]"
                                                   name="monthly_reports[{{$index}}][total_new_recruits]"
                                                   value="{{ empty($organizationUnit['total_new_recruits']) ? 0 : $organizationUnit['total_new_recruits']}}"
                                                   placeholder="">
                                        </td>

                                        <td><input type="number" class="form-control custom-input-box"
                                                   id="total_new_recruits[{{ $index }}]"
                                                   name="monthly_reports[{{$index}}][total_vacancy]"
                                                   value="{{ empty($organizationUnit['total_vacancy']) ? 0 : $organizationUnit['total_vacancy']}}"
                                                   placeholder="">
                                        </td>

                                        <td><input type="number" class="form-control custom-input-box"
                                                   id="total_new_recruits[{{ $index }}]"
                                                   name="monthly_reports[{{$index}}][total_occupied_position]"
                                                   value="{{ empty($organizationUnit['total_occupied_position']) ? 0 : $organizationUnit['total_occupied_position']}}"
                                                   placeholder="">
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




