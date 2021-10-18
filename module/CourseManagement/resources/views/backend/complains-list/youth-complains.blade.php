@extends('master::layouts.master')

@section('title')
    Youth Complain List
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header text-primary custom-bg-gradient-info">
                        <h3 class="card-title font-weight-bold">Youth Complain List</h3>

                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="datatable-container">
                            <div class="filter-area">
                                <div class="">
                                    <div class="filter-item">
                                        <a class="btn btn-sm {{ request()->is('admin/course-management/youth-complains*') ? 'btn-info' : 'btn-outline-info' }} "
                                           href="{{ route('course_management::admin.youth-complains') }}"
                                           style="min-width: 100px">Youth</a>
                                    </div>

                                    <div class="filter-item">
                                        <a class="btn btn-sm {{ request()->is('admin/course-management/organization-complains*') ? 'btn-info' : 'btn-outline-info' }}"
                                           href="{{ route('course_management::admin.organization-complains') }}"
                                           style="min-width: 100px">Organization</a>
                                    </div>

                                </div>
                            </div>

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
    <style>
        @media only screen and (min-width: 825px) {
            .filter-area {
                position: absolute;
                padding: 0 60px;
                margin-bottom: 5px;
            }
        }

        .filter-area {
            /*position: absolute;
            padding: 0 60px;*/

        }

        .filter-item {
            display: inline-block;
            padding: 0 10px;
        }

        .filter-icon {
            color: #007bff;
            font-size: 26px;
        }

        .filter-label-header {
            padding: 0 !important;
        }
    </style>
@endpush

@push('js')
    <script type="text/javascript" src="{{asset('/js/datatable-bundle.js')}}"></script>

    <script>
        $(function () {
            let baseUrl = '{{route('course_management::admin.youth-complains.datatable')}}';
            let params = serverSideDatatableFactory({
                url: baseUrl,
                //order: [[0, "desc"]],
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
                        title: "Institute Name",
                        data: "institute_name",
                        name: "institutes.title_en",
                        visible: false,
                    },
                    {
                        title: "From",
                        data: "youth_name_en",
                        name: "youths.name_en"
                    },
                    {
                        title: "TO",
                        data: "organization_title_en",
                        name: "organizations.title_en"
                    },
                    {
                        title: "Complain Title",
                        data: "complain_title",
                        name: "youth_complain_to_organizations.complain_title"
                    },
                    {
                        title: "Date",
                        data: "created_at",
                        name: "youth_complain_to_organizations.created_at",
                        visible: true
                    },
                    {
                        title: "View Status",
                        data: "read_at",
                        name: "youth_complain_to_organizations.read_at"
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

            params.ajax.data = d => {
                d.form_type = $('.form_type:checked').val();
            };

            const datatable = $('#dataTable').DataTable(params);
            bindDatatableSearchOnPresEnterOnly(datatable);

            $(document, 'td').on('click', '.delete', function (e) {
                $('#delete_form')[0].action = $(this).data('action');
                $('#delete_modal').modal('show');
            });
        });
    </script>
@endpush
