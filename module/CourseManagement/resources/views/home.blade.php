@php
    $layout = 'master::layouts.front-end';
    $slug = request()->segment(count(request()->segments()));

    if (!\App\Helpers\Classes\Helper::validSlug($slug)) {
        $slug = null;
    }

    $currentInstitute = null;

    if ($slug) {
        $currentInstitute = \Module\CourseManagement\App\Models\Institute::where('slug', $slug)->first();
    }

@endphp

@extends($layout)

@section('title')
    প্রথম পাতা
@endsection

@section('content')
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
                                       class="more-course-button mt-3 mb-5 bg-transparent">আরও দেখুন <i
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
                        {{ !empty($currentInstitute)? $currentInstitute->name:'DGP Training and Certificate Management' }}
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
                        {{ !empty($currentInstitute->name)? $currentInstitute->name:'' }}
                        এ নিম্ন বিষয়ে প্রশিক্ষণ প্রদান করা হয়
                    </p>
                </div>
                <div class="tab-content">
                    @if($publishCourses->count() > 4)
                        <div id="all-course" class="tab-pane active">
                            <div id="courseCarousel" class="carousel custom-carousel slide w-100" data-ride="carousel">
                                <div class="custom-carousel-inner w-100" role="listbox">
                                    <div class="col-md-12 p-0">
                                        <div class="row">

                                            @php
                                                $ml=0;
                                            @endphp

                                            @foreach($publishCourses as $key => $publishCourse)
                                                <div
                                                    class="carousel-item custom-carousel-item {{ ++$ml==1?'active':'' }}">
                                                    <div class="col-md-3">
                                                        <div class="card card-main mb-2">
                                                            <div class="card-bar-home-course">
                                                                <div class="pb-3">
                                                                    <img class="slider-img border-top-radius"
                                                                         src="{{asset('/storage/'.$publishCourse->course->cover_image)}}"
                                                                         alt="icon">
                                                                </div>
                                                                <div class="text-left pl-4 pr-4 pt-1 pb-1">
                                                                    <p class="font-weight-bold course-heading-wrap">{{ $publishCourse ? $publishCourse->coures->title_bn/*." (".$publishCourse->session_name_bn.")"*/:'' }}</p>
                                                                    <p class="font-weight-light mb-1"><i
                                                                            class="fas fa-clock gray-color mr-2"></i>
                                                                        <span
                                                                            class="course-p">{{ !empty($publishCourse->duration) ? $publishCourse->course->duration:' সময়কাল নির্ধারিত হয়নি' }}</span>
                                                                    </p>
                                                                    <p class="font-weight-light mb-1"><i
                                                                            class="fas fa-user-plus gray-color mr-2"></i>

                                                                        <span class="course-p">আসন সংখ্যা ( {{ \App\Helpers\Classes\NumberToBanglaWord::engToBn(!empty($publishCourse)? $publishCourse->course->max_seat_available:'') }} )</span>
                                                                    </p>
                                                                    <p class="card-p1 float-left mb-1">
                                                                        <span
                                                                            style="font-weight: 900;color: #73727f;font-size: 23px; margin-right: 8px; width: 20px; display: inline-block;">&#2547;</span>
                                                                        {{ $publishCourse->course_fee ? \App\Helpers\Classes\NumberToBanglaWord::engToBn($publishCourse->course->course_fee).' টাকা' : 'ফ্রি'}}
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
                    @elseif($publishCourses->isEmpty())
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
                                <div class="row justify-content-center">
                                    @foreach($publishCourses as $key => $publishCourse)
                                        <div class="col-md-6">
                                            <div class="card card-main mb-2">
                                                <div class="card-bar-home-course">
                                                    <div class="pb-3">
                                                        <img class="slider-img border-top-radius"
                                                             src="{{asset('/storage/'. $publishCourse->course->cover_image)}}"
                                                             alt="icon">
                                                    </div>
                                                    <div class="text-left pl-4 pr-4 pt-1 pb-1">
                                                        <p class="font-weight-bold course-heading-wrap">{{ $publishCourse ? $publishCourse->course->title_bn/*." (".$course->session_name_bn.")"*/:'' }}</p>
                                                        <p class="font-weight-light mb-1"><i
                                                                class="fas fa-clock gray-color mr-2"></i> <span
                                                                class="course-p">{{ !empty($publishCourse->course->duration) ? $publishCourse->course->duration:' সময়কাল নির্ধারিত হয়নি' }}</span>
                                                        </p>
                                                        <p class="font-weight-light mb-1"><i
                                                                class="fas fa-user-plus gray-color mr-2"></i>
                                                            <span
                                                                class="course-p">আসন সংখ্যা ( {{ \App\Helpers\Classes\NumberToBanglaWord::engToBn(!empty($publishCourse)? $publishCourse->course->max_seat_available:'' )}} )</span>
                                                        </p>
                                                        <p class="card-p1 float-left mb-1">
                                                            <span
                                                                style="font-weight: 900;color: #73727f;font-size: 23px; margin-right: 8px; width: 20px; display: inline-block;">&#2547;</span>
                                                            {{$publishCourse->course->course_fee ? \App\Helpers\Classes\NumberToBanglaWord::engToBn($publishCourse->course->course_fee).' টাকা' : 'ফ্রি'}}
                                                        </p>
                                                        <p class="float-right">
                                                            <a href="javascript:;"
                                                               onclick="courseDetailsModalOpen('{{ $publishCourse->course->id }}')"
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
@endsection

@push('css')
@endpush
@push('js')
@endpush
