@php
    $edit = isset($team->id);
    $title = __(($edit ? 'Information Edit' : 'Information Add')) . ' - ' . __('Ward/Village Team');
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
    </h1>
@stop

@section('content')
    <div class="page-content container-fluid">
        <div class="panel panel-bordered">
            <div class="panel-heading">
                <a href="{{ route('teams.index') }}" class="btn btn-sm btn-default">
                    <span class="fa fa-backward"></span>&nbsp;
                    {{ __('voyager::generic.back') }}
                </a>
            </div>
            <div class="panel-body">
                <form class="form-edit-add repeater" role="form" id="form_add_edit"
                      action="{{$edit ? route('teams.update', $team->id) : route('teams.store')}}"
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
                                            value="{{$programme->id}}" {{$edit && $team->programme_id == $programme->id ? 'selected':''}}>
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
                                            name="loc_union_municipality_id"
                                            id="loc_union_municipality_id"
                                    >
                                        <option selected disabled>{{__("voyager::generic.none")}}</option>
                                        @foreach($locUnionMunicipalities as $key => $title)
                                            <option
                                                value="{{$key}}" {{$edit && $team->loc_union_municipality_id == $key ? 'selected':''}}>{{$title}}</option>
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
                                        data-label="title"
                                        data-connection="master"
                                        @if($authUser->isUpazilaOffice())
                                        data-depend-on="{{json_encode(['loc_union_municipality_id'])}}"
                                        data-additional-queries="{{json_encode(['type_of' => 'undefined'])}}"
                                        @else
                                        data-additional-queries="{{json_encode(['type_of' => 'undefined', 'id' => json_decode($authUser->loc_ward_ids)])}}"
                                        @endif
                                        data-placeholder="{{__("voyager::generic.none")}}"
                                >
                                    @if($edit && $team->loc_village_ward_ashrayan_matrikendro_id)
                                        <option value="{{$team->loc_village_ward_ashrayan_matrikendro_id}}"
                                                selected>{{optional($team->locVillageWardAshrayanMatrikendro)->title}}</option>
                                    @endif
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6 mb-0">
                            <div class="form-group">
                                <label for="team_name">{{ __($localPrefix .'team_name') }} : <span
                                        class="text-danger">*</span></label>
                                <input id="team_name" type="text" class="form-control" name="team_name"
                                       placeholder="{{ __($localPrefix .'team_name') }}"
                                       value="{{$edit ? $team->team_name : ''}}">
                            </div>
                        </div>
                        <div class="col-md-6 mb-0">
                            <div class="form-group">
                                <label for="team_code">{{ __($localPrefix .'team_code') }} : <span
                                        class="text-danger">*</span></label>
                                <input id="team_code" type="text" class="form-control" name="team_code"
                                       placeholder="{{ __($localPrefix .'team_code') }}"
                                       value="{{$edit ? $team->team_code : ''}}">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12" id="append_member"></div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 text-right">
                            <button class="btn btn-sm btn-info add-row"
                                    type="button"><i class="fa fa-plus"></i></button>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12 text-center">
                            <button type="submit" class="btn btn-sm btn-success px-5"> {{ __('সংরক্ষণ করুন') }}</button>
                        </div>
                    </div>
                </form>
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
        function memberSelection(e) {
            let member_id = $(e).val();
            let sl = $(e).data('id');

            $.post("{{ route('ward-village.get-member-details.for-teams') }}", {member_id: member_id}, function (data) {
                $('#father_name_' + sl).val(data.father);
                $('#husband_name_' + sl).val(data.husband);
                $('#age_' + sl).val(data.age);
                $('#occupation_' + sl).val(data.occupation);
            });
        }

        function fileChange(input) {
            let imgView = $("#view_" + $(input).prop('id'));
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    imgView.attr('src', e.target.result).width(100);
                };
                reader.readAsDataURL(input.files[0]);
            }
        }

        let dyTemp = function (sl) {
            let edit = this.id || false;
            return `<div class="row dynamic-list" id="dynamic_list_${sl}">
                        <div class="col-md-1 mb-0">
                            <input type="hidden" name="member[${sl}][delete]" value="0" id="marK_as_delete_${sl}" class="custom-control-input">
                            <input type="hidden" name="member[${sl}][id]" value="${edit ? this.id : ''}" id="member_${sl}" class="custom-control-input">
                            <div class="fom-group">
                                <label>{{__('দলনেতা')}}?</label>
                                <div class="custom-control custom-radio">
                                  <input type="radio" name="member[${sl}][is_team_head]" ${edit && this.is_team_head ? 'checked' : ''} value="1" id="customRadio${sl}" class="custom-control-input is_team_head">
                                  <label class="custom-control-label" for="customRadio${sl}">{{__('হ্যাঁ')}}</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-5 mb-0">
                            <div class="form-group">
                                <label for="family_member_survey_id_${sl}">{{__('সদস্যের নাম:')}}<span class="text-danger">*</span></label>
                                <select onchange="memberSelection(this)" class="form-control member-selection" name="member[${sl}][family_member_survey_id]" data-id="${sl}"
                                        id="family_member_survey_id_${sl}">
                                        ${edit ? `<option value="${this.family_member_survey_id}" selected>${this.member_name}</option>` : ''}
                                </select>
                            </div>
                        </div>

                        <div class="col-md-3 mb-0">
                            <div class="form-group">
                                <label for="">{{ __('পিতার নাম') }} :<span class="text-danger">*</span></label>
                                <input readonly type="text" class="form-control" name="member[${sl}][father]" id="father_name_${sl}" data-id="${sl}" value="${edit && this.father ? this.father : ''}" placeholder="{{ __('পিতার নাম') }}">
                             </div>
                         </div>

                        <div class="col-md-3 mb-0">
                            <div class="form-group">
                                <label for="">{{ __('স্বামীর নাম') }} :</label>
                                <input readonly type="text" class="form-control" name="member[${sl}][husband]" id="husband_name_${sl}" data-id="${sl}" value="${edit && this.husband ? this.husband : ''}" placeholder="{{ __('স্বামীর নাম') }}">
                             </div>
                         </div>
                        <div class="col-md-4 mb-0">
                            <div class="form-group">
                                <label for="">{{ __('বয়স') }} :<span class="text-danger">*</span></label>
                                <input readonly min="1" type="text" value="${edit ? this.age : ''}" class="form-control numeric-input" id="age_${sl}" data-id="${sl}" placeholder="{{ __('বয়স') }}">
                            </div>
                        </div>

                        <div class="col-md-4 mb-0">
                            <div class="form-group">
                                <label for="">{{ __('পেশা') }} :<span class="text-danger">*</span></label>
                                <input readonly type="text" class="form-control" value="${edit && this.occupation ? this.occupation : ''}" id="occupation_${sl}" data-id="${sl}" placeholder="{{ __('পেশা') }}">
                            </div>
                        </div>
                        <div class="col-md-2 mb-0">
                            <div class="form-group">
                                <br>
                                <label class="btn btn-lg btn-success" id="photo_label_upload_${sl}" for="photo_${sl}">
                                <i class="fa fa-photo"></i> {{__('ছবি নির্বাচন')}}
            </label>
            <input onchange="fileChange(this)" style="display: none" id="photo_${sl}" name="member[${sl}][photo]" data-id="${sl}" type="file">
                            </div>
                        </div>
                        <div class="col-md-2">
                             <img src="{{url('storage/')}}/${edit && this.photo ? this.photo : '../assets/dummy-person.png'}" id="view_photo_${sl}" style="width: 100px"/>
                        </div>
                        <button data-row-id="${sl}" class="btn btn-sm remove-row btn-danger" type='button'> <i class="fa fa-window-close"></i> </button>
                    </div>`;
        };

        const programmeId = $('#programme_id'),
            locVillageWardAshrayanMatrikendroId = $('#loc_village_ward_ashrayan_matrikendro_id'),
            locUnionMunicipalityId = $('#loc_union_municipality_id'),
            memberSelectionClass = $('.member-selection');

        /**
         *
         * @param args
         */
        function dynamicElmProcess(args) {
            this.el = args.el;
            this.addBtn = args.addBtn;
            this.removeBtn = args.removeBtn;
            this.sl = args.sl || 0;
            this.minRow = args.minRow || 1;
            this.template = args.template || '';

            let self = this;
            $(document).on('click', this.addBtn, function () {
                self.addRows();
            })

            $(document).on('click', this.removeBtn, function () {
                if ($(self.el).find('.dynamic-list').length === 1) {
                    return false;
                }
                let rowId = $(this).data("row-id");

                @if($edit)
                if ($("#member_" + rowId).val()) {
                    $("#marK_as_delete_" + rowId).val(1);
                    $("#dynamic_list_" + rowId).hide();
                } else {
                    $("#dynamic_list_" + rowId).remove();
                }
                @else
                $("#dynamic_list_" + rowId).remove();
                @endif
            })
            $(document).on('change', '.is_team_head', function () {
                $('.is_team_head').prop('checked', false);
                $(this).prop('checked', true);
            })
        }

        dynamicElmProcess.prototype.addRows = function (data = null, extra = []) {
            extra.push(this.sl);
            this.sl++;

            let addNewRow = this.template.apply(data, extra);
            $(this.el).append(addNewRow);

            $('.member-selection').rules('add', {
                required: true,
                member_unique: true,
            });

            $('.member-selection').select2({
                width: '100%',
                placeholder: 'সদস্য নির্বাচন',
                allowClear: true,
                ajax: {
                    url: '{{route('ward-village.survey-members.for-teams')}}',
                    method: 'post',
                    data: function (params) {
                        return {
                            search: params.term,
                            @if($authUser->isUpazilaOffice())
                            loc_union_municipality_id: locUnionMunicipalityId.val(),
                            @endif
                            loc_village_ward_ashrayan_matrikendro_id: locVillageWardAshrayanMatrikendroId.val(),
                            programme_id: programmeId.val()
                        };
                    }
                }
            });
        }

        $.validator.addMethod(
            "member_unique",
            function (value, element, regexp) {
                let counter = 0;
                $('.member-selection').each(function () {
                    if (value == $(this).val()) {
                        counter++;
                    }
                });
                return counter === 1;
            },
            "{{__('Member Should be unique')}}"
        );

        let rules = {
            rules: {
                'team_name': {
                    required: true,
                },
                'team_code': {
                    required: true,
                    remote: {
                        url: "{{ route('ward-village.team-unique-code') }}",
                        type: "post",
                        data: {
                            field: "team_code",
                            except_field: 'id',
                            @if($authUser->isUpazilaOffice())
                            loc_union_municipality_id: () => locUnionMunicipalityId.val(),
                            @endif
                            loc_village_ward_ashrayan_matrikendro_id: () => locVillageWardAshrayanMatrikendroId.val(),
                            programme_id: () => programmeId.val(),
                            except_val: '{{$edit ? $team->id : ''}}'
                        }
                    }
                },
                'programme_id': {
                    required: true
                }
            },
            messages: {
                team_code: {
                    remote: "{{__('Team Code Already Exists')}}"
                },
            },
            submitHandler: function (formElement) {
                $('#voyager-loader').show();
                let formData = new FormData(formElement);

                $('#form_add_edit').arrowAjax({
                    processData: false,
                    contentType: false,
                    data: formData
                })
            }
        }

        $('#form_add_edit').validate(Object.assign(rules, formValidatorConfig));

        let dynamicEl = new dynamicElmProcess({
            el: '#append_member',
            addBtn: '.add-row',
            removeBtn: '.remove-row',
            template: dyTemp,
        });

        @if(!$edit && !$isWorkWithOldData)
        dynamicEl.addRows();
        @elseif($edit)
        @forelse($teamMembers as $member)
        dynamicEl.addRows(@json($member));
        @empty
        dynamicEl.addRows();
        @endforelse
        @endif

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
        });

        $(programmeId).on('select2:unselect', function () {
            locVillageWardAshrayanMatrikendroId.data('additional-queries', {id: [0]});
            locVillageWardAshrayanMatrikendroId.val(null).trigger('change');
        });

        if (locUnionMunicipalityId.length) {
            $(locUnionMunicipalityId).on('select2:select', function () {
                locVillageWardAshrayanMatrikendroId.val(null).trigger('change');
            });
            $(locUnionMunicipalityId).on('select2:unselect', function () {
                locVillageWardAshrayanMatrikendroId.val(null).trigger('change');
            });
        }
    </script>
@stop

