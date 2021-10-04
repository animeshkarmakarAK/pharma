@php
    $currentInstitute = domainConfig('institute');
    $layout = $currentInstitute ? 'master::layouts.custom1' : 'master::layouts.front-end';
@endphp
@extends($layout)

@section('content')
    <!-- Top content Slider Start -->
    <section class="top-content">
        <!-- Carousel -->
        <div id="carousel-example" class="carousel slide" data-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-item active"
                     style="background: url('https://dwtyzx6upklss.cloudfront.net/Pictures/1024x536/4/5/9/11459_covid19protectingworkersrights_666160.jpg');">
                    <div class="overlay" style=" background:linear-gradient( rgba(0, 0, 0, 0.5),rgba(0, 0, 0, 0.5))" ;>
                        <div class="carousel-caption">
                            <h3>সমাজসেবা অধিদপ্তর-গণপ্রজাতন্ত্রী </h3>
                        </div>
                    </div>
                </div>
                <div class="carousel-item"
                     style="background: url('https://images.unsplash.com/photo-1541746972996-4e0b0f43e02a?ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&ixlib=rb-1.2.1&auto=format&fit=crop&w=1470&q=80');">
                    <div class="carousel-caption">
                        <h3>সমাজসেবা অধিদপ্তর সমাজসেবা সমাজসেবা</h3>
                    </div>
                </div>
                <div class="carousel-item"
                     style="background: url('https://static.vecteezy.com/system/resources/previews/000/677/302/non_2x/abstract-technology-banner-background.jpg');">
                    <div class="carousel-caption">
                        <h3>সমাজসেবা অধিদপ্তর-গণপ্রজাতন্ত্রী </h3>
                    </div>
                </div>
                <div class="carousel-item"
                     style="background: url('https://images.unsplash.com/photo-1541746972996-4e0b0f43e02a?ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&ixlib=rb-1.2.1&auto=format&fit=crop&w=1470&q=80');">
                    <div class="carousel-caption">
                        <h3>সমাজসেবা অধিদপ্তর সমাজসেবা সমাজসেবা</h3>
                    </div>
                </div>
            </div>

            <a class="carousel-control-prev slider-previous-link" href="#carousel-example" role="button"
               data-slide="prev">
                <span class="slider-previous-icon" aria-hidden="true">
                        <i class="fas fa-chevron-left"></i>
                </span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#carousel-example" role="button" data-slide="next">
                <span class="slider-next-icon" aria-hidden="true">
                        <i class="fas fa-chevron-right"></i>
                </span>
                <span class="sr-only">Next</span>
            </a>
        </div>
        <!-- End carousel -->
    </section>
    <!-- End Top Content Slider -->

    <!-- About Us Start-->
    <section class="about-us-section  position-relative">
        <div class="about-section-color">
            <div class="container pt-5 pb-5">
                <div class="row">
                    <div class="col-md-7">
                        <!--Services Heading-->
                        <h2 class="section-heading-h2 pb-3 mb-0 font-weight-bold"> আমাদের সম্পর্কে </h2>
                        <div class="about-us-content">
                            <p>গণপ্রজাতন্ত্রী বাংলাদেশ সরকারের রূপকল্প ২০২১ বাস্তবায়নে যুবকদের আত্নকর্মসংস্থান ও
                                স্বাবলম্বী
                                করে
                                তোলার লক্ষ্যে "অনলাইনে বিভিন্ন প্রশিক্ষণ কোর্সের পরিচালনা ও পর্যবেক্ষণ করা"।
                                এই ওয়েব অ্যাপ্লিকেশনটি মূলত "অনলাইন কোর্স ম্যানেজমেন্ট সিস্টেম"।
                                এই প্ল্যাটফর্মে শিক্ষার্থী অতি সহজে বিভিন্ন প্রশিক্ষণ কোর্সে প্রশিক্ষণ নিয়ে স্বাবলম্বী
                                হতে
                                পাড়বে। শিক্ষার্থী
                                তার নিজ পছন্দের বিষয়ে প্রশিক্ষণের জন্য এডমিনে কাছে অনুরোধ/আবেদন করতে পাড়বে। প্রশিক্ষণ
                                শেষে
                                শিক্ষার্থীকে সার্টিফিকেট প্রদান করা হবে। </p>
                            <h2 class="para-heading about-use-para-heading font-weight-light">পোর্টালের লক্ষ্য/উদ্দেশ্য
                                সমূহঃ</h2>

                            <ul class="sidebar-list">
                                <li><i class="font-weight-bold lists">*</i> এই প্ল্যাটফর্মে শিক্ষার্থী বিভিন্ন প্রশিক্ষণ
                                    কোর্সের
                                    জন্য আবেদন করতে পারবে।
                                </li>
                                <li><i class="font-weight-bold lists">*</i> বিভিন্ন ক্যাটাগরিতে অনেক গুলো কোর্স একসাথে
                                    পরিচালনা
                                    ও
                                    পর্যবেক্ষণ করা সম্ভব।
                                </li>
                                <li><i class="font-weight-bold lists">*</i> সঠিক পদ্ধতিতে শিক্ষার্থীর দক্ষতা যাচাই করা
                                    এবং
                                    বৃদ্ধি
                                    করা হয় ।
                                </li>
                            </ul>
                        </div>
                    </div>


                    <div class="col-md-5 img-div">
                        <div class="image-div-2">
                            <iframe src="https://www.youtube.com/embed/4CzYXfBeIdM" height="400" width="460"
                                    title="Iframe" class="cr-img"></iframe>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End About Us-->

    <!-- At A Glance Start -->
    <section class="bg-white pb-5">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="section-heading section-heading-home pb-5">একনজরে</h2>
                    <p class="text-center pb-2"> বিটাক প্রশিক্ষণ ও কোর্স ম্যানেজমেন্ট সিস্টেমের পরিসংখ্যান</p>
                    <div class="template-space"></div>
                </div>
            </div>
            <div class="row">
                <dvi class="col-md-2"></dvi>
                <div class="col-md-2 ">
                    <div class="instant-view-box instant-view-box-home">
                        <i class="fas fa-user-friends fa-3x p-3 custom-icon"></i>
                        <h1>10</h1>
                        <p>প্রশিক্ষণ প্রদান</p>
                    </div>
                </div>
                <div class="col-md-2 ">
                    <div class="instant-view-box instant-view-box-home">
                        <i class="fas fa-graduation-cap fa-flip-horizontal fa-3x p-3 custom-icon"></i>
                        <h1>10</h1>
                        <p>প্রশিক্ষণ গ্রহণ</p>
                    </div>
                </div>
                <div class="col-md-2 ">
                    <div class="instant-view-box instant-view-box-home">
                        <i class="fas fa-hotel fa-3x p-3 custom-icon"></i>
                        <h1>10</h1>
                        <p>প্রশিক্ষণ কেন্দ্র</p>
                    </div>
                </div>
                <div class="col-md-2 ">
                    <div class="instant-view-box instant-view-box-home">
                        <i class="fas fa-user-tie fa-3x p-3 custom-icon"></i>
                        <h1>10</h1>
                        <p>প্রশিক্ষক</p>
                    </div>
                </div>
                <div class="col-md-2"></div>
            </div>
        </div>
    </section>
    <!-- End At A Glance -->

    <!-- Courses Start -->
    <section class="container-fluid slider-area course-section">
        <div class="container my-4">
            <div class="row">
                <div class="col-md-12 mb-3">
                    <h3 class="section-heading section-heading-home pb-5">কোর্স সমূহ</h3>
                </div>
            </div>
            <div class="col-md-12 ">
                <div class="accordion" id="accordionExample">
                    <div id="popular-course" class="collapse show" aria-labelledby="popular-course"
                         data-parent="#accordionExample">
                        <!--Carousel Wrapper-->
                        <div id="pop-crs-arrow" class="carousel slide carousel-multi-item"
                             data-ride="carousel">

                            <!--Controls-->
                            <div class="controls-top">
                                <a class="btn-floating left-btn-arrow" href="#pop-crs-arrow"
                                   data-slide="prev"><i
                                        class="fas fa-chevron-left"></i></a>
                                <a class="btn-floating right-btn-arrow" href="#pop-crs-arrow"
                                   data-slide="next"><i
                                        class="fas fa-chevron-right"></i></a>
                            </div>
                            <!--/.Controls-->

                            <!--Indicators-->
                            <ol class="carousel-indicators">
                                <li data-target="#pop-crs-arrow" data-slide-to="0" class="active"></li>
                                <li data-target="#pop-crs-arrow" data-slide-to="1"></li>

                            </ol>
                            <!--/.Indicators-->

                            <!--Slides-->
                            <div class="carousel-inner" role="listbox">

                                <!--First slide-->
                                <div class="carousel-item active">
                                    <div class="col-md-3" style="float:left">
                                        <div class="card card-main mb-2">
                                            <div class="card-bar-home-course">
                                                <div class="pb-3">
                                                    <img class="slider-img border-top-radius"
                                                         src="https://images.unsplash.com/photo-1541746972996-4e0b0f43e02a?ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&ixlib=rb-1.2.1&auto=format&fit=crop&w=1470&q=80"
                                                         alt="icon">
                                                </div>
                                                <div class="text-left pl-4 pr-4 pt-1 pb-1">
                                                    <p class="card-p1">বিনামূল্য</p>
                                                    <p class="font-weight-bold">ঝালাই নিয়মিত</p>
                                                    <p class="font-weight-light mb-1"><i
                                                            class="fas fa-clock gray-color"></i> <span class="course-p">১ ঘন্টা ৩০ মিনিট</span>
                                                    </p>
                                                    <p class="font-weight-light"><i
                                                            class="fas fa-user-plus gray-color"></i>
                                                        <span class="course-p">Student(16.1k)</span></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-3" style="float:left">
                                        <div class="card card-main mb-2">
                                            <div class="card-bar-home-courser">
                                                <div class="pb-3">
                                                    <img class="slider-img border-top-radius"
                                                         src="https://static.vecteezy.com/system/resources/previews/000/677/302/non_2x/abstract-technology-banner-background.jpg"
                                                         alt="icon">
                                                </div>
                                                <div class="text-left pl-4 pr-4 pt-1 pb-1">
                                                    <p class="card-p1">বিনামূল্য</p>
                                                    <p class="font-weight-bold">ঝালাই নিয়মিত</p>
                                                    <p class="font-weight-light mb-1"><i
                                                            class="fas fa-clock gray-color"></i> <span
                                                            class="course-p ">১ ঘন্টা ৩০ মিনিট</span></p>
                                                    <p class="font-weight-light"><i
                                                            class="fas fa-user-plus gray-color"></i>
                                                        <span class="course-p">Student(16.1k)</span></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-3" style="float:left">
                                        <div class="card card-main mb-2">
                                            <div class="card-bar-home-course">
                                                <div class="pb-3">
                                                    <img class="slider-img border-top-radius"
                                                         src="https://images.unsplash.com/photo-1541746972996-4e0b0f43e02a?ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&ixlib=rb-1.2.1&auto=format&fit=crop&w=1470&q=80"
                                                         alt="icon">
                                                </div>
                                                <div class="text-left pl-4 pr-4 pt-1 pb-1">
                                                    <p class="card-p1">বিনামূল্য</p>
                                                    <p class="font-weight-bold">ঝালাই নিয়মিত</p>
                                                    <p class="font-weight-light mb-1"><i
                                                            class="fas fa-clock gray-color"></i> <span class="course-p">১ ঘন্টা ৩০ মিনিট</span>
                                                    </p>
                                                    <p class="font-weight-light"><i
                                                            class="fas fa-user-plus gray-color"></i>
                                                        <span class="course-p">Student(16.1k)</span></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-3" style="float:left">
                                        <div class="card card-main mb-2">
                                            <div class="card-bar-home-course">
                                                <div class="pb-3">
                                                    <img class="slider-img border-top-radius"
                                                         src="https://static.vecteezy.com/system/resources/previews/000/677/302/non_2x/abstract-technology-banner-background.jpg"
                                                         alt="icon">
                                                </div>
                                                <div class="text-left pl-4 pr-4 pt-1 pb-1">
                                                    <p class="card-p1">বিনামূল্য</p>
                                                    <p class="font-weight-bold">কঝালাই নিয়মিত</p>
                                                    <p class="font-weight-light mb-1"><i
                                                            class="fas fa-clock gray-color"></i> <span class="course-p">১ ঘন্টা ৩০ মিনিট</span>
                                                    </p>
                                                    <p class="font-weight-light"><i
                                                            class="fas fa-user-plus gray-color"></i>
                                                        <span class="course-p">Student(16.1k)</span></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <!--/.First slide-->

                                <!--Second slide-->
                                <div class="carousel-item">

                                    <div class="col-md-3" style="float:left">
                                        <div class="card card-main mb-2">
                                            <div class="card-bar-home-course">
                                                <div class="pb-3">
                                                    <img class="slider-img border-top-radius"
                                                         src="https://images.unsplash.com/photo-1541746972996-4e0b0f43e02a?ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&ixlib=rb-1.2.1&auto=format&fit=crop&w=1470&q=80"
                                                         alt="icon">
                                                </div>
                                                <div class="text-left pl-4 pt-1 pb-1">
                                                    <p class="card-p1">বিনামূল্য</p>
                                                    <p class="font-weight-bold">ঝালাই নিয়মিত</p>
                                                    <p class="font-weight-light mb-1"><i
                                                            class="fas fa-clock gray-color"></i> <span class="course-p">১ ঘন্টা ৩০ মিনিট</span>
                                                    </p>
                                                    <p class="font-weight-light"><i
                                                            class="fas fa-user-plus gray-color"></i>
                                                        <span class="course-p">Student(16.1k)</span></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-3" style="float:left">
                                        <div class="card card-main mb-2">
                                            <div class="card-bar-home-course">
                                                <div class="pb-3">
                                                    <img class="slider-img border-top-radius"
                                                         src="https://static.vecteezy.com/system/resources/previews/000/677/302/non_2x/abstract-technology-banner-background.jpg"
                                                         alt="icon">
                                                </div>
                                                <div class="text-left pl-4 pt-1 pb-1">
                                                    <p class="card-p1">বিনামূল্য</p>
                                                    <p class="font-weight-bold">ঝালাই নিয়মিত</p>
                                                    <p class="font-weight-light mb-1"><i
                                                            class="fas fa-clock gray-color"></i> <span class="course-p">১ ঘন্টা ৩০ মিনিট</span>
                                                    </p>
                                                    <p class="font-weight-light"><i
                                                            class="fas fa-user-plus gray-color"></i>
                                                        <span class="course-p">Student(16.1k)</span></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-3" style="float:left">
                                        <div class="card card-main mb-2">
                                            <div class="card-bar-home-course">
                                                <div class="pb-3">
                                                    <img class="slider-img border-top-radius"
                                                         src="https://images.unsplash.com/photo-1541746972996-4e0b0f43e02a?ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&ixlib=rb-1.2.1&auto=format&fit=crop&w=1470&q=80"
                                                         alt="icon">
                                                </div>
                                                <div class="text-left pl-4 pt-1 pb-1">
                                                    <p class="card-p1">বিনামূল্য</p>
                                                    <p class="font-weight-bold">ঝালাই নিয়মিত</p>
                                                    <p class="font-weight-light mb-1"><i
                                                            class="fas fa-clock gray-color"></i> <span class="course-p">১ ঘন্টা ৩০ মিনিট</span>
                                                    </p>
                                                    <p class="font-weight-light"><i
                                                            class="fas fa-user-plus gray-color"></i>
                                                        <span class="course-p">Student(16.1k)</span></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-3" style="float:left">
                                        <div class="card card-main mb-2">
                                            <div class="card-bar-home-course">
                                                <div class="pb-3">
                                                    <img class="slider-img border-top-radius"
                                                         src="https://static.vecteezy.com/system/resources/previews/000/677/302/non_2x/abstract-technology-banner-background.jpg"
                                                         alt="icon">
                                                </div>
                                                <div class="text-left pl-4 pt-1 pb-1">
                                                    <p class="card-p1">বিনামূল্য</p>
                                                    <p class="font-weight-bold">ঝালাই নিয়মিত</p>
                                                    <p class="font-weight-light mb-1"><i
                                                            class="fas fa-clock gray-color"></i> <span class="course-p">১ ঘন্টা ৩০ মিনিট</span>
                                                    </p>
                                                    <p class="font-weight-light"><i
                                                            class="fas fa-user-plus gray-color"></i>
                                                        <span class="course-p">Student(16.1k)</span></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <!--/.Second slide-->
                            </div>
                            <!--/.Slides-->
                        </div>
                        <!--/.Carousel Wrapper-->

                        <div class="col-md-12 text-center pt-5">
                            <a href="#" target="_blank" class="more-course-button">আরও দেখুন <i
                                    class="fas fa-arrow-right btn-arrow"></i></a>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End Courses -->

    <!-- Event Start -->
    <section class="yearly-training-calendar bg-white">
        <div class="container pb-5">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="section-heading">ইভেন্ট</h2>
                </div>
            </div>
        </div>
        <div class="container p-5 card">
            <div class="row">
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-md-12">
                            <h3 class="accordion-heading">শুক্রবার, ২৫ জানুয়ারী ২০২১</h3>
                            <!-- Accordion -->
                            <div id="accordionExample" class="accordion">

                                <!-- Accordion item 1 -->
                                <div class="card shadow-none mb-0">
                                    <div id="headingOne" class="card-header bg-white shadow-sm border-0">
                                        <h2 class="mb-0">
                                            <button type="button" data-toggle="collapse" data-target="#collapseOne"
                                                    aria-expanded="true" aria-controls="collapseOne"
                                                    class="btn btn-link text-dark font-weight-bold text-uppercase collapsible-link">
                                                সেপা প্রকল্পের মোটিভেশনাল ওয়ার্কশপ <p class="mb-0">
                                                    <i class="far fa-calendar-minus gray-color"></i>
                                                    <span class="accordion-date">১২/০৯/২০২১</span>
                                                </p>
                                            </button>
                                        </h2>
                                    </div>
                                    <div id="collapseOne" aria-labelledby="headingOne" data-parent="#accordionExample"
                                         class="collapse {{--show--}}">
                                        <div class="card-body p-5">
                                            <p class="font-weight-light m-0">Anim pariatur cliche reprehenderit, enim
                                                eiusmod high life accusamus terry richardson ad squid. 3 wolf moon
                                                officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa
                                                nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a
                                                bird on it squid single-origin coffee nulla assumenda shoreditch et.</p>
                                        </div>
                                    </div>
                                </div><!-- End -->

                                <!-- Accordion item 2 -->
                                <div class="card shadow-none mb-0">
                                    <div id="headingTwo" class="card-header bg-white shadow-sm border-0">
                                        <h2 class="mb-0">
                                            <button type="button" data-toggle="collapse" data-target="#collapseTwo"
                                                    aria-expanded="false" aria-controls="collapseTwo"
                                                    class="btn btn-link collapsed text-dark font-weight-bold text-uppercase collapsible-link">
                                                সেপা প্রকল্পের মোটিভেশনাল ওয়ার্কশপ
                                                <p class="mb-0">
                                                    <i class="far fa-calendar-minus gray-color"></i>
                                                    <span class="accordion-date">১২/০৯/২০২১</span>
                                                </p>
                                            </button>
                                        </h2>
                                    </div>
                                    <div id="collapseTwo" aria-labelledby="headingTwo" data-parent="#accordionExample"
                                         class="collapse">
                                        <div class="card-body p-5">
                                            <p class="font-weight-light m-0">Anim pariatur cliche reprehenderit, enim
                                                eiusmod high life accusamus terry richardson ad squid. 3 wolf moon
                                                officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa
                                                nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a
                                                bird on it squid single-origin coffee nulla assumenda shoreditch et.</p>
                                        </div>
                                    </div>
                                </div><!-- End -->

                                <!-- Accordion item 3 -->
                                <div class="card shadow-none mb-0">
                                    <div id="headingThree" class="card-header bg-white shadow-sm border-0">
                                        <h2 class="mb-0">
                                            <button type="button" data-toggle="collapse" data-target="#collapseThree"
                                                    aria-expanded="false" aria-controls="collapseThree"
                                                    class="btn btn-link collapsed text-dark font-weight-bold text-uppercase collapsible-link">
                                                সেপা প্রকল্পের মোটিভেশনাল ওয়ার্কশপ <p class="mb-0"><i
                                                        class="far fa-calendar-minus gray-color"></i> <span
                                                        class="accordion-date">১২/০৯/২০২১</span></p></button>
                                        </h2>
                                    </div>
                                    <div id="collapseThree" aria-labelledby="headingThree"
                                         data-parent="#accordionExample" class="collapse">
                                        <div class="card-body p-5">
                                            <p class="font-weight-light m-0">Anim pariatur cliche reprehenderit, enim
                                                eiusmod high life accusamus terry richardson ad squid. 3 wolf moon
                                                officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa
                                                nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a
                                                bird on it squid single-origin coffee nulla assumenda shoreditch et.</p>
                                        </div>
                                    </div>
                                </div><!-- End -->

                            </div><!-- End -->
                        </div>
                    </div>
                </div>
                <div class="col-md-6 rounded">
                    <div id='calendar'></div>
                </div>
            </div>

        </div>
    </section>
    <!-- End Event -->

    <!-- Gallery Start -->
    <section class="gallery">
        <div class="container">
            <div class="row mt-4">
                <div class="col-md-12 mb-3">
                    <h3 class="gallery-section-heading section-heading-home section-heading pb-5">গ্যালারি</h3>
                </div>
                <div class="col-md-12">
                    <!-- Video Gallery Start-->
                    <div id="video-gallery" class="collapse show" aria-labelledby="video-gallery"
                         data-parent="#accordionExample">
                        <!--Carousel Wrapper-->
                        <div id="multi-item-example-vdo" class="carousel slide carousel-multi-item"
                             data-ride="carousel">

                            <!--Controls-->
                            <div class="controls-top">
                                <a class="btn-floating left-btn-arrow" href="#multi-item-example-vdo"
                                   data-slide="prev"><i
                                        class="fas fa-chevron-left"></i></a>
                                <a class="btn-floating right-btn-arrow" href="#multi-item-example-vdo"
                                   data-slide="next"><i
                                        class="fas fa-chevron-right"></i></a>
                            </div>
                            <!--/.Controls-->

                            <!--Indicators-->
                            <ol class="carousel-indicators">
                                <li data-target="#multi-item-example-vdo" data-slide-to="0" class="active"></li>
                                <li data-target="#multi-item-example-vdo" data-slide-to="1"></li>

                            </ol>
                            <!--/.Indicators-->

                            <!--Slides-->
                            <div class="carousel-inner" role="listbox">

                                <!--First slide-->
                                <div class="carousel-item active">
                                    <div class="col-md-3" style="float:left">
                                        <div class="card card-main mb-2 shadow-none bg-transparent">
                                            <img class="slider-img"
                                                 src="https://images.unsplash.com/photo-1541746972996-4e0b0f43e02a?ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&ixlib=rb-1.2.1&auto=format&fit=crop&w=1470&q=80">
                                            <h3 class="gallery-post-heading">সেপা প্রকল্পের মোটিভেশনাল ওয়ার্কশপ</h3>
                                        </div>
                                    </div>

                                    <div class="col-md-3" style="float:left">
                                        <div class="card card-main mb-2 shadow-none bg-transparent">
                                            <img class="slider-img"
                                                 src="https://images.unsplash.com/photo-1541746972996-4e0b0f43e02a?ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&ixlib=rb-1.2.1&auto=format&fit=crop&w=1470&q=80"
                                                 alt="icon">
                                            <h3 class="gallery-post-heading">সেপা প্রকল্পের মোটিভেশনাল ওয়ার্কশপ</h3>
                                        </div>
                                    </div>

                                    <div class="col-md-3" style="float:left">
                                        <div class="card card-main mb-2 shadow-none bg-transparent">
                                            <img class="slider-img"
                                                 src="https://images.unsplash.com/photo-1541746972996-4e0b0f43e02a?ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&ixlib=rb-1.2.1&auto=format&fit=crop&w=1470&q=80"
                                                 alt="icon">
                                            <h3 class="gallery-post-heading">সেপা প্রকল্পের মোটিভেশনাল ওয়ার্কশপ</h3>
                                        </div>
                                    </div>

                                    <div class="col-md-3" style="float:left">
                                        <div class="card card-main mb-2 shadow-none bg-transparent">
                                            <img class="slider-img"
                                                 src="https://images.unsplash.com/photo-1541746972996-4e0b0f43e02a?ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&ixlib=rb-1.2.1&auto=format&fit=crop&w=1470&q=80"
                                                 alt="icon">
                                            <h3 class="gallery-post-heading">সেপা প্রকল্পের মোটিভেশনাল ওয়ার্কশপ</h3>
                                        </div>
                                    </div>

                                </div>
                                <!--/.First slide-->

                                <!--Second slide-->
                                <div class="carousel-item">

                                    <div class="col-md-3" style="float:left">
                                        <div class="card card-main mb-2 shadow-none bg-transparent">
                                            <img class="slider-img"
                                                 src="https://images.unsplash.com/photo-1541746972996-4e0b0f43e02a?ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&ixlib=rb-1.2.1&auto=format&fit=crop&w=1470&q=80"
                                                 alt="icon">
                                            <h3 class="gallery-post-heading">সেপা প্রকল্পের মোটিভেশনাল ওয়ার্কশপ</h3>
                                        </div>
                                    </div>

                                    <div class="col-md-3" style="float:left">
                                        <div class="card card-main mb-2 shadow-none bg-transparent">
                                            <img class="slider-img"
                                                 src="https://images.unsplash.com/photo-1541746972996-4e0b0f43e02a?ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&ixlib=rb-1.2.1&auto=format&fit=crop&w=1470&q=80"
                                                 alt="icon">
                                            <h3 class="gallery-post-heading">সেপা প্রকল্পের মোটিভেশনাল ওয়ার্কশপ</h3>
                                        </div>
                                    </div>

                                    <div class="col-md-3" style="float:left">
                                        <div class="card card-main mb-2 shadow-none bg-transparent">
                                            <img class="slider-img"
                                                 src="https://images.unsplash.com/photo-1541746972996-4e0b0f43e02a?ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&ixlib=rb-1.2.1&auto=format&fit=crop&w=1470&q=80"
                                                 alt="icon">
                                            <h3 class="gallery-post-heading">সেপা প্রকল্পের মোটিভেশনাল ওয়ার্কশপ</h3>
                                        </div>
                                    </div>

                                    <div class="col-md-3" style="float:left">
                                        <div class="card card-main mb-2 shadow-none bg-transparent">
                                            <img class="slider-img"
                                                 src="https://images.unsplash.com/photo-1541746972996-4e0b0f43e02a?ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&ixlib=rb-1.2.1&auto=format&fit=crop&w=1470&q=80"
                                                 alt="icon">
                                            <h3 class="gallery-post-heading">সেপা প্রকল্পের মোটিভেশনাল ওয়ার্কশপ</h3>
                                        </div>
                                    </div>

                                </div>
                                <!--/.Second slide-->
                            </div>
                            <!--/.Slides-->
                        </div>
                        <!--/.Carousel Wrapper-->
                        <div class="col-md-12 text-center pt-5 pb-5">
                            <a href="#" target="_blank" class="more-course-button">আরও দেখুন <i
                                    class="fas fa-arrow-right btn-arrow"></i></a>
                        </div>
                    </div>
                    <!-- End Video Gallery -->
                </div>
            </div>
        </div>
    </section>
    <!-- End Gallery -->

