@php
    $edit = !empty($branch->id);
    /** @var \App\Models\User $authUser */
    $authUser = \App\Helpers\Classes\AuthHelper::getAuthUser();
@endphp

@extends('master::layouts.master')

@section('title')
    {{ $edit?'Edit Branch':'Create Branch' }}
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header text-primary custom-bg-gradient-info">
                        <h3 class="card-title font-weight-bold">{{ $edit?'Edit Branch':'Create Branch' }}</h3>
                        <div class="card-tools">
                            <a href="{{route('course_management::admin.branches.index')}}"
                               class="btn btn-sm btn-outline-primary btn-rounded">
                                <i class="fas fa-backward"></i> Back to list
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
                                    <label for="name">{{ __('Branch Title') . '(English)' }} <span
                                            style="color: red">*</span></label>
                                    <input type="text" class="form-control custom-input-box" id="title_en"
                                           name="title_en"
                                           value="{{$edit ? $branch->title_en : old('title_en')}}"
                                           placeholder="{{ __('Name') }}">
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="name">{{ __('Branch Title') . '(Bangla)' }} <span
                                            style="color: red">*</span></label>
                                    <input type="text" class="form-control custom-input-box" id="title_bn"
                                           name="title_bn"
                                           value="{{$edit ? $branch->title_bn : old('title_bn')}}"
                                           placeholder="{{ __('Name') }}">

                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="address">{{ __('Address') }}</label>
                                    <textarea class="form-control" id="address" name="address"
                                              rows="3">{{ $edit ? $branch->address : old('address') }}</textarea>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="google_map_src">{{ __('Google Map src') }}</label>
                                    <textarea class="form-control" id="google_map_src" name="google_map_src"
                                              rows="3">{{ $edit ? $branch->google_map_src : old('google_map_src') }}</textarea>
                                </div>
                            </div>

                            @if($authUser->isInstituteUser())
                                <input type="hidden" id="institute_id" name="institute_id" id="institute_id"
                                       value="{{$authUser->institute_id}}">
                            @else
                                <div class="form-group col-md-6">
                                    <label for="institute_id">Institute Name <span style="color: red">*</span></label>
                                    <select class="form-control select2-ajax-wizard"
                                            name="institute_id"
                                            id="institute_id"
                                            data-model="{{base64_encode(\Module\CourseManagement\App\Models\Institute::class)}}"
                                            data-label-fields="{title_en}"
                                            @if($edit)
                                            data-preselected-option="{{json_encode(['text' =>  $branch->institute->title_en, 'id' =>  $branch->institute->id])}}"
                                            @endif
                                            data-placeholder="নির্বাচন করুন"
                                    >
                                    </select>
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
    @include('utils.delete-confirm-modal')

@endsection
@push('js')
    <x-generic-validation-error-toastr></x-generic-validation-error-toastr>

    <script>
        const EDIT = !!'{{$edit}}';

        const editAddForm = $('.edit-add-form');
        editAddForm.validate({
            rules: {
                title_en: {
                    required: true,
                    pattern: "^[a-zA-Z0-9!@#\$%\^\&*\)\(+=._-]+$",
                },
                title_bn: {
                    required: true,
                    pattern: "^[\\s-'\u0980-\u09ff!@#\$%\^\&*\)\(+=._-]{1,255}$",
                },
                institute_id: {
                    required: true
                },
            },
            messages: {
                title_en: {
                        pattern: "This field is required in English.",
                },
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


