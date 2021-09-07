@php
    $currentInstitute = domainConfig('institute');
    $layout = $currentInstitute ? 'master::layouts.custom1' : 'master::layouts.front-end';
@endphp
@extends($layout)

@section('title')
    যোগাযোগ
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card py-3 mb-2">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-6 contact-us-form-area">
                                <div class="contact-us-form">
                                    <div class="contact-us-portlet-body form fix">
                                        <div class="form-body fix">
                                            <div class="contact-us-portlet-title fix">
                                                <div class="text-center">
                                                    <h3 class="green-heading titleconte">
                                                        আমাদের সাথে যোগাযোগ করুন </h3>
                                                </div>
                                                <hr>
                                            </div>
                                            <div class="col-md-12 input_area">
                                                <form action="{{ route('course_management::visitor-feedback.store') }}"
                                                      method="POST"
                                                      class="edit-add-form">
                                                    @csrf
                                                    <div class="form-group row" aria-required="true">
                                                        <label for="receiver" class="col-sm-2 control-label">প্রাপক
                                                            <span style="color: red"> * </span></label>
                                                        <div class="col-sm-10 container_name">
                                                            <select required="required" name="receiver"
                                                                    class="form-control"
                                                                    id="receiver">
                                                                <optgroup label="ইনস্টিটিউট">
                                                                    <option
                                                                        {{--value="institute-{{ $currentInstitute->id }}"--}}
                                                                        value="{{ $currentInstitute->google_map_src }}"
                                                                    >
                                                                        {{ $currentInstitute->title_bn }}
                                                                    </option>
                                                                </optgroup>
                                                                {{--@if(\App\Models\Branch::where(['institute_id'=>$currentInstitute->id])->count()>0)
                                                                    <optgroup label="Branch">
                                                                        @foreach(\App\Models\Branch::where(['institute_id'=>$currentInstitute->id])->get() as $branch)
                                                                            <option value="branch-{{ $branch->id }}">
                                                                                {{ $branch->title_bn }}
                                                                            </option>
                                                                        @endforeach
                                                                    </optgroup>
                                                                @endif--}}
                                                                @if(\Module\CourseManagement\App\Models\TrainingCenter::where(['institute_id'=>$currentInstitute->id])->count()>0)
                                                                    <optgroup label="ট্রেনিং সেন্টার">
                                                                        @foreach(\Module\CourseManagement\App\Models\TrainingCenter::where(['institute_id'=>$currentInstitute->id])->get() as $trainingCenter)
                                                                            <option
                                                                                {{--value="training_center-{{ $trainingCenter->id }}"--}}
                                                                                value="{{ $trainingCenter->google_map_src }}"
                                                                            >
                                                                                {{ $trainingCenter->title_bn }}
                                                                            </option>
                                                                        @endforeach
                                                                    </optgroup>
                                                                @endif
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <hr>

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
                                                                   value="{{\Module\CourseManagement\App\Models\VisitorFeedback::FORM_TYPE_CONTACT}}">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row" aria-required="true">

                                                        <label for="mobile" class="col-sm-2 control-label">মোবাইল
                                                            নম্বর
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
                                                    <div class="form-group row" aria-required="true">
                                                        <label for="suggestion"
                                                               class="col-sm-2 control-label">মতামত
                                                            <span style="color: red"> * </span></label>
                                                        <div class="col-sm-10">
                                                        <textarea class="form-control" name="comment" rows="4"
                                                                  required="required" id="comment"
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
                            <div class="col-md-6 contact-us-form-area">
                                <div class="contact-us-form">

                                    <div class="contact-us-portlet-body form fix">
                                        <div class="form-body fix">
                                            <div class="contact-us-portlet-title fix">
                                                <div class="text-center">
                                                    <h3 class="green-heading titleconte">
                                                        আমাদের লোকেশন ম্যাপে দেখুন </h3>
                                                </div>
                                                <hr>
                                            </div>

                                            <div class="contact-us-portlet-body form fix">
                                                <div class="">
                                                    <div id="select-map-div">
                                                        <select name="google_map_src" class="form-control"
                                                                id="google_map_src">
                                                            <optgroup label="ইনস্টিটিউট">
                                                                <option value="{{ $currentInstitute->google_map_src }}">
                                                                    {{ $currentInstitute->title_bn }}
                                                                </option>
                                                            </optgroup>
                                                            {{--@if(\Module\CourseManagement\App\Models\Branch::where(['institute_id'=>$currentInstitute->id])->count()>0)
                                                                <optgroup label="ব্রাঞ্চ">
                                                                    @foreach(\Module\CourseManagement\App\Models\Branch::where(['institute_id'=>$currentInstitute->id])->get() as $branch)
                                                                        <option value="{{ $branch->google_map_src }}">
                                                                            {{ $branch->title_bn }}
                                                                        </option>
                                                                    @endforeach
                                                                </optgroup>
                                                            @endif--}}
                                                            @if(\Module\CourseManagement\App\Models\TrainingCenter::where(['institute_id'=>$currentInstitute->id])->count()>0)
                                                                <optgroup label="ট্রেনিং সেন্টার">
                                                                    @foreach(\Module\CourseManagement\App\Models\TrainingCenter::where(['institute_id'=>$currentInstitute->id])->get() as $trainingCenter)
                                                                        <option
                                                                            value="{{ $trainingCenter->google_map_src }}">
                                                                            {{ $trainingCenter->title_bn }}
                                                                        </option>
                                                                    @endforeach
                                                                </optgroup>
                                                            @endif
                                                        </select>
                                                    </div>

                                                    <div class="mt-2" style="display: block;">
                                                        <div class="">
                                                            <iframe class="google_map_src_iframe" frameborder="0"
                                                                    src="{{ $currentInstitute->google_map_src? $currentInstitute->google_map_src :'No Map' }}"
                                                                    style="border:0; height: 309px;"
                                                                    width="100%"></iframe>
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
            </div>
            <div class="col-md-12">
                <div class="contact-us-bottom-area">
                    <aside class="light-bg contact-address">
                        <div class="container">
                            <div class="row">
                                <!-- Addresse-->
                                <div class="col-md-4 contact-box text-center">
                                    <div class="d-inline-flex" style="width: 215px">
                                        <i class="fas fa-map-marked template-contact-icon"></i>
                                        <p style="text-align: justify; color: #869099;">
                                            {{  !empty($currentInstitute->address)?$currentInstitute->address:'' }}
                                        </p>
                                    </div>
                                </div>

                                <!--     Phone Numbers-->
                                <div class="col-md-4 contact-box text-center">
                                    <div class="d-inline-flex" style="width: 215px">
                                        <i class="fas fa-phone-square-alt template-contact-icon"></i>
                                        <p>
                                            @if(!empty($currentInstitute->phone_numbers))
                                                @foreach($currentInstitute->phone_numbers as $phoneNumber)
                                                    <a style="color: #869099;"
                                                       href="tel:{{  $phoneNumber }}"
                                                       onclick="">{{  $phoneNumber }}
                                                    </a><br>
                                                @endforeach
                                            @endif
                                        </p>
                                    </div>
                                </div>

                                <!-- Email Details -->
                                <div class="col-md-4 contact-box text-center">
                                    <div class="d-inline-flex" style="width: 215px">
                                        <i class="fas fa-envelope-open-text template-contact-icon"></i>
                                        <p><a class="" style="color: #212529;" onMouseOver="this.style.color='#4b77be'"
                                              onMouseOut="this.style.color='#212529'"
                                              href="mailto:ict@bitac.gov.bd">
                                                <span>
                                                    <a class="footer-email"
                                                       href="mailto:{{  !empty($currentInstitute->email)?$currentInstitute->email:'' }}">
                                                        <span
                                                            style="font-family:'Roboto', sans-serif; font-size: 17px;">
                                                            {{  !empty($currentInstitute->email)?$currentInstitute->email:'' }}
                                                        </span>
                                                    </a>
                                                </span>
                                            </a>
                                        </p>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </aside>

                </div>
            </div>
        </div>
    </div>
