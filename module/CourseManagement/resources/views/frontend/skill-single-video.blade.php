@php
    $currentInstitute = domainConfig('institute');
    $layout = 'master::layouts.front-end';
@endphp

@extends($layout)

@section('title')
    ভিডিও
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card mb-2">
                    <div class="card-header custom-bg-gradient-info">
                        <h2 class="text-center text-primary font-weight-lighter">{{ !empty($youthVideos)? $youthVideos->title_bn:'' }}</h2>
                    </div>
                    {{--<div class="card-tools">
                        <div class="m-2">
                            <a href="javascript: history.go(-1)"
                               class="btn btn-sm btn-outline-primary btn-rounded float-right">
                                <i class="fas fa-backward"></i> {{ __('পূর্বের পেজে যান') }}
                            </a>
                        </div>
                    </div>--}}
                    <div class="px-5 py-4">
                        <div class="row">
                            <div class="col-md-10 mx-auto">
                                @if($youthVideos->youtube_video_id !=null)
                                    <iframe
                                        src="https://www.youtube.com/embed/{{ !empty($youthVideos)? $youthVideos->youtube_video_id:'' }}?autoplay=1"
                                        frameborder="0"
                                        height="500px" width="100%"
                                        allow='accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share'
                                        allowFullScreen>
                                    </iframe>
                                @else
                                    <iframe
                                        src="{{ asset("storage/{$youthVideos->uploaded_video_path}") }}"
                                        frameborder="0"
                                        height="500px" width="100%"
                                        allow='accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share'
                                        allowFullScreen>
                                    </iframe>
                                @endif
                            </div>
                        </div>

                    </div>
                </div>
            </div>

        </div>
@endsection

