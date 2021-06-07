@extends('voyager::master')

@php
    $title = __('গ্রাম কমিটি বিস্তারিত');
@endphp

@section('page_title', $title)

@section('css')
    <style>
        .committee-container .form-group label:nth-child(1) {
            font-weight: bold;
            display: block;
        }
    </style>
@stop

@section('page_header')
    <h1 class="page-title">
        <i class="voyager-params"></i>
        {{ $title }}

        <a href="{{ route('ward-village-committees.index') }}" class="btn btn-sm btn-warning">
            <span class="fa fa-backward"></span>
            {{ __('voyager::generic.back') }}
        </a>

        <a class="btn btn-sm btn-primary" href="{{ route('ward-village-committees.edit', $committee->id) }}"><i class="fa fa-edit"></i> {{ __('voyager::generic.edit') }}</a>
    </h1>
@stop

@section('content')
    <div class="page-content committee-container container-fluid">
        <div class="row justify-content-center">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4 mb-0">
                                <div class="form-group">
                                    <label for="">{{ __('কমিটির নাম') }} :</label>
                                    <label>{{optional($committee->programme)->title . ' - '. (optional($committee->locVillageWardAshrayanMatrikendro)->title ?? optional($committee->locMunicipalWard)->title ?? optional($committee->LocCityCorporationWard)->title)}}</label>
                                </div>
                            </div>

                            @if(auth()->user()->isUpazilaOffice())
                                <div class="col-md-4 mb-0">
                                    <div class="form-group">
                                        <label for="">{{ __('ইউনিয়ন/পৌরসভা') }} :</label>
                                        <label>{{optional($committee->locUnionMunicipality)->title}}</label>
                                    </div>
                                </div>
                            @endif

                            <div class="col-md-4 mb-0">
                                <div class="form-group">
                                    <label for="">{{ __('গ্রাম/ওয়ার্ড') }} :</label>
                                    <label>{{optional($committee->locVillageWardAshrayanMatrikendro)->title}}</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="page-content committee-container container-fluid">
        <div class="row justify-content-center">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <table class="table table-sm table-striped">
                                    <thead>
                                    <tr>
                                        <th>{{ __('পদবি') }}</th>
                                        <th>{{ __('সদস্য') }}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($committee->wardVillageCommitteeMembers as $member)
                                        <tr>
                                            <td>{{$member->committee_designation}}</td>
                                            <td>{{$member->member_name}}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('javascript')
    <script>

    </script>
@stop

