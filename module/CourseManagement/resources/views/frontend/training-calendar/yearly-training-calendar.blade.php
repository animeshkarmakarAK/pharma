@php
    $currentInstitute = domainConfig('institute');
    $layout = $currentInstitute ? 'master::layouts.custom1' : 'master::layouts.front-end';
@endphp
@extends($layout)

@section('content')

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="row justify-content-center mt-3">
                    <div class="col-md-1">
                        <p class="font-weight-bold text-primary">ফিল্টার <i class="fa fa-filter"></i></p>
                    </div>

                    {{--<div class="col-md-3">
                        <input type="search" name="search" id="search" class="form-control rounded-0"
                               placeholder="সার্চ...">
                    </div>--}}

                    @if(!empty($currentInstitute))
                        <input type="hidden" name="institute_id" id="institute_id" value="{{ $currentInstitute->id }}">
                    @else
                        <div class="col-md-2">
                            <div class="form-group">
                                <select class="form-control select2-ajax-wizard"
                                        name="institute_id"
                                        id="institute_id"
                                        data-model="{{base64_encode(\Module\CourseManagement\App\Models\Institute::class)}}"
                                        data-label-fields="{title_en}"
                                        data-dependent-fields="#video_id|#video_category_id"
                                        data-placeholder="ইনস্টিটিউট সিলেক্ট করুন"
                                >
                                    <option value="">ইনস্টিটিউট সিলেক্ট করুন</option>
                                </select>
                            </div>
                        </div>
                    @endif

                    <div class="col-md-2">
                        <div class="form-group">
                            <select class="form-control select2-ajax-wizard"
                                    name="branch_id"
                                    id="branch_id"
                                    data-model="{{base64_encode(\Module\CourseManagement\App\Models\Branch::class)}}"
                                    data-label-fields="{title_en}"
                                    data-depend-on="institute_id"
                                    data-dependent-fields="#training_centre_id"
                                    data-placeholder="ব্রাঞ্চ সিলেক্ট করুন"
                            >
                            </select>
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="form-group">
                            <select class="form-control select2-ajax-wizard"
                                    name="training_center_id"
                                    id="training_center_id"
                                    data-model="{{base64_encode(\Module\CourseManagement\App\Models\TrainingCenter::class)}}"
                                    data-label-fields="{title_en} - {institute_id}"
                                    data-depend-on-optional="institute_id"
                                    data-placeholder="ট্রেনিং সেন্টারে সিলেক্ট করুন"
                            >
                            </select>
                        </div>
                    </div>

                    <div class="col-md-1">
                        <button class="btn btn-success" id="course-session-filter-btn">{{ __('অনুসন্ধান') }}</button>
                    </div>

                    <div class="col">
                        <div class="overlay" style="display: none">
                            <i class="fas fa-2x fa-sync-alt fa-spin"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header custom-bg-gradient-info">
                        <h2 class="text-center text-primary font-weight-lighter">প্রশিক্ষণ বাস্তবায়ন সময়সূচি</h2>
                    </div>
                </div>
                <div id='calendar'></div>
            </div>
        </div>
    </div>

    <div class="modal modal-danger fade" tabindex="-1" id="course_details_modal" role="dialog">
        <div class="modal-dialog" style="max-width: 80%;">
            <div class="modal-content modal-xlg" style="background-color: #e6eaeb">
            </div>
        </div>
    </div>
@endsection
@push('css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@5.7.0/main.min.css" type="text/css">
    <style>
        html, body {
            margin: 0;
            padding: 0;
            font-family: Arial, Helvetica Neue, Helvetica, sans-serif;
            font-size: 14px;
        }

        #calendar {
            max-width: 1100px;
            margin: 40px auto;
        }
        .fc-daygrid-day-number {
            font-size: x-large;
        }
    </style>
@endpush
@push('js')
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
                customButtons: {
                    myCustomButton: {
                        text: 'Year',
                        click: function() {
                            window.location= '{{ route('course_management::fiscal-year') }}';
                        }
                    }
                },
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay,myCustomButton'
                },
                events: function (fetchInfo, successCallback, failureCallback) {
                    $.ajax({
                        url: '{{route('course_management::yearly-training-calendar.all-event')}}',
                        type: "POST",
                    }).done(function (response) {
                        successCallback(response);
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




            //calendar filter by Branch & Training Centre
            $('#course-session-filter-btn').on('click', function () {
                delete calendar;
                let branch_id = $('#branch_id').val();
                let training_center_id = $('#training_center_id').val();

                let calendar1 = new FullCalendar.Calendar(calendarEl, {
                    initialView: 'dayGridMonth',
                    initialDate,
                    displayEventTime: false,
                    customButtons: {
                        myCustomButton: {
                            text: 'Year',
                            click: function() {
                                window.location= '{{ route('course_management::fiscal-year') }}';
                            }
                        }
                    },
                    headerToolbar: {
                        left: 'prev,next today',
                        center: 'title',
                        right: 'dayGridMonth,timeGridWeek,timeGridDay,myCustomButton'
                    },
                    events: function (fetchInfo, successCallback, failureCallback){
                        $.ajax({
                            url: '{{route('course_management::yearly-training-calendar.all-event')}}',
                            data: { branch_id: branch_id, training_center_id: training_center_id },
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
            });

        });

    </script>
@endpush
