@php
    $edit = !empty($rank->id);
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
                        <h3 class="card-title font-weight-bold">{{ $edit?'Edit Rank':'Create Rank' }}</h3>
                        <div class="card-tools">
                            <a href="{{route('govt_stakeholder::admin.ranks.index')}}"
                               class="btn btn-sm btn-outline-primary btn-rounded">
                                <i class="fas fa-backward"></i> Back to list
                            </a>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <form
                            action="{{$edit ? route('govt_stakeholder::admin.ranks.update', $rank->id) : route('govt_stakeholder::admin.ranks.store')}}"
                            method="POST" class="row edit-add-form">
                            @csrf
                            @if($edit)
                                @method('put')
                            @endif

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="title_en">{{ __('Title') . '(English)' }} <span
                                            style="color: red">*</span></label>
                                    <input type="text" class="form-control custom-input-box" id="title_en"
                                           name="title_en"
                                           value="{{$edit ? $rank->title_en : old('title_en')}}"
                                           placeholder="{{ __('Title English') }}">
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="title_bn">{{ __('Title') . '(Bangla)' }} <span
                                            style="color: red">*</span></label>
                                    <input type="text" class="form-control custom-input-box" id="title_bn"
                                           name="title_bn"
                                           value="{{$edit ? $rank->title_bn : old('title_bn')}}"
                                           placeholder="{{ __('Title Bangla') }}">

                                </div>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="rank_type_id">Rank Type <span style="color: red">*</span></label>
                                <select class="form-control select2-ajax-wizard"
                                        name="rank_type_id"
                                        id="rank_type_id"
                                        data-model="{{base64_encode(\Module\GovtStakeholder\App\Models\RankType::class)}}"
                                        data-label-fields="{title_en}"
                                        @if($edit)
                                        data-preselected-option="{{json_encode(['text' =>  $rank->rankType->title_en, 'id' =>  $rank->rank_type_id])}}"
                                        @endif
                                        data-placeholder="Select option"
                                >
                                    <option selected value="">Select</option>
                                </select>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="organization_id">Organization Name</label>
                                <select class="form-control select2-ajax-wizard"
                                        name="organization_id"
                                        id="organization_id"
                                        data-model="{{base64_encode(\Module\GovtStakeholder\App\Models\Organization::class)}}"
                                        data-label-fields="{title_en}"
                                        @if($edit && !empty($rank->organization_id))
                                        data-preselected-option="{{json_encode(['text' =>  $rank->organization->title_en, 'id' =>  $rank->organization_id])}}"
                                        @endif
                                        data-placeholder="Select option"
                                >
                                    <option selected value="">Select</option>
                                </select>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="grade">{{ __('Grade') }} </label>
                                    <input type="text" class="form-control custom-input-box" id="grade"
                                           name="grade"
                                           value="{{$edit ? $rank->grade : old('grade')}}"
                                           placeholder="{{ __('Grade') }}">
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="order">{{ __('Order') }} </label>
                                    <input type="text" class="form-control custom-input-box" id="order"
                                           name="order"
                                           value="{{$edit ? $rank->order ? $rank->order:'0' : old('order')}}"
                                           placeholder="{{ __('Order') }}">
                                </div>
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
                rank_type_id: {
                    required: true
                },
                order: {
                    number: true
                }
            },
            messages: {
                title_bn: {
                    pattern: "This field is required in Bangla.",
                },
                order: {
                    number: "This field is required only number."
                }
            },
            submitHandler: function (htmlForm) {
                $('.overlay').show();
                htmlForm.submit();
            }
        });
    </script>
@endpush


