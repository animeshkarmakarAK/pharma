@extends('master::layouts.master')

@section('title')
    {{ __('Examination List') }}
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header text-primary custom-bg-gradient-info">
                        <h3 class="card-title font-weight-bold">{{__('course_management::admin.examination.list')}}</h3>

                        <div class="card-tools">
                            @can('create', \Module\CourseManagement\App\Models\Examination::class)
                                <a href="{{route('course_management::admin.examinations.create')}}"
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
                url: '{{route('course_management::admin.examinations.datatable')}}',
                order: [[2, "desc"]],
                columns: [
                    {
                        title: '{{__('course_management::admin.examination.sl')}}',
                        data: null,
                        defaultContent: "SL#",
                        searchable: false,
                        orderable: false,
                        visible: true,
                    },

                    {
                        title: "{{__('course_management::admin.examination.examination_type')}}",
                        data: "examination_type.title",
                        name: "examinations.examination_type_id"
                    },

                    {
                        title: "{{__('course_management::admin.examination.training_center')}}",
                        data: "training_center.title_en",
                        name: "examinations.training_center_id"
                    },
                    {
                        title: "{{__('course_management::admin.examination.batch_title')}}",
                        data: "batch.title_en",
                        name: "examinations.batch_id"
                    },




                    {
                        title: "{{__('course_management::admin.examination.exam_details')}}",
                        data: "exam_details",
                        name: "examinations.exam_details"
                    },
                    {
                        title: "{{__('course_management::admin.examination.pass_mark')}}",
                        data: "pass_mark",
                        name: "examinations.pass_mark"
                    },
                    {
                        title: "{{__('course_management::admin.examination.total_mark')}}",
                        data: "total_mark",
                        name: "examinations.total_mark"
                    },
                    {
                        title: "{{__('course_management::admin.examination.action')}}",
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


