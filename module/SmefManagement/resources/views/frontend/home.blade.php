@php
    $currentInstitute = domainConfig('institute');
    $layout = 'master::layouts.smef-front-end';

@endphp

@extends($layout)

@section('title')
    প্রথম পাতা
@endsection

@section('content')
    <div class="container-fluid">
        <h1>Hello</h1>
    </div>
@endsection

@push('css')

@endpush

@push('js')

@endpush
