@extends('core.main')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header text-primary custom-bg-gradient-info">
                        <h3 class="card-title font-weight-bold">Organization</h3>

                        <div class="card-tools">
                            @can('create', \Module\GovtStakeholder\App\Models\Organization::class)
                                <a href="{{ route('admin.organizations.create') }}"
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
                url: '{{ route('admin.organizations.datatable') }}',
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
                        name: "organizations.title_en"
                    },
                    {
                        title: "Title (Bn)",
                        data: "title_bn",
                        name: "organizations.title_bn"
                    },
                    {
                        title: "Email",
                        data: "email",
                        name: "organizations.email"
                    },
                    {
                        title: "Mobile",
                        data: "mobile",
                        name: "organizations.mobile"
                    },
                    {
                        title: "Contact Person",
                        data: "contact_person_name",
                        name: "organizations.contact_person_name",
                        orderable: false,
                        visible: false
                    },
                    {
                        title: "Organization Type",
                        data: "organization_types_title",
                        name: "organization_types.title_en"
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

