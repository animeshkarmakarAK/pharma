@extends('master::layouts.master')

@section('title')
    {{ __('Course List') }}
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header text-primary custom-bg-gradient-info">
                        <h3 class="card-title font-weight-bold">Course List</h3>
                        <div class="card-tools">
                            @can('create', \Module\CourseManagement\App\Models\Course::class)
                                <a href="{{route('course_management::admin.courses.create')}}"
                                   class="btn btn-sm btn-outline-primary btn-rounded">
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
                url: '{{ route('course_management::admin.courses.datatable') }}',
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
                        title: "{{__('course_management::admin.course.title')}}",
                        data: "title_en",
                        name: "title_en"
                    },
                    {
                        title: "{{__('course_management::admin.course.code')}}",
                        data: "code",
                        name: "code"
                    },

                    {
                        title: "{{__('course_management::admin.course.institute_name')}}",
                        data: "institute_title",
                        name: "institutes.title_en",
                        visible: false,
                    },
                    {
                        title: "{{__('course_management::admin.course.course_fee')}}",
                        data: "course_fee",
                        name: "course_fee",
                    },
                    {
                        title: "{{__('course_management::admin.course.duration')}}",
                        data: "duration",
                        name: "duration",
                        visible: false,
                    },
                    {
                        title: "{{__('course_management::admin.course.target_group')}}",
                        data: "target_group",
                        name: "target_group",
                        visible: false,
                    },
                    {
                        title: "{{__('course_management::admin.course.object')}}",
                        data: "objects",
                        name: "objects",
                        visible: false,
                    },
                    {
                        title: "{{__('course_management::admin.course.content')}}",
                        data: "contents",
                        name: "contents",
                        visible: false,
                    },
                    {
                        title: "{{__('course_management::admin.course.training_methodology')}}",
                        data: "training_methodology",
                        name: "training_methodology",
                        visible: false,
                    },
                    {
                        title: "{{__('course_management::admin.course.evaluation_system')}}",
                        data: "evaluation_system",
                        name: "evaluation_system",
                        visible: false,
                    },
                    {
                        title: "{{__('course_management::admin.course.status')}}",
                        data: "row_status",
                        name: "courses.row_status",
                        orderable: false,
                        searchable: false,
                        visible: true
                    },
                    {
                        title: "{{__('course_management::admin.common.action')}}",
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
