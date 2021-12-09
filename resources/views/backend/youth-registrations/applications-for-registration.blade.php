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
        #add-to-batch-form{
            z-index: 9999;
        }

        #add-to-batch-area{
            position: absolute;
            left: 100px;
            top: 0;
            z-index: 999;
        }
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
                        <h3 class="card-title font-weight-bold text-primary">Applications</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <button id="accept-now" style="visibility: hidden" type="submit"
                                        class="mb-3 btn btn-sm btn-rounded btn-success"
                                        data-toggle="modal" data-target="#accept-application-modal-all">
                                    <i class="fas fa-check-circle"></i> Accept Now
                                </button>
                                <button id="reject-now" style="visibility: hidden" type="button"
                                   class="mb-3 btn btn-sm btn-rounded btn-danger"
                                   data-toggle="modal" data-target="#reject-application-modal-all">
                                    <i class="fas fa-times-circle"></i> Reject
                                </button>
                            </div>
                            <div class="col-md-12">
                                <form action="#">
                                    <div class="col-md-12 mb-2">
                                        <div class="row">
                                            <div class="col-md-12 mb-2">
                                                <label class="filter-label text-primary">
                                                    <i class="fas fa-sort-amount-down-alt"></i>
                                                    Filter</label>
                                            </div>
                                            @if($authUser->isInstituteUser())
                                                <input type="hidden" id="institute_id" name="institute_id"
                                                       value="{{$authUser->institute_id}}">
                                            @else
                                                <div class="col-md-3 mb-2">
                                                    <select class="form-control select2-ajax-wizard"
                                                            name="institute_id"
                                                            id="institute_id"
                                                            data-model="{{base64_encode(App\Models\Institute::class)}}"
                                                            data-label-fields="{title_en}"
                                                            data-dependent-fields="#branch_id|#course_id"
                                                            data-placeholder="Institute"
                                                    >
                                                    </select>
                                                </div>
                                            @endif

                                            <div class="col-md-3 mb-2">
                                                <select class="form-control select2-ajax-wizard"
                                                        name="training_center_id"
                                                        id="training_center_id"
                                                        data-model="{{base64_encode(App\Models\TrainingCenter::class)}}"
                                                        data-label-fields="{title_en}"
                                                        data-depend-on-optional="institute_id"
                                                        data-placeholder="Training Center"
                                                >
                                                </select>
                                            </div>

                                            <div class="col-md-3 mb-2">
                                                <select class="form-control select2-ajax-wizard"
                                                        name="programme_id"
                                                        id="programme_id"
                                                        data-model="{{base64_encode(App\Models\Programme::class)}}"
                                                        data-label-fields="{title_en}"
                                                        data-depend-on-optional="institute_id"
                                                        data-placeholder="Programme"
                                                >
                                                </select>
                                            </div>

                                            <div class="col-md-3 mb-2">
                                                <select class="form-control select2-ajax-wizard"
                                                        name="course_id"
                                                        id="course_id"
                                                        data-model="{{base64_encode(App\Models\Course::class)}}"
                                                        data-label-fields="{title_en}"
                                                        data-depend-on-optional="institute_id"
                                                        data-placeholder="Course"
                                                >
                                                </select>
                                            </div>

                                            <div class="col-md-3 mb-2">
                                                <input class="flat-date date_filter" id="date-filter" name="start_date"
                                                       type="text" placeholder="Select Date">
                                            </div>
                                            <div class="col-md-1 mb-2">
                                                <button class="btn btn-primary" id="reset-btn">Reset</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
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
    <div class="modal fade" id="addToBatchModal" tabindex="-1" role="dialog"
         aria-labelledby="addToBatchModalTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                @if($batches->count())
                    <form id="add-to-batch-form" method="post"
                          action="{{route('admin.youth.add-to-batch')}}">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLongTitle">Select Batch</h5>
                            <button type="button" class="close" data-dismiss="modal"
                                    aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="assign_batch_id">Select Batch <span
                                        style="color: red"> * </span></label>
                                <select name="batch_id" id="assign_batch_id" class="select2"
                                        data-placeholder="{{ __('generic.select_placeholder') }}"
                                >
                                    <option selected disabled>{{ __('generic.select_placeholder') }}</option>
                                    @foreach($batches as $batch)
                                        <option value="{{$batch->id}}">{{$batch->title_en}}</option>
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
                        <h5 class="modal-title" id="exampleModalLongTitle">Create Batch</h5>
                        <button type="button" class="close" data-dismiss="modal"
                                aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        @can('create', \App\Models\Batch::class)
                            <div class="d-block mt-5 mb-5 text-center">
                                <a href="{{route('admin.batches.create')}}"
                                   class="btn btn-sm btn-success">
                                    <i class="fa fa-plus-circle"></i> Create New Batch
                                </a>
                            </div>
                        @else
                            <div class="alert alert-danger" role="alert">
                                <div class="d-block text-center mt-3 mb-3">
                                    <i class="fa fa-info-circle fa-3x"></i>
                                </div>
                                You don't have any <strong>Batch</strong> to assign. Please contact support to add
                                batch.
                            </div>
                        @endcan
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div class="modal modal-danger fade" tabindex="-1" id="accept-application-modal" role="dialog"
         data-backdrop="static">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header custom-bg-gradient-info">
                    <h4 class="modal-title">
                        <i class="fas fa-hand-paper"></i> {{ __('Do you want to accept it?') }}
                    </h4>
                    <button type="button" class="close" data-dismiss="modal"
                            aria-label="{{ __('voyager::generic.close') }}">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-right"
                            data-dismiss="modal">{{ __('Cancel') }}</button>
                    <form action="#" id="accept-application-form" method="POST">
                        {{ method_field("PUT") }}
                        {{ csrf_field() }}
                        <input type="submit" class="btn btn-danger pull-right delete-confirm"
                               value="{{ __('Confirm') }}">
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal modal-danger fade" tabindex="-1" id="reject-application-modal" role="dialog"
         data-backdrop="static">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header custom-bg-gradient-info">
                    <h4 class="modal-title">
                        <i class="fas fa-hand-paper"></i> {{ __('Do you want to reject it?') }}
                    </h4>
                    <button type="button" class="close" data-dismiss="modal"
                            aria-label="{{ __('voyager::generic.close') }}">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-right"
                            data-dismiss="modal">{{ __('Cancel') }}</button>
                    <form action="#" id="reject-application-form" method="POST">
                        {{ method_field("PUT") }}
                        {{ csrf_field() }}
                        <input type="submit" class="btn btn-danger pull-right delete-confirm"
                               value="{{ __('Confirm') }}">
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal End-->

    <div class="modal modal-danger fade" tabindex="-1" id="accept-application-modal-all" role="dialog"
         data-backdrop="static">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header custom-bg-gradient-info">
                    <h4 class="modal-title">
                        <i class="fas fa-hand-paper"></i> {{ __('Do you want to accept it?') }}
                    </h4>

                    <button type="button" class="close" data-dismiss="modal"
                            aria-label="{{ __('voyager::generic.close') }}">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-right"
                            data-dismiss="modal">{{ __('Cancel') }}</button>
                    <form action="{{route('admin.youth-accept-now-all')}} "id="accept-now-form" class="float-left" method="post">
                        {{ method_field("PUT") }}
                        {{ csrf_field() }}
                        <input type="submit" class="btn btn-danger pull-right delete-confirm"
                               value="{{ __('Confirm') }}">
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal modal-danger fade" tabindex="-1" id="reject-application-modal-all" role="dialog"
         data-backdrop="static">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header custom-bg-gradient-info">
                    <h4 class="modal-title">
                        <i class="fas fa-hand-paper"></i> {{ __('Do you want to reject it?') }}
                    </h4>
                    <button type="button" class="close" data-dismiss="modal"
                            aria-label="{{ __('voyager::generic.close') }}">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-right"
                            data-dismiss="modal">{{ __('Cancel') }}</button>
                    <form action="{{route('admin.youth-reject-now-all')}}" id="reject-now-form" method="POST">
                        {{ method_field("PUT") }}
                        {{ csrf_field() }}
                        <input type="submit" class="btn btn-danger pull-right delete-confirm"
                               value="{{ __('Confirm') }}">
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('css')
    <link rel="stylesheet" href="{{asset('/css/datatable-bundle.css')}}">
