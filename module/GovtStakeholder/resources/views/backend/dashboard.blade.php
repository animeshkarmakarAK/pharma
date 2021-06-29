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
            padding: 7px 30px;
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
            stroke-width: 0.03;
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
            box-shadow: 0 0 2px 0 #a6a6a6;
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
            bottom: 6px;
            right: 6px;
            opacity: .8;
            font-size: 12px;
            background: #f2f7f8;
            border-radius: 5px;
            /*max-height: 190px;*/
            min-width: 192px;
        }

        .svg_map {
            margin-bottom: 50px !important;
        }

        .map_content_top {
            padding: 15px 10px 0 10px;
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
                        background: url({{ asset("/assets/dashboard/2.png") }}) no-repeat center;">
                        <i class="fa fa-industry sticker-icon"></i>
                    </div>

                    <div class="sticker-count">
                        <a href="{{--{{ route('govt_stakeholder::admin.institutes.index') }}--}}">104{{--{{ $stickerCount['total_institute']? $stickerCount['total_institute']:'0' }}--}}</a>
                    </div>
                    <div class="sticker-title">
                        শিল্প প্রতিষ্ঠান
                    </div>
                </div>
            </div>
            <div class="flex-fill mx-2">
                <div class="sticker-area text-center youth-sticker">
                    <div class="sticker-body" id="pentagon" style="
                        height: 80px;
                        background: url({{ asset("/assets/dashboard/1.png") }}) no-repeat center; ">
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
                        background: url({{ asset("/assets/dashboard/3.png") }}) no-repeat center; ">
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
                        background: url({{ asset("/assets/dashboard/5.png") }}) no-repeat center; ">
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
                        background: url({{ asset("/assets/dashboard/4.png") }}) no-repeat center; ">
                        <i class="fas fa-chalkboard-teacher sticker-icon"></i>
                    </div>

                    <div class="sticker-count">
                        <a href="#">231</a>
                    </div>
                    <div class="sticker-title">
                        প্রশিক্ষণ প্রতিষ্ঠান
                    </div>
                </div>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header text-white bg-maroon">
                                <h3 class="card-title font-weight-bold">বিগত ৬ মাসের হিসাব</h3>
                            </div>
                            <div class="card-body">
                                <div id="employment_statistic"></div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header text-white bg-primary">
                                <h3 class="card-title font-weight-bold">সেক্টর ভিত্তিক জনবল</h3>
                            </div>
                            <div class="card-body">
                                <div id="job_sector_statistic"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="col-md-6">
                <div class="card" style="height: 100%">
                    <div class="card-header text-white" style="background-color:#c665e6;">
                        <h3 class="map-type-title card-title font-weight-bold">{{ $authUser->isDivcomUser()  ? "বিভাগ মানচিত্র" : "জেলা মানচিত্র"}}</h3>
                    </div>
                    <div class="card-body">
                        @if($authUser->isDCUser())
                            <select class="select2-ajax-wizard"
                                    name="map_select"
                                    id="map_select"
                                    data-model="{{base64_encode(\App\Models\LocDistrict::class)}}"
                                    data-filters="{{json_encode(['id' => $authUser->loc_district_id])}}"
                                    data-preselected-option="{{json_encode(['text' =>  $authUser->locDistrict->title_en, 'id' =>  $authUser->loc_district_id])}}"
                                    data-label-fields="{title_en}"
                                    data-placeholder="Select District"
                            >
                            </select>
                        @elseif($authUser->isDivcomUser())
                            <select class="select2-ajax-wizard"
                                    name="map_select"
                                    id="map_select"
                                    data-model="{{base64_encode(\App\Models\LocDivision::class)}}"
                                    data-filters="{{json_encode(['id' => $authUser->loc_division_id])}}"
                                    data-preselected-option="{{json_encode(['text' =>  $authUser->locDivision->title_en, 'id' =>  $authUser->loc_division_id])}}"
                                    data-label-fields="{title_en}"
                                    data-placeholder="Select Division"
                            >
                            </select>
                        @else
                            <select class="select2-ajax-wizard"
                                    name="map_select"
                                    id="map_select"
                                    data-model="{{base64_encode(\App\Models\LocDistrict::class)}}"
                                    data-label-fields="{title_en}"
                                    data-placeholder="Select District"
                            >
                            </select>
                        @endif
                        {{--<div id="map_message">
                            <br>
                            <h3 class="text-shadow-light text-center" style="color: #777f85;">Please select <strong>District</strong> to view map</h3>
                        </div>--}}
                        <div id="bd_map_d3" style="display: none"></div>
                        <div class="map_info" style="display: none">
                            <div class="map_content_top">
                                <p><b><span id="district"></span></b></p>
                            </div>
                            <hr>
                            <div class="map_content_body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-2">
                                            <p class="mb-0"><i class="fa fa-circle text-red" aria-hidden="true"></i>
                                                Total Unemployed</p>
                                            <strong id="total_unemployed" class="map_count_numbers"></strong>
                                        </div>
                                        <div class="mb-2">
                                            <p class="mb-0"><i class="fa fa-circle text-green" aria-hidden="true"></i>
                                                Total Employed</p>
                                            <b id="total_employed" class="map_count_numbers"></b>
                                        </div>
                                        <div class="mb-2">
                                            <p class="mb-0"><i class="fa fa-circle text-blue" aria-hidden="true"></i>
                                                Total Vacancy</p>
                                            <b id="total_vacancy" class="map_count_numbers"></b>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-2">
                                            <p class="mb-0"><i class="fa fa-circle" style="color: #b3de4a"
                                                               aria-hidden="true"></i>
                                                Total New Recruitment</p>
                                            <strong id="total_new_recruitment" class="map_count_numbers"></strong>
                                        </div>
                                        <div class="mb-2">
                                            <p class="mb-0"><i class="fa fa-circle" style="color: #f368e0"
                                                               aria-hidden="true"></i>
                                                Total New Skilled Youth</p>
                                            <b id="total_new_skilled_youth" class="map_count_numbers"></b>
                                        </div>
                                        <div class="mb-2">
                                            <p class="mb-0"><i class="fa fa-circle" style="color: #9b4ade"
                                                               aria-hidden="true"></i>
                                                Total Skilled Youth</p>
                                            <b id="total_skilled_youth" class="map_count_numbers"></b>
                                        </div>
                                    </div>
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
                                            <select class="form-control" id="month-list"
                                                    style="width: 18vh; margin-right: 2px;">
                                                @foreach(getMonthList('bn') as $key => $month)
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
                                <table class="table table-bordered dataTable" id="dataTable2"
                                       style="background-color: #ffffff">
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
                                <table class="table table-bordered dataTable" id="dataTable4"
                                       style="background-color: #ffffff">
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
        let data = @json($data);
        let windowWidth = window.innerWidth;

        $('.navTabs').on('click', function (event) {
            $('.navTabs').removeClass('active')
            $(this).addClass('active')
        })
        let loc_division_id;
        const isUserDivisionCommissioner = {!! $authUser->isDivcomUser() ? 1 : 0!!};

        $(function () {

            if (isUserDivisionCommissioner){
                loc_division_id = $('#map_select').val();
            }

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
                d.loc_division_id = loc_division_id;
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

            params1.ajax.data = d => {
                d.loc_division_id = loc_division_id;
            };
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
                        title: "কর্মখালি",
                        data: "sum_vacancy",
                        name: "sum_vacancy"
                    },
                ]
            });
            params2.dom = "<'row'<'col-sm-12'tr>>";
            params2.ajax.data = d => {
                d.loc_division_id = loc_division_id;
            };

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

            params3.ajax.data = d => {
                d.loc_division_id = loc_division_id;
            };
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
            params4.ajax.data = d => {
                d.loc_division_id = loc_division_id;
            };
            const datatable4 = $('#dataTable4').DataTable(params4);

            $('a[href = "#skilled"]').on('click', function () {
                setTimeout(function () {
                    datatable4.draw();
                }, 200)
            })
        });

        (function () {

            if (data == [] || !data.employment_statistic) {
                $("#employment_statistic").html('No Data Found')
                return null;
            }

            console.table('data', data);

            // set the dimensions and margins of the graph
            let margin = {top: 40, right: 80, bottom: 30, left: 50}, //add
                width = Math.abs(windowWidth / 2.7) - margin.left - margin.right,
                height = 300 - margin.top - margin.bottom;

            // append the svg object to the body of the page
            let svg1 = d3.select("#employment_statistic")
                .append("svg")
                .attr("width", width + margin.left + margin.right)
                .attr("height", height + margin.top + margin.bottom)
                .append("g")
                .attr("transform",
                    "translate(" + margin.left + "," + margin.top + ")");

            let xaxisLabels = [];
            let highestValue = 0;
            let employment_statistic_data = data.employment_statistic.map((item, index) => {
                for (const [key, value] of Object.entries(item)) {
                    highestValue = parseInt(value) > highestValue ? parseInt(value) : highestValue;
                }
                xaxisLabels.push(item.survey_date);
                item['time'] = '' + (index + 1)
                return item
            })
            let employment_statistic_data_group = [{total_unemployed: 'কর্মহীন'}, {total_employed: 'কর্মরত'}, {total_skilled_youth: 'নতুন দক্ষ জনবল'}, {total_vacancy: 'কর্মখালি'}, {total_new_recruitment: 'নিয়োগ'}]


            // Reformat the data: we need an array of arrays of {x, y} tuples
            let dataReady = employment_statistic_data_group.map(function (data) { // .map allows to do something for each element of the list
                return {
                    key: Object.keys(data)[0],
                    name: data[Object.keys(data)[0]],
                    values: employment_statistic_data.map(function (d) {
                        return {time: d.survey_date, value: +d[Object.keys(data)[0]]};
                    })
                };
            });
            // I strongly advise to have a look to dataReady with
            console.log('dataReady', dataReady);
            //custom line add to graph background
            let lineBackground1 = (data = [0, 1, 2, 3, 4]) => {
                return data.map((i) => {
                    return svg1.append('line')
                        .attr('x1', 0)
                        .attr('y1', (height / 5) * i) //add
                        .attr('x2', width) //add
                        .attr('y2', (height / 5) * i) //add
                        .attr('stroke', 'gray')
                        .attr('stroke-width', 0.2)
                })
            }


            // A color scale: one color for each group
            let myColor = d3.scaleOrdinal()
                .domain(employment_statistic_data_group)
                .range(["#66c2a5", "#fc8d62", "#8da0cb", "#e78ac3", "#a6d854"]);

            console.log('width', width)
            // Add X axis --> it is a date format
            let x = d3.scaleBand()
                .domain(xaxisLabels)
                .range([0, width]);
            svg1.append("g")
                .attr("transform", "translate(0," + height + ")")
                .call(d3.axisBottom(x));

            // Add Y axis
            let y = d3.scaleLinear()
                .domain([0, highestValue])
                .range([height, 0]);
            svg1.append("g")
                .call(d3.axisLeft(y));

            lineBackground1()

            // Add the lines
            let line = d3.line()
                .x(function (d) {
                    return x(d.time)
                })
                .y(function (d) {
                    return y(+d.value)
                })
            svg1.selectAll("myLines")
                .data(dataReady)
                .enter()
                .append("path")
                .attr("class", function (d) {
                    return d.key
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
                    return d.key
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
                    return d.key
                })
                .datum(function (d) {
                    return {name: d.name, value: d.values[d.values.length - 1]};
                }) // keep only the last value of each time series
                .attr("transform", function (d) {
                    return "translate(" + x(d.value.time) + "," + y(d.value.value) + ")";
                }) // Put the text at the position of the last point
                .attr("x", -5) // shift the text a bit more right
                .attr("y", -5) // shift the text a bit more right
                .text(function (d) {
                    return d.name;
                })
                .style("fill", function (d) {
                    return myColor(d.name)
                })
                .style("font-size", 12)

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
                .attr('y', -24) //add
                .text(function (d) {
                    return d.name;
                })
                .style("fill", function (d) {
                    return myColor(d.name)
                })
                .style("font-size", 15)
                .on("click", function (d) {
                    // is the element currently visible ?
                    currentOpacity = d3.selectAll("." + d.key).style("opacity")
                    // Change the opacity: from 0 to 1 or from 1 to 0
                    d3.selectAll("." + d.key).transition().style("opacity", currentOpacity == 1 ? 0 : 1)
                })
        })();

        (function () {
            /**
             * This block is for colum graph
             **/
            if (data == [] || !data.job_sector_statistic) {
                $("#job_sector_statistic").html('No Data Found')
                return null;
            }

            // set the dimensions and margins of the graph
            let margin = {top: 25, right: 20, bottom: 150, left: 100},
                width = Math.abs(windowWidth / 3) - margin.left - margin.right,
                height = 500 - margin.top - margin.bottom;

            // append the svg object to the body of the page

            // Parse the Data
            let job_sector_statistic_data = data['job_sector_statistic']

            let highestValue = 0;
            data.job_sector_statistic.map((item, index) => {
                for (const [key, value] of Object.entries(item)) {
                    highestValue = parseInt(value) > highestValue ? parseInt(value) : highestValue;
                }
            })


            let subgroups = ['Employed', 'UnEmployed']
            let subgroupsKey = [{key: "Employed", name: "কর্মরত"}, {key: "UnEmployed", name: "কর্মহীন"}]
            let colorCodes = ['#2f49d1', '#f52674']

            graph(job_sector_statistic_data)

            function xAxis(g) {
                return g.attr("transform", `translate(0,${height - margin.bottom})`)
                    .call(d3.axisBottom(x)
                        .tickSizeOuter(0))
            }

            function graph(data) {
                let svg = d3.select("#job_sector_statistic")
                    .append("svg")
                    .attr("width", width + margin.left + margin.right)
                    .attr("height", height + margin.top + margin.bottom)
                    .append("g")
                    .attr("transform",
                        "translate(" + margin.left + "," + margin.top + ")");


                // List of groups = species here = value of the first column called group -> I show them on the X axis
                let groups = d3.map(data, function (d) {
                    return (d.sector)
                }).keys()

                let lineBackground = (data = [0, 1, 2, 3, 4]) => {
                    return data.map((i) => {
                        return svg.append('line')
                            .attr('x1', 0)
                            .attr('y1', (highestValue / 27) * i)
                            .attr('x2', width)
                            .attr('y2', (highestValue / 27) * i)
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
                    .call(d3.axisBottom(x).tickSize(6))
                    .selectAll("text")
                    .attr("transform", "translate(-10,0)rotate(-45)")
                    .style("text-anchor", "end");

                // Add Y axis
                let y = d3.scaleLinear()
                    .domain([0, highestValue])
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
                        return "translate(" + x(d.sector) + ",0)";
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
                    })
                    .attr("class", function (d) {
                        return d.key
                    });

                svg
                    .selectAll("myLegend")
                    .data(subgroupsKey)
                    .enter()
                    .append('g')
                    .append("text")
                    .attr('x', function (d, i) {
                        return i == 3 ? 30 + i * 100 : 30 + i * 60
                    })
                    .attr('y', -10) //add
                    .text(function (d) {
                        return d.name;
                    })
                    .style("fill", function (d) {
                        return color(d.key)
                    })
                    .style("font-size", 15)
                    .on("click", function (d) {
                        // is the element currently visible ?
                        currentOpacity = d3.selectAll("." + d.key).style("opacity")
                        // Change the opacity: from 0 to 1 or from 1 to 0
                        d3.selectAll("." + d.key).transition().style("opacity", currentOpacity == 1 ? 0 : 1)
                    });
            }
        })
        ();
    </script>

    <script src="https://d3js.org/d3.v3.min.js"></script>
    <script src="https://d3js.org/topojson.v1.min.js"></script>
    <script type="text/javascript" src="{{ asset('assets/dashboard/bd-map-assets/d3.geo.min.js') }}"></script>
    <script type="text/javascript">
        (function () {
            let selectedDistroctData = [];
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


            //let url = "{{ asset('assets/dashboard/bd-map-assets/bangladesh_upozila_map.json') }}";
            let url = "{{ asset('assets/dashboard/bd-map-assets/small_bangladesh_geojson_adm3_492_upozila.json') }}";
            d3.json(url, function (json) {
                const getMap = () => {
                    $('#bd_map_d3').show();
                    let districtElm = $('#map_select option:selected');
                    let district = districtElm.text().toLowerCase();

                    let division_id = $('#loc_division_id option:selected').val();

                    $.ajax({
                        data: {district_id: division_id},
                        url: "{{ route('admin.admin-dashboard-upazila-job-statistic') }}",
                        type: 'POST',
                        success: function (data) {
                            selectedDistroctData = data;
                        }
                    });

                    const words = district.split(" ");

                    for (let i = 0; i < words.length; i++) {
                        words[i] = words[i][0]?.toUpperCase() + words[i].substr(1);
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
                        .attr("class", "labels")
                        .on('mouseover', function (d, i) {
                            let districtId = $('#map_select').val();
                            let upazilaName = d.properties.ADM3_EN;
                            console.log('districtId: ' + districtId + 'Thana: ' + d.properties.ADM3_EN);
                            let upazilaStatistics = selectedDistroctData.find((item) => item?.upazila_title?.toString().toLowerCase() === upazilaName.toLowerCase());
                            console.table(upazilaStatistics)
                            if ($('.map_info').hide()) {
                                $('.map_info').show();
                                $('#map_message').hide();
                                $("#district").text(d.properties.ADM3_EN + " Thana");
                                $("#total_unemployed").text(upazilaStatistics?.total_unemployed);
                                $("#total_employed").text(upazilaStatistics?.total_employed);
                                $("#total_vacancy").text(upazilaStatistics?.total_vacancy);
                                $("#total_new_recruitment").text(upazilaStatistics?.total_new_recruitment);
                                $("#total_new_skilled_youth").text(upazilaStatistics?.total_new_skilled_youth);
                                $("#total_skilled_youth").text(upazilaStatistics?.total_skilled_youth);
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
                                $("#total_unemployed").text('0');
                                $("#total_employed").text('0');
                                $("#total_vacancy").text('0');
                                $("#total_new_recruitment").text('0');
                                $("#total_new_skilled_youth").text('0');
                                $("#total_skilled_youth").text('0');
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


                    //Remove unnecessary path
                    bangladesh.selectAll('path')
                        .filter((d) => d.properties.ADM2_EN != district).remove();

                    //Remove unnecessary label
                    bangladesh.selectAll('text')
                        .filter((d) => d.properties.ADM2_EN != district).remove();


                    //viewBox
                    let box = bangladesh[0][0].getBBox()
                    map.attr("viewBox", `${box.x} ${box.y} ${box.width} ${box.height}`);
                }
                getMap();

                $('#map_select').on('change', function () {
                    getMap();
                });
            });

            function initialize() {
                proj.scale(6700);
                proj.translate([-1240, 720]);
            }
        })();
    </script>


@endpush

