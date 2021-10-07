@php
    $currentInstitute = domainConfig('institute');
    $layout = 'master::layouts.front-end';
@endphp

@extends($layout)

@section('title')
    প্রশিক্ষণ বাস্তবায়ন সময়সূচি
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card mb-2">
                    <div class="card-header custom-bg-gradient-info">
                        @php
                            $year = ( date('m') > 6) ? date('Y') + 1 : date('Y');
                        @endphp
                        <h2 class="text-center text-primary font-weight-lighter">
                            প্রশিক্ষণ বাস্তবায়ন সময়সূচি
                            {{ (date('m') > 6) ? \App\Helpers\Classes\NumberToBanglaWord::engToBn(date('Y').'-'.date('Y')+1) : \App\Helpers\Classes\NumberToBanglaWord::engToBn((date('Y')-1) .'-'.date('Y')) }}
                        </h2>
                    </div>
                    <div class="card-body">
                        <div>
                            <table
                                class="table table-responsive table-bordered table-hover floatThead-table table-fixed">
                                <thead class="" style="background: #f4f6f9">
                                <tr>
                                    <th rowspan="2" style="vertical-align: middle">ক্রমিক নং</th>
                                    <th rowspan="2" style="vertical-align: middle">ট্রেডের নাম</th>
                                    <th colspan="12" rowspan="1"><p class="text-center">মাস</p></th>
                                    <th rowspan="2" style="vertical-align: middle">বাৎসরিক প্রশিক্ষণ
                                        লক্ষ্যমাত্রা
                                    </th>
                                    <th rowspan="2" style="vertical-align: middle">প্রশিক্ষণের ধরন</th>
                                    <th rowspan="2" style="vertical-align: middle">প্রশিক্ষণ ভ্যানু</th>
                                    <th rowspan="2" style="vertical-align: middle">ভ্যানু বিস্তারিত</th>
                                </tr>
                                <tr>
                                    <th>জুলাই<br>{{ \App\Helpers\Classes\NumberToBanglaWord::engToBn($year-1) }}
                                    </th>
                                    <th>আগস্ট<br>{{ \App\Helpers\Classes\NumberToBanglaWord::engToBn($year-1) }}
                                    </th>
                                    <th>
                                        সেপ্টেম্:<br>{{ \App\Helpers\Classes\NumberToBanglaWord::engToBn($year-1) }}
                                    </th>
                                    <th>
                                        অক্টো:<br>{{ \App\Helpers\Classes\NumberToBanglaWord::engToBn($year-1) }}
                                    </th>
                                    <th>নভে:<br>{{ \App\Helpers\Classes\NumberToBanglaWord::engToBn($year-1) }}
                                    </th>
                                    <th>ডিসে:<br>{{ \App\Helpers\Classes\NumberToBanglaWord::engToBn($year-1) }}
                                    </th>
                                    <th>জানু:<br>{{ \App\Helpers\Classes\NumberToBanglaWord::engToBn($year) }}
                                    </th>
                                    <th>ফেব্রু:<br>{{ \App\Helpers\Classes\NumberToBanglaWord::engToBn($year) }}
                                    </th>
                                    <th>মার্চ<br>{{ \App\Helpers\Classes\NumberToBanglaWord::engToBn($year) }}
                                    </th>
                                    <th>এপ্রিল<br>{{ \App\Helpers\Classes\NumberToBanglaWord::engToBn($year) }}
                                    </th>
                                    <th>মে<br>{{ \App\Helpers\Classes\NumberToBanglaWord::engToBn($year) }}
                                    </th>
                                    <th>জুন<br>{{ \App\Helpers\Classes\NumberToBanglaWord::engToBn($year) }}
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                @php
                                    $sl = 0;
                                @endphp

                                @if($totalCourseVenue)
                                    @foreach($courses as $key => $course)
                                        <tr>
                                            <th class="text-center"
                                                rowspan="{{ count($course)+1 }}">{{ \App\Helpers\Classes\NumberToBanglaWord::engToBn(++$sl) }}</th>
                                            <th colspan="5">{{ optional($totalCourseVenue[$key])->course_name}}</th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th class="align-middle text-center"
                                                rowspan="{{ count($course)+1 }}">
                                                {{ \App\Helpers\Classes\NumberToBanglaWord::engToBn($totalCourseVenue? $totalAnnualTrainingTarget[$totalCourseVenue[$key]->course_id] :'0') }}
                                            </th>
                                            <th class="align-middle text-center"
                                                rowspan="{{ count($course)+1 }}"> {{ $totalCourseVenue? ($totalCourseVenue[$key]->course_fee?'আবাসিক':'অনাবাসিক'):'' }}</th>
                                            <th class="align-middle text-center"
                                                rowspan="{{ count($course)+1 }}">{{ \App\Helpers\Classes\NumberToBanglaWord::engToBn($totalCourseVenue? ($totalCourseVenue[$key]? $totalCourseVenue[$key]->total_venue :'0'):'') }}
                                                টি কেন্দ্র
                                            </th>
                                            <th class="align-middle text-center"
                                                rowspan="{{ count($course)+1 }}">
                                                <a href="{{ route('course_management::venue-list', $totalCourseVenue?$totalCourseVenue[$key]->course_id:'' ) }}">বিস্তারিত</a>
                                            </th>
                                        </tr>

                                        @foreach($course as $courseSession)
                                            <tr>
                                                <th style="font-size: 12px">
                                                    {{  $courseSession->session_name_bn? $courseSession->session_name_bn:'' }}
                                                </th>
                                                <th>{{ \App\Helpers\Classes\NumberToBanglaWord::engToBn(date('m', strtotime($courseSession->application_start_date))==7 && date('Y', strtotime($courseSession->application_start_date))==date('Y')? date('d', strtotime($courseSession->application_start_date)) :'') }}</th>
                                                <th>{{ \App\Helpers\Classes\NumberToBanglaWord::engToBn(date('m', strtotime($courseSession->application_start_date))==8 && date('Y', strtotime($courseSession->application_start_date))==date('Y')? date('d', strtotime($courseSession->application_start_date)) :'') }}</th>
                                                <th>{{ \App\Helpers\Classes\NumberToBanglaWord::engToBn(date('m', strtotime($courseSession->application_start_date))==9 && date('Y', strtotime($courseSession->application_start_date))==date('Y')? date('d', strtotime($courseSession->application_start_date)) :'') }}</th>
                                                <th>{{ \App\Helpers\Classes\NumberToBanglaWord::engToBn(date('m', strtotime($courseSession->application_start_date))==10 && date('Y', strtotime($courseSession->application_start_date))==date('Y')? date('d', strtotime($courseSession->application_start_date)) :'') }}</th>
                                                <th>{{ \App\Helpers\Classes\NumberToBanglaWord::engToBn(date('m', strtotime($courseSession->application_start_date))==11 && date('Y', strtotime($courseSession->application_start_date))==date('Y')? date('d', strtotime($courseSession->application_start_date)) :'') }}</th>
                                                <th>{{ \App\Helpers\Classes\NumberToBanglaWord::engToBn(date('m', strtotime($courseSession->application_start_date))==12 && date('Y', strtotime($courseSession->application_start_date))==date('Y')? date('d', strtotime($courseSession->application_start_date)) :'') }}</th>
                                                <th>{{ \App\Helpers\Classes\NumberToBanglaWord::engToBn(date('m', strtotime($courseSession->application_start_date))==1 && date('Y', strtotime($courseSession->application_start_date))==date('Y')+1? date('d', strtotime($courseSession->application_start_date)) :'') }}</th>
                                                <th>{{ \App\Helpers\Classes\NumberToBanglaWord::engToBn(date('m', strtotime($courseSession->application_start_date))==2  && date('Y', strtotime($courseSession->application_start_date))==date('Y')+1? date('d', strtotime($courseSession->application_start_date)) :'') }}</th>
                                                <th>{{ \App\Helpers\Classes\NumberToBanglaWord::engToBn(date('m', strtotime($courseSession->application_start_date))==3  && date('Y', strtotime($courseSession->application_start_date))==date('Y')+1? date('d', strtotime($courseSession->application_start_date)) :'') }}</th>
                                                <th>{{ \App\Helpers\Classes\NumberToBanglaWord::engToBn(date('m', strtotime($courseSession->application_start_date))==4  && date('Y', strtotime($courseSession->application_start_date))==date('Y')+1? date('d', strtotime($courseSession->application_start_date)) :'') }}</th>
                                                <th>{{ \App\Helpers\Classes\NumberToBanglaWord::engToBn(date('m', strtotime($courseSession->application_start_date))==5  && date('Y', strtotime($courseSession->application_start_date))==date('Y')+1? date('d', strtotime($courseSession->application_start_date)) :'') }}</th>
                                                <th>{{ \App\Helpers\Classes\NumberToBanglaWord::engToBn(date('m', strtotime($courseSession->application_start_date))==6  && date('Y', strtotime($courseSession->application_start_date))==date('Y')+1? date('d', strtotime($courseSession->application_start_date)) :'') }}</th>
                                            </tr>
                                        @endforeach
                                    @endforeach
                                @else
                                    <tr>
                                        <th colspan="18">
                                            <div class="alert text-danger text-center">
                                                কোনো ডেটা পাওয়া যায়নি!
                                            </div>
                                        </th>
                                    </tr>
                                @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@push('css')
@endpush
@push('js')

@endpush
