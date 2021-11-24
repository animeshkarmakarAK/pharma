@php
    $currentInstitute = domainConfig('institute');
    $layout = 'master::layouts.smef-front-end';

@endphp

@extends($layout)

@section('title')
    রেজিস্ট্রেশন ফর্ম
@endsection

@section('content')
    <div class="container-fluid">

        <div class="row">
            <div class="col-md-12">
                <form class="row reg-form" action="" method="" enctype="multipart/form-data">
                    <div class="card mt-2">
                        <div class="card-header d-flex custom-bg-gradient-info mt-2">
                            <h3 class="card-title font-weight-bold text-primary">
                                <i class="fab fa-wpforms"> </i>
                                ব্যক্তিগত এবং সংস্থার তথ্য/Personal And Organization Information
                            </h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="name_en">নাম (ইংরেজি) <span class="required">*</span> :</label>
                                    <input type="text" class="form-control" name="name_en" id="name_en"
                                           value="{{ old('name_en') }}"
                                           placeholder="নাম">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="name_bn">নাম (বাংলা) <span class="required">*</span> :</label>
                                    <input type="text" class="form-control" name="name_bn" id="name_bn"
                                           value="{{ old('name_bn') }}"
                                           placeholder="নাম">
                                </div>

                                <div
                                    class="form-group col-md-6">
                                    <label for="mobile">মোবাইল নাম্বার <span class="required">*</span>
                                        :</label>
                                    <input type="text" class="form-control" name="mobile" id="mobile"
                                           value="{{ old('mobile') }}"
                                           placeholder="মোবাইল নাম্বার ">
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="mailing_address">মেইলিং এড্রেস <span class="required">*</span>
                                        :</label>
                                    <textarea rows="1" type="text" class="form-control" name="mailing_address"
                                              id="mailing_address"
                                              placeholder="মেইলিং এড্রেস">{{ old('mailing_address') }}</textarea>
                                </div>

                                <div
                                    class="form-group col-md-6">
                                    <label for="email">ইমেইল <span class="required">*</span>
                                        :</label>
                                    <input type="text" class="form-control" name="email" id="email"
                                           value="{{ old('email') }}"
                                           placeholder="ইমেল">
                                </div>

                                <div
                                    class="form-group col-md-6">
                                    <label for="conform_email">কনফার্ম ইমেইল <span class="required">*</span>
                                        :</label>
                                    <input type="text" class="form-control" name="conform_email" id="conform_email"
                                           value="{{ old('conform_email') }}"
                                           placeholder="কনফার্ম ইমেইল">
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="father_or_husband_name">পিতা/স্বামীর নাম <span class="required">*</span>
                                        :</label>
                                    <input type="text" class="form-control" name="father_or_husband_name" id="father_or_husband_name"
                                           value="{{ old('father_or_husband_name') }}"
                                           placeholder="পিতা/স্বামীর নাম">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="mother_name">মাতার নাম <span class="required">*</span> :</label>
                                    <input type="text" class="form-control" name="mother_name" id="mother_name"
                                           value="{{ old('mother_name') }}"
                                           placeholder="মাতার নাম">
                                </div>

                                <div class="form-group col-md-6 mb-5">
                                    <label for="district">জেলা <span class="required">*</span> :</label>
                                    <select class="form-control select2-ajax-wizard"
                                            name="loc_district_id"
                                            id="loc_district_id"
                                            data-model="{{base64_encode(App\Models\LocDistrict::class)}}"
                                            data-label-fields="{title} - {title_en}"
                                            data-placeholder="{{ __('নির্বাচন করুন') }}">
                                    </select>
                                </div>

                                <div
                                    class="form-group col-md-6 mb-5">
                                    <label for="date_of_birth">জন্ম তারিখ
                                        <span class="required">*</span> :</label>
                                    <input type="text" class="form-control flat-date date_of_birth"
                                           name="date_of_birth"
                                           id="date_of_birth"
                                           value="{{ old('date_of_birth') }}"
                                           placeholder="জন্ম তারিখ">
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="gender">লিঙ্গ<span class="required"> *</span> :</label>
                                    <div
                                        class="d-md-flex form-control"
                                        style="display: inline-table;">
                                        <div class="custom-control custom-radio mr-3">
                                            <input class="custom-control-input" type="radio" id="gender_male"
                                                   name="gender"
                                                   value="{{ \Module\CourseManagement\App\Models\YouthFamilyMemberInfo::GENDER_MALE }}">
                                            <label for="gender_male" class="custom-control-label">পুরুষ</label>
                                        </div>
                                        <div class="custom-control custom-radio mr-3">
                                            <input class="custom-control-input" type="radio" id="gender_female"
                                                   name="gender"
                                                   value="{{ \Module\CourseManagement\App\Models\YouthFamilyMemberInfo::GENDER_FEMALE }}">
                                            <label for="gender_female" class="custom-control-label">নারী</label>
                                        </div>
                                        <div class="custom-control custom-radio mr-3">
                                            <input class="custom-control-input" type="radio" id="gender_transgender"
                                                   name="gender"
                                                   value="{{ \Module\CourseManagement\App\Models\YouthFamilyMemberInfo::GENDER_TRANSGENDER }}">
                                            <label for="gender_transgender"
                                                   class="custom-control-label">তৃতীয় লিঙ্গ</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="current_occupation">
                                        বর্তমান পেশা
                                        <span class="required">*</span> :</label>

                                    <select class="form-control form-control"
                                            name="current_occupation" id="current_occupation">
                                        <option value="">নির্বাচন করুন</option>
                                        <option value="Business">বিসনেস - Business</option>
                                        <option value="Service">সার্ভিস - Service</option>
                                        <option value="Student">স্টুডেন্টস - Student</option>
                                    </select>
                                </div>

                                <div class="form-group col-md-12 text-center">
                                    <input type="submit" class="btn btn-primary" value="রেজিস্ট্রেশন করুন">
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>


    </div>

@endsection
@push('css')
    <style>
        .date_of_birth {
            background-color: #fafdff !important;
        }

        #loc_district_id-error, #date_of_birth-error{
            position: absolute;
            left: 5px;
            bottom: -21px;
        }

        #gender-error{
            position: absolute;
            width: 200px;
            bottom: -30px;
            left: -14px;
        }

    </style>

@endpush
@push('js')
    <script>
        const regForm = $('.reg-form');
        regForm.validate({
            rules: {
                name_en: {
                    required: true
                },
                name_bn: {
                    required: true
                },
                mobile: {
                    required: true
                },
                mailing_address: {
                    required: true
                },
                current_occupation: {
                    required: true
                },

                email: {
                    required: true,
                    /*remote: {
                        param: {
                            type: "post",
                            url: "{{ route('course_management::admin.check-batch-code') }}",
                        },
                        depends: function (element) {
                            return $(element).val() !== $('#code').attr('data-code');
                        }
                    },*/
                },
                conform_email: {
                    required: true,
                },
                father_or_husband_name: {
                    required: true,
                },
                mother_name: {
                    required: true,
                },
                loc_district_id: {
                    required: true,
                },
                date_of_birth: {
                    required: true,
                },
                gender: {
                    required: true,
                },

            },
            messages: {

            },
            submitHandler: function (htmlForm) {
                $('.overlay').show();
                htmlForm.submit();
            }
        });

        $(document).ready(function () {
            $('#date_of_birth').on('change',function (){
                $("#date_of_birth").valid();
            });
        });
    </script>
@endpush
