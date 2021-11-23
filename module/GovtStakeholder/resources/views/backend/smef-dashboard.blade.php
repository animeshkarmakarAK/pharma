@extends('master::layouts.master')
@php
    /** @let \App\Models\User $authUser */
    $authUser = \App\Helpers\Classes\AuthHelper::getAuthUser();
@endphp

@section('title')
    SMEF Dashboard
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row d-flex">
            <h1>SMEF Dashboard</h1>

        </div>
    </div>

@endsection


@push('css')
    <link rel="stylesheet" href="{{asset('/css/datatable-bundle.css')}}">
@endpush

@push('js')
    <script type="text/javascript" src="{{asset('/js/datatable-bundle.js')}}"></script>
@endpush

