@extends('master::layouts.master')
@php
    /** @var \App\Models\User $authUser */
    $authUser = \App\Helpers\Classes\AuthHelper::getAuthUser();
@endphp


@push('js')
    <script src="https://d3js.org/d3.v4.js"></script>
@endpush

@section('content')
    <div class="container-fluid">
        <div class="row my-3">
            <div class="col-md-3">
                <div class="p-3 text-center rounded mb-2 text-white"
                     style="background: rgb(188,97,235);
                            background: linear-gradient(55deg,rgba(188,97,235,1) 24%, rgba(215,106,225,1) 71%);">
                    <h1><b>{{ $data['total_course']? $data['total_course']:'0' }}</b></h1>
                    <p>{{ __('generic.total_course') }}</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="p-3 text-center rounded mb-2 text-white"
                     style="background: rgb(123,142,207);
                            background: linear-gradient(55deg, rgba(123,142,207,1) 24%, rgba(94,127,241,1) 71%);">
                    <h1><b>{{ $data['total_youth']? $data['total_youth']:'0' }}</b></h1>
                    <p>{{ __('generic.total_enroll') }}</p>
                </div>
            </div>

            <div class="col-md-3">
                <div class="p-3 text-center rounded mb-2 text-white"
                     style="background: rgb(75,255,243);
                            background: linear-gradient(1deg,rgba(75,255,243,1) 22%, rgba(53,217,206,1) 71%);">
                    <h1><b>{{ $data['total_course']? $data['total_course']:'0' }}</b></h1>
                    <p>{{ __('generic.certificate_issue') }}</p>
                </div>
            </div>

            <div class="col-md-3">
                <div class="p-3 text-center rounded mb-2 text-white"
                     style="background: rgb(253,134,71);background: linear-gradient(146deg, rgba(253,134,71,1) 22%, rgba(252,159,110,1) 71%);">
                    <h1><b>{{ $data['total_course']? $data['total_course']:'0' }}</b></h1>
                    <p>{{ __('generic.trending_course') }}</p>
                </div>
            </div>

            <div class="col-md-3">
                <div class="p-3 text-center rounded mb-2 text-white"
                     style="background: rgb(51,192,128);background: linear-gradient(233deg, rgba(51,192,128,1) 22%, rgba(89,205,153,1) 71%);">
                    <h1><b>{{ $data['total_course']? $data['total_course']:'0' }}</b></h1>
                    <p>{{ __('generic.industry_demand') }}</p>
                </div>
            </div>

            <div class="col-md-3">
                <div class="p-3 text-center rounded mb-2 text-white"
                     style="background: rgb(248,114,177);background: linear-gradient(75deg, rgba(248,114,177,1) 22%, rgba(222,32,122,1) 71%);">
                    <h1><b>{{ $data['totalBatch']? $data['totalBatch']:'0' }}</b></h1>
                    <p>{{ __('generic.total_batch') }}</p>
                </div>
            </div>

            <div class="col-md-3">
                <div class="p-3 text-center rounded mb-2 text-white"
                     style="background: rgb(237,65,65);background: linear-gradient(180deg, rgba(237,65,65,1) 22%, rgba(240,107,107,1) 71%);">
                    <h1><b>{{ $data['total_course']? $data['total_course']:'0' }}</b></h1>
                    <p>{{ __('generic.running_student') }}</p>
                </div>
            </div>

            <div class="col-md-3">
                <div class="p-3 text-center rounded mb-2 text-white"
                     style="background: rgb(222,19,193);background: linear-gradient(113deg, rgba(222,19,193,1) 22%, rgba(243,104,224,1) 71%);">
                    <h1><b>{{ $data['total_course']? $data['total_course']:'0' }}</b></h1>
                    <p>{{ __('generic.number_of_trainers') }}</p>
                </div>
            </div>

        </div>

        <div class="row mb-3">
            <div class="col-md-8">
                <div class="card" style="border-radius: 10px; height: 100%">
                    <div style="margin: 10px">
                        <h3 class="card-title font-weight-bold" style="margin-top: 20px">{{ __('generic.most_demandable_course') }}</h3>
                    </div>
                    <div class="card-body">
                        <div id="my_data"></div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card" style="border-radius: 10px; height: 100%">
                    <div class="card-body">
                        <label>{{ __('generic.institute_calender') }}</label>
                        <div id='calendar'></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-8">
                <div class="card" style="border-radius: 10px; height: 100%">
                    <div class="card-header">
                        <h3 class="card-title font-weight-bold" style="margin-top: 20px">{{ __('generic.trending_jobs') }}</h3>
                        <div class="card-tools">
                            <select class="form-control" style="">
                                <option value="1" selected>2021</option>
                                <option value="2">2020</option>
                                <option value="3">2019</option>
                                <option value="4">2018</option>
                            </select>
                        </div>
                    </div>
                    <div class="card-body">
                        <div id="my_dataviz" style="background-color: #ffffff; margin-left: -3px"></div>
                        <div style="height: 1px; margin-top: 5px; background-color: #f4f4f4"></div>
                        <div class="row mt-3" style="margin-left: 30px; margin-bottom: -20px" id="graphRadio">
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card" style=" border-radius: 10px; height: 100%">
                    <div class="card-body">
                        <label>{{ __('generic.map') }}</label>
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
    </div>

    <div class="row">
        <div class="col-sm-10 mx-auto">
            <div class="modal modal-danger fade" tabindex="-1" id="course_details_modal" role="dialog">
                <div class="modal-dialog" style="max-width: 100%;">
                    <div class="modal-content modal-xlg" style="background-color: #e6eaeb">
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script src="https://d3js.org/d3-scale-chromatic.v1.min.js"></script>
    <script>

        (function (newD3) {
            let margin = {top: 20, right: 0, bottom: 40, left: 60},
                width = 560 - margin.left - margin.right,
                height = 300 - margin.top - margin.bottom;

            // append the svg object to the body of the page
            let svg = newD3.select("#my_data")
                .append("svg")
                .attr("width", width + margin.left + margin.right)
                .attr("height", height + margin.top + margin.bottom)
                .append("g")
                .attr("transform",
                    "translate(" + margin.left + "," + margin.top + ")");

            // Parse the Data

            let testData = [
                {Country: "ওয়েল্ডিং", Value: "7148"},
                {Country: "কম্পিউটার অপারেটিং", Value: "6653"},
                {Country: "মোবাইল সার্ভিসিং", Value: "5162"},
                {Country: "অফিস ব্যবস্থাপনা", Value: "4131"},
                {Country: "বিক্রয়কর্মী", Value: "3714"}]

            d3Chart(testData)

            function d3Chart(data) {

                // Add X axis

                let x = newD3.scaleLinear()
                    .domain([0, 8000])
                    .range([0, width]);


                // Y axis
                let y = newD3.scaleBand()
                    .range([0, height])
                    .domain(data.map(function (d) {
                        return d.Value;
                    }))
                    .padding(.1);
                svg.append("g")
                    .call(newD3.axisLeft(y))

                //Bars
                svg.selectAll("myRect")
                    .data(data)
                    .enter()
                    .append("rect")
                    .attr('class', 'bar')
                    .attr("x", x(0))
                    .attr("y", function (d) {
                        return y(d.Value);
                    })
                    .attr("width", function (d) {
                        return x(d.Value);
                    })
                    .attr("height", y.bandwidth())
                    .attr("fill", "rgba(227,227,227,0.71)");

                let yPadding = [215, 170, 125, 80, 33]


                svg.selectAll("myRect")
                    .data(data)
                    .enter()
                    .append('text').text(function (d) {
                    return d.Country;
                })
                    .attr("x", 10)
                    .attr('y', function () {
                        return yPadding.pop();
                    }).attr("font-size", "12px");
            }
        })(d3)

        // set the dimensions and margins of the graph


    </script>

    <script>

        (function (chakiD3) {
            let margin = {top: 10, right: 20, bottom: 30, left: 90},
                width = 560 - margin.left - margin.right,
                height = 300 - margin.top - margin.bottom;

            // append the svg object to the body of the page

            let dataSet = [
                {
                    time: "1",
                    ডিজাইন: "20",
                    বিক্রয়কর্মী: "350",
                    ব্যবস্থাপনা: "130",
                    সার্ভিসিং: "200",
                    অপারেটিং: "20",
                    ওয়েল্ডিং: '400'
                },
                {
                    time: "1",
                    ডিজাইন: "20",
                    বিক্রয়কর্মী: "50",
                    ব্যবস্থাপনা: "100",
                    সার্ভিসিং: "200",
                    অপারেটিং: "20",
                    ওয়েল্ডিং: '400'
                },
                {
                    time: "2",
                    ডিজাইন: "150",
                    বিক্রয়কর্মী: "400",
                    ব্যবস্থাপনা: "104",
                    সার্ভিসিং: "340",
                    অপারেটিং: "340",
                    ওয়েল্ডিং: '300'
                },
                {
                    time: "3",
                    ডিজাইন: "250",
                    বিক্রয়কর্মী: "449",
                    ব্যবস্থাপনা: "316",
                    সার্ভিসিং: "350",
                    অপারেটিং: "211",
                    ওয়েল্ডিং: '200'
                },
                {
                    time: "4",
                    ডিজাইন: "307",
                    বিক্রয়কর্মী: "400",
                    ব্যবস্থাপনা: "412",
                    সার্ভিসিং: "8",
                    অপারেটিং: "313",
                    ওয়েল্ডিং: '400'
                },
                {
                    time: "5",
                    ডিজাইন: "383",
                    বিক্রয়কর্মী: "348",
                    ব্যবস্থাপনা: "270",
                    সার্ভিসিং: "20",
                    অপারেটিং: "315",
                    ওয়েল্ডিং: '450'
                },
                {
                    time: "5",
                    ডিজাইন: "383",
                    বিক্রয়কর্মী: "348",
                    ব্যবস্থাপনা: "270",
                    সার্ভিসিং: "20",
                    অপারেটিং: "315",
                    ওয়েল্ডিং: '450'
                }
            ]
            //Read the data

            // List of groups (here I have one group per column)
            let allGroup = [{ডিজাইন: 'ডিজাইন'}, {বিক্রয়কর্মী: 'বিক্রয়কর্মী'}, {ব্যবস্থাপনা: 'ব্যবস্থাপনা'}, {সার্ভিসিং: 'সার্ভিসিং'}, {অপারেটিং: 'অপারেটিং'}, {ওয়েল্ডিং: 'ওয়েল্ডিং'}]
            let colorList = ["#66c2a5", "#fc8d62", "#8da0cb", "#e78ac3", "#a6d854", "#e5c494"]
            let nameColor = {
                'ডিজাইন': "#66c2a5",
                'বিক্রয়কর্মী': "#fc8d62",
                'ব্যবস্থাপনা': "#8da0cb",
                'সার্ভিসিং': "#e78ac3",
                'অপারেটিং': "#a6d854",
                'ওয়েল্ডিং': "#e5c494"
            }

            let html = ''
            for (const [key, value] of Object.entries(nameColor)) {
                //console.log(`${key}: ${value}`);
                html += '<div class="row  col-4 toggolItem" name="' + key + '"> ' +
                    '<div class="colorIndicator" style="background-color:' + value + '"></div> ' +
                    '<p>' + key + '</p> ' +
                    '</div>'
            }

            $('#graphRadio').html(html)

            function dataSwitch(type) {
                let status = true
                for (index in allGroup) {
                    if (Object.keys(allGroup[index])[0] == type) {
                        allGroup.splice(index, 1)
                        colorList.splice(index, 1)
                        status = false
                    }
                }
                if (status) {
                    allGroup.push({[type]: type})
                    colorList.push(nameColor[type])
                }
                $('#my_dataviz').html('')
                console.log(allGroup, colorList)
                graphCreate()
            }

            $(document).on('click', '.toggolItem', function () {
                dataSwitch($(this).attr('name'))
            })


            graphCreate()

            function graphCreate() {

                let svg1 = chakiD3.select("#my_dataviz")
                    .append("svg")
                    .attr("width", width + margin.left + margin.right)
                    .attr("height", height + margin.top + margin.bottom)
                    .append("g")
                    .attr("transform",
                        "translate(" + margin.left + "," + margin.top + ")");


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
                            .attr("transform", "translate(0,.3)")
                    })
                }


                // A color scale: one color for each group
                let myColor = chakiD3.scaleOrdinal()
                    .domain(allGroup)
                    .range(colorList);

                // Add X axis --> it is a date format
                let x = chakiD3.scaleLinear()
                    .domain([1, 5])
                    .range([0, width]);
                svg1.append("g")
                    .attr("transform", "translate(0," + height + ")")
                    .call(chakiD3.axisBottom(x));

                // Add Y axis
                let y = chakiD3.scaleLinear()
                    .domain([0, 500])
                    .range([height, 0]);
                svg1.append("g")
                    .call(chakiD3.axisLeft(y));

                lineBackground1()

                // Add the lines
                let line = chakiD3.line()
                    .curve(chakiD3.curveCatmullRomOpen)
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
                    .attr("x", 6) // shift the text a bit more right
                    .style("fill", function (d) {
                        return myColor(d.name)
                    })
                    .style("font-size", 4)

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
                    /*.text(function (d) {
                        return d.name;
                    })*/
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
            }
        })(d3);

        // set the dimensions and margins of the graph


    </script>


    {{--Map d3js js--}}
    <script src="https://d3js.org/d3.v3.min.js"></script>
    <script src="https://d3js.org/topojson.v1.min.js"></script>
    <script type="text/javascript" src="{{ asset('assets/dashboard/bd-map-assets/d3.geo.min.js') }}"></script>
    <script type="text/javascript">
        var w = 300;
        var h = 340;
        var proj = d3.geo.mercator();
        var path = d3.geo.path().projection(proj);
        var t = proj.translate(); // the projection's default translation
        var s = proj.scale() // the projection's default scale

        var buckets = 9,
            colors = ["#ffffd9", "#edf8b1", "#c7e9b4", "#7fcdbb", "#41b6c4", "#1d91c0", "#225ea8", "#253494", "#081d58"]; // alternatively colorbrewer.YlGnBu[9]

        var map = d3.select("#bd_map_d3")
            .append("svg:svg")
            .attr("viewBox", "397 205 86 122")
            /*.attr("width", w)
            .attr("height", h)*/
            //.call(d3.behavior.zoom().on("zoom", redraw))
            .call(initialize);

        var bangladesh = map.append("svg:g")
            .attr("id", "bangladesh");

        var div = d3.select("body").append("div")
            .attr("class", "tooltip")
            .style("opacity", 0);


        let url = "{{ asset('assets/dashboard/bd-map-assets/small_bangladesh_geojson_adm2_64_districts_zillas.json') }}";//offline json
        d3.json(url, function (json) {

            var maxTotal = d3.max(json.features, function (d) {
                return d.properties.ADM2_EN;
            });

            var colorScale = d3.scale.quantile()
                .domain(d3.range(buckets).map(function (d) {
                    return (d / buckets) * maxTotal
                }))
                .range(colors);


            var y = d3.scale.sqrt()
                .domain([0, 10000])
                .range([0, 300]);

            var yAxis = d3.svg.axis()
                .scale(y)
                .tickValues(colorScale.domain())
                .orient("right");


            bangladesh.selectAll("path")
                .data(json.features)
                .enter().append("path")
                .attr("d", path)
                .style("opacity", 0.5)
                .attr('class', 'bd')

                .on('mouseover', function (d, i) {
                    if ($('.map_info').hide()) {
                        $('.map_info').show();
                        $("#district").text(d.properties.ADM2_EN + " District");
                        $("#running_courses").text(Math.floor(Math.random() * 6) + 10);
                        $("#running_students").text(Math.floor(Math.random() * 9) + 250);
                        $("#total_enrollment").text(Math.floor(Math.random() * 5) + 50);
                    }

                    d3.select(this).transition().duration(300).style("opacity", 1);
                    div.transition().duration(300)
                        .style("opacity", .9)
                        .text(d.properties.ADM2_EN + " - " + d.properties.ADM1_EN)
                        .style("color", "#fff")
                        .style("padding", "5px 5px")
                        .style("border", "1px solid #fff")
                        .style("font-weight", " bold")
                        /*.style("width", "150px")
                        .style("height", "150px")*/
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
                        let g = Math.floor(100 + Math.random() * 155)
                        let b = Math.floor(100 + Math.random() * 155)
                        v.setAttribute('fill', `rgb(${r},${g},${b})`)
                    })
                });


            bangladesh.selectAll("path").transition().duration(300)
                .style("fill", function (d) {
                    return colorScale(d.properties.ADM1_EN);
                });

        });

        function initialize() {
            proj.scale(6700);
            proj.translate([-1240, 720]);
        }


    </script>


    {{--Full calender js--}}
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.7.0/main.min.js"></script>
    <script>
        async function courseDetailsModalOpen(publishCourseId) {
            let response = await $.get('{{route('course_management::course-details.ajax', ['publish_course_id' => '__'])}}'.replace('__', publishCourseId));
            if (response?.length) {
                $("#course_details_modal").find(".modal-content").html(response);
            } else {
                let notFound = `<div class="alert alert-danger">Not Found</div>`
                $("#course_details_modal").find(".modal-content").html(notFound);
            }
            $("#course_details_modal").modal('show');
        }

        $(function () {
            let calendarEl = document.getElementById('calendar');
            let initialDate = '{{date('Y-m-d')}}';

            let calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                initialDate,
                displayEventTime: false,
                height: 370,
                headerToolbar: {
                    left: 'prev',
                    center: 'title',
                    right: 'next'
                },
                events: function (fetchInfo, successCallback, failureCallback) {
                    $.ajax({
                        url: '{{route('course_management::yearly-training-calendar.all-event')}}',
                        type: "POST",
                    }).done(function (response) {
                        successCallback(response);
                    }).fail(function (xhr) {
                        failureCallback([]);
                    })
                },
                eventClick: function (calEvent, jsEvent, view) {
                    const {publish_course_id} = calEvent.event.extendedProps;
                    courseDetailsModalOpen(publish_course_id);
                }
            });
            calendar.render();
        });
    </script>

