@extends('master::layouts.master')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header text-primary custom-bg-gradient-info">
                        <h3 class="card-title font-weight-bold">Organization Units Statistics</h3>

                        <div class="card-tools">
                            @can('create', \Module\GovtStakeholder\App\Models\organizationUnitStatistic::class)
                                <a href="{{route('govt_stakeholder::admin.organization-unit-statistics.create')}}"
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
    <div class="modal modal-danger fade" tabindex="-1" id="delete_modal" role="dialog" data-backdrop="static">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header custom-bg-gradient-info">
                    <h4 class="modal-title">
                        <i class="fas fa-trash"></i> {{ __('Are you sure') }}?
                    </h4>
                    <button type="button" class="close" data-dismiss="modal"
                            aria-label="{{ __('voyager::generic.close') }}">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="delete_model_body">
                    All Occupation statistic data for current institute and current month will delete permanently.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-right"
                            data-dismiss="modal">{{ __('Cancel') }}</button>
                    <form action="#" id="delete_form" method="POST">
                        {{ method_field("DELETE") }}
                        {{ csrf_field() }}
                        <input type="submit" class="btn btn-danger pull-right delete-confirm"
                               value="{{ __('Confirm') }}">
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
@push('css')
    <link rel="stylesheet" href="{{asset('/css/datatable-bundle.css')}}">
@endpush

@push('js')
    <script type="text/javascript" src="{{asset('/js/datatable-bundle.js')}}"></script>
    <script>
        $(function () {
            let params = serverSideDatatableFactory({
                url: '{{route('govt_stakeholder::admin.organization-unit-statistics.datatable')}}',
                order: [[2, "desc"]],
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
                        title: "Organization Unit",
                        data: "organization_unit_name",
                        name: "organization_units.title_en",
                    },
                    {
                        title: "Reporting Month",
                        data: "survey_date",
                        name: "organization_unit_statistics.survey_date"
                    },
                    {
                        title: "New Recruit",
                        data: "total_new_recruits",
                        name: "organization_unit_statistics.total_new_recruits"
                    },
                    {
                        title: "Total Vacancy",
                        data: "total_vacancy",
                        name: "organization_unit_statistics.total_vacancy"
                    },
                    {
                        title: "Total occupied position",
                        data: "total_occupied_position",
                        name: "organization_unit_statistics.total_occupied_position"
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


