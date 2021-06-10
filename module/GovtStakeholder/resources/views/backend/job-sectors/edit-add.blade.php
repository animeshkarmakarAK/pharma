@php
    $edit = !empty($jobSector->id);
    /** @var \App\Models\User $authUser */
    $authUser = \App\Helpers\Classes\AuthHelper::getAuthUser();
@endphp

@extends('master::layouts.master')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header text-primary custom-bg-gradient-info">
                        <h3 class="card-title font-weight-bold">{{ $edit?'Edit Job Sector':'Create Job Sector' }}</h3>
                        <div class="card-tools">
                            <a href="{{route('admin.job-sectors.index')}}"
                               class="btn btn-sm btn-outline-primary btn-rounded">
                                <i class="fas fa-backward"></i> Back to list
                            </a>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <form
                            action="{{$edit ? route('admin.job-sectors.update', $jobSector->id) : route('admin.job-sectors.store')}}"
                            method="POST" class="row edit-add-form">
                            @csrf
                            @if($edit)
                                @method('put')
                            @endif

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="name">{{ __('Title') . '(English)' }} <span
                                            style="color: red">*</span></label>
                                    <input type="text" class="form-control custom-input-box" id="title_en"
                                           name="title_en"
                                           value="{{$edit ? $jobSector->title_en : old('title_en')}}"
                                           placeholder="{{ __('Title') }}">
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="name">{{ __('Title') . '(Bangla)' }} <span style="color: red">*</span></label>
                                    <input type="text" class="form-control custom-input-box" id="title_bn"
                                           name="title_bn"
                                           value="{{$edit ? $jobSector->title_bn : old('title_bn')}}"
                                           placeholder="{{ __('Title') }}">

                                </div>
                            </div>

                            @if($edit)
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="row_status">{{ __('Status') }}<span
                                                style="color: red"> * </span></label>
                                        <div class="custom-control custom-radio col-sm-6">
                                            <input class="custom-control-input" type="radio" id="active"
                                                   name="row_status"
                                                   value="1"
                                                {{ ($edit && $jobSector->row_status == \Module\GovtStakeholder\App\Models\JobSector::ROW_STATUS_ACTIVE) || (!empty(old('row_status')) && old('row_status') == 1)  ? 'checked' : '' }}>
                                            <label for="active" class="custom-control-label">Active</label>
                                        </div>
                                        <div class="custom-control custom-radio col-sm-6">
                                            <input class="custom-control-input" type="radio" id="inactive"
                                                   name="row_status"
                                                   value="0"
                                                {{ ($edit && $jobSector->row_status == \Module\GovtStakeholder\App\Models\JobSector::ROW_STATUS_INACTIVE) || (!empty(old('row_status')) && old('row_status') == 0)  ? 'checked' : '' }}>
                                            <label for="inactive" class="custom-control-label">Inactive</label>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            <div class="col-sm-12 text-right">
                                <button type="submit"
                                        class="btn btn-success">{{ $edit ? __('Update') : __('Add') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('master::utils.delete-confirm-modal')

@endsection
@push('js')
    <x-generic-validation-error-toastr></x-generic-validation-error-toastr>

    <script>
        const EDIT = !!'{{$edit}}';

        const editAddForm = $('.edit-add-form');
        editAddForm.validate({
            rules: {
                title_en: {
                    required: true
                },
                title_bn: {
                    required: true,
                    pattern: "^[\\s-'\u0980-\u09ff]{1,255}$",
                },
            },
            messages: {
                title_bn: {
                    pattern: "This field is required in Bangla.",
                }
            },
            submitHandler: function (htmlForm) {
                $('.overlay').show();
                htmlForm.submit();
            }
        });
    </script>
@endpush


