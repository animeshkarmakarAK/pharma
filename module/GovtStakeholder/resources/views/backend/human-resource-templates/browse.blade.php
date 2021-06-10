@extends('core.main')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header text-primary custom-bg-gradient-info">
                        <h3 class="card-title font-weight-bold">Human Resources List</h3>

                        <div class="card-tools">
                            @can('create', \Module\GovtStakeholder\App\Models\HumanResourceTemplate::class)
                                <a href="{{route('admin.human-resource-templates.create')}}"
                                   class="btn btn-sm btn-outline-primary btn-rounded">
                                    <i class="fas fa-plus-circle"></i> Add new
                                </a>
                            @endcan
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="datatable-container">
                            <table id="dataTable" class="table table-bordered table-striped dataTable compact">
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
                url: '{{ route('admin.human-resource-templates.datatable') }}',
                order: [[4, "asc"]],
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
                        title: "Title (Bn)",
                        data: "title_en",
                        name: "title_en"
                    },
                    {
                        title: "Title (En)",
                        data: "title_bn",
                        name: "title_bn"
                    },
                    {
                        title: "Organization Name",
                        data: "organization_title",
                        name: "organizations.title_en"
                    },
                    {
                        title: "Parent",
                        data: "parent",
                        name: "human_resource_templates.parent_id"
                    },
                    {
                        title: "Organization Unit Type",
                        data: "organization_unit_type_title",
                        name: "organization_unit_types.title_en",
                        visible: false
                    },
                    {
                        title: "Rank",
                        data: "rank_title",
                        name: "ranks.title_en"
                    },
                    {
                        title: "Display Order",
                        data: "display_order",
                        name: "display_order"
                    },
                    {
                        title: "Is Designation?",
                        data: "is_designation",
                        name: "is_designation",
                        visible: false
                    },
                    {
                        title: "Skills",
                        data: "skills",
                        name: "skill_ids",
                        visible: false,
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
