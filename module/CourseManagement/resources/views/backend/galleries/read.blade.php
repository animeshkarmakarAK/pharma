@extends('master::layouts.master')



@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-4">
                <div class="user-details card mb-3">
                    <div
                        class="card-header custom-bg-gradient-info font-weight-bold text-primary">{{ __('Gallery Media') }}</div>
                    @if( \Module\CourseManagement\App\Models\Gallery::CONTENT_TYPE_IMAGE == $gallery->content_type)
                        <div class="col-md-12 custom-view-box text-center mt-3">

                            <div class="card-header d-flex justify-content-between custom-bg-gradient-info">
                                <img src="{{asset('storage/' .$gallery->content_path)}}" class="img-fluid"
                                     alt="Responsive image" style="height: 300px; width: 100%">
                            </div>
                            <p class="label-text">{{ __('Image') }}</p>

                        </div>
                    @elseif(\Module\CourseManagement\App\Models\Gallery::CONTENT_TYPE_VIDEO == $gallery->content_type && $gallery->is_youtube_video )
                        <div class="col-md-12 custom-view-box text-center mt-3">
                            <iframe width="100%" height="100%"
                                    src={{"https://www.youtube.com/embed/".$gallery->you_tube_video_id}}>
                            </iframe>

                            <p class="label-text">{{ __('Youtube Video Content') }}</p>

                        </div>

                    @elseif(\Module\CourseManagement\App\Models\Gallery::CONTENT_TYPE_VIDEO == $gallery->content_type)
                        <div class="col-md-12 custom-view-box text-center mt-3">
                            <iframe width="100%" height="100%"
                                    src="{{asset('storage/' .$gallery->content_path)}}">
                            </iframe>
                            <p class="label-text">{{ __('Uploaded Video Content') }}</p>

                        </div>
                    @endif
                </div>

            </div>
            <div class="col-md-8">

                <div class="card">
                    <div class="card-header text-primary custom-bg-gradient-info">
                        <h3 class="card-title font-weight-bold">{{ __('Gallery') }}</h3>

                        <div class="card-tools">
                            <div class="btn-group">
                                <a href="{{route('course_management::admin.galleries.edit', [$gallery->id])}}"
                                   class="btn btn-sm btn-outline-primary btn-rounded">
                                    <i class="fas fa-plus-circle"></i> {{ __('Edit Gallery') }}
                                </a>
                                <a href="{{route('course_management::admin.galleries.index')}}"
                                   class="btn btn-sm btn-outline-primary btn-rounded">
                                    <i class="fas fa-backward"></i> {{ __('Back to list') }}
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="row card-body">
                        <div class="col-md-6 custom-view-box">
                            <p class="label-text">{{ __('Caption') }}</p>
                            <div class="input-box">
                                {{ $gallery->content_title }}
                            </div>
                        </div>

                        <div class="col-md-6 custom-view-box">
                            <p class="label-text">{{ __('Content Type') }}</p>
                            <div class="input-box">
                                {{ \Module\CourseManagement\App\Models\Gallery::CONTENT_TYPES[$gallery->content_type]}}
                            </div>
                        </div>

                        <div class="col-md-6 custom-view-box">
                            <p class="label-text">{{ __('Institute Name') }}</p>
                            <div class="input-box">
                                {{ $gallery->institute->title_en }}
                            </div>
                        </div>
                        <div class="col-md-6 custom-view-box">
                            <p class="label-text">{{ __('Publish Date') }}</p>
                            <div class="input-box">
                                {{ $gallery->publish_date }}
                            </div>
                        </div>
                        <div class="col-md-6 custom-view-box">
                            <p class="label-text">{{ __('Archive Date') }}</p>
                            <div class="input-box">
                                {{ $gallery->archive_date }}
                            </div>
                        </div>
                        @if($gallery->content_type==\Module\CourseManagement\App\Models\Gallery::CONTENT_TYPE_VIDEO)
                            <div class="col-md-6 custom-view-box">
                                <p class="label-text">{{ __('Video Type') }}</p>
                                <div class="input-box">
                                    {{ $gallery->is_youtube_video?'Youtube':'Uploaded Video'}}
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

            </div>

        </div>

    </div>
@endsection
