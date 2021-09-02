@extends('master::layouts.master')

@section('title')
    Visitor Feedback List
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header text-primary custom-bg-gradient-info">
                        <h3 class="card-title font-weight-bold">Visitor Feedback List</h3>

                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="datatable-container">
                            <div class="filter-area">
                                <div class="">
                                    <div class="filter-item filter-label-header">
                                        <labe>
                                            <i class="fas fa-sort-amount-up-alt filter-icon"></i>
                                            <b>Filter : </b>
                                        </labe>
                                    </div>

                                    <div class="filter-item">
                                        <input type="radio"id="all_filter" name="form_type" class="form_type" value="">
                                        <label for="all_filter">All</label>
                                    </div>

                                    <div class="filter-item">
                                        <input type="radio" id="feedbacl_filter" name="form_type" class="form_type"
                                               value="{{\Module\CourseManagement\App\Models\VisitorFeedback::FORM_TYPE_FEEDBACK}}">
                                        <label for="feedbacl_filter">Feedback</label>
                                    </div>

                                    <div class="filter-item">
                                        <input type="radio" id="contact_filter" name="form_type" class="form_type"
                                               value="{{\Module\CourseManagement\App\Models\VisitorFeedback::FORM_TYPE_CONTACT}}">
                                        <label for="contact_filter">Contact</label>
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
            .filter-area{
                position: absolute;
                padding: 0 60px;
            }
        }
        .filter-area{
            /*position: absolute;
            padding: 0 60px;*/

        }
        .filter-item{
            display: inline-block;
            padding: 0 10px;
        }
        .filter-icon{
            color: #007bff;
            font-size: 26px;
        }
        .filter-label-header{
            padding: 0 !important;
        }
    </style>
@endpush

@push('js')
    <script type="text/javascript" src="{{asset('/js/datatable-bundle.js')}}"></script>

    <script>
        $(function () {
            let params = serverSideDatatableFactory({
                url: '{{route('course_management::admin.visitor-feedback.datatable')}}',
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
                        title: "Name",
                        data: "name",
                        name: "visitor_feedback.name"
                    },
                    {
                        title: "Mobile",
                        data: "mobile",
                        name: "visitor_feedback.mobile"
                    },
                    {
                        title: "Email",
                        data: "email",
                        name: "visitor_feedback.email"
                    },
                    {
                        title: "Type",
                        data: "form_type",
                        name: "visitor_feedback.form_type",
                    },
                    {
                        title: "View Status",
                        data: "read_at",
                        name: "visitor_feedback.read_at"
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

            $('.form_type').on('change', function () {
                datatable.draw();
            });

            //Filter by all option selected
            $('#all_filter').prop("checked", true);

        });
    </script>
@endpush
