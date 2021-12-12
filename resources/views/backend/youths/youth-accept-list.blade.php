@php
    /** @var \App\Models\User $authUser */
    $authUser = \App\Helpers\Classes\AuthHelper::getAuthUser();
@endphp
@extends('master::layouts.master')

@section('title')
    {{ __('admin.youth.list')  }}
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
                        <h3 class="card-title font-weight-bold text-primary">{{ __('admin.youth.enroll_trainee')  }}</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <button id="add-to-batch-area" style="visibility: hidden" type="button"
                                        class="mb-3 btn btn-sm btn-rounded btn-primary"
                                        data-toggle="modal" data-target="#addToBatchModal">
                                    <i class="fas fa-plus-circle"></i> {{ __('admin.youth_batches.add')  }}
                                </button>
                            </div>

                            <div class="col-md-12">
                                <form action="#">
                                    <div class="row mb-3">
                                        <div class="col-md-1 mb-2">
                                            <label class="filter-label text-primary">
                                                <i class="fas fa-sort-amount-down-alt"></i>{{ __('admin.youth.filter')  }} </label>
                                        </div>
                                        <div class="col-md-2 mb-2">
                                            <input type="text" class="form-control search-text-fields"
                                                   id="youth_name"
                                                   placeholder="Name">
                                        </div>

                                        <div class="col-md-2 mb-2">
                                            <input type="text" class="form-control search-text-fields" id="reg_no"
                                                   placeholder="Reg. No.">
                                        </div>


                                        <div class="col-md-2 mb-2">
                                            <button class="btn btn-primary" id="reset-btn">{{ __('admin.youth.reset')  }}</button>
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
    <!-- Start Modal For All Selection-->
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
                                        data-placeholder="{{ __('generic.select_placeholder') }}">
                                    <option selected disabled>{{ __('generic.select_placeholder') }}</option>
                                    @foreach($batches as $batch)
                                        <option value="{{$batch->id}}">{{$batch->title}}</option>
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
    <!-- End Modal For All Selection -->

    <!-- Start Modal For Single Selection -->

    <div class="modal fade" id="addToSingleBatchModal" tabindex="-1" role="dialog"
         aria-labelledby="addToBatchModalTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                @if($batches->count())
                    <form id="add-to-single-batch-form" method="post"
                          action="{{route('admin.youth.add-to-batch')}}">
                        {{ method_field("PUT") }}
                        {{ csrf_field() }}
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLongTitle">Select Batch</h5>
                            <button type="button" class="close" data-dismiss="modal"
                                    aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="single_batch_id">Select Batch <span
                                        style="color: red"> * </span></label>
                                <select name="single_batch_id" id="single_batch_id" class="select2"
                                        data-placeholder="{{ __('generic.select_placeholder') }}">
                                    <option selected disabled>{{ __('generic.select_placeholder') }}</option>
                                    @foreach($batches as $batch)
                                        <option value="{{$batch->id}}">{{$batch->title}}</option>
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
    <!-- End Modal For Sinlge Selection -->

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
                url: '{{ route('admin.youth.acceptlist.datatable') }}',
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
                            if (rowData.paid_or_unpaid == 1) {
                                $(td).addClass('select-checkbox').prop('disabled', null);
                            }else {
                                $(td).removeClass('select-checkbox').prop('disabled', true).closest('tr').addClass('no-select');
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
                        title: "Name",
                        data: "name",
                        name: "youths.name"
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
                        title: "Institute Title",
                        data: "institute_title",
                        name: "institutes.title",
                        visible: false
                    },
                    {
                        title: "Branch Name",
                        data: "branches.title",
                        name: "branches.title",
                        defaultContent: '',
                        visible: false
                    },
                    {
                        title: "Training Center",
                        data: "training_centers.title",
                        name: "training_centers.title",
                        defaultContent: '',
                        visible: false
                    },
                    {
                        title: "Programme",
                        data: "programmes.title",
                        name: "programmes.title",
                        defaultContent: '',
                        visible: false
                    },
                    {
                        title: "Course Name",
                        data: "courses.title",
                        name: "courses.title",
                        defaultContent: '',
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

            $("#select_all_rows").click(function () {
                let selectedRow =  datatable.rows(".selected").nodes().length;
                if (selectedRow == 0) {
                    datatable.rows(':has(.select-checkbox)').select();
                } else  {
                    datatable.rows(':has(.select-checkbox)').deselect();
                }
            });

            $(document, 'td').on('click', '.accept-to-batch', function (e) {
                $batchId = $('#add-to-single-batch-form')[0];
                if($batchId != null) {
                    $batchId.action = $(this).data('action');
                }
                $('#addToSingleBatchModal').modal('show');
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
                        $('#add-to-batch-area').css({visibility: 'visible'});
                    } else {
                        $('#add-to-batch-area').css({visibility: 'hidden'});
                    }

                    let totalRows = datatable.rows().count();
                    $("#select_all_rows").prop('checked', totalRows === selectedRows)

                }
            });
            bindDatatableSearchOnPresEnterOnly(datatable);



            $("#add-to-batch-area").click(function () {
                addToBatchForm.find('.youth_enroll_ids').remove();
                let selectedRows = Array.from(datatable.rows({selected: true}).data());
                (selectedRows || []).forEach(function (row) {
                    console.log(row);
                    addToBatchForm.append('<input name="youth_enroll_ids[]" class="youth_enroll_ids" value="' + row.youth_course_enroll_id + '" type="hidden"/>');
                });
            });

            $('#accept-now-button').click(function (){
                addToBatchForm.find('.youth_enroll_ids').remove();
                let selectedRows = Array.from(datatable.rows({selected: true}).data());
                (selectedRows || []).forEach(function (row) {
                    console.log(row)
                    addToBatchForm.append('<input name="youth_enroll_ids[]" class="youth_enroll_ids" value="' + row.youth_course_enroll_id + '" type="hidden"/>');
                });
            });
            let addToBatchForm = $("#add-to-batch-form");
            let singleAddToBatchForm = $("#add-to-single-batch-form");

            addToBatchForm.validate({
                rules: {
                    batch_id: {
                        required: true,
                    }
                },
                messages: {
                    batch_id: {
                        required: "Please select Batch",
                    }
                },
                submitHandler: function (htmlForm) {
                    htmlForm.submit();
                }
            });

            singleAddToBatchForm.validate({
                rules: {
                    single_batch_id: {
                        required: true,
                    }
                },
                messages: {
                    single_batch_id: {
                        required: "Please select Batch",
                    }
                },
                submitHandler: function (htmlForm) {
                    htmlForm.submit();
                }
            });

        });

    </script>
@endpush
