@extends('master::layouts.master')

@section('title')
    {{ __('Gallery Album List') }}
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header text-primary custom-bg-gradient-info">
                        <h3 class="card-title font-weight-bold">Album List</h3>
                        <div class="card-tools">
                            @can('create', \Module\CourseManagement\App\Models\GalleryCategory::class)
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
                serialNumberColumn: 0,
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
                        name: "gallery_categories.title_en",
                    },
                    {
                        title: "Institute Name",
                        data: "institute_title_en",
                        name: "institutes.title_en",
                        visible: {{ \App\Helpers\Classes\AuthHelper::getAuthUser()->isSuperUser() ? "true" : "false" }},
                    },
                    {
                        title: "Programme Name",
                        data: "programme_title_en",
                        name: "programmes.title_en",
                        visible: false,
                    },
                    {
                        title: "Batch Name",
                        data: "batch_title_en",
                        name: "batches.title_en",
                        visible: false,
                    },
                    {
                        title: "Featured",
                        data: "featured",
                        name: "gallery_categories.featured",
                        render: function (data, type, row, meta) {
                            let checked = row.featured === 1 ? "checked" : "";
                            let yesNo = row.featured === 1 ? "Yes" : "No";
                            let html = '<div class="form-group">';
                            html += '<div class="custom-control custom-switch custom-switch custom-switch-off-danger custom-switch-on-success">';
                            html += '<input type="checkbox" class="custom-control-input feature-toggle" id="'+row.id+'"' + checked + '>';
                            html += '<label class="custom-control-label" for="'+row.id+'">' + yesNo +'</label>';
                            html += '</div></div>';
                            return html;
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
                return nFeaturedGalleries <= maxFeaturedGallery;
            }

            function showToasterAlert(response) {
                let alertType = response.alertType;
                let alertMessage = response.message;
                let alerter = toastr[alertType];
                alerter ? alerter(alertMessage) : toastr.error("toastr alert-type " + alertType + " is unknown");
            }

            $(document).ready(function () {
                $(document).on('click', '.feature-toggle', function (e) {
                    let id = $(this).attr('id');
                    let data = {
                        id: id,
                        maxFeaturedGallery: maxFeaturedGallery,
                    };
                    if ($(this).is(':checked')) {
                        data.featured = true;
                    } else {
                        data.featured = false;
                    }

                    updateFeature(data);

                    // if (!checkMaxFeaturedGallery() && $(this).is(':checked')) {
                    //     e.preventDefault();
                    //     showToasterAlert({
                    //         alertType: "error",
                    //         message: "Max " + maxFeaturedGallery + " features are supported!",
                    //     });
                    //     return false;
                    // }
                })
            })


            function updateFeature(data) {
                const url = "{!! route('course_management::admin.gallery-album.change-featured')!!}";
                let posting = $.post(url, {data: data});
                posting.done(function (response) {
                    //show success alert
                    showToasterAlert(response);
                    datatable.draw();
                });
            }

            $(document).on('click', '#update-featured-gallery', function (event) {
                // Stop form from submitting normally
                event.preventDefault();

                // Get some values from elements on the page:
                const $form = $(this),
                    url = "{!! route('course_management::admin.gallery-album.change-featured')!!}";

                let checkedAlbums = [], uncheckedAlbums = [];
                $('input[type=checkbox]').each(function () {
                    if (this.checked) {
                        checkedAlbums.push($(this).attr('id'));
                    } else {
                        uncheckedAlbums.push($(this).attr('id'));
                    }
                });

                const data = {"featured": checkedAlbums, "dropped": uncheckedAlbums};
                let posting = $.post(url, {data: data});

                posting.done(function (data) {
                    //show success alert
                    showToasterAlert(data);
                    datatable.draw();
                });
            });
        })

    </script>
    <script>
        $(function() {
            $('#toggle-one').bootstrapToggle();
        })
    </script>
@endpush
