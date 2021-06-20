@extends('master::layouts.master')
@php
    /** @let \App\Models\User $authUser */
    $authUser = \App\Helpers\Classes\AuthHelper::getAuthUser();
@endphp

@push('css')
    <link rel="stylesheet" href="{{asset('/css/datatable-bundle.css')}}">
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
            /*width: 10vw;*/
            padding: 10px;
            height: fit-content;
            background-color: #6fcdff;
            margin-right: -6.1vw;
            margin-bottom: -11.6px;
            margin-top: -6.3px;
        }

        .table {
            background-color: #ffffff;
            /*width: 80vw;*/
        }

        .table thead {
            border-top-right-radius: 20px;
        }


        /**************************************************************/
        /*************************Map CSS******************************/
        /**************************************************************/
        #bangladesh {
            stroke: #101010;
            stroke-width: 0.01;
        }

        div.tooltip {
            position: absolute;
            text-align: center;
            padding: 0.5em;
            font-size: 10px;
            color: #222;
            background: #FFF;
            border-radius: 2px;
            pointer-events: none;
            box-shadow: 0px 0px 2px 0px #a6a6a6;
        }

        .key path {
            display: none;
        }

        .key line {
            stroke: #000;
            shape-rendering: crispEdges;
        }

        .key text {
            font-size: 10px;
        }

        .key rect {
            stroke-width: .4;
        }

        .bd:hover {
            fill: green;
        }

        .map_info {
            display: inline-block;
            position: absolute;
            top: 50px;
            right: 6px;
            opacity: .8;
            font-size: 12px;
            background: #f2f7f8;
            border-radius: 5px;
            max-height: 190px;
            min-width: 192px;
        }

        .svg_map {
            margin-bottom: 50px !important;
        }

        .map_content_top {
            padding: 15px 10px 0px 10px;
            line-height: 2px;
            font-size: 15px;
        }

        .map_content_body {
            padding: 0 10px 10px 10px;
            line-height: 17px;
        }

        .map_count_numbers {
            margin-left: 18px;
            font-size: 18px;
        }
    </style>
@endpush

