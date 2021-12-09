@php
    $layout = 'master::layouts.front-end';
@endphp

@extends($layout)

@section('title')
    Institutes
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-10 py-2">
                <div class="card mb-2">
                    <h3 class="card-header text-center p-5">{{ $institute->title_en }}</h3>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <img class="card-img"
                                     src="{{ $institute->cover_image ?? "http://via.placeholder.com/640x360" }}"
                                     height="300" alt="Card image cap" title="{{$institute->title_en}} image">
                            </div>

                            <div class="col-md-6">
                                <div class="row justify-content-center mr-2">
                                    <p class="card-info col-md-10"><span class="font-weight-bold">Office head: </span>{{ $institute->office_head_name }}</p>
                                    <p class="card-info col-md-10"><span class="font-weight-bold">Office head post: </span>{{ $institute->office_head_post }}</p>
                                    <p class="card-info col-md-10"><span class="font-weight-bold">Mobile: </span>{{ $institute->mobile }}</p>
                                    <p class="card-info col-md-10"><span class="font-weight-bold">E-mail: </span>{{ $institute->email }}</p>
                                </div>
                            </div>

                            <div class="col-md-6 mt-2">
                                <h4 class="font-weight-bold">Contact Information</h4>
                                <p class="card-info col-md-10"><span class="font-weight-bold">Contact person name: </span>{{ $institute->contact_person_name }}</p>
                                <p class="card-info col-md-10"><span class="font-weight-bold">Contact person E-mail: </span>{{ $institute->contact_person_email }}</p>
                                <p class="card-info col-md-10"><span class="font-weight-bold">Contact person Mobile: </span>{{ $institute->contact_person_mobile }}</p>
                                <p class="card-info col-md-10"><span class="font-weight-bold">Contact person Mobile: </span>{{ $institute->contact_person_mobile }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer text-center">
                        {{ $institute->address}}
                    </div>
                </div>
            </div>
        </div>
@endsection