@endsection

@push('css')
    <style>
        .para-heading {
            color: #671688 !important;
        }

        .section-heading-h2 {
            color: #671688;
        }

        .lists {
            color: black !important;
        }

        .about-section-color {
            background-color: #f6f9f9;
        }

        .course-div {
            padding-top: 75px;
        }

        .course-section {
            background: #FFFFFF;
        }

        .course-btn {
            padding: 10px 30px;
            color: #671688;
            border-radius: 5px;
            transition: .4s;
        }

        .course-btn-dem {
            background: #671688;
            color: #fff;
            border: 1px solid #671688;
            padding: 10px 30px;
            border-radius: 5px;
            transition: .4s;
        }

        .course-btn:active {
            background: #671688;
            color: #fff;
            border: 1px solid #671688;
        }

        .card-p1 {
            color: #671688;
        }

        .cr-img {
            border: 0;
            border-radius: 15px;
        }

        .img-div {
            position: absolute;
            right: 0;
            top: 20px;
        }

        .image-div-2 {
            height: 400px;
            background: url(https://www.onpointcomputerrepairs.com.au/wp-content/uploads/2020/04/1-1-1.jpg);
            background: no-repeat;
            border-radius: 0;
            /*top: -90px;*/
            position: absolute;
            width: 460px;
        }

        .at-glance-section {
            padding-bottom: 110px;
        }

        .banner-bar {
            border-radius: 15px;
        }

        .banner-bar-color-1 {
            background-color: #0069bc;
        }

        .banner-bar-color-2 {
            background-color: #168866;
        }

        .banner-bar-color-3 {
            background-color: #e67e22;
        }

        .banner-bar h3, .banner-bar p {
            color: #ffffff;
        }

        .icons {
            font-size: 60px;
            color: #FFFFFF;
            padding: 10px;
        }

        .banner-bar p {
            font-size: 15px;
        }

        .left-btn-arrow {
            position: absolute;
            left: -2%;
            bottom: 46%;
        }

        .right-btn-arrow {
            position: absolute;
            right: -2%;
            bottom: 46%;
        }

        .carousel-indicators {
            top: 100%;
        }

        .carousel-indicators li {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background-color: #c4c4c4;
        }

        .carousel-control-prev, .carousel-control-next {
            opacity: 1;
        }

        .card-h1 {
            font-size: 16px;
        }

        .card-h1, .card-p {
            color: #000000 !important;
        }


        .card-icons {
            color: #671688;
            font-size: 60px;
            padding: 10px;
        }

        .card-main {
            border-radius: 5px;
        }

        .card-bar {
            padding: 10px 15px;
            text-align: center;
            margin: 0 10px;
            transition: .4s;
            cursor: pointer;
            border-radius: 50%;
        }

        .more-course-button {
            background: #fff;
            color: #671688;
            padding: 10px 25px;
            display: inline-block;
            margin: 30px 0 0 0;
            transition: .4s;
            border: 1px solid #671688;
            border-radius: 20px;
        }

        .btn-arrow {
            font-size: 1rem;
            padding-left: 1rem;
            margin-right: -10px;
        }

        .btn-floating {
            color: black;
        }

        .slider-img {
            width: 100%;
            height: 11vw;
            object-fit: cover;
        }
    </style>
    <style>
        /*sliders css*/
        .slider-left-content h1 {
            color: #000000;
            font-size: 1.5rem;
            font-weight: bold;
            margin-bottom: 15px;
        }

        .slider-left-content p {
            margin-bottom: 45px;
            color: #6C6B76;
        }

        .slider-left-content a {
            background: #671688;
            padding: 15px 25px;
            color: #fff;
            border: 1px solid #671688;
            border-radius: 5px;
            letter-spacing: 2px;
            transition: .4s;
        }

        .slider-left-content a:hover {
            background: #4c4c4c;
            border: 1px solid #4c4c4c;
            transition: .4s;
        }


        .slider-right-content img {
            float: right;
            height: 135px !important;
            width: 100% !important;
            margin-top: 150px;
        }

        .slider-previous-icon, .slider-next-icon {
            border: 1px solid white;
            padding: 15px;
            border-radius: 50%;
        }

        .slider-previous-icon i, .slider-next-icon i {
            display: block;
            width: 15px;
            color: white;
            font-size: 15px;
        }


        .slider-previous-link, .slider-next-link {
            width: 8% !important;
        }

        .player-icon {
            position: absolute !important;
            left: 45%;
            top: 45%;
            font-size: 35px;
            color: #65546B;
            z-index: 99999;
        }

        /*Top Content Slider*/

        .top-content {
            width: 100%;
            padding: 0;
        }

        .top-content .carousel-control-prev {
            border-bottom: 0;
        }

        .top-content .carousel-control-next {
            border-bottom: 0;
        }

        .top-content .carousel-caption {
            padding-bottom: 60px;
            padding-top: 0;
        }

        .top-content .carousel-caption h1 {
            padding-top: 60px;
            color: #fff;
        }

        .top-content .carousel-caption h3 {
            color: #fff;
        }

        .top-content .carousel-caption .carousel-caption-description {
            color: #fff;
            color: rgba(255, 255, 255, 0.8);
        }

        .top-content .carousel-indicators li {
            width: 16px;
            height: 16px;
            margin-left: 5px;
            margin-right: 5px;
            border-radius: 50%;
        }

        .top-content .carousel-item {
            height: 450px;
        }

        .carousel-caption {
            top: 45%;
        }

        /*About Us*/

        .about-us-section {
            background: #FFFFFF;
            padding-top: 4rem;
        }

        .about-us-content p {
            line-height: 30px;
            font-size: 14px;
        }

        .about-use-para-heading {
            padding-top: 25px;
            font-size: 1.5rem !important;
            font-weight: 400 !important;
        }

        .sidebar-list li {
            list-style: none;
            font-size: 14px;
            line-height: 30px;
        }

        /*Aknojore*/

        .section-heading-home {
            color: #671688;
            font-weight: bold;
        }

        .instant-view-box-home {
            margin-right: 20px;
            padding: 0;
            box-shadow: 0px 5px 5px #d7d7d7;
            transition: 0.3s;
        }

        .instant-view-box-home:hover {
            box-shadow: 0px 0px 5px #d7d7d7;
        }

        .instant-view-box-home i {
            font-size: 35px;
        }

        .instant-view-box-home h1 {
            font-size: 30px;
        }

        /*Courses*/

        .card-bar-home-course {
            padding: 0;
            margin: 0;
        }

        .gray-color {
            color: #73727f;
        }

        .course-p {
            font-size: 14px;
            font-weight: 400;
            color: #671688;
        }

        .border-top-radius {
            border-top-left-radius: 5px;
            border-top-right-radius: 5px;
        }


        /* Gallery */
        .gallery {
            background: #FFFFFF;
        }

        .gallery-section-heading:before {
            left: 50.5%;
        }

        .gallery-post-heading {
            font-size: 1rem;
            padding: 15px;
            font-weight: 400;
        }

        /* Event */
        .accordion-heading {
            background: #671688;
            color: #ffffff;
            padding: 20px;
            border-radius: 10px;
            font-size: 20px;
            text-align: center;
        }

        .collapsible-link {
            width: 100%;
            position: relative;
            text-align: left;
        }

        .collapsible-link::before {
            content: '\f107';
            position: absolute;
            top: 50%;
            right: 0.8rem;
            transform: translateY(-50%);
            display: block;
            font-family: 'Font Awesome 5 Free';
            font-size: 1.1rem;
        }

        .collapsible-link[aria-expanded='true']::before {
            content: '\f106';
        }

        .accordion-date {
            font-size: 12px;
            padding-left: 5px;
            color: darkgray;
        }


        /*Footer*/

        .main-footer {
            background: #eeeeee;
        }

        .footer-2 {
            background: #FFFFFF;
        }


    </style>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@5.7.0/main.min.css" type="text/css">
    <style>

        #calendar {
            background-color: #F2F7F8;
            border-radius: 5px;
        }

        .fc-daygrid-day-number {
            /*font-size: x-large;*/
        }

        .fc-daygrid-event {
            cursor: pointer;
        }

        .fc-daygrid-day-top {
            justify-content: center;
        }


    </style>
