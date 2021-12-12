@php
    /** @var \App\Models\Institute $currentInstitute */
    $currentInstitute =  app('currentInstitute');
@endphp

<section class="main-footer">
    <div class="container">
        <div class="row">
            <!--footer widget one-->
            <div class="col-md-4 col-sm-6 footer-item">
                <div class="footer-widget">
                    <img
                        src="{{$currentInstitute && $currentInstitute->logo ? asset('storage/' . $currentInstitute->logo) : asset('assets/logo/dpg/logo.svg')}}"
                        alt=""
                        class="img-responsive logo-change" style="height: 60px;">
                    <p>
                        <?php
                        $descriptions = "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.";
                        ?>
                        {{  $currentInstitute && !empty($currentInstitute->description) ? $currentInstitute->description : '' }}
                    </p>
                    <span>
                            <a href="{{route('frontend.static-content.show',[ 'page_id' => 'aboutus', 'instituteSlug' => $currentInstitute->slug ?? ''])}}"
                               class="read-more"> <i
                                    class="fas fa-angle-double-right"></i> বিস্তারিত</a>
                        </span>
                </div>
            </div>
            <!--/ footer widget one-->

            <!--footer widget Two-->
            <div class="col-md-4 col-sm-6 footer-item">
                <div class="footer-widget-address">
                    <h3 class="mb-3">যোগাযোগ</h3>
                    <p>
                        <i class="fa fa-home" aria-hidden="true"></i>
                        {{  $currentInstitute && !empty($currentInstitute->address) ? $currentInstitute->address : 'Dhaka-1212' }}
                    </p>

                    <p>
                        <i class="fa fa-envelope" aria-hidden="true"></i>
                        <a class="footer-email"
                           href="mailto:{{  $currentInstitute && !empty($currentInstitute->email) ? $currentInstitute->email :'email@example.com' }}">
                            {{  $currentInstitute && !empty($currentInstitute->email) ? $currentInstitute->email :'email@example.com' }}
                        </a>
                    </p>
                    <p>
                        <i class="fas fa-mobile"></i>
                        &nbsp;
                        <a
                            href="tel:{{  $currentInstitute && !empty($currentInstitute->mobile) ? $currentInstitute->mobile :'017xxxxxxxx' }}">
                            {{  $currentInstitute && !empty($currentInstitute->mobile) ? $currentInstitute->mobile :'017xxxxxxxx' }}
                        </a>
                    </p>
                    <p>
                        <i class="fas fa-mobile"></i>
                        &nbsp;

                        <a
                            href="tel:{{  $currentInstitute && !empty($currentInstitute->contact_person_mobile) ? $currentInstitute->contact_person_mobile :'019xxxxxxxx' }}">
                            {{  $currentInstitute && !empty($currentInstitute->contact_person_mobile) ? $currentInstitute->contact_person_mobile :'019xxxxxxxx' }}
                        </a>
                    </p>

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
                                href="{{route('frontend.static-content.show', ['page_id' => 'aboutus', 'instituteSlug' => $currentInstitute->slug ?? ''])}}">আমাদের
                                সম্পর্কে</a></li>
                        <li><i class="fa  fa-angle-right"></i> <a
                                href="{{ route('frontend.advice-page', ['instituteSlug' => $currentInstitute->slug ?? '']) }}">পরামর্শ</a>
                        </li>
                        <li><i class="fa  fa-angle-right"></i> <a
                                href="{{route('frontend.contact-us-page', ['instituteSlug' => $currentInstitute->slug ?? ''])}}">যোগাযোগ</a>
                        </li>
                        <li><i class="fa  fa-angle-right"></i> <a
                                href="{{route('frontend.general-ask-page', ['instituteSlug' => $currentInstitute->slug ?? ''])}}">প্রশ্নোত্তর</a>
                        </li>
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
                        <img src="{{asset('/assets/logo/planner-logo.png')}}" alt="A2i Logo"></a>
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


