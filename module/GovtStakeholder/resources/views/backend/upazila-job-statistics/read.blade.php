@php
    /** @var \App\Models\User $authUser */
    $authUser = \App\Helpers\Classes\AuthHelper::getAuthUser();
@endphp
@extends('master::layouts.master')

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-header text-primary custom-bg-gradient-info">
                <h3 class="card-title font-weight-bold">Job Sector</h3>

                <div class="card-tools">
                    <div class="btn-group">
                        <a href="{{route('govt_stakeholder::admin.upazila-job-statistics.edit', [$upazilaJobStatistic->id])}}"
                           class="btn btn-sm btn-outline-primary btn-rounded">
                            <i class="fas fa-plus-circle"></i> {{ __('Edit Job Sector') }}
                        </a>
                        <a href="{{route('govt_stakeholder::admin.upazila-job-statistics.index')}}" class="btn btn-sm btn-outline-primary btn-rounded">
                            <i class="fas fa-backward"></i> {{ __('Back to list') }}
                        </a>
                    </div>
                </div>
            </div>

            <div class="row card-body">

                <div class="col-md-6 custom-view-box">
                    <p class="label-text">{{ __('Reporting Month') }}</p>
                    <div class="input-box">
                        {{ $upazilaJobStatistic->survey_date ? \Carbon\Carbon::parse($upazilaJobStatistic->survey_date)->format('d M, Y') : '' }}
                    </div>
                </div>

                <div class="col-md-6 custom-view-box">
                    <p class="label-text">{{ __('Upazila') }}</p>
                    <div class="input-box">
                        {{ $upazilaJobStatistic->LocUpazila->title_en ? $upazilaJobStatistic->LocUpazila->title_en : '' }}
                    </div>
                </div>

                <div class="col-md-12">
                    <table class="table table-bordered">
                        <thead>
                        <tr class="text-primary custom-bg-gradient-info">
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
                                $statistic = !empty($upazilaJobStatistics[$jobSector->id]) ? $upazilaJobStatistics[$jobSector->id] : null;
                            @endphp
                            <tr>
                                <th scope="row">
                                    {{ $jobSector->title_en }}
                                </th>
                                <td class="custom-view-box">
                                    <div class="input-box">
                                        {{$statistic ? $statistic->total_unemployed : 0 }}
                                    </div>

                                </td>
                                <td class="custom-view-box">
                                    <div class="input-box">
                                        {{$statistic ? $statistic->total_employed : 0 }}
                                    </div>
                                </td>
                                <td class="custom-view-box">
                                    <div class="input-box">
                                        {{$statistic ? $statistic->total_vacancy : 0 }}
                                    </div>
                                </td>
                                <td class="custom-view-box">
                                    <div class="input-box">
                                        {{$statistic ? $statistic->total_new_recruitment : 0 }}
                                    </div>
                                </td>
                                <td class="custom-view-box">
                                    <div class="input-box">
                                        {{$statistic ? $statistic->total_new_skilled_youth : 0 }}
                                    </div>
                                </td>
                                <td class="custom-view-box">
                                    <div class="input-box">
                                        {{$statistic ? $statistic->total_skilled_youth : 0 }}
                                    </div>
                                </td>
                            </tr>
                        @endforeach

                        </tbody>
                    </table>
                </div>


            </div>
        </div>
    </div>
@endsection
