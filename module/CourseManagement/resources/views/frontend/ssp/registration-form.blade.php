@php
    $layout = 'master::layouts.front-end';
@endphp

@extends($layout)

@section('title')
    ssp-registration
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <form action="{{ route('course_management::ssp-registration') }}" method="post" class="ssp-registration-form">
                    @csrf
                    <div class="row justify-content-center py-4">
                        <div class="col-md-8">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row justify-content-center">
                                        <h3 class="font-weight-bold">Registration</h3>
                                    </div>
                                    <div class="row">
                                        <h5 class="ml-2 font-weight-bold">SSP Information</h5>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label for="name">{{ __('generic.name') }}</label>
                                            <input type="text" class="form-control" name="name" id="name"
                                                   placeholder="{{ __('generic.name') }}" value="{{old('name')}}">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="email">{{ __('generic.email') }}</label>
                                            <input type="text" class="form-control" name="email" id="email"
                                                   placeholder="{{ __('generic.email') }}"l value="{{ old('email') }}">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="mobile">{{ __('generic.mobile') }}</label>
                                            <input type="text" class="form-control" name="mobile" id="mobile"
                                                   placeholder="{{ __('generic.mobile') }}" value="{{ old('mobile') }}">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="address">{{ __('generic.address') }}</label>
                                            <input type="text" class="form-control" name="address" id="address"
                                                   placeholder="{{ __('generic.address') }}" value="{{ old('address') }}">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="office_head_name">{{ __('generic.office_head_name') }}</label>
                                            <input type="text" class="form-control" name="office_head_name" id="office_head_name"
                                                   placeholder="{{ __('generic.office_head_name') }}" value="{{ old('office_head_name') }}">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="office_head_post">{{ __('generic.office_head_post') }}</label>
                                            <input type="text" class="form-control" name="office_head_post"
                                                   id="office_head_post"
                                                   placeholder="{{ __('generic.office_head_post') }}" value="{{ old('office_head_post') }}">
                                        </div>
                                    </div>

                                    <div class="row py-2">
                                        <h5 class="ml-2 font-weight-bold">{{ __('generic.user-information') }}</h5>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label
                                                for="contact_person_name">{{ __('generic.contact_person_name') }}</label>
                                            <input type="text" class="form-control" name="contact_person_name"
                                                   id="contact_person_name"
                                                   placeholder="{{ __('generic.contact_person_name') }}" value="{{ old('contact_person_name') }}">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label
                                                for="contact_person_post">{{ __('generic.contact_person_post') }}</label>
                                            <input type="text" class="form-control" name="contact_person_post"
                                                   id="contact_person_post"
                                                   placeholder="{{ __('generic.contact_person_post') }}" value="{{ old('contact_person_post') }}">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label
                                                for="contact_person_email">{{ __('generic.contact_person_email') }}</label>
                                            <input type="text" class="form-control" name="contact_person_email"
                                                   id="contact_person_email"
                                                   placeholder="{{ __('generic.contact_person_email') }}" value="{{ old('contact_person_email') }}">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label
                                                for="contact_person_mobile">{{ __('generic.contact_person_mobile') }}</label>
                                            <input type="text" class="form-control" name="contact_person_mobile"
                                                   id="contact_person_mobile"
                                                   placeholder="{{ __('generic.contact_person_mobile') }}" value="{{ old('contact_person_mobile') }}">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label
                                                for="contact_person_password">{{ __('generic.contact_person_password') }}</label>
                                            <input type="password" class="form-control" name="contact_person_password"
                                                   id="contact_person_password"
                                                   placeholder="{{ __('generic.contact_person_password') }}" value="{{old('contact_person_password')}}">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label
                                                for="contact_person_password_confirmation">{{ __('generic.contact_person_password_confirmation') }}</label>
                                            <input type="password" class="form-control"
                                                   name="contact_person_password_confirmation"
                                                   id="contact_person_password_confirmation"
                                                   placeholder="{{ __('generic.contact_person_password_confirmation') }}" value="{{ old('contact_person_password_confirmation') }}">
                                        </div>
                                        <div class="col-md-12">
                                            <input type="submit" class="btn btn-primary float-right ml-2"
                                                   value="{{ __('generic.registration') }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <x-generic-validation-error-toastr></x-generic-validation-error-toastr>
    <script>
        const SSPRegistrationForm = $('.ssp-registration-form');

            SSPRegistrationForm.validate({
                rules: {
                    name: {
                        required: true,
                        maxLength: 30,
                    },
                    email: {
                        required: true,
                        pattern: /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/,
                    },
                    mobile: {
                        required: true,
                    },
                    address: {
                        required: false,
                    },
                    office_head: {
                        required: true,
                    },
                    office_head_post: {
                        required: true,
                    },
                    contact_person_name: {
                        required: true,
                    },
                    contact_person_post: {
                        required: true,
                    },
                    contact_person_email: {
                        required: true,
                    },
                    contact_person_mobile: {
                        required: true,
                    },
                    contact_person_password: {
                        required: true,
                    },
                    contact_person_password_confirmation: {
                        equalTo: '#contact_person_password',
                    },
                }
            })
    </script>
@endpush
