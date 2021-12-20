@php
    $currentInstitute = app('currentInstitute');
    $layout = 'master::layouts.front-end';

@endphp

@extends($layout)

@section('title')
    {{ __('generic.course') }}
@endsection

@section('content')
    <div class="container-fluid" id="fixed-scrollbar">
        <div class="row  justify-content-center">
            <div class="col-md-11 col-sm-12">
                <div class="card mt-3">
                    <div class="card-header d-flex justify-content-between custom-bg-gradient-info"
                         style="background: url('{{asset('storage/'. optional($course)->cover_image)}}') no-repeat center center;
                             background-size: cover; min-height: 40vh;"
                    >
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12 custom-view-box">
                                <div class="row">
                                    <div class="col-md-6">
                                        <p class="label-text">{{__('admin.course.batch_list')}}</p>
                                        <ul class="list-group">
                                            @foreach($batches as $batch)
                                                <li class="list-group-item"><input class="batch-list"
                                                                                   data-id="{{ $batch->id }}"
                                                                                   type="checkbox"
                                                                                   value="{{ $batch->title }}"/> <label
                                                        for="batch title">{{ $batch->title }}</label></li>
                                            @endforeach
                                        </ul>
                                    </div>
                                    <div class="col-md-6">
                                        <p class="label-text">{{'Selected '}}{{__('admin.course.batch_list')}}</p>
                                        <ul class="list-group selected-batch-list">

                                        </ul>
                                    </div>
                                </div>

                            </div>

                            <div class="col-md-12">
                                <p class="font-italic">(Fill required field's to complete application)</p>

                                <div class="form-row">
                                    <div class="form-group col-md-6" id="ethnic-group-section">
                                        <label for="ethnic_group">{{ __('generic.ethnic_group') }}<span
                                                class="required">*</span> :</label>
                                        <div
                                            class="d-md-flex form-control"
                                            style="display: inline-table;">
                                            <div class="custom-control custom-radio mr-3">
                                                <input class="custom-control-input" type="radio"
                                                       id="ethnic_group_yes"
                                                       name="ethnic_group"
                                                       value="{{ \App\Models\Trainee::ETHNIC_GROUP_YES }}"
                                                    {{$trainee->ethnic_group == \App\Models\Trainee::ETHNIC_GROUP_YES ? 'checked' : ''}}>
                                                <label for="ethnic_group_yes"
                                                       class="custom-control-label">{{ __('generic.yes') }}</label>
                                            </div>
                                            <div class="custom-control custom-radio mr-3">
                                                <input class="custom-control-input" type="radio"
                                                       id="ethnic_group_no"
                                                       name="ethnic_group"
                                                       value="{{ \App\Models\Trainee::ETHNIC_GROUP_NO }}"
                                                    {{ $trainee->ethnic_group == \App\Models\Trainee::ETHNIC_GROUP_NO ? 'checked' : ''}}>
                                                <label for="ethnic_group_no"
                                                       class="custom-control-label">{{__('generic.no')}}</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6" id="freedom-fighter-status-section">
                                        <div class="form-group">
                                            <label for="freedom_fighter_status">{{__('generic.freedom_fighter_status')}}
                                                <span
                                                    class="required">*</span> :</label>
                                            <select class="form-control select2"
                                            @foreach(\App\Models\TraineeFamilyMemberInfo::getFreedomFighterStatusOptions() as $ffStatus)
                                                <option>{{ $ffStatus }}</option>
                                            @endforeach
                                            >
                                            </select>
                                        </div>
                                    </div>
                                </div>


                                <div class="row">
                                    <h5>Academic Information</h5>
                                    <div class="card-body row">
                                        <div class="col-md-6 academic-qualification-jsc mb-2">
                                            <div class="card col-md-12 custom-bg-gradient-info" style="height: 100%;">
                                                <div class="card-header">
                                                    <h3 class="card-title text-primary d-inline-flex">{{ __('admin.examination_name.jsc')}}
                                                        /{{ __('generic.equivalent')}}
                                                        ({{ __('generic.pass')}})</h3>
                                                </div>
                                                <div class="card-body jsc_collapse hide">

                                                    <input type="hidden" name="academicQualification[jsc][examination]"
                                                           value="{{ \App\Models\TraineeAcademicQualification::EXAMINATION_JSC }}">

                                                    <div class="form-row form-group">
                                                        <label for="jsc_examination_name"
                                                               class="col-md-4 col-form-label">{{ __('generic.examination')}}
                                                        </label>
                                                        <div class="col-md-8">
                                                            <select name="academicQualification[jsc][examination_name]"
                                                                    id="jsc_examination_name"
                                                                    class="select2 form-control">
                                                                <option value=""></option>
                                                                @foreach(\App\Models\TraineeAcademicQualification::getJSCExaminationOptions() as $key => $value)
                                                                    <option
                                                                        value="{{ $key }}" {{ isset($academicQualifications[\App\Models\TraineeAcademicQualification::EXAMINATION_JSC]) && $academicQualifications[\App\Models\TraineeAcademicQualification::EXAMINATION_JSC]->examination_name == $key ? 'selected' : ''}} {{ old('academicQualification.jsc.examination_name') == $key ? 'selected' : '' }}>
                                                                        {{ $value }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col-md-4"></div>
                                                    </div>

                                                    <div class="form-row form-group mt-2">
                                                        <label for="jsc_board"
                                                               class="col-md-4 col-form-label">{{ __('generic.board')}}
                                                        </label>
                                                        <div class="col-md-8">
                                                            <select name="academicQualification[jsc][board]"
                                                                    id="jsc_board"
                                                                    class="select2">
                                                                @foreach(\App\Models\TraineeAcademicQualification::getExaminationBoardOptions() as $key => $value)
                                                                    <option value=""></option>
                                                                    <option
                                                                        value="{{ $key }}" {{ isset($academicQualifications[\App\Models\TraineeAcademicQualification::EXAMINATION_JSC]) && $academicQualifications[\App\Models\TraineeAcademicQualification::EXAMINATION_JSC]->board == $key ? 'selected' : ''}} {{ old('academicQualification.jsc.board') == $key ? 'selected' : '' }}>
                                                                        {{ $value }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col-md-4"></div>
                                                    </div>

                                                    <div class="form-row form-group mt-2">
                                                        <label for="jsc_roll"
                                                               class="col-md-4 col-form-label">{{ __('generic.roll_no')}}</label>
                                                        <div class="col-md-8">
                                                            <input type="text"
                                                                   name="academicQualification[jsc][roll_no]"
                                                                   id="jsc_roll" class="form-control"
                                                                   value="{{ isset($academicQualifications[\App\Models\TraineeAcademicQualification::EXAMINATION_JSC]) ? $academicQualifications[\App\Models\TraineeAcademicQualification::EXAMINATION_JSC]->roll_no :  old('academicQualification.jsc.roll_no') }}">
                                                        </div>
                                                        <div class="col-md-4"></div>
                                                    </div>

                                                    <div class="form-row form-group mt-2">
                                                        <label for="jsc_reg_no"
                                                               class="col-md-4 col-form-label">{{ __('generic.reg_no')}}</label>
                                                        <div class="col-md-8">
                                                            <input type="text" id="jsc_reg_no"
                                                                   name="academicQualification[jsc][reg_no]"
                                                                   class="form-control"
                                                                   value="{{ isset($academicQualifications[\App\Models\TraineeAcademicQualification::EXAMINATION_JSC]) ? $academicQualifications[\App\Models\TraineeAcademicQualification::EXAMINATION_JSC]->reg_no :  old('academicQualification.jsc.reg_no') }}">
                                                        </div>
                                                        <div class="col-md-4"></div>
                                                    </div>

                                                    <input type="hidden" name="academicQualification[jsc][result]"
                                                           value="5">
                                                    <div class="form-row form-group mt-2">
                                                        <label for="jsc_result"
                                                               class="col-md-4 col-form-label">{{ __('generic.result')}}
                                                        </label>
                                                        <div class="col-md-8">
                                                            <input type="number"
                                                                   name="academicQualification[jsc][grade]"
                                                                   id="jsc_gpa" class="form-control"
                                                                   width="10" placeholder="{{ __('generic.result')}}"
                                                                   value="{{ isset($academicQualifications[\App\Models\TraineeAcademicQualification::EXAMINATION_JSC]) ? $academicQualifications[\App\Models\TraineeAcademicQualification::EXAMINATION_JSC]->grade :  old('academicQualification.jsc.grade') }}">
                                                        </div>
                                                        <div class="col-md-4"></div>
                                                    </div>

                                                    <div class="form-row form-group mt-2">
                                                        <label for="jsc_passing_year"
                                                               class="col-md-4 col-form-label">{{ __('generic.passing_year')}}</label>
                                                        <div class="col-md-8">
                                                            <select name="academicQualification[jsc][passing_year]"
                                                                    id="jsc_passing_year" class="select2">
                                                                <option value=""></option>
                                                                @for($i = now()->format('Y') - 50; $i <= now()->format('Y'); $i++)
                                                                    <option
                                                                        value="{{ $i }}" {{ isset($academicQualifications[\App\Models\TraineeAcademicQualification::EXAMINATION_JSC]) && $academicQualifications[\App\Models\TraineeAcademicQualification::EXAMINATION_JSC]->passing_year == $i ? 'selected' : ''}} >{{ $i }}</option>
                                                                @endfor
                                                            </select>
                                                        </div>
                                                        <div class="col-md-4"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 academic-qualification-ssc mb-2">
                                            <div class="card col-md-12 custom-bg-gradient-info" style="height: 100%;">
                                                <div class="card-header">
                                                    <h3 class="card-title text-primary d-inline-flex">
                                                        {{ __('admin.examination_name.ssc')}}
                                                        /{{ __('generic.equivalent')}}/{{ __('generic.o-level')}}
                                                        ({{ __('generic.pass')}}) </h3>
                                                </div>
                                                <div class="card-body ssc_collapse {{--collapse--}} hide">

                                                    <input type="hidden" name="academicQualification[ssc][examination]"
                                                           value="{{ \App\Models\TraineeAcademicQualification::EXAMINATION_SSC }}">

                                                    <div class="form-row form-group">
                                                        <label for="ssc_examination_name"
                                                               class="col-md-4 col-form-label">{{ __('generic.examination')}}
                                                        </label>
                                                        <div class="col-md-8">
                                                            <select name="academicQualification[ssc][examination_name]"
                                                                    id="ssc_examination_name"
                                                                    class="select2 form-control">
                                                                <option value=""></option>
                                                                @foreach(\App\Models\TraineeAcademicQualification::getSSCExaminationOptions() as $key => $value)
                                                                    <option
                                                                        value="{{ $key }}" {{ isset($academicQualifications[\App\Models\TraineeAcademicQualification::EXAMINATION_SSC]) && $academicQualifications[\App\Models\TraineeAcademicQualification::EXAMINATION_SSC]->examination_name == $key ? 'selected' : ''}} {{ old('academicQualification.ssc.examination_name') == $key ? 'selected' : '' }}>
                                                                        {{ $value }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col-md-4"></div>
                                                    </div>

                                                    <div class="form-row form-group mt-2">
                                                        <label for="ssc_board"
                                                               class="col-md-4 col-form-label">{{ __('generic.board')}}</label>
                                                        <div class="col-md-8">
                                                            <select name="academicQualification[ssc][board]"
                                                                    id="ssc_board"
                                                                    class="select2">
                                                                <option value=""></option>

                                                                @foreach(\App\Models\TraineeAcademicQualification::getExaminationBoardOptions() as $key => $value)
                                                                    <option
                                                                        value="{{ $key }}" {{ isset($academicQualifications[\App\Models\TraineeAcademicQualification::EXAMINATION_SSC]) && $academicQualifications[\App\Models\TraineeAcademicQualification::EXAMINATION_SSC]->board == $key ? 'selected' : ''}} {{ old('academicQualification.jsc.board') == $key ? 'selected' : '' }}>
                                                                        {{ $value }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col-md-4"></div>
                                                    </div>

                                                    <div class="form-row form-group mt-2">
                                                        <label for="ssc_roll"
                                                               class="col-md-4 col-form-label">{{ __('generic.roll_no')}}</label>
                                                        <div class="col-md-8">
                                                            <input type="text"
                                                                   name="academicQualification[ssc][roll_no]"
                                                                   id="ssc_roll" class="form-control"
                                                                   value="{{ isset($academicQualifications[\App\Models\TraineeAcademicQualification::EXAMINATION_SSC]) ? $academicQualifications[\App\Models\TraineeAcademicQualification::EXAMINATION_SSC]->roll_no :  old('academicQualification.ssc.roll_no') }}">
                                                        </div>
                                                        <div class="col-md-4"></div>
                                                    </div>

                                                    <div class="form-row form-group mt-2">
                                                        <label for="ssc_reg_no"
                                                               class="col-md-4 col-form-label">{{ __('generic.reg_no')}}</label>
                                                        <div class="col-md-8">
                                                            <input type="text" id="ssc_reg_no"
                                                                   name="academicQualification[ssc][reg_no]"
                                                                   class="form-control"
                                                                   value="{{ isset($academicQualifications[\App\Models\TraineeAcademicQualification::EXAMINATION_SSC]) ? $academicQualifications[\App\Models\TraineeAcademicQualification::EXAMINATION_SSC]->reg_no :  old('academicQualification.ssc.reg_no') }}">
                                                        </div>
                                                        <div class="col-md-4"></div>
                                                    </div>

                                                    <div class="form-row form-group mt-2">
                                                        <label for="ssc_result"
                                                               class="col-md-4 col-form-label">{{ __('generic.result')}}</label>
                                                        <div class="col-md-8" id="ssc_result_div">
                                                            <select name="academicQualification[ssc][result]"
                                                                    id="ssc_result"
                                                                    class="select2">
                                                                <option value=""></option>
                                                                @foreach(\App\Models\TraineeAcademicQualification::getExaminationResultOptions() as $key => $value)
                                                                    @if($key == \App\Models\TraineeAcademicQualification::EXAMINATION_RESULT_PASSED_MBBS_BDS)
                                                                        @continue;
                                                                    @endif
                                                                    <option
                                                                        value="{{ $key }}" {{ isset($academicQualifications[\App\Models\TraineeAcademicQualification::EXAMINATION_SSC]) && $academicQualifications[\App\Models\TraineeAcademicQualification::EXAMINATION_SSC]->result == $key ? 'selected' : ''}} {{ old('academicQualification.ssc.result') == $key ? 'selected' : '' }}>
                                                                        {{ $value }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="" id="ssc_gpa_div">
                                                            <input type="number"
                                                                   name="academicQualification[ssc][grade]"
                                                                   id="ssc_gpa" class="form-control"
                                                                   width="10" placeholder="জি.পি.এ"
                                                                   value="{{ isset($academicQualifications[\App\Models\TraineeAcademicQualification::EXAMINATION_SSC]) ? $academicQualifications[\App\Models\TraineeAcademicQualification::EXAMINATION_SSC]->grade :  old('academicQualification.ssc.grade') }}"
                                                                   hidden>
                                                        </div>
                                                        <div class="col-md-4"></div>
                                                    </div>

                                                    <div class="form-row form-group mt-2">
                                                        <label for="ssc_group"
                                                               class="col-md-4 col-form-label">{{ __('generic.division')}}</label>
                                                        <div class="col-md-8">
                                                            <select name="academicQualification[ssc][group]"
                                                                    class="select2"
                                                                    id="ssc_group">
                                                                <option value=""></option>
                                                                @foreach(\App\Models\TraineeAcademicQualification::getExaminationGroupOptions() as $key => $value)
                                                                    <option
                                                                        value="{{ $key }}" {{ isset($academicQualifications[\App\Models\TraineeAcademicQualification::EXAMINATION_SSC]) && $academicQualifications[\App\Models\TraineeAcademicQualification::EXAMINATION_SSC]->group == $key ? 'selected' : ''}} {{ old('academicQualification.ssc.group') == $key ? 'selected' : '' }}>
                                                                        {{ $value }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col-md-4"></div>
                                                    </div>

                                                    <div class="form-row form-group mt-2">
                                                        <label for="ssc_passing_year"
                                                               class="col-md-4 col-form-label">{{ __('generic.passing_year')}}</label>
                                                        <div class="col-md-8">
                                                            <select name="academicQualification[ssc][passing_year]"
                                                                    id="ssc_passing_year" class="select2">
                                                                <option value=""></option>
                                                                @for($i = now()->format('Y') - 50; $i <= now()->format('Y'); $i++)
                                                                    <option
                                                                        value="{{ $i }}" {{ isset($academicQualifications[\App\Models\TraineeAcademicQualification::EXAMINATION_SSC]) && $academicQualifications[\App\Models\TraineeAcademicQualification::EXAMINATION_SSC]->passing_year == $i ? 'selected' : ''}} {{ old('academicQualification.ssc.passing_year') == $i ? 'selected' : '' }}>
                                                                        {{ $i }}
                                                                    </option>
                                                                @endfor
                                                            </select>
                                                        </div>
                                                        <div class="col-md-4"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-6 academic-qualification-hsc mb-2">
                                            <div class="card custom-bg-gradient-info col-md-12" style="height: 100%;">
                                                <div class="card-header">
                                                    <h3 class="card-title text-primary d-inline-flex">
                                                        {{ __('admin.examination_name.hsc')}}
                                                        /{{ __('generic.equivalent')}}
                                                        ({{ __('generic.pass')}})
                                                    </h3>
                                                </div>
                                                <div class="card-body hsc_collapse hide">
                                                    <input type="hidden" name="academicQualification[hsc][examination]"
                                                           value="{{ \App\Models\TraineeAcademicQualification::EXAMINATION_HSC }}">
                                                    <div class="form-row form-group">
                                                        <label for="hsc_examination_name"
                                                               class="col-md-4 col-form-label">{{ __('generic.examination')}}
                                                        </label>

                                                        <div class="col-md-8">
                                                            <select name="academicQualification[hsc][examination_name]"
                                                                    id="hsc_examination_name" class="select2">
                                                                <option></option>
                                                                @foreach(\App\Models\TraineeAcademicQualification::getHSCExaminationOptions() as $key => $value)
                                                                    <option
                                                                        value="{{ $key }}" {{ isset($academicQualifications[\App\Models\TraineeAcademicQualification::EXAMINATION_HSC]) && $academicQualifications[\App\Models\TraineeAcademicQualification::EXAMINATION_HSC]->examination_name == $key ? 'selected' : ''}} {{ old('academicQualification.hsc.examination_name') == $key ? 'selected' : '' }}>
                                                                        {{ $value }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col-md-4"></div>
                                                    </div>

                                                    <div class="form-row form-group mt-2">
                                                        <label for="hsc_board"
                                                               class="col-md-4 col-form-label">{{ __('generic.board')}}
                                                        </label>
                                                        <div class="col-md-8">
                                                            <select name="academicQualification[hsc][board]"
                                                                    id="hsc_board"
                                                                    class="select2">
                                                                <option></option>
                                                                @foreach(\App\Models\TraineeAcademicQualification::getExaminationBoardOptions() as $key => $value)
                                                                    <option
                                                                        value="{{ $key }}" {{ isset($academicQualifications[\App\Models\TraineeAcademicQualification::EXAMINATION_HSC]) && $academicQualifications[\App\Models\TraineeAcademicQualification::EXAMINATION_HSC]->board == $key ? 'selected' : ''}} {{ old('academicQualification.hsc.board') == $key ? 'selected' : '' }}>
                                                                        {{ $value }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col-md-4"></div>
                                                    </div>

                                                    <div class="form-row form-group mt-2">
                                                        <label for="hsc_roll"
                                                               class="col-md-4 col-form-label">{{ __('generic.roll_no')}}</label>
                                                        <div class="col-md-8">
                                                            <input type="text"
                                                                   name="academicQualification[hsc][roll_no]"
                                                                   id="hsc_roll" class="form-control"
                                                                   value="{{ isset($academicQualifications[\App\Models\TraineeAcademicQualification::EXAMINATION_HSC]) ? $academicQualifications[\App\Models\TraineeAcademicQualification::EXAMINATION_HSC]->roll_no :  old('academicQualification.hsc.roll_no') }}">
                                                        </div>
                                                        <div class="col-md-4"></div>
                                                    </div>

                                                    <div class="form-row form-group mt-2">
                                                        <label for="hsc_reg_no"
                                                               class="col-md-4 col-form-label">{{ __('generic.reg_no')}}</label>
                                                        <div class="col-md-8">
                                                            <input type="text" name="academicQualification[hsc][reg_no]"
                                                                   id="hsc_reg_no" class="form-control"
                                                                   value="{{ isset($academicQualifications[\App\Models\TraineeAcademicQualification::EXAMINATION_HSC]) ? $academicQualifications[\App\Models\TraineeAcademicQualification::EXAMINATION_HSC]->reg_no :  old('academicQualification.hsc.reg_no') }}"

                                                            >
                                                        </div>
                                                        <div class="col-md-4"></div>
                                                    </div>

                                                    <div class="form-row form-group mt-2">
                                                        <label for="hsc_result"
                                                               class="col-md-4 col-form-label">{{ __('generic.result')}}
                                                        </label>
                                                        <div class="col-md-8" id="hsc_result_div">
                                                            <select name="academicQualification[hsc][result]"
                                                                    id="hsc_result"
                                                                    class="select2">
                                                                <option></option>
                                                                @foreach(\App\Models\TraineeAcademicQualification::getExaminationResultOptions() as $key => $value)
                                                                    @if($key == \App\Models\TraineeAcademicQualification::EXAMINATION_RESULT_PASSED_MBBS_BDS)
                                                                        @continue;
                                                                    @endif
                                                                    <option
                                                                        value="{{ $key }}" {{ isset($academicQualifications[\App\Models\TraineeAcademicQualification::EXAMINATION_HSC]) && $academicQualifications[\App\Models\TraineeAcademicQualification::EXAMINATION_HSC]->result == $key ? 'selected' : ''}} {{ old('academicQualification.hsc.result') == $key ? 'selected' : '' }}>
                                                                        {{ $value }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="" id="hsc_gpa_div">
                                                            <input type="number"
                                                                   name="academicQualification[hsc][grade]"
                                                                   id="hsc_gpa" class="form-control"
                                                                   width="10" placeholder="জি.পি.এ"
                                                                   value="{{ isset($academicQualifications[\App\Models\TraineeAcademicQualification::EXAMINATION_HSC]) ? $academicQualifications[\App\Models\TraineeAcademicQualification::EXAMINATION_HSC]->grade :  old('academicQualification.hsc.grade') }}"
                                                                   hidden>
                                                        </div>
                                                        <div class="col-md-4"></div>
                                                    </div>

                                                    <div class="form-row form-group mt-2">
                                                        <label for="hsc_group"
                                                               class="col-md-4 col-form-label">{{ __('generic.division')}}
                                                        </label>
                                                        <div class="col-md-8">
                                                            <select name="academicQualification[hsc][group]"
                                                                    id="hsc_group"
                                                                    class="select2">
                                                                <option></option>
                                                                @foreach(\App\Models\TraineeAcademicQualification::getExaminationGroupOptions() as $key => $value)
                                                                    <option
                                                                        value="{{ $key }}" {{ isset($academicQualifications[\App\Models\TraineeAcademicQualification::EXAMINATION_HSC]) && $academicQualifications[\App\Models\TraineeAcademicQualification::EXAMINATION_HSC]->group == $key ? 'selected' : ''}} {{ old('academicQualification.hsc.group') == $key ? 'selected' : '' }}>
                                                                        {{ $value }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col-md-4"></div>
                                                    </div>

                                                    <div class="form-row form-group mt-2">
                                                        <label for="hsc_passing_year"
                                                               class="col-md-4 col-form-label">{{ __('generic.passing_year')}}</label>
                                                        <div class="col-md-8">
                                                            <select name="academicQualification[hsc][passing_year]"
                                                                    id="hsc_passing_year" class="select2">
                                                                <option value=""></option>
                                                                @for($i = now()->format('Y') - 50; $i <= now()->format('Y'); $i++)
                                                                    <option
                                                                        value="{{ $i }}" {{ isset($academicQualifications[\App\Models\TraineeAcademicQualification::EXAMINATION_HSC]) && $academicQualifications[\App\Models\TraineeAcademicQualification::EXAMINATION_HSC]->passing_year == $i ? 'selected' : ''}} {{ old('academicQualification.hsc.passing_year') == $i ? 'selected' : '' }}>
                                                                        {{ $i }}
                                                                    </option>
                                                                @endfor
                                                            </select>
                                                        </div>
                                                        <div class="col-md-4"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-6 academic-qualification-graduation mb-2">
                                            <div class="card col-md-12 custom-bg-gradient-info" style="height: 100%;">
                                                <div class="card-header">
                                                    <h3 class="card-title text-primary d-inline-flex">{{ __('admin.examination_name.honors')}}
                                                        ({{ __('generic.pass')}})</h3>
                                                </div>
                                                <div class="card-body graduation_collapse hide">
                                                    <input type="hidden"
                                                           name="academicQualification[graduation][examination]"
                                                           value="{{ \App\Models\TraineeAcademicQualification::EXAMINATION_GRADUATION }}">

                                                    <div class="form-row form-group">
                                                        <label for="graduation_examination_name"
                                                               class="col-md-4 col-form-label">{{ __('generic.examination')}}
                                                        </label>
                                                        <div class="col-md-8">
                                                            <select
                                                                name="academicQualification[graduation][examination_name]"
                                                                id="graduation_examination_name" class="select2">
                                                                <option value=""></option>
                                                                @foreach(\App\Models\TraineeAcademicQualification::getGraduationExaminationOptions() as $key => $value)
                                                                    <option
                                                                        value="{{ $key }}" {{ isset($academicQualifications[\App\Models\TraineeAcademicQualification::EXAMINATION_GRADUATION]) && $academicQualifications[\App\Models\TraineeAcademicQualification::EXAMINATION_GRADUATION]->examination_name == $key ? 'selected' : ''}} {{ old('academicQualification.graduation.examination_name') == $key ? 'selected' : '' }}>
                                                                        {{ $value }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col-md-4"></div>
                                                    </div>

                                                    <div class="form-row form-group mt-2">
                                                        <label for="graduation_subject"
                                                               class="col-md-4 col-form-label">{{ __('generic.subject')}}
                                                            /{{ __('generic.degree')}}</label>
                                                        <div class="col-md-8">
                                                            <input type="text"
                                                                   name="academicQualification[graduation][subject]"
                                                                   id="graduation_subject" class="form-control"
                                                                   value="{{ isset($academicQualifications[\App\Models\TraineeAcademicQualification::EXAMINATION_GRADUATION]) ? $academicQualifications[\App\Models\TraineeAcademicQualification::EXAMINATION_GRADUATION]->subject :  old('academicQualification.graduation.subject') }}">
                                                        </div>
                                                        <div class="col-md-4"></div>
                                                    </div>

                                                    <div class="form-row form-group mt-2">
                                                        <label for="graduation_institute"
                                                               class="col-md-4 col-form-label">{{ __('generic.institute')}}
                                                            /{{ __('generic.university')}}</label>
                                                        <div class="col-md-8">
                                                            <select name="academicQualification[graduation][institute]"
                                                                    id="graduation_institute"
                                                                    class="select2">
                                                                <option value=""></option>
                                                                @foreach(\App\Models\TraineeAcademicQualification::getUniversities() as $key => $value)
                                                                    <option
                                                                        value="{{ $key }}" {{ isset($academicQualifications[\App\Models\TraineeAcademicQualification::EXAMINATION_GRADUATION]) && $academicQualifications[\App\Models\TraineeAcademicQualification::EXAMINATION_GRADUATION]->institute == $key ? 'selected' : ''}} {{ old('academicQualification.graduation.institute') == $key ? 'selected' : '' }}>
                                                                        {{ $value }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col-md-4"></div>
                                                    </div>


                                                    <div class="form-row form-group mt-2">
                                                        <label for="graduation_result"
                                                               class="col-md-4 col-form-label">{{ __('generic.result')}}
                                                        </label>
                                                        <div class="col-md-8" id="graduation_result_div">
                                                            <select name="academicQualification[graduation][result]"
                                                                    id="graduation_result"
                                                                    class="select2">
                                                                <option value=""></option>
                                                                @foreach(\App\Models\TraineeAcademicQualification::getExaminationResultOptions() as $key => $value)
                                                                    <option
                                                                        value="{{ $key }}" {{ isset($academicQualifications[\App\Models\TraineeAcademicQualification::EXAMINATION_GRADUATION]) && $academicQualifications[\App\Models\TraineeAcademicQualification::EXAMINATION_GRADUATION]->result == $key ? 'selected' : ''}} {{ old('academicQualification.graduation.result') == $key ? 'selected' : '' }}>
                                                                        {{ $value }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="" id="graduation_cgpa_div">
                                                            <input type="number"
                                                                   name="academicQualification[graduation][grade]"
                                                                   id="graduation_cgpa"
                                                                   class="form-control" width="10"
                                                                   placeholder="সি.জি.পি.এ"
                                                                   value="{{ isset($academicQualifications[\App\Models\TraineeAcademicQualification::EXAMINATION_GRADUATION]) ? $academicQualifications[\App\Models\TraineeAcademicQualification::EXAMINATION_GRADUATION]->grade :  old('academicQualification.graduation.grade') }}"
                                                                   hidden>
                                                        </div>
                                                        <div class="col-md-4"></div>
                                                    </div>

                                                    <div class="form-row form-group mt-2">
                                                        <label for="graduation_passing_year"
                                                               class="col-md-4 col-form-label">
                                                            {{ __('generic.passing_year')}}</label>
                                                        <div class="col-md-8">
                                                            <select
                                                                name="academicQualification[graduation][passing_year]"
                                                                id="graduation_passing_year" class="select2">
                                                                <option></option>
                                                                @for($i = now()->format('Y') - 50; $i <= now()->format('Y'); $i++)
                                                                    <option
                                                                        value="{{ $i }}" {{ isset($academicQualifications[\App\Models\TraineeAcademicQualification::EXAMINATION_GRADUATION]) && $academicQualifications[\App\Models\TraineeAcademicQualification::EXAMINATION_GRADUATION]->passing_year == $i ? 'selected' : ''}} {{ old('academicQualification.graduation.passing_year') == $i ? 'selected' : '' }}>
                                                                        {{ $i }}
                                                                    </option>
                                                                @endfor
                                                            </select>
                                                        </div>
                                                        <div class="col-md-4"></div>
                                                    </div>

                                                    <div class="form-row form-group mt-2">
                                                        <label for="graduation_course_duration"
                                                               class="col-md-4 col-form-label">
                                                            {{ __('generic.course_duration')}}</label>
                                                        <div class="col-md-8">
                                                            <select
                                                                name="academicQualification[graduation][course_duration]"
                                                                id="graduation_course_duration" class="select2">
                                                                <option></option>
                                                                @foreach(\App\Models\TraineeAcademicQualification::getExaminationCourseDurationOptions() as $key => $value)
                                                                    <option
                                                                        value="{{ $key }}" {{ isset($academicQualifications[\App\Models\TraineeAcademicQualification::EXAMINATION_GRADUATION]) && $academicQualifications[\App\Models\TraineeAcademicQualification::EXAMINATION_GRADUATION]->course_duration == $key ? 'selected' : ''}} {{ old('academicQualification.graduation.course_duration') == $key ? 'selected' : '' }}>
                                                                        {{ $value }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col-md-4"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 academic-qualification-masters mb-2">
                                            <div class="card col-md-12 custom-bg-gradient-info" style="height: 100%;">
                                                <div class="card-header">
                                                    <h3 class="card-title text-primary d-inline-flex">{{ __('admin.examination_name.masters')}}
                                                        ({{ __('generic.pass')}}) </h3>
                                                </div>
                                                <div class="card-body masters_collapse {{--collapse--}} hide">
                                                    <input type="hidden"
                                                           name="academicQualification[masters][examination]"
                                                           value="{{ \App\Models\TraineeAcademicQualification::EXAMINATION_MASTERS }}">
                                                    <div class="form-row form-group">
                                                        <label for="masters_examination_name"
                                                               class="col-md-4 col-form-label">{{ __('generic.examination')}}</label>
                                                        <div class="col-md-8">
                                                            <select
                                                                name="academicQualification[masters][examination_name]"
                                                                id="masters_examination_name" class="select2">
                                                                <option></option>
                                                                @foreach(\App\Models\TraineeAcademicQualification::getMastersExaminationOptions() as $key => $value)
                                                                    <option
                                                                        value="{{ $key }}" {{ isset($academicQualifications[\App\Models\TraineeAcademicQualification::EXAMINATION_MASTERS]) && $academicQualifications[\App\Models\TraineeAcademicQualification::EXAMINATION_MASTERS]->examination_name == $key ? 'selected' : ''}} {{ old('academicQualification.masters.examination_name') == $key ? 'selected' : '' }}>
                                                                        {{ $value }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col-md-4"></div>
                                                    </div>

                                                    <div class="form-row form-group mt-2">
                                                        <label for="masters_subject"
                                                               class="col-md-4 col-form-label">{{ __('generic.subject')}}
                                                            /{{ __('generic.degree')}}</label>
                                                        <div class="col-md-8">
                                                            <input type="text"
                                                                   name="academicQualification[masters][subject]"
                                                                   id="masters_subject"
                                                                   class="form-control"
                                                                   value="{{ isset($academicQualifications[\App\Models\TraineeAcademicQualification::EXAMINATION_MASTERS]) ? $academicQualifications[\App\Models\TraineeAcademicQualification::EXAMINATION_MASTERS]->subject :  old('academicQualification.graduation.subject') }}"
                                                            >
                                                        </div>
                                                        <div class="col-md-4"></div>
                                                    </div>

                                                    <div class="form-row form-group mt-2">
                                                        <label for="masters_institute"
                                                               class="col-md-4 col-form-label">{{ __('generic.institute')}}
                                                            /{{ __('generic.university')}}</label>
                                                        <div class="col-md-8">
                                                            <select name="academicQualification[masters][institute]"
                                                                    id="masters_institute" class="select2">
                                                                <option value=""></option>
                                                                @foreach(\App\Models\TraineeAcademicQualification::getUniversities() as $key => $value)
                                                                    <option
                                                                        value="{{ $key }}" {{ isset($academicQualifications[\App\Models\TraineeAcademicQualification::EXAMINATION_MASTERS]) && $academicQualifications[\App\Models\TraineeAcademicQualification::EXAMINATION_MASTERS]->institute == $key ? 'selected' : ''}} {{ old('academicQualification.masters.institute') == $key ? 'selected' : '' }}>
                                                                        {{ $value }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col-md-4"></div>
                                                    </div>


                                                    <div class="form-row form-group mt-2">
                                                        <label for="masters_result"
                                                               class="col-md-4 col-form-label">{{ __('generic.result')}}</label>
                                                        <div class="col-md-8" id="masters_result_div">
                                                            <select name="academicQualification[masters][result]"
                                                                    id="masters_result"
                                                                    class="select2">
                                                                <option></option>
                                                                @foreach(\App\Models\TraineeAcademicQualification::getExaminationResultOptions() as $key => $value)
                                                                    <option
                                                                        value="{{ $key }}" {{ isset($academicQualifications[\App\Models\TraineeAcademicQualification::EXAMINATION_MASTERS]) && $academicQualifications[\App\Models\TraineeAcademicQualification::EXAMINATION_MASTERS]->result == $key ? 'selected' : ''}} {{ old('academicQualification.masters.result') == $key ? 'selected' : '' }}>
                                                                        {{ $value }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="" id="masters_cgpa_div">
                                                            <input type="number"
                                                                   name="academicQualification[masters][grade]"
                                                                   id="masters_cgpa"
                                                                   class="form-control" width="10"
                                                                   placeholder="সি.জি.পি.এ"
                                                                   value="{{ old('academicQualification.masters.grade') }}"
                                                                   hidden>
                                                        </div>
                                                        <div class="col-md-4"></div>
                                                    </div>

                                                    <div class="form-row form-group mt-2">
                                                        <label for="masters_passing_year"
                                                               class="col-md-4 col-form-label">
                                                            {{ __('generic.passing_year')}}</label>
                                                        <div class="col-md-8">
                                                            <select name="academicQualification[masters][passing_year]"
                                                                    class="select2" id="masters_passing_year">
                                                                <option></option>
                                                                @for($i = now()->format('Y') - 50; $i <= now()->format('Y'); $i++)
                                                                    <option
                                                                        value="{{ $i }}" {{ isset($academicQualifications[\App\Models\TraineeAcademicQualification::EXAMINATION_MASTERS]) && $academicQualifications[\App\Models\TraineeAcademicQualification::EXAMINATION_MASTERS]->passing_year == $i ? 'selected' : ''}} {{ old('academicQualification.masters.passing_year') == $i ? 'selected' : '' }}>
                                                                        {{ $i }}
                                                                    </option>
                                                                @endfor
                                                            </select>
                                                        </div>
                                                        <div class="col-md-4"></div>

                                                    </div>

                                                    <div class="form-row form-group mt-2">
                                                        <label for="masters_course_duration"
                                                               class="col-md-4 col-form-label">
                                                            {{ __('generic.course_duration')}}</label>
                                                        <div class="col-md-8">
                                                            <select
                                                                name="academicQualification[masters][course_duration]"
                                                                id="masters_course_duration" class="select2">
                                                                <option></option>
                                                                @foreach(\App\Models\TraineeAcademicQualification::getExaminationCourseDurationOptions() as $key => $value)
                                                                    <option
                                                                        value="{{ $key }}" {{ isset($academicQualifications[\App\Models\TraineeAcademicQualification::EXAMINATION_MASTERS]) && $academicQualifications[\App\Models\TraineeAcademicQualification::EXAMINATION_MASTERS]->course_duration == $key ? 'selected' : ''}} {{ old('academicQualification.masters.course_duration') == $key ? 'selected' : '' }}>
                                                                        {{ $value }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col-md-4"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 custom-view-box mt2 " style="text-align: center">
                                <a href="#" class="btn btn-primary " style="padding: 2px 10px;">আবেদন</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@push('css')
    <style>
        .card-background-white {
            background: #faf8fb;
        }

        .form-control {
            border: 1px solid #671688;
            color: #671688;
        }

        .form-control:focus {
            border-color: #671688;
        }

        .button-bg {
            background: #671688;
            border-color: #671688;
        }

        .button-bg:hover {
            color: #ffffff;
            background-color: #671688 !important;;
            border-color: #671688 !important;;
        }

        .button-bg:active {
            color: #ffffff;
            background-color: #671688 !important;
            border-color: #671688 !important;;
        }

        .button-bg:focus {
            color: #ffffff;
            background-color: #671688 !important;;
            border-color: #671688 !important;;
        }

        .button-bg:visited {
            color: #ffffff;
            background-color: #671688 !important;;
            border-color: #671688 !important;;
        }

        .card-header-title {
            min-height: 48px;
        }

        .card-bar-home-course img {
            height: 14vw;
        }

        .gray-color {
            color: #73727f;
        }

        .course-heading-wrap {
            text-overflow: ellipsis;
            white-space: nowrap;
            overflow: hidden;
        }

        .course-heading-wrap:hover {
            overflow: visible;
            white-space: normal;
            cursor: pointer;
        }

        .course-p {
            font-size: 14px;
            font-weight: 400;
            color: #671688;
        }

        .header-bg {
            background: #671688;
            color: white;
        }

        .modal-header .close, .modal-header .mailbox-attachment-close {
            padding: 1rem;
            margin: -1rem -1rem -1rem auto;
            color: white;
            outline: none;
        }

        .card-p1 {
            color: #671688;
        }
    </style>
@endpush
@push('js')
    <script>

        function setFormFields(settings) {
            console.log(settings);

            if (settings?.FreedomFighter?.should_present_in_form) {
                $('#freedom-fighter-status-section').show();
            }else {
                $('#freedom-fighter-status-section').hide();
            }

            if (settings?.ethnicGroup?.should_present_in_form) {
                $('#ethnic-group-section').show();
            }else {
                $('#ethnic-group-section').hide();
            }

            settings?.JSCInfo?.should_present_in_form ? $('.jsc_collapse').parent().parent().show() : $('.jsc_collapse').parent().parent().hide()
            settings?.SSCInfo?.should_present_in_form ? $('.ssc_collapse').parent().parent().show() : $('.ssc_collapse').parent().parent().hide();
            settings?.HSCInfo?.should_present_in_form ? $('.hsc_collapse').parent().parent().show() : $('.hsc_collapse').parent().parent().hide();
            settings?.HonoursInfo?.should_present_in_form ? $('.graduation_collapse').parent().parent().show() : $('.graduation_collapse').parent().parent().hide();
            settings?.MastersInfo?.should_present_in_form ? $('.masters_collapse').parent().parent().show() : $('.masters_collapse').parent().parent().hide();
        }


        $(document).ready(function () {

            const COURSE = {!! $course !!};
            const APPLICATION_FORM_SETTINGS =  COURSE?.application_form_settings;
            setFormFields(APPLICATION_FORM_SETTINGS);


            $('.batch-list').on('click', function () {
                if ($(this).is(':checked')) {
                    $('.selected-batch-list').append('<li id="batch-list-item-' + $(this).attr("data-id") + '" class="list-group-item"><input name="batches[]"' +
                        ' type="hidden" value="' + $(this).attr("data-id") + '"/><label for="Batch title">' + $(".selected-batch-list").children().length + '. ' + $(this).val() + '</lable></li>');
                } else if (!($(this).is(':checked'))) {
                    $("#batch-list-item-" + $(this).attr("data-id")).remove();
                }
            });
            if ($(".selected-batch-list").children().length == 0) {
                //$(".selected-batch-list").append('<li class="list-group-item" style="background: #bd2130;color: #ffffff;" ><span >No batch selected</span></li>');
            }
        });
    </script>
@endpush
