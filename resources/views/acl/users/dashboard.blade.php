@extends('master::layouts.master')

@section('title')
    User Dashboard
@endsection
@section('content')
    Dashboard
@endsection

@push('css')
    <link rel="stylesheet" href="{{asset('/css/datatable-bundle.css')}}">
@endpush

@push('js')
    <script type="text/javascript" src="{{asset('/js/datatable-bundle.js')}}"></script>
@endpush
