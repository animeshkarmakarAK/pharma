@php
    $edit = !empty($organization->id);
@endphp

@extends('master::layouts.master')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card card-outline">
                    <div class="card-header text-primary custom-bg-gradient-info">
                        <h3 class="card-title font-weight-bold text-primary">{{ ! $edit ? 'Add Industry information' : 'Update Industry information' }}</h3>

                        <div class="card-tools">
                            {{--@can('viewAny', \Module\GovtStakeholder\App\Models\Organization::class)

                            @endcan--}}

                            <a href="{{route('govt_stakeholder::admin.organization-information')}}"
                               class="btn btn-sm btn-outline-primary btn-rounded">
                                <i class="fas fa-backward"></i> Back to list
                            </a>
                        </div>
                    </div>

                    <div class="card-body">
                        <form action="{{route('govt_stakeholder::admin.organization-information.store')}}" method="post" id="employee-vertical-wizard">
                            @csrf
                            <div>
                                <h3>তথ্যগ্রহীতার তথ্য</h3>
                                <section>
                                    <div class="card-body pt-1">
                                        <h3 clas="text-dark">তথ্যগ্রহীতার তথ্য</h3>
                                        <div class="row pt-4">
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="informant_name">তথ্যগ্রহীতার নাম<span
                                                            style="color: red"> * </span></label>
                                                    <input type="text" class="form-control" id="informant_name"
                                                           name="informant_name"
                                                           placeholder="তথ্যগ্রহীতার নাম">
                                                </div>
                                            </div>

                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="informant_mobile">তথ্যগ্রহীতার মোবাইল নম্বর<span
                                                            style="color: red"> * </span></label>
                                                    <input type="text" class="form-control" id="informant_mobile"
                                                           name="informant_mobile"
                                                           placeholder="তথ্যগ্রহীতার মোবাইল নম্বর">
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="informant_email">তথ্যগ্রহীতার ইমেইল<span
                                                            style="color: red"> * </span></label>
                                                    <input type="text" class="form-control" id="informant_email"
                                                           name="informant_email"
                                                           placeholder="তথ্যগ্রহীতার ইমেইল">
                                                </div>
                                            </div>

                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="informant_date">তথ্য সংগ্রহের তারিখ <span
                                                            style="color: red">*</span></label>
                                                    <input type="text" class="flat-date flat-date-custom-bg start_date" id="informant_date"
                                                           name="informant_date"
                                                           value=""
                                                    >
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </section>
                                <h3>উত্তরদাতার প্রাথমিক তথ্য</h3>
                                <section>
                                    <div class="card-body pt-1">
                                        <h3 clas="text-dark">উত্তরদাতার প্রাথমিক তথ্য</h3>
                                        <div class="col-sm-6 pt-4">
                                            <div class="form-group">
                                                <label for="respondent_name">উত্তরদাতার নাম<span
                                                        style="color: red"> * </span></label>
                                                <input type="text" class="form-control" id="respondent_name"
                                                       name="respondent_name"
                                                       placeholder="উত্তরদাতার নাম">
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="respondent_designation">উত্তরদাতার পদবী<span
                                                        class="required"> *</span> </label>
                                                <div class="row">
                                                    <div class="col-sm-6 pb-3">
                                                        <div class="custom-control custom-radio">
                                                            <input class="custom-control-input" type="radio" id="respondent_relation"
                                                                   name="respondent_designation"
                                                                   value="মানব সম্পর্ক কর্মকর্তা">
                                                            <label for="respondent_relation" class="custom-control-label">মানব সম্পর্ক কর্মকর্তা</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6 pb-3">
                                                        <div class="custom-control custom-radio">
                                                            <input class="custom-control-input" type="radio" id="respondent_owner"
                                                                   name="respondent_designation"
                                                                   value="মালিক">
                                                            <label for="respondent_owner" class="custom-control-label">মালিক</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6 pb-3">
                                                        <div class="custom-control custom-radio">
                                                            <input class="custom-control-input" type="radio" id="respondent_employee"
                                                                   name="respondent_designation"
                                                                   value="নির্বাহী কর্মকর্তা ">
                                                            <label for="respondent_employee" class="custom-control-label">নির্বাহী কর্মকর্তা </label>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6 pb-3">
                                                        <div class="custom-control custom-radio">
                                                            <input class="custom-control-input" type="radio" id="respondent_manager"
                                                                   name="respondent_designation"
                                                                   value="ম্যানেজার">
                                                            <label for="respondent_manager" class="custom-control-label">ম্যানেজার</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6 pb-3">
                                                        <div class="custom-control custom-radio">
                                                            <input class="custom-control-input" type="radio" id="respondent_others"
                                                                   name="respondent_designation"
                                                                   value="অন্যান্য">
                                                            <label for="respondent_others" class="custom-control-label">অন্যান্য</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </section>
                                <h3>প্রতিষ্ঠানের প্রাথমিক তথ্য</h3>
                                <section>
                                    <div class="card-body p-1">
                                        <h3 clas="text-dark">প্রতিষ্ঠানের প্রাথমিক তথ্য</h3>
                                        <div class="row pt-4">
                                            <div class="col-sm-8 mb-4">
                                                <div class="form-group">
                                                    <label for="industry_sector">আপনার প্রতিষ্ঠানটি কোন সেক্টরের অন্তর্ভুক্ত?<span
                                                            style="color: red"> * </span></label>
                                                    <select name="industry_sector" id="industry_sector" class="form-control select">
                                                        <option value="">নির্বাচন করুন</option>
                                                        <option value="তৈরি পোশাক">তৈরি পোশাক</option>
                                                        <option value="এগ্রো ফুড">এগ্রো ফুড</option>
                                                        <option value="সিরামিক্স">সিরামিক্স</option>
                                                        <option value="ফার্মাসিউটিক্যাল">ফার্মাসিউটিক্যাল</option>
                                                        <option value="টুরিসম এন্ড হসপিটালিটি">টুরিসম এন্ড হসপিটালিটি</option>
                                                        <option value="লেদার এন্ড ফুটওয়ার">লেদার এন্ড ফুটওয়ার</option>
                                                        <option value="আইসিটি এন্ড ই-কমারস">আইসিটি এন্ড ই-কমারস</option>
                                                        <option value="কন্সট্রাকশন">কন্সট্রাকশন</option>
                                                        <option value="ফারনিচার">ফারনিচার</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-sm-4 mb-4">
                                                <div class="form-group">
                                                    <label for="industry_started">প্রতিষ্ঠার সময়কাল<span
                                                            style="color: red"> * </span></label>
                                                    <select name="industry_started" id="industry_started" class="form-control select">
                                                        <option value="">নির্বাচন করুন</option>
                                                        <option value="৩ বছরের নিচে">৩ বছরের নিচে</option>
                                                        <option value="৪-১০ বছরের">৪-১০ বছরের </option>
                                                        <option value="option 3">option 3</option>
                                                        <option value="১০ বছরের বেশি">১০ বছরের বেশি</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-sm-8">
                                                <div class="form-group">
                                                    <label for="industry_association">আপনার প্রতিষ্ঠানটি কোন এসোসিয়েশনের অন্তর্ভুক্ত?<span
                                                            style="color: red"> * </span></label>
                                                    <input type="text" class="form-control" id="industry_association"
                                                           name="industry_association"
                                                           placeholder="এসোসিয়েশনের নাম লিখুন">
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label for="industry_type">প্রতিষ্ঠানের ধরন<span
                                                            style="color: red"> * </span></label>
                                                    <select name="industry_type" id="industry_type" class="form-control select">
                                                        <option value="">নির্বাচন করুন</option>
                                                        <option value="পাবলিক ব্যাংক">পাবলিক ব্যাংক</option>
                                                        <option value="প্রাইভেট ব্যাংক">প্রাইভেট ব্যাংক</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </section>
                                <h3>কর্মী সংক্রান্ত তথ্য</h3>
                                <section>
                                    <div id="horizontal-wizard" class="card-body p-1">
                                        <div class="col-md-12 col-sm-12">
                                            <ul class="nav nav-tabs" role="tablist">
                                                <li class="nav-item">
                                                    <a class="padding-left-right nav-link active border-top-0 border-bottom-0 border-left-0 border-right-0 text-dark font-weight-bold" data-toggle="tab" href="#tabs-1" role="tab">কর্মীর তথ্য</a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="padding-left-right nav-link border-top-0 border-bottom-0 border-left-0 border-right-0 text-dark font-weight-bold" data-toggle="tab" href="#tabs-2" role="tab">স্তরভিত্তিক কর্মী কর্মরত</a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class=" padding-left-right nav-link border-top-0 border-bottom-0 border-left-0 border-right-0 text-dark font-weight-bold" data-toggle="tab" href="#tabs-3" role="tab">প্রতিষ্ঠানে কর্মী নিয়োগ </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class=" padding-left-right nav-link border-top-0 border-bottom-0 border-left-0 border-right-0 text-dark font-weight-bold" data-toggle="tab" href="#tabs-4" role="tab">দক্ষতা সম্পন্ন কর্মী </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class=" padding-left-right nav-link border-top-0 border-bottom-0 border-left-0 border-right-0 text-dark font-weight-bold" data-toggle="tab" href="#tabs-5" role="tab">মতামত </a>
                                                </li>
                                            </ul>
                                            <!-- Tab panes -->
                                            <div class="tab-content">
                                                <div class="tab-pane active" id="tabs-1" role="tabpanel">
                                                    <div class="row pt-4">
                                                        <div class="col-sm-6">
                                                            <div class="form-group">
                                                                <label for="total_employee_one">মোট কর্মী<span
                                                                        style="color: red"> * </span></label>
                                                                <input type="text" class="form-control" id="total_employee_one"
                                                                       name="total_employee_one"
                                                                       placeholder="কর্মী সংখ্যা লিখুন">
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <div class="form-group">
                                                                <label for="full_time_employee_one">পূর্ণকালীন কর্মী সংখ্যা<span
                                                                        style="color: red"> * </span></label>
                                                                <input type="text" class="form-control" id="full_time_employee_one"
                                                                       name="full_time_employee_one"
                                                                       placeholder="পূর্ণকালীন কর্মী সংখ্যা লিখুন">
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <div class="form-group">
                                                                <label for="half_time_employee_one">খন্ডকালীন কর্মী সংখ্যা<span
                                                                        style="color: red"> * </span></label>
                                                                <input type="text" class="form-control" id="half_time_employee_one"
                                                                       name="half_time_employee_one"
                                                                       placeholder="খন্ডকালীন কর্মী সংখ্যা লিখুন">
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <div class="form-group">
                                                                <label for="female_number_one">নারীর সংখ্যা<span
                                                                        style="color: red"> * </span></label>
                                                                <input type="text" class="form-control" id="female_number_one"
                                                                       name="female_number_one"
                                                                       placeholder="নারীর সংখ্যা লিখুন">
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <div class="form-group">
                                                                <label for="male_number_one">পুরুষ সংখ্যা<span
                                                                        style="color: red"> * </span></label>
                                                                <input type="text" class="form-control" id="male_number_one"
                                                                       name="male_number_one"
                                                                       placeholder="পুরুষ সংখ্যা লিখুন">
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <label for="others_number_one">আপনি কি তৃতীয় লিঙ্গের?<span
                                                                    class="required"> *</span> </label>
                                                            <div class="row">
                                                                <div class="col-md-6 col-sm-6">
                                                                    <div class="custom-control custom-radio">
                                                                        <input class="custom-control-input" type="radio" id="g_yes"
                                                                               name="others_number_one"
                                                                               value="yes">
                                                                        <label for="g_yes" class="custom-control-label margin-top-bottom-half-em">হ্যাঁ</label>
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-6 col-sm-6">
                                                                    <div class="custom-control custom-radio">
                                                                        <input class="custom-control-input" type="radio" id="g_no"
                                                                               name="others_number_one"
                                                                               value="no">
                                                                        <label for="g_no" class="custom-control-label margin-top-bottom-half-em">না</label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-sm-6 mt-3" id="others_total_number_section" style="display: none;">
                                                            <div class="form-group">
                                                                <label for="others_total_number">তৃতীয় লিঙ্গের সংখ্যা<span
                                                                        style="color: red"> * </span></label>
                                                                <input type="text" class="form-control" id="others_total_number"
                                                                       name="others_total_number"
                                                                       placeholder="তৃতীয় লিঙ্গের সংখ্যা">
                                                            </div>
                                                        </div>

                                                        <div class="col-sm-6  mt-3" id="disabled_person">
                                                            <label for="disabled_person">আপনি কি প্রতিবন্দী?<span
                                                                    class="required"> *</span> </label>
                                                            <div class="row">
                                                                <div class="col-md-6 col-sm-6">
                                                                    <div class="custom-control custom-radio">
                                                                        <input class="custom-control-input" type="radio" id="d_yes"
                                                                               name="disabled_person"
                                                                               value="yes">
                                                                        <label for="d_yes" class="custom-control-label margin-top-bottom-half-em">হ্যাঁ</label>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6 col-sm-6">
                                                                    <div class="custom-control custom-radio">
                                                                        <input class="custom-control-input" type="radio" id="d_no"
                                                                               name="disabled_person"
                                                                               value="no">
                                                                        <label for="d_no" class="custom-control-label margin-top-bottom-half-em">না</label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6 mt-3" id="disabled_person_number_section" style="display: none;">
                                                            <div class="form-group">
                                                                <label for="disabled_person_number">প্রতিবন্দী সংখ্যা<span
                                                                        style="color: red"> * </span></label>
                                                                <input type="text" class="form-control" id="disabled_person_number"
                                                                       name="disabled_person_number"
                                                                       placeholder="প্রতিবন্দী সংখ্যা">
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6 mt-3" id="unhelped_group_select">
                                                            <label for="unhelped_group">অন্যান্য সুবিধা বঞ্চিত গোষ্ঠী ?<span
                                                                    class="required"> *</span> </label>
                                                            <div class="row">
                                                                <div class="col-md-6 col-sm-6">
                                                                    <div class="custom-control custom-radio">
                                                                        <input class="custom-control-input" type="radio" id="ug_yes"
                                                                               name="unhelped_group"
                                                                               value="yes">
                                                                        <label for="ug_yes" class="custom-control-label margin-top-bottom-half-em">হ্যাঁ</label>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6 col-sm-6">
                                                                    <div class="custom-control custom-radio">
                                                                        <input class="custom-control-input" type="radio" id="ug_no"
                                                                               name="unhelped_group"
                                                                               value="no">
                                                                        <label for="ug_no" class="custom-control-label margin-top-bottom-half-em">না</label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6 mt-3" id="unhelped_group_number" style="display: none;">
                                                            <div class="form-group">
                                                                <label for="unhelped_group_number">সুবিধা বঞ্চিত গোষ্ঠী সংখ্যা<span
                                                                        style="color: red"> * </span></label>
                                                                <input type="text" class="form-control" id="unhelped_group_number"
                                                                       name="unhelped_group_number"
                                                                       placeholder="সুবিধা বঞ্চিত গোষ্ঠী সংখ্যা">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="tab-pane" id="tabs-2" role="tabpanel">
                                                    <h4 class="p-2 mt-3 mb-3">আপনার প্রতিষ্ঠানে বর্তমানে কোন স্তরে কতজন কর্মী কর্মরত রয়েছে?</h4>
                                                    <div class="row">
                                                        <div class="col-sm-6">
                                                            <div class="form-group">
                                                                <label for="senior_level_one">সিনিয়র লেভেল<span
                                                                        style="color: red"> * </span></label>
                                                                <input type="text" class="form-control" id="senior_level_one"
                                                                       name="senior_level_one"
                                                                       placeholder="কর্মী সংখ্যা লিখুন">
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <div class="form-group">
                                                                <label for="middle_level_one">মধ্যম লেভেল<span
                                                                        style="color: red"> * </span></label>
                                                                <input type="text" class="form-control" id="middle_level_one"
                                                                       name="middle_level_one"
                                                                       placeholder="কর্মী সংখ্যা লিখুন">
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <div class="form-group">
                                                                <label for="junior_level_one">জুনিয়ার লেভেল<span
                                                                        style="color: red"> * </span></label>
                                                                <input type="text" class="form-control" id="junior_level_one"
                                                                       name="junior_level_one"
                                                                       placeholder="কর্মী সংখ্যা লিখুন">
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <label for="outside_employee">আপনি বিদেশে কর্মী নিয়োগ করেছেন?<span
                                                                    class="required"> *</span> </label>
                                                            <div class="row">
                                                                <div class="col-md-6 col-sm-6">
                                                                    <div class="custom-control custom-radio">
                                                                        <input class="custom-control-input" type="radio" id="oe_yes"
                                                                               name="outside_employee"
                                                                               value="yes">
                                                                        <label for="oe_yes" class="custom-control-label margin-top-bottom-half-em">হ্যাঁ</label>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6 col-sm-6">
                                                                    <div class="custom-control custom-radio">
                                                                        <input class="custom-control-input" type="radio" id="oe_no"
                                                                               name="outside_employee"
                                                                               value="no">
                                                                        <label for="oe_no" class="custom-control-label margin-top-bottom-half-em">না</label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row" id="foreign_employee_section" style="display:none">
                                                        <div class="col-sm-6">
                                                            <div class="form-group">
                                                                <label for="other_country_employee_number">বিদেশী কর্মী সংখ্যা লিখুন<span
                                                                        style="color: red"> * </span></label>
                                                                <input type="text" class="form-control" id="other_country_employee_number"
                                                                       name="other_country_employee_number"
                                                                       placeholder="কর্মী সংখ্যা লিখুন">
                                                            </div>
                                                        </div>
                                                        <h4 class="p-2 mt-5 mb-4">কোন স্তরে কত জন বিদেশ কর্মী রয়েছে?</h4>
                                                        <div class="col-sm-6">
                                                            <div class="form-group">
                                                                <label for="senior_level_two">সিনিয়র লেভেল<span
                                                                        style="color: red"> * </span></label>
                                                                <input type="text" class="form-control" id="senior_level_two"
                                                                       name="senior_level_two"
                                                                       placeholder="কর্মী সংখ্যা লিখুন">
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <div class="form-group">
                                                                <label for="middle_level_two">মধ্যম লেভেল<span
                                                                        style="color: red"> * </span></label>
                                                                <input type="text" class="form-control" id="middle_level_two"
                                                                       name="middle_level_two"
                                                                       placeholder="কর্মী সংখ্যা লিখুন">
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <div class="form-group">
                                                                <label for="junior_level_two">জুনিয়ার লেভেল<span
                                                                        style="color: red"> * </span></label>
                                                                <input type="text" class="form-control" id="junior_level_two"
                                                                       name="junior_level_two"
                                                                       placeholder="কর্মী সংখ্যা লিখুন">
                                                            </div>

                                                            <label for="employee_problem">আপনার উল্লেখিত স্তরগুলোর মধ্যে কোন স্তরে কর্মী পেতে সমস্যা হয় কি?<span
                                                                    class="required"> *</span> </label>
                                                            <div class="row">
                                                                <div class="col-md-6 col-sm-6">
                                                                    <div class="custom-control custom-radio">
                                                                        <input class="custom-control-input" type="radio" id="ep_yes"
                                                                               name="employee_problem"
                                                                               value="yes">
                                                                        <label for="ep_yes" class="custom-control-label margin-top-bottom-half-em">হ্যাঁ</label>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6 col-sm-6">
                                                                    <div class="custom-control custom-radio">
                                                                        <input class="custom-control-input" type="radio" id="ep_no"
                                                                               name="employee_problem"
                                                                               value="no">
                                                                        <label for="ep_no" class="custom-control-label margin-top-bottom-half-em">না</label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6" id="employee_problem_detail_section" style="display:none;">
                                                            <div class="form-group">
                                                                <label for="employee_problem_detail">কোন স্তরে কি সমস্যা হয়?<span
                                                                        class="required"> *</span></label>
                                                                <textarea class="form-control" id="employee_problem_detail"
                                                                          name="employee_problem_detail"
                                                                          rows="6"
                                                                          placeholder="স্তরভিত্তিক সমস্যাগুলো লিখুন"></textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="tab-pane" id="tabs-3" role="tabpanel">
                                                    <h4 class="p-2 mt-3 mb-3">আপনার প্রতিষ্ঠানে নিয়োগের ক্ষেত্রে কোন ধরনের কর্মী নিয়োগ করবেন?</h4>
                                                    <p class="pt-2 pb-2 font-weight-bold"> কর্মী নিয়োগ প্রতিষ্ঠান ভিত্তিক </p>
                                                    <div id ="question1" class="accordion">
                                                        <div class="card shadow-none mb-0 bg-accordion">
                                                            <div id="heading" class="card-header border">
                                                                <h2 class="mb-0">
                                                                    <button type="button" data-toggle="collapse" data-target="#collapse"
                                                                            aria-expanded="true" aria-controls="collapseOne"
                                                                            class="btn btn-link text-dark font-weight-bold text-uppercase collapsible-link">
                                                                        নির্বাচন করুন
                                                                </h2>
                                                            </div>
                                                            <div id="collapse" aria-labelledby="heading" data-parent="#question1" class="collapse">
                                                                <div class="card-body p-2 pl-4 border">
                                                                    <div class="custom-control custom-checkbox form-check-inline" style="padding-left: 1.5rem !important;">
                                                                        <input class="custom-control-input" type="checkbox" name="employee_recruitment[]" id="inlineCheckbox1" value="প্রফেশনাল">
                                                                        <label class="custom-control-label" for="inlineCheckbox1">প্রফেশনাল</label>
                                                                    </div>
                                                                    <div class="custom-control custom-checkbox form-check-inline" style="padding-left: 1.5rem !important;">
                                                                        <input class="custom-control-input" type="checkbox" name="employee_recruitment[]" id="inlineCheckbox2" value="প্রশিক্ষন প্রাপ্ত">
                                                                        <label class="custom-control-label" for="inlineCheckbox2">প্রশিক্ষন প্রাপ্ত</label>
                                                                    </div>
                                                                    <div class="custom-control custom-checkbox form-check-inline" style="padding-left: 1.5rem !important;">
                                                                        <input class="custom-control-input" type="checkbox" name="employee_recruitment[]" id="inlineCheckbox3" value="প্রশিক্ষন বিহীন">
                                                                        <label class="custom-control-label" for="inlineCheckbox3">প্রশিক্ষন বিহীন</label>
                                                                    </div>
                                                                    <div class="custom-control custom-checkbox form-check-inline" style="padding-left: 1.5rem !important;">
                                                                        <input class="custom-control-input" type="checkbox" name="employee_recruitment[]" id="inlineCheckbox4" value="শিক্ষানবিশ">
                                                                        <label class="custom-control-label" for="inlineCheckbox4">শিক্ষানবিশ</label>
                                                                    </div>
                                                                    <div class="custom-control custom-checkbox form-check-inline" style="padding-left: 1.5rem !important;">
                                                                        <input class="custom-control-input" type="checkbox" name="employee_recruitment[]" id="inlineCheckbox5" value="অন্যান্য">
                                                                        <label class="custom-control-label" for="inlineCheckbox5">অন্যান্য</label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <p class="pt-5 mb-2 font-weight-bold"> প্রশিক্ষনপ্রাপ্ত হলে আপনার প্রতিষ্ঠানে কী কী সুবিধা হয়? </p>
                                                    <div id ="question2" class="accordion">
                                                        <div class="card shadow-none mb-0 bg-accordion">
                                                            <div id="heading" class="card-header border">
                                                                <h2 class="mb-0">
                                                                    <button type="button" data-toggle="collapse" data-target="#collapse2"
                                                                            aria-expanded="true" aria-controls="collapseTwo"
                                                                            class="btn btn-link text-dark font-weight-bold text-uppercase collapsible-link">
                                                                        নির্বাচন করুন
                                                                </h2>
                                                            </div>
                                                            <div id="collapse2" aria-labelledby="heading" data-parent="#question2" class="collapse">
                                                                <div class="card-body p-2 pl-4 border">
                                                                    <div class="custom-control custom-checkbox border-0" style="padding-left: 1.5rem !important;">
                                                                        <input class="custom-control-input" type="checkbox" name="institute_facilities" id="inlineCheckbox6" value="চামালের সর্বচ্চো ব্যবহার নিশ্চিত হয়">
                                                                        <label class="custom-control-label" for="inlineCheckbox6">চামালের সর্বচ্চো ব্যবহার নিশ্চিত হয়</label>
                                                                    </div>
                                                                    <div class="custom-control custom-checkbox border-0" style="padding-left: 1.5rem !important;">
                                                                        <input class="custom-control-input" type="checkbox" name="institute_facilities" id="inlineCheckbox7" value="উৎপাদনশীলতা বাড়ে">
                                                                        <label class="custom-control-label" for="inlineCheckbox7">উৎপাদনশীলতা বাড়ে </label>
                                                                    </div>
                                                                    <div class="custom-control custom-checkbox border-0" style="padding-left: 1.5rem !important;">
                                                                        <input class="custom-control-input" type="checkbox" name="institute_facilities" id="inlineCheckbox8" value="শ্রমবিভাজন করতে সুবিধা হয়">
                                                                        <label class="custom-control-label" for="inlineCheckbox8">শ্রমবিভাজন করতে সুবিধা হয়</label>
                                                                    </div>
                                                                    <div class="custom-control custom-checkbox border-0" style="padding-left: 1.5rem !important;">
                                                                        <input class="custom-control-input" type="checkbox" name="institute_facilities" id="inlineCheckbox9" value="উৎপাদিত পণ্যের গুনগত মান বৃদ্ধি পায়">
                                                                        <label class="custom-control-label" for="inlineCheckbox9">উৎপাদিত পণ্যের গুনগত মান বৃদ্ধি পায়</label>
                                                                    </div>
                                                                    <div class="custom-control custom-checkbox border-0" style="padding-left: 1.5rem !important;">
                                                                        <input class="custom-control-input" type="checkbox" name="institute_facilities" id="inlineCheckbox10" value="প্রতিষ্ঠানের আয় বৃদ্ধি পায়">
                                                                        <label class="custom-control-label" for="inlineCheckbox10">প্রতিষ্ঠানের আয় বৃদ্ধি পায়</label>
                                                                    </div>
                                                                    <div class="custom-control custom-checkbox border-0" style="padding-left: 1.5rem !important;">
                                                                        <input class="custom-control-input" type="checkbox" name="institute_facilities" id="inlineCheckbox11" value="অন্যান্য">
                                                                        <label class="custom-control-label" for="inlineCheckbox11">অন্যান্য</label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <p class="pt-5 mb-2 font-weight-bold"> আপনার প্রতিষ্ঠানে নিয়োগের ক্ষেত্রে কোন মাধ্যম ব্যাবহার করেন? </p>
                                                    <div id ="question3" class="accordion">
                                                        <div class="card shadow-none mb-0 bg-accordion">
                                                            <div id="heading" class="card-header border">
                                                                <h2 class="mb-0">
                                                                    <button type="button" data-toggle="collapse" data-target="#collapse3"
                                                                            aria-expanded="true" aria-controls="collapseThree"
                                                                            class="btn btn-link text-dark font-weight-bold text-uppercase collapsible-link">
                                                                        নির্বাচন করুন
                                                                </h2>
                                                            </div>
                                                            <div id="collapse3" aria-labelledby="heading" data-parent="#question3" class="collapse">
                                                                <div class="card-body p-2 pl-4 border">
                                                                    <div class="custom-control custom-checkbox border-0" style="padding-left: 1.5rem !important;">
                                                                        <input class="custom-control-input" type="checkbox" name="recruitment_media" id="inlineCheckbox12" value="জব ফেয়ার">
                                                                        <label class="custom-control-label" for="inlineCheckbox12">জব ফেয়ার</label>
                                                                    </div>
                                                                    <div class="custom-control custom-checkbox border-0" style="padding-left: 1.5rem !important;">
                                                                        <input class="custom-control-input" type="checkbox" name="recruitment_media" id="inlineCheckbox13" value="পত্রিকায় বিজ্ঞাপন">
                                                                        <label class="custom-control-label" for="inlineCheckbox13">পত্রিকায় বিজ্ঞাপন</label>
                                                                    </div>
                                                                    <div class="custom-control custom-checkbox border-0" style="padding-left: 1.5rem !important;">
                                                                        <input class="custom-control-input" type="checkbox" name="recruitment_media" id="inlineCheckbox14" value="্যক্তি মাধ্যম">
                                                                        <label class="custom-control-label" for="inlineCheckbox14">ব্যক্তি মাধ্যম</label>
                                                                    </div>
                                                                    <div class="custom-control custom-checkbox border-0" style="padding-left: 1.5rem !important;">
                                                                        <input class="custom-control-input" type="checkbox" name="recruitment_media" id="inlineCheckbox15" value="জব পোর্টাল">
                                                                        <label class="custom-control-label" for="inlineCheckbox15">জব পোর্টাল</label>
                                                                    </div>
                                                                    <div class="custom-control custom-checkbox border-0" style="padding-left: 1.5rem !important;">
                                                                        <input class="custom-control-input" type="checkbox" name="recruitment_media" id="inlineCheckbox16" value="অন্যান্য">
                                                                        <label class="custom-control-label" for="inlineCheckbox16">অন্যান্য</label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="tab-pane" id="tabs-4" role="tabpanel">
                                                    <div class="efficient-employee-contents">

                                                    </div>
                                                    <div class="col-md-12">
                                                        <a class="btn  btn-outline-primary float-left  add-employee"><i class="fa fa-plus-circle fa-fw"></i> কর্মী যোগ করুন</a>
                                                    </div>
                                                </div>
                                                <div class="tab-pane" id="tabs-5" role="tabpanel">
                                                    <div class="col-sm-12 pt-4">
                                                        <div class="form-group">
                                                            <label for="decision_problem_1">বর্ণিত পেশা/অকুপেশন/কোর্স/ট্রেডসমূহ ছাড়া চতুর্থ শিল্প-বিপ্লবের চাহিদার আলোকে আর কি কি বিষয়ে চাহিদা তৈরি হবে এবং
                                                                সে বিষয়ে প্রশিক্ষন দেয়া যেতে পারে বলে আপনি মনে করেন?<span
                                                                    class="required"> *</span></label>
                                                            <textarea class="form-control" id="decision_problem_1"
                                                                      name="decision_problem_1"
                                                                      rows="5"
                                                                      placeholder="আপনার বক্তব্য লিখুন"></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-12">
                                                        <div class="form-group">
                                                            <label for="decision_problem_2">চতুর্থ শিল্প-বিপ্লব ভিত্তিক পেশা/অকুপেশন/কোর্স/ট্রেডে দক্ষতা উন্নয়নের জন্য শিল্প-প্রতিষ্ঠান/শিল্প সমিতি/চেম্বার অফ কমার্সের
                                                                কি ধরনের পদক্ষেপ নিতে পারে বলে আপনি মনে করেন?<span
                                                                    class="required"> *</span></label>
                                                            <textarea class="form-control" id="decision_problem_2"
                                                                      name="decision_problem_2"
                                                                      rows="5"
                                                                      placeholder="আপনার বক্তব্য লিখুন"></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-12">
                                                        <div class="form-group">
                                                            <label for="decision_problem_3">চতুর্থ শিল্প-বিপ্লব ভিত্তিক পেশা/অকুপেশন/কোর্স/ট্রেডে দক্ষতা উন্নয়নের জন্য প্রশিক্ষণ প্রতিষ্ঠানসমূহ কি ধরনের পদক্ষেপ নিলে
                                                                দক্ষতা বৃদ্ধির কাজটি সঠিক ও দ্রুত কার্যকর হতে পারে বলে আপনি মনে করেন?<span
                                                                    class="required"> *</span></label>
                                                            <textarea class="form-control" id="decision_problem_3"
                                                                      name="decision_problem_3"
                                                                      rows="5"
                                                                      placeholder="আপনার বক্তব্য লিখুন"></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-12">
                                                        <div class="form-group">
                                                            <label for="decision_problem_4">চতুর্থ শিল্প-বিপ্লব ভিত্তিক পেশা/অকুপেশনে প্রশিক্ষণ প্রাপ্ত হলে আপনি কোথা থেকে প্রশিক্ষণপ্রাপ্ত কর্মী নিয়োগ করবেন?<span
                                                                    class="required"> *</span></label>
                                                            <div class="card-body bg-accordion rounded">
                                                                <div class="custom-control custom-checkbox border-0" style="padding-left: 1.5rem !important;">
                                                                    <input class="custom-control-input" type="checkbox" name="decision_problem_4" id="inlineCheckbox17" value="জব ফেয়ার">
                                                                    <label class="custom-control-label" for="inlineCheckbox17">জব ফেয়ার</label>
                                                                </div>
                                                                <div class="custom-control custom-checkbox border-0" style="padding-left: 1.5rem !important;">
                                                                    <input class="custom-control-input" type="checkbox" name="decision_problem_4" id="inlineCheckbox18" value="পত্রিকায় বিজ্ঞাপন">
                                                                    <label class="custom-control-label" for="inlineCheckbox18">পত্রিকায় বিজ্ঞাপন</label>
                                                                </div>
                                                                <div class="custom-control custom-checkbox border-0" style="padding-left: 1.5rem !important;">
                                                                    <input class="custom-control-input" type="checkbox" name="decision_problem_4" id="inlineCheckbox19" value="ব্যক্তি মাধ্যম">
                                                                    <label class="custom-control-label" for="inlineCheckbox19">ব্যক্তি মাধ্যম</label>
                                                                </div>
                                                                <div class="custom-control custom-checkbox border-0" style="padding-left: 1.5rem !important;">
                                                                    <input class="custom-control-input" type="checkbox" name="decision_problem_4" id="inlineCheckbox20" value="জব পোর্টাল">
                                                                    <label class="custom-control-label" for="inlineCheckbox20">জব পোর্টাল</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-12">
                                                        <div class="form-group">
                                                            <label for="decision_problem_5">আপনার মতামত লিখুন অথবা পরামর্শ দিন<span
                                                                    class="required"> *</span></label>
                                                            <textarea class="form-control" id="decision_problem_5"
                                                                      name="decision_problem_5"
                                                                      rows="5"
                                                                      placeholder="মতামত অথবা পরামর্শ লিখুন"></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </section>
                            </div>
                        </form>
                    </div>

                    <div class="overlay" style="display: none">
                        <i class="fas fa-2x fa-sync-alt fa-spin"></i>
                    </div>

                </div>
            </div>
        </div>
    </div>

