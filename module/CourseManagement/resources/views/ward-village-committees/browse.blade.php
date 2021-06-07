@extends('voyager::master')
@php
    $title = __($localPrefix . 'village_committee_list');
@endphp

@section('page_title', $title)

@section('page_header')
    <h1 class="page-title">
        <i class="fa fa-list"></i>
        {{ $title }}
    </h1>
    @can('add', \Module\TeamManagement\Models\WardVillageCommittee::class)
    <a href="{{ route('ward-village-committees.create') }}" class="btn btn-success">
        <span class="fa fa-plus"></span>
        {{ __('Create') }}
    </a>
    @endcan

@stop

@section('content')
    <div class="page-content container-fluid">
        <div class="row justify-content-center">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <table id="dataTable" class="table table-striped table-sm table-hover">
                            <thead>
                            <tr>
                                <th>{{ __($localPrefix .'committee_name') }}</th>
                                <th>{{ __($localPrefix .'num_of_member') }}</th>
                                <th>{{ __('voyager::generic.created_at') }}</th>
                                <th>{{ __('voyager::generic.status') }}</th>
                                <th>{{ __('voyager::generic.actions') }}</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="modal modal-danger fade" tabindex="-1" id="delete_modal" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">
                        <i class="voyager-trash"></i> {{ __('voyager::generic.delete_question') }}?
                    </h4>

                    <button type="button" class="close" data-dismiss="modal"
                            aria-label="{{ __('voyager::generic.close') }}">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="delete_model_body"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-right"
                            data-dismiss="modal">{{ __('voyager::generic.cancel') }}</button>
                    <form action="#" id="delete_form" method="POST">
                        {{ method_field("DELETE") }}
                        {{ csrf_field() }}
                        <input type="submit" class="btn btn-danger pull-right delete-confirm"
                               value="{{ __('voyager::generic.delete_this_confirm') }}">
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal modal-success fade" tabindex="-1" id="approve_modal" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">
                        <i class="fa fa-check"></i> {{ __('Are you sure approve this') }}?
                    </h4>
                    <button type="button" class="close" data-dismiss="modal"
                            aria-label="{{ __('voyager::generic.close') }}">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="approve_model_body"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-right"
                            data-dismiss="modal">{{ __('voyager::generic.cancel') }}</button>
                    <form action="#" id="approve_form" method="POST">
                        {{ method_field("PUT") }}
                        {{ csrf_field() }}
                        <input type="submit" name="confirm" value="approve" class="btn btn-success pull-right mr-2 approve-confirm">
                        <input type="submit" name="confirm" value="reject" class="btn btn-danger pull-right mr-2 reject-confirm">
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('css')
    <link rel="stylesheet" href="{{asset('backend_resources/js/datatable/datatables.min.css')}}">
@endsection
@section('datatable_script')
    <script src="{{asset('backend_resources/js/datatable/datatables.min.js')}}"></script>
@endsection
@section('javascript')
    <script>
        $(document).ready(function () {
            let dataTableParams = {!! json_encode(
                    array_merge([
                        "language" => __('voyager::datatable'),
                        "processing" => true,
                        "serverSide" => true,
                        "ordering" => true,
                        "searching" => true,
                        "stateSave"=> false,
                        "ajax" => [
                            "method" => "POST",
                            "url" => route("ward-village-committees.datatable"),
                        ],
                        "columns" => [
                            [ "data" => 'committee_name'],
                            [ "data" => 'num_of_member', "name" => 'ward_village_committees.num_of_member'],
                            [ "data" => 'created_at', "name" => 'ward_village_committees.created_at'],
                            [ "data" => 'row_status', "name" => 'ward_village_committees.row_status'],
                            [ "data" => 'action', 'orderable' => false, 'searchable' => false]
                        ],
                    ],
                    config('voyager.dashboard.data_tables', []))
                , true) !!};

            dataTableParams.buttons = [
                {
                    extend: 'colvis',
                    text : '<i class="fa fa-eye"></i>',
                    className: 'btn btn-sm btn-primary',
                    titleAttr: '{{__('Column visibility')}}',
                    attr: {
                        id: 'asm-column-visibility-btn'
                    },
                    init: function(dt, node, config){
                        $(node).removeClass('btn-secondary');
                    }
                }
            ];

            let table = $('#dataTable').DataTable(dataTableParams);

        });

        $(document).on('focus', '.dataTables_filter input', function() {
            $(this).unbind().bind('keyup', function(e) {
                if(e.keyCode === 13) {
                    table.search( this.value ).draw();
                }
            });
        });
        $(document, 'td').on('click', '.delete', function (e) {
            $('#delete_form')[0].action = $(this).data('action');
            $('#delete_modal').modal('show');
        });

        $(document, 'td').on('click', '.confirm', function (e) {
            $('#approve_form')[0].action = $(this).data('action');
            $('#approve_modal').modal('show');
        });
    </script>
@endsection

