@extends('master::layouts.master')

@section('title')
    {{ __('Batches List') }}
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between custom-bg-gradient-info">
                        <h3 class="card-title font-weight-bold text-primary">{{__('course_management::admin.batch.list')}}</h3>
                        <div class="card-tools">
                            @can('create', \Module\CourseManagement\App\Models\Batch::class)
                                <a href="{{route('course_management::admin.batches.create')}}" class="btn btn-sm btn-rounded btn-primary">
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
                url: '{{ route('course_management::admin.batches.datatable') }}',
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
                        title: "{{__('course_management::admin.batch.title')}}",
                        data: "title_en",
                        name: "batches.title_en",
                    },
                    {
                        title: "{{__('course_management::admin.batch.institute_name')}}",
                        data: "institutes.title_en",
                        name: "institutes.title_en",
                        visible: false,
                    },
                    {
                        title: "{{__('course_management::admin.batch.course_title')}}",
                        data: "courses.title_en",
                        name: "courses.title_en"
                    },
                    {
                        title: "{{__('course_management::admin.batch.max_student_enrollment')}}",
                        data: "batches.max_student_enrollment",
                        name: "batches.max_student_enrollment",
                        visible: false
                    },
                    {
                        title: "{{__('course_management::admin.batch.start_date')}}",
                        data: "start_date",
                        name: "batches.start_date",
                    },

                    {
                        title: "{{__('course_management::admin.batch.end_date')}}",
                        data: "end_date",
                        name: "batches.end_date",
                        visible: false
                    },

                    {
                        title: "{{__('course_management::admin.batch.start_time')}}",
                        data: "start_time",
                        name: "batches.start_time",
                        visible: false
                    },

                    {
                        title: "{{__('course_management::admin.batch.end_time')}}",
                        data: "end_time",
                        name: "batches.end_time",
                        visible: false
                    },
                    {
                        title: "{{__('course_management::admin.batch.batch_status')}}",
                        data: "batch_status",
                        name: "batches.batch_status",
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
