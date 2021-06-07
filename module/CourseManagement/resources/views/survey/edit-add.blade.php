@php
    $edit = isset($survey->id);
    $title = __('Family Survey ' . ($edit ? 'Edit' : 'Add'));
    $localPrefix = 'teammanagement::survey.';
    $authUser = auth()->user();
@endphp
@extends('voyager::master')

@section('page_title', $title)

@section('css')
    <style>

    </style>
@stop

@section('page_header')
    <h1 class="page-title">
        <i class="fa fa-edit"></i>
        {{ $title }}
    </h1>
@stop
@section('content')
    <div id="app" class="page-content container-fluid">
        <form class="form-edit-add repeater" role="form" id="user_add_edit"
              action="{{$edit ? route('survey.update', $survey) : route('survey.store')}}"
              method="POST" enctype="multipart/form-data" autocomplete="off">
            <!-- PUT Method if we are editing -->
            @if($edit)
                {{ method_field("PUT") }}
            @endif
            @csrf

            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header bg-white">
                            <h4 class="text-center d-inline">
                                {{ __('Family Survey Form') }}
                            </h4>
                            <a href="{{ route('survey.index') }}" class="btn btn-sm pull-right btn-default">
                                <span class="fa fa-backward"></span>&nbsp;
                                {{ __('voyager::generic.back') }}
                            </a>
                        </div>
                        <div class="card-body">
                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="first-tab" href="#first" role="tab"
                                       aria-controls="first"
                                       aria-selected="true">{{ __('Family Head Information') }}</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="second-tab" href="#second" role="tab" aria-controls="second"
                                       aria-selected="false">{{ __('Family Information') }}</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="third-tab" href="#third" role="tab" aria-controls="third"
                                       aria-selected="false">{{ __('Socio-economic information') }}</a>
                                </li>
                            </ul>

                            <div class="tab-content py-2 border border-top-0" id="myTabContent">
                                <div class="tab-pane fade show active" id="first" role="tabpanel"
                                     aria-labelledby="first-tab">
                                    <div class="row p-2">
                                        <div class="col-md-12">
                                            <div class="form-row">
                                                <div class="col-sm-6 col-md-4">
                                                    <div class="form-group">
                                                        <label
                                                            for="programme_id">{{ __($localPrefix . 'programme_id') }}</label>
                                                        <select class="form-control select2"
                                                                {{$edit ? 'disabled':''}}
                                                                name="data[family_head][programme_id]"
                                                                id="programme_id"
                                                        >
                                                            <option selected
                                                                    disabled>{{__("voyager::generic.none")}}</option>
                                                            @foreach($programmes as $programme)
                                                                <option
                                                                    data-program-code="{{$programme->program_code}}"
                                                                    data-end-location-center-type="{{$programme->end_location_center_type}}"
                                                                    value="{{$programme->id}}" {{$edit && $survey->programme_id == $programme->id ? 'selected':''}}>
                                                                    {{$programme->title}}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                @if($authUser->isUpazilaOffice())
                                                    <div class="col-sm-6 col-md-4">
                                                        <div class="form-group">
                                                            <label
                                                                for="loc_union_municipality_id">{{ __($localPrefix . 'loc_union_municipality_id') }}</label>
                                                            <select class="form-control select2"
                                                                    {{$edit ? 'disabled':''}}
                                                                    name="data[family_head][loc_union_municipality_id]"
                                                                    id="loc_union_municipality_id"
                                                            >
                                                                <option selected
                                                                        disabled>{{__("voyager::generic.none")}}</option>
                                                                @foreach($locUnionMunicipalities as $key => $title)
                                                                    <option
                                                                        value="{{$key}}" {{$edit && $survey->loc_union_municipality_id == $key ? 'selected':''}}>{{$title}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                @endif
                                                <div class="col-sm-6 col-md-4">
                                                    <div class="form-group">
                                                        <label
                                                            for="loc_village_ward_ashrayan_matrikendro_id">{{ __($localPrefix . 'loc_village_ward_ashrayan_matrikendro_id') }}</label>
                                                        <select class="form-control select2-ajax-custom"
                                                                {{$edit ? 'disabled':''}}
                                                                name="data[family_head][loc_village_ward_ashrayan_matrikendro_id]"
                                                                id="loc_village_ward_ashrayan_matrikendro_id"
                                                                data-url="{{route('api.index')}}"
                                                                data-model="{{App\Models\LocVillageWardAshrayanMatrikendro::class}}"
                                                                data-label="title"
                                                                data-connection="master"
                                                                @if($authUser->isUpazilaOffice())
                                                                data-depend-on="{{json_encode(['data[family_head][loc_union_municipality_id]' => 'loc_union_municipality_id' ])}}"
                                                                data-additional-queries="{{json_encode(['type_of' => 'undefined'])}}"
                                                                @else
                                                                data-additional-queries="{{json_encode(['type_of' => 'undefined', 'id' => json_decode($authUser->loc_ward_ids)])}}"
                                                                @endif
                                                                data-placeholder="{{__("voyager::generic.none")}}"
                                                        >
                                                            @if($edit && $survey->loc_village_ward_ashrayan_matrikendro_id)
                                                                <option
                                                                    value="{{$survey->loc_village_ward_ashrayan_matrikendro_id}}"
                                                                    selected>{{optional($survey->locVillageWardAshrayanMatrikendro)->title}}</option>
                                                            @endif
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <label
                                                            for="house_no">{{ __($localPrefix . 'house_no') }}</label>
                                                        <input type="text" class="form-control" id="house_no"
                                                               name="data[family_head][house_no]"
                                                               value="{{$edit ? $survey->house_no : ''}}"
                                                               placeholder="{{ __($localPrefix . 'house_no') }}">
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <label for="road_no">{{ __($localPrefix . 'road_no') }}</label>
                                                        <input type="text" class="form-control" id="road_no"
                                                               name="data[family_head][road_no]"
                                                               value="{{$edit ? $survey->road_no : ''}}"
                                                               placeholder="{{ __($localPrefix . 'road_no') }}">
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <label
                                                            for="area_detail">{{ __($localPrefix . 'area_detail') }}</label>
                                                        <input type="text" class="form-control" id="area_detail"
                                                               name="data[family_head][area_detail]"
                                                               value="{{$edit ? $survey->area_detail : ''}}"
                                                               placeholder="{{ __($localPrefix . 'area_detail') }}">
                                                    </div>
                                                </div>
                                            </div>
                                            <fieldset class="scheduler-border">
                                                <legend class="scheduler-border">
                                                    <label for="">{{ __('Family Head') }} :</label>
                                                </legend>
                                                <div class="form-row">
                                                    <div class="col-sm-6">
                                                        <div class="form-group">
                                                            <label
                                                                for="family_head_name">{{ __($localPrefix . 'family_head_name') }}</label>
                                                            <input type="text" class="form-control family_head_name"
                                                                   id="family_head_name"
                                                                   name="data[family_head][family_head_name]"
                                                                   value="{{$edit ? $survey->family_head_name : ''}}"
                                                                   placeholder="{{ __($localPrefix . 'family_head_name') }}">
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div class="form-group">
                                                            <label for="nid">{{ __($localPrefix . 'nid') }}</label>
                                                            <input type="text" class="form-control" id="nid"
                                                                   name="data[family_head][nid]"
                                                                   value="{{$edit ? $survey->nid : ''}}"
                                                                   placeholder="{{ __($localPrefix . 'nid') }}">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-row">
                                                    <div class="col-sm-6">
                                                        <div class="form-group">
                                                            <label
                                                                for="father_spouse">{{ __($localPrefix . 'father_spouse') }}</label>
                                                            <input type="text" class="form-control" id="father_spouse"
                                                                   name="data[family_head][father_spouse]"
                                                                   value="{{$edit ? $survey->father_spouse : ''}}"
                                                                   placeholder="{{ __($localPrefix . 'father_spouse') }}">
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div class="form-group">
                                                            <label
                                                                for="religion">{{ __($localPrefix . 'religion') }}</label>
                                                            <input type="text" class="form-control" id="religion"
                                                                   name="data[family_head][religion]"
                                                                   value="{{$edit ? $survey->religion : ''}}"
                                                                   placeholder="{{ __($localPrefix . 'religion') }}">
                                                        </div>
                                                    </div>
                                                </div>
                                            </fieldset>
                                        </div>

                                        <div class="col-md-12 text-center">
                                            <button type="button"
                                                    onclick="document.getElementById('second-tab').click()"
                                                    class="btn btn-primary px-3 mx-2">
                                                {{ __('পরবর্তী') }} <i class="fa fa-forward"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <div class="tab-pane fade" id="second" role="tabpanel" aria-labelledby="second-tab">
                                    <div class="row p-2">
                                        <div class="col-md-12" id="member-list"></div>
                                        <div class="col-md-12">
                                            <button type="button" onclick="addMemberField()"
                                                    class="btn btn-success mx-2 px-3 float-right"><i
                                                    class="fa fa-user-plus"></i> {{ __('Add New Member') }}</button>
                                        </div>
                                    </div>

                                    <div class="row px-2">
                                        <div class="col-md-12 text-center">
                                            <button type="button" onclick="document.getElementById('first-tab').click()"
                                                    class="btn btn-primary mx-2 px-3">
                                                <i class="fa fa-backward"></i> {{ __('voyager::generic.back') }}
                                            </button>
                                            <button type="button" onclick="document.getElementById('third-tab').click()"
                                                    class="btn btn-success px-3 mx-2">
                                                {{ __('voyager::generic.next') }} <i class="fa fa-forward"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <div class="tab-pane fade" id="third" role="tabpanel" aria-labelledby="third-tab">
                                    <div class="row p-2">
                                        <div class="col-md-12">
                                            <!-- land -->
                                            <fieldset class="scheduler-border">
                                                <legend class="scheduler-border">
                                                    <label for="">{{__('Land Property')}}</label>
                                                </legend>
                                                <div class="form-row">
                                                    @if($edit && optional($survey->familyLandSurvey)->id)
                                                        <input type="hidden" name="data[land][id]"
                                                               value="{{ $survey->familyLandSurvey->id }}">
                                                    @endif
                                                    <div class="col-md-4 col-sm-6">
                                                        <div class="form-group">
                                                            <label
                                                                for="land_house_land">{{ __($localPrefix . 'house_land') }}</label>
                                                            <div class="input-group">
                                                                <input type="text" class="form-control"
                                                                       id="land_house_land"
                                                                       name="data[land][house_land]"
                                                                       value="{{$edit ? optional($survey->familyLandSurvey)->house_land : ''}}"
                                                                       placeholder="{{ __($localPrefix . 'house_land') }}">
                                                                <div class="input-group-append">
                                                                    <div
                                                                        class="input-group-text">{{ __('Shotangsa') }}</div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4 col-sm-6">
                                                        <div class="form-group">
                                                            <label
                                                                for="land_farmland_own">{{ __($localPrefix . 'farmland_own') }}</label>
                                                            <div class="input-group">
                                                                <input type="text" class="form-control"
                                                                       id="land_farmland_own"
                                                                       name="data[land][farmland_own]"
                                                                       value="{{$edit ? optional($survey->familyLandSurvey)->farmland_own : ''}}"
                                                                       placeholder="{{ __($localPrefix . 'farmland_own') }}">
                                                                <div class="input-group-append">
                                                                    <div
                                                                        class="input-group-text">{{ __('Shotangsa') }}</div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4 col-sm-6">
                                                        <div class="form-group">
                                                            <label
                                                                for="land_farmland_lease">{{ __($localPrefix . 'farmland_lease') }}</label>
                                                            <div class="input-group">
                                                                <input type="text" class="form-control"
                                                                       id="land_farmland_lease"
                                                                       name="data[land][farmland_lease]"
                                                                       value="{{$edit ? optional($survey->familyLandSurvey)->farmland_lease : ''}}"
                                                                       placeholder="{{ __($localPrefix . 'farmland_lease') }}">
                                                                <div class="input-group-append">
                                                                    <div
                                                                        class="input-group-text">{{ __('Shotangsa') }}</div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4 col-sm-6">
                                                        <div class="form-group">
                                                            <label
                                                                for="land_pond_arable">{{ __($localPrefix . 'pond_arable') }}</label>
                                                            <div class="input-group">
                                                                <input type="text" class="form-control"
                                                                       id="land_pond_arable"
                                                                       name="data[land][pond_arable]"
                                                                       value="{{$edit ? optional($survey->familyLandSurvey)->pond_arable : ''}}"
                                                                       placeholder="{{ __($localPrefix . 'pond_arable') }}">
                                                                <div class="input-group-append">
                                                                    <div
                                                                        class="input-group-text">{{ __('Shotangsa') }}</div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4 col-sm-6">
                                                        <div class="form-group">
                                                            <label
                                                                for="land_pond_non_arable">{{ __($localPrefix . 'pond_non_arable') }}</label>
                                                            <div class="input-group">
                                                                <input type="text" class="form-control"
                                                                       id="land_pond_non_arable"
                                                                       name="data[land][pond_non_arable]"
                                                                       value="{{$edit ? optional($survey->familyLandSurvey)->pond_non_arable : ''}}"
                                                                       placeholder="{{ __($localPrefix . 'pond_non_arable') }}">
                                                                <div class="input-group-append">
                                                                    <div
                                                                        class="input-group-text">{{ __('Shotangsa') }}</div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4 col-sm-6">
                                                        <div class="form-group">
                                                            <label
                                                                for="land_other">{{ __($localPrefix . 'other') }}</label>
                                                            <div class="input-group">
                                                                <input type="text" class="form-control" id="land_other"
                                                                       name="data[land][other]"
                                                                       value="{{$edit ? optional($survey->familyLandSurvey)->other : ''}}"
                                                                       placeholder="{{ __($localPrefix . 'other')}}">
                                                                <div class="input-group-append">
                                                                    <div
                                                                        class="input-group-text">{{ __('Shotangsa') }}</div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </fieldset>

                                            <!-- livestock -->
                                            <fieldset class="scheduler-border">
                                                <legend class="scheduler-border">
                                                    <label for="">{{__('পশু সম্পদ')}}</label>
                                                </legend>
                                                <div class="form-row">
                                                    @if($edit && optional($survey->familyLivestockSurvey)->id)
                                                        <input type="hidden" name="data[livestock][id]"
                                                               value="{{ $survey->familyLivestockSurvey->id }}">
                                                    @endif
                                                    <div class="col-md-4 col-sm-6">
                                                        <div class="form-group">
                                                            <label
                                                                for="livestock_cow">{{ __($localPrefix . 'cow') }}</label>
                                                            <div class="input-group">
                                                                <input type="text" class="form-control"
                                                                       id="livestock_cow" name="data[livestock][cow]"
                                                                       value="{{$edit ? optional($survey->familyLivestockSurvey)->cow : ''}}"
                                                                       placeholder="{{ __($localPrefix . 'cow') }}">
                                                                <div class="input-group-append">
                                                                    <div
                                                                        class="input-group-text">{{ __('Number') }}</div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4 col-sm-6">
                                                        <div class="form-group">
                                                            <label
                                                                for="livestock_buffalo">{{ __($localPrefix . 'buffalo') }}</label>
                                                            <div class="input-group">
                                                                <input type="text" class="form-control"
                                                                       id="livestock_buffalo"
                                                                       name="data[livestock][buffalo]"
                                                                       value="{{$edit ? optional($survey->familyLivestockSurvey)->buffalo : ''}}"
                                                                       placeholder="{{ __($localPrefix . 'buffalo') }}">
                                                                <div class="input-group-append">
                                                                    <div
                                                                        class="input-group-text">{{ __('Number') }}</div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4 col-sm-6">
                                                        <div class="form-group">
                                                            <label
                                                                for="livestock_goat">{{ __($localPrefix . 'goat') }}</label>
                                                            <div class="input-group">
                                                                <input type="text" class="form-control"
                                                                       id="livestock_goat" name="data[livestock][goat]"
                                                                       value="{{$edit ? optional($survey->familyLivestockSurvey)->goat : ''}}"
                                                                       placeholder="{{ __($localPrefix . 'goat') }}">
                                                                <div class="input-group-append">
                                                                    <div
                                                                        class="input-group-text">{{ __('Number') }}</div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4 col-sm-6">
                                                        <div class="form-group">
                                                            <label
                                                                for="livestock_hen">{{ __($localPrefix . 'hen') }}</label>
                                                            <div class="input-group">
                                                                <input type="text" class="form-control"
                                                                       id="livestock_hen" name="data[livestock][hen]"
                                                                       value="{{$edit ? optional($survey->familyLivestockSurvey)->hen : ''}}"
                                                                       placeholder="{{ __($localPrefix . 'hen') }}">
                                                                <div class="input-group-append">
                                                                    <div
                                                                        class="input-group-text">{{ __('Number') }}</div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4 col-sm-6">
                                                        <div class="form-group">
                                                            <label
                                                                for="livestock_other">{{ __($localPrefix . 'other') }}</label>
                                                            <div class="input-group">
                                                                <input type="text" class="form-control"
                                                                       id="livestock_other"
                                                                       name="data[livestock][other]"
                                                                       value="{{$edit ? optional($survey->familyLivestockSurvey)->other : ''}}"
                                                                       placeholder="{{ __($localPrefix . 'other') }}">
                                                                <div class="input-group-append">
                                                                    <div
                                                                        class="input-group-text">{{ __('Number') }}</div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </fieldset>

                                            <!-- annual income -->
                                            <fieldset class="scheduler-border">
                                                <legend class="scheduler-border">
                                                    <label for="">{{__('Annual Income')}}</label>
                                                </legend>
                                                <div class="form-row">
                                                    @if($edit && optional($survey->familyAnnualIncomeSurvey)->id)
                                                        <input type="hidden" name="data[annual_income][id]"
                                                               value="{{ $survey->familyAnnualIncomeSurvey->id }}">
                                                    @endif
                                                    <div class="col-md-4 col-sm-6">
                                                        <div class="form-group">
                                                            <label
                                                                for="annual_income_land_crop">{{ __($localPrefix . 'land_crop') }}</label>
                                                            <div class="input-group">
                                                                <input type="text" class="form-control annual-income"
                                                                       id="annual_income_land_crop"
                                                                       name="data[annual_income][land_crop]"
                                                                       value="{{$edit ? optional($survey->familyAnnualIncomeSurvey)->land_crop : ''}}"
                                                                       placeholder="{{ __($localPrefix . 'land_crop') }}">
                                                                <div class="input-group-append">
                                                                    <div class="input-group-text">{{ __('Taka') }}</div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4 col-sm-6">
                                                        <div class="form-group">
                                                            <label
                                                                for="annual_income_vegetable_fruit">{{ __($localPrefix . 'vegetable_fruit') }}</label>
                                                            <div class="input-group">
                                                                <input type="text" class="form-control annual-income"
                                                                       id="annual_income_vegetable_fruit"
                                                                       name="data[annual_income][vegetable_fruit]"
                                                                       value="{{$edit ? optional($survey->familyAnnualIncomeSurvey)->vegetable_fruit : ''}}"
                                                                       placeholder="{{ __($localPrefix . 'vegetable_fruit') }}">
                                                                <div class="input-group-append">
                                                                    <div class="input-group-text">{{ __('Taka') }}</div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4 col-sm-6">
                                                        <div class="form-group">
                                                            <label
                                                                for="annual_income_livestock">{{ __($localPrefix . 'livestock') }}</label>
                                                            <div class="input-group">
                                                                <input type="text" class="form-control annual-income"
                                                                       id="annual_income_livestock"
                                                                       name="data[annual_income][livestock]"
                                                                       value="{{$edit ? optional($survey->familyAnnualIncomeSurvey)->livestock : ''}}"
                                                                       placeholder="{{ __($localPrefix . 'livestock') }}">
                                                                <div class="input-group-append">
                                                                    <div class="input-group-text">{{ __('Taka') }}</div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4 col-sm-6">
                                                        <div class="form-group">
                                                            <label
                                                                for="annual_income_pond">{{ __($localPrefix . 'pond') }}</label>
                                                            <div class="input-group">
                                                                <input type="text" class="form-control annual-income"
                                                                       id="annual_income_pond"
                                                                       name="data[annual_income][pond]"
                                                                       value="{{$edit ? optional($survey->familyAnnualIncomeSurvey)->pond : ''}}"
                                                                       placeholder="{{ __($localPrefix . 'pond') }}">
                                                                <div class="input-group-append">
                                                                    <div class="input-group-text">{{ __('Taka') }}</div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4 col-sm-6">
                                                        <div class="form-group">
                                                            <label
                                                                for="annual_income_job">{{ __($localPrefix . 'job') }}</label>
                                                            <div class="input-group">
                                                                <input type="text" class="form-control annual-income"
                                                                       id="annual_income_job"
                                                                       name="data[annual_income][job]"
                                                                       value="{{$edit ? optional($survey->familyAnnualIncomeSurvey)->job : ''}}"
                                                                       placeholder="{{ __($localPrefix . 'job') }}">
                                                                <div class="input-group-append">
                                                                    <div class="input-group-text">{{ __('Taka') }}</div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4 col-sm-6">
                                                        <div class="form-group">
                                                            <label
                                                                for="annual_income_other">{{ __($localPrefix . 'other') }}</label>
                                                            <div class="input-group">
                                                                <input type="text" class="form-control annual-income"
                                                                       id="annual_income_other"
                                                                       name="data[annual_income][other]"
                                                                       value="{{$edit ? optional($survey->familyAnnualIncomeSurvey)->other : ''}}"
                                                                       placeholder="{{ __($localPrefix . 'other') }}">
                                                                <div class="input-group-append">
                                                                    <div class="input-group-text">{{ __('Taka') }}</div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </fieldset>

                                            <!-- others/sanitation -->
                                            <fieldset class="scheduler-border">
                                                <legend class="scheduler-border">
                                                    <label for="">{{__($localPrefix . 'other')}}</label>
                                                </legend>
                                                <div class="form-row">
                                                    @if($edit && optional($survey->familySanitationSurvey)->id)
                                                        <input type="hidden" name="data[sanitation][id]"
                                                               value="{{ $survey->familySanitationSurvey->id }}">
                                                    @endif
                                                    <div class="col-md-6">
                                                        <table
                                                            class="table table-sm table-responsive-sm table-bordered">
                                                            <thead>
                                                            <tr>
                                                                <th>{{__('House (Write Number)')}}</th>
                                                                <th>{{__('Self')}}</th>
                                                                <th>{{__('Rent')}}</th>
                                                            </tr>
                                                            </thead>
                                                            <tr>
                                                                <td>{{__($localPrefix . 'ripe_house')}}</td>
                                                                <td>
                                                                    <input type="text" class="form-control"
                                                                           id="sanitation_ripe_house_own"
                                                                           name="data[sanitation][ripe_house_own]"
                                                                           value="{{$edit ? optional($survey->familySanitationSurvey)->ripe_house_own : ''}}"
                                                                           placeholder="{{ __('নিজ') }}">
                                                                </td>
                                                                <td>
                                                                    <input type="text" class="form-control"
                                                                           id="sanitation_ripe_house_rent"
                                                                           name="data[sanitation][ripe_house_rent]"
                                                                           value="{{$edit ? optional($survey->familySanitationSurvey)->ripe_house_rent : ''}}"
                                                                           placeholder="{{ __('ভাড়া') }}">
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>{{ __($localPrefix . 'semi_ripe_house')}}</td>
                                                                <td>
                                                                    <input type="text" class="form-control"
                                                                           id="sanitation_semi_ripe_house_own"
                                                                           name="data[sanitation][semi_ripe_house_own]"
                                                                           value="{{$edit ? optional($survey->familySanitationSurvey)->semi_ripe_house_own : ''}}"
                                                                           placeholder="{{ __('নিজ') }}">
                                                                </td>
                                                                <td>
                                                                    <input type="text" class="form-control"
                                                                           id="sanitation_semi_ripe_house_rent"
                                                                           name="data[sanitation][semi_ripe_house_rent]"
                                                                           value="{{$edit ? optional($survey->familySanitationSurvey)->semi_ripe_house_rent : ''}}"
                                                                           placeholder="{{ __('ভাড়া') }}">
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>{{__($localPrefix . 'tin_house')}}</td>
                                                                <td>
                                                                    <input type="text" class="form-control"
                                                                           id="sanitation_tin_house_own"
                                                                           name="data[sanitation][tin_house_own]"
                                                                           value="{{$edit ? optional($survey->familySanitationSurvey)->tin_house_own : ''}}"
                                                                           placeholder="{{ __('নিজ') }}">
                                                                </td>
                                                                <td>
                                                                    <input type="text" class="form-control"
                                                                           id="sanitation_tin_house_rent"
                                                                           name="data[sanitation][tin_house_rent]"
                                                                           value="{{$edit ? optional($survey->familySanitationSurvey)->tin_house_rent : ''}}"
                                                                           placeholder="{{ __('ভাড়া') }}">
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>{{__($localPrefix . 'hut')}}</td>
                                                                <td>
                                                                    <input type="text" class="form-control"
                                                                           id="sanitation_hut_own"
                                                                           name="data[sanitation][hut_own]"
                                                                           value="{{$edit ? optional($survey->familySanitationSurvey)->hut_own : ''}}"
                                                                           placeholder="{{ __('নিজ') }}">
                                                                </td>
                                                                <td>
                                                                    <input type="text" class="form-control"
                                                                           id="sanitation_hut_rent"
                                                                           name="data[sanitation][hut_rent]"
                                                                           value="{{$edit ? optional($survey->familySanitationSurvey)->hut_rent : ''}}"
                                                                           placeholder="{{ __('ভাড়া') }}">
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-row">
                                                            <div class="col-md-6 col-sm-6">
                                                                <div class="form-group">
                                                                    <label for="">{{ __($localPrefix . 'toilet_type') }}
                                                                        :</label>
                                                                    <br>
                                                                    <div class="form-check form-check-inline">
                                                                        <input class="form-check-input" type="radio"
                                                                               name="data[sanitation][toilet_type]"
                                                                               {{$edit && optional($survey->familySanitationSurvey)->toilet_type == 1 ? 'checked': ''}}
                                                                               id="sanitation_toilet_type_1" value="1">
                                                                        <label class="form-check-label"
                                                                               for="toilet_type_1">{{ __($localPrefix . 'toilet_type_ripe') }}</label>
                                                                    </div>
                                                                    <div class="form-check form-check-inline">
                                                                        <input class="form-check-input" type="radio"
                                                                               name="data[sanitation][toilet_type]"
                                                                               {{$edit && optional($survey->familySanitationSurvey)->toilet_type == 2 ? 'checked': ''}}
                                                                               id="sanitation_toilet_type_2" value="2">
                                                                        <label class="form-check-label"
                                                                               for="toilet_type_2">{{ __($localPrefix . 'toilet_type_raw') }}</label>
                                                                    </div>
                                                                    <div class="form-check form-check-inline">
                                                                        <input class="form-check-input" type="radio"
                                                                               name="data[sanitation][toilet_type]"
                                                                               {{$edit && optional($survey->familySanitationSurvey)->toilet_type == 0 ? 'checked': (!$edit ? 'checked': '')}}
                                                                               id="sanitation_toilet_type_3" value="0">
                                                                        <label class="form-check-label"
                                                                               for="toilet_type_3">{{ __($localPrefix . 'toilet_type_none') }}</label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6 col-sm-6">
                                                                <div class="form-group">
                                                                    <label
                                                                        for="">{{ __($localPrefix . 'drinking_water') }}
                                                                        :</label>
                                                                    <br>
                                                                    <div class="form-check form-check-inline">
                                                                        <input class="form-check-input" type="checkbox"
                                                                               name="data[sanitation][drinking_water_tubewell]"
                                                                               id="sanitation_drinking_water_tubewell"
                                                                               {{$edit ? (optional($survey->familySanitationSurvey)->drinking_water_tubewell == 1 ? 'checked': '') : (!$edit ? 'checked': '')}}
                                                                               value="1">
                                                                        <label class="form-check-label"
                                                                               for="drinking_water_tubewell">{{ __($localPrefix . 'drinking_water_tubewell') }}</label>
                                                                    </div>
                                                                    <div class="form-check form-check-inline">
                                                                        <input class="form-check-input" type="checkbox"
                                                                               name="data[sanitation][drinking_water_tap]"
                                                                               {{$edit ? (optional($survey->familySanitationSurvey)->drinking_water_tap == 1 ? 'checked': '') : ''}}
                                                                               id="sanitation_drinking_water_tap"
                                                                               value="1">
                                                                        <label class="form-check-label"
                                                                               for="drinking_water_tap">{{ __($localPrefix . 'drinking_water_tap') }}</label>
                                                                    </div>
                                                                    <div class="form-check form-check-inline">
                                                                        <input class="form-check-input" type="checkbox"
                                                                               name="data[sanitation][drinking_water_pond]"
                                                                               {{$edit ? (optional($survey->familySanitationSurvey)->drinking_water_pond == 1 ? 'checked': '') : ''}}
                                                                               id="sanitation_drinking_water_pond"
                                                                               value="1">
                                                                        <label class="form-check-label"
                                                                               for="drinking_water_pond">{{ __($localPrefix . 'drinking_water_pond') }}</label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </fieldset>

                                            <!-- loan -->
                                            <fieldset class="scheduler-border">
                                                <legend class="scheduler-border">
                                                    <label for="">{{__('Loan Information')}}</label>
                                                </legend>
                                                <div class="form-row">
                                                    <div id="loan-list" class="col-md-12">
                                                        <table
                                                            class="table table-bordered table-sm table-responsive-sm">
                                                            <thead>
                                                            <tr>
                                                                <th colspan="3">{{__('Loan Details By Other Organization/Agency')}}</th>
                                                            </tr>
                                                            <tr>
                                                                <th>{{__($localPrefix . 'organization_name')}}</th>
                                                                <th colspan="2">{{__($localPrefix . 'loan_amount')}}</th>
                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    <div class="col-md-12 text-right">
                                                        <button type="button" onclick="addLoanField()"
                                                                class="btn btn-sm btn-warning">
                                                            <i class="fa fa-plus"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </fieldset>

                                            <!-- Person Injury info servey for burn/ingury -->
                                            @if(!$edit || $survey->surveyPersonInjuryDetail)
                                                <fieldset class="scheduler-border"
                                                          style="{{$edit && $survey->surveyPersonInjuryDetail ? '' : 'display: none'}}"
                                                          id="injury_survey_section">
                                                    <legend class="scheduler-border">
                                                        <label
                                                            for="">{{__('এসিড সহিংসতা/দগ্ধ/দুর্ঘটনার কারনে ক্ষতিগ্রস্থ/প্রতিবন্ধী ব্যক্তির বিবরণ (যদি থাকে)')}}</label>
                                                    </legend>
                                                    <div class="form-row">
                                                        <div class="col-md-4 col-sm-6">
                                                            <div class="form-group">
                                                                <label
                                                                    for="injured_family_member_survey_id">{{ __('ক্ষতিগ্রস্থ ব্যক্তি') }}</label>
                                                                <select
                                                                    class="form-control injured_family_member_survey_id"
                                                                    id="injured_family_member_survey_id"
                                                                    name="data[survey_person_injury_detail][family_member_survey_id]">
                                                                    <option selected
                                                                            disabled>{{ __('ক্ষতিগ্রস্থ ব্যক্তি') }}</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4 col-sm-6">
                                                            <div class="form-group">
                                                                <label
                                                                    for="injury_date">{{ __('ক্ষতিগ্রস্থ হওয়ার তারিখ') }}</label>
                                                                <input type="text"
                                                                       class="form-control flat-date injury-date"
                                                                       id="injury_date"
                                                                       name="data[survey_person_injury_detail][injury_date]"
                                                                       value="{{$edit ? optional(optional($survey->surveyPersonInjuryDetail)->injury_date)->format('Y-m-d') : ''}}"
                                                                       placeholder="{{ __('ক্ষতিগ্রস্থ হওয়ার তারিখ') }}">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4 col-sm-6">
                                                            <div class="form-group">
                                                                <label
                                                                    for="injury_reason">{{ __('ক্ষতিগ্রস্থ হওয়ার কারণ') }}</label>
                                                                <div class="input-group">
                                                                    <div class="form-check form-check-inline">
                                                                        <input class="form-check-input injury-reason"
                                                                               type="radio"
                                                                               name="data[survey_person_injury_detail][injury_reason]"
                                                                               {{$edit && $survey->surveyPersonInjuryDetail->injury_reason == Module\TeamManagement\Models\SurveyPersonInjuryDetail::INJURY_REASON_BY_BORN ? 'checked' : ''}}
                                                                               id="injury_reason_by_bor" value="1">
                                                                        <label class="form-check-label"
                                                                               for="injury_reason_by_bor">{{__('জন্মগত')}}</label>
                                                                    </div>
                                                                    <div class="form-check form-check-inline">
                                                                        <input class="form-check-input injury-reason"
                                                                               type="radio"
                                                                               name="data[survey_person_injury_detail][injury_reason]"
                                                                               {{$edit && $survey->surveyPersonInjuryDetail->injury_reason == Module\TeamManagement\Models\SurveyPersonInjuryDetail::INJURY_REASON_ACID_BURN ? 'checked' : ''}}
                                                                               id="injury_reason_acid_burn" value="2">
                                                                        <label class="form-check-label"
                                                                               for="injury_reason_acid_burn">{{__('এসিডদগ্ধ')}}</label>
                                                                    </div>
                                                                    <div class="form-check form-check-inline">
                                                                        <input class="form-check-input injury-reason"
                                                                               type="radio"
                                                                               name="data[survey_person_injury_detail][injury_reason]"
                                                                               {{$edit && $survey->surveyPersonInjuryDetail->injury_reason == Module\TeamManagement\Models\SurveyPersonInjuryDetail::INJURY_REASON_FIRE_BURN ? 'checked' : ''}}
                                                                               id="injury_reason_fire_burn" value="3">
                                                                        <label class="form-check-label"
                                                                               for="injury_reason_fire_burn">{{__('অগ্নিদগ্ধ')}}</label>
                                                                    </div>
                                                                    <div class="form-check form-check-inline">
                                                                        <input class="form-check-input injury-reason"
                                                                               type="radio"
                                                                               name="data[survey_person_injury_detail][injury_reason]"
                                                                               {{$edit && $survey->surveyPersonInjuryDetail->injury_reason == Module\TeamManagement\Models\SurveyPersonInjuryDetail::INJURY_REASON_OTHER ? 'checked' : ''}}
                                                                               id="injury_reason_other" value="4">
                                                                        <label class="form-check-label"
                                                                               for="injury_reason_other">{{__('অন্যান্য')}}</label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="form-row">
                                                        <div class="col-md-4 col-sm-6">
                                                            <div class="form-group">
                                                                <label
                                                                    for="injury_types">{{ __('ক্ষতিগ্রস্থ ব্যক্তির শারীরিক ক্ষয়ক্ষতির ধরণ') }}</label>
                                                                <div class="input-group">
                                                                    <div class="form-check form-check-inline">
                                                                        <input class="form-check-input injury_types"
                                                                               type="checkbox"
                                                                               name="data[survey_person_injury_detail][injury_types][physical]"
                                                                               {{$edit && !empty($survey->surveyPersonInjuryDetail->injury_types['physical']) && $survey->surveyPersonInjuryDetail->injury_types['physical'] ? 'checked' : ''}}
                                                                               id="injury_types_physical" value="1">
                                                                        <label class="form-check-label"
                                                                               for="injury_types_physical">{{__('শারীরিক')}}</label>
                                                                    </div>
                                                                    <div class="form-check form-check-inline">
                                                                        <input class="form-check-input injury_types"
                                                                               type="checkbox"
                                                                               name="data[survey_person_injury_detail][injury_types][mental]"
                                                                               {{$edit && !empty($survey->surveyPersonInjuryDetail->injury_types['mental']) && $survey->surveyPersonInjuryDetail->injury_types['mental'] ? 'checked' : ''}}
                                                                               id="injury_types_mental" value="1">
                                                                        <label class="form-check-label"
                                                                               for="injury_types_mental">{{__('মানসিক')}}</label>
                                                                    </div>
                                                                    <div class="form-check form-check-inline">
                                                                        <input class="form-check-input injury_types"
                                                                               type="checkbox"
                                                                               name="data[survey_person_injury_detail][injury_types][vision]"
                                                                               {{$edit && !empty($survey->surveyPersonInjuryDetail->injury_types['vision']) && $survey->surveyPersonInjuryDetail->injury_types['vision'] ? 'checked' : ''}}
                                                                               id="injury_types_vision" value="1">
                                                                        <label class="form-check-label"
                                                                               for="injury_types_vision">{{__('দৃষ্টি')}}</label>
                                                                    </div>
                                                                    <div class="form-check form-check-inline">
                                                                        <input class="form-check-input injury_types"
                                                                               type="checkbox"
                                                                               name="data[survey_person_injury_detail][injury_types][speech_and_hearing]"
                                                                               {{$edit && !empty($survey->surveyPersonInjuryDetail->injury_types['speech_and_hearing']) && $survey->surveyPersonInjuryDetail->injury_types['speech_and_hearing'] ? 'checked' : ''}}
                                                                               id="injury_types_speech_and_hearing"
                                                                               value="1">
                                                                        <label class="form-check-label"
                                                                               for="injury_types_speech_and_hearing">{{__('বাক ও শ্রবণ')}}</label>
                                                                    </div>
                                                                    <div class="form-check form-check-inline">
                                                                        <input class="form-check-input injury_types"
                                                                               type="checkbox"
                                                                               name="data[survey_person_injury_detail][injury_types][other]"
                                                                               {{$edit && !empty($survey->surveyPersonInjuryDetail->injury_types['other']) && $survey->surveyPersonInjuryDetail->injury_types['other'] ? 'checked' : ''}}
                                                                               id="injury_types_other" value="1">
                                                                        <label class="form-check-label"
                                                                               for="injury_types_other">{{__('বহু মাত্রিক')}}</label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4 col-sm-6">
                                                            <div class="form-group">
                                                                <label
                                                                    for="annual_income_other">{{ __('ক্ষতিগ্রস্থ ব্যক্তির শারীরিক ক্ষতিগ্রস্থতার অবস্থা') }}</label>
                                                                <div class="input-group">
                                                                    <div
                                                                        class="form-check form-check-inline injury_level">
                                                                        <input class="form-check-input" type="radio"
                                                                               name="data[survey_person_injury_detail][injury_level]"
                                                                               {{$edit && $survey->surveyPersonInjuryDetail->injury_level == Module\TeamManagement\Models\SurveyPersonInjuryDetail::INJURY_LEVEL_SLIGHTLY ? 'checked' : ''}}
                                                                               id="injury_level_slightly" value="1">
                                                                        <label class="form-check-label"
                                                                               for="injury_level_slightly">{{__('মৃদু')}}</label>
                                                                    </div>
                                                                    <div
                                                                        class="form-check form-check-inline injury_level">
                                                                        <input class="form-check-input" type="radio"
                                                                               name="data[survey_person_injury_detail][injury_level]"
                                                                               {{$edit && $survey->surveyPersonInjuryDetail->injury_level == Module\TeamManagement\Models\SurveyPersonInjuryDetail::INJURY_LEVEL_MEDIUM ? 'checked' : ''}}
                                                                               id="injury_level_medium" value="2">
                                                                        <label class="form-check-label"
                                                                               for="injury_level_medium">{{__('মাঝারী')}}</label>
                                                                    </div>
                                                                    <div
                                                                        class="form-check form-check-inline injury_level">
                                                                        <input class="form-check-input" type="radio"
                                                                               name="data[survey_person_injury_detail][injury_level]"
                                                                               {{$edit && $survey->surveyPersonInjuryDetail->injury_level == Module\TeamManagement\Models\SurveyPersonInjuryDetail::INJURY_LEVEL_EXTREMELY ? 'checked' : ''}}
                                                                               id="injury_level_extreemly" value="3">
                                                                        <label class="form-check-label"
                                                                               for="injury_level_extreemly">{{__('তীব্র')}}</label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4 col-sm-6">
                                                            <div class="form-group">
                                                                <label
                                                                    for="annual_income_other">{{ __('ক্ষতিগ্রস্থ ব্যক্তির চিকিৎসা সংক্রান্ত তথ্য') }}</label>
                                                                <div class="input-group">
                                                                    <div class="form-check form-check-inline">
                                                                        <input
                                                                            class="form-check-input is_taken_treatment"
                                                                            type="checkbox"
                                                                            name="data[survey_person_injury_detail][is_taken_treatment]"
                                                                            {{$edit && $survey->surveyPersonInjuryDetail->is_taken_treatment ? 'checked' : ''}}
                                                                            id="is_taken_treatment" value="1">
                                                                        <label class="form-check-label"
                                                                               for="is_taken_treatment">{{__('চিকিৎসা নেয়া হয়েছে') }}</label>
                                                                    </div>
                                                                </div>
                                                                <div class="input-group">
                                                                    <div class="form-check form-check-inline">
                                                                        <input
                                                                            class="form-check-input is_treatment_needed"
                                                                            type="checkbox"
                                                                            name="data[survey_person_injury_detail][is_treatment_needed]"
                                                                            {{$edit && $survey->surveyPersonInjuryDetail->is_treatment_needed ? 'checked' : ''}}
                                                                            id="is_treatment_needed" value="1">
                                                                        <label class="form-check-label"
                                                                               for="is_treatment_needed">{{__('আরো চিকিৎসা প্রয়োজন আছে') }}</label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-4 col-sm-6">
                                                            <div class="form-group">
                                                                <label
                                                                    for="annual_income_other">{{ __('ক্ষতিগ্রস্থ ব্যক্তির উপার্জন, প্রশিক্ষণ, আয় বর্ধক ও অন্যান্য তথ্য') }}</label>
                                                                <div class="input-group">
                                                                    <div class="form-check form-check-inline">
                                                                        <input class="form-check-input" type="checkbox"
                                                                               name="data[survey_person_injury_detail][income_and_other_info][earning_person]"
                                                                               {{$edit && !empty($survey->surveyPersonInjuryDetail->income_and_other_info['earning_person']) && $survey->surveyPersonInjuryDetail->income_and_other_info['earning_person'] ? 'checked' : ''}}
                                                                               id="earning_person" value="1">
                                                                        <label class="form-check-label"
                                                                               for="earning_person">{{__('পরিবারের উপার্জনশী ব্যক্তি') }}</label>
                                                                    </div>
                                                                </div>
                                                                <div class="input-group">
                                                                    <div class="form-check form-check-inline">
                                                                        <input class="form-check-input" type="checkbox"
                                                                               name="data[survey_person_injury_detail][income_and_other_info][family_depend_on_person]"
                                                                               {{$edit && !empty($survey->surveyPersonInjuryDetail->income_and_other_info['family_depend_on_person']) && $survey->surveyPersonInjuryDetail->income_and_other_info['family_depend_on_person'] ? 'checked' : ''}}
                                                                               id="family_depend_on_person" value="1">
                                                                        <label class="form-check-label"
                                                                               for="family_depend_on_person">{{__('তার উপর পরিবার নির্ভরশীল') }}</label>
                                                                    </div>
                                                                </div>
                                                                <div class="input-group">
                                                                    <div class="form-check form-check-inline">
                                                                        <input class="form-check-input" type="checkbox"
                                                                               name="data[survey_person_injury_detail][income_and_other_info][has_vocational_training]"
                                                                               {{$edit && !empty($survey->surveyPersonInjuryDetail->income_and_other_info['has_vocational_training']) && $survey->surveyPersonInjuryDetail->income_and_other_info['has_vocational_training'] ? 'checked' : ''}}
                                                                               id="has_vocational_training" value="1">
                                                                        <label class="form-check-label"
                                                                               for="has_vocational_training">{{__('বৃত্তিমূলক প্রশিক্ষন আছে') }}</label>
                                                                    </div>
                                                                </div>
                                                                <div class="input-group">
                                                                    <div class="form-check form-check-inline">
                                                                        <input class="form-check-input" type="checkbox"
                                                                               name="data[survey_person_injury_detail][income_and_other_info][interested_in_income]"
                                                                               {{$edit && !empty($survey->surveyPersonInjuryDetail->income_and_other_info['interested_in_income']) && $survey->surveyPersonInjuryDetail->income_and_other_info['interested_in_income'] ? 'checked' : ''}}
                                                                               id="interested_in_income" value="1">
                                                                        <label class="form-check-label"
                                                                               for="interested_in_income">{{__('আয় বর্ধক কাজ করতে আগ্রহী') }}</label>
                                                                    </div>
                                                                </div>
                                                                <div class="input-group">
                                                                    <div class="form-check form-check-inline">
                                                                        <input class="form-check-input" type="checkbox"
                                                                               name="data[survey_person_injury_detail][income_and_other_info][requires_financial_support]"
                                                                               {{$edit && !empty($survey->surveyPersonInjuryDetail->income_and_other_info['requires_financial_support']) && $survey->surveyPersonInjuryDetail->income_and_other_info['requires_financial_support'] ? 'checked' : ''}}
                                                                               id="requires_financial_support"
                                                                               value="1">
                                                                        <label class="form-check-label"
                                                                               for="requires_financial_support">{{__('এ কাজে আর্থিক সহায়তার প্রয়োজন') }}</label>
                                                                    </div>
                                                                </div>
                                                                <div class="input-group">
                                                                    <div class="form-check form-check-inline">
                                                                        <input class="form-check-input" type="checkbox"
                                                                               name="data[survey_person_injury_detail][income_and_other_info][member_of_targeted_family]"
                                                                               {{$edit && !empty($survey->surveyPersonInjuryDetail->income_and_other_info['member_of_targeted_family']) && $survey->surveyPersonInjuryDetail->income_and_other_info['member_of_targeted_family'] ? 'checked' : ''}}
                                                                               id="member_of_targeted_family" value="1">
                                                                        <label class="form-check-label"
                                                                               for="member_of_targeted_family">{{__('ক্ষতিগ্রস্থ ব্যক্তি লক্ষ্যভূক্ত পরিবারের সদস্য') }}</label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </fieldset>
                                            @endif
                                        </div>

                                        <div class="col-md-12 text-center">
                                            <button type="button"
                                                    onclick="document.getElementById('second-tab').click()"
                                                    class="btn btn-primary mx-2 px-3">
                                                <i class="fa fa-backward"></i> {{ __('voyager::generic.back') }}
                                            </button>
                                            <button type="submit" class="btn btn-success px-3 mx-2">
                                                {{ __('voyager::generic.save') }} <i class="fa fa-save"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@stop

@push('javascript')
    <script type="text/javascript" src="{{ asset('backend_resources/js/form.js') }}"></script>
    <script src="{{ asset('backend_resources/js/jquery_validation_combine.js') }}"></script>
    @if(app()->getLocale() === 'bn')
        <script src="{{ asset('backend_resources/js/validation_localization_bn.js') }}"></script>
    @endif
@endpush

@section('javascript')
    <script>
        const memberList = $('#member-list'),
            loanList = $('#loan-list tbody'),
            form = $('#app .form-edit-add'),
            edit = parseInt('{{$edit ? 1:0}}'),
            programmeId = $('#programme_id'),
            locVillageWardAshrayanMatrikendroId = $('#loc_village_ward_ashrayan_matrikendro_id'),
            locUnionMunicipalityId = $('#loc_union_municipality_id'),
            injurySurveySection = $('#injury_survey_section'),
            injuredFamilyMemberSurveyId = $('#injured_family_member_survey_id');

        let members = [],
            allMemberLists = [],
            loans = [],
            memberSl = 1,
            loanSl = 1;

        $(function () {
            if (edit) {
                members = @json($survey->familyMemberSurveys);
                loans = @json($survey->familyLoanSurvey);
                if (members.length) {
                    members.forEach(function (member) {
                        addMemberField(true, member, member.relation_with_head === '{{\Module\TeamManagement\Models\FamilyMemberSurvey::RELATION_SELF}}');
                    })
                }

                if (loans.length) {
                    loans.forEach(function (loan) {
                        addLoanField(true, loan);
                    })
                }
            }
        });

        const personalInfo = {
                'data[family_head][programme_id]': {
                    required: true,
                },
                'data[family_head][family_head_name]': {
                    required: true,
                },
                'data[family_head][nid]': {
                    required: true,
                },
                'data[family_head][father_spouse]': {
                    required: true,
                },
                'data[family_head][house_no]': {
                    required: true,
                }
            },
            submitSurvey = function (formElement, e) {
                let keyCode = e.keyCode || e.which;
                if (keyCode === 13) {
                    e.preventDefault();
                    return false;
                }
                let formData = new FormData(formElement);
                form.arrowAjax({
                    processData: false,
                    contentType: false,
                    data: formData
                })
                return false;
            };

        $(function () {
            form.validate(Object.assign({rules: personalInfo, submitHandler: submitSurvey}, formValidatorConfig));

            $.validator.addClassRules('annual-income', {
                required: (el) => {
                    let isRequired = true;
                    $('.annual-income').each(function () {
                        if (Number($(this).val()) > 0) isRequired = false;
                    });
                    return isRequired;
                },
                number: true
            });

            $(document).on('click', '#first-tab', function (e) {
                if (!form.valid()) return false;

                $(this).tab('show')
            });

            $(document).on('click', '#second-tab', function (e) {
                if (!form.valid()) return false;

                $(this).tab('show')

                if (memberList.children().length < 1) {
                    addMemberField(false, [], true);
                    $(".family_head_name").val($("#family_head_name").val());
                    $(".member-member-name").trigger('keyup');
                }
            });

            $(document).on('click', '#third-tab', function (e) {
                if (!form.valid()) return false;
                $(this).tab('show')
            })
        });

        function addMemberField(edit = false, member = [], isHead = false) {
            let memberInfo = $('#member_info').html();
            let template = lodash_template(memberInfo);
            memberList.append(template({sl: memberSl++, member: member, edit: edit, isHead: isHead}));

            $.validator.addClassRules("member-member-name", {required: true});
            $.validator.addClassRules("member-relation-with-head", {required: true});
            $.validator.addClassRules("member-gender", {required: true});
            $.validator.addClassRules("member-age", {required: true});
            $.validator.addClassRules("member-physical-ability", {required: true});
        }

        function removeMemberField(id) {
            if (memberList.children().length == 1) return false;

            let removeField = $(id);
            if (removeField.find('.member_id').length) {
                removeField.find('.delete_status').val(1);
                removeField.hide();
            } else {
                removeField.remove();
            }
        }

        function addLoanField(edit = false, loan = []) {
            let loanTemplate = $('#loan').html();
            let template = lodash_template(loanTemplate);
            loanList.append(template({sl: loanSl++, loan: loan, edit: edit}));
        }

        function removeLoanField(id) {
            let removeField = $(id);
            if (removeField.find('.loan_id').length) {
                removeField.find('.delete_status').val(1);
                removeField.hide();
            } else {
                removeField.remove();
            }
        }

        function generateMemberInjuryLists() {
            allMemberLists = [];

            $(document)
                .find('.member-member-name')
                .each(function () {
                    allMemberLists.push({id: $(this).attr('name'), text: $(this).val()});
                });

            if (injuredFamilyMemberSurveyId.data('select2')) {
                injuredFamilyMemberSurveyId.select2('destroy');
            }
            injuredFamilyMemberSurveyId
                .empty()
                .select2({
                    placeholder: "{{ __('ক্ষতিগ্রস্থ ব্যক্তি') }}",
                    allowClear: true,
                    width: '100%',
                    data: allMemberLists
                });

            @if($edit && optional($survey->surveyPersonInjuryDetail)->familyMemberSurvey)
            let selected = allMemberLists.filter((item) => item.text === '{{optional($survey->surveyPersonInjuryDetail)->familyMemberSurvey->member_name}}');
            injuredFamilyMemberSurveyId
                .val(selected.length ? selected[0].id : null)
                .trigger('change');
            @else
            injuredFamilyMemberSurveyId.val(null).trigger('change');
            @endif

        }

        const relations = ['self', 'husband', 'wife', 'father', 'mother', 'sister', 'brother', 'son', 'daughter', 'nephew'];

        $(document).on('change', '.member-relation-with-head', function (e) {
            let el = $(this);
            let otherSelectInput = $("#" + el.data('sl') + "_relation_with_head_other");
            let otherInput = $("#" + el.data('sl') + "_relation_with_head_other_input");

            if (!relations.includes(el.val())) {
                otherInput.show();
            } else {
                otherSelectInput.attr('value', '');
                otherInput.hide();
            }
        });

        $(document).on("keyup change", ".family_head_name", function () {
            $(".family_head_name").val($(this).val());
        });

        $(document).on('keyup', '.relation-with-head-other-input', function (e) {
            let el = $(this);
            let otherSelectInput = $("#" + el.data('sl') + "_relation_with_head_other");
            otherSelectInput.attr('value', el.val());
            form.valid();
        });

        $(programmeId).on('select2:select', function () {
            let endLocationCenterType = $('option:selected', this).data('end-location-center-type');

            let queries = locVillageWardAshrayanMatrikendroId.data('additional-queries')
            queries.type_of = endLocationCenterType;

            if (typeof endLocationCenterType == 'undefined' || endLocationCenterType === '') {
                delete queries.type_of;
            }
            locVillageWardAshrayanMatrikendroId
                .data('additional-queries', queries)
                .val(null).trigger('change');

            let programmeCode = $('option:selected', this).data('program-code');

            if (typeof programmeCode != 'undefined' && programmeCode === '{{\App\Models\Programme::PROGRAM_CODE_ACID_AND_FIRE_BURN}}') {
                injurySurveySection.show();
            } else {
                injurySurveySection.hide();
            }
        });

        $(programmeId).on('select2:unselect', function () {
            locVillageWardAshrayanMatrikendroId.data('additional-queries', {id: [0]});
            locVillageWardAshrayanMatrikendroId.val(null).trigger('change');
            injurySurveySection.hide();
        });

        if (locUnionMunicipalityId.length) {
            $(locUnionMunicipalityId).on('select2:select', function () {
                locVillageWardAshrayanMatrikendroId.val(null).trigger('change');
            });
            $(locUnionMunicipalityId).on('select2:unselect', function () {
                locVillageWardAshrayanMatrikendroId.val(null).trigger('change');
            });
        }

        @if($edit)
        $(function () {
            setTimeout(() => {
                generateMemberInjuryLists();
            });
        });
        @endif
        $(document).on('keyup paste change', '.member-member-name', function (e) {
            generateMemberInjuryLists();
        })
    </script>

    <script type="text/template" id="loan">
        <tr id="loan_no_<%=sl%>">
            <td>
                <% if(edit && loan.id) { %>
                <input type="hidden" name="data[loans][<%=sl%>][id]" class="loan_id" value="<%= loan.id %>"/>
                <input type="hidden" name="data[loans][<%=sl%>][delete]" class="delete_status" value="0"/>
                <% } %>
                <input type="text" name="data[loans][<%=sl%>][organization_name]" class="form-control"
                       value="<%=edit ? loan.organization_name : ''%>"
                       placeholder="{{__($localPrefix . 'organization_name')}}"/>
            </td>
            <td>
                <input type="text" name="data[loans][<%=sl%>][loan_amount]" class="form-control"
                       value="<%=edit ? loan.loan_amount : ''%>"
                       placeholder="{{__($localPrefix . 'loan_amount')}}"/>
            </td>
            <td>
                <button onclick="removeLoanField('#loan_no_<%=sl%>')" type="button"
                        class="btn pull-right btn-sm btn-danger">
                    <i class="fa fa-times"></i>
                </button>
            </td>
        </tr>
    </script>

    <script type="text/template" id="member_info">
        <div id="member_<%=sl%>" class="self">
            <fieldset class="scheduler-border">
                <legend class="scheduler-border">
                    <label for="">{{ __('Member') }} <%=en2bnNumber(sl)%></label>
                </legend>
                <div class="form-row">
                    <% if(edit && member.id) { %>
                    <input type="hidden" name="data[member_details][<%=sl%>][id]" class="member_id"
                           value="<%= member.id %>"/>
                    <input type="hidden" name="data[member_details][<%=sl%>][delete]" class="delete_status" value="0"/>
                    <% } %>
                    <div class="col-md-4 col-sm-6 mb-3">
                        <div class="form-group">
                            <label for="<%=sl%>_member_name">{{ __($localPrefix . 'member_name') }}</label>
                            <input type="text"
                                   class="form-control member-member-name <%= isHead ? 'family_head_name': ''%>"
                                   value="<%=edit ? member.member_name : ''%>"
                                   id="<%=sl%>_member_name" name="data[member_details][<%=sl%>][member_name]">
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6 mb-3">
                        <div class="form-group">
                            <label
                                for="<%=sl%>_relation_with_head">{{ __($localPrefix . 'relation_with_head') }}</label>
                            <select name="data[member_details][<%=sl%>][relation_with_head]"
                                    id="<%=sl%>_relation_with_head" class="form-control member-relation-with-head"
                                    data-sl="<%=sl%>">
                                <option selected disabled>{{ __('voyager::generic.none') }}</option>
                                <% if(isHead) { %>
                                <option selected value="self">{{ __('Self') }}</option>
                                <% } else { %>
                                <option value="father"
                                <%= edit && member.relation_with_head === 'father' ? 'selected' : ''%>
                                >{{ __('Father') }}</option>
                                <option value="husband"
                                <%= edit && member.relation_with_head === 'husband' ? 'selected' : ''%>
                                >{{ __('Husband') }}</option>
                                <option value="wife"
                                <%= edit && member.relation_with_head === 'wife' ? 'selected' : ''%>
                                >{{ __('Wife') }}</option>
                                <option value="mother"
                                <%= edit && member.relation_with_head === 'mother' ? 'selected' : ''%>
                                >{{ __('Mother') }}</option>
                                <option value="sister"
                                <%= edit && member.relation_with_head === 'sister' ? 'selected' : ''%>
                                >{{ __('Sister') }}</option>
                                <option value="brother"
                                <%= edit && member.relation_with_head === 'brother' ? 'selected' : ''%>
                                >{{ __('Brother') }}</option>
                                <option value="son"
                                <%= edit && member.relation_with_head === 'son' ? 'selected' : ''%>
                                >{{ __('Son') }}</option>
                                <option value="daughter"
                                <%= edit && member.relation_with_head === 'daughter' ? 'selected' : ''%>
                                >{{ __('Daughter') }}</option>
                                <option value="nephew"
                                <%= edit && member.relation_with_head === 'nephew' ? 'selected' : ''%>
                                >{{ __('Nephew') }}</option>
                                <option id="<%=sl%>_relation_with_head_other" value=""
                                <%= edit && !member.relation_with_head ? 'selected' : ''%> >{{ __('Other') }}</option>
                                <% } %>
                            </select>
                            <input type="text" style="display: none" id="<%=sl%>_relation_with_head_other_input"
                                   value="<%=edit ? member.relation_with_head : ''%>"
                                   class="form-control relation-with-head-other-input" data-sl="<%=sl%>">
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6 mb-3">
                        <div class="form-group">
                            <label for="<%=sl%>_gender_selection">{{ __($localPrefix . 'gender') }} :</label>
                            <br>
                            <div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input member-gender" type="radio"
                                    <%=edit && member.gender == 1 ? 'checked' : ''%>
                                    name="data[member_details][<%=sl%>][gender]" id="<%=sl%>_gender_1" value="1">
                                    <label class="form-check-label" for="gender_1">{{ __('পুরুষ') }}</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input member-gender" type="radio"
                                    <%=edit && member.gender == 2 ? 'checked' : ''%>
                                    name="data[member_details][<%=sl%>][gender]" id="<%=sl%>_gender_2" value="2">
                                    <label class="form-check-label" for="gender_2">{{ __('মহিলা') }}</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input member-gender" type="radio"
                                    <%=edit && member.gender == 3 ? 'checked' : ''%>
                                    name="data[member_details][<%=sl%>][gender]" id="<%=sl%>_gender_3" value="3">
                                    <label class="form-check-label" for="gender_3">{{ __('হিজড়া') }}</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2 col-sm-6 mb-3">
                        <div class="form-group">
                            <label for="<%=sl%>_age">{{ __($localPrefix . 'age') }}</label>
                            <div class="input-group">
                                <input type="text" min="0" id="<%=sl%>_age" name="data[member_details][<%=sl%>][age]"
                                       value="<%=edit ? member.age : ''%>"
                                       class="form-control member-age">
                                <div class="input-group-append">
                                    <div class="input-group-text">{{ __('Year') }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-row">
                    <div class="col-md-4 col-sm-6 mb-3">
                        <div class="form-group">
                            <label
                                for="<%=sl%>_educational_qualification">{{ __($localPrefix . 'educational_qualification') }}</label>
                            <input type="text" class="form-control" id="<%=sl%>_educational_qualification"
                                   value="<%=edit ? member.educational_qualification : ''%>"
                                   name="data[member_details][<%=sl%>][educational_qualification]">
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-6 mb-3">
                        <div class="form-group">
                            <label for="<%=sl%>_main_occupation">{{ __($localPrefix . 'main_occupation') }}</label>
                            <input type="text" class="form-control" id="<%=sl%>_main_occupation"
                                   value="<%=edit ? member.main_occupation : ''%>"
                                   name="data[member_details][<%=sl%>][main_occupation]">
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-6 mb-3">
                        <div class="form-group">
                            <label for="<%=sl%>_other_occupation">{{ __($localPrefix . 'other_occupation') }}</label>
                            <input type="text" class="form-control" id="<%=sl%>_other_occupation"
                                   value="<%=edit ? member.other_occupation : ''%>"
                                   name="data[member_details][<%=sl%>][other_occupation]">
                        </div>
                    </div>
                </div>

                <div class="form-row">
                    <div class="col-md-4 col-md-4 mb-3">
                        <div class="form-group">
                            <label for="<%=sl%>_physical_ability">{{ __($localPrefix . 'physical_ability') }} :</label>
                            <select name="data[member_details][<%=sl%>][physical_ability]" id="<%=sl%>_physical_ability"
                                    class="form-control member-physical-ability">
                                <option value="1"
                                <%= edit && member.physical_ability == 1 ? 'selected' : (!edit ? 'selected' : '')%>
                                >{{ __('Capable') }}</option>
                                <option value="2"
                                <%= edit && member.physical_ability == 2 ? 'selected' : ''%>
                                >{{ __('Partially Disabled') }}</option>
                                <option value="3"
                                <%= edit && member.physical_ability == 3 ? 'selected' : ''%>
                                >{{ __('Completely Disabled') }}</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-8 col-md-8 mb-3">
                        <div class="form-group">
                            <label for="<%=sl%>_disable_status">{{ __($localPrefix . 'disable_status') }} :</label>
                            <div class="input-group">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox"
                                           name="data[member_details][<%=sl%>][disable_status][capable]"
                                    <%= edit && member.disable_status.capable ? 'checked' : (!edit ? 'checked' : '')%>
                                    id="<%=sl%>_disable_status1" value="1">
                                    <label class="form-check-label"
                                           for="disable_status1">{{ __($localPrefix . 'capable') }}</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox"
                                           name="data[member_details][<%=sl%>][disable_status][mentally_disabled]"
                                    <%= edit && member.disable_status.mentally_disabled ? 'checked' : ''%>
                                    id="<%=sl%>_disable_status2" value="1">
                                    <label class="form-check-label"
                                           for="disable_status2">{{ __($localPrefix . 'mentally_disabled') }}</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox"
                                           name="data[member_details][<%=sl%>][disable_status][vision_disabled]"
                                    <%= edit && member.disable_status.vision_disabled ? 'checked' : ''%>
                                    id="<%=sl%>_disable_status4" value="1">
                                    <label class="form-check-label"
                                           for="disable_status4">{{ __($localPrefix . 'vision_disabled') }}</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox"
                                           name="data[member_details][<%=sl%>][disable_status][deaf]"
                                    <%= edit && member.disable_status.deaf ? 'checked' : ''%>
                                    id="<%=sl%>_disable_status5" value="1">
                                    <label class="form-check-label"
                                           for="disable_status5">{{ __($localPrefix . 'deaf') }}</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox"
                                           name="data[member_details][<%=sl%>][disable_status][socially_disabled]"
                                    <%= edit && member.disable_status.socially_disabled ? 'checked' : ''%>
                                    id="<%=sl%>_disable_status6" value="1">
                                    <label class="form-check-label"
                                           for="disable_status6">{{ __($localPrefix . 'socially_disabled') }}</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-row">
                    <div class="col-sm-3 mb-3 school_going">
                        <div class="form-group">
                            <label for="<%=sl%>_current_student">{{ __($localPrefix . 'current_student') }} :</label>
                            <br>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio"
                                       name="data[member_details][<%=sl%>][current_student]"
                                <%= edit && member.current_student == 1 ? 'checked' : ''%>
                                id="<%=sl%>_current_student1" value="1">
                                <label class="form-check-label"
                                       for="current_student1">{{ __('voyager::generic.yes') }}</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio"
                                       name="data[member_details][<%=sl%>][current_student]"
                                <%= edit && member.current_student == 0 ? 'checked' : (!edit ? 'checked' : '')%>
                                id="<%=sl%>_current_student2" value="0">
                                <label class="form-check-label"
                                       for="current_student2">{{ __('voyager::generic.no') }}</label>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-3 mb-3">
                        <div class="form-group">
                            <label for="<%=sl%>_married_or_not">{{ __($localPrefix . 'is_married') }} :</label>
                            <br>

                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio"
                                       name="data[member_details][<%=sl%>][is_married]" id="<%=sl%>_is_married_1"
                                <%= edit && member.is_married == 1 ? 'checked' : (!edit ? 'checked' : '')%>
                                value="1">
                                <label class="form-check-label" for="is_married_1">{{ __('Married') }}</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio"
                                       name="data[member_details][<%=sl%>][is_married]" id="<%=sl%>_is_married_2"
                                <%= edit && !member.is_married ? 'checked' : ''%>
                                value="0">
                                <label class="form-check-label" for="is_married_2">{{ __('Unmarried') }}</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-3 mb-3">
                        <div class="form-group">
                            <label for="<%=sl%>_fertile">{{ __($localPrefix . 'fertile') }} :</label>
                            <br>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio"
                                <%= edit && member.fertile ? 'checked' : (!edit ? 'checked' : '')%>
                                name="data[member_details][<%=sl%>][fertile]" id="<%=sl%>_fertile1" value="1">
                                <label class="form-check-label" for="fertile1">{{ __('voyager::generic.yes') }}</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio"
                                <%= edit && !member.fertile ? 'checked' : ''%>
                                name="data[member_details][<%=sl%>][fertile]" id="<%=sl%>_fertile2" value="0">
                                <label class="form-check-label" for="fertile2">{{ __('voyager::generic.no') }}</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-3 mb-3 family_planning">
                        <div class="form-group">
                            <label for="<%=sl%>_family_plan">{{ __($localPrefix . 'family_plan') }} :</label>
                            <select name="data[member_details][<%=sl%>][family_plan]" id="<%=sl%>_family_plan"
                                    class="form-control">
                                <option value="0"
                                <%= edit && !member.family_plan ? 'selected' : (!edit ? 'selected' : '')%>
                                >{{ __('voyager::generic.no') }}</option>
                                <option value="2"
                                <%= edit && member.family_plan == 2 ? 'selected' : ''%> >{{ __('Temporary') }}</option>
                                <option value="1"
                                <%= edit && member.family_plan == 1 ? 'selected' : ''%> >{{ __('Permanent') }}</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-md-8 col-md-8 mb-3">
                        <div class="form-group">
                            <label for="<%=sl%>_vaccination">{{ __($localPrefix . 'vaccination') }} :</label>
                            <div class="input-group">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox"
                                           name="data[member_details][<%=sl%>][vaccination][dpt]"
                                    <%= edit && member.vaccination.dpt ? 'checked' : ''%>
                                    id="<%=sl%>_vaccination1" value="1">
                                    <label class="form-check-label" for="vaccination1">{{ __('DPT') }}</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox"
                                           name="data[member_details][<%=sl%>][vaccination][polio]"
                                    <%= edit && member.vaccination.polio ? 'checked' : ''%>
                                    id="<%=sl%>_vaccination2" value="1">
                                    <label class="form-check-label" for="vaccination2">{{ __('Polio') }}</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox"
                                           name="data[member_details][<%=sl%>][vaccination][hum]"
                                    <%= edit && member.vaccination.hum ? 'checked' : ''%>
                                    id="<%=sl%>_vaccination3" value="1">
                                    <label class="form-check-label" for="vaccination3">{{ __('Hum') }}</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox"
                                           name="data[member_details][<%=sl%>][vaccination][bcg]"
                                    <%= edit && member.vaccination.bcg ? 'checked' : ''%>
                                    id="<%=sl%>_vaccination4" value="1">
                                    <label class="form-check-label" for="vaccination4">{{ __('BCG') }}</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox"
                                           name="data[member_details][<%=sl%>][vaccination][tt]"
                                    <%= edit && member.vaccination.tt ? 'checked' : ''%>
                                    id="<%=sl%>_vaccination5" value="1">
                                    <label class="form-check-label" for="vaccination5">{{ __('TT') }}</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <% if(!isHead) { %>
                <button onclick="removeMemberField('#member_<%=sl%>')" type="button"
                        class="btn btn-danger px-3 float-right mx-2"><i class="fa fa-times"></i></button>
                <% } %>
            </fieldset>
        </div>
    </script>
@stop
