@php
    $currentInstitute = domainConfig('institute');
    $layout = 'master::layouts.front-end';
@endphp
@extends($layout)

@section('title')
    ভিডিও সমূহ
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card mb-2">
                    <div class="card-header custom-bg-gradient-info">
                        <h2 class="text-center text-primary font-weight-lighter">ভিডিও সমূহ</h2>
                    </div>
                    <div class="px-5 py-4">
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
                                                        data-model="{{base64_encode(\Module\CourseManagement\App\Models\Institute::class)}}"
                                                        data-label-fields="{title_bn}"
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
                                            <select class="form-control"
                                                    name="video_category_id"
                                                    id="video_category_id"
                                            >
                                                <option value="">ভিডিও ক্যাটাগরি</option>
                                                @foreach($youthVideoCategories as $youthVideoCategory)
                                                    <option
                                                        value="{{ $youthVideoCategory->id }}">{{ $youthVideoCategory->title_bn }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <select class="form-control select2-ajax-wizard"
                                                    name="video_id"
                                                    id="video_id"
                                            >
                                                <option value="">ভিডিও সিলেক্ট করুন</option>
                                                @foreach($youthVideos as $youthVideo)
                                                    <option
                                                        value="{{ $youthVideo->id }}">{{ $youthVideo->title_bn }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-1">
                                        <button class="btn btn-success mb-2"
                                                id="skill-video-search-btn">{{ __('অনুসন্ধান') }}</button>
                                    </div>

                                    <div class="col">
                                        <div class="overlay" style="display: none">
                                            <i class="fas fa-2x fa-sync-alt fa-spin"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row justify-content-center" id="container-skill-videos"></div>
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

        @push('js')
            <script>
                const template = function (item) {
                    let html = `<div class="col-md-3">
                                <div class="embed-responsive embed-responsive-16by9">`;
                    if (item.video_type == {!! \Module\CourseManagement\App\Models\Video::VIDEO_TYPE_YOUTUBE_VIDEO !!}) {
                        html += '<iframe class="embed-responsive-item"';
                        html += ' src=https://www.youtube.com/embed/' + item.youtube_video_id + '?rel=0';
                        html += ' allowfullscreen></iframe>';
                    } else {
                        html += '<video controls width="250"';
                        html += '<source src = /storage/' + item.uploaded_video_path + ' type="video/mp4"';
                        html += '></video>';
                    }
                    html += '</div>';
                    html += '<div class="video-title mt-3 mb-3 text-dark font-weight-bold text-center">';
                    html += item.title_bn;
                    html += '</div></div>';
                    return html;
                };

                const paginatorLinks = function (link) {
                    console.log(link)
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
                const skillVideoFetch = searchAPI({
                    model: "{{base64_encode(\Module\CourseManagement\App\Models\Video::class)}}",
                    columns: 'youtube_video_id|uploaded_video_path|title_en|title_bn|video_type'
                });

                function videoSearch(url = baseUrl) {
                    $('.overlay').show();
                    let searchQuery = $('#search').val();
                    let institute = $('#institute_id').val();
                    let videoCategory = $('#video_category_id').val();
                    let video = $('#video_id').val();

                    const filters = {};
                    if (searchQuery?.toString()?.length) {
                        filters['title_bn'] = {
                            type: 'contain',
                            value: searchQuery
                        };
                    }
                    if (institute?.toString()?.length) {
                        filters['institute_id'] = institute;
                    }
                    if (videoCategory?.toString()?.length) {
                        filters['video_category_id'] = videoCategory;
                    }
                    if (video?.toString()?.length) {
                        filters['id'] = video;
                    }

                    skillVideoFetch(url, filters)?.then(function (response) {
                        $('.overlay').hide();
                        window.scrollTo(0, 0);
                        let html = '';
                        if (response?.data?.data.length <= 0) {
                            html += '<div class="text-center mt-5" "><i class="fa fa-sad-tear fa-2x text-warning mb-3"></i><div class="text-center text-danger h3">কোন ভিডিও খুঁজে পাওয়া যায়নি!</div>';
                        }
                        $.each(response.data?.data, function (i, item) {
                            html += template(item);
                        });

                        $('#container-skill-videos').html(html);
                        // $('.prev-next-button').html(response?.pagination);
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
                    videoSearch();

                    $(document).on('click', '.pagination .page-link', function (e) {
                        e.preventDefault();
                        let url = $(this).attr('href');
                        if (url) {
                            videoSearch(url);
                        }
                    });

                    $("#search").on("keyup change", function (e) {
                        videoSearch();
                    })

                    $('#skill-video-search-btn').on('click', function () {
                        videoSearch();
                    });

                    $('#video_category_id').on('change', function () {
                        videoSearch();
                    });
                    $('#video_id').on('change', function () {
                        videoSearch();
                    });


                });
            </script>
    @endpush
