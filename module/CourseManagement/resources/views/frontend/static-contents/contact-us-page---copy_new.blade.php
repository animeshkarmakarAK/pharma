@php
    $currentInstitute = domainConfig('institute');
    $layout = 'master::layouts.front-end';
@endphp
@extends($layout)

@section('title')
    যোগাযোগ
@endsection

@section('content')
    <div class="container-fluid bg-white">
        <h1 class="text-center heading-text pt-5 pb-0 m-0">
            যোগাযোগ</h1>
        <div class="container content-shape border-l-t-r">&nbsp;</div>
    </div>


    <div class="container-fluid content-body-bg p-0 m-0">
        <div class="container">
            <div class="row pt-5">
                <div class="col-md-6">
                    <div class="card">
                        <div class="p-4">
                            <h3 class="card-heading-title" >
                                আমাদের সাথে যোগাযোগ করুন </h3>
                            <div class="col-md-12 input_area">
                                <form action="{{ route('course_management::visitor-feedback.store') }}"
                                      method="POST"
                                      class="edit-add-form">
                                    @csrf
                                    <div class="form-group row" aria-required="true">

                                        <div class="col-sm-12 container_name">
                                            <label for="receiver" class="control-label">
                                                প্রাপক
                                                <span style="color: red"> * </span></label>
                                            <select required="required" name="receiver"
                                                    class="form-control map-change"
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
                <div class="col-md-6">
                    <div class="card">
                        <div class="p-4">
                            <h3 class="card-heading-title">
                                আমাদের লোকেশন ম্যাপে দেখুন </h3>
                            <div class="contact-us-portlet-body form fix">
                                <div class="">
                                    <div id="select-map-div">
                                        <select name="google_map_src" class="form-control map-change"
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

    <div class="container-fluid bg-white pb-5">
        <div class="container content-shape border-l-b-r">&nbsp;</div>
    </div>


@endsection

@push('css')
    <style>

        /*New css*/
        .heading-text{
            font-family: Hind Siliguri;
            font-style: normal;
            font-weight: bold;
            font-size: 50px;
            line-height: 78px;
        }
        .content-body-bg{
            background: #671688;
        }
        .card-heading-title{
            font-family: Hind Siliguri;
            font-size: 25px;
            line-height: 20px;
        }
        .content-shape{
            background: rgba(103, 22, 136, 0.03);
            min-height: 42px;
        }

        .border-l-t-r{
            border-left: 1px solid #d7d7d7;
            border-top: 1px solid #d7d7d7;
            border-right: 1px solid #d7d7d7;
        }

        .border-l-b-r{
            border-left: 1px solid #d7d7d7;
            border-bottom: 1px solid #d7d7d7;
            border-right: 1px solid #d7d7d7;
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
        $('.map-change').on('change', function () {
            $("#google_map_src,#receiver").val(this.value);
            let google_map_src = $(this).val();
            if (google_map_src === '') {
                $('.google_map_src_iframe').attr("src", 'null');
            } else {
                $('.google_map_src_iframe').attr("src", google_map_src);
            }
        })
    </script>

@endpush
