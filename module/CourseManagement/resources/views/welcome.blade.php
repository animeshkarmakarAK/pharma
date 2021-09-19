@php
    $currentInstitute = domainConfig('institute');
    $layout = $currentInstitute ? 'master::layouts.custom1' : 'master::layouts.front-end';
@endphp
@extends($layout)

@section('content')
    <section class="container-fluid slider-area position-relative">
        <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
            <div class="carousel-inner" role="listbox" style="overflow: visible">
                <div class="carousel-item active">
                    <div class='container'>
                        <div class='row pos-rel'>
                            <div class='col-sm-12 col-md-5 slider-left-content'>
                                <h1 class=''>সমাজসেবা অধিদপ্তর সমাজসেবা সমাজসেবা</h1>
                                <p>
                                    সমাজসেবা অধিদপ্তর-গণপ্রজাতন্ত্রী বাংলাদেশ সরকার
                                    সমাজসেবা অধিদপ্তর-গণপ্রজাতন্ত্রী বাংলাদেশ সরকার
                                    সমাজসেবা অধিদপ্তর-গণপ্রজাতন্ত্রী বাংলাদেশ সরকার
                                </p>
                                <a href='#' target="_blank">
                                    বিস্তারিত &nbsp;
                                    <i class="fas fa-arrow-right"></i>
                                </a>
                            </div>
                            <div class='col-md-7 animate pos-sta hidden-xs hidden-sm slider-right-content'>

                            </div>
                        </div>
                    </div>
                </div>

                <div class="carousel-item">

                    <div class='container s-fix'>
                        <div class='row pos-rel'>
                            <div class='col-sm-12 col-md-5 animate slider-left-content'>
                                <h1 class='big fadeInDownBig animated'>সমাজসেবা অধিদপ্তর সমাজসেবা অধিদপ্তর</h1>
                                <p class='normal fadeInUpBig animated delay-point-five-s'>
                                    সমাজসেবা অধিদপ্তর-গণপ্রজাতন্ত্রী বাংলাদেশ সরকার সরকারসরকারসরকার
                                    সমাজসেবা অধিদপ্তর-গণপ্রজাতন্ত্রী বাংলাদেশ সরকার সরকারসরকারসরকার
                                </p>
                                <a href='#' target="_blank">
                                    বিস্তারিত &nbsp;
                                    <i class="fas fa-arrow-right"></i>
                                </a>
                            </div>
                            <div class='col-md-7 animate pos-sta hidden-xs hidden-sm slider-right-content'>

                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <a class="carousel-control-prev slider-previous-link" href="#carouselExampleIndicators" role="button"
               data-slide="prev">
                <!--<span class="carousel-control-prev-icon sliders-previous-icon" aria-hidden="true"></span>-->
                <span class="slider-previous-icon" aria-hidden="true">
                    <i class="fas fa-chevron-left"></i>
                </span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next slider-next-link" href="#carouselExampleIndicators" role="button"
               data-slide="next">
                <!--<span class="carousel-control-next-icon sliders-next-icon" aria-hidden="true"></span>-->
                <span class="slider-next-icon" aria-hidden="true">
                    <i class="fas fa-chevron-right"></i>
                </span>
                <span class="sr-only">Next</span>
            </a>

            <div class="player-icon">
                <i class="fas fa-play-circle"></i>
            </div>
        </div>
    </section>

    <section class="bg-white at-glance-section">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="section-heading">একনজরে</h2>
                    <p class="text-center">প্রশিক্ষণ ব্যবস্থাপনা সিস্টেমের পরিসংখ্যান</p>
                    <div class="template-space"></div>
                </div>
                <div class="company-stats col-md-12">
                    <div class="row">
                        <div class="col-md-2 "></div>
                        <div class="col-md-2 mr-3">
                            <div class="instant-view-box">
                                <i class="fas fa-user-friends fa-3x p-3 custom-icon"></i>
                                <h1>10</h1>
                                <p class="p-3">প্রশিক্ষণ প্রদান</p>
                            </div>
                        </div>
                        <div class="col-md-2 mr-3">
                            <div class="instant-view-box">
                                <i class="fas fa-graduation-cap fa-flip-horizontal fa-3x p-3 custom-icon"></i>
                                <h1>10</h1>
                                <p class="p-3">প্রশিক্ষণ গ্রহণ</p>
                            </div>
                        </div>
                        <div class="col-md-2 mr-3">
                            <div class="instant-view-box">
                                <i class="fas fa-hotel fa-3x p-3 custom-icon"></i>
                                <h1>10</h1>
                                <p class="p-3">প্রশিক্ষণ কেন্দ্র</p>
                            </div>
                        </div>
                        <div class="col-md-2 mr-3">
                            <div class="instant-view-box">
                                <i class="fas fa-user-tie fa-3x p-3 custom-icon"></i>
                                <h1>10</h1>
                                <p class="p-3">প্রশিক্ষক</p>
                            </div>
                        </div>
                        <div class="col-md-2 "></div>

                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="about-us-section about-section-color position-relative">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <!--Services Heading-->
                    <h2 class="section-heading-h2 pb-3 font-weight-bold"> আমাদের সম্পর্কে </h2>
                    {{--                    <div class="template-space"></div>--}}
                </div>
                <div class="col-md-7">
                    <p>গণপ্রজাতন্ত্রী বাংলাদেশ সরকারের রূপকল্প ২০২১ বাস্তবায়নে যুবকদের আত্নকর্মসংস্থান ও স্বাবলম্বী করে
                        তোলার লক্ষ্যে "অনলাইনে বিভিন্ন প্রশিক্ষণ কোর্সের পরিচালনা ও পর্যবেক্ষণ করা"।
                        এই ওয়েব অ্যাপ্লিকেশনটি মূলত "অনলাইন কোর্স ম্যানেজমেন্ট সিস্টেম"।
                        এই প্ল্যাটফর্মে শিক্ষার্থী অতি সহজে বিভিন্ন প্রশিক্ষণ কোর্সে প্রশিক্ষণ নিয়ে স্বাবলম্বী হতে
                        পাড়বে। শিক্ষার্থী
                        তার নিজ পছন্দের বিষয়ে প্রশিক্ষণের জন্য এডমিনে কাছে অনুরোধ/আবেদন করতে পাড়বে। প্রশিক্ষণ শেষে
                        শিক্ষার্থীকে সার্টিফিকেট প্রদান করা হবে। </p>
                    <h2 class="para-heading font-weight-light">পোর্টালের লক্ষ্য/উদ্দেশ্য সমূহঃ</h2>

                    <ul class="sidebar-list">
                        <li><i class="font-weight-bold lists">*</i> এই প্ল্যাটফর্মে শিক্ষার্থী বিভিন্ন প্রশিক্ষণ কোর্সের
                            জন্য আবেদন করতে পারবে।
                        </li>
                        <li><i class="font-weight-bold lists">*</i> বিভিন্ন ক্যাটাগরিতে অনেক গুলো কোর্স একসাথে পরিচালনা
                            ও
                            পর্যবেক্ষণ করা সম্ভব।
                        </li>
                        <li><i class="font-weight-bold lists">*</i> সঠিক পদ্ধতিতে শিক্ষার্থীর দক্ষতা যাচাই করা এবং
                            বৃদ্ধি
                            করা হয় ।
                        </li>
                    </ul>
                </div>

                <div class="col-md-5 img-div">
                    <div class="image-div-2">
                        <img class="cr-img"
                             src="https://www.onpointcomputerrepairs.com.au/wp-content/uploads/2020/04/1-1-1.jpg"
                             alt="icon">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="banner-section">
        <div class="container banner">
            <div class="row">
                <div class="col-sm-4">
                    <div class="banner-bar banner-bar-color-1">
                        <i class="fas fa-chalkboard-teacher icons"></i>
                        <h3><span>অভিজ্ঞ প্রশিক্ষক</span></h3>
                        <p class="font-weight-light">অভিজ্ঞ প্রশিক্ষক দ্বারা কোর্স পরিচালনা ও পর্যবেক্ষণ করা হয়।</p>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="banner-bar banner-bar-color-2">
                        <i class="fas fa-graduation-cap icons"></i>
                        <h3><span>দক্ষতা বৃদ্ধি</span></h3>
                        <p class="font-weight-light">সঠিক পদ্ধতিতে শিক্ষার্থীদের দক্ষতা যাচাই করা এবং বৃদ্ধি করা
                            হয়।</p>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="banner-bar banner-bar-color-3">
                        <i class="fas fa-briefcase icons"></i>
                        <h3><span>কাজের নিশ্চয়তা</span></h3>
                        <p class="font-weight-light">বেকার যুবকদের স্বাবলম্বী করার পাশাপাশি দেশের উন্নয়নকে ত্বরান্বিত
                            করার লক্ষ্যে কাজ করেছে।</p>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <section class="container-fluid slider-area course-section">
        <div class="container my-4">
            <div class="row">
                <div class="col-md-12 mb-3">
                    <h3 class="course-section-heading default-heading-color mb-3">কোর্স সমূহ</h3>
                    <p>মোটিভেশনাল ওয়ার্কশপ অনুষ্ঠান হতে নিম্ন বিষয়ক প্রশিক্ষণ প্রদান করা হয়</p>
                </div>
            </div>
            <!--Carousel Wrapper-->
            <div id="multi-item-example" class="carousel slide carousel-multi-item" data-ride="carousel">

                <!--Controls-->
                <div class="controls-top">
                    <a class="btn-floating left-btn-arrow" href="#multi-item-example" data-slide="prev"><i
                            class="fas fa-chevron-left"></i></a>
                    <a class="btn-floating right-btn-arrow" href="#multi-item-example" data-slide="next"><i
                            class="fas fa-chevron-right"></i></a>
                </div>
                <!--/.Controls-->

                <!--Indicators-->
                <ol class="carousel-indicators">
                    <li data-target="#multi-item-example" data-slide-to="0" class="active"></li>
                    <li data-target="#multi-item-example" data-slide-to="1"></li>

                </ol>
                <!--/.Indicators-->

                <!--Slides-->
                <div class="carousel-inner" role="listbox">

                    <!--First slide-->
                    <div class="carousel-item active">
                        <div class="row">
                            <div class="col-md-2 mx-auto">
                                <div class="card card-main mb-2">
                                    <div class="card-bar">
                                        <i class="fas fa-headset card-icons"></i>
                                        <h3 class="card-h1"><span>কাস্টমার সাপোর্ট</span></h3>
                                        <p class="font-weight-light card-p">৩০ কোর্স</p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-2 mx-auto" >
                                <div class="card card-main mb-2">
                                    <div class="card-bar">
                                        <i class="fas fa-paint-brush card-icons"></i>
                                        <h3 class="card-h1"><span>গ্রাফিক্স ডিজাইন</span></h3>
                                        <p class="font-weight-light card-p">৩০ কোর্স</p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-2 mx-auto" >
                                <div class="card card-main mb-2">
                                    <div class="card-bar">
                                        <i class="fas fa-film card-icons"></i>
                                        <h3 class="card-h1"><span>ভিডিও এডিটিং</span></h3>
                                        <p class="font-weight-light card-p">৩০ কোর্স</p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-2 mx-auto" >
                                <div class="card card-main mb-2">
                                    <div class="card-bar">
                                        <i class="fas fa-film card-icons"></i>
                                        <h3 class="card-h1"><span>ভিডিও এডিটিং</span></h3>
                                        <p class="font-weight-light card-p">৩০ কোর্স</p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-2 mx-auto">
                                <div class="card card-main mb-2">
                                    <div class="card-bar">
                                        <i class="fas fa-palette card-icons"></i>
                                        <h3 class="card-h1"><span>আর্ট</span></h3>
                                        <p class="font-weight-light card-p">৩০ কোর্স</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--/.First slide-->

                    <!--Second slide-->
                    <div class="carousel-item">

                        <div class="row">
                            <div class="col-md-2 mx-auto">
                                <div class="card card-main mb-2">
                                    <div class="card-bar">
                                        <i class="fas fa-headset card-icons"></i>
                                        <h3 class="card-h1"><span>কাস্টমার সাপোর্ট</span></h3>
                                        <p class="font-weight-light card-p">৩০ কোর্স</p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-2 mx-auto" >
                                <div class="card card-main mb-2">
                                    <div class="card-bar">
                                        <i class="fas fa-paint-brush card-icons"></i>
                                        <h3 class="card-h1"><span>গ্রাফিক্স ডিজাইন</span></h3>
                                        <p class="font-weight-light card-p">৩০ কোর্স</p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-2 mx-auto" >
                                <div class="card card-main mb-2">
                                    <div class="card-bar">
                                        <i class="fas fa-film card-icons"></i>
                                        <h3 class="card-h1"><span>ভিডিও এডিটিং</span></h3>
                                        <p class="font-weight-light card-p">৩০ কোর্স</p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-2 mx-auto" >
                                <div class="card card-main mb-2">
                                    <div class="card-bar">
                                        <i class="fas fa-film card-icons"></i>
                                        <h3 class="card-h1"><span>ভিডিও এডিটিং</span></h3>
                                        <p class="font-weight-light card-p">৩০ কোর্স</p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-2 mx-auto">
                                <div class="card card-main mb-2">
                                    <div class="card-bar">
                                        <i class="fas fa-palette card-icons"></i>
                                        <h3 class="card-h1"><span>আর্ট</span></h3>
                                        <p class="font-weight-light card-p">৩০ কোর্স</p>
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
            <div class="col-md-12 text-center margin-10">
                <a href="#" target="_blank" class="more-course-button">আরও দেখুন <i
                        class="fas fa-arrow-right btn-arrow"></i></a>
            </div>

            <div class="col-md-12  course-div">
                <div class="accordion" id="accordionExample">
                    <div class="pb-5">
                        <a class="course-btn-dem mr-3 active" type="button" data-toggle="collapse"
                           data-target="#popular-course"
                           aria-expanded="true" aria-controls="popular-course">
                            জনপ্রিয় কোর্স
                        </a>
                        <a class="course-btn mr-3 collapsed" type="button" data-toggle="collapse"
                           data-target="#last-course" aria-expanded="false" aria-controls="last-course">
                            সর্বশেষ কোর্স
                        </a>
                        <a class="course-btn mr-3 collapsed" type="button" data-toggle="collapse"
                           data-target="#continue-course" aria-expanded="false" aria-controls="continue-course">
                            চলমান কোর্স
                        </a>
                        <a class="course-btn mr-3 collapsed" type="button" data-toggle="collapse"
                           data-target="#ended-course" aria-expanded="false" aria-controls="ended-course">
                            সমাপ্ত কোর্স
                        </a>
                        <a class="course-btn mr-3 collapsed" type="button" data-toggle="collapse"
                           data-target="#upcoming-gallery" aria-expanded="false" aria-controls="upcoming-gallery">
                            আসন্ন কোর্স
                        </a>
                    </div>

                    <div class="">
                        {{--popular-course--}}
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
                                                <div class="card-bar">
                                                    <div class="pb-3">
                                                        <img class="slider-img"
                                                             src="https://groupbuyseotools.org/wp-content/uploads/2017/12/videoblock.jpg"
                                                             alt="icon">
                                                    </div>
                                                    <div class="text-left">
                                                        <p class="card-p1">বিনামূল্য</p>
                                                        <p class="font-weight-bold">কোভিড-১৯ ও ডায়াবেটিস বিষয়ক অনলাইন
                                                            কোর্স</p>
                                                        <p class="font-weight-light"><i class="fas fa-clock"></i> ১
                                                            ঘন্টায় ৩০ মিনিট</p>
                                                        <p class="font-weight-light"><i class="fas fa-user-plus"></i>
                                                            Student(16.1k)</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-3" style="float:left">
                                            <div class="card card-main mb-2">
                                                <div class="card-bar">
                                                    <div class="pb-3">
                                                        <img class="slider-img"
                                                             src="https://groupbuyseotools.org/wp-content/uploads/2017/12/videoblock.jpg"
                                                             alt="icon">
                                                    </div>
                                                    <div class="text-left">
                                                        <p class="card-p1">বিনামূল্য</p>
                                                        <p class="font-weight-bold">কোভিড-১৯ ও ডায়াবেটিস বিষয়ক অনলাইন
                                                            কোর্স</p>
                                                        <p class="font-weight-light"><i class="fas fa-clock"></i> ১
                                                            ঘন্টায় ৩০ মিনিট</p>
                                                        <p class="font-weight-light"><i class="fas fa-user-plus"></i>
                                                            Student(16.1k)</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-3" style="float:left">
                                            <div class="card card-main mb-2">
                                                <div class="card-bar">
                                                    <div class="pb-3">
                                                        <img class="slider-img"
                                                             src="https://groupbuyseotools.org/wp-content/uploads/2017/12/videoblock.jpg"
                                                             alt="icon">
                                                    </div>
                                                    <div class="text-left">
                                                        <p class="card-p1">বিনামূল্য</p>
                                                        <p class="font-weight-bold">কোভিড-১৯ ও ডায়াবেটিস বিষয়ক অনলাইন
                                                            কোর্স</p>
                                                        <p class="font-weight-light"><i class="fas fa-clock"></i> ১
                                                            ঘন্টায় ৩০ মিনিট</p>
                                                        <p class="font-weight-light"><i class="fas fa-user-plus"></i>
                                                            Student(16.1k)</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-3" style="float:left">
                                            <div class="card card-main mb-2">
                                                <div class="card-bar">
                                                    <div class="pb-3">
                                                        <img class="slider-img"
                                                             src="https://groupbuyseotools.org/wp-content/uploads/2017/12/videoblock.jpg"
                                                             alt="icon">
                                                    </div>
                                                    <div class="text-left">
                                                        <p class="card-p1">বিনামূল্য</p>
                                                        <p class="font-weight-bold">কোভিড-১৯ ও ডায়াবেটিস বিষয়ক অনলাইন
                                                            কোর্স</p>
                                                        <p class="font-weight-light"><i class="fas fa-clock"></i> ১
                                                            ঘন্টায় ৩০ মিনিট</p>
                                                        <p class="font-weight-light"><i class="fas fa-user-plus"></i>
                                                            Student(16.1k)</p>
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
                                                <div class="card-bar">
                                                    <div class="pb-3">
                                                        <img class="slider-img"
                                                             src="https://groupbuyseotools.org/wp-content/uploads/2017/12/videoblock.jpg"
                                                             alt="icon">
                                                    </div>
                                                    <div class="text-left">
                                                        <p class="card-p1">বিনামূল্য</p>
                                                        <p class="font-weight-bold">কোভিড-১৯ ও ডায়াবেটিস বিষয়ক অনলাইন
                                                            কোর্স</p>
                                                        <p class="font-weight-light"><i class="fas fa-clock"></i> ১
                                                            ঘন্টায় ৩০ মিনিট</p>
                                                        <p class="font-weight-light"><i class="fas fa-user-plus"></i>
                                                            Student(16.1k)</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-3" style="float:left">
                                            <div class="card card-main mb-2">
                                                <div class="card-bar">
                                                    <div class="pb-3">
                                                        <img class="slider-img"
                                                             src="https://groupbuyseotools.org/wp-content/uploads/2017/12/videoblock.jpg"
                                                             alt="icon">
                                                    </div>
                                                    <div class="text-left">
                                                        <p class="card-p1">বিনামূল্য</p>
                                                        <p class="font-weight-bold">কোভিড-১৯ ও ডায়াবেটিস বিষয়ক অনলাইন
                                                            কোর্স</p>
                                                        <p class="font-weight-light"><i class="fas fa-clock"></i> ১
                                                            ঘন্টায় ৩০ মিনিট</p>
                                                        <p class="font-weight-light"><i class="fas fa-user-plus"></i>
                                                            Student(16.1k)</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-3" style="float:left">
                                            <div class="card card-main mb-2">
                                                <div class="card-bar">
                                                    <div class="pb-3">
                                                        <img class="slider-img"
                                                             src="https://groupbuyseotools.org/wp-content/uploads/2017/12/videoblock.jpg"
                                                             alt="icon">
                                                    </div>
                                                    <div class="text-left">
                                                        <p class="card-p1">বিনামূল্য</p>
                                                        <p class="font-weight-bold">কোভিড-১৯ ও ডায়াবেটিস বিষয়ক অনলাইন
                                                            কোর্স</p>
                                                        <p class="font-weight-light"><i class="fas fa-clock"></i> ১
                                                            ঘন্টায় ৩০ মিনিট</p>
                                                        <p class="font-weight-light"><i class="fas fa-user-plus"></i>
                                                            Student(16.1k)</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-3" style="float:left">
                                            <div class="card card-main mb-2">
                                                <div class="card-bar">
                                                    <div class="pb-3">
                                                        <img class="slider-img"
                                                             src="https://groupbuyseotools.org/wp-content/uploads/2017/12/videoblock.jpg"
                                                             alt="icon">
                                                    </div>
                                                    <div class="text-left">
                                                        <p class="card-p1">বিনামূল্য</p>
                                                        <p class="font-weight-bold">কোভিড-১৯ ও ডায়াবেটিস বিষয়ক অনলাইন
                                                            কোর্স</p>
                                                        <p class="font-weight-light"><i class="fas fa-clock"></i> ১
                                                            ঘন্টায় ৩০ মিনিট</p>
                                                        <p class="font-weight-light"><i class="fas fa-user-plus"></i>
                                                            Student(16.1k)</p>
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

                            <div class="col-md-12 text-center margin-10">
                                <a href="#" target="_blank" class="more-course-button">আরও দেখুন <i
                                        class="fas fa-arrow-right btn-arrow"></i></a>
                            </div>

                        </div>

                        {{--last-course--}}
                        <div id="last-course" class="collapse" aria-labelledby="last-course"
                             data-parent="#accordionExample">
                            <!--Carousel Wrapper-->
                            <div id="last-cou-arrow" class="carousel slide carousel-multi-item"
                                 data-ride="carousel">

                                <!--Controls-->
                                <div class="controls-top">
                                    <a class="btn-floating left-btn-arrow" href="#last-cou-arrow"
                                       data-slide="prev"><i
                                            class="fas fa-chevron-left"></i></a>
                                    <a class="btn-floating right-btn-arrow" href="#last-cou-arrow"
                                       data-slide="next"><i
                                            class="fas fa-chevron-right"></i></a>
                                </div>
                                <!--/.Controls-->

                                <!--Indicators-->
                                <ol class="carousel-indicators">
                                    <li data-target="#last-cou-arrow" data-slide-to="0" class="active"></li>
                                    <li data-target="#last-cou-arrow" data-slide-to="1"></li>

                                </ol>
                                <!--/.Indicators-->

                                <!--Slides-->
                                <div class="carousel-inner" role="listbox">

                                    <!--First slide-->
                                    <div class="carousel-item active">
                                        <div class="col-md-3" style="float:left">
                                            <div class="card card-main mb-2">
                                                <div class="card-bar">
                                                    <div class="pb-3">
                                                        <img class="slider-img"
                                                             src="https://groupbuyseotools.org/wp-content/uploads/2017/12/videoblock.jpg"
                                                             alt="icon">
                                                    </div>
                                                    <div class="text-left">
                                                        <p class="card-p1">বিনামূল্য</p>
                                                        <p class="font-weight-bold">কোভিড-১৯ ও ডায়াবেটিস বিষয়ক অনলাইন
                                                            কোর্স</p>
                                                        <p class="font-weight-light"><i class="fas fa-clock"></i> ১
                                                            ঘন্টায় ৩০ মিনিট</p>
                                                        <p class="font-weight-light"><i class="fas fa-user-plus"></i>
                                                            Student(16.1k)</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-3" style="float:left">
                                            <div class="card card-main mb-2">
                                                <div class="card-bar">
                                                    <div class="pb-3">
                                                        <img class="slider-img"
                                                             src="https://groupbuyseotools.org/wp-content/uploads/2017/12/videoblock.jpg"
                                                             alt="icon">
                                                    </div>
                                                    <div class="text-left">
                                                        <p class="card-p1">বিনামূল্য</p>
                                                        <p class="font-weight-bold">কোভিড-১৯ ও ডায়াবেটিস বিষয়ক অনলাইন
                                                            কোর্স</p>
                                                        <p class="font-weight-light"><i class="fas fa-clock"></i> ১
                                                            ঘন্টায় ৩০ মিনিট</p>
                                                        <p class="font-weight-light"><i class="fas fa-user-plus"></i>
                                                            Student(16.1k)</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-3" style="float:left">
                                            <div class="card card-main mb-2">
                                                <div class="card-bar">
                                                    <div class="pb-3">
                                                        <img class="slider-img"
                                                             src="https://groupbuyseotools.org/wp-content/uploads/2017/12/videoblock.jpg"
                                                             alt="icon">
                                                    </div>
                                                    <div class="text-left">
                                                        <p class="card-p1">বিনামূল্য</p>
                                                        <p class="font-weight-bold">কোভিড-১৯ ও ডায়াবেটিস বিষয়ক অনলাইন
                                                            কোর্স</p>
                                                        <p class="font-weight-light"><i class="fas fa-clock"></i> ১
                                                            ঘন্টায় ৩০ মিনিট</p>
                                                        <p class="font-weight-light"><i class="fas fa-user-plus"></i>
                                                            Student(16.1k)</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-3" style="float:left">
                                            <div class="card card-main mb-2">
                                                <div class="card-bar">
                                                    <div class="pb-3">
                                                        <img class="slider-img"
                                                             src="https://groupbuyseotools.org/wp-content/uploads/2017/12/videoblock.jpg"
                                                             alt="icon">
                                                    </div>
                                                    <div class="text-left">
                                                        <p class="card-p1">বিনামূল্য</p>
                                                        <p class="font-weight-bold">কোভিড-১৯ ও ডায়াবেটিস বিষয়ক অনলাইন
                                                            কোর্স</p>
                                                        <p class="font-weight-light"><i class="fas fa-clock"></i> ১
                                                            ঘন্টায় ৩০ মিনিট</p>
                                                        <p class="font-weight-light"><i class="fas fa-user-plus"></i>
                                                            Student(16.1k)</p>
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
                                                <div class="card-bar">
                                                    <div class="pb-3">
                                                        <img class="slider-img"
                                                             src="https://groupbuyseotools.org/wp-content/uploads/2017/12/videoblock.jpg"
                                                             alt="icon">
                                                    </div>
                                                    <div class="text-left">
                                                        <p class="card-p1">বিনামূল্য</p>
                                                        <p class="font-weight-bold">কোভিড-১৯ ও ডায়াবেটিস বিষয়ক অনলাইন
                                                            কোর্স</p>
                                                        <p class="font-weight-light"><i class="fas fa-clock"></i> ১
                                                            ঘন্টায় ৩০ মিনিট</p>
                                                        <p class="font-weight-light"><i class="fas fa-user-plus"></i>
                                                            Student(16.1k)</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-3" style="float:left">
                                            <div class="card card-main mb-2">
                                                <div class="card-bar">
                                                    <div class="pb-3">
                                                        <img class="slider-img"
                                                             src="https://groupbuyseotools.org/wp-content/uploads/2017/12/videoblock.jpg"
                                                             alt="icon">
                                                    </div>
                                                    <div class="text-left">
                                                        <p class="card-p1">বিনামূল্য</p>
                                                        <p class="font-weight-bold">কোভিড-১৯ ও ডায়াবেটিস বিষয়ক অনলাইন
                                                            কোর্স</p>
                                                        <p class="font-weight-light"><i class="fas fa-clock"></i> ১
                                                            ঘন্টায় ৩০ মিনিট</p>
                                                        <p class="font-weight-light"><i class="fas fa-user-plus"></i>
                                                            Student(16.1k)</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-3" style="float:left">
                                            <div class="card card-main mb-2">
                                                <div class="card-bar">
                                                    <div class="pb-3">
                                                        <img class="slider-img"
                                                             src="https://groupbuyseotools.org/wp-content/uploads/2017/12/videoblock.jpg"
                                                             alt="icon">
                                                    </div>
                                                    <div class="text-left">
                                                        <p class="card-p1">বিনামূল্য</p>
                                                        <p class="font-weight-bold">কোভিড-১৯ ও ডায়াবেটিস বিষয়ক অনলাইন
                                                            কোর্স</p>
                                                        <p class="font-weight-light"><i class="fas fa-clock"></i> ১
                                                            ঘন্টায় ৩০ মিনিট</p>
                                                        <p class="font-weight-light"><i class="fas fa-user-plus"></i>
                                                            Student(16.1k)</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-3" style="float:left">
                                            <div class="card card-main mb-2">
                                                <div class="card-bar">
                                                    <div class="pb-3">
                                                        <img class="slider-img"
                                                             src="https://groupbuyseotools.org/wp-content/uploads/2017/12/videoblock.jpg"
                                                             alt="icon">
                                                    </div>
                                                    <div class="text-left">
                                                        <p class="card-p1">বিনামূল্য</p>
                                                        <p class="font-weight-bold">কোভিড-১৯ ও ডায়াবেটিস বিষয়ক অনলাইন
                                                            কোর্স</p>
                                                        <p class="font-weight-light"><i class="fas fa-clock"></i> ১
                                                            ঘন্টায় ৩০ মিনিট</p>
                                                        <p class="font-weight-light"><i class="fas fa-user-plus"></i>
                                                            Student(16.1k)</p>
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

                            <div class="col-md-12 text-center margin-10">
                                <a href="#" target="_blank" class="more-course-button">আরও দেখুন <i
                                        class="fas fa-arrow-right btn-arrow"></i></a>
                            </div>
                        </div>

                        {{---continue course--}}
                        <div id="continue-course" class="collapse" aria-labelledby="continue-course"
                             data-parent="#accordionExample">
                            <!--Carousel Wrapper-->
                            <div id="continue-cou-arrow" class="carousel slide carousel-multi-item"
                                 data-ride="carousel">

                                <!--Controls-->
                                <div class="controls-top">
                                    <a class="btn-floating left-btn-arrow" href="#continue-cou-arrow"
                                       data-slide="prev"><i
                                            class="fas fa-chevron-left"></i></a>
                                    <a class="btn-floating right-btn-arrow" href="#continue-cou-arrow"
                                       data-slide="next"><i
                                            class="fas fa-chevron-right"></i></a>
                                </div>
                                <!--/.Controls-->

                                <!--Indicators-->
                                <ol class="carousel-indicators">
                                    <li data-target="#continue-cou-arrow" data-slide-to="0" class="active"></li>
                                    <li data-target="#continue-cou-arrow" data-slide-to="1"></li>

                                </ol>
                                <!--/.Indicators-->

                                <!--Slides-->
                                <div class="carousel-inner" role="listbox">

                                    <!--First slide-->
                                    <div class="carousel-item active">
                                        <div class="col-md-3" style="float:left">
                                            <div class="card card-main mb-2">
                                                <div class="card-bar">
                                                    <div class="pb-3">
                                                        <img class="slider-img"
                                                             src="https://groupbuyseotools.org/wp-content/uploads/2017/12/videoblock.jpg"
                                                             alt="icon">
                                                    </div>
                                                    <div class="text-left">
                                                        <p class="card-p1">বিনামূল্য</p>
                                                        <p class="font-weight-bold">কোভিড-১৯ ও ডায়াবেটিস বিষয়ক অনলাইন
                                                            কোর্স</p>
                                                        <p class="font-weight-light"><i class="fas fa-clock"></i> ১
                                                            ঘন্টায় ৩০ মিনিট</p>
                                                        <p class="font-weight-light"><i class="fas fa-user-plus"></i>
                                                            Student(16.1k)</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-3" style="float:left">
                                            <div class="card card-main mb-2">
                                                <div class="card-bar">
                                                    <div class="pb-3">
                                                        <img class="slider-img"
                                                             src="https://groupbuyseotools.org/wp-content/uploads/2017/12/videoblock.jpg"
                                                             alt="icon">
                                                    </div>
                                                    <div class="text-left">
                                                        <p class="card-p1">বিনামূল্য</p>
                                                        <p class="font-weight-bold">কোভিড-১৯ ও ডায়াবেটিস বিষয়ক অনলাইন
                                                            কোর্স</p>
                                                        <p class="font-weight-light"><i class="fas fa-clock"></i> ১
                                                            ঘন্টায় ৩০ মিনিট</p>
                                                        <p class="font-weight-light"><i class="fas fa-user-plus"></i>
                                                            Student(16.1k)</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-3" style="float:left">
                                            <div class="card card-main mb-2">
                                                <div class="card-bar">
                                                    <div class="pb-3">
                                                        <img class="slider-img"
                                                             src="https://groupbuyseotools.org/wp-content/uploads/2017/12/videoblock.jpg"
                                                             alt="icon">
                                                    </div>
                                                    <div class="text-left">
                                                        <p class="card-p1">বিনামূল্য</p>
                                                        <p class="font-weight-bold">কোভিড-১৯ ও ডায়াবেটিস বিষয়ক অনলাইন
                                                            কোর্স</p>
                                                        <p class="font-weight-light"><i class="fas fa-clock"></i> ১
                                                            ঘন্টায় ৩০ মিনিট</p>
                                                        <p class="font-weight-light"><i class="fas fa-user-plus"></i>
                                                            Student(16.1k)</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-3" style="float:left">
                                            <div class="card card-main mb-2">
                                                <div class="card-bar">
                                                    <div class="pb-3">
                                                        <img class="slider-img"
                                                             src="https://groupbuyseotools.org/wp-content/uploads/2017/12/videoblock.jpg"
                                                             alt="icon">
                                                    </div>
                                                    <div class="text-left">
                                                        <p class="card-p1">বিনামূল্য</p>
                                                        <p class="font-weight-bold">কোভিড-১৯ ও ডায়াবেটিস বিষয়ক অনলাইন
                                                            কোর্স</p>
                                                        <p class="font-weight-light"><i class="fas fa-clock"></i> ১
                                                            ঘন্টায় ৩০ মিনিট</p>
                                                        <p class="font-weight-light"><i class="fas fa-user-plus"></i>
                                                            Student(16.1k)</p>
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
                                                <div class="card-bar">
                                                    <div class="pb-3">
                                                        <img class="slider-img"
                                                             src="https://groupbuyseotools.org/wp-content/uploads/2017/12/videoblock.jpg"
                                                             alt="icon">
                                                    </div>
                                                    <div class="text-left">
                                                        <p class="card-p1">বিনামূল্য</p>
                                                        <p class="font-weight-bold">কোভিড-১৯ ও ডায়াবেটিস বিষয়ক অনলাইন
                                                            কোর্স</p>
                                                        <p class="font-weight-light"><i class="fas fa-clock"></i> ১
                                                            ঘন্টায় ৩০ মিনিট</p>
                                                        <p class="font-weight-light"><i class="fas fa-user-plus"></i>
                                                            Student(16.1k)</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-3" style="float:left">
                                            <div class="card card-main mb-2">
                                                <div class="card-bar">
                                                    <div class="pb-3">
                                                        <img class="slider-img"
                                                             src="https://groupbuyseotools.org/wp-content/uploads/2017/12/videoblock.jpg"
                                                             alt="icon">
                                                    </div>
                                                    <div class="text-left">
                                                        <p class="card-p1">বিনামূল্য</p>
                                                        <p class="font-weight-bold">কোভিড-১৯ ও ডায়াবেটিস বিষয়ক অনলাইন
                                                            কোর্স</p>
                                                        <p class="font-weight-light"><i class="fas fa-clock"></i> ১
                                                            ঘন্টায় ৩০ মিনিট</p>
                                                        <p class="font-weight-light"><i class="fas fa-user-plus"></i>
                                                            Student(16.1k)</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-3" style="float:left">
                                            <div class="card card-main mb-2">
                                                <div class="card-bar">
                                                    <div class="pb-3">
                                                        <img class="slider-img"
                                                             src="https://groupbuyseotools.org/wp-content/uploads/2017/12/videoblock.jpg"
                                                             alt="icon">
                                                    </div>
                                                    <div class="text-left">
                                                        <p class="card-p1">বিনামূল্য</p>
                                                        <p class="font-weight-bold">কোভিড-১৯ ও ডায়াবেটিস বিষয়ক অনলাইন
                                                            কোর্স</p>
                                                        <p class="font-weight-light"><i class="fas fa-clock"></i> ১
                                                            ঘন্টায় ৩০ মিনিট</p>
                                                        <p class="font-weight-light"><i class="fas fa-user-plus"></i>
                                                            Student(16.1k)</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-3" style="float:left">
                                            <div class="card card-main mb-2">
                                                <div class="card-bar">
                                                    <div class="pb-3">
                                                        <img class="slider-img"
                                                             src="https://groupbuyseotools.org/wp-content/uploads/2017/12/videoblock.jpg"
                                                             alt="icon">
                                                    </div>
                                                    <div class="text-left">
                                                        <p class="card-p1">বিনামূল্য</p>
                                                        <p class="font-weight-bold">কোভিড-১৯ ও ডায়াবেটিস বিষয়ক অনলাইন
                                                            কোর্স</p>
                                                        <p class="font-weight-light"><i class="fas fa-clock"></i> ১
                                                            ঘন্টায় ৩০ মিনিট</p>
                                                        <p class="font-weight-light"><i class="fas fa-user-plus"></i>
                                                            Student(16.1k)</p>
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

                            <div class="col-md-12 text-center margin-10">
                                <a href="#" target="_blank" class="more-course-button">আরও দেখুন <i
                                        class="fas fa-arrow-right btn-arrow"></i></a>
                            </div>
                        </div>

                        {{---continue course--}}
                        <div id="ended-course" class="collapse" aria-labelledby="ended-course"
                             data-parent="#accordionExample">
                            <!--Carousel Wrapper-->
                            <div id="ended-cou-arrow" class="carousel slide carousel-multi-item"
                                 data-ride="carousel">

                                <!--Controls-->
                                <div class="controls-top">
                                    <a class="btn-floating left-btn-arrow" href="#ended-cou-arrow"
                                       data-slide="prev"><i
                                            class="fas fa-chevron-left"></i></a>
                                    <a class="btn-floating right-btn-arrow" href="#ended-cou-arrow"
                                       data-slide="next"><i
                                            class="fas fa-chevron-right"></i></a>
                                </div>
                                <!--/.Controls-->

                                <!--Indicators-->
                                <ol class="carousel-indicators">
                                    <li data-target="#ended-cou-arrow" data-slide-to="0" class="active"></li>
                                    <li data-target="#ended-cou-arrow" data-slide-to="1"></li>

                                </ol>
                                <!--/.Indicators-->

                                <!--Slides-->
                                <div class="carousel-inner" role="listbox">

                                    <!--First slide-->
                                    <div class="carousel-item active">
                                        <div class="col-md-3" style="float:left">
                                            <div class="card card-main mb-2">
                                                <div class="card-bar">
                                                    <div class="pb-3">
                                                        <img class="slider-img"
                                                             src="https://groupbuyseotools.org/wp-content/uploads/2017/12/videoblock.jpg"
                                                             alt="icon">
                                                    </div>
                                                    <div class="text-left">
                                                        <p class="card-p1">বিনামূল্য</p>
                                                        <p class="font-weight-bold">কোভিড-১৯ ও ডায়াবেটিস বিষয়ক অনলাইন
                                                            কোর্স</p>
                                                        <p class="font-weight-light"><i class="fas fa-clock"></i> ১
                                                            ঘন্টায় ৩০ মিনিট</p>
                                                        <p class="font-weight-light"><i class="fas fa-user-plus"></i>
                                                            Student(16.1k)</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-3" style="float:left">
                                            <div class="card card-main mb-2">
                                                <div class="card-bar">
                                                    <div class="pb-3">
                                                        <img class="slider-img"
                                                             src="https://groupbuyseotools.org/wp-content/uploads/2017/12/videoblock.jpg"
                                                             alt="icon">
                                                    </div>
                                                    <div class="text-left">
                                                        <p class="card-p1">বিনামূল্য</p>
                                                        <p class="font-weight-bold">কোভিড-১৯ ও ডায়াবেটিস বিষয়ক অনলাইন
                                                            কোর্স</p>
                                                        <p class="font-weight-light"><i class="fas fa-clock"></i> ১
                                                            ঘন্টায় ৩০ মিনিট</p>
                                                        <p class="font-weight-light"><i class="fas fa-user-plus"></i>
                                                            Student(16.1k)</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-3" style="float:left">
                                            <div class="card card-main mb-2">
                                                <div class="card-bar">
                                                    <div class="pb-3">
                                                        <img class="slider-img"
                                                             src="https://groupbuyseotools.org/wp-content/uploads/2017/12/videoblock.jpg"
                                                             alt="icon">
                                                    </div>
                                                    <div class="text-left">
                                                        <p class="card-p1">বিনামূল্য</p>
                                                        <p class="font-weight-bold">কোভিড-১৯ ও ডায়াবেটিস বিষয়ক অনলাইন
                                                            কোর্স</p>
                                                        <p class="font-weight-light"><i class="fas fa-clock"></i> ১
                                                            ঘন্টায় ৩০ মিনিট</p>
                                                        <p class="font-weight-light"><i class="fas fa-user-plus"></i>
                                                            Student(16.1k)</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-3" style="float:left">
                                            <div class="card card-main mb-2">
                                                <div class="card-bar">
                                                    <div class="pb-3">
                                                        <img class="slider-img"
                                                             src="https://groupbuyseotools.org/wp-content/uploads/2017/12/videoblock.jpg"
                                                             alt="icon">
                                                    </div>
                                                    <div class="text-left">
                                                        <p class="card-p1">বিনামূল্য</p>
                                                        <p class="font-weight-bold">কোভিড-১৯ ও ডায়াবেটিস বিষয়ক অনলাইন
                                                            কোর্স</p>
                                                        <p class="font-weight-light"><i class="fas fa-clock"></i> ১
                                                            ঘন্টায় ৩০ মিনিট</p>
                                                        <p class="font-weight-light"><i class="fas fa-user-plus"></i>
                                                            Student(16.1k)</p>
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
                                                <div class="card-bar">
                                                    <div class="pb-3">
                                                        <img class="slider-img"
                                                             src="https://groupbuyseotools.org/wp-content/uploads/2017/12/videoblock.jpg"
                                                             alt="icon">
                                                    </div>
                                                    <div class="text-left">
                                                        <p class="card-p1">বিনামূল্য</p>
                                                        <p class="font-weight-bold">কোভিড-১৯ ও ডায়াবেটিস বিষয়ক অনলাইন
                                                            কোর্স</p>
                                                        <p class="font-weight-light"><i class="fas fa-clock"></i> ১
                                                            ঘন্টায় ৩০ মিনিট</p>
                                                        <p class="font-weight-light"><i class="fas fa-user-plus"></i>
                                                            Student(16.1k)</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-3" style="float:left">
                                            <div class="card card-main mb-2">
                                                <div class="card-bar">
                                                    <div class="pb-3">
                                                        <img class="slider-img"
                                                             src="https://groupbuyseotools.org/wp-content/uploads/2017/12/videoblock.jpg"
                                                             alt="icon">
                                                    </div>
                                                    <div class="text-left">
                                                        <p class="card-p1">বিনামূল্য</p>
                                                        <p class="font-weight-bold">কোভিড-১৯ ও ডায়াবেটিস বিষয়ক অনলাইন
                                                            কোর্স</p>
                                                        <p class="font-weight-light"><i class="fas fa-clock"></i> ১
                                                            ঘন্টায় ৩০ মিনিট</p>
                                                        <p class="font-weight-light"><i class="fas fa-user-plus"></i>
                                                            Student(16.1k)</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-3" style="float:left">
                                            <div class="card card-main mb-2">
                                                <div class="card-bar">
                                                    <div class="pb-3">
                                                        <img class="slider-img"
                                                             src="https://groupbuyseotools.org/wp-content/uploads/2017/12/videoblock.jpg"
                                                             alt="icon">
                                                    </div>
                                                    <div class="text-left">
                                                        <p class="card-p1">বিনামূল্য</p>
                                                        <p class="font-weight-bold">কোভিড-১৯ ও ডায়াবেটিস বিষয়ক অনলাইন
                                                            কোর্স</p>
                                                        <p class="font-weight-light"><i class="fas fa-clock"></i> ১
                                                            ঘন্টায় ৩০ মিনিট</p>
                                                        <p class="font-weight-light"><i class="fas fa-user-plus"></i>
                                                            Student(16.1k)</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-3" style="float:left">
                                            <div class="card card-main mb-2">
                                                <div class="card-bar">
                                                    <div class="pb-3">
                                                        <img class="slider-img"
                                                             src="https://groupbuyseotools.org/wp-content/uploads/2017/12/videoblock.jpg"
                                                             alt="icon">
                                                    </div>
                                                    <div class="text-left">
                                                        <p class="card-p1">বিনামূল্য</p>
                                                        <p class="font-weight-bold">কোভিড-১৯ ও ডায়াবেটিস বিষয়ক অনলাইন
                                                            কোর্স</p>
                                                        <p class="font-weight-light"><i class="fas fa-clock"></i> ১
                                                            ঘন্টায় ৩০ মিনিট</p>
                                                        <p class="font-weight-light"><i class="fas fa-user-plus"></i>
                                                            Student(16.1k)</p>
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

                            <div class="col-md-12 text-center margin-10">
                                <a href="#" target="_blank" class="more-course-button">আরও দেখুন <i
                                        class="fas fa-arrow-right btn-arrow"></i></a>
                            </div>
                        </div>

                        {{---continue course--}}
                        <div id="upcoming-course" class="collapse" aria-labelledby="upcoming-course"
                             data-parent="#accordionExample">
                            <!--Carousel Wrapper-->
                            <div id="upcoming-cou-arrow" class="carousel slide carousel-multi-item"
                                 data-ride="carousel">

                                <!--Controls-->
                                <div class="controls-top">
                                    <a class="btn-floating left-btn-arrow" href="#upcoming-cou-arrow"
                                       data-slide="prev"><i
                                            class="fas fa-chevron-left"></i></a>
                                    <a class="btn-floating right-btn-arrow" href="#upcoming-cou-arrow"
                                       data-slide="next"><i
                                            class="fas fa-chevron-right"></i></a>
                                </div>
                                <!--/.Controls-->

                                <!--Indicators-->
                                <ol class="carousel-indicators">
                                    <li data-target="#upcoming-cou-arrow" data-slide-to="0" class="active"></li>
                                    <li data-target="#upcoming-cou-arrow" data-slide-to="1"></li>

                                </ol>
                                <!--/.Indicators-->

                                <!--Slides-->
                                <div class="carousel-inner" role="listbox">

                                    <!--First slide-->
                                    <div class="carousel-item active">
                                        <div class="col-md-3" style="float:left">
                                            <div class="card card-main mb-2">
                                                <div class="card-bar">
                                                    <div class="pb-3">
                                                        <img class="slider-img"
                                                             src="https://groupbuyseotools.org/wp-content/uploads/2017/12/videoblock.jpg"
                                                             alt="icon">
                                                    </div>
                                                    <div class="text-left">
                                                        <p class="card-p1">বিনামূল্য</p>
                                                        <p class="font-weight-bold">কোভিড-১৯ ও ডায়াবেটিস বিষয়ক অনলাইন
                                                            কোর্স</p>
                                                        <p class="font-weight-light"><i class="fas fa-clock"></i> ১
                                                            ঘন্টায় ৩০ মিনিট</p>
                                                        <p class="font-weight-light"><i class="fas fa-user-plus"></i>
                                                            Student(16.1k)</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-3" style="float:left">
                                            <div class="card card-main mb-2">
                                                <div class="card-bar">
                                                    <div class="pb-3">
                                                        <img class="slider-img"
                                                             src="https://groupbuyseotools.org/wp-content/uploads/2017/12/videoblock.jpg"
                                                             alt="icon">
                                                    </div>
                                                    <div class="text-left">
                                                        <p class="card-p1">বিনামূল্য</p>
                                                        <p class="font-weight-bold">কোভিড-১৯ ও ডায়াবেটিস বিষয়ক অনলাইন
                                                            কোর্স</p>
                                                        <p class="font-weight-light"><i class="fas fa-clock"></i> ১
                                                            ঘন্টায় ৩০ মিনিট</p>
                                                        <p class="font-weight-light"><i class="fas fa-user-plus"></i>
                                                            Student(16.1k)</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-3" style="float:left">
                                            <div class="card card-main mb-2">
                                                <div class="card-bar">
                                                    <div class="pb-3">
                                                        <img class="slider-img"
                                                             src="https://groupbuyseotools.org/wp-content/uploads/2017/12/videoblock.jpg"
                                                             alt="icon">
                                                    </div>
                                                    <div class="text-left">
                                                        <p class="card-p1">বিনামূল্য</p>
                                                        <p class="font-weight-bold">কোভিড-১৯ ও ডায়াবেটিস বিষয়ক অনলাইন
                                                            কোর্স</p>
                                                        <p class="font-weight-light"><i class="fas fa-clock"></i> ১
                                                            ঘন্টায় ৩০ মিনিট</p>
                                                        <p class="font-weight-light"><i class="fas fa-user-plus"></i>
                                                            Student(16.1k)</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-3" style="float:left">
                                            <div class="card card-main mb-2">
                                                <div class="card-bar">
                                                    <div class="pb-3">
                                                        <img class="slider-img"
                                                             src="https://groupbuyseotools.org/wp-content/uploads/2017/12/videoblock.jpg"
                                                             alt="icon">
                                                    </div>
                                                    <div class="text-left">
                                                        <p class="card-p1">বিনামূল্য</p>
                                                        <p class="font-weight-bold">কোভিড-১৯ ও ডায়াবেটিস বিষয়ক অনলাইন
                                                            কোর্স</p>
                                                        <p class="font-weight-light"><i class="fas fa-clock"></i> ১
                                                            ঘন্টায় ৩০ মিনিট</p>
                                                        <p class="font-weight-light"><i class="fas fa-user-plus"></i>
                                                            Student(16.1k)</p>
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
                                                <div class="card-bar">
                                                    <div class="pb-3">
                                                        <img class="slider-img"
                                                             src="https://groupbuyseotools.org/wp-content/uploads/2017/12/videoblock.jpg"
                                                             alt="icon">
                                                    </div>
                                                    <div class="text-left">
                                                        <p class="card-p1">বিনামূল্য</p>
                                                        <p class="font-weight-bold">কোভিড-১৯ ও ডায়াবেটিস বিষয়ক অনলাইন
                                                            কোর্স</p>
                                                        <p class="font-weight-light"><i class="fas fa-clock"></i> ১
                                                            ঘন্টায় ৩০ মিনিট</p>
                                                        <p class="font-weight-light"><i class="fas fa-user-plus"></i>
                                                            Student(16.1k)</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-3" style="float:left">
                                            <div class="card card-main mb-2">
                                                <div class="card-bar">
                                                    <div class="pb-3">
                                                        <img class="slider-img"
                                                             src="https://groupbuyseotools.org/wp-content/uploads/2017/12/videoblock.jpg"
                                                             alt="icon">
                                                    </div>
                                                    <div class="text-left">
                                                        <p class="card-p1">বিনামূল্য</p>
                                                        <p class="font-weight-bold">কোভিড-১৯ ও ডায়াবেটিস বিষয়ক অনলাইন
                                                            কোর্স</p>
                                                        <p class="font-weight-light"><i class="fas fa-clock"></i> ১
                                                            ঘন্টায় ৩০ মিনিট</p>
                                                        <p class="font-weight-light"><i class="fas fa-user-plus"></i>
                                                            Student(16.1k)</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-3" style="float:left">
                                            <div class="card card-main mb-2">
                                                <div class="card-bar">
                                                    <div class="pb-3">
                                                        <img class="slider-img"
                                                             src="https://groupbuyseotools.org/wp-content/uploads/2017/12/videoblock.jpg"
                                                             alt="icon">
                                                    </div>
                                                    <div class="text-left">
                                                        <p class="card-p1">বিনামূল্য</p>
                                                        <p class="font-weight-bold">কোভিড-১৯ ও ডায়াবেটিস বিষয়ক অনলাইন
                                                            কোর্স</p>
                                                        <p class="font-weight-light"><i class="fas fa-clock"></i> ১
                                                            ঘন্টায় ৩০ মিনিট</p>
                                                        <p class="font-weight-light"><i class="fas fa-user-plus"></i>
                                                            Student(16.1k)</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-3" style="float:left">
                                            <div class="card card-main mb-2">
                                                <div class="card-bar">
                                                    <div class="pb-3">
                                                        <img class="slider-img"
                                                             src="https://groupbuyseotools.org/wp-content/uploads/2017/12/videoblock.jpg"
                                                             alt="icon">
                                                    </div>
                                                    <div class="text-left">
                                                        <p class="card-p1">বিনামূল্য</p>
                                                        <p class="font-weight-bold">কোভিড-১৯ ও ডায়াবেটিস বিষয়ক অনলাইন
                                                            কোর্স</p>
                                                        <p class="font-weight-light"><i class="fas fa-clock"></i> ১
                                                            ঘন্টায় ৩০ মিনিট</p>
                                                        <p class="font-weight-light"><i class="fas fa-user-plus"></i>
                                                            Student(16.1k)</p>
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

                            <div class="col-md-12 text-center margin-10">
                                <a href="#" target="_blank" class="more-course-button">আরও দেখুন <i
                                        class="fas fa-arrow-right btn-arrow"></i></a>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>

    </section>


    <section class="yearly-training-calendar bg-white">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="section-heading">প্রশিক্ষণ বাস্তবায়ন সময়সূচি</h2>
                </div>
                <div class="col-md-10 mx-auto rounded">
                    <div id='calendar'></div>
                </div>
            </div>
            <div class="row mt-5">
                <div class="col-md-12 mb-3">
                    <h3 class="gallery-section-heading default-heading-color mb-3">গ্যালারি</h3>
                    <p>বিটাক পরিচালিত কতিপয় কর্মসূচির ছবি</p>
                </div>

                <div class="col-md-12">
                    <div class="accordion" id="accordionExample">
                        <div class="pb-5">
                            <a class="custom-btn mr-3" type="button" data-toggle="collapse" data-target="#video-gallery"
                               aria-expanded="true" aria-controls="video-gallery">
                                ভিডিও গ্যালারি
                            </a>
                            <a class="custom-btn mr-3 collapsed" type="button" data-toggle="collapse"
                               data-target="#photo-gallery" aria-expanded="false" aria-controls="photo-gallery">
                                ছবি গ্যালারি
                            </a>
                        </div>

                        <div class="">
                            {{--video gallery--}}
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
                                                <div class="card card-main mb-2">
                                                    <img class="slider-img"
                                                         src="https://groupbuyseotools.org/wp-content/uploads/2017/12/videoblock.jpg"
                                                         alt="icon">
                                                </div>
                                            </div>

                                            <div class="col-md-3" style="float:left">
                                                <div class="card card-main mb-2">
                                                    <img class="slider-img"
                                                         src="https://groupbuyseotools.org/wp-content/uploads/2017/12/videoblock.jpg"
                                                         alt="icon">
                                                </div>
                                            </div>

                                            <div class="col-md-3" style="float:left">
                                                <div class="card card-main mb-2">
                                                    <img class="slider-img"
                                                         src="https://groupbuyseotools.org/wp-content/uploads/2017/12/videoblock.jpg"
                                                         alt="icon">
                                                </div>
                                            </div>

                                            <div class="col-md-3" style="float:left">
                                                <div class="card card-main mb-2">
                                                    <img class="slider-img"
                                                         src="https://groupbuyseotools.org/wp-content/uploads/2017/12/videoblock.jpg"
                                                         alt="icon">
                                                </div>
                                            </div>

                                        </div>
                                        <!--/.First slide-->

                                        <!--Second slide-->
                                        <div class="carousel-item">

                                            <div class="col-md-3" style="float:left">
                                                <div class="card card-main mb-2">
                                                    <img class="slider-img"
                                                         src="https://groupbuyseotools.org/wp-content/uploads/2017/12/videoblock.jpg"
                                                         alt="icon">
                                                </div>
                                            </div>

                                            <div class="col-md-3" style="float:left">
                                                <div class="card card-main mb-2">
                                                    <img class="slider-img"
                                                         src="https://groupbuyseotools.org/wp-content/uploads/2017/12/videoblock.jpg"
                                                         alt="icon">
                                                </div>
                                            </div>

                                            <div class="col-md-3" style="float:left">
                                                <div class="card card-main mb-2">
                                                    <img class="slider-img"
                                                         src="https://groupbuyseotools.org/wp-content/uploads/2017/12/videoblock.jpg"
                                                         alt="icon">
                                                </div>
                                            </div>

                                            <div class="col-md-3" style="float:left">
                                                <div class="card card-main mb-2">
                                                    <img class="slider-img"
                                                         src="https://groupbuyseotools.org/wp-content/uploads/2017/12/videoblock.jpg"
                                                         alt="icon">
                                                </div>
                                            </div>

                                        </div>
                                        <!--/.Second slide-->
                                    </div>
                                    <!--/.Slides-->
                                </div>
                                <!--/.Carousel Wrapper-->

                                <div class="col-md-12 text-center margin-10">
                                    <a href="#" target="_blank" class="more-course-button">আরও দেখুন <i
                                            class="fas fa-arrow-right btn-arrow"></i></a>
                                </div>

                            </div>

                            {{--image gallery--}}
                            <div id="photo-gallery" class="collapse" aria-labelledby="photo-gallery"
                                 data-parent="#accordionExample">
                                <!--Carousel Wrapper-->
                                <div id="multi-item-example-img" class="carousel slide carousel-multi-item"
                                     data-ride="carousel">

                                    <!--Controls-->
                                    <div class="controls-top">
                                        <a class="btn-floating left-btn-arrow" href="#multi-item-example-img"
                                           data-slide="prev"><i
                                                class="fas fa-chevron-left"></i></a>
                                        <a class="btn-floating right-btn-arrow" href="#multi-item-example-img"
                                           data-slide="next"><i
                                                class="fas fa-chevron-right"></i></a>
                                    </div>
                                    <!--/.Controls-->

                                    <!--Indicators-->
                                    <ol class="carousel-indicators">
                                        <li data-target="#multi-item-example-img" data-slide-to="0" class="active"></li>
                                        <li data-target="#multi-item-example-img" data-slide-to="1"></li>

                                    </ol>
                                    <!--/.Indicators-->

                                    <!--Slides-->
                                    <div class="carousel-inner" role="listbox">

                                        <!--First slide-->
                                        <div class="carousel-item active">
                                            <div class="col-md-3" style="float:left">
                                                <div class="card card-main mb-2">
                                                    <img class="slider-img"
                                                         src="https://www.onpointcomputerrepairs.com.au/wp-content/uploads/2020/04/1-1-1.jpg"
                                                         alt="icon">
                                                </div>
                                            </div>

                                            <div class="col-md-3" style="float:left">
                                                <div class="card card-main mb-2">
                                                    <img class="slider-img"
                                                         src="https://www.onpointcomputerrepairs.com.au/wp-content/uploads/2020/04/1-1-1.jpg"
                                                         alt="icon">
                                                </div>
                                            </div>

                                            <div class="col-md-3" style="float:left">
                                                <div class="card card-main mb-2">
                                                    <img class="slider-img"
                                                         src="https://www.onpointcomputerrepairs.com.au/wp-content/uploads/2020/04/1-1-1.jpg"
                                                         alt="icon">
                                                </div>
                                            </div>

                                            <div class="col-md-3" style="float:left">
                                                <div class="card card-main mb-2">
                                                    <img class="slider-img"
                                                         src="https://www.onpointcomputerrepairs.com.au/wp-content/uploads/2020/04/1-1-1.jpg"
                                                         alt="icon">
                                                </div>
                                            </div>

                                        </div>
                                        <!--/.First slide-->

                                        <!--Second slide-->
                                        <div class="carousel-item">

                                            <div class="col-md-3" style="float:left">
                                                <div class="card card-main mb-2">
                                                    <img class="slider-img"
                                                         src="https://www.onpointcomputerrepairs.com.au/wp-content/uploads/2020/04/1-1-1.jpg"
                                                         alt="icon">
                                                </div>
                                            </div>

                                            <div class="col-md-3" style="float:left">
                                                <div class="card card-main mb-2">
                                                    <img class="slider-img"
                                                         src="https://www.onpointcomputerrepairs.com.au/wp-content/uploads/2020/04/1-1-1.jpg"
                                                         alt="icon">
                                                </div>
                                            </div>

                                            <div class="col-md-3" style="float:left">
                                                <div class="card card-main mb-2">
                                                    <img class="slider-img"
                                                         src="https://www.onpointcomputerrepairs.com.au/wp-content/uploads/2020/04/1-1-1.jpg"
                                                         alt="icon">
                                                </div>
                                            </div>

                                            <div class="col-md-3" style="float:left">
                                                <div class="card card-main mb-2">
                                                    <img class="slider-img"
                                                         src="https://www.onpointcomputerrepairs.com.au/wp-content/uploads/2020/04/1-1-1.jpg"
                                                         alt="icon">
                                                </div>
                                            </div>

                                        </div>
                                        <!--/.Second slide-->
                                    </div>
                                    <!--/.Slides-->
                                </div>
                                <!--/.Carousel Wrapper-->
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>

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
            color: #000;
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
            height: 391px;
            width: 317px;
            border-radius: 35px 0;
            transform: skewY(-1deg) scale(1);
        }

        .img-div {
            position: absolute;
            right: 1%;
            top: -30px;
        }

        .image-div-2 {
            height: 391px;
            width: 317px;
            border-radius: 55px 0;
            transform: skewY(-10deg) scale(1);
            background: url(https://www.onpointcomputerrepairs.com.au/wp-content/uploads/2020/04/1-1-1.jpg);
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

        .card-h1{
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
        .section-heading {
            margin-top: 0;
            font-weight: 500;
            padding-bottom: 11px;
            color: #333;
            text-align: center;
            margin-bottom: 25px;
            letter-spacing: 2px;
            text-transform: uppercase;
            font-size: 1.6rem;
        }


        .section-heading:before {
            width: 200px;
            position: absolute;
            content: "";
            left: 46%;
            top: 37px;
            height: 3px;
            margin-left: -50px;
            background-image: linear-gradient(to right, #33c2a7 50%, #f5a000 50%) !important;
        }

        .gallery-section-heading:before {
            width: 90px;
            position: absolute;
            content: "";
            top: 37px;
            height: 3px;
            background-image: linear-gradient(to right, #33c2a7 50%, #f5a000 50%) !important;
        }

        .course-section-heading:before {
            width: 134px;
            position: absolute;
            content: "";
            top: 37px;
            height: 3px;
            background-image: linear-gradient(to right, #33c2a7 50%, #f5a000 50%) !important;
        }
        .default-heading-color{
            color: #671688;
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
