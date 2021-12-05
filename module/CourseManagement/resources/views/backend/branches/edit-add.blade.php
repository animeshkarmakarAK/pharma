@php
    $edit = !empty($branch->id);
    /** @var \App\Models\User $authUser */
    $authUser = \App\Helpers\Classes\AuthHelper::getAuthUser();
@endphp

@extends('master::layouts.master')

@section('title')
    {{ $edit?__('course_management::admin.branch.edit'): __('course_management::admin.branch.add') }}
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header text-primary custom-bg-gradient-info">
                        <h3 class="card-title font-weight-bold">{{ $edit ? __('course_management::admin.branch.edit') : __('course_management::admin.branch.add') }}</h3>
                        <div class="card-tools">
                            <a href="{{route('course_management::admin.branches.index')}}"
                               class="btn btn-sm btn-outline-primary btn-rounded">
                                <i class="fas fa-backward"></i> {{__('course_management::admin.common.back')}}
                            </a>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <form
                            action="{{$edit ? route('course_management::admin.branches.update', $branch->id) : route('course_management::admin.branches.store')}}"
                            method="POST" class="row edit-add-form">
                            @csrf
                            @if($edit)
                                @method('put')
                            @endif

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="name">{{__('course_management::admin.branch.title')}} <span
                                            style="color: red">*</span></label>
                                    <input type="text" class="form-control custom-input-box" id="title_en"
                                           name="title_en"
                                           value="{{$edit ? $branch->title_en : old('title_en')}}"
                                           placeholder="{{__('course_management::admin.branch.title')}}">
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="address">{{__('course_management::admin.branch.address')}}</label>
                                    <textarea class="form-control" id="address" name="address"
                                              placeholder="{{__('course_management::admin.branch.address')}}"
                                              rows="3">{{ $edit ? $branch->address : old('address') }}</textarea>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="google_map_src">{{__('course_management::admin.branch.google_map_source')}}</label>
                                    <textarea class="form-control" id="google_map_src" name="google_map_src"
                                              placeholder="{{__('course_management::admin.branch.google_map_source')}}"
                                              rows="3">{{ $edit ? $branch->google_map_src : old('google_map_src') }}</textarea>
                                </div>
                            </div>

                            @if($authUser->isInstituteUser())
                                <input type="hidden" id="institute_id" name="institute_id" id="institute_id"
                                       value="{{$authUser->institute_id}}">
                            @else
                                <div class="form-group col-md-6">
                                    <label for="institute_id">{{__('course_management::admin.branch.institute_name')}} <span style="color: red">*</span></label>
                                    <select class="form-control select2-ajax-wizard"
                                            name="institute_id"
                                            id="institute_id"
                                            data-model="{{base64_encode(\Module\CourseManagement\App\Models\Institute::class)}}"
                                            data-label-fields="{title_en}"
                                            @if($edit)
                                            data-preselected-option="{{json_encode(['text' =>  $branch->institute->title_en, 'id' =>  $branch->institute->id])}}"
                                            @endif
                                            data-placeholder="{{__('course_management::admin.branch.institute_name')}} "
                                    >
                                    </select>
                                </div>
                            @endif

                            <div class="col-sm-12 text-right">
                                <button type="submit"
                                        class="btn btn-success">{{ $edit ? __('course_management::admin.branch.update') : __('course_management::admin.branch.add') }}</button>
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
    <style>
        .has-error{
            position: relative;
            padding: 0px 0 12px 0;
        }
        #institute_id-error{
            position: absolute;
            left: 6px;
            bottom: -9px;
        }
    </style>
@endpush

@push('js')
    <x-generic-validation-error-toastr></x-generic-validation-error-toastr>

    <script>
        const EDIT = !!'{{$edit}}';

        const editAddForm = $('.edit-add-form');
        editAddForm.validate({
            rules: {
                title_en: {
                    required: true,
                    pattern: /^[a-zA-Z0-9 ]*$/,
                },
                institute_id: {
                    required: true
                },
            },
            messages: {
                title_en: {
                        pattern: "This field is required in English.",
                },
            },
            submitHandler: function (htmlForm) {
                $('.overlay').show();
                htmlForm.submit();
            }
        });
    </script>
@endpush


