@extends('master::layouts.master')

@section('title')
    {{ __('course_management::admin.publish_course.list') }}
@endsection


@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between custom-bg-gradient-info">
                        <h3 class="card-title font-weight-bold text-primary">{{ __('course_management::admin.publish_course.list') }}</h3>
                        <div class="card-tools">
                            @can('create', \Module\CourseManagement\App\Models\PublishCourse::class)
                                <a href="{{route('course_management::admin.publish-courses.create')}}" class="btn btn-sm btn-rounded btn-primary">
                                    <i class="fas fa-plus-circle"></i> {{__('course_management::admin.common.add')}}
                                </a>
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
                url: '{{ route('course_management::admin.publish-courses.datatable') }}',
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
                        title: "{{ __('course_management::admin.publish_course.title') }}",
                        data: "course_title",
                        name: "courses.title_en"
                    },

                    {
                        title: "{{ __('course_management::admin.publish_course.institute_name') }}",
                        data: "institute_title",
                        name: "institutes.title_en",
                    },
                    {
                        title: "{{ __('course_management::admin.publish_course.programme') }}",
                        data: "programme_name",
                        name: "programmes.title_en",
                    },/*
                    {
                        title: "Training Center Name",
                        data: "training_center_name",
                        name: "training_centers.title_en",
                        visible: false,
                    },*/
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