@endsection

@push('css')
    <style>
        h3.green-heading.titleconte {
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

        .contact-us-form-area {

        }

        .contact-us-form {
            border: 1px solid #f9f9f9;
            padding: 20px;
            box-shadow: 0 0 15px #eee;
            min-height: 100%;
        }

        .contact-us-bottom-area {
            padding: 30px 0;
            background: #F3F6F8;
            box-shadow: 0 0 5px 0 #dddddd;
        }

        .contact-box {
            padding: 10px 20px;
            margin: 0;
        }

        i.template-contact-icon {
            width: 50px;
            float: left;
            margin-right: 15px;
            font-size: 40px;
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
                let en = /^[a-zA-Z0-9 .,?]*$/i;
                let bn = /^[\s'\u0980-\u09ff .,?]+$/i;
                let reEn = new RegExp(en);
                let reBn = new RegExp(bn);
                return this.optional(element) || reEn.test(value) || reBn.test(value);
            },
            "textEnBnWithoutSpecialChar is require"
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
                comment: {
                    required: true,
                    textEnBnWithoutSpecialChar: true,
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
                comment: {
                    required: "এখানে আপনার মতামত লিখুন।",
                    textEnBnWithoutSpecialChar: "স্পেশাল ক্যারেক্টার ছাড়া মতামত দিন [অনুগ্রহ করে শুধু  . , ? এই  স্পেশাল ক্যারেক্টার গুলা ব্যবহার করুন]"
                }
            },
            submitHandler: function (htmlForm) {
                $('.overlay').show();
                htmlForm.submit();
            }
        });

        //contact-us-page map jQuery
        $('#google_map_src').on('change', function () {
            let google_map_src = $(this).val();
            if (google_map_src === '') {
                $('.google_map_src_iframe').attr("src", 'null');
            } else {
                $('.google_map_src_iframe').attr("src", google_map_src);
            }
        })

        $('#receiver').on('change', function () {
            let google_map_src = $(this).val();
            if (google_map_src === '') {
                $('.google_map_src_iframe').attr("src", 'null');
            } else {
                $('.google_map_src_iframe').attr("src", google_map_src);
            }
        })
    </script>

@endpush
