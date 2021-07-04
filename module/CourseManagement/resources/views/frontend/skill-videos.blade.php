@php
    $currentInstitute = domainConfig('institute');
    $layout = $currentInstitute ? 'master::layouts.custom1' : 'master::layouts.front-end';
@endphp
@extends($layout)

@section('content')
    <div class="container-fluid">
        <div class="row mt-2 mb-5">
            <div class="col-md-12">
                <div class="row justify-content-center">
                    <div class="col-md-1">
                        <p class="font-weight-bold text-primary">ফিল্টার <i class="fa fa-filter"></i></p>
                    </div>

                    <div class="col-md-3">
                        <input type="search" name="search" id="search" class="form-control rounded-0"
                               placeholder="অনুসন্ধান...">
                    </div>

                    @if(!empty($currentInstitute))
                        <input type="hidden" name="institute_id" id="institute_id" value="{{ $currentInstitute->id }}">
                    @else
                        <div class="col-md-2">
                            <div class="form-group">
                                <select class="form-control select2-ajax-wizard"
                                        name="institute_id"
                                        id="institute_id"
                                        data-model="{{base64_encode(\Module\CourseManagement\App\Models\Institute::class)}}"
                                        data-label-fields="{title_bn}"
                                        data-dependent-fields="#video_id|#video_category_id"
                                        data-placeholder="ইনস্টিটিউট নির্বাচন করুন"
                                >
                                </select>
                            </div>
                        </div>
                    @endif

                    <div class="col-md-2">
                        <div class="form-group">
                            <select class="form-control select2-ajax-wizard"
                                    name="video_category_id"
                                    id="video_category_id"
                                    data-model="{{base64_encode(\Module\CourseManagement\App\Models\VideoCategory::class)}}"
                                    data-label-fields="{title_bn}"
                                    data-depend-on="institute_id"
                                    data-dependent-fields="#video_id"
                                    data-placeholder="ভিডিও ক্যাটাগরি নির্বাচন করুন"
                            >
                                <option value="">ভিডিও ক্যাটাগরি নির্বাচন করুন</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="form-group">
                            <select class="form-control select2-ajax-wizard"
                                    name="video_id"
                                    id="video_id"
                                    data-model="{{base64_encode(\Module\CourseManagement\App\Models\Video::class)}}"
                                    data-label-fields="{title_bn} - {institute_id}"
                                    data-depend-on-optional="institute_id"
                                    data-placeholder="ভিডিও নির্বাচন করুন"
                            >
                                <option value="">ভিডিও নির্বাচন করুন</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-1">
                        <button class="btn btn-success" id="skill-video-search-btn">{{ __('অনুসন্ধান') }}</button>
                    </div>

                    <div class="col">
                        <div class="overlay" style="display: none">
                            <i class="fas fa-2x fa-sync-alt fa-spin"></i>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <div class="row justify-content-center" id="container-skill-videos">

        </div>
        <div class="row mb-5">
            <div class="col-md-12">
                <div class="prev-next-button float-right">

                </div>
                <div class="overlay" style="display: none">
                    <i class="fas fa-2x fa-sync-alt fa-spin"></i>
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
                html += '<source src = storage/' + item.uploaded_video_path + ' type="video/mp4"';
                html += '></video>';
            }
            html += '</div>';
            html += '<div class="video-title mt-3 mb-3 text-dark font-weight-bold text-center">';
            html += item.title_en;
            html += '</div></div>';
            return html;
        };

        const paginatorLinks = function (link) {
            let html = '';
            if (link.active) {
                html += '<li class="page-item active"><a class="page-link">' + link.label + '</a></li>';
            } else if (!link.url) {
                html += '<li class="page-item"><a class="page-link">' + link.label + '</a></li>';
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
            columns: 'youtube_video_id|uploaded_video_path|title_en|video_type'
        });

        function videoSearch(url = baseUrl) {
            $('.overlay').show();
            let searchQuery = $('#search').val();
            let institute = $('#institute_id').val();
            let videoCategory = $('#video_category_id').val();
            let video = $('#video_id').val();

            const filters = {};
            if (searchQuery?.toString()?.length) {
                filters['title_en'] = {
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
                window.scrollTo(0,0);
                let html = '';
                if (response?.data?.data.length <= 0) {
                    html += '<div class="text-center" "><div class="fa fa-sad-tear" style="font-size: 20px;"></div><div class="text-center h3">কোন ভিডিও পাওয়া যায়নি!</div>';
                }
                $.each(response.data?.data, function (i, item) {
                    html += template(item);
                });

                $('#container-skill-videos').html(html);
                $('.prev-next-button').html(response?.pagination);

                // let link_html = '<nav> <ul class="pagination">';
                // $.each(response.links, function (i, link) {
                //     link_html += paginatorLinks(link);
                //     // window.history.pushState("", "", link.url);
                // });
                // link_html += '</ul></nav>';
                // $('.prev-next-button').html(link_html);
            });
        }

        $(document).ready(function () {
            videoSearch();

            $(document).on('click', '.pagination .page-link', function (e) {
                e.preventDefault();
                let url = $(this).attr('href');
                videoSearch(url);
            });

            $('#skill-video-search-btn').on('click', function () {
                videoSearch();
            });
        });
    </script>
@endpush
