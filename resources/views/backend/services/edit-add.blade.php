@php
    $edit = !empty($service->id);
    /** @var \App\Models\User $authUser */
    $authUser = \App\Helpers\Classes\AuthHelper::getAuthUser();
@endphp

@extends('core.main')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header text-primary custom-bg-gradient-info">
                        <h3 class="card-title font-weight-bold">{{ $edit?'Edit Service':'Create Service' }}</h3>
                        <div class="card-tools">
                            <a href="{{route('admin.services.index')}}"
                               class="btn btn-sm btn-outline-primary btn-rounded">
                                <i class="fas fa-backward"></i> Back to list
                            </a>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <form
                            action="{{$edit ? route('admin.services.update', $service->id) : route('admin.services.store')}}"
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
                                           value="{{$edit ? $service->title_en : old('title_en')}}"
                                           placeholder="{{ __('Title') }}">
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="name">{{ __('Title') . '(Bangla)' }} <span style="color: red">*</span></label>
                                    <input type="text" class="form-control custom-input-box" id="title_bn"
                                           name="title_bn"
                                           value="{{$edit ? $service->title_bn : old('title_bn')}}"
                                           placeholder="{{ __('Title') }}">

                                </div>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="organization_id">Organization Name <span style="color: red">*</span></label>
                                <select class="form-control select2-ajax-wizard"
                                        name="organization_id"
                                        id="organization_id"
                                        data-model="{{base64_encode(App\Models\Organization::class)}}"
                                        data-label-fields="{title_en}"
                                        @if($edit && !empty($service->organization_id))
                                        data-preselected-option="{{json_encode(['text' =>  $service->organization->title_en, 'id' =>  $service->organization_id])}}"
                                        @endif
                                        data-placeholder="Select option"
                                >
                                    <option selected value="">Select</option>
                                </select>
                            </div>

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
                    required: true
                },
                title_bn: {
                    required: true,
                    pattern: "^[\\s-'\u0980-\u09ff]{1,255}$",
                },
                organization_id: {
                    required: true,
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


