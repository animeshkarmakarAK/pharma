@php
    $currentInstitute = domainConfig('institute');
    $layout = $currentInstitute ? 'master::layouts.custom1' : 'master::layouts.front-end';
@endphp

@extends($layout)

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header custom-bg-gradient-info">
                        <h1 class="text-center text-primary">প্রশিক্ষণ বাস্তবায়ন সময়সূচি</h1>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">

                        @php
                            $year = ( date('m') > 6) ? date('Y') + 1 : date('Y');
                        @endphp
                        <div class="col-md-12">
                            <h3 class="text-center">প্রশিক্ষণ বাস্তবায়ন
                                সময়সূচি {{ (date('m') > 6) ? date('Y').'-'.date('Y')+1 : (date('Y')-1) .'-'.date('Y') }}</h3>
                        </div>
                        <div class="col-md-12">
                            <div>
                                <table
                                    class="table table-responsive table-bordered table-hover floatThead-table table-fixed">
                                    <thead class="sticky-top" style="background: #f4f6f9">
                                    <tr>
                                        <th rowspan="2" style="vertical-align: middle">ক্রমিক নং</th>
                                        <th rowspan="2" style="vertical-align: middle">ট্রেডের নাম</th>
                                        <th colspan="12" rowspan="1"><p class="text-center">মাস</p></th>
                                        <th rowspan="2" style="vertical-align: middle">বাৎসরিক প্রশিক্ষণ লক্ষ্যমাত্রা
                                        </th>
                                        <th rowspan="2" style="vertical-align: middle">প্রশিক্ষণের ধরন</th>
                                        <th rowspan="2" style="vertical-align: middle">প্রশিক্ষণ ভেনু</th>
                                        <th rowspan="2" style="vertical-align: middle">ভেনু বিস্তারিত</th>
                                    </tr>
                                    <tr>
                                        <th>জুলাই<br>{{ $year-1 }}</th>
                                        <th>অগাস্ট<br>{{ $year-1 }}</th>
                                        <th>সেপ্টেম্:<br>{{ $year-1 }}</th>
                                        <th>অক্টো:<br>{{ $year-1 }}</th>
                                        <th>নভে:<br>{{ $year-1 }}</th>
                                        <th>ডিসে:<br>{{ $year-1 }}</th>
                                        <th>জানু:<br>{{ $year}}</th>
                                        <th>ফেব্রু:<br>{{ $year}}</th>
                                        <th>মার্চ<br>{{ $year}}</th>
                                        <th>এপ্রিল<br>{{ $year}}</th>
                                        <th>মে<br>{{ $year}}</th>
                                        <th>জুন<br>{{ $year}}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @php
                                    $sl = 0;
                                    @endphp
                                    @foreach($courses as $key => $course)
                                        <tr>
                                            <th class="align-middle" rowspan="{{ count($course)+1 }}">{{ ++$sl }}</th>
                                            <th colspan="5">{{ $totalCourseVenue[$key]->course_name }}</th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th class="align-middle" rowspan="{{ count($course)+1 }}">
                                                {{ $totalAnnualTrainingTarget[$totalCourseVenue[$key]->course_id] }}
                                            </th>
                                            <th class="align-middle"
                                                rowspan="{{ count($course)+1 }}"> {{ $totalCourseVenue[$key]->course_fee?'আবাসিক':'অনাবাসিক' }}</th>
                                            <th class="align-middle"
                                                rowspan="{{ count($course)+1 }}">{{ $totalCourseVenue[$key]? $totalCourseVenue[$key]->total_venue :'0' }}
                                                টি কেন্দ্র
                                            </th>
                                            <th class="align-middle" rowspan="{{ count($course)+1 }}">
                                                <a href="{{ route('course_management::venue-list',$totalCourseVenue[$key]->course_id ) }}">বিস্তারিত</a>
                                            </th>
                                        </tr>
                                        @foreach($course as $courseSession)
                                            <tr>
                                                <th style="font-size: 12px">{{ $totalCourseVenue[$key]->course_name }}
                                                    (Session-{{  $courseSession->number_of_batches}})
                                                </th>
                                                <th>{{ date('m', strtotime($courseSession->application_start_date))==7 && date('Y', strtotime($courseSession->application_start_date))==date('Y')? date('d', strtotime($courseSession->application_start_date)) :'' }}</th>
                                                <th>{{ date('m', strtotime($courseSession->application_start_date))==8 && date('Y', strtotime($courseSession->application_start_date))==date('Y')? date('d', strtotime($courseSession->application_start_date)) :'' }}</th>
                                                <th>{{ date('m', strtotime($courseSession->application_start_date))==9 && date('Y', strtotime($courseSession->application_start_date))==date('Y')? date('d', strtotime($courseSession->application_start_date)) :'' }}</th>
                                                <th>{{ date('m', strtotime($courseSession->application_start_date))==10 && date('Y', strtotime($courseSession->application_start_date))==date('Y')? date('d', strtotime($courseSession->application_start_date)) :'' }}</th>
                                                <th>{{ date('m', strtotime($courseSession->application_start_date))==11 && date('Y', strtotime($courseSession->application_start_date))==date('Y')? date('d', strtotime($courseSession->application_start_date)) :'' }}</th>
                                                <th>{{ date('m', strtotime($courseSession->application_start_date))==12 && date('Y', strtotime($courseSession->application_start_date))==date('Y')? date('d', strtotime($courseSession->application_start_date)) :'' }}</th>
                                                <th>{{ date('m', strtotime($courseSession->application_start_date))==1 && date('Y', strtotime($courseSession->application_start_date))==date('Y')+1? date('d', strtotime($courseSession->application_start_date)) :'' }}</th>
                                                <th>{{ date('m', strtotime($courseSession->application_start_date))==2  && date('Y', strtotime($courseSession->application_start_date))==date('Y')+1? date('d', strtotime($courseSession->application_start_date)) :'' }}</th>
                                                <th>{{ date('m', strtotime($courseSession->application_start_date))==3  && date('Y', strtotime($courseSession->application_start_date))==date('Y')+1? date('d', strtotime($courseSession->application_start_date)) :'' }}</th>
                                                <th>{{ date('m', strtotime($courseSession->application_start_date))==4  && date('Y', strtotime($courseSession->application_start_date))==date('Y')+1? date('d', strtotime($courseSession->application_start_date)) :'' }}</th>
                                                <th>{{ date('m', strtotime($courseSession->application_start_date))==5  && date('Y', strtotime($courseSession->application_start_date))==date('Y')+1? date('d', strtotime($courseSession->application_start_date)) :'' }}</th>
                                                <th>{{ date('m', strtotime($courseSession->application_start_date))==6  && date('Y', strtotime($courseSession->application_start_date))==date('Y')+1? date('d', strtotime($courseSession->application_start_date)) :'' }}</th>
                                            </tr>
                                        @endforeach
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@push('css')
    <style>


    </style>
@endpush
@push('js')


@endpush
