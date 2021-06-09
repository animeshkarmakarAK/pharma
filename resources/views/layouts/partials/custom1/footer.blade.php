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
                    <p>গণপ্রজাতন্ত্রী বাংলাদেশ সরকারের রূপকল্প ২০২১ বাস্তবায়নে যুবকদের আত্নকর্মসংস্থান ও স্বাবলম্বী
                        করে তোলার লক্ষ্যে "অনলাইনে বিভিন্ন প্রশিক্ষণ কোর্সের পরিচালনা ও পর্যবেক্ষণ করা"।</p>
                    <span>
                            <a href="#" class="read-more"> <i class="fas fa-angle-double-right"></i> বিস্তারিত</a>
                        </span>
                </div>
            </div>
            <!--/ footer widget one-->

            <!--footer widget Two-->
            <div class="col-md-4 col-sm-6 footer-item">
                <div class="footer-widget-address">
                    <h3>যোগাযোগ </h3>
                    <p>
                        <i class="fa fa-home" aria-hidden="true"></i>
                        <span>বাংলাদেশ শিল্প কারগরি সহায়তা কেন্দ্র (বিটাক)<br>১১৬ (খ),তেজগাঁও শিল্প এলাকা ঢাকা - ১২০৮
                            </span>
                    </p>
                    <p>
                        <i class="fa fa-envelope" aria-hidden="true"></i>
                        <a class="footer-email" href="mailto:ict@bitac.gov.bd"><span style="font-family:'Roboto', sans-serif; font-size: 17px;"> ict@bitac.gov.bd</span></a>
                    </p>
                    <p>
                        <i class="fas fa-phone-volume"></i>
                        <span> +৮৮-০২-৮৮৭০৬৮০, +৮৮-০২-৮৮৭০২৬৬</span>
                    </p>
                    <p>
                        <i class="fa fa-fax" aria-hidden="true"></i>
                        <span> +৮৮-০২-৮৮৭০৭২৮</span>
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
            <div class="col-md-6 col-sm-6 col-xs-12" style="width: auto">
                <div class="float-left">
                    <h3>পরিকল্পনা ও বাস্তবায়নে</h3>
                    <a href="#" target="_blank">
                        <img src="{{asset('assets/company/images/footer-img/a2i_logoset.png')}}"
                             class="img-responsive govt-img"></a>
                </div>
            </div>
            <div class="col-md-6 col-sm-6 col-xs-12" style="width: auto">
                <div class="float-right">
                    <h3> কারিগরি সহায়তায়</h3>
                    <a href="http://softbdltd.com/" target="_blank">
                        <img src="{{asset('assets/company/images/footer-img/softbd-footer-img.png')}}"
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

