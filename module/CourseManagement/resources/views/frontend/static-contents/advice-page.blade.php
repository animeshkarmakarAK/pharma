@php
    $currentInstitute = domainConfig('institute');
    $layout = $currentInstitute ? 'master::layouts.custom1' : 'master::layouts.front-end';
@endphp
@extends($layout)

@section('title')
    পরামর্শ
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card py-3 mb-2">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-8 mx-auto advice-form">
                                <div class="portlet light">
                                    <div class="advice-portlet-body form fix">
                                        <div class="form-body fix">
                                            <div class="advice-portlet-title fix">
                                                <div class="text-center">
                                                    <h3 class="green-heading title-content">{{ $currentInstitute->title_bn? $currentInstitute->title_bn:'' }}
                                                        সম্পর্কে যদি আপনার কোনো মতামত থাকে তাহলে নিচের ফর্মটি পূরণ করে
                                                        সংরক্ষণ করুন</h3>
                                                </div>
                                                <hr>
                                            </div>
                                            <div class="col-md-12 input_area">

                                                <form action="{{ route('course_management::visitor-feedback.store') }}"
                                                      method="POST" class="edit-add-form">
                                                    @csrf
                                                    <div class="form-group row" aria-required="true">
                                                        <label for="name" class="col-sm-2 control-label">নাম
                                                            <span style="color: red"> * </span></label>
                                                        <div class="col-sm-10 container_name">
                                                            <input required="required" maxlength="255" id="name"
                                                                   class="form-control" type="text" name="name"
                                                                   aria-required="true">
                                                            <input type="hidden" name="institute_id" id="institute_id"
                                                                   value="{{$currentInstitute->id}}">
                                                            <input type="hidden" name="form_type"
                                                                   value="{{\Module\CourseManagement\App\Models\VisitorFeedback::FORM_TYPE_FEEDBACK}}">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row" aria-required="true">

                                                        <label for="mobile" class="col-sm-2 control-label">
                                                            মোবাইল নাম্বার
                                                            <span style="color: red"> * </span></label>
                                                        <div class="col-sm-10">
                                                            <input required="required" maxlength="255" id="mobile"
                                                                   class="form-control" type="text" name="mobile"
                                                                   aria-required="true">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="email" class="col-sm-2 control-label"
                                                               aria-required="true">ইমেইল <span
                                                                style="color: red"> * </span></label>
                                                        <div class="col-sm-10 container_email">
                                                            <input maxlength="50" id="email" class="form-control"
                                                                   type="text" name="email">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="address" class="col-sm-2 control-label">ঠিকানা</label>
                                                        <div class="col-sm-10">
                                                        <textarea class="form-control" name="address" rows="2"
                                                                  id="address"></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row" aria-required="true">
                                                        <label for="suggestion"
                                                               class="col-sm-2 control-label">মতামত
                                                            <span style="color: red"> * </span></label>
                                                        <div class="col-sm-10">
                                                        <textarea class="form-control" name="comment" rows="4"
                                                                  id="comment"
                                                                  aria-required="true"></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <div class="col-md-12 text-center">
                                                            <div class="submit">
                                                                <input type="submit" class="btn btn-default btn_save"
                                                                       value="সংরক্ষণ করুন">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>

                                        </div>
                                    </div>
                                </div>
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
        h3.green-heading.title-content {
            font-size: 18px !important;
            padding: 15px;
        }

        .green-heading {
            font-weight: bold !important;
            color: #4b77be !important;
            line-height: 24px;
        }

        .btn_save {
            background: #4b77be !important;
            color: #fff !important;
        }

        .btn_save:hover {
            background: #1650ae !important;
        }

        .input_area {
            font-size: 12px;
        }

        .advice-portlet-body {
            padding: 15px 15px;
            border: 1px solid #e1e1e1 !important;
            border-radius: 8px !important;
        }

        .download-area {
            text-align: center;
        }

        .advice-download-area {
            border-left: 1px solid #e1e1e1;
        }
        .advice-form{
            border: 1px solid #f9f9f9;
            padding: 20px;
            box-shadow: 0 0 15px #eee;
            min-height: 100%;
        }
    </style>
@endpush

@push('js')
    <script>
        $.validator.addMethod(
            "nameValidation",
            function (value, element) {
                let regexp = /^[a-zA-Z0-9()[^-_-. ]+$/i;
                let regexp1 = /^[\s-'\u0980-\u09ff)(. _-]{1,255}$/i;
                let re = new RegExp(regexp);
                let re1 = new RegExp(regexp1);
                return this.optional(element) || re.test(value) || re1.test(value);
            },
            "আপনার সঠিক নাম লিখুন"
        );

        $.validator.addMethod(
            "mobileValidation",
            function (value, element) {
                let regexp1 = /^(?:\+88|88)?(01[3-9]\d{8})$/i;
                let regexp = /^(?:\+৮৮|৮৮)?(০১[৩-৯][০-৯]{8})$/i;
                let re = new RegExp(regexp);
                let re1 = new RegExp(regexp1);
                return this.optional(element) || re.test(value) || re1.test(value);
            },
            "আপনার সঠিক মোবাইল নাম্বার লিখুন"
        );

        $.validator.addMethod(
            "textEnBnWithoutSpecialChar",
            function (value, element) {
                let en = /^[a-zA-Z0-9 .,?&।\s'\u0980-\u09ff\n\r]*$/i;
                let reEn = new RegExp(en);
                return this.optional(element) || reEn.test(value);
            },
            "textEnBnWithoutSpecialChar is require"
        );

        $.validator.addMethod(
            "addressWithoutSpecialChar",
            function (value, element) {
                let en = /^[a-zA-Z0-9\s'\u0980-\u09ff\n\r ,./।-]*$/i;
                let reEn = new RegExp(en);
                return this.optional(element) || reEn.test(value);
            },
            "addressWithoutSpecialChar is require"
        );

        const editAddForm = $('.edit-add-form');
        editAddForm.validate({
            rules: {
                name: {
                    required: true,
                    nameValidation: true,
                },
                mobile: {
                    required: true,
                    mobileValidation: true,
                },
                email: {
                    required: true,
                    pattern: /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/,
                },
                address: {
                    addressWithoutSpecialChar:true,
                },
                comment: {
                    required: true,
                    textEnBnWithoutSpecialChar:true,
                }
            },
            messages: {
                name: {
                    required: "এখানে আপনার নাম লিখুন।"
                },
                mobile: {
                    required: "এখানে আপনার মোবাইল নাম্বার লিখুন।",
                },
                email: {
                    required: "এখানে আপনার ই-মেইল এড্রেস লিখুন।",
                    pattern: "এখানে আপনার সঠিক ই-মেইল এড্রেস লিখুন",
                },
                address: {
                    addressWithoutSpecialChar: "এখানে আপনার সঠিক ঠিকানা লিখুন [অনুগ্রহ করে শুধু , . - / এই  স্পেশাল ক্যারেক্টার গুলা ব্যবহার করুন]",
                },
                comment: {
                    required: "এখানে আপনার মতামত লিখুন।",
                    textEnBnWithoutSpecialChar: "স্পেশাল ক্যারেক্টার ছাড়া মতামত দিন [অনুগ্রহ করে শুধু . , ? এই  স্পেশাল ক্যারেক্টার গুলা ব্যবহার করুন]"
                }
            },
            submitHandler: function (htmlForm) {
                $('.overlay').show();
                htmlForm.submit();
            }
        });
    </script>
@endpush