@endpush

@push('css')
    <style>
        body {
            font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
        }

        #bangladesh {
            /*    fill: #00BCD4;
            opacity: .7; */
            stroke: #101010;
            stroke-width: 0.2;
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
            /*padding: 15px 10px 10px 10px;*/
            position: absolute;
            bottom: 6px;
            left: 6px;
            opacity: .8;
            font-size: 12px;
            background: #f2f7f8;
            border-radius: 5px;
            max-height: 190px;
            min-width: 192px;
        }

        svg {
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


    {{--fullCalender css--}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@5.7.0/main.min.css" type="text/css">
    <style>
        #calendar {
            margin: 0 auto;
            font-size: 10px;
            width: 100%;
        }

        .fc-header-title h2 {
            font-size: .9em;
            white-space: normal !important;
        }

        .fc-view-month .fc-event, .fc-view-agendaWeek .fc-event {
            font-size: 0;
            overflow: hidden;
            height: 2px;
        }

        .fc-view-agendaWeek .fc-event-vert {
            font-size: 0;
            overflow: hidden;
            width: 2px !important;
        }

        .fc-agenda-axis {
            width: 20px !important;
            font-size: .7em;
        }

        .fc-button-content {
            padding: 0;
        }

        .fc-direction-ltr .fc-toolbar > * > :not(:first-child) {
            margin-left: 0 !important;
            margin-top: 5px !important;
        }

        .fc .fc-daygrid-body-unbalanced .fc-daygrid-day-events {
            position: relative;
            min-height: 0;
        }
    </style>

@endpush
