@php
    $edit = !empty($role->id);
@endphp
@extends('core.main')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header custom-bg-gradient-info text-primary">
                        <h3 class="card-title font-weight-bold">{{ $edit?'Edit Role':'Create Role' }}</h3>

                        <div class="card-tools">
                            <a href="{{route('admin.roles.index')}}" class="btn btn-sm btn-outline-primary">
                                <i class="fas fa-backward"></i> Back to list
                            </a>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <form
                            action="{{$edit ? route('admin.roles.update', $role->id) : route('admin.roles.store')}}"
                            method="POST" class="edit-add-form">
                            @csrf
                            @if($edit)
                                @method('put')
                            @endif
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="code">Code <span style="color: red"> * </span></label>
                                    <input type="text" class="form-control" name="code" id="code"
                                           pattern="[A-Za-z0-9\w]{4,20}"
                                           value="{{$edit ? $role->code : old('code')}}"
                                           placeholder="Enter unique code" required>
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="title_en">Title (En) <span style="color: red"> * </span></label>
                                    <input type="text" class="form-control" name="title_en" id="title_en"
                                           value="{{$edit ? $role->title_en : old('title_en')}}"
                                           placeholder="Enter title in English" required>
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="title_bn">Title (Bn) <span style="color: red"> * </span></label>
                                    <input type="text" class="form-control" name="title_bn" id="title_bn"
                                           value="{{$edit ? $role->title_bn : old('title_bn')}}"
                                           placeholder="Enter title in Bengali" required>
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="">Deletable?</label>
                                    <div class="input-group form-control">
                                        <div class="custom-control custom-radio custom-radio-is-deletable">
                                            <input type="radio" id="is_deletable_yes"
                                                   name="is_deletable"
                                                   value="1"
                                                   class="custom-control-input" {{$edit && $role->is_deletable == 1 ? 'checked':'' }}>
                                            <label class="custom-control-label" for="is_deletable_yes">Yes</label>
                                        </div>
                                        <div class="custom-control custom-radio custom-radio-is-deletable">
                                            <input type="radio" id="is_deletable_no"
                                                   name="is_deletable"
                                                   value="0"
                                                   class="custom-control-input" {{$edit && $role->is_deletable == 0 ? 'checked':'' }}>
                                            <label class="custom-control-label" for="is_deletable_no">No</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="description">Description</label>
                                    <textarea type="text" class="form-control" name="description" id="description"
                                              placeholder="Enter description">{{$edit ? $role->description : old('description')}}</textarea>
                                </div>


                            </div>
                            <input type="submit" class="btn btn-primary float-right"
                                   value="{{ $edit?'Update Role':'Create Role' }}">
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
        .custom-radio-is-deletable{
            margin-right: 25px;
        }
    </style>
@endpush
@push('js')
    <x-generic-validation-error-toastr/>
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
                code: {
                    required: true
                },
                is_deletable: {
                    required: true
                }
            },
            messages:{
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


