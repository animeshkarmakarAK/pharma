@extends('master::layouts.master')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header text-primary custom-bg-gradient-info">
                        <h3 class="card-title font-weight-bold">Sliders List</h3>

                        <div class="card-tools">
                            @can('create', \Module\CourseManagement\App\Models\Slider::class)
                                <a href="{{route('course_management::admin.sliders.create')}}"
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
                url: '{{ route('course_management::admin.sliders.datatable') }}',
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
                        title: "Title",
                        data: "title",
                        name: "sliders.title"
                    },
                    {
                        title: "Sub-title",
                        data: "sub_title",
                        name: "sliders.sub_title"
                    },
                    {
                        title: "Picture",
                        data: "slider",
                        name: "sliders.slider"
                    },

                    {
                        title: "link",
                        data: "link",
                        name: "sliders.link",
                        visible: false,
                    },
                    {
                        title: "Institute",
                        data: "institute_name",
                        name: "institutes.title_en",
                        visible: false,
                    },
                    {
                        title: "Button",
                        data: "button_text",
                        name: "sliders.button_text",
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
