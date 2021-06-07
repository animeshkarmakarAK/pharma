@extends('voyager::master')
@php
    $title = __('teammanagement::survey.survey');
    $localPrefix = 'teammanagement::survey.';
    $edit = false;
@endphp
@section('page_title', $title)

@section('css')
    <style>
        .view-list .view-item {
            border-bottom: 1px solid #eee;
        }
        input[type="checkbox"] {
            visibility: hidden;
        }
        label {
            cursor: pointer;
        }
        input[type="checkbox"] + label:before {
            content: "\00a0";
            display: inline-block;
            font: 16px/1em sans-serif;
            height: 16px;
            margin: 0 .25em 0 0;
            padding: 0;
            vertical-align: top;
            width: 16px;
        }
        input[type="checkbox"]:checked + label:before {
            background: #fff;
            color: #333;
            content: "\2713";
            text-align: center;
        }
        input[type="checkbox"]:checked + label:after {
            font-weight: bold;
        }
        input[type="radio"] {
            visibility: hidden;
        }
        label {
            cursor: pointer;
        }
        input[type="radio"] + label:before {
            content: "\00a0";
            display: inline-block;
            font: 16px/1em sans-serif;
            height: 16px;
            margin: 0 .25em 0 0;
            padding: 0;
            vertical-align: top;
            width: 16px;
        }
        input[type="radio"]:checked + label:before {
            background: #fff;
            color: #333;
            content: "\2713";
            text-align: center;
        }
        input[type="radio"]:checked + label:after {
            font-weight: bold;
        }
    </style>
@stop
@php
    /** @var \App\Models\User $authUser */
        $authUser = auth()->user();
@endphp
@section('page_header')
    <h1 class="page-title">
        <i class="fa fa-eye"></i>
        {{ $title }}
    </h1>
