@php
    $currentInstitute = domainConfig('institute');
@endphp
<section class="main-footer">
    <div class="container">
        <div class="row">
            <!--footer widget one-->
            <div class="col-md-4 col-sm-6 footer-item">
                <div class="footer-widget">
                    <img src="{{asset('storage/' .$currentInstitute->logo)}}" alt=""
                         class="img-responsive logo-change" style="height: 60px;">
                    <p>
                        {{  !empty($currentInstitute->description)?$currentInstitute->description:'' }}
                    </p>
                    <span>
                            <a href="{{route('course_management::static-content.show', 'aboutus')}}" class="read-more"> <i
                                    class="fas fa-angle-double-right"></i> বিস্তারিত</a>
                        </span>
                </div>
            </div>
            <!--/ footer widget one-->

            <!--footer widget Two-->
            <div class="col-md-4 col-sm-6 footer-item">
                <div class="footer-widget-address">
                    <h3 class="mb-3">যোগাযোগ</h3>
                    @if(!empty($currentInstitute->address))
                        <p>
                            <i class="fa fa-home" aria-hidden="true"></i>
                            {{  !empty($currentInstitute->address)?$currentInstitute->address:'' }}
                        </p>
                    @endif

                    @if(!empty($currentInstitute->email))
                        <p>
                            <i class="fa fa-envelope" aria-hidden="true"></i>
                            <a class="footer-email"
                               href="mailto:{{  !empty($currentInstitute->email)?$currentInstitute->email:'' }}">
                                {{  !empty($currentInstitute->email)?$currentInstitute->email:'' }}
                            </a>
                        </p>
                    @endif

                    @if(!empty($currentInstitute->primary_phone) || !empty($currentInstitute->phone_numbers))
                        <p>
                            <i class="fas fa-phone fa-flip-horizontal" style="padding: 10px 0px 0px 0px;"></i> &nbsp;
                            <a
                                href="tel:{{  !empty($currentInstitute->primary_phone)?$currentInstitute->primary_phone:''}}"
                                onclick="">
                                {{  !empty($currentInstitute->primary_phone)?$currentInstitute->primary_phone.' ':''}}
                            </a>


                            @foreach($currentInstitute->phone_numbers as $phoneNumber)
                                <a
                                    href="tel:{{  $phoneNumber }}"
                                    onclick="">
                                    {{  ', '.$phoneNumber }}
                                </a>
                            @endforeach
                        </p>
                    @endif

                    @if(!empty($currentInstitute->primary_mobile) || !empty($currentInstitute->mobile_numbers))
                        <p>
                            <i class="fas fa-mobile"></i>
                            {{--<i class="fas fa-phone fa-flip-horizontal" style="padding: 10px 0px 0px 0px;"></i>--}}
                            &nbsp;
                            <a
                                href="tel:{{  !empty($currentInstitute->primary_mobile)?$currentInstitute->primary_mobile:''}}"
                                onclick="">
                                {{  !empty($currentInstitute->primary_mobile)?$currentInstitute->primary_mobile:' '}}
                            </a>

                            @foreach($currentInstitute->mobile_numbers as $mobileNumber)
                                <a
                                    href="tel:{{  $mobileNumber }}"
                                    onclick="">
                                    {{  ', '.$mobileNumber }}
                                </a>
                            @endforeach
                        </p>
                    @endif

                </div>
            </div>
            <!--/ footer widget Two-->

            <!--footer widget Three-->
            <div class="col-md-4 col-sm-6 footer-item">
                <div class=" footer-widget-quick-links">
                    <h3 class="mb-3">গুরুত্বপূর্ণ লিঙ্ক</h3>
                    <ul>
                        <li>
                            <i class="fa  fa-angle-right"></i>
                            <a href="#">অনলাইন কোর্স</a>
                        </li>
                        <li><i class="fa  fa-angle-right"></i> <a href="#">সংবাদ </a></li>
                        <li><i class="fa  fa-angle-right"></i> <a href="#">ঘটনাবলী</a></li>
                        <li><i class="fa  fa-angle-right"></i> <a
                                href="{{route('course_management::static-content.show', 'aboutus')}}">আমাদের
                                সম্পর্কে</a></li>
                        <li><i class="fa  fa-angle-right"></i> <a
                                href="{{ route('course_management::advice-page') }}">পরামর্শ</a></li>
                        <li><i class="fa  fa-angle-right"></i> <a
                                href="{{route('course_management::contact-us-page')}}">যোগাযোগ</a></li>
                        <li><i class="fa  fa-angle-right"></i> <a
                                href="{{route('course_management::general-ask-page')}}">প্রশ্নোত্তর</a></li>
                        @guest
                            <li><i class="fa  fa-angle-right"></i> <a href="{{route('admin.login-form')}}">লগইন</a></li>
                            <li><i class="fa  fa-angle-right"></i> <a href="#">সাইন আপ</a></li>
                        @endguest
                        <li><i class="fa  fa-angle-right"></i> <a href="#">শর্তাবলী</a></li>
                        <li><i class="fa  fa-angle-right"></i> <a href="#">গোপনীয়তা নীতি</a></li>
                    </ul>
                    </p>

                </div>
            </div>
            <!--/ footer widget thre-->
        </div>
    </div>
</section>

<footer class="footer-2">
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-sm-6 col-xs-12" style="width: auto">
                <div class="float-left">
                    <h3>পরিকল্পনা ও বাস্তবায়নে</h3>
                    <a href="#" target="_blank">
                        <img src="{{asset('/assets/logo/planner-logo.png')}}" alt="A2i Logo" ></a>
                </div>
            </div>
            <div class="col-md-6 col-sm-6 col-xs-12" style="width: auto">
                <div class="float-right">
                    <h3> কারিগরি সহায়তায়</h3>
                    <a href="http://softbdltd.com/" target="_blank">
                        <img src="{{asset('/assets/logo/softbd-logo.png')}}" alt="SoftBD Logo"
                             class="img-responsive soft-bd">
                    </a>
                </div>
            </div>
        </div>
    </div>
</footer>
<!--------Back to top HTML-------->
<!-- Scroll to Top -->
<a id="back-to-top" href="#" class="btn btn-light btn-lg back-to-top" role="button">
    <i class="fas fa-chevron-up"></i>
</a>
<!-- Color Changer -->


