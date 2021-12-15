@extends('master::layouts.master')

@section('title')
    {{__('admin.examination_result.list')}}
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header text-primary custom-bg-gradient-info">
                        <h3 class="card-title font-weight-bold">{{__('admin.examination_result.list')}}</h3>

                        <div class="card-tools">
                            @can('create', \App\Models\ExaminationResult::class)
                                <a href="{{route('admin.examination-results.create')}}"
                                   class="btn btn-sm btn-outline-primary btn-rounded">
                                    <i class="fas fa-plus-circle"></i> {{__('admin.common.add')}}
                                </a>
                            @endcan

                        </div>

                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <form
                            action=""
                            method="POST" class="row edit-add-form">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>#Sl</th>
                                        <th>Name</th>
                                        <th>Total Marks</th>
                                        <th>Achieved Marks</th>
                                        <th>Feedback</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <th>

                                    </th>
                                    <td>
                                        <input type="number" class="form-control custom-input-box"
                                               id="total_new_recruits"
                                               name="monthly_reports[0][total_new_recruits]"
                                               value="0">


                                    </td>
                                    <td>
                                        <input type="number" class="form-control custom-input-box"
                                               id="total_vacancy"
                                               name="monthly_reports[0][total_vacancy]"
                                               value="0">
                                    </td>
                                    <td>
                                        <input type="number" class="form-control custom-input-box"
                                               id="total_occupied_position"
                                               name="monthly_reports[0][total_occupied_position]"

                                               value="0">
                                    </td>
                                </tr>
                                </tbody>
                            </table>


                            <div class="col-sm-12 text-right">
                                <button type="submit"
                                        class="btn btn-success">Add</button>
                            </div>
                        </form>
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
                url: '{{route('admin.examination-results.datatable')}}',
                order: [[2, "desc"]],
                columns: [
                    {
                        title: '{{__('admin.examination_result.sl')}}',
                        data: null,
                        defaultContent: "SL#",
                        searchable: false,
                        orderable: false,
                        visible: true,
                    },
                    {
                        title: "{{__('admin.examination_result.achieved_marks')}}",
                        data: "achieved_marks",
                        name: "examination_results.achieved_marks"
                    },

                    {
                        title: "{{__('admin.examination_result.feedback')}}",
                        data: "feedback",
                        name: "examination_results.feedback"
                    },

                    {
                        title: "{{__('admin.examination_result.examination')}}",
                        data: "examination.exam_details",
                        //data: "examination.examination_type.title",
                        name: "examination_results.examination_id",
                        //orderable: false, searchable: false,
                    },

                    {
                        title: "{{__('admin.examination_result.training_center')}}",
                        data: "training_center.title",
                        name: "examination_results.training_center_id",

                    },
                    {
                        title: "{{__('admin.examination_result.batch_title')}}",
                        data: "batch.title",
                        name: "examination_results.batch_id"
                    },
                    {
                        title: "{{__('admin.examination_result.action')}}",
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


