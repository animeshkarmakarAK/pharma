@php
    $edit = !empty($event->id);
    /** @var \App\Models\User $authUser */
    $authUser = \App\Helpers\Classes\AuthHelper::getAuthUser();
@endphp
@extends('master::layouts.master')

@section('title')
    {{ $edit?'Edit Event':'Create Event' }}
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header text-primary custom-bg-gradient-info">
                        <h3 class="card-title font-weight-bold">{{ $edit?'Edit Event':'Create Event' }}</h3>

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
                            action="{{$edit ? route('course_management::admin.events.update', $event->id) : route('course_management::admin.events.store')}}"
                            method="POST" class="edit-add-form" enctype="multipart/form-data">
                            @csrf
                            @if($edit)
                                @method('put')
                            @endif
                            <div class="form-row">
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
                                                data-model="{{base64_encode(\Module\CourseManagement\App\Models\Institute::class)}}"
                                                data-label-fields="{title_en}"
                                                data-dependent-fields="#branch_id"
                                                @if($edit)
                                                data-preselected-option="{{json_encode(['text' =>  $event->institute->title_en, 'id' =>  $event->institute->id])}}"
                                                @endif
                                                data-placeholder="{{ __('Select Institute') }}"
                                        >
                                        </select>
                                    </div>
                                @endif

                                <div class="form-group col-md-6">
                                    <label for="caption">Caption <span style="color: red"> * </span></label>
                                    <input type="text" class="form-control custom-input-box" name="caption"
                                           id="caption"
                                           value="{{$edit ? $event->caption : old('caption')}}"
                                           placeholder="Caption" required>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="image">Image <span style="color: red"> * </span></label>
                                    <input type="file" class="form-control custom-input-box" name="image"
                                           id="image"
                                           value="{{$edit ? $event->image : old('image')}}"
                                           placeholder="Image">
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="date">Date <span style="color: red"> * </span></label>
                                    <input type="text" class="flat-datetime flat-date-custom-bg" name="date"
                                           id="date"
                                           value="{{$edit ? $event->date : old('date')}}"
                                           placeholder="Date">
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="details">{{ __('Details') }} <span style="color: red"> * </span></label>
                                        <textarea class="form-control" id="address" name="details"
                                                  placeholder="Details"
                                                  rows="3">{{ $edit ? $event->details : old('details') }}</textarea>
                                    </div>
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

@push('css')
    <style>
        .required {
            color: red;
        }

        .flat-date-custom-bg {
            background-color: #fafdff !important;
        }

        #date-error, #institute_id-error{
            position: absolute;
            left: 5px;
            bottom: 0;
        }
    </style>
@endpush

@push('js')
    <x-generic-validation-error-toastr/>
    <script>
        const EDIT = !!'{{$edit}}';
        const INSTITUTE_USER = !!'{{$authUser->isInstituteUser()}}';
        const editAddForm = $('.edit-add-form');
        editAddForm.validate({
            rules: {
                institute_id: {
                    required: function (){
                        if(!INSTITUTE_USER){
                            return true;
                        }else{
                            return false;
                        }
                    }
                },
                caption: {
                    required: true,
                },
                image: {
                    required: true,
                },
                date: {
                    required: true,
                },
                details: {
                    required: true,
                },
            },
            messages: {

            },
            submitHandler: function (htmlForm) {
                $('.overlay').show();
                htmlForm.submit();
            }
        });
    </script>
@endpush



