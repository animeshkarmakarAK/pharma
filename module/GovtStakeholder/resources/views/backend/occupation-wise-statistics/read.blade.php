@php
    /** @var \App\Models\User $authUser */
    $authUser = \App\Helpers\Classes\AuthHelper::getAuthUser();
@endphp
@extends('master::layouts.master')

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-header text-primary custom-bg-gradient-info">
                <h3 class="card-title font-weight-bold">Occupation Wise Statistic For {{date("M Y", strtotime($occupationWiseStatistic->survey_date))}}</h3>

                <div class="card-tools">
                    <div class="btn-group">
                        <a href="{{route('govt_stakeholder::admin.occupation-wise-statistics.edit', [$occupationWiseStatistic->id])}}"
                           class="btn btn-sm btn-outline-primary btn-rounded">
                            <i class="fas fa-plus-circle"></i> {{ __('Edit Occupation Wise Statistic') }}
                        </a>
                        <a href="{{route('govt_stakeholder::admin.occupation-wise-statistics.index')}}"
                           class="btn btn-sm btn-outline-primary btn-rounded">
                            <i class="fas fa-backward"></i> {{ __('Back to list') }}
                        </a>
                    </div>
                </div>
            </div>

            <div class="row card-body">

                <table class="table table-bordered">
                    <thead>
                    <tr class="text-primary custom-bg-gradient-info">
                        <th>Occupation</th>
                        <th>Current Month Skilled Youth</th>
                        <th>Next Month Skilled Youth</th>
                    </tr>
                    </thead>
                    <tbody>


                    @foreach($occupationWiseStatistics as $index=>$occupationWiseStatisticData)
                        <tr>
                            <th scope="row">{{$occupationWiseStatisticData->occupation->title_en}}</th>
                            <td>{{$occupationWiseStatisticData->current_month_skilled_youth}}</td>
                            <td>{{$occupationWiseStatisticData->next_month_skill_youth}}</td>
                        </tr>


                    @endforeach

                    </tbody>
                </table>

            </div>
        </div>
    </div>
@endsection
