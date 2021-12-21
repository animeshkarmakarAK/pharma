@php
    $edit = false;
    /** @var \App\Models\User $authUser */
    $authUser = \App\Helpers\Classes\AuthHelper::getAuthUser();
@endphp

@extends('master::layouts.master')

@section('title')
    {{ __('Routine List') }}
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header text-primary custom-bg-gradient-info">
                        <h3 class="card-title font-weight-bold">{{__('admin.examination_routine.weekly_routine')}}</h3>
                        <div class="card-tools">
                            <a href="{{route('admin.routines.index')}}"
                               class="btn btn-sm btn-outline-primary btn-rounded">
                                <i class="fas fa-backward"></i> {{__('admin.common.back')}}
                            </a>
                            @if(count($examinationRoutines) > 0)
                                <button class="btn btn-sm btn-outline-warning btn-rounded pull-right"
                                        style="margin-top: 0px; width: 80px" onclick="PrintDiv()">
                                    <i class="fa fa-print" aria-hidden="true"></i>
                                </button>
                            @endif


                        </div>

                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    @if(count($errors))
                                        <div class="alert alert-danger alert-dismissible">
                                            <strong>Whoops!</strong> There were some problems with your input.
                                            <br/>
                                            <ul>
                                                @foreach($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif

                                    @if(Session::has('success'))
                                        <div class="alert alert-success alert-dismissible">
                                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                            <strong>Success!</strong> {{Session::get('success')}}
                                        </div>
                                    @endif
                                    <br>
                                </div>



                                {{--<div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="trainer_id">
                                            {{__('admin.routine.batch')}}
                                            <span class="required"></span>
                                        </label>

                                        <select class="form-control select20"
                                                name="batch_id" id="batch_id"
                                        >
                                            <option value="">{{__('admin.daily_routine.select')}}</option>
                                            @foreach($batches as $batch)
                                                <option value="{{$batch->id}}" {{(@$parameters['batch_id'] == $batch->id )? 'selected' : ''}}>{{$batch->title}}</option>
                                            @endforeach

                                        </select>
                                    </div>
                                </div>--}}

                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label for="training_center_id">
                                            {{__('admin.routine.training_center')}}
                                            <span class="required"></span>
                                        </label>

                                        <select class="form-control select2-ajax-wizard" required
                                                name="training_center_id"
                                                id="training_center_id"
                                                data-model="{{base64_encode(App\Models\TrainingCenter::class)}}"
                                                data-label-fields="{title}"
                                                data-dependent-fields="#batch_id"
                                                data-filters="{{json_encode(['institute_id' => $authUser->institute_id])}}"
                                                @if(@$parameters['training_center_id'])
                                                data-preselected-option="{{json_encode(['text' =>  $parameters['training_center_name'], 'id' =>  $parameters['training_center_id']])}}"
                                                @endif
                                                data-placeholder="{{ __('generic.select_placeholder') }}"
                                        >
                                        </select>

                                    </div>
                                </div>


                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label for="batch_id">
                                            {{__('admin.routine.batch_title')}}
                                            <span class="required"></span>
                                        </label>

                                        <select class="form-control select2-ajax-wizard" required
                                                name="batch_id"
                                                id="batch_id"
                                                data-model="{{base64_encode(App\Models\Batch::class)}}"
                                                data-label-fields="{title}"
                                                data-dependent-fields="#examination_id"
                                                data-depend-on-optional="training_center_id"
                                                data-filters="{{json_encode(['institute_id' => $authUser->institute_id])}}"
                                                @if(@$parameters['batch_id'])
                                                data-preselected-option="{{json_encode(['text' =>  $parameters['batch_name'], 'id' =>  $parameters['batch_id']])}}"
                                                @endif
                                                data-placeholder="{{ __('generic.select_placeholder') }}"
                                        >
                                        </select>

                                    </div>
                                </div>

                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label for="examination_id">
                                            {{__('admin.examination_routine.examination')}}
                                            <span class="required"></span>
                                        </label>

                                        <select class="form-control select2-ajax-wizard"
                                                name="examination_id"
                                                id="examination_id"
                                                data-model="{{base64_encode(App\Models\Examination::class)}}"
                                                data-label-fields="{code} -- {exam_details}"
                                                data-depend-on-optional="batch_id"
                                                data-filters="{{json_encode(['institute_id' => $authUser->institute_id])}}"
                                                @if(@$parameters['examination_id'])
                                                data-preselected-option="{{json_encode(['text' =>  $parameters['examination_name'], 'id' =>  $parameters['examination_id']])}}"
                                                @endif
                                                data-placeholder="{{ __('generic.select_placeholder') }}"
                                        >
                                        </select>

                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label for="trainer_id" style="visibility: hidden">
                                            xsd
                                            <span class="required"></span>
                                        </label>

                                        <button type="button"
                                                class="btn btn-default form-control" id="examination-routine-search">{{ __('admin.common.search') }}</button>
                                    </div>
                                </div>


                            </div>
                        <div class="col">
                            <div class="overlay" style="display: none">
                                <i class="fas fa-2x fa-sync-alt fa-spin"></i>
                            </div>
                        </div>
                        <div class="datatable-container">
                            <table id="dataTable" class="table table-bordered table-striped dataTable">
                                <thead>
                                <tr>
                                    <th class="text-center">{{__('admin.examination_routine.date')}}</th>
                                    <th class="text-center">{{__('admin.examination_routine.examination')}}</th>
                                </tr>
                                </thead>
                                <tbody id="examination-routine">
                                </tbody>
                            </table>
                        </div>
                        {{--@if(count($examinationRoutines) > 0)
                            <div class="datatable-container">
                                <p class="text-center text-success border-bottom border-top">
                                    Report result on
                                    @if(@$parameters['batch_id'])

                                        <span>
                                            {{__('admin.routine.batch_title')}} :
                                        </span>
                                        {{$parameters['batch_name']}}
                                    @endif

                                    @if(@$parameters['examination_id'])

                                        <span>
                                            {{__('admin.examination_routine.examination')}} :
                                        </span>
                                        {{$parameters['examination_name']}}
                                    @endif
                                </p>

                                <table id="dataTable" class="table table-bordered table-striped dataTable">
                                    <thead>
                                    <tr>
                                        <th class="text-center">{{__('admin.examination_routine.date')}}</th>
                                        <th class="text-center">{{__('admin.examination_routine.examination')}}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($examinationRoutines as $examinationRoutine)
                                        <tr>
                                            <td>
                                                {{date('jS F , y', strtotime($examinationRoutine->date))}}
                                            </td>
                                            <td>
                                                <table class="table">
                                                    <tr>
                                                        @foreach($examinationRoutine->examinationRoutineDetail as $examinationRoutineDetail)
                                                            <td class="text-center font-weight-bold">
                                                                {{ date("g:i A", strtotime($examinationRoutineDetail->start_time)) }} -- {{ date("g:i A", strtotime($examinationRoutineDetail->end_time)) }}
                                                            </td>
                                                        @endforeach
                                                    </tr>
                                                    <tr>
                                                        @foreach($examinationRoutine->examinationRoutineDetail as $examinationRoutineDetail)
                                                            <td class="text-center">
                                                                {{$examinationRoutineDetail->examination->code}} -- {{ substr($examinationRoutineDetail->examination->exam_details,0,100) }}
                                                            </td>
                                                        @endforeach
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif--}}
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('utils.delete-confirm-modal')

@endsection
@push('css')
    <link rel="stylesheet" href="{{asset('/css/datatable-bundle.css')}}">
    <style>
        .select20 { width: 100%}
        .select2-container--default .select2-selection--single {
            background-color: #fafdff;
            border: 2px solid #ddf1ff;
            border-radius: 4px;
        }
        .select2-container .select2-selection--single {
            box-sizing: border-box;
            cursor: pointer;
            display: block;
            height: 38px;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
            -webkit-user-select: none;
        }
        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 26px;
            position: absolute;
            top: 7px;
            right: 1px;
            width: 20px;
        }
    </style>

