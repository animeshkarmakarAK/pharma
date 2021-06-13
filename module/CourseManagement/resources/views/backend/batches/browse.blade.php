@extends('master::layouts.master')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between custom-bg-gradient-info">
                        <h3 class="card-title font-weight-bold text-primary">Batches List</h3>
                        <div class="card-tools">
                            @can('create', \Module\CourseManagement\App\Models\Batch::class)
                                <a href="{{route('course_management::admin.batches.create')}}" class="btn btn-sm btn-rounded btn-primary">
                                    <i class="fas fa-plus-circle"></i> Add new
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
                        title: "Batch Title",
                        data: "batches.title_en",
                        name: "batches.title_en"
                    },
                    {
                        title: "Institute Name",
                        data: "institutes.title_en",
                        name: "institutes.title_en",
                        visible: false,
                    },
                    {
                        title: "Course Title",
                        data: "courses.title_en",
                        name: "courses.title_en"
                    },
                    {
                        title: "Max Student Enrollment",
                        data: "batches.max_student_enrollment",
                        name: "batches.max_student_enrollment",
                        visible: false
                    },
                    {
                        title: "Start Date",
                        data: "start_date",
                        name: "batches.start_date",
                    },

                    {
                        title: "End Date",
                        data: "end_date",
                        name: "batches.end_date",
                        visible: false
                    },

                    {
                        title: "Start Time",
                        data: "start_time",
                        name: "batches.start_time",
                        visible: false
                    },

                    {
                        title: "End Time",
                        data: "end_time",
                        name: "batches.end_time",
                        visible: false
                    },

                    {
                        title: "Action",
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
