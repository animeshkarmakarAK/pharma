@php
    $currentInstitute = app('currentInstitute');
    $layout = 'master::layouts.front-end';
    $edit = !!$guardian->id;
@endphp
@extends($layout)

@section('title')
    add guardian info
@endsection

@push('css')
    <style>
    </style>

@endpush

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card mt-4">
                    <div class="card-header">
                        <div
                            class="card-title">{{ $edit ? 'Edit guardian information' : 'Add guardian information' }}</div>
                        <div class="card-tools">
                            <a href="{{route('frontend.trainee')}}"
                               class="btn btn-sm btn-outline-primary btn-rounded">
                                <i class="fas fa-backward"></i> {{ __('generic.back_to_list') }}
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <form
                            action="{{ $edit ? route('frontend.guardian-info.update', ['id' => $guardian->id]) : route('frontend.guardian-info.store') }}"
                            method="post"
                            enctype="multipart/form-data" class="edit-form">
                            @csrf
                            @if($edit)
                                @method('put')
                            @endif

                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="name">{{ __('generic.name') }}<span
                                            class="required">*</span> :</label>
                                    <input type="text" class="form-control" name="name" id="name"
                                           placeholder="{{ __('generic.name') }}" value="{{ $guardian->name }}">
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="mobile">{{ __('generic.mobile') }}<span
                                            class="required">*</span> :</label>
                                    <input type="text" class="form-control" name="mobile" id="mobile"
                                           placeholder="{{ __('generic.mobile') }}" value="{{ $guardian->mobile  }}">
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="date_of_birth">{{ __('generic.date_of_birth') }}<span
                                            class="required">*</span> :</label>
                                    <input type="text" class="flat-date form-control" name="date_of_birth"
                                           id="date_of_birth"
                                           placeholder="{{ __('generic.date_of_birth') }}"
                                           value="{{ $guardian->date_of_birth }}">
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="gender">{{ __('generic.gender') }}<span
                                            class="required">*</span> :</label>
                                    <div
                                        class="d-md-flex form-control"
                                        style="display: inline-table;">
                                        <div class="custom-control custom-radio mr-3">
                                            <input class="custom-control-input" type="radio" id="gender_male"
                                                   name="gender"
                                                   value="{{ \App\Models\TraineeFamilyMemberInfo::GENDER_MALE }}"
                                                {{ $guardian->gender == \App\Models\TraineeFamilyMemberInfo::GENDER_MALE ? 'checked' : ''}}>
                                            <label for="gender_male"
                                                   class="custom-control-label">{{ __('generic.gender.male') }}</label>
                                        </div>
                                        <div class="custom-control custom-radio mr-3">
                                            <input class="custom-control-input" type="radio" id="gender_female"
                                                   name="gender"
                                                   value="{{ \App\Models\TraineeFamilyMemberInfo::GENDER_FEMALE }}"
                                                {{ $guardian->gender == \App\Models\TraineeFamilyMemberInfo::GENDER_FEMALE ? 'checked' : ''}}>
                                            <label for="gender_female"
                                                   class="custom-control-label">{{__('generic.gender.female')}}</label>
                                        </div>
                                        <div class="custom-control custom-radio mr-3">
                                            <input class="custom-control-input" type="radio"
                                                   id="gender_transgender"
                                                   name="gender"
                                                   value="{{ \App\Models\TraineeFamilyMemberInfo::GENDER_OTHER }}"
                                                {{$guardian->gender == \App\Models\TraineeFamilyMemberInfo::GENDER_OTHER ? 'checked' : ''}}>
                                            <label for="gender_transgender"
                                                   class="custom-control-label">{{ __('generic.other') }}</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="relation_with_trainee">{{ __('generic.relation') }}<span
                                            class="required">*</span> :</label>
                                    <input type="text" class="form-control" name="relation_with_trainee"
                                           id="relation_with_trainee"
                                           placeholder="{{ __('generic.relation') }}"
                                           value="{{ $guardian->relation_with_trainee  }}">
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="occupation">{{ __('generic.occupation') }}</label>
                                    <input type="text" class="form-control" name="occupation" id="occupation"
                                           placeholder="{{ __('generic.occupation') }}"
                                           value="{{ $guardian->occupation_with_trainee  }}">
                                </div>

                                <div class="col-md-12">
                                    <input type="submit" class="btn btn-primary float-right ml-2"
                                           value="{{ $edit ? __('admin.common.edit') : __('admin.common.add') }}">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <x-generic-validation-error-toastr></x-generic-validation-error-toastr>

    <script>
        const editForm = $('.edit-form');

        editForm.validate({
            rules: {
                name: {
                    required: true,
                    maxLength: 30,
                },
                mobile: {
                    required: true,
                },
                date_of_birth: {
                    required: true,
                },
                gender: {
                    required: true,
                },
                relation_with_trainee: {
                    required: true,
                },
                occupation: {
                    required: false,
                }
            }
        });

    </script>
@endpush
