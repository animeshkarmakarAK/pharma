@php
    $currentInstitute = domainConfig('institute');
    $layout = 'master::layouts.front-end';
@endphp
@extends($layout)

@section('title')
    প্রশিক্ষণ বর্ষপঞ্জি
@endsection

@section('content')

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card mb-2">
                    <div class="card-header p-5 border-0">
                        <h2 class="text-center text-dark font-weight-bold">
                            প্রশিক্ষণ বাস্তবায়ন সময়সূচি</h2>
                    </div>

                    <div class="row px-5 py-4">
                        <div class="col-md-12 mb-2">
                            <div class="row">
                                <div class="col-md-1">
                                    <label
                                        style="color: #757575; line-height: calc(1.5em + .75rem); font-size: 1rem; font-weight: 400;">
                                        ফিল্টার&nbsp;&nbsp;<i class="fa fa-filter"></i>
                                    </label>
                                </div>

                                @if(!empty($currentInstitute))
                                    <input type="hidden" name="institute_id" id="institute_id"
                                           value="{{ $currentInstitute->id }}">
                                @else
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <select class="form-control select2-ajax-wizard"
                                                    name="institute_id"
                                                    id="institute_id"
                                                    data-model="{{base64_encode(\Module\CourseManagement\App\Models\Institute::class)}}"
                                                    data-label-fields="{title_bn}"
                                                    data-dependent-fields="#video_id|#video_category_id"
                                                    data-placeholder="ইনস্টিটিউট সিলেক্ট করুন"
                                            >
                                                <option value="">ইনস্টিটিউট সিলেক্ট করুন</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <select class="form-control select2-ajax-wizard"
                                                    name="branch_id"
                                                    id="branch_id"
                                                    data-model="{{base64_encode(\Module\CourseManagement\App\Models\Branch::class)}}"
                                                    data-label-fields="{title_bn}"
                                                    data-depend-on="institute_id"
                                                    data-dependent-fields="#training_centre_id"
                                                    data-placeholder="ব্রাঞ্চ সিলেক্ট করুন"
                                            >
                                            </select>
                                        </div>
                                    </div>
                                @endif



                                <div class="col-md-2">
                                    <div class="form-group">
                                        <select class="form-control select2-ajax-wizard"
                                                name="training_center_id"
                                                id="training_center_id"
                                                data-model="{{base64_encode(\Module\CourseManagement\App\Models\TrainingCenter::class)}}"
                                                data-label-fields="{title_bn}"
                                                data-depend-on-optional="institute_id"
                                                data-placeholder="ট্রেনিং সেন্টারে সিলেক্ট করুন"
                                        >
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <button class="btn btn-success"
                                            id="course-session-filter-btn">{{ __('অনুসন্ধান') }}</button>
                                </div>

                                {{--<div class="col">
                                    <div class="overlay" style="display: none">
                                        <i class="fas fa-2x fa-sync-alt fa-spin"></i>
                                    </div>
                                </div>--}}
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div id='calendar'></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal modal-danger fade" tabindex="-1" id="course_details_modal" role="dialog">
            <div class="row">
                <div class="col-sm-10 mx-auto">
                    <div class="modal-dialog" style="max-width: 100%;">
                        <div class="modal-content modal-xlg" style="background-color: #e6eaeb">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endsection
        @push('css')
            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@5.7.0/main.min.css" type="text/css">
            <style>

                #calendar {
                    /*max-width: 1100px;
                    margin: 40px auto;*/
                }

                .fc-daygrid-day-number {
                    font-size: x-large;
                }

                .fc-daygrid-event{
                    cursor: pointer;
                }

                .fc-daygrid-day-top{
                    justify-content: center;
                }


            </style>
        @endpush
        @push('js')
            <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.9.0/main.min.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.9.0/locales-all.js"></script>
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
                    let initialLocaleCode = 'bn';

                    let calendar = new FullCalendar.Calendar(calendarEl, {
                        initialView: 'dayGridMonth',
                        initialDate,
                        displayEventTime: false,
                        customButtons: {
                            myCustomButton: {
                                text: 'বছর',
                                click: function () {
                                    window.location = '{{ route('course_management::fiscal-year') }}';
                                }
                            }
                        },
                        headerToolbar: {
                            left: 'prev,next today',
                            center: 'title',
                            right: 'timeGridDay,timeGridWeek,dayGridMonth,myCustomButton'
                        },
                        locale: initialLocaleCode,
                        events: function (fetchInfo, successCallback, failureCallback) {
                            $.ajax({
                                url: '{{route('course_management::yearly-training-calendar.all-event')}}',
                                type: "POST",
                            }).done(function (response) {
                                successCallback(response);
                                $('.fc-event-title').attr('title','কোর্সের বিস্তারিত দেখুন');
                            }).fail(function (xhr) {
                                failureCallback([]);
                            });
                        },
                        eventClick: function (calEvent, jsEvent, view) {
                            const {publish_course_id} = calEvent.event.extendedProps;
                            courseDetailsModalOpen(publish_course_id);
                        },

                    });
                    calendar.render();


                    function filterEvent(){
                        delete calendar;
                        let branch_id = $('#branch_id').val();
                        let training_center_id = $('#training_center_id').val();

                        let calendar1 = new FullCalendar.Calendar(calendarEl, {
                            initialView: 'dayGridMonth',
                            initialDate,
                            displayEventTime: false,
                            customButtons: {
                                myCustomButton: {
                                    text: 'বছর',
                                    click: function () {
                                        window.location = '{{ route('course_management::fiscal-year') }}';
                                    }
                                }
                            },
                            headerToolbar: {
                                left: 'prev,next today',
                                center: 'title',
                                right: 'timeGridDay,timeGridWeek,dayGridMonth,myCustomButton'
                            },
                            locale: initialLocaleCode,
                            events: function (fetchInfo, successCallback, failureCallback) {
                                $.ajax({
                                    url: '{{route('course_management::yearly-training-calendar.all-event')}}',
                                    data: {branch_id: branch_id, training_center_id: training_center_id},
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
                            },

                        });
                        calendar1.render();

                    }
                    //calendar filter by Branch & Training Centre
                    $('#course-session-filter-btn').on('click', function () {
                        filterEvent();
                    });

                    $('#training_center_id').on('change', function (){
                        filterEvent();
                    });
                    $('#branch_id').on('change', function (){
                        filterEvent();
                    });


                    $('.fc-event-title').click(function (){
                        console.log($('.fc-event-title').html());
                    });
                });

            </script>
    @endpush
