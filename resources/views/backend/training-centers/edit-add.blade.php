@php
    $edit = !empty($trainingCenter->id);
    /** @var \App\Models\User $authUser */
    $authUser = \App\Helpers\Classes\AuthHelper::getAuthUser();
@endphp
@extends('master::layouts.master')

@section('title')
    {{ $edit ? __('admin.training_center.edit')  : __('admin.training_center.add')  }}
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header text-primary custom-bg-gradient-info">
                        <h3 class="card-title font-weight-bold">{{ $edit ? __('admin.training_center.edit')  : __('admin.training_center.add')  }}</h3>

                        <div class="card-tools">
                            <a href="{{route('admin.training-centers.index')}}"
                               class="btn btn-sm btn-outline-primary btn-rounded">
                                <i class="fas fa-backward"></i>{{__('admin.common.back')}}
                            </a>
                        </div>

                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <form
                            action="{{$edit ? route('admin.training-centers.update', $trainingCenter->id) : route('admin.training-centers.store')}}"
                            method="POST" class="edit-add-form" enctype="multipart/form-data">
                            @csrf
                            @if($edit)
                                @method('put')
                            @endif
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="title">{{__('admin.training_center.title') }} <span style="color: red"> * </span></label>
                                    <input type="text" class="form-control custom-input-box" name="title"
                                           id="title"
                                           value="{{$edit ? $trainingCenter->title : old('title')}}"
                                           placeholder="{{__('admin.training_center.title') }}" required>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="address">{{__('admin.training_center.address') }}</label>
                                        <textarea class="form-control" id="address" name="address"
                                                  placeholder="Address"
                                                  rows="3">{{ $edit ? $trainingCenter->address : old('address') }}</textarea>
                                    </div>
                                </div>

                                @if($authUser->isInstituteUser())
                                    <input type="hidden" id="institute_id" name="institute_id"
                                           value="{{$authUser->institute_id}}">
                                @else
                                    <div class="form-group col-md-6">
                                        <label for="institute_id">{{__('admin.training_center.institute_name') }} <span
                                                style="color: red"> * </span></label>
                                        <select class="form-control select2-ajax-wizard"
                                                name="institute_id"
                                                id="institute_id"
                                                data-model="{{base64_encode(\App\Models\Institute::class)}}"
                                                data-label-fields="{title}"
                                                data-dependent-fields="#branch_id"
                                                @if($edit)
                                                data-preselected-option="{{json_encode(['text' =>  $trainingCenter->institute->title, 'id' =>  $trainingCenter->institute->id])}}"
                                                @endif
                                                data-placeholder="{{__('admin.training_center.institute_name') }}"
                                        >
                                        </select>
                                    </div>
                                @endif


                                <div class="form-group col-md-6">
                                    <label for="mobile">{{ __('admin.training_center.mobile') }} <span style="color: red"> * </span></label>
                                    <input type="text" class="form-control custom-input-box" name="mobile"
                                           id="mobile"
                                           value="{{$edit ? $trainingCenter->mobile : old('mobile')}}"
                                           placeholder="Mobile" required>
                                </div>


                                <div class="col-sm-12 text-right">
                                    <button type="submit"
                                            class="btn btn-success">{{ $edit ? __('admin.training_center.update') : __('admin.training_center.add') }}</button>
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


        /**
         * start event image course_coordinator_signature dimension validation
         * */
        $.validator.addMethod('dimension', function (value, element, param) {
            if (element.files.length === 0) {
                return true;
            }
            let width = $(element).data('imageWidth');
            let height = $(element).data('imageHeight');
            if (width === param[0] && height === param[1]) {
                return true;
            } else {
                return false;
            }
        }, 'Please upload a Signature with 300 x 80 pixels dimension');

        $('#course_coordinator_signature').change(function () {
            $('#course_coordinator_signature').removeData('imageWidth');
            $('#course_coordinator_signature').removeData('imageHeight');
            let file = this.files[0];
            let tmpImg = new Image();
            tmpImg.src = window.URL.createObjectURL(file);
            tmpImg.onload = function () {
                width = tmpImg.naturalWidth,
                    height = tmpImg.naturalHeight;
                $('#course_coordinator_signature').data('imageWidth', width);
                $('#course_coordinator_signature').data('imageHeight', height);
            }
        });

        $('#course_director_signature').change(function () {
            $('#course_director_signature').removeData('imageWidth');
            $('#course_director_signature').removeData('imageHeight');
            let file = this.files[0];
            let tmpImg = new Image();
            tmpImg.src = window.URL.createObjectURL(file);
            tmpImg.onload = function () {
                width = tmpImg.naturalWidth,
                    height = tmpImg.naturalHeight;
                $('#course_director_signature').data('imageWidth', width);
                $('#course_director_signature').data('imageHeight', height);
            }
        });
        /** end event image dimension validation  */



        editAddForm.validate({
            rules: {
                title: {
                    required: true,
                    pattern: /^[a-zA-Z0-9 ]*$/,
                },
                institute_id: {
                    required: true
                },

                mobile:{
                    required: true,
                },
            },
            messages: {
                title: {
                    pattern: "This field is required in English.",
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