@endsection
@push('css')
    <link rel="stylesheet" href="{{asset('css/jquery-steps.css')}}">
@endpush
@push('js')

    <script type="text/javascript" src="{{asset('/js/jquery-steps/jquery.steps.min.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lodash.js/4.17.21/lodash.js"></script>

    <x-generic-validation-error-toastr></x-generic-validation-error-toastr>

    <script>
        let employeeFullForm = $("#employee-vertical-wizard");
        employeeFullForm.children("div").steps({
            headerTag: "h3",
            bodyTag: "section",
            transitionEffect: "fade",
            stepsOrientation: "vertical",
            labels: {
                next: "পরবর্তীতে যান",
                previous: "পূর্বে যান",
                finish: "সাবমিট",
            },
            onStepChanging: function (event, currentIndex, newIndex)
            {
                // Allways allow previous action even if the current form is not valid!
                if (currentIndex > newIndex)
                {
                    return true;
                }
                if (currentIndex < newIndex)
                {
                    // To remove error styles
                    employeeFullForm.find(".body:eq(" + newIndex + ") label.error").remove();
                    employeeFullForm.find(".body:eq(" + newIndex + ") .error").removeClass("error");
                }
                employeeFullForm.validate().settings.ignore = ":disabled, :hidden";
                return employeeFullForm.valid();
            },
            onStepChanged: function (event, currentIndex, priorIndex)
            {
                // Used to skip the "Warning" step if the user is old enough and wants to the previous step.
                if (currentIndex === 2 && priorIndex === 3)
                {
                    employeeFullForm.steps("previous");
                }
            },
            onFinishing: function (event, currentIndex)
            {
                employeeFullForm.validate().settings.ignore = "";
                return employeeFullForm.valid();
            },
            onFinished: function (event, currentIndex)
            {
                $("#employee-vertical-wizard").submit();
            }
        });

        $("#employee-vertical-wizard").validate({
            rules:{
                informant_name: {
                    required: true,
                },
                informant_mobile: {
                    required: true,
                    pattern: /^(?:\+88|88)?(01[3-9]\d{8})$/,
                },
                informant_email: {
                    required: true,
                    pattern: /^[^\s@]+@[^\s@]+$/,
                },
                informant_date: {
                    required: true,
                },
                respondent_name: {
                    required: true,
                },
                respondent_designation: {
                    required: true,
                },
                industry_sector: {
                    required: true,
                },
                industry_started: {
                    required: true,
                },
                industry_association: {
                    required: true,
                },
                industry_type: {
                    required: true,
                },
                total_employee_one: {
                    required: true,
                    digits: true
                },
                full_time_employee_one: {
                    required: true,
                    digits: true
                },
                half_time_employee_one: {
                    required: true,
                    digits: true
                },
                female_number_one: {
                    required: true,
                    digits: true
                },
                male_number_one: {
                    required: true,
                    digits: true
                },
                outside_employee: {
                    required: true,
                },
                others_number_one: {
                    required: true,
                },
                disabled_person: {
                    required: true,
                },
                unhelped_group: {
                    required: true,
                },
                senior_level_one: {
                    required: true,
                    digits: true
                },
                middle_level_one: {
                    required: true,
                    digits: true
                },
                junior_level_one: {
                    required: true,
                    digits: true
                },
                senior_level_two: {
                    required: true,
                    digits: true
                },
                middle_level_two: {
                    required: true,
                    digits: true
                },
                junior_level_two: {
                    required: true,
                    digits: true
                },
                other_country_employee_number: {
                    required: true,
                    digits: true
                },
                employee_problem: {
                    required: true,
                },
                employee_problem_detail: {
                    required: true,
                },
                'employee_recruitment[]': {
                    required:true,
                },
                institute_facilities: {
                    required: true,
                },
                recruitment_media: {
                    required: true
                },
                decision_problem_1:{
                    required: true,
                },
                decision_problem_2:{
                    required: true,
                },
                decision_problem_3:{
                    required: true,
                },
                decision_problem_4:{
                    required: true,
                },
                decision_problem_5:{
                    required: true,
                },
                employee_level_occupation:{
                    required:true,
                },
            }
        });

        var efficient_employees = $('input[name^="efficient_employees"]');

        efficient_employees.filter('input[name$="[employee_level_occupation]"]').each(function() {
            $(this).rules("add", {
                required: true
            });
        });

        $('input[name="outside_employee"]').on('change', function () {
            if($(this).val() =='yes'){
                $("#foreign_employee_section").show();
            }
            else {
                $("#foreign_employee_section").hide();
            }
        });

        $('input[name="employee_problem"]').on('change', function () {
            if($(this).val() =='yes'){
                $("#employee_problem_detail_section").show();
            }
            else {
                $("#employee_problem_detail_section").hide();
            }
        });
        $('input[name="others_number_one"]').on('change', function () {
            if($(this).val() =='yes'){
                $("#others_total_number_section").show();
            }
            else {
                $("#others_total_number_section").hide();
            }
        });

        $('input[name="disabled_person"]').on('change', function () {
            if($(this).val() =='yes'){
                $("#disabled_person_number_section").show();
            }
            else {
                $("#disabled_person_number_section").hide();
            }
        });
        $('input[name="unhelped_group"]').on('change', function () {
            if($(this).val() =='yes'){
                $("#unhelped_group_number").show();
            }
            else {
                $("#unhelped_group_number").hide();
            }
        });

        const EDIT = !!'{{$edit}}';
        let SL = 0;

        function addRow(data = {}) {
            console.log('SL: ' + SL)
            let efficientEmployee = _.template($('#efficient-employee').html());
            console.table('efficcent template:', efficientEmployee);
            let efficientEmployeeContentElm = $(".efficient-employee-contents");
            efficientEmployeeContentElm.append(efficientEmployee({sl: SL, data: data, edit: EDIT}));
            efficientEmployeeContentElm.find('.flat-date').each(function () {
                $(this).flatpickr({
                    altInput: false,
                    altFormat: "j F, Y",
                    dateFormat: "Y-m-d",
                });
            });
            SL++;
        }

        $.validator.addMethod(
            "employeeLevelOccupation",
            function (value, element) {
                let regexp = /^[a-zA-Z0-9 ]*$/;
                let re = new RegExp(regexp);
                return this.optional(element) || re.test(value);
            },
            "Please fill this field in English."
        );
        $.validator.addClassRules("employee_level_occupation", {
            required: true,
            employeeLevelOccupation: true,
        });

        function deleteRow(slNo) {
            let employeeELm = $("#efficient-employee-no-" + slNo);
            console.log(employeeELm.find('.delete_status').length);
            if (employeeELm.find('.delete_status').length) {
                employeeELm.find('.delete_status').val(1);
                employeeELm.hide();
            } else {
                employeeELm.remove();
            }
        }

        $(document).ready(function () {
            $.validator.setDefaults({ ignore: "" });
            @if($edit && $publishCourse->courseSessions->count())
            @foreach($publishCourse->courseSessions as $session)
            addRow(@json($session));
            @endforeach
            @else
            addRow();
            @endif
            $(document).on('click', '.add-employee', function () {
                addRow();
            });
        });

    </script>
    <script type="text/template" id="efficient-employee">
        <div class="card mt-4" id="efficient-employee-no-<%=sl%>">
            <div class="card-header bg-primary">
                <h4 class="text-white p-3">আপনার প্রতিষ্ঠানে আগামী ৫ বছরে কোন ধরনের দক্ষতা সম্পন্ন কর্মী প্রয়োজন হবে?</h4>

            </div>
            <div class="card-body bg-accordion">
                <div class="row">
                    <% if(edit && data.id) { %>
                    <input type="hidden" id="efficient_employees_<%=data.id%>" name="efficient_employees_[<%=sl%>][id]"
                           value="<%=data.id%>">
                    <input type="hidden" name="efficient_employees[<%=sl%>][delete]" class="delete_status" value="0"/>
                    <% } %>
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label for="employee_level_occupation">স্তরকর্মীর সংখ্যাপেশা/অকুপেশন/কোর্স/ ট্রেডের নাম<span
                                    style="color: red"> * </span></label>
                            <input type="text" class="form-control" id="employee_level_occupation"
                                   name="efficient_employees[<%=sl%>][employee_level_occupation]"
                                   placeholder="লিখুন">
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="senior_level_occupation">সিনিয়র লেভেল<span
                                    style="color: red"> * </span></label>
                            <input type="text" class="form-control" id="senior_level_occupation"
                                   name="efficient_employees[<%=sl%>][senior_level_occupation]"
                                   placeholder="কর্মী সংখ্যা লিখুন">
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="middle_level_occupation">মধ্যম লেভেল<span
                                    style="color: red"> * </span></label>
                            <input type="text" class="form-control" id="middle_level_occupation"
                                   name="efficient_employees[<%=sl%>][middle_level_occupation]"
                                   placeholder="কর্মী সংখ্যা লিখুন">
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="junior_level_occupation">জুনিয়ার লেভেল<span
                                    style="color: red"> * </span></label>
                            <input type="text" class="form-control" id="junior_level_occupation"
                                   name="efficient_employees[<%=sl%>][junior_level_occupation]"
                                   placeholder="কর্মী সংখ্যা লিখুন">
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <button style="margin-top: 50px;" class="btn  btn-outline-danger float-right delete-employee"
                                onclick="deleteRow(<%=sl%>)"
                        ><i class="fa fa-minus-circle fa-fw"></i> কর্মী বাদ করুন</button>
                    </div>
                </div>
            </div>
        </div>
    </script>
@endpush
