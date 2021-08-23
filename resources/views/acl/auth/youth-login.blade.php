@php
    $currentInstitute = domainConfig('institute');
    $layout = $currentInstitute ? 'master::layouts.custom1' : 'master::layouts.front-end';
@endphp

@extends($layout)

@section('content')
    <div class="container-fluid pb-5">
        <div class="row justify-content-center align-items-center">
            <div class="col-md-4">
                <div class="card shadow-lg">
                    <div class="card-header text-center">
                        <i class="fas text-success fa-user-circle fa-4x"></i>
                    </div>
                    <div class="card-body login-card-body form-area">
                        <p class="text-center font-weight-bold">Login to access youth profile</p>
                        <form class="login-form" action="{{route('youth.login-submit')}}" method="post">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <div class="input-group mb-3">
                                    <input name="access_key" id="access_key" type="text" class="form-control"
                                           placeholder="আপনার এক্সেস কী লিখুন">
                                    <div class="input-group-append">
                                        <div class="input-group-text input-group-text-border">
                                            <i class="fas fa-key"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 d-flex justify-content-end">
                                    <button type="submit" class="btn btn-primary form-submit-btn">Login</button>
                                </div>
                            </div>
                        </form>
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
