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
                        <h3 class="card-title font-weight-bold">{{__('course_management::admin.daily_routine.weekly_routine')}}</h3>
                        <div class="card-tools">
                            <a href="{{route('course_management::admin.routines.index')}}"
                               class="btn btn-sm btn-outline-primary btn-rounded">
                                <i class="fas fa-backward"></i> {{__('course_management::admin.common.back')}}
                            </a>
                            @if(count($routines) > 0)
                                <button class="btn btn-sm btn-outline-warning btn-rounded pull-right"
                                        style="margin-top: 0px; width: 80px" onclick="PrintDiv()">
                                    <i class="fa fa-print" aria-hidden="true"></i>
                                </button>
                            @endif


                        </div>

                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <form
                            action="{{route('course_management::admin.weekly-routine.filter') }}"
                            method="POST" class="row1 edit-add-form">
                            @csrf
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

                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="trainer_id">
                                        {{__('course_management::admin.routine.batch')}}
                                        <span class="required"></span>
                                    </label>

                                    <select class="form-control select20"
                                            name="batch_id" id="batch_id"
                                    >
                                        <option value="">{{__('course_management::admin.daily_routine.select')}}</option>
                                        @foreach($batches as $batch)
                                            <option value="{{$batch->id}}" {{(@$parameters['batch_id'] == $batch->id )? 'selected' : ''}}>{{$batch->title_en}}</option>
                                        @endforeach

                                    </select>
                                </div>
                            </div>

                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="trainer_id">
                                        {{__('course_management::admin.daily_routine.trainer')}}
                                        <span class="required"></span>
                                    </label>

                                    <select class="form-control select20"
                                            name="user_id" id="user_id"
                                    >
                                        <option value="">{{__('course_management::admin.daily_routine.select')}}</option>
                                        @foreach($trainers as $trainer)
                                            <option value="{{$trainer->id}}" {{(@$parameters['user_id'] == $trainer->id) ? 'selected' : ''}} >{{$trainer->name_en}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>


                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="trainer_id" style="visibility: hidden">
                                        xsd
                                        <span class="required"></span>
                                    </label>

                                    <button type="submit"
                                            class="btn btn-default form-control">{{ __('course_management::admin.common.search') }}</button>
                                </div>
                            </div>


                        </div>
                        </form>
                        @if(count($routines) > 0)
                            <div class="datatable-container">
                                <table id="dataTable" class="table table-bordered table-striped dataTable">
                                    <thead>
                                    <tr>
                                        <th class="text-center">{{__('course_management::admin.routine.day')}}</th>
                                        <th class="text-center">{{__('course_management::admin.daily_routine.class')}}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($routines as $routine)
                                        <tr>
                                            <td>{{$routine->day}}</td>
                                            <td>
                                                <table class="table">
                                                    <tr>
                                                        @foreach($routine->routineClass as $routineClass)
                                                            <td class="text-center font-weight-bold">
                                                                {{ date("g:i A", strtotime($routineClass->start_time)) }} -- {{ date("g:i A", strtotime($routineClass->end_time)) }}
                                                            </td>
                                                        @endforeach
                                                    </tr>
                                                    <tr>
                                                    @foreach($routine->routineClass as $routineClass)
                                                        <td class="text-center">
                                                            {{$routineClass->class}} -- {{$routineClass->user->name_en}}
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
                        @endif
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
        const searchForm = $('.edit-add-form');
        searchForm.validate({
            rules: {
                batch_id: {
                    required: true,
            },
            submitHandler: function (htmlForm) {
                $('.overlay').show();
                htmlForm.submit();
                }
            }
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
 @Session::forget(['user_id','batch_id']);
?>


