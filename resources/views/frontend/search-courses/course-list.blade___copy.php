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
                <div class="card shadow-none mb-2 ">
                    <div class="card-header p-5">
                        <h2 class="text-center text-dark font-weight-bold">পছন্দের কোর্সে আবেদন করুন</h2>
                    </div>
                    <div class="px-5 py-4 card-background-white">
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-1">
                                        <label
                                            style="color: #757575; line-height: calc(1.5em + .75rem); font-size: 1rem; font-weight: 400;">
                                            ফিল্টার&nbsp;&nbsp;<i class="fa fa-filter"></i>
                                        </label>
                                    </div>

                                    <div class="col-md-2 mb-3">
                                        <input type="search" name="search" id="search" class="form-control rounded-2"
                                               placeholder="সার্চ...">
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
                                                        data-model="{{base64_encode(\App\Models\Institute::class)}}"
                                                        data-label-fields="{title_bn}"
                                                        data-placeholder="ইনস্টিটিউট সিলেক্ট করুন"
                                                >
                                                    <option value="">ইনস্টিটিউট সিলেক্ট করুন</option>
                                                </select>
                                            </div>
                                        </div>
                                    @endif

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <select class="form-control"
                                                    name="publish_course_id"
                                                    id="publish_course_id"
                                                    data-model="{{base64_encode(\App\Models\PublishCourse::class)}}"
                                                    data-label-fields="{course.title_bn}"
                                            >
                                                <option value="">কোর্সের নাম নির্বাচন করুন</option>
                                                @foreach($publishCourses as $publishCourse)
                                                    <option
                                                        value="{{$publishCourse->id }}">{{ optional($publishCourse->course)->title_bn  }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <select class="form-control select2-ajax-wizard"
                                                    name="video_id"
                                                    id="video_id"
                                            >
                                                <option value="">প্রোগ্রামের নাম নির্বাচন করুন</option>
                                                @foreach($programmes as $programme)
                                                    <option
                                                        value="{{ $programme->id }}">{{ $programme->title_bn }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-1">
                                        <button class="btn btn-success button-bg  mb-2"
                                                id="skill-video-search-btn">{{ __('অনুসন্ধান') }}</button>
                                    </div>

                                </div>
                            </div>
                        </div>
                        @if(!$publishCourses->isEmpty())
                        <div class="row justify-content-center" id="container-skill-videos">
                            @foreach($publishCourses as $key => $publishCourse)
                                <div class="col-md-3">
                                    <div class="card card-main mb-2">
                                        <div class="card-bar-home-course">
                                            <div class="pb-3">
                                                <img class="slider-img border-top-radius"
                                                     src="{{asset('/storage/'. optional($publishCourse->course)->cover_image)}}"
                                                     alt="icon">
                                            </div>
                                            <div class="text-left pl-4 pr-4 pt-1 pb-1">
                                                <p class="card-p1">{{optional($publishCourse->course)->course_fee?'Tk. '.optional($publishCourse->course)->course_fee:'Free'}}</p>
                                                <p class="font-weight-bold course-heading-wrap">{{ optional($publishCourse->course)->title_bn }}</p>
                                                <p class="font-weight-light mb-1"><i
                                                        class="fas fa-clock gray-color"></i> <span
                                                        class="course-p">{{ !empty($publishCourse->course->duration)?$publishCourse->course->duration:'undefined' }}</span>
                                                </p>
                                                <p class="font-weight-light float-left"><i
                                                        class="fas fa-user-plus gray-color"></i>
                                                    <span
                                                        class="course-p">Student ( {{ $maxEnrollmentNumber[$key] }} )</span>
                                                </p>
                                                <p class="float-right">
                                                    <a href="javascript:;"
                                                       onclick="courseDetailsModalOpen('{{ $publishCourse->id }}')"
                                                       class="btn btn-primary btn-sm">বিস্তারিত</a>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        @else
                            <div class="col-md-12 m-5 text-center">
                                <i class="fa fa-sad-tear fa-2x text-warning mb-3"></i>
                                <h5 class="text-danger">কোন কোর্স নেই</h5>
                            </div>
                        @endif
                        <!-- Modal Start-->
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
                        <!-- End Modal -->
                        </section>
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
                    border-color:#671688;
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
                .card-main {
                    border-radius: 5px;
                }
                .card-bar-home-course {
                    padding: 0;
                    margin: 0;
                }
                .border-top-radius {
                    border-top-left-radius: 5px;
                    border-top-right-radius: 5px;
                }
                .slider-img {
                    width: 100%;
                    height: 11vw;
                    object-fit: cover;
                }



            </style>
        @endpush
        @push('js')

            <script>

                // $(document).ready(function () {
                    {{--const template = function (item) {--}}
                    {{--    console.log(item)--}}
                    {{--    let html = `<div class="col-md-3">--}}
                    {{--            <div class="embed-responsive embed-responsive-16by9">`;--}}
                    {{--    if (item.video_type == {!! \App\Models\PublishCourse::PUBLISH_STATUS_PUBLISH !!}) {--}}
                    {{--        html += '<iframe class="embed-responsive-item youtube-video"';--}}
                    {{--        html += ' src=https://www.youtube.com/embed/' + item.youtube_video_id + '?html5=1&enablejsapi=1;rel=0';--}}
                    {{--        html += 'frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>';--}}
                    {{--    } else {--}}
                    {{--        // html += '<video id="custom_video' + item.id + '" class="custom_video_class" width="250" controls="controls"';--}}
                    {{--        // html += '<source src = /storage/' + item.uploaded_video_path + ' type="video/mp4"';--}}
                    {{--        // html += '></video>';--}}

                    {{--        html += '<iframe id="custom_video' + item.id + '" class="embed-responsive-item youtube-video"';--}}
                    {{--        html += 'src= /storage/' + item.uploaded_video_path + '?html5=1&enablejsapi=1;rel=0';--}}
                    {{--        html += 'frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>';--}}
                    {{--    }--}}
                    {{--    html += '</div>';--}}
                    {{--    html += '<div class="video-title mt-3 mb-3 text-dark font-weight-bold text-center">';--}}
                    {{--    html += item.title_bn;--}}
                    {{--    html += '</div></div>';--}}
                    {{--    return html;--}}
                    {{--};--}}

                    // const paginatorLinks = function (link) {
                    //     console.log(link)
                    //     if (link.label == 'pagination.previous') {
                    //         link.label = 'Previous'
                    //     }
                    //     if (link.label == 'pagination.next') {
                    //         link.label = 'Next'
                    //     }
                    //     let html = '';
                    //     if (link.active) {
                    //         html += '<li class="page-item active">' +
                    //             '<a class="page-link">' + link.label + '</a>' +
                    //             '</li>';
                    //     } else if (!link.url) {
                    //         html += '<li class="page-item">' +
                    //             '<a class="page-link">' + link.label + '</a>' +
                    //             '</li>';
                    //     } else {
                    //         html += '<li class="page-item"><a class="page-link" href="' + link.url + '">' + link.label + '</a></li>';
                    //     }
                    //     return html;
                    // }

                    {{--const searchAPI = function ({model, columns}) {--}}
                    {{--    return function (url, filters = {}) {--}}
                    {{--        return $.ajax({--}}
                    {{--            url: url,--}}
                    {{--            type: "POST",--}}
                    {{--            data: {--}}
                    {{--                _token: '{{csrf_token()}}',--}}
                    {{--                resource: {--}}
                    {{--                    model: model,--}}
                    {{--                    columns: columns,--}}
                    {{--                    paginate: true,--}}
                    {{--                    page: 1,--}}
                    {{--                    per_page: 16,--}}
                    {{--                    filters,--}}
                    {{--                }--}}
                    {{--            }--}}
                    {{--        }).done(function (response) {--}}
                    {{--            return response;--}}
                    {{--        });--}}
                    {{--    };--}}
                    {{--};--}}

                    {{--let baseUrl = '{{route('web-api.model-resources')}}';--}}
                    {{--const skillVideoFetch = searchAPI({--}}
                    {{--    model: "{{base64_encode(\App\Models\PublishCourse::class)}}",--}}
                    {{--    columns: 'course_id|title_en|title_bn|'--}}
                    {{--});--}}

                    {{--function videoSearch(url = baseUrl) {--}}
                    {{--    $('.overlay').show();--}}
                    {{--    let searchQuery = $('#search').val();--}}
                    {{--    let institute = $('#institute_id').val();--}}
                    {{--    let videoCategory = $('#publish_course_id').val();--}}
                    {{--    let video = $('#video_id').val();--}}

                    {{--    const filters = {};--}}
                    {{--    if (searchQuery?.toString()?.length) {--}}
                    {{--        filters['title_bn'] = {--}}
                    {{--            type: 'contain',--}}
                    {{--            value: searchQuery--}}
                    {{--        };--}}
                    {{--    }--}}
                    {{--    if (institute?.toString()?.length) {--}}
                    {{--        filters['institute_id'] = institute;--}}
                    {{--    }--}}
                    {{--    if (videoCategory?.toString()?.length) {--}}
                    {{--        filters['publish_course_id'] = videoCategory;--}}
                    {{--    }--}}
                    {{--    if (video?.toString()?.length) {--}}
                    {{--        filters['id'] = video;--}}
                    {{--    }--}}

                    {{--    skillVideoFetch(url, filters)?.then(function (response) {--}}
                    {{--        $('.overlay').hide();--}}
                    {{--        window.scrollTo(0, 0);--}}
                    {{--        let html = '';--}}
                    {{--        if (response?.data?.data.length <= 0) {--}}
                    {{--            html += '<div class="text-center mt-5" "><i class="fa fa-sad-tear fa-2x text-warning mb-3"></i><div class="text-center text-danger h3">কোন ভিডিও খুঁজে পাওয়া যায়নি!</div>';--}}
                    {{--        }--}}
                    {{--        $.each(response.data?.data, function (i, item) {--}}
                    {{--            html += template(item);--}}
                    {{--        });--}}

                    {{--        $('#container-skill-videos').html(html);--}}
                    {{--        // $('.prev-next-button').html(response?.pagination);--}}
                    {{--        console.table("response", response.data.links);--}}

                    {{--        let link_html = '<nav> <ul class="pagination">';--}}
                    {{--        let links = response?.data?.links;--}}
                    {{--        if (links.length > 3) {--}}
                    {{--            $.each(links, function (i, link) {--}}
                    {{--                link_html += paginatorLinks(link);--}}
                    {{--            });--}}
                    {{--        }--}}
                    {{--        link_html += '</ul></nav>';--}}
                    {{--        $('.prev-next-button').html(link_html);--}}
                    {{--    });--}}
                    {{--}--}}


                    // videoSearch();

                //     $(document).on('click', '.pagination .page-link', function (e) {
                //         e.preventDefault();
                //         let url = $(this).attr('href');
                //         if (url) {
                //             videoSearch(url);
                //         }
                //     });
                //
                //     $("#search").on("keyup change", function (e) {
                //         videoSearch();
                //     })
                //
                //     $('#skill-video-search-btn').on('click', function () {
                //         videoSearch();
                //     });
                //
                //     $('#publish_course_id').on('change', function () {
                //         videoSearch();
                //     });
                //     $('#video_id').on('change', function () {
                //         videoSearch();
                //     });
                //
                // });
            </script>
            <script>

                async function courseDetailsModalOpen(publishCourseId) {
                    let response = await $.get('{{route('course-details.ajax', ['publish_course_id' => '_'])}}'.replace('_', publishCourseId));

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
