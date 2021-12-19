@php
    $edit = !empty($examinationResult->examination_id);
    /** @var \App\Models\User $authUser */
    $authUser = \App\Helpers\Classes\AuthHelper::getAuthUser();
@endphp

@extends('master::layouts.master')

@section('title')
    {{__('admin.examination_result.list')}}
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header text-primary custom-bg-gradient-info">
                        <h3 class="card-title font-weight-bold">{{__('admin.examination_result.list')}}</h3>

                        <div class="card-tools">
                            @can('create', \App\Models\ExaminationResult::class)
                                <a href="{{route('admin.examination-results.create')}}"
                                   class="btn btn-sm btn-outline-primary btn-rounded">
                                    <i class="fas fa-plus-circle"></i> {{__('admin.common.add')}}
                                </a>
                            @endcan

                        </div>

                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <form action="{{route('admin.examination-result.batch.store')}}"
                            method="POST" class="row batch-result-form">
                            @csrf
                            @if($edit)
                                @method('put')
                            @endif
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>{{__('admin.examination_result.sl')}}</th>
                                        <th>{{__('admin.examination_result.trainee')}} <span
                                                style="color: red">*</span></th>
                                        <th>{{__('admin.examination_result.total_marks')}} <span
                                                style="color: red">*</span></th>
                                        <th>{{__('admin.examination_result.achieved_marks')}} <span
                                                style="color: red">*</span></th>
                                        <th>{{__('admin.examination_result.feedback')}} <span
                                                style="color: red">*</span></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($trainees as $key => $trainee)
                                        <tr>
                                            <th>
                                                {{$key+1}}
                                            </th>
                                            <input type="text" class="form-control custom-input-box"
                                                        name="result[{{$key}}][examination_id]"
                                                        value="{{$trainee->examination_id}}"
                                                        hidden
                                            >
                                            <input type="text" class="form-control custom-input-box"
                                                   name="result[{{$key}}][youth_id]"
                                                   value="{{$trainee->id}}"
                                                   hidden
                                            >
                                            <td>
                                                <input type="text" class="form-control custom-input-box"
                                                       id="trainee"
                                                       name="result[{{$key}}][trainee]"
                                                       value="{{$trainee->name}}"
                                                       disabled>
                                            </td>
                                            <td>
                                                <input type="number" class="form-control custom-input-box"
                                                       id="total_marks"
                                                       name="result[{{$key}}][total_marks]"
                                                       value="{{$trainee->total_mark}}"
                                                       disabled>
                                            </td>
                                            <td>
                                                <input type="number" class="form-control custom-input-box"
                                                       id="achieved_marks"
                                                       name="result[{{$key}}][achieved_marks]"
                                                       value="{{$edit ? $examinationResult->achieved_marks : old('achieved_marks')}}"
                                                required>
                                            </td>
                                            <td>
                                                <input type="text" class="form-control custom-input-box"
                                                       id="feedback"
                                                       name="result[{{$key}}][feedback]"
                                                       value="{{$edit ? $examinationResult->feedback : old('feedback')}}"
                                                required>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="col-sm-12 text-right">
                                <button type="submit"
                                        class="btn btn-success">Add</button>
                            </div>
                        </form>
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
    <x-generic-validation-error-toastr></x-generic-validation-error-toastr>
    <script>
        {{--const EDIT = !!'{{$edit}}';--}}

        const batchResultForm = $('.batch-result-form');
        batchResultForm.validate();
        var result = $('input[name^="result"]');

        result.filter('input[name$="[achieved_marks]"]').each(function() {
            $(this).rules("add", {
                required: true,
                messages: {
                    required: "Achieved Marks is Mandatory"
                }
            });
        });

        result.filter('input[name$="[feedback]"]').each(function() {
            $(this).rules("add", {
                required: true,
                messages: {
                    required: "FeedBack is Mandatory"
                }
            });
        });
    </script>
@endpush


