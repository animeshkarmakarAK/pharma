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
                        <div class='row pos-rel px-5'>
                            <div class='col-sm-12 col-md-5 slider-left-content mb-4'>
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
                            <div class='col-sm-12 col-md-7'>
                                <img class="rounded" width="100%" src="data:image/jpeg;base64,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">

                            </div>
                        </div>
                    </div>
                </div>

                <div class="carousel-item">
                    <div class='container s-fix'>
                        <div class='row pos-rel px-5'>
                            <div class='col-sm-12 col-md-5 slider-left-content mb-4'>
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
                            <div class='col-sm-12 col-md-7'>
                                <img class="rounded" width="100%" src="https://static.vecteezy.com/system/resources/previews/000/677/302/non_2x/abstract-technology-banner-background.jpg">

                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <a class="carousel-control-prev slider-previous-link" href="#carouselExampleIndicators" role="button"
               data-slide="prev">
                <span class="slider-previous-icon" aria-hidden="true">
                    <i class="fas fa-chevron-left"></i>
                </span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next slider-next-link" href="#carouselExampleIndicators" role="button"
               data-slide="next">
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
