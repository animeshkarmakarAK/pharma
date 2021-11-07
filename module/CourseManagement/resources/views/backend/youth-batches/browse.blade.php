@extends('master::layouts.master')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between custom-bg-gradient-info">
                        <h3 class="card-title font-weight-bold text-primary"><b>{{$batch->title_en}}</b> - Trainee List
                        </h3>
                        <div class="card-tools">
                            <a href="{{route('course_management::admin.batches.index')}}"
                               class="btn btn-sm btn-rounded btn-outline-primary">
                                <i class="fas fa-backward"></i> Back to batch list
                            </a>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        @if($batch->batch_status == \Module\CourseManagement\App\Models\Batch::BATCH_STATUS_COMPLETE)
                            <form class="row bulk-import-youth" id="import-youth-form" method="post"
                                  enctype="multipart/form-data">
                                @csrf
                                <div class="col-md-6 py-2 mb-2">
                                    <div class="form-group">
                                        <label for="import_youth_file" class="form-label">Import Trainee</label>
                                        <input class="form-control form-control-lg" id="import_youth" type="file"
                                               name="import_youth_file"/>
                                    </div>
                                </div>
                                <div class="col-md-3 py-2 mb-2">
                                    <div class="form-group row">
                                        <label for="import_youth" class="form-label">&nbsp;</label>
                                        <button class="form-control form-control-lg bg-blue" id="import_youth_btn">
                                            Import Now
                                        </button>
                                    </div>
                                </div>
                                <div class="col-md-3 py-2 mb-2 text-center">
                                    <div class="form-group row">
                                        <label for="Download_demo" class="form-label">&nbsp;</label>
                                        <a href="{{asset('/assets/demoExcelFormat/demo.csv')}} "
                                           class="form-control form-control-lg bg-info"> Download Demo</a>
                                    </div>
                                </div>

                            </form>

                            <div class="col-md-6 py-2 mb-2" id="validation-error-div" style="display: none">
                                <p>Validation Error:</p>
                                <ul id="validation-error-list"></ul>
                            </div>
                        @endif


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
        let datatable = null;
        $(function () {
            let params = serverSideDatatableFactory({
                url: '{{ route('course_management::admin.batches.youths.datatable', $batch->id) }}',
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
                        title: "Trainee Reg. No",
                        data: "youth_registration_no",
                        name: "youths.youth_registration_no",
                    },
                    {
                        title: "Trainee Name",
                        data: "youth_name_en",
                        name: "youths.name_en"
                    },
                    {
                        title: "Enrollment Date",
                        data: "enrollment_date",
                        name: "youth_batches.enrollment_date",
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
            datatable = $('#dataTable').DataTable(params);
            bindDatatableSearchOnPresEnterOnly(datatable);

        });

        const importYouthForm = $('#import-youth-form');
        importYouthForm.validate({
            rules: {
                import_youth_file: {
                    required: true,
                    extension: "xlsx|xls|xlsm|csv"
                }
            },
            messages: {
                import_youth_file: {
                    required: "File is required",
                    extension: "File extension will be xlsx|xls|xlsm|csv"
                }
            }
        });
        $(document).ready(function () {
            $("#import-youth-form").on("submit", function (event) {
                event.preventDefault();
                let formData = new FormData($(this)[0]);
                $.ajax({
                    url: "{{route('course_management::admin.batches.youths-import',$batch->id)}}",
                    type: "POST",
                    data: formData,
                    async: false,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function (res) {
                        if (res.code === 422) {
                            let li = "";
                            $.each(res.errors, function (i, error) {
                                li += "<li class='text-danger'>" + error + "</li>";
                            });
                            $("#validation-error-list").html(li);
                            $("#validation-error-div").css("display", "block");
                        } else if (res.code === 200) {
                            window.location.reload();
                        }
                    }

                })
            })
        })
    </script>
@endpush
