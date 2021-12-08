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
                        title: "{{__('course_management::admin.batch.course_title')}}",
                        data: "courses.title_en",
                        name: "courses.title_en"
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
