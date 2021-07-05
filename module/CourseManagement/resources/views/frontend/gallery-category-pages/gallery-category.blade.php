@php
    $currentInstitute = domainConfig('institute');
    $layout = $currentInstitute ? 'master::layouts.custom1' : 'master::layouts.front-end';
@endphp
@extends($layout)

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header custom-bg-gradient-info">
                            <h1 class="text-center text-primary mt-4">{{ $galleryCategory->title_bn }}</h1>
                        </div>
                        <div class="card-body bg-gray-light">
                            <div class="row">
                                @if($galleries->count())
                                    @foreach($galleries as $gallery)
                                        <div class="col-md-3">
                                            <div class="card">
                                                <div class="card-body">
                                                    <a href="" data-toggle="modal"
                                                       data-target="#gallery_id_{{$gallery->id}}">
                                                        @if($gallery->content_type == \Module\CourseManagement\App\Models\Gallery::CONTENT_TYPE_IMAGE)
                                                            <img class="img-responsive"
                                                                 style="width: 100%; height: 200px"
                                                                 src="{{asset('/storage/'. $gallery->content_path)}}">
                                                        @else
                                                            <div class="position-relative">
                                                                <div class="iframe-layer"></div>
                                                                <div class="iframe-class">
                                                                    <iframe width="100%" height="200px"
                                                                            style="border: none"
                                                                            src={{"https://www.youtube.com/embed/".$gallery->you_tube_video_id}}>
                                                                    </iframe>
                                                                </div>
                                                            </div>
                                                        @endif
                                                    </a>
                                                </div>
                                                <div class="card-footer">
                                                    <h6 class="float-left">{{$gallery->content_title}}</h6>
                                                    <h6 class="float-right">{{$gallery->created_at->format('d-m-Y')}}</h6>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="col-md-12 m-5">
                                        <h5 class="text-center text-danger">এই অ্যালবামে কোন ছবি নেই</h5>
                                    </div>
                                @endif

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Modal -->
    @if(!empty($galleries))
        @foreach($galleries as $gallery)
            <div class="modal fade" id="gallery_id_{{ $gallery->id }}" tabindex="-1" role="dialog"
                 aria-labelledby="gallery_id_{{ $gallery->id }}" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                    <div class="modal-content gallery_modal">
                        <div class="modal-header">
                            <button type="button" class="close modal_close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div>
                            @if($gallery->content_type == \Module\CourseManagement\App\Models\Gallery::CONTENT_TYPE_IMAGE)
                                <div class="card-overlay bg-black">
                                    <img class="img-responsive gallery-image"
                                         src="{{asset('/storage/'. $gallery->content_path)}}" width="100%">
                                </div>
                            @else
                                <div class="embed-responsive embed-responsive-16by9">
                                    <iframe class="embed-responsive-item"
                                            src="{{'https://www.youtube.com/embed/'.$gallery->you_tube_video_id}}">
                                    </iframe>
                                </div>
                            @endif
                        </div>
                        <div class="modal-footer justify-content-start">
                            <h5>{{$gallery->content_title}}</h5>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    @endif
@endsection

@push('css')
    <style>
        .modal{
            background: #000b16;
        }
        .gallery-image {
            display: block;
            position: relative;
            left: 0;
            top: 0;
            z-index: 0;
            opacity: 0.4;
            background: url("http://lorempixel.com/1000/600/") no-repeat center center;
            background-size: cover;
        }

        .iframe-class {
            z-index: -1;
        }

        .iframe-layer {
            position: absolute;
            height: 100%;
            z-index: 99;
            width: 100%;
            opacity: .0001;
        }

        .modal_close {
            z-index: 999;
        }

    </style>
@endpush

@push('js')
    <script>
    </script>
@endpush