@endpush
@push('js')
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.9.0/main.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.9.0/locales-all.js"></script>
    <script>
        async function courseDetailsModalOpen(publishCourseId) {
            let response = await $.get('{{route('course_management::course-details.ajax', ['publish_course_id' => '__'])}}'.replace('__', publishCourseId));

            if (response?.length) {
                $("#course_details_modal").find(".modal-content").html(response);
            } else {
                let notFound = `<div class="alert alert-danger">Not Found</div>`
                $("#course_details_modal").find(".modal-content").html(notFound);
            }

            $("#course_details_modal").modal('show');
        }

        $(function () {
            let calendarEl = document.getElementById('calendar');
            let initialDate = '{{date('Y-m-d')}}';
            let initialLocaleCode = 'bn';

            let calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                initialDate,
                height: 300,
                aspectRatio: 1,
                displayEventTime: false,
                customButtons: {
                    myCustomButton: {
                        text: 'বছর',
                        click: function () {
                            window.location = '{{ route('course_management::fiscal-year') }}';
                        }
                    }
                },
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'timeGridDay,timeGridWeek,dayGridMonth,myCustomButton'
                },
                locale: initialLocaleCode,
                events: function (fetchInfo, successCallback, failureCallback) {
                    $.ajax({
                        url: '{{route('course_management::yearly-training-calendar.all-event')}}',
                        type: "POST",
                    }).done(function (response) {
                        successCallback(response);
                        $('.fc-event-title').attr('title', 'কোর্সের বিস্তারিত দেখুন');
                    }).fail(function (xhr) {
                        failureCallback([]);
                    });
                },
                eventClick: function (calEvent, jsEvent, view) {
                    const {publish_course_id} = calEvent.event.extendedProps;
                    courseDetailsModalOpen(publish_course_id);
                },

            });
            calendar.render();

        });


    </script>
@endpush
