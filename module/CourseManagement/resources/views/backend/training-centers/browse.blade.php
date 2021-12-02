@extends('master::layouts.master')

@section('title')
    {{ __('Training Center List') }}
@endsection


@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header text-primary custom-bg-gradient-info">
                        <h3 class="card-title font-weight-bold">Training Center List</h3>

                        <div class="card-tools">
                            @can('create', \Module\CourseManagement\App\Models\TrainingCenter::class)
                                <a href="{{route('course_management::admin.training-centers.create')}}"
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
                url: '{{ route('course_management::admin.training-centers.datatable') }}',
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
                        title: "Title (En)",
                        data: "title_en",
                        name: "training_centers.title_en"
                    },
                    {
                        title: "Institute Name",
                        data: "institute_name",
                        name: "institutes.title_en",
                        visible: false,
                    },

                    {
                        title: "Branch Name",
                        data: "branch_name",
                        name: "branches.title_en",
                        visible: true,
                    },
                    {
                        title: "Created By",
                        data: "training_center_created_by",
                        name: "training_centers.created_by",
                        visible: false,
                    },
                    {
                        title: "Created Date",
                        data: "created_at",
                        name: "training_centers.created_at",
                        visible: false,
                        searchable: false,
                    },

                    {
                        title: "Update Date",
                        data: "updated_at",
                        name: "training_centers.updated_at",
                        visible: false,
                        searchable: false,
                    },
                    {
                        title: "Action",
                        data: "action",
                        orderable: false,
                        searchable: false,
                        visible: true
                    }
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