@endpush

@push('js')
    <script type="text/javascript" src="{{asset('/js/datatable-bundle.js')}}"></script>
    <script>
        $(document).ready(function () {

            if (($('#institute_id').attr('type') == "hidden")) {
                $('#programme_id').parent().removeClass('col-md-3').addClass('col-md-2');
                $('#course_id').parent().removeClass('col-md-3').addClass('col-md-2');
                $('.date_filter').parent().removeClass('col-md-3').addClass('col-md-2');
            }
            let params = serverSideDatatableFactory({
                url: '{{ route('admin.youth.registrations.datatable') }}',
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
                        "createdCell": function(td, cellData, rowData, row, col) {
                            console.log(rowData)
                            if (rowData.paid_or_unpaid == 1 && rowData.enroll_status_check ==1) {
                                // $(td).removeClass('select-checkbox').prop('disabled', true).closest('tr').addClass('no-select');
                            }else {
                                $(td).addClass('select-checkbox').prop('disabled', null);

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
                        //className: 1 ? 'select-checkbox' : '',
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
                        title: "Application Date",
                        data: "application_date",
                        name: "youths.created_at"
                    },
                    {
                        title: "Reg. No.",
                        data: "youth_registration_no",
                        name: "youths.youth_registration_no"
                    },
                    {
                        title: "Institute Name",
                        data: "institutes.title_en",
                        name: "institutes.title_en",
                        visible: false
                    },
                    {
                        title: "Branch Name",
                        data: "branches.title_en",
                        name: "branches.title_en",
                        defaultContent: '',
                        visible: false
                    },
                    {
                        title: "Training Center",
                        data: "training_centers.title_en",
                        name: "training_centers.title_en",
                        defaultContent: '',
                        visible: false
                    },
                    {
                        title: "Programme",
                        data: "programmes.title_en",
                        name: "programmes.title_en",
                        defaultContent: '',
                        visible: false
                    },
                    {
                        title: "Course Name",
                        data: "courses.title_en",
                        name: "courses.title_en",
                        defaultContent: '',
                    },
                    {
                        title: "Enroll Status",
                        data: "enroll_status",
                        name: "youth_course_enrolls.enroll_status",
                        searchable: false,
                    },
                    {
                        title: "Payment Status",
                        data: "payment_status",
                        name: "youth_course_enrolls.payment_status",
                        searchable: false,
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

            $(document, 'td').on('click', '.accept-application', function (e) {
                $('#accept-application-form')[0].action = $(this).data('action');
                console.log($('#accept-application-form')[0].action );
                $('#accept-application-modal').modal('show');
            });

            $(document, 'td').on('click', '.reject-application', function (e) {
                $('#reject-application-form')[0].action = $(this).data('action');
                $('#reject-application-modal').modal('show');
            });

            $("#select_all_rows").click(function () {
                // let selectAll = $(this);
                let selectedRow =  datatable.rows(".selected").nodes().length;
                if (selectedRow == 0) {
                    datatable.rows(':has(.select-checkbox)').select();
                } else  {
                    datatable.rows(':has(.select-checkbox)').deselect();
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
                        $('#accept-now').css({visibility: 'visible'});
                        $('#reject-now').css({visibility: 'visible'});
                    } else {
                        $('#accept-now').css({visibility: 'hidden'});
                        $('#reject-now').css({visibility: 'hidden'});
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

            let acceptNowForm = $("#accept-now-form");
            let rejectNowForm =$("#reject-now-form");

            $("#accept-now").click(function () {
                acceptNowForm.find('.youth_ids').remove();
                acceptNowForm.find('.mobile').remove();
                let selectedRows = Array.from(datatable.rows({selected: true}).data());
                (selectedRows || []).forEach(function (row) {
                    console.log(row)
                    acceptNowForm.append('<input name="youth_ids[]" class="youth_ids" value="' + row.id + '" type="hidden"/>');
                    acceptNowForm.append('<input name="mobile[]" class="mobile" value="' + row.mobile + '" type="hidden"/>');
                });
            });
            $("#reject-now").click(function () {
                rejectNowForm.find('.youth_ids').remove();
                rejectNowForm.find('.mobile').remove();
                let selectedRows = Array.from(datatable.rows({selected: true}).data());
                (selectedRows || []).forEach(function (row) {
                    console.log(row)
                    rejectNowForm.append('<input name="youth_ids[]" class="youth_ids" value="' + row.id + '" type="hidden"/>');
                    rejectNowForm.append('<input name="mobile[]" class="mobile" value="' + row.mobile + '" type="hidden"/>');
                });
            });
        });

    </script>
@endpush
