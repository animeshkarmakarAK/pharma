@extends('master::layouts.master')

@section('content')
    <div class="container-fluid slider-area">
        <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
            <div class="carousel-inner" role="listbox">
                <div class="carousel-item active">
                    <div class='container s-fix'>
                        <div class='row pos-rel'>
                            <div class='col-sm-12 col-md-5 animate slider-left-content'>
                                <h1 class='big fadeInDownBig animated'>সমাজসেবা অধিদপ্তর</h1>
                                <p class='normal fadeInUpBig animated delay-point-five-s'>সমাজসেবা
                                    অধিদপ্তর-গণপ্রজাতন্ত্রী বাংলাদেশ সরকার</p>
                                <a href='#' target="_blank">বিস্তারিত</a>
                            </div>
                            <div class='col-md-7 animate pos-sta hidden-xs hidden-sm slider-right-content'>
                                <img class="img-responsive img-right fadeInRightBig animated delay-one-point-five-s"
                                     alt="iPhone"
                                     src="http://skills.gov.bd/demo-dss/files/slider/picture/e9ef950e-d88c-46ac-8aff-5ee8edf45762.jpg"
                                     style="width: 50%; height: auto;"/>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="carousel-item">

                    <div class='container s-fix'>
                        <div class='row pos-rel'>
                            <div class='col-sm-12 col-md-5 animate slider-left-content'>
                                <h1 class='big fadeInDownBig animated'>সমাজসেবা অধিদপ্তর</h1>
                                <p class='normal fadeInUpBig animated delay-point-five-s'>সমাজসেবা
                                    অধিদপ্তর-গণপ্রজাতন্ত্রী বাংলাদেশ সরকার</p>
                                <a class='' href='#' target="_blank">বিস্তারিত</a>
                            </div>
                            <div class='col-md-7 animate pos-sta hidden-xs hidden-sm slider-right-content'>
                                <img class="img-responsive img-right fadeInRightBig animated delay-one-point-five-s"
                                     alt="iPhone"
                                     src="http://skills.gov.bd/demo-dss/files/slider/picture/98b33fcb-9753-46b7-9e90-2324ca2bdd7a.gif"
                                     style="width: 50%; height: auto;"/>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <a class="carousel-control-prev slider-previous-link" href="#carouselExampleIndicators" role="button"
               data-slide="prev">
                <span class="slider-previous-icon" aria-hidden="true">
                    <i class="fas fa-chevron-circle-left"></i>
                </span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next slider-next-link" href="#carouselExampleIndicators" role="button"
               data-slide="next">
                <span class="slider-next-icon" aria-hidden="true">
                    <i class="fas fa-chevron-circle-right"></i>
                </span>
                <span class="sr-only">Next</span>
            </a>
        </div>
    </div>

    <section class="about-us-section">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <!--Services Heading-->
                    <h2 class="section-heading"> আমাদের সম্পর্কে </h2>
                    <div class="template-space"></div>
                </div>
                <div class="col-md-8">
                    <p>গণপ্রজাতন্ত্রী বাংলাদেশ সরকারের রূপকল্প ২০২১ বাস্তবায়নে যুবকদের আত্নকর্মসংস্থান ও স্বাবলম্বী করে
                        তোলার লক্ষ্যে "অনলাইনে বিভিন্ন প্রশিক্ষণ কোর্সের পরিচালনা ও পর্যবেক্ষণ করা"।
                        এই ওয়েব অ্যাপ্লিকেশনটি মূলত "অনলাইন কোর্স ম্যানেজমেন্ট সিস্টেম"।
                        এই প্ল্যাটফর্মে শিক্ষার্থী অতি সহজে বিভিন্ন প্রশিক্ষণ কোর্সে প্রশিক্ষণ নিয়ে স্বাবলম্বী হতে
                        পাড়বে। শিক্ষার্থী
                        তার নিজ পছন্দের বিষয়ে প্রশিক্ষণের জন্য এডমিনে কাছে অনুরোধ/আবেদন করতে পাড়বে। প্রশিক্ষণ শেষে
                        শিক্ষার্থীকে সার্টিফিকেট প্রদান করা হবে। </p>
                    <h2 class="para-heading">পোর্টালের লক্ষ্য/উদ্দেশ্য সমূহঃ</h2>

                    <ul class="sidebar-list">
                        <li><i class="fas fa-chevron-right"></i> এই প্ল্যাটফর্মে শিক্ষার্থী বিভিন্ন প্রশিক্ষণ কোর্সের
                            জন্য আবেদন করতে পারবে।
                        </li>
                        <li><i class="fas fa-chevron-right"></i> বিভিন্ন ক্যাটাগরিতে অনেক গুলো কোর্স একসাথে পরিচালনা ও
                            পর্যবেক্ষণ করা সম্ভব।
                        </li>
                        <li><i class="fas fa-chevron-right"></i> সঠিক পদ্ধতিতে শিক্ষার্থীর দক্ষতা যাচাই করা এবং বৃদ্ধি
                            করা হয় ।
                        </li>
                    </ul>
                </div>

                <div class="col-md-4 notice">
                    <div class="portlet box blue-steel notice-portlet">
                        <div class="portlet-title notice-portlet-title">
                            <div class="caption text-white">
                                <i class="far fa-bell"></i>&nbsp; সাম্প্রতিক কার্যকলাপ
                            </div>
                        </div>
                        <div class="portlet-body">
                            <div class="slimScrollDiv"
                                 style="position: relative; overflow: hidden; width: auto; height: 315px;">
                                <div id="front-right-sidebar" class="scroller"
                                     style="height: 315px; overflow: hidden; width: auto;" data-always-visible="1"
                                     data-rail-visible="0" data-initialized="1">
                                    <p style="font-size:1rem; line-height:1.5;font-family: Flaticon;color: #555;">কোন
                                        কার্যক্রম পাওয়া যায় নি ।</p>
                                </div>
                                <div class="slimScrollBar"
                                     style="background: rgb(187, 187, 187); width: 7px; position: absolute; top: 0; opacity: 0.4; display: none; border-radius: 7px; z-index: 99; right: 1px; height: 315px;"></div>
                                <div class="slimScrollRail"
                                     style="width: 7px; height: 100%; position: absolute; top: 0; display: none; border-radius: 7px; background: rgb(234, 234, 234); opacity: 0.2; z-index: 90; right: 1px;"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="banner-section">
        <div class="container banner">
            <div class="row">
                <div class="col-sm-4">
                    <div class="banner-bar">
                        <img src="https://img.icons8.com/carbon-copy/2x/image.png" alt="icon">
                        <h3><span>অভিজ্ঞ প্রশিক্ষক</span></h3>
                        <p>অভিজ্ঞ প্রশিক্ষক দ্বারা কোর্স পরিচালনা ও পর্যবেক্ষণ করা হয়।</p>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="banner-bar">
                        <img src="https://img.icons8.com/carbon-copy/2x/image.png" alt="icon">
                        <h3><span>অভিজ্ঞ প্রশিক্ষক</span></h3>
                        <p>অভিজ্ঞ প্রশিক্ষক দ্বারা কোর্স পরিচালনা ও পর্যবেক্ষণ করা হয়।</p>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="banner-bar">
                        <img src="https://img.icons8.com/carbon-copy/2x/image.png" alt="icon">
                        <h3><span>অভিজ্ঞ প্রশিক্ষক</span></h3>
                        <p>অভিজ্ঞ প্রশিক্ষক দ্বারা কোর্স পরিচালনা ও পর্যবেক্ষণ করা হয়।</p>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <section class="light-bg">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="section-heading">একনজরে</h2>
                    <p class="text-center">প্রশিক্ষণ ব্যবস্থাপনা সিস্টেমের পরিসংখ্যান</p>
                    <div class="template-space"></div>
                </div>
                <div class="company-stats col-md-12">
                    <div class="row">
                        <div class="col-md-3 col-sm-6">
                            <div class="profile-box">
                                <img
                                    src="https://d1nhio0ox7pgb.cloudfront.net/_img/o_collection_png/green_dark_grey/512x512/plain/tools.png"
                                    alt="icon">
                                <h4><span>32 টি+ </span> বিষয়ে প্রশিক্ষণ প্রদান</h4>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6">
                            <div class="profile-box">
                                <img src="https://pngimage.net/wp-content/uploads/2018/05/configuration-icon-png-4.png"
                                     alt="icon">
                                <h4><span>32 টি+ </span> বিষয়ে প্রশিক্ষণ প্রদান</h4>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6">
                            <div class="profile-box">
                                <img
                                    src="https://image.freepik.com/free-icon/slots-representing-configuration_318-9479.jpg"
                                    alt="icon">
                                <h4><span>32 টি+ </span> বিষয়ে প্রশিক্ষণ প্রদান</h4>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6">
                            <div class="profile-box">
                                <img src="https://static.thenounproject.com/png/36971-200.png" alt="icon">
                                <h4><span>32 টি+ </span> বিষয়ে প্রশিক্ষণ প্রদান</h4>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="template-news">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="section-heading text-dark">প্রশিক্ষণ শাখা</h2>
                    <p class="text-center">সমাজসেবা অধিদপ্তর হতে নিম্ন বিষয়ে প্রশিক্ষণ প্রদান করা হয়</p>
                    <div class="template-space"></div>
                </div>
            </div>
            <div class="row">
                <!--Course One-->
                <div class="col-sm-3 article-box">
                    <article>
                        <div class="news-post">
                            <div class="img-box">
                                <span>৳500</span>
                                <a href="/demo-dss/course/98" target="_blank">
                                    <img src="https://images-na.ssl-images-amazon.com/images/I/41o-zwK0i0L._SL1001_.jpg"
                                         alt="it's me Image" width="100%" height="100%">
                                </a>
                            </div>
                            <div class="post-content-text">
                                <h4>
                                    <span>নেটওয়ার্কিং</span>
                                </h4>
                                <h4>
                                    <i class="far fa-calendar-check"></i> 6
                                </h4>
                                <div class="post-more">
                                    <a href="#" target="_blank">বিস্তারিত</a>
                                    <a href="#">এপ্লাই</a>
                                </div>
                            </div>
                        </div>
                    </article>
                </div>
                <div class="col-sm-3 article-box">
                    <article>
                        <div class="news-post">
                            <div class="img-box">
                                <span>৳500</span>
                                <a href="/demo-dss/course/98" target="_blank">
                                    <img src="https://images-na.ssl-images-amazon.com/images/I/41o-zwK0i0L._SL1001_.jpg"
                                         alt="it's me Image" width="100%" height="100%">
                                </a>
                            </div>
                            <div class="post-content-text">
                                <h4>
                                    <span>ডাটাবেজ এন্ড নেটওয়ার্কিং</span>
                                </h4>
                                <h4>
                                    <i class="fas fa-calendar-check"></i> 6
                                </h4>
                                <div class="post-more">
                                    <a href="#" target="_blank">বিস্তারিত</a>
                                    <a href="#">এপ্লাই</a>
                                </div>
                            </div>
                        </div>
                    </article>
                </div>
                <div class="col-sm-3 article-box">
                    <article>
                        <div class="news-post">
                            <div class="img-box">
                                <span>৳500</span>
                                <a href="/demo-dss/course/98" target="_blank">
                                    <img src="https://images-na.ssl-images-amazon.com/images/I/41o-zwK0i0L._SL1001_.jpg"
                                         alt="it's me Image" width="100%" height="100%">
                                </a>
                            </div>
                            <div class="post-content-text">
                                <h4>
                                    <span>ডাটাবেজ ম্যানেজমেন্ট এন্ড নেটওয়ার্কিং</span>
                                </h4>
                                <h4>
                                    <i class="far fa-calendar-check"></i> 6
                                </h4>
                                <div class="post-more">
                                    <a href="#" target="_blank">বিস্তারিত</a>
                                    <a href="#">এপ্লাই</a>
                                </div>
                            </div>
                        </div>
                    </article>
                </div>
                <div class="col-sm-3 article-box">
                    <article>
                        <div class="news-post">
                            <div class="img-box">
                                <span>৳500</span>
                                <a href="/demo-dss/course/98" target="_blank">
                                    <img src="https://images-na.ssl-images-amazon.com/images/I/41o-zwK0i0L._SL1001_.jpg"
                                         alt="it's me Image" width="100%" height="100%">
                                </a>
                            </div>
                            <div class="post-content-text">
                                <h4>
                                    <span>ডাটাবেজ ম্যানেজমেন্ট এন্ড নেটওয়ার্কিং</span>
                                </h4>
                                <h4>
                                    <i class="fas fa-calendar-check"></i> 6
                                </h4>
                                <div class="post-more">
                                    <a href="#" target="_blank">বিস্তারিত</a>
                                    <a href="#">এপ্লাই</a>
                                </div>
                            </div>
                        </div>
                    </article>
                </div>


                <div class="col-md-12 text-center margin-10">
                    <a href="#" target="_blank" class="service-box-button">আরও কোর্স দেখুন</a>
                </div>
            </div>
        </div>
    </section>
@endsection
@push('js')
@endpush
