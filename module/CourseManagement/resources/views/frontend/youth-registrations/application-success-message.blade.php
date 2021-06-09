@php
    $currentInstitute = domainConfig('institute');
    $layout = $currentInstitute ? 'master::layouts.custom1' : 'master::layouts.front-end';
@endphp
@extends($layout)

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-sm-6 mx-auto mb-5">
                <div class="card text-center mt-5 mb-5">
                    <h5 class="card-header bg-success">Youth Registration Successful</h5>
                    <div class="card-body pt-5 pb-5">
                        <h5 class="display-5">Your application has been successfully submitted.</h5><br>
                        <p class="text-muted">Your access key:<strong> {{$accessKey}}</strong></p>
                        <p class="text-warning">
                            <em>Please save your access key for further process.</em>
                        </p>
                        <p class="card-text">You can access to your profile using this access key. <a
                                href="{{route('youth.login-form')}}">click
                                here</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
@endpush
