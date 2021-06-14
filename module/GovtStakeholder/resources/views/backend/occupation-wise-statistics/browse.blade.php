@extends('master::layouts.master')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header text-primary custom-bg-gradient-info">
                        <h3 class="card-title font-weight-bold">Occupation Wise Statistic List</h3>

                        <div class="card-tools">
                            @can('create', \Module\GovtStakeholder\App\Models\OccupationWiseStatistic::class)
                                <a href="{{route('govt_stakeholder::admin.occupation-wise-statistics.create')}}"
                                   class="btn btn-sm btn-outline-primary btn-rounded">
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
    @include('master::utils.delete-confirm-modal')

@endsection
@push('css')
    <link rel="stylesheet" href="{{asset('/css/datatable-bundle.css')}}">
@endpush

@push('js')
    <script type="text/javascript" src="{{asset('/js/datatable-bundle.js')}}"></script>
    <script>
        $(function () {
            let params = serverSideDatatableFactory({
                url: '{{route('govt_stakeholder::admin.occupation-wise-statistics.datatable')}}',
                order: [[1, "desc"]],
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
                        title: "Institute",
                        data: "institute_title_en",
                        name: "institutes.title_en"
                    },
                    {
                        title: "Occupation",
                        data: "occupation_title_en",
                        name: "occupations.title_en"
                    },
                    {
                        title: "Current Month Skilled Youth",
                        data: "current_month_skilled_youth",
                        name: "occupation_wise_statistics.current_month_skilled_youth"
                    },
                    {
                        title: "Next Month Skilled Youth",
                        data: "next_month_skill_youth",
                        name: "occupation_wise_statistics.next_month_skill_youth"
                    },
                    {
                        title: "Status",
                        data: "row_status",
                        name: "occupation_wise_statistics.row_status"
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


