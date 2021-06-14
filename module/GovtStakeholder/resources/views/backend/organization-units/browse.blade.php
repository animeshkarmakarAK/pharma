@extends('master::layouts.master')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header text-primary custom-bg-gradient-info">
                        <h3 class="card-title font-weight-bold">Organization Units List</h3>

                        <div class="card-tools">
                            @can('create', \Module\GovtStakeholder\App\Models\OrganizationUnit::class)
                                <a href="{{route('govt_stakeholder::admin.organization-units.create')}}"
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
                url: '{{ route('govt_stakeholder::admin.organization-units.datatable') }}',
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
                        data: "organization_name",
                        name: "organization.title_en"
                    },
                    {
                        title: "Division",
                        data: "division_name",
                        name: "loc_division.title_en",
                        visible: false,
                    },
                    {
                        title: "District",
                        data: "district_name",
                        name: "loc_district.title_en",
                        visible: false,
                    },
                    {
                        title: "Upazila",
                        data: "upazila_name",
                        name: "loc_upazila.title_en",
                        visible: false,
                    },
                    {
                        title: "Address",
                        data: "address",
                        name: "address"
                    },

                    {
                        title: "Mobile",
                        data: "mobile",
                        name: "mobile",
                        visible: false,
                    },
                    {
                        title: "Email",
                        data: "email",
                        name: "email",
                        visible: false,
                    },
                    {
                        title: "Fax No.",
                        data: "fax_no",
                        name: "fax_no",
                        visible: false,
                    },
                    {
                        title: "Contact Person Name",
                        data: "contact_person_name",
                        name: "contact_person_name",
                        visible: false,
                    },
                    {
                        title: "Contact Person Mobile",
                        data: "contact_person_mobile",
                        name: "contact_person_mobile",
                        visible: false,
                    },
                    {
                        title: "Contact Person Email",
                        data: "contact_person_email",
                        name: "contact_person_email",
                        visible: false,
                    },
                    {
                        title: "Contact Person Designation",
                        data: "contact_person_designation",
                        name: "contact_person_designation",
                        visible: false,
                    },
                    {
                        title: "Employee Size",
                        data: "employee_size",
                        name: "employee_size",
                        visible: false,
                    },
                    {
                        title: "Organization Unit Type",
                        data: "organization_unit_name",
                        name: "organization_unit_types.title_en",
                    },
                    {
                        title: "Active Status",
                        data: "row_status",
                        name: "row_status"
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