@push('js')
    <script src="https://d3js.org/d3.v4.js"></script>
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

        <div class="row">
            <div class="col-md-6">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header text-white" style="background-color:#c665e6;">
                                <h3 class="card-title font-weight-bold">বিগত ১ মাসের হিসাব</h3>
                            </div>
                            <div class="card-body">
                                <div id="my_data"></div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header text-white">
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
                </div>
            </div>


            <div class="col-md-6">
                <div class="card">
                    <div class="card-header text-white" style="background-color:#c665e6;">
                        <h3 class="card-title font-weight-bold">জেলা মানচিত্র</h3>
                    </div>
                    <div class="card-body">
                        <select class="select2-ajax-wizard"
                                name="map_select"
                                id="map_select"
                                data-model="{{base64_encode(\App\Models\LocDistrict::class)}}"
                                data-label-fields="{title_en}"
                                data-placeholder="Select option"
                        >
                            <option selected disabled>Select Upazila</option>
                        </select>
                        <div id="bd_map_d3"></div>
                        <div class="map_info" style="display: none">
                            <div class="map_content_top">
                                <p><b><span id="district"></span></b></p>
                            </div>
                            <hr>
                            <div class="map_content_body">
                                <div class="mb-2">
                                    <p class="mb-0"><i class="fa fa-circle text-red" aria-hidden="true"></i> Running
                                        Courses</p>
                                    <strong id="running_courses" class="map_count_numbers">10</strong>
                                </div>
                                <div class="mb-2">
                                    <p class="mb-0"><i class="fa fa-circle text-green" aria-hidden="true"></i> Total
                                        Enrollment</p>
                                    <b id="total_enrollment" class="map_count_numbers">20</b>
                                </div>
                                <div class="mb-2">
                                    <p class="mb-0"><i class="fa fa-circle text-blue" aria-hidden="true"></i>
                                        Running Students</p>
                                    <b id="running_students" class="map_count_numbers">100</b>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="tab" role="tabpanel">
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs" role="tablist">
                        <li role="presentation" class="navTabs active" style="">
                            <a href="#Industry" aria-controls="home" role="tab" data-toggle="tab">
                                <span>ইন্ডাস্ট্রির তালিকা</span>
                            </a>
                        </li>
                        <li role="presentation" class="navTabs" style="">
                            <a href="#unemployed" aria-controls="profile" role="tab" data-toggle="tab">
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
                            <a href="#skilled" aria-controls="messages" role="tab" data-toggle="tab">
                                <span>দক্ষ জনবলের তালিকা</span>
                            </a>
                        </li>

                    </ul>
                    <!-- Tab panes -->
                    <div class="tab-content tabs">
                        <div role="tabpanel" class="tab-pane tab_custome_style fade in active show" id="Industry">
                            <div class="datatable-container">
                                <table id="dataTable" class="table table-bordered dataTable">
                                    <thead class="custom-bg-gradient-info">
                                    <tr>
                                        <th scope="col">কোম্পানির নাম</th>
                                        <th scope="col">ধরন</th>
                                        <th scope="col">নতুন নিয়োগ</th>
                                        <th scope="col">কর্মখালি</th>
                                        <th scope="col">কর্মরত</th>
                                        <th scope="col" style="margin-right: -10px">
                                            <?php $months = [1 => 'জানুয়ারি', 2 => 'ফেব্রুয়ারি', 3 => 'মার্চ', 4 => 'এপ্রিল', 5 => 'মে',
                                                6 => 'জুন', 7 => 'জুলাই', 8 => 'আগস্ট', 9 => 'সেপ্টেমবর', 10 => 'অক্টোবর', 11 => 'নভেম্বর', 12 =>'ডিসেম্বর']  ?>
                                            <select class="form-control" id="month-list" style="width: 18vh; margin-right: 2px;">
                                                @foreach($months as $key => $month)
                                                    @if($key == \Carbon\Carbon::now()->format('m'))
                                                        <option value="{{ $key }}" selected>{{ $month }}</option>
                                                    @else
                                                    <option value="{{ $key }}">{{ $month }}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </th>
                                    </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                        <div role="tabpanel" class="tab-pane tab_custome_style fade" id="unemployed">
                            <div class="datatable-container">
                                <table id="dataTable1" class="table table-bordered dataTable">
                                    <thead class="custom-bg-gradient-info">
                                    </thead>
                                </table>
                            </div>
                        </div>
                        <div role="tabpanel" class="tab-pane tab_custome_style fade" id="vacant">
                            <div class="datatable-container">
                                <table class="table table-bordered dataTable" id="dataTable2" style="background-color: #ffffff">
                                    <thead class="custom-bg-gradient-info">
                                    </thead>
                                </table>
                            </div>
                        </div>
                        <div role="tabpanel" class="tab-pane tab_custome_style fade" id="employed">
                            <div class="datatable-container">
                                <table id="dataTable3" class="table table-bordered dataTable">
                                    <thead class="custom-bg-gradient-info">
                                    </thead>
                                </table>
                            </div>
                        </div>
                        <div role="tabpanel" class="tab-pane tab_custome_style fade" id="skilled">
                            <div class="datatable-container">
                                <table class="table table-bordered dataTable" id="dataTable4" style="background-color: #ffffff">
                                    <thead class="custom-bg-gradient-info">
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('js')
    <script type="text/javascript" src="{{asset('/js/datatable-bundle.js')}}"></script>
    <script src="https://d3js.org/d3-scale-chromatic.v1.min.js"></script>
    <script>
        $('.navTabs').on('click', function (event) {
            $('.navTabs').removeClass('active')
            $(this).addClass('active')
            //$(this).css('background-color: #138dd1')
        })
        $(function () {
            let params = serverSideDatatableFactory({
                url: '{{ route('govt_stakeholder::admin.organization-units.statistics-datatable') }}',
                order: [[2, "asc"]],
                searching: false,
                paging: false,
                lengthChange: false,
                info: false,
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
                        visible: true,
                        sortable: false,
                        defaultContent: "",
                    },
                ]
            });
            params.dom = "<'row'<'col-sm-12'tr>>";

            params.ajax.data = d => {
                d.month = $('#month-list').val();
            };
            const datatable = $('#dataTable').DataTable(params);

            $('#month-list').on('change', function () {
                datatable.draw();
            })


            let params1 = serverSideDatatableFactory({
                url: '{{ route('govt_stakeholder::admin.occupations.statistics-datatable') }}',
                searching: false,
                paging: false,
                generateSerialNumber: false,
                columns: [
                    {
                        title: "কোম্পানির নাম",
                        data: "organization_unit_name",
                        name: "organization_units.title_en"
                    },
                    {
                        title: "কর্মহীন",
                        data: "sum_vacancy",
                        name: "sum_vacancy",
                    },
                ]
            });
            params1.dom = "<'row'<'col-sm-12'tr>>";

            const datatable1 = $('#dataTable1').DataTable(params1);

            $('a[href = "#unemployed"]').on('click', function () {
                setTimeout(function () {
                    datatable1.draw();
                }, 200)
            })

            let params2 = serverSideDatatableFactory({
                url: '{{ route('govt_stakeholder::admin.occupations.statistics-datatable') }}',
                searching: false,
                paging: false,
                generateSerialNumber: false,
                columns: [
                    {
                        title: "কোম্পানির নাম",
                        data: "organization_unit_name",
                        name: "organization_units.title_en"
                    },
                    {
                        title: "করমখালি",
                        data: "sum_vacancy",
                        name: "sum_vacancy"
                    },
                ]
            });
            params2.dom = "<'row'<'col-sm-12'tr>>";

            const datatable2 = $('#dataTable2').DataTable(params2);

            $('a[href = "#vacant"]').on('click', function () {
                setTimeout(function () {
                    datatable2.draw();
                }, 200)
            })

            //datatable for employed statistics

            let params3 = serverSideDatatableFactory({
                url: '{{ route('govt_stakeholder::admin.occupations.statistics-datatable') }}',
                searching: false,
                paging: false,
                lengthChange: false,
                info: false,
                generateSerialNumber: false,
                columns: [
                    {
                        title: "কোম্পানির নাম",
                        data: "organization_unit_name",
                        name: "organization_units.title_en"
                    },
                    {
                        title: "কর্মরত",
                        data: "sum_occupied_position",
                        name: "sum_occupied_position"
                    },
                ]
            });
            params3.dom = "<'row'<'col-sm-12'tr>>";


            const datatable3 = $('#dataTable3').DataTable(params3);

            $('a[href = "#employed"]').on('click', function () {
                setTimeout(function () {
                    datatable3.draw();
                }, 200)
            })


            //datatable for skilled people
            let params4 = serverSideDatatableFactory({
                url: '{{ route('govt_stakeholder::admin.occupations.statistics-datatable') }}',
                searching: false,
                paging: false,
                lengthChange: false,
                info: false,
                generateSerialNumber: false,
                columns: [
                    {
                        title: "কোম্পানির নাম",
                        data: "organization_unit_name",
                        name: "organization_units.title_en"
                    },
                    {
                        title: "দক্ষ জনবল সংখ্যা",
                        data: "sum_occupied_position",
                        name: "sum_occupied_position"
                    },
                ]
            });
            params4.dom = "<'row'<'col-sm-12'tr>>";

            const datatable4 = $('#dataTable4').DataTable(params4);

            $('a[href = "#skilled"]').on('click', function () {
                setTimeout(function () {
                    datatable4.draw();
                }, 200)
            })
        });

        (function () {
            // set the dimensions and margins of the graph
            let margin = {top: 10, right: 100, bottom: 30, left: 30},
                width = 560 - margin.left - margin.right,
                height = 300 - margin.top - margin.bottom;

            // append the svg object to the body of the page
            let svg1 = d3.select("#my_data")
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
            let allGroup = [{A: 'কর্মহীন'}, {B: 'কর্মরত'}, {C: 'নতুন দক্ষ জনবল'}, {D: 'কর্মখালি'}, {E: 'নিয়োগ'}]


            // Reformat the data: we need an array of arrays of {x, y} tuples
            let dataReady = allGroup.map(function (data) { // .map allows to do something for each element of the list
                return {
                    name: data[Object.keys(data)[0]],
                    values: dataSet.map(function (d) {
                        return {time: d.time, value: +d[Object.keys(data)[0]]};
                    })
                };
            });
            // I strongly advise to have a look to dataReady with

            //custom line add to graph background
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
            let myColor = d3.scaleOrdinal()
                .domain(allGroup)
                .range(["#66c2a5", "#fc8d62", "#8da0cb", "#e78ac3", "#a6d854"]);

            // Add X axis --> it is a date format
            let x = d3.scaleLinear()
                .domain([1, 5])
                .range([0, width]);
            svg1.append("g")
                .attr("transform", "translate(0," + height + ")")
                .call(d3.axisBottom(x));

            // Add Y axis
            let y = d3.scaleLinear()
                .domain([0, 500])
                .range([height, 0]);
            svg1.append("g")
                .call(d3.axisLeft(y));

            lineBackground1()

            // Add the lines
            let line = d3.line()
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
        })();

        (function () {
            /**
             * This block is for colum graph
             **/
                // set the dimensions and margins of the graph
            let margin = {top: 10, right: 30, bottom: 20, left: 50},
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
                    let index = subgroups.indexOf(type);
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

                let svg = d3.select("#my_dataviz")
                    .append("svg")
                    .attr("width", width + margin.left + margin.right)
                    .attr("height", height + margin.top + margin.bottom)
                    .append("g")
                    .attr("transform",
                        "translate(" + margin.left + "," + margin.top + ")");


                // List of subgroups = header of the csv files = soil condition here
                //let subgroups = data.columns.slice(1)

                // List of groups = species here = value of the first column called group -> I show them on the X axis
                let groups = d3.map(data, function (d) {
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
                let x = d3.scaleBand()
                    .domain(groups)
                    .range([0, width])
                    .paddingInner([0.3])
                svg.append("g")
                    .attr("transform", "translate(0," + height + ")")
                    .call(d3.axisBottom(x).tickSize(6));

                // Add Y axis
                let y = d3.scaleLinear()
                    .domain([0, 200])
                    .range([height, 0]);
                svg.append("g")
                    .call(d3.axisLeft(y));

                // Another scale for subgroup position?
                let xSubgroup = d3.scaleBand()
                    .domain(subgroups)
                    .range([0, x.bandwidth()])
                    .paddingInner([0.1]);
                // color palette = one color per subgroup
                let color = d3.scaleOrdinal()
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
        })();
    </script>

    <script src="https://d3js.org/d3.v3.min.js"></script>
    <script src="https://d3js.org/topojson.v1.min.js"></script>
    <script type="text/javascript" src="{{ asset('assets/dashboard/bd-map-assets/d3.geo.min.js') }}"></script>
    <script type="text/javascript">
        (function () {
            let w = 300;
            let h = 340;
            let proj = d3.geo.mercator();
            let path = d3.geo.path().projection(proj);
            let t = proj.translate(); // the projection's default translation
            let s = proj.scale() // the projection's default scale

            let buckets = 9,
                colors = ["#ffffd9", "#edf8b1", "#c7e9b4", "#7fcdbb", "#41b6c4", "#1d91c0", "#225ea8", "#253494", "#081d58"]; // alternatively colorbrewer.YlGnBu[9]

            let map = d3.select("#bd_map_d3")
                .append("svg:svg")
                //.attr("viewBox", "397 205 86 122")
                .attr("width", w)
                .attr("height", h)
                .attr("class", "svg_map")
                //.call(d3.behavior.zoom().on("zoom", redraw))
                .call(initialize);

            let bangladesh = map.append("svg:g")
                .attr("id", "bangladesh");

            let div = d3.select("body").append("div")
                .attr("class", "tooltip")
                .style("opacity", 0);


            let url = "{{ asset('assets/dashboard/bd-map-assets/bangladesh_upozila_map.json') }}";
            d3.json(url, function (json) {

                $('#map_select').on('change', function () {
                    let district = $('#map_select option:selected').text();
                    district = district.toLowerCase();
                    const words = district.split(" ");

                    for (let i = 0; i < words.length; i++) {
                        words[i] = words[i][0].toUpperCase() + words[i].substr(1);
                    }
                    district = words.join(" ");

                    let maxTotal = d3.max(json.features, function (d) {
                        return d.properties.ADM2_EN;
                    });

                    let colorScale = d3.scale.quantile()
                        .domain(d3.range(buckets).map(function (d) {
                            return (d / buckets) * maxTotal;
                        }))
                        .range(colors);


                    let y = d3.scale.sqrt()
                        .domain([0, 10000])
                        .range([0, 300]);

                    let yAxis = d3.svg.axis()
                        .scale(y)
                        .tickValues(colorScale.domain())
                        .orient("right");

                    bangladesh.selectAll("path")
                        .data(json.features)
                        .enter().append("path")
                        .attr("d", path)
                        .style("opacity", 0.5)
                        .attr('class', 'bd')
                        .filter((d) => d.properties.ADM2_EN == district)

                        .on('mouseover', function (d, i) {
                            if ($('.map_info').hide()) {
                                $('.map_info').show();
                                $("#district").text(d.properties.ADM3_EN + " Thana");
                                $("#running_courses").text(Math.floor(Math.random() * 6) + 10);
                                $("#running_students").text(Math.floor(Math.random() * 9) + 250);
                                $("#total_enrollment").text(Math.floor(Math.random() * 5) + 50);
                            }

                            d3.select(this).transition().duration(300).style("opacity", 1);
                            div.transition().duration(300)
                                .style("opacity", .9)
                                .text(d.properties.ADM3_EN + " - " + d.properties.ADM2_EN)
                                .style("color", "#fff")
                                .style("padding", "5px 5px")
                                .style("border", "1px solid #fff")
                                .style("font-weight", " bold")
                                .style("background", "#333")
                                .style("top", (d3.event.pageY - 10) + "px")
                                .style("left", (d3.event.pageX + 10) + "px");
                        })

                        .on('mouseleave', function (d, i) {
                            if ($('.map_info').show()) {
                                $('.map_info').hide();
                            }

                            d3.select(this).transition().duration(300)
                                .style("opacity", 0.5);
                            div.transition().duration(300)
                                .style("opacity", 0);
                        })

                        .forEach(a => {
                            a.forEach(v => {
                                // console.log(v)
                                let r = Math.floor(100 + Math.random() * 155)
                                let g = Math.floor(100 + Math.random() * 55)
                                let b = Math.floor(100 + Math.random() * 55)
                                v.setAttribute('fill', `rgb(${r},${g},${b})`)
                            })
                        });

                    bangladesh.selectAll("path").transition().duration(300)
                        .style("fill", function (d) {
                            return colorScale(d.properties.DIVISION);
                        });
                    console.log('BD >> ', bangladesh);

                    //Remove unnecessary path
                    bangladesh.selectAll('path')
                        .filter((d) => d.properties.ADM2_EN != district).remove();
                    //viewBox
                    let box = bangladesh[0][0].getBBox()
                    map.attr("viewBox", `${box.x} ${box.y} ${box.width} ${box.height}`)
                })


            });

            function initialize() {
                proj.scale(6700);
                proj.translate([-1240, 720]);
            }
        })();
    </script>

@endpush

