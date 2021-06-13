@php
    $edit = !empty($trainingCenter->id);
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
                        <h3 class="card-title font-weight-bold">{{ $edit?'Edit Training Center':'Create Training Center' }}</h3>

                        <div class="card-tools">
                            <a href="{{route('course_management::admin.training-centers.index')}}"
                               class="btn btn-sm btn-outline-primary btn-rounded">
                                <i class="fas fa-backward"></i> Back to list
                            </a>
                        </div>

                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <form
                            action="{{$edit ? route('course_management::admin.training-centers.update', $trainingCenter->id) : route('course_management::admin.training-centers.store')}}"
                            method="POST" class="edit-add-form">
                            @csrf
                            @if($edit)
                                @method('put')
                            @endif
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="title_en">Title (En) <span style="color: red"> * </span></label>
                                    <input type="text" class="form-control custom-input-box" name="title_en"
                                           id="title_en"
                                           value="{{$edit ? $trainingCenter->title_en : old('title_en')}}"
                                           placeholder="Enter your training center name in English" required>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="title_bn">Title (Bn) <span style="color: red"> * </span></label>
                                    <input type="text" class="form-control custom-input-box" name="title_bn"
                                           id="title_bn"
                                           value="{{$edit ? $trainingCenter->title_bn : old('title_bn')}}"
                                           placeholder="Enter your training center name in Bengali" required>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="address">{{ __('Address') }}</label>
                                        <textarea class="form-control" id="address" name="address"
                                                  rows="3">{{ $edit ? $trainingCenter->address : old('address') }}</textarea>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="google_map_src">{{ __('Google Map src') }}</label>
                                        <textarea class="form-control" id="google_map_src" name="google_map_src"
                                                  rows="3">{{ $edit ? $trainingCenter->google_map_src : old('google_map_src') }}</textarea>
                                    </div>
                                </div>

                                @if($authUser->isInstituteUser())
                                    <input type="hidden" id="institute_id" name="institute_id"
                                           value="{{$authUser->institute_id}}">
                                @else
                                    <div class="form-group col-md-6">
                                        <label for="institute_id">Institute Name <span
                                                style="color: red"> * </span></label>
                                        <select class="form-control select2-ajax-wizard"
                                                name="institute_id"
                                                id="institute_id"
                                                data-model="{{base64_encode(App\Models\Institute::class)}}"
                                                data-label-fields="{title_en}"
                                                data-dependent-fields="#branch_id"
                                                @if($edit)
                                                data-preselected-option="{{json_encode(['text' =>  $trainingCenter->institute->title_en, 'id' =>  $trainingCenter->institute->id])}}"
                                                @endif
                                                data-placeholder="Select Institute"
                                        >
                                        </select>
                                    </div>
                                @endif
                                <div class="form-group col-md-6">
                                    <label for="branch_id">Branch</label>
                                    <select class="form-control select2-ajax-wizard"
                                            name="branch_id"
                                            id="branch_id"
                                            data-model="{{base64_encode(App\Models\Branch::class)}}"
                                            data-label-fields="{title_en}"
                                            data-depend-on="institute_id"
                                            @if($edit)
                                            data-preselected-option="{{json_encode(['text' =>  !empty($trainingCenter->branch->title_en)?$trainingCenter->branch->title_en:'', 'id' =>  !empty($trainingCenter->branch->id)?$trainingCenter->branch->id:''])}}"
                                            @endif
                                            data-placeholder="Select Branch"
                                    >
                                    </select>
                                </div>

                                <div class="col-sm-12 text-right">
                                    <button type="submit"
                                            class="btn btn-success">{{ $edit ? __('Update') : __('Add') }}</button>
                                </div>
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
    <x-generic-validation-error-toastr/>
    <script>
        const EDIT = !!'{{$edit}}';
        const INSTITUTE_USER = !!'{{$authUser->isInstituteUser()}}';
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
                institute_id: {
                    required: true
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
@push('css')
    <style>
        .required {
            color: red;
        }
    </style>
@endpush


