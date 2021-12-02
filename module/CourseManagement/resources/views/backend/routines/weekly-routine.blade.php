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
                        </div>

                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label for="trainer_id">
                                        {{__('course_management::admin.daily_routine.trainer')}}
                                        <span class="required"></span>
                                    </label>

                                    <select class="form-control select20 user_id"
                                            name="daily_routines[<%=sl%>][user_id]"
                                            id="daily_routines[<%=sl%>][user_id]"
                                    >
                                        <option value="">{{__('course_management::admin.daily_routine.select')}}</option>
                                        @foreach($trainers as $trainer)
                                            <option value="{{$trainer->id}}">{{$trainer->name_en}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label for="trainer_id">
                                        {{__('course_management::admin.routine.batch')}}
                                        <span class="required"></span>
                                    </label>

                                    <select class="form-control select20 user_id"
                                            name="daily_routines[<%=sl%>][user_id]"
                                            id="daily_routines[<%=sl%>][user_id]"
                                    >
                                        <option value="">{{__('course_management::admin.daily_routine.select')}}</option>
                                        @foreach($batches as $batch)
                                            <option value="{{$batch->id}}">{{$batch->title_en}}</option>
                                        @endforeach

                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="datatable-container">
                            <table id="dataTable" class="table table-bordered table-striped dataTable">
                                <thead>
                                <tr>
                                    <th>{{__('course_management::admin.routine.day')}}</th>
                                    <th>{{__('course_management::admin.daily_routine.class')}}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($routines as $routine)
                                    <tr>
                                        <td>{{$routine->day}}</td>
                                        <td>
                                            <table>
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

    </script>
@endpush


