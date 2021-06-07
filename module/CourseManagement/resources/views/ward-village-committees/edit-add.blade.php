@php
    $edit = isset($committee->id);
    $title = __('Ward/Village Committee ' . ($edit ? 'Edit' : 'Add'));

    /** @var \App\Models\User $authUser */
    $authUser = auth()->user();
@endphp
@extends('voyager::master')

@section('page_title', $title)

@section('css')
    <style>
        .dynamic-list {
            border: 1px dashed #cfcfcf;
            position: relative;
            margin-bottom: 1rem;
            padding: 1rem;
        }
        .dynamic-list .remove-row {
            position: absolute;
            top: -5px;
            right: 0;
        }
    </style>
@stop

@section('page_header')
    <h1 class="page-title">
        <i class="fa fa-pencil-square-o"></i>
        {{ $title }}

        @can('browse', \Module\TeamManagement\Models\WardVillageCommittee::class)
            <a href="{{ route('ward-village-committees.index') }}" class="btn btn-sm btn-warning">
                <span class="fa fa-backward"></span>&nbsp;
                {{ __('voyager::generic.back') }}
            </a>
        @endcan
    </h1>
@stop

@section('content')
    <div class="page-content container-fluid">
        <div class="row justify-content-center">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <form class="form-edit-add repeater" role="form" id="form_add_edit"
                              action="{{$edit ? route('ward-village-committees.update', $committee->id) : route('ward-village-committees.store')}}"
                              method="POST" enctype="multipart/form-data" autocomplete="off">
                            <!-- PUT Method if we are editing -->
                            @if($edit)
                                {{ method_field("PUT") }}
                            @endif
                            @csrf
                            <div class="row mb-3">
                                <div class="col-sm-6 col-md-4">
                                    <div class="form-group">
                                        <label
                                                for="programme_id">{{ __($localPrefix . 'programme_id') }}</label>
                                        <select class="form-control select2"
                                                {{$edit ? 'disabled':''}}
                                                name="programme_id"
                                                id="programme_id"
                                        >
                                            <option selected disabled>{{__("voyager::generic.none")}}</option>
                                            @foreach($programmes as $programme)
                                                <option
                                                        data-program-code="{{$programme->program_code}}"
                                                        data-end-location-center-type="{{$programme->end_location_center_type}}"
                                                        value="{{$programme->id}}" {{$edit && $committee->programme_id == $programme->id ? 'selected':''}}>
                                                    {{$programme->title_en}}
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
                                                    name="loc_union_municipality_id"
                                                    id="loc_union_municipality_id"
                                            >
                                                <option selected disabled>{{__("voyager::generic.none")}}</option>
                                                @foreach($locUnionMunicipalities as $key => $title)
                                                    <option value="{{$key}}" {{$edit && $committee->loc_union_municipality_id == $key ? 'selected':''}}>{{$title}}</option>
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
                                                name="loc_village_ward_ashrayan_matrikendro_id"
                                                id="loc_village_ward_ashrayan_matrikendro_id"
                                                data-url="{{route('api.index')}}"
                                                data-model="{{App\Models\LocVillageWardAshrayanMatrikendro::class}}"
                                                data-label="title_en"
                                                data-connection="master"
                                                @if($authUser->isUpazilaOffice())
                                                data-depend-on="{{json_encode(['loc_union_municipality_id' ])}}"
                                                data-additional-queries="{{json_encode(['type_of' => 'undefined'])}}"
                                                @else
                                                data-additional-queries="{{json_encode(['type_of' => 'undefined', 'id' => json_decode($authUser->loc_ward_ids)])}}"
                                                @endif
                                                data-placeholder="{{__("voyager::generic.none")}}"
                                        >
                                            @if($edit && $committee->loc_village_ward_ashrayan_matrikendro_id)
                                                <option value="{{$committee->loc_village_ward_ashrayan_matrikendro_id}}" selected>{{optional($committee->locVillageWardAshrayanMatrikendro)->title_en}}</option>
                                            @endif
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12" id="append_member"></div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 text-center">
                                    <button type="submit"
                                            class="btn btn-sm btn-success px-5"> {{ __('Submit For Approval') }}</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('javascript')
    <script type="text/javascript" src="{{ asset('backend_resources/js/form.js') }}"></script>
    <script src="{{ asset('backend_resources/js/jquery_validation_combine.js') }}"></script>
    @if(app()->getLocale() === 'bn')
        <script src="{{ asset('backend_resources/js/validation_localization_bn.js') }}"></script>
    @endif

    <script>
        let dyTemp = function (sl, designation) {
            let edit = this.id || false;
            return `<div class="row dynamic-list" id="dynamic_list_${sl}">
                        <input type="hidden" name="member[${sl}][id]" value="${edit ? this.id : ''}" id="member_${sl}" class="custom-control-input">
                        <div class="col-md-6">
                            <label>{{__($localPrefix . 'designation_id')}}</label>
                            <input type="hidden" id="org-designation-${sl}" name="member[${sl}][org_designation]" value="${designation.org_designation}" />
                            <input type="hidden" id="committee-designation-${sl}" name="member[${sl}][committee_designation]" value="${designation.committee_designation}" />
                            <select disabled class="form-control member-designation">
                                <option value="${designation.committee_designation}" selected>${designation.committee_designation}</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-0">
                            <div class="form-group">
                                <label for="family_member_survey_id_${sl}">{{__($localPrefix . 'member')}}<span class="text-danger">*</span></label>
                                <select id="member-selection-${sl}" class="form-control member-selection" name="member[${sl}][family_member_survey_id]" data-id="${sl}"
                                        id="family_member_survey_id_${sl}">
                                        ${edit ? `<option value="${this.family_member_survey_id}" selected>${this.member_name}</option>` : ''}
                                </select>
                            </div>
                        </div>
                    </div>`;
        };
        const programmeId = $('#programme_id'),
            locVillageWardAshrayanMatrikendroId = $('#loc_village_ward_ashrayan_matrikendro_id'),
            locUnionMunicipalityId = $('#loc_union_municipality_id'),
            memberLists = $("#append_member"),
            template = dyTemp;

        $.validator.addMethod("member_unique", function (value, element, regexp) {
                let counter = 0;
                $('.member-selection').each(function () {
                    if (value === $(this).val()) counter++;
                });
                return counter === 1;
            },
            "{{__("Member Should be unique")}}"
        );

        function generateMemberList(data)
        {
            data.forEach(function (designation, i) {
                let addNewRow = template.apply(@if($edit) designation @else null @endif, [i, designation]);
                memberLists.append(addNewRow);
                let memberNth = $('#member-selection-'+i);
                //TODO: I don't know why it's not working using class selector.
                memberNth.rules('add', {
                    required: true,
                    member_unique: true,
                });
                memberNth.select2({
                    width: '100%',
                    placeholder: 'সদস্য নির্বাচন',
                    allowClear: true,
                    ajax: {
                        url: '{{route('ward-village.team-members.for-committees')}}',
                        method: 'post',
                        data: function (params) {
                            return {
                                search: params.term,
                                @if($authUser->isUpazilaOffice())
                                loc_union_municipality_id: locUnionMunicipalityId.val(),
                                @endif
                                loc_village_ward_ashrayan_matrikendro_id: locVillageWardAshrayanMatrikendroId.val(),
                                programme_id: programmeId.val(),
                                org_designation: $("#org-designation-"+i).val(),
                                committee_designation: $("#committee-designation-"+i).val(),
                            };
                        }
                    }
                });
            });
        }

        let rules = {
            rules: {
                'programme_id': {
                    required: true
                },
            },
            messages: { },
            submitHandler: function (formElement) {
                $('#voyager-loader').show();
                let formData = new FormData(formElement);

                $('#form_add_edit').arrowAjax({
                    processData: false,
                    contentType: false,
                    data: formData
                });
            }
        }
        $('#form_add_edit').validate(Object.assign(rules, formValidatorConfig));
        $(function () {
            @if($edit)
            generateMemberList(@json($committeeMembers));
            @endif
        });

        $(programmeId).on('select2:select', function() {
            let endLocationCenterType = $('option:selected', this).data('end-location-center-type');

            let queries = locVillageWardAshrayanMatrikendroId.data('additional-queries')
            queries.type_of = endLocationCenterType;

            if(typeof endLocationCenterType == 'undefined' || endLocationCenterType === '') {
                delete queries.type_of;
            }
            locVillageWardAshrayanMatrikendroId
                .data('additional-queries', queries)
                .val(null).trigger('change');

            $.ajax({
                method: 'POST',
                url: '{{route('get-committee-settings')}}',
                data: {
                    programme_id: $(this).val(),
                }
            }).done(function (data) {
                memberLists.empty();
                generateMemberList(data);
            }).fail(function(error) {
                memberLists.empty();
            });
        });

        $(programmeId).on('select2:unselect', function() {
            locVillageWardAshrayanMatrikendroId.data('additional-queries', {id: [0]});
            locVillageWardAshrayanMatrikendroId.val(null).trigger('change');
        });
    </script>
@stop

