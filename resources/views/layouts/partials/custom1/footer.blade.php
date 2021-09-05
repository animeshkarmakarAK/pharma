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
                         class="img-responsive logo-change" style="height: 60px; max-width: 100%">
                    <p>
                        {{  !empty($currentInstitute->description)?$currentInstitute->description:'' }}
                    </p>
                    <span>
                            <a href='{{route('course_management::static-content.show', 'aboutus')}}' class="read-more"> <i class="fas fa-angle-double-right"></i> বিস্তারিত</a>
                    </span>
                </div>
            </div>
            <!--/ footer widget one-->

            <!--footer widget Two-->
            <div class="col-md-4 col-sm-6 footer-item">
                <div class="footer-widget-address">
                    <h3>যোগাযোগ </h3>
                    <p>
                        <span>
                            <i class="fa fa-home" aria-hidden="true"></i>
                            {{  !empty($currentInstitute->address)?$currentInstitute->address:'' }}
                        </span>
                    </p>
                    <p>
                        <i class="fa fa-envelope" aria-hidden="true"></i>
                        <a class="footer-email"
                           href="mailto:{{  !empty($currentInstitute->email)?$currentInstitute->email:'' }}">
                            <span style="font-family:'Roboto', sans-serif; font-size: 17px;">
                                {{  !empty($currentInstitute->email)?$currentInstitute->email:'' }}
                            </span>
                        </a>
                    </p>
                    <p>
                        <span>
                            <i class="fas fa-phone-volume"></i>
                            <a style="color: #869099;"
                               href="tel:{{  !empty($currentInstitute->primary_phone)?$currentInstitute->primary_phone:''}}"
                               onclick="">
                                {{  !empty($currentInstitute->primary_phone)?$currentInstitute->primary_phone:''}}
                            </a>

                            @if(!empty($currentInstitute->phone_numbers))
                                @foreach($currentInstitute->phone_numbers as $phoneNumber)
                                    <a style="color: #869099;"
                                       href="tel:{{  $phoneNumber }}"
                                       onclick="">
                                        , {{  $phoneNumber }}
                                    </a>
                                @endforeach
                            @endif
                        </span>
                    </p>
                    <p>
                        <span>
                            <i class="fa fa-fax" aria-hidden="true"></i>
                            <a style="color: #869099;"
                               href="tel:{{  !empty($currentInstitute->primary_mobile)?$currentInstitute->primary_mobile:'' }}"
                               onclick="">
                                {{  !empty($currentInstitute->primary_mobile)?$currentInstitute->primary_mobile:'' }}
                            </a>
                            {{--+৮৮-০২-৮৮৭০৭২৮--}}
                        </span>
                    </p>
                </div>
            </div>
            <!--/ footer widget Two-->

            <!--footer widget Three-->
            <div class="col-md-4 col-sm-6 footer-item">
                <div class=" footer-widget-quick-links">
                    <h3>গুরুত্বপূর্ণ লিঙ্ক</h3>
                    <ul>
                        <li>
                            <i class="fa  fa-angle-right"></i>
                            <a href="#">অনলাইন কোর্স</a>
                        </li>
                        <li><i class="fa  fa-angle-right"></i> <a href="#">সংবাদ </a></li>
                        <li><i class="fa  fa-angle-right"></i> <a href="#">ঘটনাবলী</a></li>
                        <li><i class="fa  fa-angle-right"></i> <a href="#">আমাদের সম্পর্কে</a></li>
                        <li><i class="fa  fa-angle-right"></i> <a href="#">যোগাযোগ</a></li>
                        <li><i class="fa  fa-angle-right"></i> <a href="#">প্রয়োজনীয় প্রশ্ন এবং উত্তর</a></li>
                        @guest
                            <li><i class="fa  fa-angle-right"></i> <a href="{{route('admin.login-form')}}">লগইন</a></li>
                            <li><i class="fa  fa-angle-right"></i> <a href="#">সাইন আপ</a></li>
                        @endguest
                        <li><i class="fa  fa-angle-right"></i> <a href="#">শর্তাবলী</a></li>
                        <li><i class="fa  fa-angle-right"></i> <a href="#">গোপনীয়তা নীতি</a></li>
                    </ul>
                </div>
            </div>
            <!--/ footer widget thre-->
        </div>
    </div>
</section>

<footer class="footer-2">
    <div class="container">
        <div class="row">
            <div class="col-6">
                <div class="float-left">
                    <h3>পরিকল্পনা ও বাস্তবায়নে</h3>
                    <a href="#" target="_blank">
                        <img src="{{asset('assets/company/images/footer-img/a2i_logoset.png')}}" style="width: 100%"
                             class="img-responsive govt-img"></a>
                </div>
            </div>
            <div class="col-6">
                <div class="float-right">
                    <h3> কারিগরি সহায়তায়</h3>
                    <a href="http://softbdltd.com/" target="_blank">
                        <img src="{{asset('assets/company/images/footer-img/softbd-footer-img.png')}}" style="max-width: 100%"
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

