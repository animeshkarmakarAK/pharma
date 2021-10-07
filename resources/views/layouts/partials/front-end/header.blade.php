@php
    $currentInstitute = domainConfig('institute');
@endphp

<div class="container-fluid">
    <div class="container">
        <header class="navbar navbar-expand flex-column flex-md-row bd-navbar">
            <div class="navbar-nav-scroll">
                <div class="nise3-logo" style="height: 70px;">
                    <a href="{{ route('/') }}">
                        <img class="float-left" src="{{asset('/assets/logo/nise3.png')}}" height="100%"
                             alt="NISE3 Logo"/>
                    </a>
                    <div class="float-left px-1">
                        <p class="slogan float-right mt-3">National Intelligence for Skills Education</p>
                        <p class="slogan py-1">Employment and Entrepreneurship</p>
                        <p class="slogan slogan-tag">{{ $currentInstitute->title_en }}</p>
                    </div>
                    <a href="{{ route('/') }}">
                        <img class="" src="{{asset('storage/' .$currentInstitute->logo)}}" height="100%" alt="">
                    </a>
                </div>
            </div>
            <ul class="navbar-nav flex-row ml-md-auto d-md-flex">
                @if(!empty($currentInstitute->email))
                    <li class="nav-item">
                        <a class="nav-item nav-link text-dark font-weight-600 pl-0"
                           href="mailto:{{ $currentInstitute->email }}">
                            <i class="fa fa-paper-plane"></i>
                            {{ $currentInstitute->email }}
                        </a>
                    </li>
                @endif

                @if(!empty($currentInstitute->primary_phone))
                    <li class="nav-item">
                        <a class="nav-item nav-link text-dark font-weight-600"
                           href="tel:{{ $currentInstitute->primary_phone }}">
                            <i class="fas fa-phone fa-flip-horizontal"></i>
                            {{ $currentInstitute->primary_phone }}
                        </a>
                    </li>
                @endif
            </ul>
        </header>
    </div>
</div>

<nav class="container-fluid main-menu sticky-top navbar navbar-expand-lg navbar-light menu-bg-color">
    <div class="container">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown"
                aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <!-- Left menu items -->
            <ul class="navbar-nav mr-auto">
                <!-- Left menu item empty -->
                <li class="nav-item {{ request()->is('/') ? 'active-menu' : '' }}">
                    <a href="{{ route('/') }}" class="btn ">প্রথম পাতা</a>
                </li>

                <li class="nav-item {{ request()->is('course-management/courses-search*') ? 'active-menu' : '' }}">
                    <a href="{{ route('course_management::course_search') }}" class="btn ">কোর্স সমূহ</a>
                </li>

                <li class="nav-item {{ request()->is('course-management/advice-page*') ? 'active-menu' : '' }}">
                    <a href="{{ route('course_management::advice-page') }}" class="btn ">পরামর্শ</a>
                </li>

                <li class="nav-item {{ request()->is('course-management/yearly-training-calendar*') || request()->is('course-management/fiscal-year*') ? 'active-menu' : '' }}">
                    <a href="{{ route('course_management::yearly-training-calendar.index') }}" class="btn ">
                        প্রশিক্ষণ বর্ষপঞ্জি
                    </a>
                </li>

                <li class="nav-item {{ request()->is('course-management/skill-videos*') ? 'active-menu' : '' }}">
                    <a href="{{ route('course_management::youth.skill_videos') }}" class="btn ">ভিডিও সমূহ</a>
                </li>

                <li class="nav-item {{ request()->is('course-management/general-ask-page*') ? 'active-menu' : '' }}">
                    <a href="{{ route('course_management::general-ask-page') }}" class="btn">সাধারণ জিজ্ঞাসা</a>
                </li>

                <li class="nav-item {{ request()->is('course-management/contact-us-page*') ? 'active-menu' : '' }}">
                    <a href="{{ route('course_management::contact-us-page') }}" class="btn">যোগাযোগ</a>
                </li>

            </ul>

            <!-- Right menu items -->
            <ul class="nav navbar-nav navbar-right">
                @if(!auth()->guard('web')->check() && !auth()->guard('youth')->check())
                    <li class="nav-item">
                        <a class="btn"
                           href="{{ route('course_management::youth-registrations.index') }}"
                           id="bd-versions" aria-haspopup="true">
                            <i class="fa fa-file"> </i>&nbsp; অনলাইন আবেদন
                        </a>
                    </li>

                    {{--<li class="nav-item">
                        <a class="btn"
                           href="{{ route('course_management::youth.login-form') }}"
                           id="bd-versions" aria-haspopup="true">
                            <i class="fa fa-file"> </i>&nbsp; ফি জমা
                        </a>
                    </li>--}}
                @endif

                @if(!\Illuminate\Support\Facades\Auth::guard('web')->check() && !\Illuminate\Support\Facades\Auth::guard('youth')->check())
                    <li class="nav-item">
                        <a class="btn"
                           href="{{ route('course_management::youth.login-form') }}"
                           id="bd-versions">
                            <i class="far fa-user"></i>&nbsp; ইয়ুথ লগইন
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="btn" href="{{ route('admin.login-form') }}"
                           id="bd-versions">
                            <i class="far fa-user"></i>&nbsp; লগইন
                        </a>
                    </li>
                @endif

                @auth('web')
                    <li class="nav-item dropdown">
                        <a class="nav-item nav-link mr-md-2 text-white" href="{{ route('admin.dashboard') }}"
                           id="bd-versions">
                            <i class="fas fa-clipboard-list"></i>&nbsp; ড্যাশবোর্ড
                        </a>
                    </li>
                @elseauth('youth')
                    <li class="nav-item">
                        <a class="btn"
                           href="{{ route('course_management::youth', auth()->guard('youth')->user()->id.'/youth-enrolled-courses') }}"
                           id="bd-versions">
                            <i class="fas fa-clipboard-list"></i>&nbsp; আমার কোর্স সমূহ
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="btn"
                           href="{{ route('course_management::youth', auth()->guard('youth')->user()->id) }}"
                           id="bd-versions">
                            <i class="fas fa-clipboard-list"></i>&nbsp; প্রোফাইল
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="btn" href="#"
                           onclick="document.getElementById('youth-logout').submit()"
                           id="bd-versions">
                            <i class="fas fa-lock-open"></i>&nbsp; লগআউট
                        </a>
                        <form id="youth-logout" style="display: none" method="post"
                              action="{{route('course_management::youth.logout-submit')}}">
                            @csrf
                        </form>
                    </li>
                @endauth
                {{--<li class="nav-item ">
                    <a href="#" class="btn ">
                        <i class="fa fa-user"></i>&nbsp;
                        ইয়ুথ লগইন
                    </a>
                </li>
                <li class="nav-item ">
                    <a href="#" class="btn ">
                        <i class="fas fa-sign-in-alt"></i>&nbsp;
                        রেজিস্ট্রেশন/লগইন
                    </a>
                </li>--}}

            </ul>
        </div>
    </div>
</nav>