@stop
@section('content')
    <div id="app" class="page-content container-fluid">
        <div class="panel panel-bordered">
            <div class="panel-heading">
                <h4 class="panel-title">{{ __('Family Survey Form') }}</h4>

                <a href="{{ route('survey.index') }}" class="btn btn-default btn-sm">
                    <span class="fa fa-backward"></span>&nbsp;
                    {{ __('voyager::generic.back') }}
                </a>
            </div>
            <div class="panel-body">
                <div class="row p-2">
                    <div class="col-md-12">
                        <fieldset class="scheduler-border">
                            <legend class="scheduler-border">
                                <label for="">{{ __('Family Head Information') }} :</label>
                            </legend>
                            <div class="row">
                                <div class="col-md-6 view-item">
                                    <h6 class="view-item-title">{{ __($localPrefix . 'programme_id') }}:</h6>
                                    <div
                                        class="view-item-data">{{optional($survey->programme)->title_en}}</div>
                                </div>
                                @if($authUser->isUpazilaOffice())
                                    <div class="col-md-6 view-item">
                                        <h6 class="view-item-title">{{ __($localPrefix . 'loc_union_municipality_id') }}
                                            :</h6>
                                        <div class="view-item-data">{{optional($survey->locUnionMunicipality)->title_en}}</div>
                                    </div>
                                @endif
                                <div class="col-md-6 view-item">
                                    <h6 class="view-item-title">{{ __($localPrefix . 'loc_village_ward_ashrayan_matrikendro_id') }}
                                        :</h6>
                                    <div class="view-item-data">{{optional($survey->locVillageWardAshrayanMatrikendro)->title_en}}</div>
                                </div>
                                <div class="col-md-6 view-item">
                                    <h6 class="view-item-title">{{ __($localPrefix . 'house_no') }}:</h6>
                                    <div class="view-item-data">{{$survey->house_no}}</div>
                                </div>
                                <div class="col-md-6 view-item">
                                    <h6 class="view-item-title">{{ __($localPrefix . 'road_no') }}:</h6>
                                    <div class="view-item-data">{{$survey->road_no}}</div>
                                </div>
                                <div class="col-md-6 view-item">
                                    <h6 class="view-item-title">{{ __($localPrefix . 'area_detail') }}:</h6>
                                    <div class="view-item-data">{{$survey->area_detail}}</div>
                                </div>
                                <div class="col-md-6 view-item">
                                    <h6 class="view-item-title">{{ __($localPrefix . 'family_head_name') }}
                                        :</h6>
                                    <div class="view-item-data">{{$survey->family_head_name}}</div>
                                </div>
                                <div class="col-md-6 view-item">
                                    <h6 class="view-item-title">{{ __($localPrefix . 'nid') }}:</h6>
                                    <div class="view-item-data">{{$survey->nid}}</div>
                                </div>
                                <div class="col-md-6 view-item">
                                    <h6 class="view-item-title">{{ __($localPrefix . 'father_spouse') }}:</h6>
                                    <div class="view-item-data">{{$survey->father_spouse}}</div>
                                </div>
                                <div class="col-md-6 view-item">
                                    <h6 class="view-item-title">{{ __($localPrefix . 'religion') }}:</h6>
                                    <div class="view-item-data">{{$survey->religion}}</div>
                                </div>
                            </div>
                        </fieldset>
                    </div>
                </div>

                <div class="row p-2">
                    <div class="col-md-12">
                        <fieldset class="scheduler-border">
                            <legend class="scheduler-border">
                                <label for="">{{ __('Family Information') }} :</label>
                            </legend>
                            @if($survey->familyMemberSurveys)
                                @foreach($survey->familyMemberSurveys as $sl => $familyMember)
                                    <fieldset class="scheduler-border">
                                        <legend class="scheduler-border">
                                            <label for="">
                                                {{ __('Member') . ' '. (++$sl) . ($familyMember->relation_with_head === \Module\TeamManagement\Models\FamilyMemberSurvey::RELATION_SELF ?  ' (' .__($localPrefix . 'family_head_name') . ')' : '') }} </label>
                                        </legend>
                                        <div class="row">
                                            <div class="col-md-6 view-item">
                                                <h6 class="view-item-title">{{ __($localPrefix . 'member_name') }}
                                                    :</h6>
                                                <div class="view-item-data">{{$familyMember->member_name}}</div>
                                            </div>
                                            <div class="col-md-6 view-item">
                                                <h6 class="view-item-title">{{ __($localPrefix . 'relation_with_head') }}
                                                    :</h6>
                                                <div
                                                    class="view-item-data">{{\Illuminate\Support\Str::ucfirst($familyMember->relation_with_head)}}</div>
                                            </div>
                                            <div class="col-md-6 view-item">
                                                <h6 class="view-item-title">{{ __($localPrefix . 'gender') }}
                                                    :</h6>
                                                <div
                                                    class="view-item-data">{{ getGender($familyMember->gender) }}</div>
                                            </div>
                                            <div class="col-md-6 view-item">
                                                <h6 class="view-item-title">{{ __($localPrefix . 'age') }}:</h6>
                                                <div
                                                    class="view-item-data">{{$familyMember->age}} {{ __('Year') }}</div>
                                            </div>
                                            <div class="col-md-6 view-item">
                                                <h6 class="view-item-title">{{ __($localPrefix . 'educational_qualification') }}
                                                    :</h6>
                                                <div
                                                    class="view-item-data">{{$familyMember->educational_qualification}}</div>
                                            </div>
                                            <div class="col-md-6 view-item">
                                                <h6 class="view-item-title">{{ __($localPrefix . 'main_occupation') }}
                                                    :</h6>
                                                <div
                                                    class="view-item-data">{{$familyMember->main_occupation}}</div>
                                            </div>
                                            <div class="col-md-6 view-item">
                                                <h6 class="view-item-title">{{ __($localPrefix . 'other_occupation') }}
                                                    :</h6>
                                                <div
                                                    class="view-item-data">{{$familyMember->other_occupation}}</div>
                                            </div>
                                            <div class="col-md-6 view-item">
                                                <h6 class="view-item-title">{{ __($localPrefix . 'physical_ability') }}
                                                    :</h6>
                                                <div
                                                    class="view-item-data">{{getPhysicalAbility($familyMember->physical_ability)}}</div>
                                            </div>
                                            <div class="col-md-6 view-item">
                                                <h6 class="view-item-title">{{ __($localPrefix . 'disable_status') }}
                                                    :</h6>
                                                <div
                                                    class="view-item-data">{{printDisableStatus($familyMember->disable_status)}}</div>
                                            </div>
                                            <div class="col-md-6 view-item">
                                                <h6 class="view-item-title">{{ __($localPrefix . 'current_student') }}
                                                    :</h6>
                                                <div
                                                    class="view-item-data">{{__($familyMember->current_student ? 'Yes': 'No')}}</div>
                                            </div>
                                            <div class="col-md-6 view-item">
                                                <h6 class="view-item-title">{{ __($localPrefix . 'is_married') }}
                                                    :</h6>
                                                <div
                                                    class="view-item-data">{{__($familyMember->is_married ? 'Yes': 'No')}}</div>
                                            </div>
                                            <div class="col-md-6 view-item">
                                                <h6 class="view-item-title">{{ __($localPrefix . 'fertile') }}
                                                    :</h6>
                                                <div
                                                    class="view-item-data">{{__($familyMember->fertile ?'Yes':'No')}}</div>
                                            </div>
                                            <div class="col-md-6 view-item">
                                                <h6 class="view-item-title">{{ __($localPrefix . 'family_plan') }}
                                                    :</h6>
                                                <div
                                                    class="view-item-data">{{getFamilyPlan($familyMember->family_plan)}}</div>
                                            </div>
                                            @if($familyMember->vaccination)
                                                <div class="col-md-6 view-item">
                                                    <h6 class="view-item-title">{{ __($localPrefix . 'vaccination') }}
                                                        :</h6>
                                                    <div
                                                        class="view-item-data">{{printVaccination($familyMember->vaccination)}}</div>
                                                </div>
                                            @endif
                                        </div>
                                    </fieldset>
                                @endforeach
                            @endif
                        </fieldset>
                    </div>
                </div>

                <div class="row p-2">
                    <div class="col-md-12">
                        <fieldset class="scheduler-border">
                            <legend class="scheduler-border">
                                <label for="">{{ __('Land Property') }} :</label>
                            </legend>
                            <div class="row">
                                <div class="col-md-6 view-item">
                                    <h6 class="view-item-title">{{ __($localPrefix . 'house_land') }}:</h6>
                                    <div
                                        class="view-item-data">{{optional($survey->familyLandSurvey)->house_land}} {{__('Shotangsa')}}</div>
                                </div>
                                <div class="col-md-6 view-item">
                                    <h6 class="view-item-title">{{ __($localPrefix . 'farmland_own') }}:</h6>
                                    <div
                                        class="view-item-data">{{optional($survey->familyLandSurvey)->farmland_own}} {{__('Shotangsa')}}</div>
                                </div>
                                <div class="col-md-6 view-item">
                                    <h6 class="view-item-title">{{ __($localPrefix . 'farmland_lease') }}:</h6>
                                    <div
                                        class="view-item-data">{{optional($survey->familyLandSurvey)->farmland_lease}} {{__('Shotangsa')}}</div>
                                </div>
                                <div class="col-md-6 view-item">
                                    <h6 class="view-item-title">{{ __($localPrefix . 'pond_arable') }}:</h6>
                                    <div
                                        class="view-item-data">{{optional($survey->familyLandSurvey)->pond_arable}} {{__('Shotangsa')}}</div>
                                </div>
                                <div class="col-md-6 view-item">
                                    <h6 class="view-item-title">{{ __($localPrefix . 'pond_non_arable') }}:</h6>
                                    <div
                                        class="view-item-data">{{optional($survey->familyLandSurvey)->pond_non_arable}} {{__('Shotangsa')}}</div>
                                </div>
                                <div class="col-md-6 view-item">
                                    <h6 class="view-item-title">{{ __($localPrefix . 'other') }}:</h6>
                                    <div
                                        class="view-item-data">{{optional($survey->familyLandSurvey)->other}} {{__('Shotangsa')}}</div>
                                </div>
                            </div>
                        </fieldset>
                    </div>
                </div>

                <div class="row p-2">
                    <div class="col-md-12">
                        <fieldset class="scheduler-border">
                            <legend class="scheduler-border">
                                <label for="">{{ __('পশু সম্পদ') }} :</label>
                            </legend>
                            <div class="row">
                                <div class="col-md-6 view-item">
                                    <h6 class="view-item-title">{{ __($localPrefix . 'cow') }}:</h6>
                                    <div
                                        class="view-item-data">{{optional($survey->familyLivestockSurvey)->cow}}</div>
                                </div>
                                <div class="col-md-6 view-item">
                                    <h6 class="view-item-title">{{ __($localPrefix . 'buffalo') }}:</h6>
                                    <div
                                        class="view-item-data">{{optional($survey->familyLivestockSurvey)->buffalo}}</div>
                                </div>
                                <div class="col-md-6 view-item">
                                    <h6 class="view-item-title">{{ __($localPrefix . 'goat') }}:</h6>
                                    <div
                                        class="view-item-data">{{optional($survey->familyLivestockSurvey)->goat}}</div>
                                </div>
                                <div class="col-md-6 view-item">
                                    <h6 class="view-item-title">{{ __($localPrefix . 'hen') }}:</h6>
                                    <div
                                        class="view-item-data">{{optional($survey->familyLivestockSurvey)->hen}}</div>
                                </div>
                                <div class="col-md-6 view-item">
                                    <h6 class="view-item-title">{{ __($localPrefix . 'other') }}:</h6>
                                    <div
                                        class="view-item-data">{{optional($survey->familyLivestockSurvey)->other}}</div>
                                </div>
                            </div>
                        </fieldset>
                    </div>
                </div>

                <div class="row p-2">
                    <div class="col-md-12">
                        <fieldset class="scheduler-border">
                            <legend class="scheduler-border">
                                <label for="">{{ __('Annual Income') }} :</label>
                            </legend>
                            <div class="row">
                                <div class="col-md-6 view-item">
                                    <h6 class="view-item-title">{{ __($localPrefix . 'cow') }}:</h6>
                                    <div
                                        class="view-item-data">&#2547; {{optional($survey->familySanitationSurvey)->land_crop}}</div>
                                </div>
                                <div class="col-md-6 view-item">
                                    <h6 class="view-item-title">{{ __($localPrefix . 'vegetable_fruit') }}:</h6>
                                    <div
                                        class="view-item-data">&#2547; {{optional($survey->familyAnnualIncomeSurvey)->vegetable_fruit}}</div>
                                </div>
                                <div class="col-md-6 view-item">
                                    <h6 class="view-item-title">{{ __($localPrefix . 'livestock') }}:</h6>
                                    <div
                                        class="view-item-data">&#2547; {{optional($survey->familyAnnualIncomeSurvey)->livestock}}</div>
                                </div>
                                <div class="col-md-6 view-item">
                                    <h6 class="view-item-title">{{ __($localPrefix . 'pond') }}:</h6>
                                    <div
                                        class="view-item-data">&#2547; {{optional($survey->familyAnnualIncomeSurvey)->pond}}</div>
                                </div>
                                <div class="col-md-6 view-item">
                                    <h6 class="view-item-title">{{ __($localPrefix . 'job') }}:</h6>
                                    <div
                                        class="view-item-data">&#2547; {{optional($survey->familyAnnualIncomeSurvey)->job}}</div>
                                </div>
                                <div class="col-md-6 view-item">
                                    <h6 class="view-item-title">{{ __($localPrefix . 'other') }}:</h6>
                                    <div
                                        class="view-item-data">&#2547; {{optional($survey->familyAnnualIncomeSurvey)->other}}</div>
                                </div>
                            </div>
                        </fieldset>
                    </div>
                </div>

                <div class="row p-2">
                    <div class="col-md-12">
                        <fieldset class="scheduler-border">
                            <legend class="scheduler-border">
                                <label for="">{{__('House')}}</label>
                            </legend>
                            <div class="row">
                                <div class="col-md-6 view-item">
                                    <h6 class="view-item-title">{{ __($localPrefix . 'ripe_house')}}:</h6>
                                    <div class="view-item-data">
                                        {{__('Self')}}
                                        : {{optional($survey->familySanitationSurvey)->ripe_house_own}}
                                        &nbsp; &nbsp;
                                        {{__('Rent')}}
                                        : {{optional($survey->familySanitationSurvey)->ripe_house_rent}}
                                    </div>
                                </div>
                                <div class="col-md-6 view-item">
                                    <h6 class="view-item-title">{{ __($localPrefix . 'semi_ripe_house')}}:</h6>
                                    <div class="view-item-data">
                                        {{__('Self')}}
                                        : {{optional($survey->familySanitationSurvey)->semi_ripe_house_own}}
                                        &nbsp; &nbsp;
                                        {{__('Rent')}}
                                        : {{optional($survey->familySanitationSurvey)->semi_ripe_house_rent}}
                                    </div>
                                </div>
                                <div class="col-md-6 view-item">
                                    <h6 class="view-item-title">{{ __($localPrefix . 'tin_house')}}:</h6>
                                    <div class="view-item-data">
                                        {{__('Self')}}
                                        : {{optional($survey->familySanitationSurvey)->tin_house_own}}
                                        &nbsp; &nbsp;
                                        {{__('Rent')}}
                                        : {{optional($survey->familySanitationSurvey)->tin_house_rent}}
                                    </div>
                                </div>
                                <div class="col-md-6 view-item">
                                    <h6 class="view-item-title">{{ __($localPrefix . 'hut')}}:</h6>
                                    <div class="view-item-data">
                                        {{__('Self')}}
                                        : {{optional($survey->familySanitationSurvey)->hut_own}} &nbsp;
                                        &nbsp;
                                        {{__('Rent')}}
                                        : {{optional($survey->familySanitationSurvey)->hut_rent}}
                                    </div>
                                </div>
                            </div>
                        </fieldset>
                    </div>
                </div>

                <div class="row p-2">
                    <div class="col-md-12">
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
                                    <div class="form-row">
                                        <div class="col-md-6 col-sm-6">
                                            <div class="form-group">
                                                <label for="">{{ __($localPrefix . 'toilet_type') }}:</label>
                                                <br>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio"
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
                    </div>
                </div>

                <div class="row p-2">
                    <div class="col-md-12">
                        <fieldset class="scheduler-border">
                            <legend class="scheduler-border">
                                <label for="">{{__('Loan Information')}}</label>
                            </legend>
                            <div class="form-row">
                                <div id="loan-list" class="col-md-12">
                                    <table
                                        class="table table-striped table-bordered">
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
                                        @foreach($survey->familyLoanSurvey as $loan)
                                            <td>{{$loan->organization_name}}</td>
                                            <td>{{$loan->loan_amount}}</td>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </fieldset>
                    </div>
                </div>
                @if(optional($survey->programme)->program_code == \App\Models\programme::PROGRAM_CODE_ACID_AND_FIRE_BURN)
                    <fieldset class="scheduler-border" id="injury_survey_section">
                        <legend class="scheduler-border">
                            <label for="">{{__('এসিড সহিংসতা/দগ্ধ/দুর্ঘটনার কারনে ক্ষতিগ্রস্থ/প্রতিবন্ধী ব্যক্তির বিবরণ (যদি থাকে)')}}</label>
                        </legend>
                        <div class="form-row">
                            <div class="col-md-4 col-sm-6">
                                <div class="form-group">
                                    <label for="injured_family_member_survey_id">{{ __('ক্ষতিগ্রস্থ ব্যক্তি') }}</label>
                                    <div>{{optional(optional($survey->surveyPersonInjuryDetail)->familyMemberSurvey)->member_name}}</div>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-6">
                                <div class="form-group">
                                    <label for="injury_date">{{ __('ক্ষতিগ্রস্থ হওয়ার তারিখ') }}</label>
                                    <input type="text" class="form-control flat-date injury-date"
                                           id="injury_date"
                                           name="data[survey_person_injury_detail][injury_date]"
                                           value="{{optional(optional($survey->surveyPersonInjuryDetail)->injury_date)->format('Y-m-d')}}"
                                           placeholder="{{ __('ক্ষতিগ্রস্থ হওয়ার তারিখ') }}">
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-6">
                                <div class="form-group">
                                    <label for="injury_reason">{{ __('ক্ষতিগ্রস্থ হওয়ার কারণ') }}</label>
                                    <div class="input-group">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input injury-reason" type="radio"
                                                   name="data[survey_person_injury_detail][injury_reason]"
                                                   {{$survey->surveyPersonInjuryDetail->injury_reason == Module\TeamManagement\Models\SurveyPersonInjuryDetail::INJURY_REASON_BY_BORN ? 'checked' : ''}}
                                                   id="injury_reason_by_bor" value="1">
                                            <label class="form-check-label"
                                                   for="injury_reason_by_bor">{{__('জন্মগত')}}</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input injury-reason" type="radio"
                                                   name="data[survey_person_injury_detail][injury_reason]"
                                                   {{$survey->surveyPersonInjuryDetail->injury_reason == Module\TeamManagement\Models\SurveyPersonInjuryDetail::INJURY_REASON_ACID_BURN ? 'checked' : ''}}
                                                   id="injury_reason_acid_burn" value="2">
                                            <label class="form-check-label"
                                                   for="injury_reason_acid_burn">{{__('এসিডদগ্ধ')}}</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input injury-reason" type="radio"
                                                   name="data[survey_person_injury_detail][injury_reason]"
                                                   {{$survey->surveyPersonInjuryDetail->injury_reason == Module\TeamManagement\Models\SurveyPersonInjuryDetail::INJURY_REASON_FIRE_BURN ? 'checked' : ''}}
                                                   id="injury_reason_fire_burn" value="3">
                                            <label class="form-check-label"
                                                   for="injury_reason_fire_burn">{{__('অগ্নিদগ্ধ')}}</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input injury-reason" type="radio"
                                                   name="data[survey_person_injury_detail][injury_reason]"
                                                   {{$survey->surveyPersonInjuryDetail->injury_reason == Module\TeamManagement\Models\SurveyPersonInjuryDetail::INJURY_REASON_OTHER ? 'checked' : ''}}
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
                                    <label for="injury_types">{{ __('ক্ষতিগ্রস্থ ব্যক্তির শারীরিক ক্ষয়ক্ষতির ধরণ') }}</label>
                                    <div class="input-group">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input injury_types" type="checkbox"
                                                   name="data[survey_person_injury_detail][injury_types][physical]"
                                                   {{!empty($survey->surveyPersonInjuryDetail->injury_types['physical']) && $survey->surveyPersonInjuryDetail->injury_types['physical'] ? 'checked' : ''}}
                                                   id="injury_types_physical" value="1">
                                            <label class="form-check-label"
                                                   for="injury_types_physical">{{__('শারীরিক')}}</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input injury_types" type="checkbox"
                                                   name="data[survey_person_injury_detail][injury_types][mental]"
                                                   {{!empty($survey->surveyPersonInjuryDetail->injury_types['mental']) && $survey->surveyPersonInjuryDetail->injury_types['mental'] ? 'checked' : ''}}
                                                   id="injury_types_mental" value="1">
                                            <label class="form-check-label"
                                                   for="injury_types_mental">{{__('মানসিক')}}</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input injury_types" type="checkbox"
                                                   name="data[survey_person_injury_detail][injury_types][vision]"
                                                   {{!empty($survey->surveyPersonInjuryDetail->injury_types['vision']) && $survey->surveyPersonInjuryDetail->injury_types['vision'] ? 'checked' : ''}}
                                                   id="injury_types_vision" value="1">
                                            <label class="form-check-label"
                                                   for="injury_types_vision">{{__('দৃষ্টি')}}</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input injury_types" type="checkbox"
                                                   name="data[survey_person_injury_detail][injury_types][speech_and_hearing]"
                                                   {{!empty($survey->surveyPersonInjuryDetail->injury_types['speech_and_hearing']) && $survey->surveyPersonInjuryDetail->injury_types['speech_and_hearing'] ? 'checked' : ''}}
                                                   id="injury_types_speech_and_hearing" value="1">
                                            <label class="form-check-label"
                                                   for="injury_types_speech_and_hearing">{{__('বাক ও শ্রবণ')}}</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input injury_types" type="checkbox"
                                                   name="data[survey_person_injury_detail][injury_types][other]"
                                                   {{!empty($survey->surveyPersonInjuryDetail->injury_types['other']) && $survey->surveyPersonInjuryDetail->injury_types['other'] ? 'checked' : ''}}
                                                   id="injury_types_other" value="1">
                                            <label class="form-check-label"
                                                   for="injury_types_other">{{__('বহু মাত্রিক')}}</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-6">
                                <div class="form-group">
                                    <label for="annual_income_other">{{ __('ক্ষতিগ্রস্থ ব্যক্তির শারীরিক ক্ষতিগ্রস্থতার অবস্থা') }}</label>
                                    <div class="input-group">
                                        <div class="form-check form-check-inline injury_level">
                                            <input class="form-check-input" type="radio"
                                                   name="data[survey_person_injury_detail][injury_level]"
                                                   {{$survey->surveyPersonInjuryDetail->injury_level == Module\TeamManagement\Models\SurveyPersonInjuryDetail::INJURY_LEVEL_SLIGHTLY ? 'checked' : ''}}
                                                   id="injury_level_slightly" value="1">
                                            <label class="form-check-label"
                                                   for="injury_level_slightly">{{__('মৃদু')}}</label>
                                        </div>
                                        <div class="form-check form-check-inline injury_level">
                                            <input class="form-check-input" type="radio"
                                                   name="data[survey_person_injury_detail][injury_level]"
                                                   {{$survey->surveyPersonInjuryDetail->injury_level == Module\TeamManagement\Models\SurveyPersonInjuryDetail::INJURY_LEVEL_MEDIUM ? 'checked' : ''}}
                                                   id="injury_level_medium" value="2">
                                            <label class="form-check-label"
                                                   for="injury_level_medium">{{__('মাঝারী')}}</label>
                                        </div>
                                        <div class="form-check form-check-inline injury_level">
                                            <input class="form-check-input" type="radio"
                                                   name="data[survey_person_injury_detail][injury_level]"
                                                   {{$survey->surveyPersonInjuryDetail->injury_level == Module\TeamManagement\Models\SurveyPersonInjuryDetail::INJURY_LEVEL_EXTREMELY ? 'checked' : ''}}
                                                   id="injury_level_extreemly" value="3">
                                            <label class="form-check-label"
                                                   for="injury_level_extreemly">{{__('তীব্র')}}</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-6">
                                <div class="form-group">
                                    <label for="annual_income_other">{{ __('ক্ষতিগ্রস্থ ব্যক্তির চিকিৎসা সংক্রান্ত তথ্য') }}</label>
                                    <div class="input-group">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input is_taken_treatment" type="checkbox"
                                                   name="data[survey_person_injury_detail][is_taken_treatment]"
                                                   {{$survey->surveyPersonInjuryDetail->is_taken_treatment ? 'checked' : ''}}
                                                   id="is_taken_treatment" value="1">
                                            <label class="form-check-label"
                                                   for="is_taken_treatment">{{__('চিকিৎসা নেয়া হয়েছে') }}</label>
                                        </div>
                                    </div>
                                    <div class="input-group">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input is_treatment_needed" type="checkbox"
                                                   name="data[survey_person_injury_detail][is_treatment_needed]"
                                                   {{$survey->surveyPersonInjuryDetail->is_treatment_needed ? 'checked' : ''}}
                                                   id="is_treatment_needed" value="1">
                                            <label class="form-check-label"
                                                   for="is_treatment_needed">{{__('আরো চিকিৎসা প্রয়োজন আছে') }}</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4 col-sm-6">
                                <div class="form-group">
                                    <label for="annual_income_other">{{ __('ক্ষতিগ্রস্থ ব্যক্তির উপার্জন, প্রশিক্ষণ, আয় বর্ধক ও অন্যান্য তথ্য') }}</label>
                                    <div class="input-group">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox"
                                                   name="data[survey_person_injury_detail][income_and_other_info][earning_person]"
                                                   {{!empty($survey->surveyPersonInjuryDetail->income_and_other_info['earning_person']) && $survey->surveyPersonInjuryDetail->income_and_other_info['earning_person'] ? 'checked' : ''}}
                                                   id="earning_person" value="1">
                                            <label class="form-check-label"
                                                   for="earning_person">{{__('পরিবারের উপার্জনশী ব্যক্তি') }}</label>
                                        </div>
                                    </div>
                                    <div class="input-group">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox"
                                                   name="data[survey_person_injury_detail][income_and_other_info][family_depend_on_person]"
                                                   {{!empty($survey->surveyPersonInjuryDetail->income_and_other_info['family_depend_on_person']) && $survey->surveyPersonInjuryDetail->income_and_other_info['family_depend_on_person'] ? 'checked' : ''}}
                                                   id="family_depend_on_person" value="1">
                                            <label class="form-check-label"
                                                   for="family_depend_on_person">{{__('তার উপর পরিবার নির্ভরশীল') }}</label>
                                        </div>
                                    </div>
                                    <div class="input-group">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox"
                                                   name="data[survey_person_injury_detail][income_and_other_info][has_vocational_training]"
                                                   {{!empty($survey->surveyPersonInjuryDetail->income_and_other_info['has_vocational_training']) && $survey->surveyPersonInjuryDetail->income_and_other_info['has_vocational_training'] ? 'checked' : ''}}
                                                   id="has_vocational_training" value="1">
                                            <label class="form-check-label"
                                                   for="has_vocational_training">{{__('বৃত্তিমূলক প্রশিক্ষন আছে') }}</label>
                                        </div>
                                    </div>
                                    <div class="input-group">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox"
                                                   name="data[survey_person_injury_detail][income_and_other_info][interested_in_income]"
                                                   {{!empty($survey->surveyPersonInjuryDetail->income_and_other_info['interested_in_income']) && $survey->surveyPersonInjuryDetail->income_and_other_info['interested_in_income'] ? 'checked' : ''}}
                                                   id="interested_in_income" value="1">
                                            <label class="form-check-label"
                                                   for="interested_in_income">{{__('আয় বর্ধক কাজ করতে আগ্রহী') }}</label>
                                        </div>
                                    </div>
                                    <div class="input-group">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox"
                                                   name="data[survey_person_injury_detail][income_and_other_info][requires_financial_support]"
                                                   {{!empty($survey->surveyPersonInjuryDetail->income_and_other_info['requires_financial_support']) && $survey->surveyPersonInjuryDetail->income_and_other_info['requires_financial_support'] ? 'checked' : ''}}
                                                   id="requires_financial_support" value="1">
                                            <label class="form-check-label"
                                                   for="requires_financial_support">{{__('এ কাজে আর্থিক সহায়তার প্রয়োজন') }}</label>
                                        </div>
                                    </div>
                                    <div class="input-group">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox"
                                                   name="data[survey_person_injury_detail][income_and_other_info][member_of_targeted_family]"
                                                   {{!empty($survey->surveyPersonInjuryDetail->income_and_other_info['member_of_targeted_family']) && $survey->surveyPersonInjuryDetail->income_and_other_info['member_of_targeted_family'] ? 'checked' : ''}}
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
        </div>
    </div>
@stop

@push('javascript')
    <script>
        $(function () {
            $('input').prop('disabled', true);
        });
    </script>
@endpush
