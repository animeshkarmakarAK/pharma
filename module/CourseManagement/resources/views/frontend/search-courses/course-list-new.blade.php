@php
    $currentInstitute = domainConfig('institute');
    $layout = 'master::layouts.front-end';
@endphp

@extends($layout)

@section('title')
    কোর্স সমূহ
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card mb-2">
                    <div class="card-header p-5">
                        <h2 class="card-header-title text-center text-dark font-weight-bold">কোর্স সমূহ</h2>
                    </div>
                    <div class="card-background-white px-5 py-4">
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-1">
                                        <label
                                            style="color: #757575; line-height: calc(1.5em + .75rem); font-size: 1rem; font-weight: 400;">
                                            &nbsp;&nbsp;<i class="fa fa-filter mr-2"></i> ফিল্টার
                                        </label>
                                    </div>

                                    @if(!empty($currentInstitute))
                                        <input type="hidden" name="institute_id" id="institute_id"
                                               value="{{ $currentInstitute->id }}">
                                    @else
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <select class="form-control select2-ajax-wizard"
                                                        name="institute_id"
                                                        id="institute_id"
                                                        data-model="{{base64_encode(\Module\CourseManagement\App\Models\Institute::class)}}"
                                                        data-label-fields="{title_bn}"
                                                        data-dependent-fields="#publish_course_id|#programme_id"
                                                        data-placeholder="ইনস্টিটিউট সিলেক্ট করুন"
                                                >
                                                    <option value="">ইনস্টিটিউট সিলেক্ট করুন</option>
                                                </select>
                                            </div>
                                        </div>
                                    @endif

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <select class="form-control select2-ajax-wizard"
                                                    name="publish_course_id"
                                                    id="publish_course_id"
                                            >
                                                <option value="">কোর্সের নাম নির্বাচন করুন</option>
                                                @foreach($publishCourses as $publishCourse)
                                                    <option
                                                        value="{{ $publishCourse->id }}">{{ $publishCourse->course->title_bn }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <select class="form-control"
                                                    name="programme_id"
                                                    id="programme_id"
                                            >
                                                <option value="">প্রোগ্রামের নাম নির্বাচন করুন</option>
                                                @foreach($programmes as $programme)
                                                    <option
                                                        value="{{ $programme->id }}">{{ $programme->title_bn }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>


                                    <div class="col-md-2">
                                        <button class="btn btn-success button-bg mb-2"
                                                id="skill-video-search-btn">{{ __('অনুসন্ধান') }}</button>
                                    </div>

                                    <div class="col-md-3 mb-3">
                                        <div class="input-group">
                                            <input type="search" name="search" id="search" class="form-control"
                                                   placeholder="সার্চ..." style="border: 1px solid #e5e5e5;">
                                            <div class="input-group-append">
                                                <button class="btn button-bg text-white" type="button">
                                                    <i class="fa fa-search"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col">
                                        <div class="overlay" style="display: none">
                                            <i class="fas fa-2x fa-sync-alt fa-spin"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row justify-content-center pt-4" id="container-publish-courses"></div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="prev-next-button float-right">

                                </div>
                                <div class="overlay" style="display: none">
                                    <i class="fas fa-2x fa-sync-alt fa-spin"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal modal-danger fade" tabindex="-1" id="course_details_modal" role="dialog">
                <div class="row">
                    <div class="col-sm-10 mx-auto">
                        <div class="modal-dialog" style="max-width: 100%">
                            <div class="modal-content modal-xlg" style="background-color: #e6eaeb">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        @endsection
        @push('css')
            <style>
                .card-background-white {
                    background: #faf8fb;
                }

                .form-control {
                    border: 1px solid #671688;
                    color: #671688;
                }

                .form-control:focus {
                    border-color: #671688;
                }

                .button-bg {
                    background: #671688;
                    border-color: #671688;
                }

                .button-bg:hover {
                    color: #ffffff;
                    background-color: #671688 !important;;
                    border-color: #671688 !important;;
                }

                .button-bg:active {
                    color: #ffffff;
                    background-color: #671688 !important;
                    border-color: #671688 !important;;
                }

                .button-bg:focus {
                    color: #ffffff;
                    background-color: #671688 !important;;
                    border-color: #671688 !important;;
                }

                .button-bg:visited {
                    color: #ffffff;
                    background-color: #671688 !important;;
                    border-color: #671688 !important;;
                }

                .card-header-title {
                    min-height: 48px;
                }

                .card-bar-home-course img {
                    height: 14vw;
                }

                .gray-color {
                    color: #73727f;
                }
                .course-heading-wrap:hover {
                    overflow: visible;
                    white-space: normal;
                    cursor: pointer;
                }
                .course-p {
                    font-size: 14px;
                    font-weight: 400;
                    color: #671688;
                }
            </style>
        @endpush
        @push('js')

            <script>
                const template = function (key, item) {
                    console.log('key: ' + key)
                    let html = '';
                    html += '<div class="col-md-3">';
                    html += '<div class="card card-main mb-3">';
                    html += '<div class="card-bar-home-course">';
                    html += '<div class="pb-3">';
                    html += '<img class="slider-img border-top-radius"';
                    html += 'src="{{asset('/storage/'. '__')}}"'.replace('__', item.course_cover_image) + '" width="100%"';
                    html += 'alt="icon">';
                    html += '</div>';
                    html += '<div class="text-left pl-4 pr-4 pt-1 pb-1">';
                    html += '<p class="card-p1">' + (item.course_course_fee ? item.course_course_fee + ' টাকা' : 'শূন্য') + '</p>';
                    html += '<p class="font-weight-bold course-heading-wrap">' + item.course_title_bn + '</p>';
                    html += '<p class="font-weight-light mb-1"><i';
                    html += 'class="fas fa-clock gray-color"></i> <span ';
                    html += 'class="course-p"><i class="fas fa-clock gray-color mr-2"></i>' + (item.course_duration ? item.course_duration : ' সময়কাল নির্ধারিত হয়নি') +
                        '</span>';
                    html += '</p>';
                    html += '<p class="font-weight-light float-left"><i';
                    html += 'class="fas fa-user-plus gray-color"></i>';
                    html += '<span ';
                    html += 'class="course-p"><i class="fas fa-user-plus gray-color mr-2"></i>' +
                        'আসন সংখ্যা ( <span class="max-enroll' + key + '"></span> )</span>';
                    html += '</p>';
                    html += '<p class="float-right">';
                    html += '<a href="javascript:;"';
                    html += 'onclick="courseDetailsModalOpen(' + item.id + ')"';
                    html += 'class="btn btn-primary btn-sm">বিস্তারিত</a>';
                    html += '</p>';
                    html += '</div>';
                    html += '</div>';
                    html += '</div> ';
                    html += '</div>';

                    return html;
                }

                const paginatorLinks = function (link) {
                    //console.log(link)
                    if (link.label == 'pagination.previous') {
                        link.label = 'Previous'
                    }
                    if (link.label == 'pagination.next') {
                        link.label = 'Next'
                    }
                    let html = '';
                    if (link.active) {
                        html += '<li class="page-item active">' +
                            '<a class="page-link">' + link.label + '</a>' +
                            '</li>';
                    } else if (!link.url) {
                        html += '<li class="page-item">' +
                            '<a class="page-link">' + link.label + '</a>' +
                            '</li>';
                    } else {
                        html += '<li class="page-item"><a class="page-link" href="' + link.url + '">' + link.label + '</a></li>';
                    }
                    return html;
                }

                const searchAPI = function ({model, columns}) {
                    return function (url, filters = {}) {
                        return $.ajax({
                            url: url,
                            type: "POST",
                            data: {
                                _token: '{{csrf_token()}}',
                                resource: {
                                    model: model,
                                    columns: columns,
                                    paginate: true,
                                    page: 1,
                                    per_page: 16,
                                    filters,
                                }
                            }
                        }).done(function (response) {
                            return response;
                        });
                    };
                };

                let baseUrl = '{{route('web-api.model-resources')}}';
                const publishCourseFetch = searchAPI({
                    model: "{{base64_encode(\Module\CourseManagement\App\Models\PublishCourse::class)}}",
                    columns: 'id|institute_id|course_id|branch_id|training_center_id|programme_id|application_form_type_id|course.title_bn|course.cover_image|course.course_fee|course.duration|course_session.max_seat_available'
                });

                function publishCourseSearch(url = baseUrl) {
                    $('.overlay').show();
                    let searchQuery = $('#search').val();
                    let institute = $('#institute_id').val();
                    let videoCategory = $('#programme_id').val();
                    let video = $('#publish_course_id').val();

                    const filters = {};
                    if (searchQuery?.toString()?.length) {
                        filters['course.title_bn'] = {
                            type: 'contain',
                            value: searchQuery
                        };
                    }
                    if (institute?.toString()?.length) {
                        filters['institute_id'] = institute;
                    }
                    if (videoCategory?.toString()?.length) {
                        filters['programme_id'] = videoCategory;
                    }
                    if (video?.toString()?.length) {
                        filters['id'] = video;
                    }

                    publishCourseFetch(url, filters)?.then(function (response) {
                        $('.overlay').hide();
                        window.scrollTo(0, 0);
                        let html = '';
                        if (response?.data?.data.length <= 0) {
                            html += '<div class="text-center mt-5" "><i class="fa fa-sad-tear fa-2x text-warning mb-3"></i><div class="text-center text-danger h3">কোন কোর্স খুঁজে পাওয়া যায়নি!</div>';
                        }

                        $.each(response.data?.data, function (i, item) {
                            console.log(i, item)
                            html += template(i, item);
                        });

                        $('#container-publish-courses').html(html);
                        console.table("response", response.data.links);

                        let link_html = '<nav> <ul class="pagination">';
                        let links = response?.data?.links;
                        if (links.length > 3) {
                            $.each(links, function (i, link) {
                                link_html += paginatorLinks(link);
                            });
                        }
                        link_html += '</ul></nav>';
                        $('.prev-next-button').html(link_html);
                    });
                }

                $(document).ready(function () {
                    publishCourseSearch();
                    $(document).on('click', '.pagination .page-link', function (e) {
                        e.preventDefault();
                        let url = $(this).attr('href');
                        if (url) {
                            publishCourseSearch(url);
                        }
                    });

                    $("#search").on("keyup change", function (e) {
                        publishCourseSearch();
                    })

                    $('#skill-video-search-btn').on('click', function () {
                        publishCourseSearch();
                    });

                    $('#programme_id').on('change', function () {
                        publishCourseSearch();
                    });

                    $('#publish_course_id').on('change', function () {
                        publishCourseSearch();
                    });


                    setTimeout(function () {
                        @foreach($maxEnrollmentNumber as $key => $maxEnrollment)
                        $('.max-enroll' + {{$key}}).html('{{ \App\Helpers\Classes\NumberToBanglaWord::engToBn($maxEnrollment) }}');
                        @endforeach
                    }, 1000)


                });

                async function courseDetailsModalOpen(publishCourseId) {
                    let response = await $.get('{{route('course_management::course-details.ajax', ['publish_course_id' => '_'])}}'.replace('_', publishCourseId));

                    if (response?.length) {
                        $("#course_details_modal").find(".modal-content").html(response);
                    } else {
                        let notFound = `<div class="alert alert-danger">Not Found</div>`
                        $("#course_details_modal").find(".modal-content").html(notFound);
                    }

                    $("#course_details_modal").modal('show');
                }


            </script>

    @endpush
