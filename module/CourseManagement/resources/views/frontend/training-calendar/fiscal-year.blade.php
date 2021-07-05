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
                        <div class="col-md-12">
                            <h3 class="text-center">প্রশিক্ষণ বাস্তবায়ন সময়সূচি ২০২০-২০২১</h3>
                        </div>
                        <div class="col-md-12">
                            <div>
                                <table class="table table-bordered table-hover floatThead-table">
                                    <thead>
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

                                            @php
                                                $year = ( date('m') > 6) ? date('Y') + 1 : date('Y');
                                            @endphp
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
                                    <?php
                                        $sl = 0;
                                    ?>
                                    @foreach($courseSessions as $courseSession)
                                    <tr>
                                        <th >{{ ++$sl }}</th>
                                        <th >{{ $courseSession->course->title_bn }} </th>

                                        <th july>10</th>
                                        <th >10</th>
                                        <th>10</th>
                                        <th>10</th>
                                        <th>10</th>
                                        <th>10</th>
                                        <th>10</th>
                                        <th>10</th>
                                        <th>10</th>
                                        <th>10</th>
                                        <th>10</th>
                                        <th>10</th>

                                        <th >100</th>
                                        <th  >অনাবাসিক</th>
                                        <th >{{ $courseSession->total_course_session }} ভেনু</th>
                                        <th ><a href="#">Details</a></th>
                                    </tr>
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
