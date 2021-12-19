@php
    $currentInstitute = app('currentInstitute');
    $layout = 'master::layouts.front-end';

@endphp

@extends($layout)

@section('title')
    {{ __('generic.course') }}
@endsection

@section('content')
    <div class="container-fluid" id="fixed-scrollbar">
        <div class="row  justify-content-center">
            <div class="col-md-8 col-sm-8">
                <div class="card mt-3">
                    <div class="card-header d-flex justify-content-between custom-bg-gradient-info"
                         style="background: url('{{asset('storage/'. optional($course)->cover_image)}}') no-repeat center center;
                             background-size: cover; min-height: 40vh;"
                    >
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 custom-view-box">
                                <p class="label-text">{{__('admin.course.title')}} </p>
                                <div class="input-box" id="course_title">
                                    {{optional($course)->title}}
                                </div>
                            </div>

                            <div class="col-md-6 custom-view-box">
                                <p class="label-text">{{__('admin.course.course_fee')}}</p>
                                <div class="input-box" id="course_fee">
                                    {{optional($course)->course_fee}}
                                </div>
                            </div>

                            <div class="col-md-6 custom-view-box">
                                <p class="label-text">{{__('admin.course.duration')}}</p>
                                <div class="input-box" id="course_duration">
                                    {{optional($course)->duration}}
                                </div>
                            </div>

                            <div class="col-md-6 custom-view-box">
                                <p class="label-text">{{__('admin.course.target_group')}}</p>
                                <div class="input-box" id="target_group">
                                    {{optional($course)->target_group}}
                                </div>
                            </div>

                            <div class="col-md-6 custom-view-box">
                                <p class="label-text">{{__('admin.course.object')}}</p>
                                <div class="input-box" id="objects">
                                    {{optional($course)->objects}}
                                </div>
                            </div>

                            <div class="col-md-6 custom-view-box">
                                <p class="label-text">{{__('admin.course.content')}}</p>
                                <div class="input-box" id="contents">
                                    {{optional($course)->contents}}
                                </div>
                            </div>

                            <div class="col-md-6 custom-view-box">
                                <p class="label-text">{{__('admin.course.training_methodology')}}</p>
                                <div class="input-box" id="training_methodology">
                                    {{optional($course)->training_methodology}}
                                </div>
                            </div>

                            <div class="col-md-6 custom-view-box">
                                <p class="label-text">{{__('admin.course.evaluation_system')}}</p>
                                <div class="input-box" id="evaluation_system">
                                    {{optional($course)->evaluation_system}}
                                </div>
                            </div>

                            <div class="col-md-12 custom-view-box">
                                <p class="label-text">{{__('admin.course.description')}}</p>
                                <div class="input-box" id="description">
                                    <p>{{optional($course)->description}}</p>
                                </div>
                            </div>
                            <div class="col-md-6 custom-view-box">
                                <p class="label-text">{{__('admin.course.course_prerequisite')}} </p>
                                <div class="input-box" id="prerequisite">
                                    {{optional($course)->prerequisite}}
                                </div>
                            </div>
                            <div class="col-md-6 custom-view-box">
                                <p class="label-text">{{__('admin.course.eligibility')}}</p>
                                <div class="input-box" id="eligibility">
                                    {{optional($course)->eligibility}}
                                </div>
                            </div>
                            <div class="col-md-6 custom-view-box">
                                <p class="label-text">{{__('admin.common.status')}}</p>
                                <div class="input-box" id="active_status">
                                    {!! $course->getCurrentRowStatus(true) !!}
                                </div>
                            </div>
                            <div class="col-md-6 custom-view-box">
                                <p class="label-text">{{__('admin.course.institute_title')}} </p>
                                <div class="input-box" id="institute_name_field">
                                    {{optional($course->institute)->title}}
                                </div>
                            </div>
                            <div class="col-md-6 custom-view-box">
                                <p class="label-text">{{__('admin.course.institute_address')}}</p>
                                <div class="input-box" id="institute_address">
                                    {{optional($course->institute)->address}}
                                </div>
                            </div>
                            <div class="col-md-12 custom-view-box">
                                <div class="row">
                                    <div class="col-md-6">
                                        <p class="label-text">{{__('admin.course.batch_list')}}</p>
                                        <ul class="list-group">
                                            @foreach($batches as $batch)
                                                <li class="list-group-item"><input class="batch-list" data-id="{{ $batch->id }}" type="checkbox" value="{{ $batch->title }}" /> <label for="batch title">{{ $batch->title }}</label></li>
                                            @endforeach
                                        </ul>
                                    </div>
                                    <div class="col-md-6">
                                        <p class="label-text">{{'Selected '}}{{__('admin.course.batch_list')}}</p>
                                        <ul class="list-group selected-batch-list">

                                        </ul>
                                    </div>
                                </div>

                            </div>
                            <div class="col-md-12 custom-view-box mt2 " style="text-align: center">
                                <a href="#" class="btn btn-primary " style="padding: 2px 10px;" >আবেদন</a>
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

        .card-header-title {
            min-height: 48px;
        }

        .card-bar-home-course img {
            height: 14vw;
        }

        .gray-color {
            color: #73727f;
        }
        .course-heading-wrap {
            text-overflow: ellipsis;
            white-space: nowrap;
            overflow: hidden;
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
        .header-bg {
            background: #671688;
            color:white;
        }
        .modal-header .close, .modal-header .mailbox-attachment-close {
            padding: 1rem;
            margin: -1rem -1rem -1rem auto;
            color: white;
            outline: none;
        }
        .card-p1 {
            color: #671688;
        }
    </style>
@endpush
@push('js')
    <script>
    $(document).ready(function(){

        $('.batch-list').on('click',function(){
            if($(this).is(':checked')){
                $('.selected-batch-list').append('<li id="batch-list-item-'+$(this).attr("data-id")+'" class="list-group-item"><input name="batches[]"' +
                    ' type="hidden" value="'+$(this).attr("data-id")+'"/><label for="Batch title">'+$(".selected-batch-list").children().length+'. '+$(this).val()+'</lable></li>');
            }else if(!($(this).is(':checked'))){
                $("#batch-list-item-"+$(this).attr("data-id")).remove();
            }
        });
        if($(".selected-batch-list").children().length == 0){
            //$(".selected-batch-list").append('<li class="list-group-item" style="background: #bd2130;color: #ffffff;" ><span >No batch selected</span></li>');
        }
    });
    </script>
@endpush
