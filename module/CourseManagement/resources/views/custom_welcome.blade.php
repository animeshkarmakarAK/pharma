@php
    $currentInstitute = domainConfig('institute');
    $layout = $currentInstitute ? 'master::layouts.custom1' : 'master::layouts.front-end';
@endphp
@extends($layout)

@section('title')
    প্রথম পাতা
@endsection

@section('content')
    <div class="container-fluid">
        <div class="slider-area">
            <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                <div class="carousel-inner" role="listbox">
                    @php
                        $sl=0;
                        $sliderImageNo=0;
                    @endphp
                    @if(!empty($sliders))
                        @foreach($sliders as $slider)
                            <div class="carousel-item  {{ ++$sl==1?'active':'' }}">
                                <div class='container s-fix'>
                                    <div class='row' style="height: 50vh">
                                        <div class='col-md-4'>
                                            <h1 class='big fadeInDownBig animated'>{{ $slider->title }}</h1>
                                            <p class='normal fadeInUpBig animated delay-point-five-s'>{{ $slider->sub_title }}</p>
                                            @if($slider->is_button_available == \Module\CourseManagement\App\Models\Slider::IS_BUTTON_AVAILABLE_YES && !empty($slider->link))
                                                <a href='{{route('course_management::static-content.show', $slider->link)}}' class="btn px-5 slider-btn mb-2">{{ $slider->button_text }}</a>
                                            @endif
                                        </div>
                                        <div class='col-md-8'>
                                            <img
                                                class="img-responsive img-right fadeInRightBig animated delay-one-point-five-s"
                                                alt="{{ ++$sliderImageNo }}"
                                                src="{{asset('/storage/'. $slider->slider)}}"
                                                style="width: 100%;"/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif

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
                    <div class="col-md-12">
                        @if(!empty($staticPage))
                            {!! $staticPage->page_contents !!}
                        @endif
                    </div>
                </div>
            </div>
        </section>

        <div class="banner-section">
            <div class="container banner">
                <div class="row">
                    <div class="col-sm-4">
                        <div class="banner-bar">
                            <img src="{{asset('/assets/company/images/front-page-images/')}}/classroom.png" alt="icon">
                            <h3><span>অভিজ্ঞ প্রশিক্ষক</span></h3>
                            <p>অভিজ্ঞ প্রশিক্ষক দ্বারা কোর্স পরিচালনা ও পর্যবেক্ষণ করা হয়।</p>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="banner-bar">
                            <img src="{{asset('/assets/company/images/front-page-images/')}}/certificate.png"
                                 alt="icon">
                            <h3><span>দক্ষতা বৃদ্ধি</span></h3>
                            <p>সঠিক পদ্ধতিতে শিক্ষার্থীর দক্ষতা যাচাই করা এবং বৃদ্ধি করা হয় ।</p>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="banner-bar">
                            <img src="{{asset('/assets/company/images/front-page-images/')}}/job-support.png"
                                 alt="icon">
                            <h3><span>কাজের নিশ্চয়তা</span></h3>
                            <p>বেকার যুবদের স্বাবলম্বী করার পাশাপাশি দেশের উন্নয়নকে ত্বরান্বিত করার লক্ষ্য কাজ
                                করছে।</p>
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
                        <p class="text-center">{{ !empty($currentInstitute->title_bn)? $currentInstitute->title_bn:'' }}
                            প্রশিক্ষণ ও কোর্স ম্যানেজমেন্ট সিস্টেমের পরিসংখ্যান</p>
                        <div class="template-space"></div>
                    </div>
                    <div class="company-stats col-md-12">
                        <div class="row">
                            <div class="col-md-3 col-sm-6">
                                <div class="profile-box">
                                    <img
                                        src="{{asset('/assets/company/images/front-page-images/ek-nojore-images/')}}/1.png"
                                        alt="icon">
                                    <h4><span>{{ $institute['courses'] ? $institute['courses'] :'0' }} টি</span> বিষয়ে
                                        প্রশিক্ষণ প্রদান</h4>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6">
                                <div class="profile-box">
                                    <img
                                        src="{{asset('/assets/company/images/front-page-images/ek-nojore-images/')}}/2.png"
                                        alt="icon">
                                    {{--<i class="fas fa-users fa-4x"></i>--}}
                                    <h4><span>{{ $institute['youth_registrations']?$institute['youth_registrations']:'0' }} জন </span>
                                        যুবক প্রশিক্ষণ গ্রহন করেছেন</h4>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6">
                                <div class="profile-box">
                                    <img
                                        src="{{asset('/assets/company/images/front-page-images/ek-nojore-images/')}}/3.png"
                                        alt="icon">
                                    {{--<i class="fas fa-university fa-4x"></i>--}}
                                    <h4>
                                        <span>{{ $institute['training_centers']? $institute['training_centers']:'0' }} টি </span>
                                        প্রশিক্ষণ কেন্দ্র</h4>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6">
                                <div class="profile-box">
                                    <img
                                        src="{{asset('/assets/company/images/front-page-images/ek-nojore-images/')}}/4.png"
                                        alt="icon">
                                    {{--<i class="fas fa-chalkboard-teacher fa-4x"></i>--}}
                                    <h4><span>{{ $institute['training_centers'] ? $institute['training_centers'] : '0' }} জন </span>
                                        দক্ষ প্রশিক্ষক</h4>
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
                        <h2 class="section-heading text-dark"> কোর্স সমূহ </h2>
                        <p class="text-center">{{ !empty($currentInstitute->title_bn)? $currentInstitute->title_bn:'' }}
                            এ নিম্ন বিষয়ে প্রশিক্ষণ প্রদান করা হয়</p>
                        <div class="template-space"></div>
                    </div>
                </div>

                <div class="row">
                    <!--Course One-->
                    @if($currentInstituteCourses->count())
                        @foreach($currentInstituteCourses as $publishCourse)
                            <div class="col-sm-3 article-box">
                                <article>
                                    <div class="news-post">
                                        <div class="img-box"
                                             style="
                                                 background: url({{asset('/storage/'. optional($publishCourse->course)->cover_image)}}) no-repeat center;
                                                 background-size: cover;
                                                 ">
                                            <span>{{optional($publishCourse->course)->course_fee?'Tk. '.optional($publishCourse->course)->course_fee:'Free'}}</span>
                                        </div>
                                        <div class="post-content-text">
                                            <h4>
                                                <span>{{ optional($publishCourse->course)->title_bn }}</span>
                                            </h4>
                                            <h4>
                                                <i class="far fa-calendar-check"></i>
                                            </h4>
                                            <div class="post-more">
                                                <a href="javascript:;"
                                                   onclick="courseDetailsModalOpen('{{ $publishCourse->id }}')">বিস্তারিত</a>
                                            </div>
                                        </div>
                                    </div>
                                </article>
                            </div>
                        @endforeach
                    @else
                        <div class="col-md-12">
                            <div class="alert text-danger text-center">
                                কোন কোর্স পাওয়া যায়নি!
                            </div>
                        </div>
                    @endif
                </div>
            </div>
            @if(!empty($currentInstituteCourses->count() >= 8))
                <div class="col-md-12 text-center margin-10">
                    <a href="{{ route('course_management::course_search') }}" class="service-box-button">
                        আরও কোর্স খুঁজুন</a>
                </div>
            @endif
        </section>

        <section class="template-news">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <h2 class="section-heading text-dark">গ্যালারি</h2>
                        <p class="text-center">{{ !empty($currentInstitute->title_bn)? $currentInstitute->title_bn:'' }}
                            পরিচালিত চলমান কতিপয় কর্মসূচির ছবি</p>
                        <div class="template-space"></div>
                    </div>
                </div>

                <div class="row">
                    @if(!empty($galleryCategories->count()))
                        <div class="col-md-12">
                            <ul class="list-inline row">
                                @foreach($galleryCategories as $galleryCategory)
                                    <div class="col-md-3">
                                        <a href="{{ route('course_management::gallery-category', $galleryCategory->id) }}">
                                            <div class="card mr-1">
                                                <img class="img-responsive" style="width: 100%; height: 180px"
                                                     src="{{asset('/storage/'. $galleryCategory->image)}}">
                                                <div class="card-body">
                                                    <h5 class="card-title float-left"
                                                        style="height: 30px">
                                                        {{ mb_strimwidth($galleryCategory->title_bn, 0, 20) }} {{ strlen($galleryCategory->title_bn) >20 ?'...':'' }}
                                                    </h5>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                @endforeach
                            </ul>
                        </div>
                    @else
                        <div class="col-md-12">
                            <div class="alert text-danger text-center">
                                কোন গ্যালারি পাওয়া যাইনি!
                            </div>
                        </div>
                    @endif
                </div>
            </div>
            @if(!empty($galleryCategories->count() >= 4))
                <div class="col-md-12 text-center margin-10">
                    <a href="{{ route('course_management::gallery-categories') }}" class="service-box-button">
                        আরও গ্যালারি দেখুন</a>
                </div>
            @endif
        </section>

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

    </div>



    @push('css')
        <style>
            .sidebar-list li:before {
                font-family: FontAwesome;
                content: "\f105";
                margin-right: 6px;
                color: #4b77be;
            }

            .slider-area {
                /*background: url(http://skills.gov.bd/bitac_cms/template_one/img/white-bg.jpg) no-repeat center;*/
                background-size: cover;
                padding: 50px 0;
            }

            .blink {
                animation: blink 1s linear infinite;
            }

            .blink:hover {
                animation: none;
            }

            @keyframes blink {
                0% {
                    opacity: 0;
                }
                50% {
                    opacity: .5;
                }
                100% {
                    opacity: 1;
                }
            }

            .responsive_menu_btn:focus {
                /*outline: none;*/
            }

            /* Gallery section css*/


            .small {
                font-size: 11px;
                color: #999;
                display: block;
                margin-top: -10px
            }

            .cont {
                text-align: center;
            }

            .page-head {
                padding: 60px 0;
                text-align: center;
            }

            .page-head .lead {
                font-size: 18px;
                font-weight: 400;
                line-height: 1.4;
                margin-bottom: 50px;
                margin-top: 0;
            }

            .page-head h1 {
                font-size: 42px;
                margin: 0 0 20px;
                color: #FFF;
                position: relative;
                display: inline-block;
            }

            .page-head h1 .version {
                bottom: 0;
                color: #ddd;
                font-size: 11px;
                font-style: italic;
                position: absolute;
                width: 58px;
                right: -58px;
            }

            .iframe-class {
                z-index: -1;
            }

            .iframe-layer {
                position: absolute;
                height: 100%;
                z-index: 9999;
                width: 100%;
                opacity: .0001;
            }
            .slider-btn{
                background: #4b77be;
                border-radius: 0;
                color: #fff;
                padding: 10px;
            }
        </style>

    @endpush
    @push('js')
        <script>
            async function courseDetailsModalOpen(courseId) {
                let response = await $.get('{{route('course_management::course-details.ajax', ['publish_course_id' => '__'])}}'.replace('__', courseId));
                if (response?.length) {
                    $("#course_details_modal").find(".modal-content").html(response);
                } else {
                    let notFound = `<div class="alert alert-danger">Not Found</div>
                            </div>`
                    $("#course_details_modal").find(".modal-content").html(notFound);
                }
                $("#course_details_modal").modal('show');
            }

            $(document).on('click', '.gallery-category-filter', function () {
                let galleryCategoryId = $(this).data('gallery-category-id');

                //$('.my_gallery_'+galleryCategoryId).addClass('bg-dark');


                if (galleryCategoryId) {
                    $("#lightgallery").find('li').fadeOut();
                    $('.gallery_category_id_' + galleryCategoryId).fadeIn();
                } else {
                    $("#lightgallery").find('li').fadeIn();
                }
            });


            let galleryCategoryName = document.getElementById("galleryCategoryName");
            let galleryCategoryBtn = galleryCategoryName?.getElementsByClassName("gallery-category-filter");
            for (var i = 0; i < galleryCategoryBtn?.length; i++) {
                galleryCategoryBtn[i].addEventListener("click", function () {
                    var current = document.getElementsByClassName("bg-dark");
                    current[0].className = current[0].className.replace(" bg-dark", " bg-light");
                    this.className += " bg-dark";
                });
            }
        </script>


    @endpush

@endsection






