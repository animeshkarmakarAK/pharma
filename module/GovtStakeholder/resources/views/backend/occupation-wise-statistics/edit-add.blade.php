@php
    $edit = !empty($occupationWiseStatistic->id) ;
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
                        <h3 class="card-title font-weight-bold">{{ $edit?'Edit Occupation Wise Statistic':'Create Occupation Wise Statistic'}}</h3>
                        <div class="card-tools">
                            <a href="{{route('govt_stakeholder::admin.occupation-wise-statistics.index')}}"
                               class="btn btn-sm btn-outline-primary btn-rounded">
                                <i class="fas fa-backward"></i> Back to list
                            </a>
                        </div>
                    </div>

                    <!-- /.card-header -->
                    <div class="card-body">
                        <form
                            action="{{$edit ? route('govt_stakeholder::admin.occupation-wise-statistics.update', $occupationWiseStatistic->id) : route('govt_stakeholder::admin.occupation-wise-statistics.store')}}"
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
                                           {{$edit?'disabled':''}}
                                           value="{{!$edit? old('survey_date')?old('survey_date'):'':$occupationWiseStatistic->survey_date}}">
                                </div>
                            </div>



                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th>Occupation</th>
                                    <th>Current Month Skilled Youth</th>
                                    <th>Next Month Skilled Youth</th>
                                </tr>
                                </thead>
                                <tbody>


                                @foreach($occupations as $index=>$occupation)
                                    @php
                                        $statistic = $edit && !empty($occupationWiseStatistics[$occupation->id]) ? $occupationWiseStatistics[$occupation->id] : null;
                                    @endphp

                                    <tr>
                                        <th scope="row">{{$occupation->title_en}}</th>
                                        <td>
                                            <input type="hidden" name="monthly_reports[{{$index}}][occupation_id]"
                                                   value="{{$occupation->id}}">
                                            @if($edit &&  !empty($statistic['id']))
                                                <input type="hidden" name="monthly_reports[{{$index}}][id]"
                                                       value="{{$statistic['id']}}">
                                            @endif
                                            @if($edit &&  !empty($statistic['survey_date']))
                                                <input type="hidden" name="monthly_reports[{{$index}}][survey_date]"
                                                       value="{{$statistic['survey_date']}}">
                                            @endif
                                            <input type="number" class="form-control custom-input-box"
                                                   id="monthly_reports[{{$index}}][current_month_skilled_youth]"
                                                   name="monthly_reports[{{$index}}][current_month_skilled_youth]"
                                                   min="0"
                                                   value="{{
                                                            empty($statistic['current_month_skilled_youth'])
                                                            ? old('monthly_reports.'.$index.'.current_month_skilled_youth')
                                                            ? old('monthly_reports.'.$index.'.current_month_skilled_youth'):0
                                                            :$statistic['current_month_skilled_youth']}}"
                                                   placeholder="">
                                        </td>
                                        <td>
                                            <input type="number" class="form-control custom-input-box"
                                                   id="monthly_reports[{{$index}}][next_month_skill_youth]"
                                                   name="monthly_reports[{{$index}}][next_month_skill_youth]"
                                                   min="0"
                                                   value="{{
                                                            empty($statistic['next_month_skill_youth'])
                                                             ? old('monthly_reports.'.$index.'.next_month_skill_youth')
                                                            ? old('monthly_reports.'.$index.'.next_month_skill_youth'):0
                                                            :$statistic['next_month_skill_youth']}}"
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
                survey_date: {
                    required: true,
                },

            },

            submitHandler: function (htmlForm) {
                $('.overlay').show();
                htmlForm.submit();
            }
        });

    </script>
@endpush




