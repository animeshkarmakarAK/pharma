@extends('voyager::master')

@section('page_title', __('জরিপ') )

@section('page_header')
    <div class="container-fluid">
        <h1 class="page-title">
            <i class="voyager-bookmark"></i> {{ __('জরিপ') }}
        </h1>

    </div>
@stop

@section('content')
    <div class="page-content browse container-fluid">
        @include('voyager::alerts')
        <div class="panel panel-bordered">
            <div class="panel-heading">
                <a href="{{ route('survey.create') }}" class="btn btn-primary btn-sm btn-add-new">
                    <i class="fa fa-plus"></i> <span>{{ __('voyager::generic.add_new') }}</span>
                </a>
            </div>
            <div class="panel-body">
                <div class="table-responsive" style="min-height: 500px;">
                    <table id="dataTable" class="table table-striped">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>{{__($localPrefix . 'member_name')}}</th>
                            <th>{{__($localPrefix . 'father_spouse')}}</th>
                            <th>{{__($localPrefix . 'gender')}}</th>
                            <th>{{__($localPrefix . 'age')}}</th>
                            <th>{{__($localPrefix . 'educational_qualification')}}</th>
                            <th>{{__($localPrefix . 'occupation')}}</th>
                            <th>{{__($localPrefix . 'annual_income_total')}}</th>
                            <th>{{__($localPrefix . 'economic_category')}}</th>
                            <th>{{__('voyager::generic.created_at')}}</th>
                            <th>{{__('voyager::generic.actions')}}</th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="modal modal-danger fade" tabindex="-1" id="delete_modal" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"
                            aria-label="{{ __('voyager::generic.close') }}">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title">
                        <i class="voyager-trash"></i> {{ __('voyager::generic.delete_question') }}?
                    </h4>
                </div>
                <div class="modal-body" id="delete_model_body"></div>
                <div class="modal-footer">
                    <form action="#" id="delete_form" method="POST">
                        {{ method_field("DELETE") }}
                        {{ csrf_field() }}
                        <input type="submit" class="btn btn-danger pull-right delete-confirm"
                               value="{{ __('voyager::generic.delete_this_confirm') }}">
                    </form>
                    <button type="button" class="btn btn-default pull-right"
                            data-dismiss="modal">{{ __('voyager::generic.cancel') }}</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('css')
    <link rel="stylesheet" href="{{asset('backend_resources/js/datatable/datatables.min.css')}}">
    <style>
        #dataTable_length {
            display: inline-block;
            margin-right: 1rem;
        }

        .dt-bootstrap4 .dataTables_length select {
            position: relative;
            top: 4px;
            left: 10px;
            margin-right: 10px;
        }
    </style>
@endsection
@section('datatable_script')
    <script src="{{asset('backend_resources/js/datatable/datatables.min.js')}}"></script>
@endsection
@section('javascript')
    <script>
        let genderOptions = {!! json_encode(\Module\TeamManagement\Models\FamilyMemberSurvey::getGenderOptions()) !!};

        $(document).ready(function () {
            var dataTableParams = {!! json_encode(
                    array_merge( config('voyager.dashboard.data_tables', []), [
                        "language" => __('voyager::datatable'),
                        "processing" => true,
                        "serverSide" => true,
                        "ordering" => true,
                        "searching" => true,
                        "stateSave"=> false,
                        "responsive" => true,
                        'order' => [[9, 'dsc'], [8, 'asc']],
                        'ajax' => [
                            'method' => 'POST',
                            'url' => route('survey.datatable'),
                        ],
                        'columns' => [
                            [ 'data' => null, 'name'=> null, 'defaultContent' => '', 'orderable' => false, 'searchable' => false],
                            [ 'data' => 'family_head_name', "name" => 'surveys.family_head_name'],
                            [ 'data' => 'father_spouse', "name" => 'surveys.father_spouse', 'visible' => false],
                            [ 'data' => 'gender', "name" => 'family_member_surveys.gender', 'visible' => false],
                            [ 'data' => 'age', 'type' => 'num', "name" => 'family_member_surveys.age', 'visible' => false],
                            [ 'data' => 'educational_qualification', "name" => 'family_member_surveys.educational_qualification', 'visible' => false],
                            [ 'data' => 'occupation', "name" => 'occupation', 'visible' => false],
                            [ 'data' => 'annual_income_total', 'type' => 'num', "name" => 'surveys.annual_income_total'],
                            [ 'data' => 'economic_category', 'name' => 'survey_categories.title'],
                            [ 'data' => 'created_at', 'name' => 'surveys.created_at', 'visible' => false],
                            [ 'data' => 'action', 'orderable' => false, 'searchable' => false]
                        ],
                        "dom" => "<'row'<'col-sm-12 col-md-6 mb-0'Bl><'col-sm-12 col-md-6 mb-0'f>>" .
                                "<'row'<'col-sm-12 mb-0'tr>>" .
                                "<'row'<'col-sm-12 col-md-5 mb-0'i><'col-sm-12 col-md-7 mb-0'p>>",
                    ] )
                , true) !!};

            dataTableParams.rowCallback = function (nRow, aData, iDisplayIndex) {
                const oSettings = this.fnSettings();

                $("td:first", nRow).text(window.en2bnNumber((oSettings._iDisplayStart + iDisplayIndex + 1).toString()));

                return nRow;
            };
            dataTableParams.columnDefs = [
                {
                    targets: 3,
                    render: function (data, type, row) {
                        if (type === 'display' && typeof genderOptions[data] !== 'undefined') {
                            return genderOptions[data];
                        }
                        return data;
                    }
                },
                {
                    targets: [4, 7],
                    render: function (data, type, row) {
                        if (type === 'display') {
                            return en2bnNumber(data);
                        }
                        return data;
                    }
                }
            ];
            dataTableParams.buttons = [
                {
                    extend: 'colvis',
                    text: '<i class="fa fa-eye"></i>',
                    className: 'btn btn-sm btn-primary mr-2',
                    titleAttr: '{{__('Column visibility')}}',
                    attr: {
                        id: 'asm-column-visibility-btn'
                    },
                    init: function (dt, node, config) {
                        $(node).removeClass('btn-secondary');
                    }
                },
                {
                    extend: 'print',
                    text: '<i class="fa fa-print"></i>',
                    className: 'btn btn-sm btn-primary',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6, 7]
                    },
                    titleAttr: '{{__('Print')}}',
                    messageTop: '<div style="font-size: 20px;margin-bottom:10px; text-align:center"><p>সমাজসেবা অধিদফতর</p><p>{{__('জরিপ')}}</p></div>',
                    customize: function (win) {
                        $(win.document.body)
                            .css('font-size', '10pt');

                        $(win.document.body).find('table')
                            .addClass('compact')
                            .css('font-size', 'inherit');
                    },
                    init: function (dt, node, config) {
                        $(node).removeClass('btn-secondary');
                    }
                },

            ];

            let table = $('#dataTable').DataTable(dataTableParams);
            $('.dt-bootstrap4 .dataTables_length select').removeClass('custom-select').removeClass('custom-select-sm').addClass('form-control');

            $(document).on('focus', '.dataTables_filter input', function () {
                $(this).unbind().bind('keyup', function (e) {
                    if (e.keyCode === 13) {
                        table.search(this.value).draw();
                    }
                });
            });

            $(document, 'td').on('click', '.delete', function (e) {
                $('#delete_form')[0].action = $(this).data('action');
                $('#delete_modal').modal('show');
            });
        });
    </script>
@endsection
