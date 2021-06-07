@extends('voyager::master')

@php
    $title = __('কর্ম দল বিস্তারিত');
@endphp

@section('page_title', $title)

@section('css')
    <style>
        .team-container .form-group label:nth-child(1) {
            font-weight: bold;
            display: block;
        }
    </style>
@stop

@section('page_header')
    <h1 class="page-title">
        <i class="voyager-params"></i>
        {{ $title }}
        <a class="btn btn-sm btn-primary" href="{{ route('teams.edit', $team->id) }}"><i
                class="fa fa-edit"></i> {{ __('voyager::generic.edit') }}</a>
    </h1>
@stop

@section('content')
    <div class="page-content team-container container-fluid">
        <div class="panel panel-bordered">
            <div class="panel-heading">
                <a href="{{ route('teams.index') }}" class="btn btn-sm btn-default">
                    <span class="fa fa-backward"></span>
                    {{ __('voyager::generic.back') }}
                </a>
            </div>
            <div class="panel-body">
                <table class="table table-striped table-borderless">
                    <thead>
                    <tr>
                        <td>{{ __('দলের নাম') }} : {{$team->team_name}}</td>
                        <td>{{ __('দলের কোড') }} : {{en2bn($team->team_code)}}</td>
                        <td>{{ __('গ্রাম/ওয়ার্ড') }} : {{optional($team->locVillageWardAshrayanMatrikendro)->title}}</td>
                    </tr>
                    </thead>
                </table>
            </div>
        </div>
        <div class="panel panel-bordered">
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">
                        <table class="table table-sm table-striped">
                            <thead>
                            <tr>
                                <td>#</td>
                                <td>{{ __('সদস্যের ছবি') }}</td>
                                <td>{{ __('সদস্যের নাম') }}</td>
                                <td>{{ __('পিতা/স্বামীর নাম') }}</td>
                                <td>{{ __('বয়স') }}</td>
                                <td>{{ __('পেশা') }}</td>
                            </tr>
                            </thead>
                            <tbody>
                            @php $iter = 0; @endphp
                            @foreach($team->wardVillageTeamMembers as $member)
                                @php $iter++; @endphp
                                <tr>
                                    <td>{{en2bn($iter)}}</td>
                                    <td>
                                        @if($member->photo && \Illuminate\Support\Facades\Storage::exists($member->photo))
                                            <img alt="Photo" src="{{asset('storage/'. ($member->photo))}}"
                                                 class="img-responsive"
                                                 style="width: 50px"/>
                                        @else
                                            <img src="{{ asset('assets/dummy-person.png') }}" class="img-responsive"
                                                 alt="User" style="width: 50px">
                                        @endif
                                    </td>
                                    <td>{{$member->member_name}}</td>
                                    <td>{{$member->father ?? $member->husband}}</td>
                                    <td>{{$member->age}}</td>
                                    <td>{{$member->occupation}}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
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

