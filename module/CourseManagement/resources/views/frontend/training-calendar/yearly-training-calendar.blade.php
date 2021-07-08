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
                    })
                },

                eventClick: function (calEvent, jsEvent, view) {
                    const {publish_course_id} = calEvent.event.extendedProps;
                    courseDetailsModalOpen(publish_course_id);
                },

            });
            calendar.render();
        });
    </script>
@endpush
