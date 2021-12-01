@extends('master::layouts.master')

@section('title')
    {{ __('Routine List') }}
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header text-primary custom-bg-gradient-info">
                        <h3 class="card-title font-weight-bold">{{__('course_management::admin.daily_routine.weekly_routine')}}</h3>

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
                url: '{{route('course_management::admin.weekly-routine.datatable')}}',
                order: [[2, "desc"]],
                columns: [
                    {
                        title: '{{__('course_management::admin.routine.sl')}}',
                        data: null,
                        defaultContent: "SL#",
                        searchable: false,
                        orderable: false,
                        visible: true,
                    },



                    {
                        title: "{{__('course_management::admin.routine.training_center')}}",
                        data: "training_center.title_en",
                        name: "routines.training_center_id"
                    },
                    {
                        title: "{{__('course_management::admin.routine.batch_title')}}",
                        data: "batch.title_en",
                        name: "routines.batch_id"
                    },
                    {
                        title: "{{__('course_management::admin.routine.day')}}",
                        data: "day",
                        name: "routines.day"
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