@endpush

@push('js')
    <script type="text/javascript" src="{{asset('/js/datatable-bundle.js')}}"></script>
    <script>
        $(function () {
            $('.select20').select2();
        })

        const template = function (item) {
            let html ='<tr><td>'+item.id+'</td><td>'+item.training_center_id+'</td></tr>';
            return html;
        };
        const searchForm = $('.edit-add-form');
        searchForm.validate({
            rules: {
                batch_id: {
                    required: true,
                },
                training_center_id: {
                    required: true,
                },
                submitHandler: function (htmlForm) {
                    $('.overlay').show();
                    htmlForm.submit();
                }
            }
        });

        const searchAPI = function ({model, columns}) {
            return function (url, filters = {}) {
                return $.ajax({
                    url: url,
                    type: "POST",
                    data: {
                        _token: '{{csrf_token()}}',
                        resource: {
                            model: model,
                            columns: columns,
                            paginate: true,
                            page: 1,
                            per_page: 16,
                            filters,
                        }
                    }
                }).done(function (response) {
                    return response;
                });
            };
        };

        let baseUrl = '{{route('web-api.model-resources')}}';
        const skillVideoFetch = searchAPI({
            model: "{{base64_encode(\App\Models\ExaminationRoutine::class)}}",
            columns: 'institute_id|batch_id|training_center_id|date|training_center.title'
        });

        function examRoutineSearch(url = baseUrl) {
            $('.overlay').show();
            let training_center = $('#training_center_id').val();
            let batch = $('#batch_id').val();
            let examination = $('#examination_id').val();
            //let videoCategory = $('#video_category_id').val();
            const filters = {};
            if (training_center?.toString()?.length) {
                filters['training_center_id'] = training_center;
            }
            if (batch_id?.toString()?.length) {
                filters['batch_id'] = batch;
            }
            if (examination?.toString()?.length) {
                filters['examination_id'] = examination;
            }
            skillVideoFetch(url, filters)?.then(function (response) {
                console.log('response',response);
                $('.overlay').hide();
                window.scrollTo(0, 0);
                let html = '';
                if (response?.data?.data.length <= 0) {
                    html += '<div class="text-center mt-5" "></i><div class="text-center text-danger h3">No data found!</div>';
                }
                $.each(response.data?.data, function (i, item) {
                    html += template(item);

                });
                $('#examination-routine').html(html);
/*
                let link_html = '<nav> <ul class="pagination">';
                let links = response?.data?.links;
                if (links.length > 3) {
                    $.each(links, function (i, link) {
                        link_html += paginatorLinks(link);
                    });
                }
                link_html += '</ul></nav>';
                $('.prev-next-button').html(link_html);*/
            });
        }

        $(document).ready(function(){
            examRoutineSearch();
            $('#training_center_id').on('keyup change',function (){
                examRoutineSearch();
            });
            $('#batch_id').on('keyup change',function (){
                examRoutineSearch();
            });
            $('#examination_id').on('keyup change',function (){
                examRoutineSearch();
            });
            $('#examination-routine-search').on('click',function (){
                examRoutineSearch();
            });

        });
    </script>

    <script type="text/javascript">
        function PrintDiv() {
            var divToPrint = document.getElementsByClassName('datatable-container')[0];
            var popupWin = window.open('invoice', '_blank', 'width=100%,height=auto,location=no,left=200px');
            popupWin.document.open();
            popupWin.document.write('<html><head><link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" type="text/css"><link href="Assets/css/bootstrap.min.css" rel="stylesheet" type="text/css"></head><body onload="window.print()">' + divToPrint.innerHTML + '</body></html>');
            popupWin.document.close();
            window.close();
        }
    </script>
@endpush

<?php
@Session::forget(['examination_id','batch_id','training_center_id']);
?>


