@extends('master::layouts.master')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between custom-bg-gradient-info">
                        <h3 class="card-title font-weight-bold text-primary"><b>{{$batch->title_en}}</b> - Youth List
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
                        <form class="row edit-add-form" method="post"
                              action="">
                            @csrf
                            <div class="col-md-6 py-2 mb-2">
                                <div class="form-group">
                                    <label for="import_youth" class="form-label">Import youths</label>
                                    <input class="form-control form-control-lg" id="import_youth" type="file" name="import_youth" />
                                </div>
                            </div>

                            <div class="col-md-2 py-2 mb-2">
                                <div class="form-group row">
                                    <label for="import_youth" class="form-label">&nbsp;</label>
                                    <button class="form-control form-control-lg bg-blue" id="import_youth" name="import_youth">Import Now</button>
                                </div>
                            </div>

                        </form>
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
                        title: "Youth Reg. No",
                        data: "youth_registration_no",
                        name: "youths.youth_registration_no",
                    },
                    {
                        title: "Youth Name",
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
            const datatable = $('#dataTable').DataTable(params);
            bindDatatableSearchOnPresEnterOnly(datatable);
        });
    </script>
@endpush
