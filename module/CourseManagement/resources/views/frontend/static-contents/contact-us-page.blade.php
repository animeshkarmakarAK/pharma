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
                <div class="card mb-0">
                    <div class="container">
                        <div class="row mt-5 mb-5">
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
                                                <form action="{{ route('course_management::visitor-feedback.store') }}" method="POST"
                                                      class="edit-add-form">
                                                    @csrf
                                                    <div class="form-group row" aria-required="true">
                                                        <label for="receiver" class="col-sm-2 control-label">প্রাপক
                                                            <span style="color: red"> * </span></label>
                                                        <div class="col-sm-10 container_name">
                                                            <select required="required" name="receiver" class="form-control"
                                                                    id="receiver">
                                                                <optgroup label="Institute">
                                                                    <option value="institute-{{ $currentInstitute->id }}">
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
                                                                    <optgroup label="Training Center">
                                                                        @foreach(\Module\CourseManagement\App\Models\TrainingCenter::where(['institute_id'=>$currentInstitute->id])->get() as $trainingCenter)
                                                                            <option
                                                                                value="training_center-{{ $trainingCenter->id }}">
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
                                                                   type="email" name="email">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row" aria-required="true">
                                                        <label for="suggestion"
                                                               class="col-sm-2 control-label">মতামত
                                                            <span style="color: red"> * </span></label>
                                                        <div class="col-sm-10">
                                                        <textarea class="form-control" name="comment" rows="7"
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
                                                    <select name="google_map_src" class="form-control"
                                                            id="google_map_src">
                                                        <optgroup label="Institute">
                                                            <option value="{{ $currentInstitute->google_map_src }}">
                                                                {{ $currentInstitute->title_bn }}
                                                            </option>
                                                        </optgroup>
                                                        @if(\Module\CourseManagement\App\Models\Branch::where(['institute_id'=>$currentInstitute->id])->count()>0)
                                                            <optgroup label="Branch">
                                                                @foreach(\Module\CourseManagement\App\Models\Branch::where(['institute_id'=>$currentInstitute->id])->get() as $branch)
                                                                    <option value="{{ $branch->google_map_src }}">
                                                                        {{ $branch->title_bn }}
                                                                    </option>
                                                                @endforeach
                                                            </optgroup>
                                                        @endif
                                                        @if(\Module\CourseManagement\App\Models\TrainingCenter::where(['institute_id'=>$currentInstitute->id])->count()>0)
                                                            <optgroup label="Training Center">
                                                                @foreach(\Module\CourseManagement\App\Models\TrainingCenter::where(['institute_id'=>$currentInstitute->id])->get() as $trainingCenter)
                                                                    <option
                                                                        value="{{ $trainingCenter->google_map_src }}">
                                                                        {{ $trainingCenter->title_bn }}
                                                                    </option>
                                                                @endforeach
                                                            </optgroup>
                                                        @endif
                                                    </select>

                                                    <div class="mt-2" style="display: block;">
                                                        <div class="">
                                                            <iframe class="google_map_src_iframe" frameborder="0"
                                                                    src="{{ $currentInstitute->google_map_src? $currentInstitute->google_map_src :'No Map' }}"
                                                                    style="border:0; height: 353px;"
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
                    <div class="contact-us-bottom-area">
                        <aside class="light-bg contact-address">
                            <div class="container">
                                <div class="row">
                                    <!-- Addresse-->
                                    <div class="col-md-4 contact-box text-center">
                                        <div class="d-inline-flex">
                                            <i class="fas fa-map-marked template-contact-icon"></i>
                                            <p>বাংলাদেশ শিল্প কারগরি সহায়তা কেন্দ্র<br>
                                                (বিটাক) ১১৬ (খ), তেজগাঁও শিল্প এলাকা <br>
                                                <span style="margin-left: 70px;">ঢাকা - ১২০৮</span>
                                            </p>
                                        </div>
                                    </div>

                                    <!--     Phone Numbers-->
                                    <div class="col-md-4 contact-box text-center">
                                        <div class="d-inline-flex">
                                            <i class="fas fa-phone-square-alt template-contact-icon"></i>
                                            <p>+৮৮-০২-৮৮৭০৬৮০<br>
                                                +৮৮-০২-৮৮৭০২৬৬</p>
                                        </div>
                                    </div>

                                    <!-- Email Details -->
                                    <div class="col-md-4 contact-box text-center">
                                        <div class="d-inline-flex">
                                            <i class="fas fa-envelope-open-text template-contact-icon"></i>
                                            <p><a class="" style="color: #212529;" onMouseOver="this.style.color='#4b77be'"
                                                  onMouseOut="this.style.color='#212529'"
                                                  href="mailto:ict@bitac.gov.bd"><span> ict@bitac.gov.bd</span></a>
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
                    email: true
                },
                comment: {
                    required: true,
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
                    email: true
                },
                comment: {
                    required: "এখানে আপনার মতামত লিখুন।",
                }
            },
            submitHandler: function (htmlForm) {
                $('.overlay').show();
                htmlForm.submit();
            }
        });


        //contact-us-page map jQuery
        $('#google_map_src').on('change', function () {
            let google_map_src = $('#google_map_src').val();
            if (google_map_src === '') {
                $('.google_map_src_iframe').attr("src", 'null');
            } else {
                $('.google_map_src_iframe').attr("src", google_map_src);
            }

        })
    </script>

@endpush
