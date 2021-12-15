@php
    $currentInstitute = app('currentInstitute');
    $layout = 'master::layouts.front-end';
@endphp
@extends($layout)

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-sm-6 mx-auto mb-5">
                <div class="card text-center mt-5 mb-5">
                    <h5 class="card-header bg-success">নিবন্ধন সফল হয়েছে</h5>
                    <div class="card-body pt-5 pb-5">
                        <h5 class="display-5">আপনার আবেদনটি সফলভাবে দাখিল হয়েছে.</h5><br>
                        <p class="text-muted">আপনার অ্যাক্সেস কী:<strong> {{$accessKey}}</strong></p>
                        <p class="text-warning">
                            <em>পরবর্তী প্রক্রিয়া জন্য আপনার অ্যাক্সেস কী সংরক্ষণ করুন.</em>
                        </p>
                        <p class="card-text">এই অ্যাক্সেস কী ব্যবহার করে আপনি আপনার প্রোফাইলে অ্যাক্সেস করতে পারেন. <a
                                href="{{route('frontend.trainee.login-form')}}">ক্লিক করুন</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
@endpush
