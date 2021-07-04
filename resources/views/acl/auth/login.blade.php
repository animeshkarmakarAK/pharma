@extends('master::layouts.custom1')
@section('header', '')
@section('footer', '')

@extends('master::layouts.front-end')

@section('content')
    <div class="container-fluid pb-5">
        <div class="row justify-content-center align-items-center">
            <div class="col-md-4">
                <div class="card shadow-lg">
                    <div class="card-header text-center">
                        <i class="fas text-success fa-user-circle fa-4x"></i>
                    </div>
                    <div class="card-body login-card-body form-area">
                        <p class="text-center font-weight-bold">Login to access system</p>
                        <form class="login-form" action="{{route('admin.login')}}" method="post">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <div class="input-group mb-3">
                                    <input name="email" id="email" type="email" class="form-control"
                                           placeholder="Email" value="{{ old('email') }}">
                                    <div class="input-group-append">
                                        <div class="input-group-text input-group-text-border">
                                            <i class="fas fa-envelope"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group mb-3">
                                    <input name="password" id="password" type="password" class="form-control"
                                           placeholder="Password" value="{{ old('password') }}">
                                    <div class="input-group-append">
                                        <div class="input-group-text input-group-text-border">
                                            <i class="fas fa-lock"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-8">
                                    <div class="icheck-primary">
                                        <input type="checkbox" id="remember">
                                        <label for="remember">
                                            Remember Me
                                        </label>
                                    </div>
                                </div>
                                <!-- /.col -->
                                <div class="col-4">
                                    <button type="submit" class="btn btn-primary btn-block form-submit-btn">Login</button>
                                </div>
                                <!-- /.col -->
                            </div>
                        </form>

                        <p class="mb-1">
                            <u>
                                <a class="form_link" href="{{ route('admin.forgot-password-form') }}">
                                    Forgot password?
                                </a>
                            </u>
                        </p>
                        <p class="">Don't have an account? <a href="{{route('admin.register-form')}}">Create an account</a></p>

                    </div>
                    <!-- /.login-card-body -->

                    <div class="overlay" style="display: none">
                        <i class="fas fa-2x fa-sync-alt fa-spin"></i>
                    </div>
                </div>
                <!-- /.login-box -->
            </div>
        </div>
    </div>
@endsection
@push('css')
    <style>

    </style>
@endpush

@push('js')
    <x-generic-validation-error-toastr/>

    <script>
        const loginForm = $('.login-form');
        loginForm.validate({
            rules: {
                email: {
                    required: true,
                    email: true
                },
                password: {
                    required: true,
                }
            },
            submitHandler: function (htmlForm) {
                $('.overlay').show();
                htmlForm.submit();
            }
        });
    </script>
@endpush
