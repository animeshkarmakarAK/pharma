@php
    /** @var \App\Models\User $authUser */
    $authUser = \App\Helpers\Classes\AuthHelper::getAuthUser();
@endphp
@extends('master::layouts.master')

@section('title')
    {{ __('Youth List') }}
@endsection

@push('css')
    <style>
        .select2 {
            border-right: transparent !important;
        }

        .select2 .select2-selection {
            background: linear-gradient(180deg, #fafdff 0%, #ddf1ff 35%);
        }

        .select2 .select2-selection__arrow {
            background-image: -moz-linear-gradient(top, #1B67A8, #1B67A8);
            background-image: -ms-linear-gradient(top, #1B67A8, #1B67A8);
            background-image: -webkit-gradient(linear, left top, left bottom, color-stop(0%, #1B67A8), color-stop(100%, #1B67A8));
            background-image: -webkit-linear-gradient(top, #1B67A8, #1B67A8);
            background-image: -o-linear-gradient(top, #1B67A8, #1B67A8);
            background-image: linear-gradient(#1B67A8, #1B67A8);
            width: 40px;
            font-size: 1.3em;
            margin-top: -19px;
            padding: 19px;
            border-radius: 0 10px 10px 0;
            margin-right: -6px;
        }

        .select2 .select2-selection__placeholder {
            color: steelblue !important;
            font-weight: bolder;
        }

        .select2-selection__clear {
            margin-right: 34px !important;
        }

        .select2-container--bootstrap4 .select2-selection--single .select2-selection__arrow b {
            border-color: #fff transparent transparent;
            border-style: solid;
            border-width: 5px 4px 0;
        }

        #select_all_rows {
            display: block;
            margin: 0 auto;
        }

        /*
        @media screen and (min-width: 645px) {
            #add-to-batch-area{
                position: absolute;
                left: 75px;
                top: 0;
            }
        }*/
    </style>
@endpush

@push('js')
    <script>
        $('b[role="presentation"]').hide();
        $('.select2-selection__arrow').append('<i class="fa fa-times" style="color: #000000; font-size: 10px"></i>');
    </script>
@endpush

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between custom-bg-gradient-info">
                        <h3 class="card-title font-weight-bold text-primary">Youth List</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <button id="add-to-batch-area" style="visibility: hidden; display: none" type="button"
                                        class="mb-3 btn btn-sm btn-rounded btn-primary float-right"
                                        data-toggle="modal" data-target="#addToOrganizationModal">
                                    <i class="fas fa-plus-circle d-inline-block"></i> Add to Organization
                                </button>
                            </div>

                            <div class="col-md-12">
                                <div class="datatable-container">
                                    <table id="dataTable" class="table table-bordered table-striped dataTable">
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="addToOrganizationModal" tabindex="-1" role="dialog"
         aria-labelledby="addToOrganizationModalTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                @if($organizations->count())
                    <form id="add-to-organization-form" method="post"
                          action="{{route('course_management::admin.youths.add-to-organization')}}">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLongTitle">Select Organization</h5>
                            <button type="button" class="close" data-dismiss="modal"
                                    aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="assign_organization_id">Select Organization <span
                                        style="color: red"> * </span></label>
                                <select name="organization_id" id="assign_organization_id" class="select2"
                                        data-placeholder="{{ __('generic.select_placeholder') }}"
                                >
                                    <option selected disabled>{{ __('generic.select_placeholder') }}</option>
                                    @foreach($organizations as $organization)
                                        <option value="{{$organization->id}}">{{$organization->title_en}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">
                                Close
                            </button>
                            <button type="submit" class="btn btn-primary ">Add</button>
                        </div>
                    </form>
                @else
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Create Organization</h5>
                        <button type="button" class="close" data-dismiss="modal"
                                aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        @can('create', \Module\GovtStakeholder\App\Models\Organization::class)
                            <div class="d-block mt-5 mb-5 text-center">
                                <a href="{{route('course_management::admin.batches.create')}}"
                                   class="btn btn-sm btn-success">
                                    <i class="fa fa-plus-circle"></i> Create New Organization
                                </a>
                            </div>
                        @else
                            <div class="alert alert-danger" role="alert">
                                <div class="d-block text-center mt-3 mb-3">
                                    <i class="fa fa-info-circle fa-3x"></i>
                                </div>
                                You don't have any <strong>Organization</strong> to assign. Please contact support to
                                add
                                Organization.
                            </div>
                        @endcan
                    </div>
                @endif
            </div>
        </div>
    </div>


    <div class="modal modal-danger fade" id="already-assigned-modal" tabindex="-1" role="dialog"
         data-backdrop="static">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header custom-bg-gradient-info">
                    <h4 class="modal-title">
                        <i class="fas fa-address-card"></i> {{ __('Youth assigned to Organization') }}
                    </h4>
                    <button type="button" class="close" data-dismiss="modal"
                            aria-label="{{ __('voyager::generic.close') }}">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body pb-5">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-right"
                            data-dismiss="modal">{{ __('Cancel') }}</button>
                    <form action="#" id="already-assigned-form" method="POST">
                        {{ method_field("PUT") }}
                        {{ csrf_field() }}
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal End-->
@endsection
@push('css')
    <link rel="stylesheet" href="{{asset('/css/datatable-bundle.css')}}">
@endpush

@push('js')
    <script type="text/javascript" src="{{asset('/js/datatable-bundle.js')}}"></script>
    <script>
        $(document).ready(function () {

            if (!($('#institute_id').attr('type') == "hidden")) {
                $('#programme_id').parent().addClass(' mt-2 offset-md-1');
            } else {
                $('#course_id').parent().addClass(' offset-md-1');
            }
            let params = serverSideDatatableFactory({
                url: '{{ route('course_management::admin.youths.datatable') }}',
                order: [[4, "DESC"]],
                serialNumberColumn: 1,
                select: {
                    style: 'multi',
                    selector: 'td:first-child',
                },
                columnDefs: [
                    {
                        "targets": 0,
                        "orderable": false,
                        "createdCell": function (td, cellData, rowData, row, col) {

                            if (1) {
                                $(td).addClass('select-checkbox enable-checkbox').prop('checked', true);
                            } else {
                                $(td).removeClass('select-checkbox enable-checkbox').prop('checked', false);
                            }
                        }
                    }
                ],
                columns: [
                    {
                        title: "<input type='checkbox' id='select_all_rows' />",
                        data: null,
                        defaultContent: '',
                        orderable: false,
                        searchable: false,
                        targets: 0
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
                        title: "Name (En)",
                        data: "name_en",
                        name: "youths.name_en"
                    },
                    {
                        title: "Name (Bn)",
                        data: "name_bn",
                        name: "youths.name_bn"
                    },
                    {
                        title: "Reg. No.",
                        data: "youth_registration_no",
                        name: "youths.youth_registration_no"
                    },
                    {
                        title: "Access_key",
                        data: "access_key",
                        name: "youths.access_key"
                    },
                    {
                        title: "Institute",
                        data: "institute_title_en",
                        name: "institute_title_en",
                        visible: false
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

            params.ajax.data = d => {
                d.institute_id = $('#institute_id').val();
                d.branch_id = $('#branch_id').val();
                d.training_center_id = $('#training_center_id').val();
                d.programme_id = $('#programme_id').val();
                d.course_id = $('#course_id').val();
                d.application_date = $('#date-filter').val();
            };

            let datatable = $('#dataTable').DataTable(params);

            /*$(document, 'td').on('click', '.already-assigned-btn', function (e) {
                let youthId = $(this).attr('id');
                console.log(youthId);
                $('#already-assigned-form')[0].action = $(this).data('action');
                $('#already-assigned-modal').modal('show');
                $.ajax({
                    url: "{{route('course_management::admin.youths.youth-assigned-organization')}}",
                    method: "POST",
                    data: {
                        id: youthId
                    },
                    success: function (res) {
                        console.log(res)
                        $('.organization-badge').remove();

                        if(res.length==0){
                            $('.modal-body').append(
                                '<span class="badge badge-warning m-1 organization-badge">'+'Not assigned to any Organization'+'</span>'
                            );
                        }

                        $.each(res, function (key, value) {
                            console.log(res[key].title_en)
                            $('.modal-body').append(
                                '<span class="badge badge-success m-1 organization-badge">'+res[key].title_en+'</span>'
                            );
                        });



                    }
                })

            });*/

            $("#select_all_rows").click(function () {
                let selectAll = $(this);

                if ($(this).is(":checked")) {
                    datatable.rows(':has(.select-checkbox)').select();
                } else {
                    datatable.rows().deselect();
                }


            });

            $(document).on('change', '.select2-ajax-wizard', function () {
                datatable.draw();
            });
            $(document).on('change', '.flat-date', function () {
                datatable.draw();
            });

            $('#reset-btn').on('click', function () {
                $('#institute_id').val(null).trigger('change');
                $('#programme_id').val(null).trigger('change');
                $('#training_center_id').val(null).trigger('change');
                $('#course_id').val(null).trigger('change');
                $('#branch_id').val(null).trigger('change');
                $('.flat-date').val(null).change();
            })

            datatable.on('select deselect', function (e, dt, type, indexes) {
                if (type === 'row') {
                    let selectedRows = datatable.rows({selected: true}).count();
                    if (selectedRows) {
                        $('#add-to-batch-area').css({visibility: 'visible', display: 'inline-block'});
                    } else {
                        $('#add-to-batch-area').css({visibility: 'hidden', display: 'none'});
                    }

                    let totalRows = datatable.rows().count();
                    $("#select_all_rows").prop('checked', totalRows === selectedRows)

                }
            });
            bindDatatableSearchOnPresEnterOnly(datatable);

            $(document, 'td').on('click', '.delete', function (e) {
                $('#delete_form')[0].action = $(this).data('action');
                $('#delete_modal').modal('show');
            });


            $("#add-to-batch-area").click(function () {
                addToOrganizationForm.find('.youth_ids').remove();
                let selectedRows = Array.from(datatable.rows({selected: true}).data());
                (selectedRows || []).forEach(function (row) {
                    console.log(row)
                    addToOrganizationForm.append('<input name="youth_ids[]" class="youth_ids" value="' + row.id + '" type="hidden"/>');
                });
            });


            let addToOrganizationForm = $("#add-to-organization-form");
            addToOrganizationForm.validate({
                rules: {
                    organization_id: {
                        required: true,
                    }
                },
                messages: {
                    organization_id: {
                        required: "Please select Organization",
                    }
                },
                submitHandler: function (htmlForm) {
                    htmlForm.submit();
                }
            });

        });

    </script>
@endpush
