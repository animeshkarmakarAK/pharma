@extends('master::layouts.master')
@php
    /** @var \App\Models\User $authUser */
    $authUser = \App\Helpers\Classes\AuthHelper::getAuthUser();
@endphp
@push('js')
    <script src="https://d3js.org/d3.v4.js"></script>[
@endpush
@section('content')
    <div class="container-fluid">
        <div class="row d-flex">
            <div class="flex-fill mx-2">
                <div class="sticker-area text-center institute-sticker">
                    <div class="sticker-body" id="pentagon" style="
                        height: 80px;
                        background: url({{ asset("/assets/dashboard/2.png") }});
                        background-repeat: no-repeat;
                        background-position: center; ">
                        {{--                            <i class="fas fa-university sticker-icon"></i>--}}
                        <i class="fa fa-industry sticker-icon"></i>
                    </div>

                    <div class="sticker-count">
                        <a href="{{--{{ route('govt_stakeholder::admin.institutes.index') }}--}}">104{{--{{ $stickerCount['total_institute']? $stickerCount['total_institute']:'0' }}--}}</a>
                    </div>
                    <div class="sticker-title">
                        ইন্ডাস্ট্রি
                    </div>
                </div>
            </div>
            <div class="flex-fill mx-2">
                <div class="sticker-area text-center youth-sticker">
                    <div class="sticker-body" id="pentagon" style="
                        height: 80px;
                        background: url({{ asset("/assets/dashboard/1.png") }});
                        background-repeat: no-repeat;
                        background-position: center; ">
                        <i class="fas fa-briefcase sticker-icon"></i>
                    </div>

                    <div class="sticker-count">
                        100
                    </div>
                    <div class="sticker-title">
                        কর্মরত
                    </div>
                </div>
            </div>

            <div class="flex-fill mx-2">
                <div class="sticker-area text-center course-sticker">
                    <div class="sticker-body" id="pentagon" style="
                        height: 80px;
                        background: url({{ asset("/assets/dashboard/3.png") }});
                        background-repeat: no-repeat;
                        background-position: center; ">
                        <i class="fas fa-list-alt sticker-icon"></i>
                    </div>

                    <div class="sticker-count">
                        <a href="#">44</a>

                    </div>
                    <div class="sticker-title">
                        কর্মখালি
                    </div>
                </div>
            </div>

            <div class="flex-fill mx-2">
                <div class="sticker-area text-center branch-sticker">
                    <div class="sticker-body" id="pentagon" style="
                        height: 80px;
                        background: url({{ asset("/assets/dashboard/5.png") }});
                        background-repeat: no-repeat;
                        background-position: center; ">
                        <i class="fas fa-code-branch sticker-icon"></i>
                    </div>

                    <div class="sticker-count">
                        <a href="#">345</a>
                    </div>
                    <div class="sticker-title">
                        কর্মহীন
                    </div>
                </div>
            </div>

            <div class="flex-fill mx-2">
                <div class="sticker-area text-center training_center-sticker">
                    <div class="sticker-body" id="pentagon" style="
                        height: 80px;
                        background: url({{ asset("/assets/dashboard/4.png") }});
                        background-repeat: no-repeat;
                        background-position: center; ">
                        <i class="fas fa-chalkboard-teacher sticker-icon"></i>
                    </div>

                    <div class="sticker-count">
                        <a href="#">231</a>
                    </div>
                    <div class="sticker-title">
                        দক্ষতা বৃদ্ধিকারী প্রতিষ্ঠান
                    </div>
                </div>
            </div>
        </div>
        <div class="row d-flex" style="margin-left: 2px">
            <div class="card" style=" border-radius: 10px; min-width: 570px">
                <div class="card-header text-white" style="background-color:#c665e6;">
                    <h3 class="card-title font-weight-bold">বিগত ১ মাসের হিসাব</h3>
                </div>
                <div class="card-body">
                    <div id="my_data"></div>
                </div>
            </div>
        </div>

        <div class="row d-flex" style="margin-left: 2px">
            <div class="card" style=" border-radius: 10px; min-width: 570px">
                <div class="card-header text-white" style="background-color:#26d6cb;">
                    <h3 class="card-title font-weight-bold">সেক্টর ভিত্তিক জনবল</h3>
                </div>
                <div class="card-body">
                    <div id="my_dataviz" style="background-color: #ffffff; margin-left: -3px"></div>
                    <div style="height: 1px; margin-top: 5px; background-color: #f4f4f4"></div>
                    <div class="row" style="margin-left: 30px; margin-bottom: -20px">
                        <div class="row col-3" id="unemployedToggle">
                            <div class="colorIndicator" style="background-color: #f52674"></div>
                            <p>কর্মহীন</p>
                        </div>
                        <div class="row  col-3" id="employedToggle">
                            <div class="colorIndicator" style="background-color:#2f49d1"></div>
                            <p>কর্মরত</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div>
            <div class="tab" role="tabpanel">
                <!-- Nav tabs -->
                <ul class="nav nav-tabs" role="tablist">
                    <li role="presentation" class="navTabs active" style="">
                        <a href="#Industry" aria-controls="home" role="tab" data-toggle="tab">
                            <span>ইন্ডাস্ট্রির তালিকা</span>
                        </a>
                    </li>
                    <li role="presentation" class="navTabs" style="">
                        <a href="#Unemployed" aria-controls="profile" role="tab" data-toggle="tab">
                            <span>কর্মহীন জনবলের তালিকা</span>
                        </a>
                    </li>
                    <li role="presentation" class="navTabs">
                        <a href="#vacant" aria-controls="messages" role="tab" data-toggle="tab">
                            <span>কর্মখালি জনবলের তালিকা</span>
                        </a>
                    </li>
                    <li role="presentation" class="navTabs">
                        <a href="#employed" aria-controls="messages" role="tab" data-toggle="tab">
                            <span>কর্মরত জনবলের তালিকা</span>
                        </a>
                    </li>
                    <li role="presentation" class="navTabs" style="">
                        <a href="#skiled" aria-controls="messages" role="tab" data-toggle="tab">
                            <span>দক্ষ জনবলের তালিকা</span>
                        </a>
                    </li>

                </ul>
                <!-- Tab panes -->
                <div class="tab-content tabs">
                    <div role="tabpanel" class="tab-pane tab_custome_style fade in active show" id="Industry">
                        <table class="table" id="dataTable">
                            <!-- /.card-header -->
{{--                            <div class="card-body">--}}
{{--                                <div class="datatable-container">--}}
{{--                                    <table id="dataTable" class="table table-bordered table-striped dataTable compact">--}}
{{--                                    </table>--}}
{{--                                </div>--}}
{{--                            </div>--}}
                            <thead class="custom-bg-gradient-info">
                            <tr>
                                <th scope="col">কোম্পানির নাম</th>
                                <th scope="col">ধরন</th>
                                <th scope="col">নতুন নিয়োগ</th>
                                <th scope="col">কর্মখালি</th>
                                <th scope="col">কর্মরত</th>
                                <th scope="col" style="margin-right: -10px">
                                    <select class="form-control" style="">
                                        <option value="1" selected>জানুয়ারি</option>
                                        <option value="2">ফেব্রুয়ারি</option>
                                        <option value="3">মার্চ</option>
                                        <option value="4">এপ্রিল</option>
                                        <option value="5">মে</option>
                                        <option value="6">জুন</option>
                                        <option value="7">জুলাই</option>
                                        <option value="8">আগস্ট</option>
                                        <option value="9">সেপ্টেমবর</option>
                                        <option value="10">অক্টোবর</option>
                                        <option value="11">নভেম্বর</option>
                                        <option value="12">ডিসেম্বর</option>
                                    </select>
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <th>আকিজ লিমিটেড</th>
                                <td>
                                    <div class="nonGovt_tag_style">বেসরকারি</div>
                                </td>
                                <td>20</td>
                                <td>200</td>
                                <td>2050</td>
                                <td></td>
                            </tr>
                            <tr>
                                <th scope="row">এসএমই ফাউন্ডেসন</th>
                                <td>
                                    <div class="govt_tag_style">সরকারি</div>
                                </td>
                                <td>50</td>
                                <td>0</td>
                                <td>340</td>
                                <td></td>

                            </tr>
                            <tr>
                                <th scope="row">বসুন্ধরা লিমিটেড</th>
                                <td>
                                    <div class="nonGovt_tag_style">বেসরকারি</div>
                                </td>
                                <td>33</td>
                                <td>405</td>
                                <td>4050</td>
                                <td></td>

                            </tr>
                            <tr>
                                <th scope="row">কর্ণফুলী পেপার মিল</th>
                                <td>
                                    <div class="govt_tag_style">সরকারি</div>
                                </td>
                                <td>36</td>
                                <td>33</td>
                                <td>330</td>
                                <td></td>

                            </tr>
                            <tr>
                                <th scope="row">সোনালি ব্যাঙ্ক</th>
                                <td>
                                    <div class="govt_tag_style">সরকারি</div>
                                </td>
                                <td>230</td>
                                <td>400</td>
                                <td>1107</td>
                                <td></td>

                            </tr>
                            <tr>
                                <th scope="row">প্রাইম ব্যাঙ্ক</th>
                                <td>
                                    <div class="nonGovt_tag_style">বেসরকারি</div>
                                </td>
                                <td>389</td>
                                <td>200</td>
                                <td>1200</td>
                                <td></td>

                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <div role="tabpanel" class="tab-pane tab_custome_style fade" id="Unemployed">
                        <table class="table" style="background-color: #ffffff">
                            <thead class="custom-bg-gradient-info">
                            <tr>
                                <th scope="col">স্কিলের নাম</th>
                                <th scope="col">নতুন</th>
                                <th scope="col">কর্মখালি</th>
                                <th scope="col">কর্মরত</th>
                                <th scope="col" style="margin-right: -50px">
                                    <select class="form-control" style="margin-right: -8.3vw">
                                        <option value="1" selected>জানুয়ারি</option>
                                        <option value="2">ফেব্রুয়ারি</option>
                                        <option value="3">মার্চ</option>
                                        <option value="4">এপ্রিল</option>
                                        <option value="5">মে</option>
                                        <option value="6">জুন</option>
                                        <option value="7">জুলাই</option>
                                        <option value="8">আগস্ট</option>
                                        <option value="9">সেপ্টেমবর</option>
                                        <option value="10">অক্টোবর</option>
                                        <option value="11">নভেম্বর</option>
                                        <option value="12">ডিসেম্বর</option>
                                    </select>
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <th>ড্রাইভার</th>
                                <td>20</td>
                                <td>200</td>
                                <td>2050</td>
                                <td></td>
                            </tr>
                            <tr>
                                <th scope="row">প্লাম্বার</th>
                                <td>50</td>
                                <td>0</td>
                                <td>340</td>
                                <td></td>

                            </tr>
                            <tr>
                                <th scope="row">ইলেক্টিসিয়ান</th>
                                <td>33</td>
                                <td>405</td>
                                <td>4050</td>
                                <td></td>

                            </tr>
                            <tr>
                                <th scope="row">কারপেন্টার</th>
                                <td>36</td>
                                <td>33</td>
                                <td>330</td>
                                <td></td>

                            </tr>
                            <tr>
                                <th scope="row">গার্ড</th>
                                <td>230</td>
                                <td>400</td>
                                <td>1107</td>
                                <td></td>

                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <div role="tabpanel" class="tab-pane tab_custome_style fade" id="vacant">
                        <table class="table" style="background-color: #ffffff">
                            <thead class="custom-bg-gradient-info">
                            <tr>
                                <th scope="col">স্কিলের নাম</th>
                                <th scope="col">নতুন</th>
                                <th scope="col">কর্মখালি</th>
                                <th scope="col">কর্মরত</th>
                                <th scope="col" style="margin-right: -50px">
                                    <select class="form-control" style="margin-right: -8.3vw">
                                        <option value="1" selected>জানুয়ারি</option>
                                        <option value="2">ফেব্রুয়ারি</option>
                                        <option value="3">মার্চ</option>
                                        <option value="4">এপ্রিল</option>
                                        <option value="5">মে</option>
                                        <option value="6">জুন</option>
                                        <option value="7">জুলাই</option>
                                        <option value="8">আগস্ট</option>
                                        <option value="9">সেপ্টেমবর</option>
                                        <option value="10">অক্টোবর</option>
                                        <option value="11">নভেম্বর</option>
                                        <option value="12">ডিসেম্বর</option>
                                    </select>
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <th>ড্রাইভার</th>
                                <td>20</td>
                                <td>200</td>
                                <td>2050</td>
                                <td></td>
                            </tr>
                            <tr>
                                <th scope="row">প্লাম্বার</th>
                                <td>50</td>
                                <td>0</td>
                                <td>340</td>
                                <td></td>

                            </tr>
                            <tr>
                                <th scope="row">ইলেক্টিসিয়ান</th>
                                <td>33</td>
                                <td>405</td>
                                <td>4050</td>
                                <td></td>

                            </tr>
                            <tr>
                                <th scope="row">কারপেন্টার</th>
                                <td>36</td>
                                <td>33</td>
                                <td>330</td>
                                <td></td>

                            </tr>
                            <tr>
                                <th scope="row">গার্ড</th>
                                <td>230</td>
                                <td>400</td>
                                <td>1107</td>
                                <td></td>

                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <div role="tabpanel" class="tab-pane tab_custome_style fade" id="employed">
                        <table class="table" style="background-color: #ffffff">
                            <thead class="custom-bg-gradient-info">
                            <tr>
                                <th scope="col">স্কিলের নাম</th>
                                <th scope="col">নতুন</th>
                                <th scope="col">কর্মখালি</th>
                                <th scope="col">কর্মরত</th>
                                <th scope="col" style="margin-right: -50px">
                                    <select class="form-control" style="margin-right: -8.3vw">
                                        <option value="1" selected>জানুয়ারি</option>
                                        <option value="2">ফেব্রুয়ারি</option>
                                        <option value="3">মার্চ</option>
                                        <option value="4">এপ্রিল</option>
                                        <option value="5">মে</option>
                                        <option value="6">জুন</option>
                                        <option value="7">জুলাই</option>
                                        <option value="8">আগস্ট</option>
                                        <option value="9">সেপ্টেমবর</option>
                                        <option value="10">অক্টোবর</option>
                                        <option value="11">নভেম্বর</option>
                                        <option value="12">ডিসেম্বর</option>
                                    </select>
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <th>ড্রাইভার</th>
                                <td>20</td>
                                <td>200</td>
                                <td>2050</td>
                                <td></td>
                            </tr>
                            <tr>
                                <th scope="row">প্লাম্বার</th>
                                <td>50</td>
                                <td>0</td>
                                <td>340</td>
                                <td></td>

                            </tr>
                            <tr>
                                <th scope="row">ইলেক্টিসিয়ান</th>
                                <td>33</td>
                                <td>405</td>
                                <td>4050</td>
                                <td></td>

                            </tr>
                            <tr>
                                <th scope="row">কারপেন্টার</th>
                                <td>36</td>
                                <td>33</td>
                                <td>330</td>
                                <td></td>

                            </tr>
                            <tr>
                                <th scope="row">গার্ড</th>
                                <td>230</td>
                                <td>400</td>
                                <td>1107</td>
                                <td></td>

                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <div role="tabpanel" class="tab-pane tab_custome_style fade" id="skiled">
                        <table class="table" style="background-color: #ffffff">
                            <thead class="custom-bg-gradient-info">
                            <tr>
                                <th scope="col">স্কিলের নাম</th>
                                <th scope="col">নতুন</th>
                                <th scope="col">কর্মখালি</th>
                                <th scope="col">কর্মরত</th>
                                <th scope="col" style="margin-right: -50px">
                                    <select class="form-control" style="margin-right: -8.3vw">
                                        <option value="1" selected>জানুয়ারি</option>
                                        <option value="2">ফেব্রুয়ারি</option>
                                        <option value="3">মার্চ</option>
                                        <option value="4">এপ্রিল</option>
                                        <option value="5">মে</option>
                                        <option value="6">জুন</option>
                                        <option value="7">জুলাই</option>
                                        <option value="8">আগস্ট</option>
                                        <option value="9">সেপ্টেমবর</option>
                                        <option value="10">অক্টোবর</option>
                                        <option value="11">নভেম্বর</option>
                                        <option value="12">ডিসেম্বর</option>
                                    </select>
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <th>ড্রাইভার</th>
                                <td>20</td>
                                <td>200</td>
                                <td>2050</td>
                                <td></td>
                            </tr>
                            <tr>
                                <th scope="row">প্লাম্বার</th>
                                <td>50</td>
                                <td>0</td>
                                <td>340</td>
                                <td></td>

                            </tr>
                            <tr>
                                <th scope="row">ইলেক্টিসিয়ান</th>
                                <td>33</td>
                                <td>405</td>
                                <td>4050</td>
                                <td></td>

                            </tr>
                            <tr>
                                <th scope="row">কারপেন্টার</th>
                                <td>36</td>
                                <td>33</td>
                                <td>330</td>
                                <td></td>

                            </tr>
                            <tr>
                                <th scope="row">গার্ড</th>
                                <td>230</td>
                                <td>400</td>
                                <td>1107</td>
                                <td></td>

                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script type="text/javascript" src="{{asset('/js/datatable-bundle.js')}}"></script>
    <script>

        $(function () {
            let params = serverSideDatatableFactory({
                url: '{{ route('govt_stakeholder::admin.organization-units.statistics-datatable') }}',
                order: [[2, "asc"]],
                searching: false,
                paging: false,
                lengthChange: false,
                info:false,
                generateSerialNumber: false,
                columns: [
                    {
                        data: "organization_unit_name",
                        name: "organization_units.title_en"
                    },
                    {
                        data: "organization_unit_type_name",
                        name: "organization_unit_types.title_en"
                    },
                    {
                        data: "total_new_recruits",
                        name: "total_new_recruits"
                    },
                    {
                        data: "total_occupied_position",
                        name: "total_occupied_position"
                    },
                    {
                        data: "total_vacancy",
                        name: "total_vacancy"
                    },
                    {
                        data: "survey_date",
                        name: "survey_date",
                        // visible: false,
                    },
                ]
            });
            const datatable = $('#dataTable').DataTable(params);
            bindDatatableSearchOnPresEnterOnly(datatable);

            $(document, 'td').on('click', '.delete', function (e) {
                $('#delete_form')[0].action = $(this).data('action');
                $('#delete_modal').modal('show');
            });
        });
    </script>
    <script src="https://d3js.org/d3-scale-chromatic.v1.min.js"></script>

    <script>
        $('.navTabs').on('click', function (event) {
            $('.navTabs').removeClass('active')
            $(this).addClass('active')
            //$(this).css('background-color: #138dd1')
        })
    </script>

    <script>

        // set the dimensions and margins of the graph
        var margin = {top: 10, right: 100, bottom: 30, left: 30},
            width = 560 - margin.left - margin.right,
            height = 300 - margin.top - margin.bottom;

        // append the svg object to the body of the page
        var svg1 = d3.select("#my_data")
            .append("svg")
            .attr("width", width + margin.left + margin.right)
            .attr("height", height + margin.top + margin.bottom)
            .append("g")
            .attr("transform",
                "translate(" + margin.left + "," + margin.top + ")");

        let dataSet = [{time: "1", A: "20", B: "350", C: "130", D: "200", E: "20"},
            {time: "2", A: "300", B: "400", C: "104", D: "340", E: "340"},
            {time: "3", A: "250", B: "449", C: "316", D: "350", E: "211"},
            {time: "4", A: "307", B: "400", C: "412", D: "8", E: "313"},
            {time: "5", A: "383", B: "348", C: "270", D: "20", E: "315"}]
        //Read the data

        // List of groups (here I have one group per column)
        var allGroup = [{A: 'কর্মহীন'}, {B: 'কর্মরত'}, {C: 'নতুন দক্ষ জনবল'}, {D: 'কর্মখালি'}, {E: 'নিয়োগ'}]


        // Reformat the data: we need an array of arrays of {x, y} tuples
        var dataReady = allGroup.map(function (data) { // .map allows to do something for each element of the list
            return {
                name: data[Object.keys(data)[0]],
                values: dataSet.map(function (d) {
                    return {time: d.time, value: +d[Object.keys(data)[0]]};
                })
            };
        });
        // I strongly advise to have a look to dataReady with

        //custome line add to graph background
        let lineBackground1 = (data = [0, 1, 2, 3, 4]) => {
            return data.map((i) => {
                return svg1.append('line')
                    .attr('x1', 0)
                    .attr('y1', 52 * i)
                    .attr('x2', 440)
                    .attr('y2', 54 * i)
                    .attr('stroke', 'gray')
                    .attr('stroke-width', 0.2)
            })
        }


        // A color scale: one color for each group
        console.log(d3.schemeSet2)
        var myColor = d3.scaleOrdinal()
            .domain(allGroup)
            .range(["#66c2a5", "#fc8d62", "#8da0cb", "#e78ac3", "#a6d854"]);

        // Add X axis --> it is a date format
        var x = d3.scaleLinear()
            .domain([1, 5])
            .range([0, width]);
        svg1.append("g")
            .attr("transform", "translate(0," + height + ")")
            .call(d3.axisBottom(x));

        // Add Y axis
        var y = d3.scaleLinear()
            .domain([0, 500])
            .range([height, 0]);
        svg1.append("g")
            .call(d3.axisLeft(y));

        lineBackground1()

        // Add the lines
        var line = d3.line()
            .x(function (d) {
                return x(+d.time)
            })
            .y(function (d) {
                return y(+d.value)
            })
        svg1.selectAll("myLines")
            .data(dataReady)
            .enter()
            .append("path")
            .attr("class", function (d) {
                return d.name
            })
            .attr("d", function (d) {
                return line(d.values)
            })
            .attr("stroke", function (d) {
                return myColor(d.name)
            })
            .style("stroke-width", 4)
            .style("fill", "none")

        // Add the points
        svg1
            // First we need to enter in a group
            .selectAll("myDots")
            .data(dataReady)
            .enter()
            .append('g')
            .style("fill", function (d) {
                return myColor(d.name)
            })
            .attr("class", function (d) {
                return d.name
            })
            // Second we need to enter in the 'values' part of this group
            .selectAll("myPoints")
            .data(function (d) {
                return d.values
            })
            .enter()
            .append("circle")
            .attr("cx", function (d) {
                return x(d.time)
            })
            .attr("cy", function (d) {
                return y(d.value)
            })
            .attr("r", 5)
            .attr("stroke", "white")

        // Add a label at the end of each line
        svg1
            .selectAll("myLabels")
            .data(dataReady)
            .enter()
            .append('g')
            .append("text")
            .attr("class", function (d) {
                return d.name
            })
            .datum(function (d) {
                return {name: d.name, value: d.values[d.values.length - 1]};
            }) // keep only the last value of each time series
            .attr("transform", function (d) {
                return "translate(" + x(d.value.time) + "," + y(d.value.value) + ")";
            }) // Put the text at the position of the last point
            .attr("x", 12) // shift the text a bit more right
            .text(function (d) {
                return d.name;
            })
            .style("fill", function (d) {
                return myColor(d.name)
            })
            .style("font-size", 15)

        // Add a legend (interactive)
        svg1
            .selectAll("myLegend")
            .data(dataReady)
            .enter()
            .append('g')
            .append("text")
            .attr('x', function (d, i) {
                return i == 3 ? 30 + i * 100 : 30 + i * 60
            })
            .attr('y', 10)
            .text(function (d) {
                return d.name;
            })
            .style("fill", function (d) {
                return myColor(d.name)
            })
            .style("font-size", 15)
            .on("click", function (d) {
                // is the element currently visible ?
                currentOpacity = d3.selectAll("." + d.name).style("opacity")
                // Change the opacity: from 0 to 1 or from 1 to 0
                d3.selectAll("." + d.name).transition().style("opacity", currentOpacity == 1 ? 0 : 1)

            })


    </script>

    <script>
        /**
         * This block is for colum graph
         **/

            // set the dimensions and margins of the graph
        var margin = {top: 10, right: 30, bottom: 20, left: 50},
            width = 560 - margin.left - margin.right,
            height = 300 - margin.top - margin.bottom;

        // append the svg object to the body of the page

        // Parse the Data


        let dummyData = [
            {
                group: "ইঞ্জিনিয়ার",
                Employed: "130",
                UnEmployed: "100"
            },
            {
                group: "মেকানিক",
                Employed: "106",
                UnEmployed: "56"
            },
            {
                group: "ডেলিভারি ম্যান",
                Employed: "191",
                UnEmployed: "128"
            },
            {
                group: "ড্রাইভার",
                Employed: "190",
                UnEmployed: "106"
            },
            {
                group: "সেলসম্যান",
                Employed: "119",
                UnEmployed: "69"
            },
            {
                group: "ইলেক্টিসিয়ান",
                Employed: "179",
                UnEmployed: "136"
            }]

        let subgroups = ['Employed', 'UnEmployed']
        let colorCodes = ['#2f49d1', '#f52674']

        function dataSwitch(type) {
            console.log(type)
            if (subgroups.includes(type)) {
                var index = subgroups.indexOf(type);
                if (index > -1) {
                    subgroups.splice(index, 1);
                    colorCodes.splice(index, 1)
                }
            } else {
                if (type == 'Employed') {
                    subgroups = [type, ...subgroups]
                    colorCodes = ['#2f49d1', ...colorCodes]
                } else {
                    subgroups.push(type)
                    colorCodes.push('#f52674')
                }

            }
            $('#my_dataviz').html('')
            graph(dummyData)

        }

        $('#employedToggle').on('click', function () {
            dataSwitch('Employed')
        })
        $('#unemployedToggle').on('click', function () {
            dataSwitch('UnEmployed')

        })

        graph(dummyData)

        function xAxis(g) {
            return g.attr("transform", `translate(0,${height - margin.bottom})`)
                .call(d3.axisBottom(x)
                    .tickSizeOuter(0))
        }

        function graph(data) {

            var svg = d3.select("#my_dataviz")
                .append("svg")
                .attr("width", width + margin.left + margin.right)
                .attr("height", height + margin.top + margin.bottom)
                .append("g")
                .attr("transform",
                    "translate(" + margin.left + "," + margin.top + ")");


            // List of subgroups = header of the csv files = soil condition here
            //var subgroups = data.columns.slice(1)

            // List of groups = species here = value of the first column called group -> I show them on the X axis
            var groups = d3.map(data, function (d) {
                console.log(d)
                return (d.group)
            }).keys()


            let lineBackground = (data = [0, 1, 2, 3, 4, 5, 6, 7]) => {
                return data.map((i) => {
                    return svg.append('line')
                        .attr('x1', 0)
                        .attr('y1', 54 * i)
                        .attr('x2', 480)
                        .attr('y2', 54 * i)
                        .attr('stroke', 'gray')
                        .attr('stroke-width', 0.2)
                })
            }

            // Add X axis
            var x = d3.scaleBand()
                .domain(groups)
                .range([0, width])
                .padding([0.3])
            svg.append("g")
                .attr("transform", "translate(0," + height + ")")
                .call(d3.axisBottom(x).tickSize(6));

            // Add Y axis
            var y = d3.scaleLinear()
                .domain([0, 200])
                .range([height, 0]);
            svg.append("g")
                .call(d3.axisLeft(y));

            // Another scale for subgroup position?
            var xSubgroup = d3.scaleBand()
                .domain(subgroups)
                .range([0, x.bandwidth()])
                .padding([0.1]);
            // color palette = one color per subgroup
            var color = d3.scaleOrdinal()
                .domain(subgroups)
                .range(colorCodes)

            // Show the bars
            lineBackground()

            svg.append("g")
                .selectAll("g")
                // Enter in data = loop group per group
                .data(data)
                .enter()
                .append("g")
                .attr("transform", function (d) {
                    return "translate(" + x(d.group) + ",0)";
                })
                .selectAll("rect")
                .data(function (d) {
                    return subgroups.map(function (key) {
                        return {key: key, value: d[key]};
                    });
                })
                .enter().append("rect")
                .attr("x", function (d) {
                    return xSubgroup(d.key);
                })
                .attr("y", function (d) {
                    return y(d.value);
                })
                .attr("width", xSubgroup.bandwidth())
                .attr("height", function (d) {
                    return height - y(d.value);
                })
                .attr("fill", function (d) {
                    return color(d.key);
                });

        }


    </script>
@endpush

@push('css')
    <style>
        .sticker-area {
            background: #fff;
            padding: 20px 30px;
            border-radius: 8px;
            margin-bottom: 10px;
        }

        .sticker-count {
            padding: 10px;
            color: #5b9bd5;
            font-size: 20px;
        }

        .sticker-title {
            font-weight: bold;
            min-height: 36px;
            line-height: 17px;
        }

        .sticker-icon {
            padding: 30px;
            font-size: 30px;
            color: #ffffff;
        }

        .institute-sticker {
            border-bottom: 8px solid #2defd8;
        }

        .youth-sticker {
            border-bottom: 8px solid #5b9bd5;
        }

        .course-sticker {
            border-bottom: 8px solid #ffd966;
        }

        .branch-sticker {
            border-bottom: 8px solid #fe5c02;
        }

        .training_center-sticker {
            border-bottom: 8px solid #ffc000;
        }

        .colorIndicator {
            height: 10px;
            width: 10px;
            border-radius: 50px;
            margin: 8px
        }

        .govt_tag_style {
            background-color: #ebf4e6;
            color: #6bbe73;
            width: 80px;
            text-align: center
        }

        .nonGovt_tag_style {
            background-color: #e6f2f8;
            color: #5a9ed5;
            width: 80px;
            text-align: center
        }

        .tab .nav-tabs li {
            background-color: #dbf4fe;
            padding-top: 7px;
            padding-bottom: 7px;
            padding-left: 30px;
            padding-right: 30px;
            border-top-left-radius: 20px 30px;
            border-top-right-radius: 20px 30px;
            border: 1px solid #138dd1;
        }

        .tab .nav-tabs li.active {
            background-color: #138dd1;
        }

        .tab .nav-tabs li.active a {
            color: #fff;
        }

        .table thead tr th select {
            width: 10vw;
            padding: 10px;
            height: fit-content;
            background-color: #6fcdff;
            margin-right: -6.1vw;
            margin-bottom: -11.6px;
            margin-top: -6.3px;
        }

        .table {
            background-color: #ffffff;
            width: 80vw;
        }

        .table thead {
            border-top-right-radius: 20px;
        }

    </style>
@endpush

