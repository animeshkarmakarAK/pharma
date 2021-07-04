@extends('master::layouts.master')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header text-primary custom-bg-gradient-info">
                        <h3 class="card-title font-weight-bold">Album List</h3>
                        <div class="card-tools">
                            @can('update', \Module\CourseManagement\App\Models\Gallery::class)
                               <button type="button" name="update-featured-gallery" id="update-featured-gallery" class="btn btn-sm btn-success btn-rounded">Update featured albums</button>
                            @endcan
                            @can('create', \Module\CourseManagement\App\Models\Gallery::class)
                                <a href="{{route('course_management::admin.gallery-categories.create')}}"
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
                url: '{{ route('course_management::admin.gallery-categories.datatable') }}',
                order: [[3, "asc"]],
                serialNumberColumn: 1,
                select: {
                    style: 'multi',
                    selector: 'td:first-child'
                },
                columns: [
                    {
                        title: "",
                        data: null,
                        defaultContent: '',
                        orderable: false,
                        searchable: false,
                        // className: 1 ? 'select-checkbox' : '', 'targets': 1,
                        render: function (data, type, row, meta) {
                            return '<input type="checkbox" ' + ((row.featured === 1) ? 'checked' : '') + ' id='+ row.id + ' class="feature-checkbox" />';
                        }
                    },
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
                        name: "gallery_categories.title_en",
                    },
                    {
                        title: "Title (Bn)",
                        data: "title_bn",
                        name: "gallery_categories.title_bn",
                    },
                    {
                        title: "Institute Name",
                        data: "institute_title_en",
                        name: "title_en",
                        visible: {{ \App\Helpers\Classes\AuthHelper::getAuthUser()->isSuperUser() ? "true" : "false" }},
                    },
                    {
                        title: "Featured",
                        data: "featured",
                        name: "gallery_categories.featured",
                        render: function (data, type, row, meta) {
                            if (row.featured === 1) {
                                return "<span class='badge badge-success'>Yes</span>";
                            }else {
                                return "<span class='badge badge-danger'>No</span>";
                            }
                        }
                    },

                    {
                        title: "Action",
                        data: "action",
                        name: "action",
                        orderable: false,
                        searchable: false,
                        visible: true
                    },
                ],
            });
            const datatable = $('#dataTable').DataTable(params);
            bindDatatableSearchOnPresEnterOnly(datatable);

            $(document, 'td').on('click', '.delete', function (e) {
                $('#delete_form')[0].action = $(this).data('action');
                $('#delete_modal').modal('show');
            });

            const maxFeaturedGallery = 4;

            function checkMaxFeaturedGallery() {
                let nFeaturedGalleries = $('input[type="checkbox"]:checked').length;
                console.table('checked', nFeaturedGalleries);
                return nFeaturedGalleries <= maxFeaturedGallery;
            }

            function showToasterAlert(response) {
                let alertType = response.alertType;
                let alertMessage = response.message;
                let alerter = toastr[alertType];
                alerter ? alerter(alertMessage) : toastr.error("toastr alert-type " + alertType + " is unknown");
            }

            $(document).ready(function () {
                $(document).on('click', '.feature-checkbox', function (e) {
                    if (!checkMaxFeaturedGallery() && $(this).is(':checked')) {
                        e.preventDefault();
                        showToasterAlert({
                            alertType: "error",
                            message: "Max " + maxFeaturedGallery + " features are supported!",
                        });
                        return false;
                    }
                })
            })


            $(document).on('click', '#update-featured-gallery', function (event) {

                // Stop form from submitting normally
                event.preventDefault();

                // Get some values from elements on the page:
                const $form = $(this),
                    url = "{!! route('course_management::admin.gallery-album.change-featured')!!}";

                const checkedAlbums = $('input[type=checkbox]:checked').map(function (_, el) {
                    return $(el).attr('id');
                }).get();

                let posting = $.post(url, {data: checkedAlbums});

                posting.done(function (data) {
                    //show success alert
                    showToasterAlert(data);
                    datatable.draw();
                });
            });
        })

    </script>
@endpush
