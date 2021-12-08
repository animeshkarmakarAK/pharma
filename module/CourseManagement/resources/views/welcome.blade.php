@php
    $currentInstitute = domainConfig('institute');
    $layout = 'master::layouts.front-end';
    $sliders = $sliders ?? collect([]);
    $staticPages = $staticPages ?? collect([]);
    $runningCourses = $runningCourse ?? collect([]);
    $upcomingCourses = $upcomingCourses ?? collect([]);
    $galleryCategories = $galleryCategories ?? collect([]);

@endphp
@extends($layout)

@section('title')
    প্রথম পাতা
@endsection

@section('content')
    @php
        $sl=0;
        $sliderImageNo=0;
    @endphp
    @if(!$sliders->isEmpty())
        <!-- Top content Slider Start -->
        <section class="top-content ">
            <!-- Carousel -->
            <div id="topCarousel" class="carousel slide" data-ride="carousel">
                <div class="carousel-inner">
                    @foreach($sliders as $slider)
                        <div class="carousel-item {{ ++$sl==1?'active':'' }}">
                            <div style="background: url('{{asset('/storage/'. $slider->slider)}}');
                                background-position: center;
                                background-size: 100% 100%;
                                background-repeat: no-repeat;
                                min-height: 100%;
                                opacity: .9;
                                "></div>
                            <div class="carousel-caption">
                                <h3 class="slider-title" title="{{ $slider->title }}">
                                    {{ $slider->title }}</h3>
                            </div>
                        </div>
                    @endforeach
                </div>

                <a class="carousel-control-prev slider-previous-link" href="#topCarousel" role="button"
                   data-slide="prev">
                <span class="slider-previous-icon" aria-hidden="true">
                        <i class="fas fa-chevron-left"></i>
                </span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next" href="#topCarousel" role="button" data-slide="next">
                <span class="slider-next-icon" aria-hidden="true">
                        <i class="fas fa-chevron-right"></i>
                </span>
                    <span class="sr-only">Next</span>
                </a>
            </div>
            <!-- End carousel -->
        </section>
        <!-- End Top Content Slider -->
    @endif
    <!-- About Us Start-->
    <section class="about-us-section  position-relative">
        <div class="about-section-color">
            <div class="container pt-5 pb-5">
                <div class="row">
                    <div class="col-md-7">
                        <!--Services Heading-->
                        <h2 class="section-heading-h2 pb-3 mb-0 font-weight-bold"> আমাদের সম্পর্কে </h2>
                        <div class="about-us-content">
                            @if(!empty($staticPage))
                                @if(strlen(strip_tags($staticPage->page_contents)) > 1136)
                                    <p>
                                        {!! \Illuminate\Support\Str::limit( strip_tags($staticPage->page_contents), 460) !!}

                                    </p>

                                    <a href="{{route('course_management::static-content.show', ['page_id' => 'aboutus', 'instituteSlug' => $slug])}}"
                                       target="_blank"
                                       class="more-course-button mt-3 mb-5 bg-transparent">আরও দেখুন<i
                                            class="fas fa-arrow-right btn-arrow"></i></a>
                                @else
                                    <p> {!! $staticPage->page_contents !!}</p>

                                @endif
                            @endif
                        </div>
                    </div>

                    <div class="col-md-5">
                        <div class="about-us-media" style="margin-top: -80px">
                            <iframe
                                src="https://www.youtube.com/embed/{{ !empty($introVideo)? $introVideo->youtube_video_id: '' }}"
                                height="400" width="100%"
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
                    <h2 class="section-heading section-heading-home pb-3">একনজরে</h2>
                    <p class="text-center pb-2">
                        {{ !empty($currentInstitute->title_bn)? $currentInstitute->title_bn:'' }}
                        প্রশিক্ষণ ও কোর্স ম্যানেজমেন্ট সিস্টেমের পরিসংখ্যান
                    </p>
                    <div class="template-space"></div>
                </div>
            </div>
            <div class="row m-left-right-10">
                <div class="col-md-3 ">
                    <div class="instant-view-box instant-view-box-home">
                        <img src="{{asset('assets/atAglance/atg-1.png')}}" class="p-3" alt="">
                        <h3>{{ \App\Helpers\Classes\NumberToBanglaWord::engToBn($institute['courses'] ? $institute['courses'] :'0')  }}
                            টি</h3>
                        <p>বিষয়ে <br> প্রশিক্ষণ প্রদান</p>
                    </div>
                </div>
                <div class="col-md-3 ">
                    <div class="instant-view-box instant-view-box-home">
                        <img src="{{asset('assets/atAglance/atg-2.png')}}" class="p-3" alt="">
                        <h3>{{ \App\Helpers\Classes\NumberToBanglaWord::engToBn($institute['youth_registrations']?$institute['youth_registrations']:'0') }}
                            জন</h3>
                        <p>প্রশিক্ষণ গ্রহণ <br> করেছেন</p>
                    </div>
                </div>
                <div class="col-md-3 ">
                    <div class="instant-view-box instant-view-box-home">
                        <img src="{{asset('assets/atAglance/atg-3.png')}}" class="p-3" alt="">
                        <h3>{{ \App\Helpers\Classes\NumberToBanglaWord::engToBn($institute['training_centers']? $institute['training_centers']:'0') }}
                            টি</h3>
                        <p class="mt-4 mb-4">প্রশিক্ষণ কেন্দ্র</p>
                    </div>
                </div>
                <div class="col-md-3 ">
                    <div class="instant-view-box instant-view-box-home">
                        <img src="{{asset('assets/atAglance/atg-4.png')}}" class="p-3" alt="">
                        <h3>{{ \App\Helpers\Classes\NumberToBanglaWord::engToBn($institute['training_centers'] ? $institute['training_centers'] : '0') }}
                            জন</h3>
                        <p class="mt-4 mb-4">দক্ষ প্রশিক্ষক</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End At A Glance -->

    <!-- Courses Start -->
    <section class="container-fluid slider-area course-section">
        <div class="container my-4">
            <div class="row">
                <div class="col-md-12 mb-3">
                    <h2 class="section-heading section-heading-home pb-3">কোর্স সমূহ</h2>
                    <p class="text-center pb-2">
                        {{ !empty($currentInstitute->title_bn)? $currentInstitute->title_bn:'' }}
                        এ নিম্ন বিষয়ে প্রশিক্ষণ প্রদান করা হয়
                    </p>
                </div>
                <div class="col-md-12 mb-5 mt-5 mt-5">
                    <div class="row">
                        <ul class="nav nav-tabs">
                            <li class="nav-item">
                                <a class="courseTabButton mr-3  {{ request()->is('/') ? 'active' : '' }}" id=""
                                   data-toggle="tab" href="#all-course" role="tab" aria-controls="all-course"
                                   aria-selected="true">চলমান কোর্স</a>
                            </li>
                            <li class="nav-item">
                                <a class="courseTabButton" id="" data-toggle="tab" href="#upcoming-course" role="tab"
                                   aria-controls="upcoming-course" aria-selected="true">আসন্ন কোর্স</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="tab-content">
                    @if($runningCourses->count() > 4)
                        <div id="all-course" class="tab-pane active">
                            <div id="courseCarousel" class="carousel custom-carousel slide w-100" data-ride="carousel">
                                <div class="custom-carousel-inner w-100" role="listbox">
                                    <div class="col-md-12 p-0">
                                        <div class="row">
                                            @php
                                                $ml=0;

                                            @endphp
                                            @foreach($runningCourses as $key => $publishCourse)

                                                <div
                                                    class="carousel-item custom-carousel-item {{ ++$ml==1?'active':'' }}">
                                                    <div class="col-md-3">
                                                        <div class="card card-main mb-2">
                                                            <div class="card-bar-home-course">
                                                                <div class="pb-3">
                                                                    <img class="slider-img border-top-radius"
                                                                         src="{{asset('/storage/'.$publishCourse->cover_image)}}"
                                                                         alt="icon">
                                                                </div>
                                                                <div class="text-left pl-4 pr-4 pt-1 pb-1">
                                                                    <p class="font-weight-bold course-heading-wrap">{{ $publishCourse? $publishCourse->title_bn/*." (".$publishCourse->session_name_bn.")"*/:'' }}</p>
                                                                    <p class="font-weight-light mb-1"><i
                                                                            class="fas fa-clock gray-color mr-2"></i>
                                                                        <span
                                                                            class="course-p">{{ !empty($publishCourse->duration)?$publishCourse->duration:' সময়কাল নির্ধারিত হয়নি' }}</span>
                                                                    </p>
                                                                    <p class="font-weight-light mb-1"><i
                                                                            class="fas fa-user-plus gray-color mr-2"></i>

                                                                        <span class="course-p">আসন সংখ্যা ( {{ \App\Helpers\Classes\NumberToBanglaWord::engToBn(!empty($publishCourse)? $publishCourse->max_seat_available:'') }} )</span>
                                                                    </p>
                                                                    <p class="card-p1 float-left mb-1">
                                                                        <span
                                                                            style="font-weight: 900;color: #73727f;font-size: 23px; margin-right: 8px; width: 20px; display: inline-block;">&#2547;</span>
                                                                        {{ $publishCourse->course_fee ? \App\Helpers\Classes\NumberToBanglaWord::engToBn($publishCourse->course_fee).' টাকা' : 'ফ্রি'}}
                                                                    </p>
                                                                    <p class="float-right">
                                                                        <a href="javascript:;"
                                                                           onclick="courseDetailsModalOpen('{{ $publishCourse->id }}')"
                                                                           class="btn btn-primary btn-sm">বিস্তারিত</a>
                                                                    </p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>


                                            @endforeach
                                        </div>
                                    </div>
                                </div>

                                <!--Controls-->
                                <div class="controls-top">
                                    <a class="btn-floating left-btn-arrow" href="#courseCarousel"
                                       data-slide="prev"><i
                                            class="fas fa-chevron-left"></i></a>
                                    <a class="btn-floating right-btn-arrow" href="#courseCarousel"
                                       data-slide="next"><i
                                            class="fas fa-chevron-right"></i></a>
                                </div>
                                <!--/.Controls-->
                            </div>
                        </div>
                    @elseif($runningCourses->isEmpty())
                        <div id="all-course" class="tab-pane active">
                            <div class="col-md-12">
                                <div class="alert text-danger text-center">
                                    কোন চলমান কোর্স পাওয়া যাইনি!
                                </div>
                            </div>
                        </div>
                    @else
                        <div id="all-course" class="tab-pane active">
                            <div class="col-md-12 p-0">
                                <div class="row">
                                    @foreach($runningCourses as $key => $publishCourse)
                                        <div class="col-md-3">
                                            <div class="card card-main mb-2">
                                                <div class="card-bar-home-course">
                                                    <div class="pb-3">
                                                        <img class="slider-img border-top-radius"
                                                             src="{{asset('/storage/'. $publishCourse->cover_image)}}"
                                                             alt="icon">
                                                    </div>
                                                    <div class="text-left pl-4 pr-4 pt-1 pb-1">
                                                        <p class="font-weight-bold course-heading-wrap">{{ $publishCourse? $publishCourse->title_bn/*." (".$publishCourse->session_name_bn.")"*/:'' }}</p>
                                                        <p class="font-weight-light mb-1"><i
                                                                class="fas fa-clock gray-color mr-2"></i> <span
                                                                class="course-p">{{ !empty($publishCourse->duration) ? $publishCourse->duration:' সময়কাল নির্ধারিত হয়নি' }}</span>
                                                        </p>
                                                        <p class="font-weight-light mb-1"><i
                                                                class="fas fa-user-plus gray-color mr-2"></i>
                                                            <span
                                                                class="course-p">আসন সংখ্যা ( {{ \App\Helpers\Classes\NumberToBanglaWord::engToBn(!empty($publishCourse)? $publishCourse->max_seat_available:'' )}} )</span>
                                                        </p>
                                                        <p class="card-p1 float-left mb-1">
                                                            <span
                                                                style="font-weight: 900;color: #73727f;font-size: 23px; margin-right: 8px; width: 20px; display: inline-block;">&#2547;</span>
                                                            {{$publishCourse->course_fee ? \App\Helpers\Classes\NumberToBanglaWord::engToBn($publishCourse->course_fee).' টাকা' : 'ফ্রি'}}
                                                        </p>
                                                        <p class="float-right">
                                                            <a href="javascript:;"
                                                               onclick="courseDetailsModalOpen('{{ $publishCourse->id }}')"
                                                               class="btn btn-primary btn-sm">বিস্তারিত</a>
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endif

                    @if($upcomingCourses->count() > 4 )
                        <div id="upcoming-course" class="tab-pane fade">
                            <div id="courseCarousel" class="carousel custom-carousel slide w-100" data-ride="carousel">
                                <div class="custom-carousel-inner w-100" role="listbox">
                                    <div class="col-md-12 p-0">
                                        <div class="row">
                                            @php
                                                $ml=0;
                                            @endphp
                                            @foreach($upcomingCourses as $key => $publishCourse)

                                                <div
                                                    class="carousel-item custom-carousel-item {{ ++$ml==1?'active':'' }}">
                                                    <div class="col-md-3">
                                                        <div class="card card-main mb-2">
                                                            <div class="card-bar-home-course">
                                                                <div class="pb-3">
                                                                    <img class="slider-img border-top-radius"
                                                                         src="{{asset('/storage/'.$publishCourse->cover_image)}}"
                                                                         alt="icon">
                                                                </div>
                                                                <div class="text-left pl-4 pr-4 pt-1 pb-1">
                                                                    <p class="font-weight-bold course-heading-wrap">{{ $publishCourse? $publishCourse->title_bn/*." (".$publishCourse->session_name_bn.")"*/:'' }}</p>
                                                                    <p class="font-weight-light mb-1"><i
                                                                            class="fas fa-clock gray-color mr-2"></i>
                                                                        <span
                                                                            class="course-p">{{ !empty($publishCourse->duration)?$publishCourse->duration:' সময়কাল নির্ধারিত হয়নি' }}</span>
                                                                    </p>
                                                                    <p class="font-weight-light mb-1"><i
                                                                            class="fas fa-user-plus gray-color mr-2"></i>

                                                                        <span class="course-p">আসন সংখ্যা ( {{ \App\Helpers\Classes\NumberToBanglaWord::engToBn(!empty($publishCourse)? $publishCourse->max_seat_available:'') }} )</span>
                                                                    </p>
                                                                    <p class="card-p1 float-left mb-1">
                                                                        <span
                                                                            style="font-weight: 900;color: #73727f;font-size: 23px; margin-right: 8px; width: 20px; display: inline-block;">&#2547;</span>
                                                                        {{$publishCourse->course_fee ? \App\Helpers\Classes\NumberToBanglaWord::engToBn($publishCourse->course_fee).' টাকা' : 'ফ্রি'}}
                                                                    </p>
                                                                    <p class="float-right">
                                                                        <a href="javascript:;"
                                                                           onclick="courseDetailsModalOpen('{{ $publishCourse->id }}')"
                                                                           class="btn btn-primary btn-sm">বিস্তারিত</a>
                                                                    </p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                                <!--Controls-->
                                <div class="controls-top">
                                    <a class="btn-floating left-btn-arrow" href="#courseCarousel"
                                       data-slide="prev"><i
                                            class="fas fa-chevron-left"></i></a>
                                    <a class="btn-floating right-btn-arrow" href="#courseCarousel"
                                       data-slide="next"><i
                                            class="fas fa-chevron-right"></i></a>
                                </div>
                                <!--/.Controls-->
                            </div>
                        </div>
                    @elseif($upcomingCourses->isEmpty())
                        <div id="upcoming-course" class="tab-pane fade">
                            <div class="col-md-12">
                                <div class="alert text-danger text-center">
                                    কোন আসন্ন কোর্স পাওয়া যাইনি!
                                </div>
                            </div>
                        </div>
                    @else
                        <div id="upcoming-course" class="tab-pane fade">
                            <div class="col-md-12 p-0">
                                <div class="row">
                                    @foreach($upcomingCourses as $key => $publishCourse)
                                        <div class="col-md-3">
                                            <div class="card card-main mb-2">
                                                <div class="card-bar-home-course">
                                                    <div class="pb-3">
                                                        <img class="slider-img border-top-radius"
                                                             src="{{asset('/storage/'. optional($publishCourse->course)->cover_image)}}"
                                                             alt="icon">
                                                    </div>
                                                    <div class="text-left pl-4 pr-4 pt-1 pb-1">
                                                        <p class="font-weight-bold course-heading-wrap">{{ $publishCourse? $publishCourse->title_bn/*." (".$publishCourse->session_name_bn.")"*/:'' }}</p>
                                                        <p class="font-weight-light mb-1"><i
                                                                class="fas fa-clock gray-color mr-2"></i> <span
                                                                class="course-p">{{ !empty($publishCourse->course->duration)?$publishCourse->course->duration:' সময়কাল নির্ধারিত হয়নি' }}</span>
                                                        </p>
                                                        <p class="font-weight-light mb-1"><i
                                                                class="fas fa-user-plus gray-color mr-2"></i>
                                                            <span
                                                                class="course-p"> আসন সংখ্যা ( {{ \App\Helpers\Classes\NumberToBanglaWord::engToBn(!empty($publishCourse)? $publishCourse->max_seat_available:'') }} )</span>
                                                        </p>
                                                        <p class="card-p1 float-left mb-1">
                                                            <span
                                                                style="font-weight: 900;color: #73727f;font-size: 23px; margin-right: 8px; width: 20px; display: inline-block;">&#2547;</span>
                                                            {{$publishCourse->course_fee ? \App\Helpers\Classes\NumberToBanglaWord::engToBn($publishCourse->course_fee).' টাকা' : 'ফ্রি'}}
                                                        </p>
                                                        <p class="float-right">
                                                            <a href="javascript:;"
                                                               onclick="courseDetailsModalOpen('{{ $publishCourse->id }}')"
                                                               class="btn btn-primary btn-sm">বিস্তারিত</a>
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        @if($upcomingCourses->count() > 4)
            <div class="col-md-12 text-center pt-3">
                <a href="{{ route('course_management::course_search') }}" target="_blank" class="more-course-button">আরও
                    দেখুন <i
                        class="fas fa-arrow-right btn-arrow"></i></a>
            </div>
        @endif
        <div class="modal modal-danger fade" tabindex="-1" id="course_details_modal" role="dialog">
            <div class="row">
                <div class="col-sm-10 mx-auto">
                    <div class="modal-dialog" style="max-width: 100%">
                        <div class="modal-content modal-xlg" style="background-color: #e6eaeb">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End Courses -->

    <!-- Event Start -->
    <section class="yearly-training-calendar bg-white">
        <div class="container pb-3">
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
                            <h3 class="accordion-heading"
                                id="eventDateTime">{{ \App\Helpers\Classes\EnglishToBanglaDate::dateFormatEnglishToBangla(date("l, j F Y")) }}</h3>
                            <!-- Accordion -->
                            <div id="eventArea" class="accordion">

                            </div>
                            <!-- End -->
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
            <div class="row">
                <div class="col-md-12 mb-3">
                    <h3 class="gallery-section-heading section-heading-home section-heading pb-4">গ্যালারি</h3>
                </div>
                @if($galleryCategories->count() > 3)
                    <div class="col-md-12">
                        <div class="row">
                            @foreach($galleryCategories as $galleryCategory)
                                <div class="col-md-3">
                                    <a href="{{ route('course_management::gallery-category', $galleryCategory->id) }}">
                                        <div class="card card-main mb-2 shadow-none bg-transparent">
                                            <img class="slider-img slider-radius"
                                                 src="{{asset('/storage/'. $galleryCategory->image)}}">
                                            <h3 class="gallery-post-heading">{{ mb_strimwidth($galleryCategory->title_bn, 0, 20) }} {{ strlen($galleryCategory->title_bn) >20 ?'...':'' }}</h3>
                                        </div>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @elseif($galleryCategories->count() > 2)
                    <div class="col-md-12">
                        <div class="row">
                            @foreach($galleryCategories as $galleryCategory)
                                <div class="col-md-4">
                                    <a href="{{ route('course_management::gallery-category', $galleryCategory->id) }}">
                                        <div class="card card-main mb-2 shadow-none bg-transparent">
                                            <img class="slider-img slider-radius"
                                                 src="{{asset('/storage/'. $galleryCategory->image)}}">
                                            <h3 class="gallery-post-heading">{{ mb_strimwidth($galleryCategory->title_bn, 0, 20) }} {{ strlen($galleryCategory->title_bn) >20 ?'...':'' }}</h3>
                                        </div>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @elseif($galleryCategories->count() > 1)
                    <div class="col-md-12">
                        <div class="row w-100 justify-content-center text-center">
                            @foreach($galleryCategories as $galleryCategory)

                                <div class="col-md-4 ">
                                    <a href="{{ route('course_management::gallery-category', $galleryCategory->id) }}">
                                        <div class="card card-main mb-2 shadow-none bg-transparent">
                                            <img class="slider-img slider-radius"
                                                 src="{{asset('/storage/'. $galleryCategory->image)}}">
                                            <h3 class="gallery-post-heading">{{ mb_strimwidth($galleryCategory->title_bn, 0, 20) }} {{ strlen($galleryCategory->title_bn) >20 ?'...':'' }}</h3>
                                        </div>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @elseif($galleryCategories->count() > 0)
                    <div class="col-md-12">
                        <div class="row w-100 justify-content-center text-center">
                            @foreach($galleryCategories as $galleryCategory)
                                <div class="col-md-4">
                                    <a href="{{ route('course_management::gallery-category', $galleryCategory->id) }}">
                                        <div class="card card-main mb-2 shadow-none bg-transparent">
                                            <img class="slider-img slider-radius"
                                                 src="{{asset('/storage/'. $galleryCategory->image)}}">
                                            <h3 class="gallery-post-heading">{{ mb_strimwidth($galleryCategory->title_bn, 0, 20) }} {{ strlen($galleryCategory->title_bn) >20 ?'...':'' }}</h3>
                                        </div>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @elseif($galleryCategories->isEmpty())
                    <div class="col-md-12">
                        <div class="alert text-danger text-center">
                            কোন গ্যালারি পাওয়া যাইনি!
                        </div>
                    </div>
                @else
                    <div class="col-md-12">
                        <div class="row">
                            @foreach($galleryCategories as $galleryCategory)
                                <div class="col-md-3">
                                    <a href="{{ route('course_management::gallery-category', $galleryCategory->id) }}">
                                        <div class="card card-main mb-2 shadow-none bg-transparent">
                                            <img class="slider-img slider-radius"
                                                 src="{{asset('/storage/'. $galleryCategory->image)}}">
                                            <h3 class="gallery-post-heading">{{ mb_strimwidth($galleryCategory->title_bn, 0, 20) }} {{ strlen($galleryCategory->title_bn) >20 ?'...':'' }}</h3>
                                        </div>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                        @endif
                    </div>
                    @if((isset($galleryAllCategories) && $galleryAllCategories->count() > 3) && ($galleryCategories->count() > 0))
                        <div class="col-md-12 text-center pb-5">
                            <a href="{{ route('course_management::gallery-categories') }}" target="_blank"
                               class="more-course-button mt-3">আরও দেখুন <i
                                    class="fas fa-arrow-right btn-arrow"></i></a>
                        </div>
                    @endif
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

        .header-bg {
            background: #671688;
            color: white;
        }

        .modal-header .close, .modal-header .mailbox-attachment-close {
            padding: 1rem;
            margin: -1rem -1rem -1rem auto;
            color: white;
            outline: none;
        }

    </style>
    <style>
        /*sliders css*/
        .slider-img {
            width: 100%;
            height: 11vw;
            object-fit: cover;
        }

        .slider-radius {
            border-radius: 0.5rem !important;
        }

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

        .slider-title {
            font-family: Hind Siliguri;
            font-style: normal;
            font-size: 25px;
            line-height: 40px;
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
            padding-top: 0;
            padding-bottom: 0;
            left: 0;
            right: 0;
        }

        .top-content .carousel-caption h1 {
            padding-top: 60px;
            color: #fff;
        }

        .top-content .carousel-caption h3 {
            color: #fff;
            background: linear-gradient(rgba(0, 0, 0, 0.2), rgba(0, 0, 0, 0.2));
            padding: 10px;
            margin-bottom: 0;
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
            height: 90vh;
        }

        .carousel-caption {
            bottom: 0;
        }

        .carousel-control-prev, .carousel-control-next {
            width: 21%;
        }

        /*About Us*/

        .about-us-section {
            background: #FFFFFF;
            padding-top: 4rem;
        }

        .about-us-content p {
            line-height: 30px;
            font-size: 20px;
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

        .custom-carousel-inner .carousel-item.active,
        .custom-carousel-inner .carousel-item-next,
        .custom-carousel-inner .carousel-item-prev {
            display: flex;
        }

        .custom-carousel-inner .carousel-item-right.active,
        .custom-carousel-inner .carousel-item-next {
            transform: translateX(25%);
        }

        .custom-carousel-inner .carousel-item-left.active,
        .custom-carousel-inner .carousel-item-prev {
            transform: translateX(-25%);
        }

        .custom-carousel-inner .carousel-item-right,
        .custom-carousel-inner .carousel-item-left {
            transform: translateX(0);

        }

        /* At a Glance */

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

        .instant-view-box-home p {
            color: #39759f;
            padding: 0px 10px;
        }

        /* Courses */

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

        .course-heading-wrap {
            text-overflow: ellipsis;
            white-space: nowrap;
            overflow: hidden;
        }

        .course-heading-wrap:hover {
            overflow: visible;
        }

        .course-heading-wrap:hover {
            overflow: visible;
            white-space: normal;
            cursor: pointer;
        }

        .courseTabButton {
            padding: 10px 30px;
            color: #671688;
            border-radius: 5px;
        }

        .courseTabButton:hover, .courseTabButton:active, .courseTabButton:focus {
            background: #671688;
            padding: 10px 30px;
            color: #fff;
            border-radius: 5px;
            border: 1px solid #671688;
        }

        #all-course {
            width: 100%;
        }

        .tab-content {
            width: 100%;
        }

        .nav-tabs {
            border-bottom: 0;
        }

        .nav-tabs .nav-item .active {
            background: #671688;
            padding: 10px 30px;
            color: #fff;
            border-radius: 5px;
            border: 1px solid #671688;
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
            color: black;
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

        .custom-carousel-inner {
            position: relative;
            width: 100%;
            overflow: hidden;
        }

        .m-left-right-10 {
            margin-left: 7.5px;
            margin-right: 7.5px;
        }

        /* Responsive Design */

        @media screen and (max-width: 767px) {
            .about-us-media {
                margin-top: 0px !important;
            }

            .slider-img {
                height: 200px;
            }

            .about-us-section {
                text-align: justify;
            }

            .top-content .carousel-item {
                height: 60vh;
            }


            .slider-previous-icon, .slider-next-icon {
                padding: 10px;
            }
        }

        @media screen and (min-width: 987px ) {
            .m-left-right-10 {
                margin-left: 10%;
                margin-right: 10%;
            }
        }


    </style>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@5.7.0/main.min.css" type="text/css">
    <style>
        #calendar {
            background-color: #fff;
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

        .fc .fc-col-header-cell-cushion {
            display: inline-block;
            padding: 2px 4px;
            color: #2c3e50;
        }

        .fc-theme-standard td, .fc-theme-standard th {
            border: none !important;
            cursor: pointer;
        }

        .fc-theme-standard .fc-scrollgrid {
            border: none !important;
        }

        .fc .fc-daygrid-day-number {
            position: relative;
            z-index: 4;
            padding: 4px;
            color: #000;
        }

        .fc .fc-day-other .fc-daygrid-day-top {
            opacity: 1 !important;
        }

        .fc .fc-day-past:not(.fc-day-other) .fc-scrollgrid-sync-inner, .fc-day-future:not(.fc-day-other) .fc-scrollgrid-sync-inner {
            background: #c7c7c7;
            border: 1px solid #c7c7c7;
            margin: 3px;
            border-radius: 5px;
        }

        .fc-day-today {
            background: #671688 !important;
            border: 1px solid #671688;
            margin: 3px;
            border-radius: 5px;
        }

        .fc-day-today a {
            color: #fff !important;
        }

        .fc .fc-button-primary {
            color: #000 !important;
            background: none !important;
            border: none !important;
        }

        .fc .fc-toolbar {
            justify-content: center !important;
        }

        .fc .fc-button:focus {
            outline: none;
            box-shadow: none !important;
        }

        .fc .fc-daygrid-day-top {
            display: flex;
            flex-direction: row-reverse;
            padding: 10px;
            margin-bottom: 5px;
        }

        .fc-daygrid-day-events {
            /*display: none !important;*/
        }

        .fc .fc-scroller-liquid-absolute {
            /*overflow: hidden !important;*/
        }

        .fc .fc-scroller {
            overflow: hidden !important;
        }

        .fc .fc-highlight {
            background: #3788d8;
        }

        .today-event {
            background: #ff005d;
            padding: 3px 10px;
            border-radius: 5px;
            color: #fff;
        }

        .fc .fc-daygrid-body-unbalanced .fc-daygrid-day-events {
            position: absolute;
            min-height: 1em !important;
            left: 0;
            bottom: 0;
            width: 25px;
            text-align: center;
            margin: 0;
            padding: 0;
        }

        .carousel-item {
            transition-duration: 3s;
        }



    </style>
@endpush
@push('js')
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.9.0/main.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.9.0/locales-all.js"></script>
    <script>
        function todayEvent() {
            let today = new Date();
            today = new Intl.DateTimeFormat('bn-BD').format(today);
            return today;
        }

        function eventDate(date) {
            let eventDate = new Date(date);
            eventDate = new Intl.DateTimeFormat('bn-BD').format(eventDate);
            return eventDate;
        }

        function eventTime(date) {
            let time = new Date(date);
            time = time.toLocaleTimeString(['bn-BD'], {hour: '2-digit', minute: '2-digit'});
            return time;
        }

        function eventsTemplate(key) {
            let eventClass = '';
            if (todayEvent() == eventDate(this.date)) {
                eventClass = 'today-event';
            } else {
                eventClass = '';
            }
            return '<div class="card shadow-none mb-0">' +
                '<div id="heading' + key + '" class="card-header bg-white shadow-sm border-0">' +
                '<h2 class="mb-0">' +
                '<button type="button" data-toggle="collapse" data-target="#collapse' + key + '"' +
                'aria-expanded="true" aria-controls="collapseOne"' +
                'class="btn btn-link text-dark font-weight-bold text-uppercase collapsible-link">' +
                this.caption +
                '<p class="mb-0 mt-1">' +
                '<i class="far fa-calendar-minus gray-color"></i>' +
                '<span class="accordion-date ' + eventClass + ' ml-1">' + eventDate(this.date) + '    ' + eventTime(this.date) + '</span>' +
                '</p> </button> </h2>' +
                '</div>' +
                '<div id="collapse' + key + '" aria-labelledby="heading' + key + '"' +
                'data-parent="#eventArea" class="collapse">' +
                '<div class="card-body p-5">' +
                '<p class="font-weight-light m-0">' + this.details +
                '</p> <a href="{{ route('course_management::single-event','__') }}"'.replace('__', this.id) +
                'class="btn btn-sm btn-info mt-3">বিস্তিরিত দেখুন</a>' +
                '</div>' +
                '</div>' +
                '</div>';
        }

        let events = '';
        @if(isset($currentInstituteEvents))
            @foreach($currentInstituteEvents as $key => $currentInstituteEvent)
            events += eventsTemplate.call(@json($currentInstituteEvent), '{{$key}}');
        @endforeach
        @endif

        $("#eventArea").html(events);

        function eventsOfSpecificDate(date) {
            $.ajax({
                url: '{{route('course_management::institute-events-date')}}',
                type: "POST",
                data: {date: date},
            }).done(function (response) {
                $("#eventArea").hide().empty();
                let events = '';
                $.each(response, function (key, value) {
                    events += eventsTemplate.call(value, key)
                })
                $("#eventArea").delay(100).fadeIn(800).html(events);
            }).fail(function (xhr) {
                failureCallback([]);
            });
        }

        $(function () {
            let calendarEl = document.getElementById('calendar');
            let initialDate = '{{date('Y-m-d')}}';
            let initialLocaleCode = 'bn';

            let calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                initialDate,
                height: 500,
                aspectRatio: 1,
                displayEventTime: false,
                selectable: true,
                customButtons: {
                    myCustomButton: {
                        text: 'বছর',
                        click: function () {
                            window.location = '{{ route('course_management::fiscal-year') }}';
                        }
                    }
                },
                headerToolbar: {
                    //left: 'prev,next today',
                    left: 'prev',
                    center: 'title',
                    //right: 'timeGridDay,timeGridWeek,dayGridMonth,myCustomButton'
                    right: 'next'
                },
                locale: initialLocaleCode,
                events: function (fetchInfo, successCallback, failureCallback) {
                    $.ajax({
                        url: '{{route('course_management::institute-events')}}',
                        type: "POST",
                    }).done(function (response) {
                        successCallback(response);
                    }).fail(function (xhr) {
                        failureCallback([]);
                    });
                },
                dateClick: function (info) {
                    console.log(info);
                    let eventDateTime = new Date(info.dateStr);
                    eventDateTime = new Intl.DateTimeFormat('bn-BD', {
                        weekday: 'long',
                        day: '2-digit',
                        month: 'long',
                        year: 'numeric',
                    }).format(eventDateTime)
                    $('#eventDateTime').html(eventDateTime);
                    const start = info.dateStr;
                    eventsOfSpecificDate(start);
                },
            });
            calendar.render();

        });


        async function courseDetailsModalOpen(publishCourseId) {
            let response = await $.get('{{route('course_management::course-details.ajax', ['publish_course_id' => '_'])}}'.replace('_', publishCourseId));

            if (response?.length) {
                $("#course_details_modal").find(".modal-content").html(response);
            } else {
                let notFound = `<div class="alert alert-danger">Not Found</div>`
                $("#course_details_modal").find(".modal-content").html(notFound);
            }

            $("#course_details_modal").modal('show');
        }

    </script>
    <script>
        $(document).ready(function () {
            $('#topCarousel').carousel({
                interval: 8000
            })
            $('#recipeCarousel').carousel({
                interval: 2000
            })
            $('#courseCarousel').carousel({
                interval: 2000
            })
            $('.custom-carousel  .custom-carousel-item').each(function () {
                var next = $(this).next();
                if (!next.length) {
                    next = $(this).siblings(':first');
                }
                next.children(':first-child').clone().appendTo($(this));

                for (var i = 0; i < 2; i++) {
                    next = next.next();
                    if (!next.length) {
                        next = $(this).siblings(':first');
                    }

                    next.children(':first-child').clone().appendTo($(this));
                }
            });

        });
    </script>
@endpush
