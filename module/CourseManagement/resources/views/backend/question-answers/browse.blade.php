@php

    $authUser = \App\Helpers\Classes\AuthHelper::getAuthUser();


@endphp

@extends('master::layouts.master')

@section('title')
    {{ __('FAQ') }}
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header text-primary custom-bg-gradient-info">
                        <h3 class="card-title font-weight-bold">FAQ List</h3>
                        <div class="card-tools">
                            <a href="{{route('course_management::admin.question-answers.create')}}"
                               class="btn btn-sm btn-outline-primary btn-rounded">
                                <i class="fas fa-plus-circle"></i> {{__('course_management::admin.common.add')}}
                            </a>
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
                url: '{{ route('course_management::admin.question-answers.datatable') }}',
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
                        title: "Question",
                        data: "question",
                        name: "question_answers.question",
                    },
                    {
                        title: "Answer",
                        data: "answer",
                        name: "question_answers.answer",
                        visible: false,
                    },
                    {
                        title: "Institute Name",
                        data: "institute_name",
                        name: "institutes.title_en",
                        visible: false,
                    },
                    {
                        title: "Active Status",
                        data: "row_status",
                        name: "question_answers.row_status",
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
