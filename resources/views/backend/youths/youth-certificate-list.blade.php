@php
    /** @var \App\Models\User $authUser */
    $authUser = \App\Helpers\Classes\AuthHelper::getAuthUser();
@endphp
@extends('master::layouts.master')

@section('title')
    {{ __('admin.youth.list')  }}
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between custom-bg-gradient-info">
                        <h3 class="card-title font-weight-bold text-primary"> {{ __('admin.youth.certificate')  }}
                            of {{ $youth->name }}</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <a href="javascript: history.go(-1)"
                                   class="mb-3 btn btn-sm btn-rounded btn-outline-primary float-right">
                                    <i class="fas fa-backward"></i>  {{ __('admin.common.back')  }}
                                </a>
                            </div>

                            <div class="col-md-12">
                                <table class="table table-bordered">
                                    <thead>
                                    <tr>
                                        <td width="10%">SL</td>
                                        <td> {{ __('admin.youth_batches.course_title')  }}</td>
                                        <td width="20%"> {{ __('admin.common.action')  }}</td>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @php
                                        $sl = 0;
                                    @endphp
                                    @foreach($youthCourseEnrolls as $youthCourseEnroll)
                                        <tr>
                                            <td>{{ ++$sl }}</td>
                                            <td>{{ $youthCourseEnroll->publishCourse->course->title}}</td>
                                            <td>
                                                @if($youthCourseEnroll->youth_batch_id!=null && $youthCourseEnroll->batch_status==\App\Models\Batch::BATCH_STATUS_COMPLETE)
                                                    <a href="{{ route('admin.youths.certificate', $youthCourseEnroll->id) }}"
                                                       target="_blank"
                                                       class="btn btn-sm btn-info">
                                                        <i class="fas fa-download"></i>
                                                        {{ __('admin.youth.view_cetificate')  }}
                                                    </a>
                                                @endif
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
    </div>
@endsection
@push('css')

@endpush

@push('js')

@endpush
