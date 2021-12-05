@php

    $authUser = \App\Helpers\Classes\AuthHelper::getAuthUser();


@endphp

@extends('master::layouts.master')

@section('title')
    {{ __('course_management::admin.intro-video.list') }}
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header text-primary custom-bg-gradient-info">
                        <h3 class="card-title font-weight-bold">{{ !$authUser->institute_id? __('course_management::admin.intro-video.list') : __('course_management::admin.intro-video.index') }}</h3>
                        <div class="card-tools">
                            @can('create', Module\CourseManagement\App\Models\Video::class)

                                @if(!$authUser->institute_id)
                                    <a href="{{route('course_management::admin.intro-videos.create')}}"
                                       class="btn btn-sm btn-outline-primary btn-rounded">
                                        <i class="fas fa-plus-circle"></i> {{__('course_management::admin.common.add')}}
                                    </a>
                                @endif

                                @if($videosCount == 0 && $authUser->institute_id)
                                    <a href="{{route('course_management::admin.intro-videos.create')}}"
                                       class="btn btn-sm btn-outline-primary btn-rounded">
                                        <i class="fas fa-plus-circle"></i> {{ __('course_management::admin.intro-video.add') }}
                                    </a>
                                @endif
                            @endcan
                        </div>

                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="datatable-container">
                            <table id="dataTable" class="table table-bordered table-striped dataTable">
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('utils.delete-confirm-modal')
@endsection
@push('css')
    <link rel="stylesheet" href="{{asset('/css/datatable-bundle.css')}}">
@endpush

@push('js')
    <script type="text/javascript" src="{{asset('/js/datatable-bundle.js')}}"></script>
    <script>
        $(function () {
            let params = serverSideDatatableFactory({
                url: '{{ route('course_management::admin.intro-videos.datatable') }}',
                order: [[2, "asc"]],
                columns: [
                    {
                        title: "SL#",
                        data: null,
                        defaultContent: "SL#",
                        searchable: false,
                        orderable: false,
                        visible: true,
                    },
                    {
                        title: "{{ __('course_management::admin.intro-video.youtube_video_url') }}",
                        data: "youtube_video_url",
                        name: "intro_videos.youtube_video_url",
                    },
                    {
                        title: "{{ __('course_management::admin.intro-video.institute_name') }}",
                        data: "institute_name",
                        name: "institutes.title_en",
                        visible: false,
                    },
                    {
                        title: "{{ __('course_management::admin.common.status') }}",
                        data: "row_status",
                        name: "intro_videos.row_status",
                    },

                    {
                        title: "{{ __('course_management::admin.common.action') }}",
                        data: "action",
                        name: "action",
                        orderable: false,
                        searchable: false,
                        visible: true
                    },
                ]
            });
            const datatable = $('#dataTable').DataTable(params);
            bindDatatableSearchOnPresEnterOnly(datatable);

            $(document, 'td').on('click', '.delete', function (e) {
                $('#delete_form')[0].action = $(this).data('action');
                $('#delete_modal').modal('show');
            });
        });
    </script>
@endpush
