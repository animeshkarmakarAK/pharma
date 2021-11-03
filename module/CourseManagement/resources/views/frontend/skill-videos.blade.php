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
                    <div class="card-header p-5">
                        <h2 class="text-center text-dark font-weight-bold">ভিডিও সমূহ</h2>
                    </div>
                    <div class="card-background-white px-5 py-4">
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-1">
                                        <label
                                            style="color: #757575; line-height: calc(1.5em + .75rem); font-size: 1rem; font-weight: 400;">
                                            <i class="fa fa-filter"></i> ফিল্টার&nbsp;&nbsp;
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
                                    @endif

                                    <div class="col-md-3">
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


                                    <div class="col-md-3">
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
            </style>
        @endpush
        @push('js')

            <script>
                const template = function (item) {
                    let html = `<div class="col-md-3">
                                <div class="embed-responsive embed-responsive-16by9">`;


                    /*html += '<iframe class="embed-responsive-item youtube-video"';
                        html += ' src=https://www.youtube.com/embed/' + item.youtube_video_id + '?html5=1&enablejsapi=1;rel=0';
                        html += 'frameborder="0" allow="accelerometer; autoplay; encrypted-media; ' +
                            'gyroscope; picture-in-picture" allowfullscreen></iframe>';*/


                    html +=
                        '<a target="_blank" href="{{ route('course_management::youth.skill-single-video','__') }}"'.replace('__', item.id) + '>' +
                        '<img class="embed-responsive-item youtube-video"';
                    html += item.youtube_video_id ? ' src="http://img.youtube.com/vi/' + item.youtube_video_id + '/0.jpg "' : 'src="https://via.placeholder.com/350x350?text=Custom+Video"';
                    html += 'frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; ' +
                        'picture-in-picture" allowfullscreen></img></a>';


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

            <!-- one Youtube video will playing at a time amung the multiple embeded videos -->
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
            <script>
                var ytplayerList;

                function onPlayerReady(e) {
                    var video_data = e.target.getVideoData(),
                        label = video_data.video_id + ':' + video_data.title;
                    e.target.ulabel = label;
                    console.log(label + " is ready!");

                }

                function onPlayerError(e) {
                    console.log('[onPlayerError]');
                }

                function onPlayerStateChange(e) {
                    var label = e.target.ulabel;
                    if (e["data"] == YT.PlayerState.PLAYING) {
                        console.log({
                            event: "youtube",
                            action: "play:" + e.target.getPlaybackQuality(),
                            label: label
                        });
                        //if one video is play then pause other
                        pauseOthersYoutubes(e.target);
                    }
                    if (e["data"] == YT.PlayerState.PAUSED) {
                        console.log({
                            event: "youtube",
                            action: "pause:" + e.target.getPlaybackQuality(),
                            label: label
                        });
                    }
                    if (e["data"] == YT.PlayerState.ENDED) {
                        console.log({
                            event: "youtube",
                            action: "end",
                            label: label
                        });
                    }
                    //track number of buffering and quality of video
                    if (e["data"] == YT.PlayerState.BUFFERING) {
                        e.target.uBufferingCount ? ++e.target.uBufferingCount : e.target.uBufferingCount = 1;
                        console.log({
                            event: "youtube",
                            action: "buffering[" + e.target.uBufferingCount + "]:" + e.target.getPlaybackQuality(),
                            label: label
                        });
                        //if one video is play then pause other, this is needed because at start video is in buffered state and start playing without go to playing state
                        if (YT.PlayerState.UNSTARTED == e.target.uLastPlayerState) {
                            pauseOthersYoutubes(e.target);
                        }
                    }
                    //last action keep stage in uLastPlayerState
                    if (e.data != e.target.uLastPlayerState) {
                        console.log(label + ":state change from " + e.target.uLastPlayerState + " to " + e.data);
                        e.target.uLastPlayerState = e.data;
                    }
                }

                function initYoutubePlayers() {
                    ytplayerList = null; //reset
                    ytplayerList = []; //create new array to hold youtube player
                    for (var e = document.getElementsByTagName("iframe"), x = e.length; x--;) {
                        if (/youtube.com\/embed/.test(e[x].src)) {
                            ytplayerList.push(initYoutubePlayer(e[x]));
                            console.log("create a Youtube player successfully");
                        }
                    }

                }

                function pauseOthersYoutubes(currentPlayer) {
                    if (!currentPlayer) return;
                    for (var i = ytplayerList.length; i--;) {
                        if (ytplayerList[i] && (ytplayerList[i] != currentPlayer)) {
                            ytplayerList[i].pauseVideo();
                        }
                    }
                }

                //init a youtube iframe
                function initYoutubePlayer(ytiframe) {
                    console.log("have youtube iframe");
                    var ytp = new YT.Player(ytiframe, {
                        events: {
                            onStateChange: onPlayerStateChange,
                            onError: onPlayerError,
                            onReady: onPlayerReady
                        }
                    });
                    ytiframe.ytp = ytp;
                    return ytp;
                }

                function onYouTubeIframeAPIReady() {
                    console.log("YouTubeIframeAPI is ready");
                    initYoutubePlayers();
                }

                var tag = document.createElement('script');

                tag.src = "https://www.youtube.com/iframe_api";
                var firstScriptTag = document.getElementsByTagName('script')[0];
                firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);
            </script>

    @endpush
