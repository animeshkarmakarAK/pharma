@extends('voyager::master')
@php
    $title = __($localPrefix . 'village_team');
@endphp

@section('page_title', $title)

@section('page_header')
    <h1 class="page-title">
        <i class="fa fa-users"></i>
        {{ $title }}
    </h1>
@endsection

@section('content')
    <div class="page-content container-fluid">
        <div class="panel panel-bordered">
            <div class="panel-heading">
                <h4 class="panel-title">{{__($localPrefix . 'village_team_list')}}</h4>
                @can('add', \Module\TeamManagement\Models\WardVillageTeam::class)
                    <a href="{{ route('teams.create') }}" class="btn btn-primary btn-sm">
                        <span class="fa fa-plus"></span>
                        {{ __('voyager::generic.add_new') }}
                    </a>
                @endcan
            </div>
            <div class="panel-body">
                <div class="table-responsive" style="min-height: 500px;">
                    <table id="dataTable" class="table table-striped table-sm">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>{{ __($localPrefix .'loc_village_ward_ashrayan_matrikendro_id') }}</th>
                            <th>{{ __($localPrefix .'team_code') }}</th>
                            <th>{{ __($localPrefix .'team_name') }}</th>
                            <th>{{ __($localPrefix .'member_count') }}</th>
                            <th>{{ __($localPrefix .'activate_date') }}</th>
                            <th>{{ __('voyager::generic.actions') }}</th>
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
            var dataTableParams = {!! json_encode(
                    array_merge([
                        'language' => __('voyager::datatable'),
                        'processing' => true,
                        'serverSide' => true,
                        'ordering' => true,
                        'searching' => true,
                        'stateSave'=> false,
                        'order' => [1, 'asc'],
                        'ajax' => [
                            'method' => 'POST',
                            'url' => route('teams.datatable'),
                        ],
                        'columns' => [
                            [ 'data' => null, 'defaultContent' => '', 'orderable' => false, 'searchable' => false],
                            [ 'data' => 'loc_village_ward_ashrayan_matrikendros_title', "name" => 'loc_village_ward_ashrayan_matrikendros.title'],
                            [ 'data' => 'team_code', "name" => 'ward_village_teams.team_code'],
                            [ 'data' => 'team_name', "name" => 'ward_village_teams.team_name'],
                            [ 'data' => 'num_of_team_member', "name" => 'ward_village_teams.num_of_team_member'],
                            [ 'data' => 'activate_date', "name" => 'ward_village_teams.activate_date', 'visible' => false],
                            [ 'data' => 'action', 'orderable' => false, 'searchable' => false]
                        ],
                    ],
                    config('voyager.dashboard.data_tables', []))
                , true) !!};

            dataTableParams.buttons = [
                {
                    extend: 'colvis',
                    text: '<i class="fa fa-eye"></i>',
                    className: 'btn btn-sm btn-primary',
                    titleAttr: '{{__('Column visibility')}}',
                    attr: {
                        id: 'asm-column-visibility-btn'
                    },
                    init: function (dt, node, config) {
                        $(node).removeClass('btn-secondary');
                    }
                }
            ];

            dataTableParams.rowCallback = function (nRow, aData, iDisplayIndex) {
                const oSettings = this.fnSettings();

                $("td:first", nRow).text(window.en2bnNumber((oSettings._iDisplayStart + iDisplayIndex + 1).toString()));

                return nRow;
            };

            let table = $('#dataTable').DataTable(dataTableParams);


        });
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
    </script>
@endsection

