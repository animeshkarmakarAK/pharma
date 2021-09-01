@php
    $currentInstitute = domainConfig('institute');
@endphp
<div class="site-header">
    <header class="navbar navbar-expand flex-column flex-md-row bd-navbar custom_header">
        <div class="navbar-nav-scroll">
            <ul class="navbar-nav flex-row ml-md-auto d-none d-md-flex">
                <li class="nav-item">
                    <a class="nav-link text-white" href="mailto:{{ $currentInstitute->email? $currentInstitute->email:'' }}"
                       onclick="ga('send', 'event', 'Navbar', 'Community links', 'Bootstrap');">
                        <i class="fa fa-paper-plane"></i>&nbsp;
                        {{ $currentInstitute->email? $currentInstitute->email:'' }}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="tel:{{ $currentInstitute->primary_phone }}"
                       onclick="">
                        <i class="fas fa-phone-volume"></i>
                        {{ $currentInstitute->primary_phone }}
                    </a>
                </li>
            </ul>
        </div>

        <ul class="navbar-nav flex-row ml-md-auto d-md-flex">
            <li class="nav-item dropdown">
                @auth('web')
                    <a class="nav-item nav-link mr-md-2 text-white" href="{{ route('admin.dashboard') }}"
                       id="bd-versions">
                        <i class="fas fa-clipboard-list"></i>&nbsp; ড্যাশবোর্ড
                    </a>
                @elseauth('youth')
                    <a class="nav-item nav-link mr-md-2 text-white"
                       href="{{ route('course_management::youth', auth()->guard('youth')->user()->id) }}"
                       id="bd-versions">
                        <i class="fas fa-clipboard-list"></i>&nbsp; প্রোফাইল
                    </a>
                @endauth
            </li>

            @if(!\Illuminate\Support\Facades\Auth::guard('web')->check() && !\Illuminate\Support\Facades\Auth::guard('youth')->check())
                <li class="nav-item dropdown">
                    <a class="nav-item nav-link mr-md-2 text-white" href="{{ route('course_management::youth.login-form') }}"
                       id="bd-versions">
                        <i class="far fa-user"></i>&nbsp; ইয়ুথ লগইন
                    </a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-item nav-link mr-md-2 text-white" href="{{ route('admin.login-form') }}"
                       id="bd-versions">
                        <i class="far fa-user"></i>&nbsp; লগইন
                    </a>
                </li>
            @endif


            @auth('youth')
                <li class="nav-item dropdown">
                    <a class="nav-item nav-link mr-md-2 text-white" href="#"
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
            @if(!auth()->guard('web')->check() && !auth()->guard('youth')->check())
                <li class="nav-item dropdown">
                    <a class="nav-item nav-link mr-md-2 text-white" href="{{ route('course_management::youth-registrations.index') }}"
                       id="bd-versions" aria-haspopup="true">
                        <i class="fa fa-file"> </i>&nbsp; অনলাইন আবেদন
                    </a>
                </li>
            @endif
        </ul>
    </header>
</div>
{{--<hr class="top_hr">--}}
<div class="main-menu sticky-top">
    <nav class="navbar navbar-expand-lg navbar-light bg-light custom_navbar_bg">
        <a class="navbar-brand" href="{{ route('/') }}" style="max-width: 500px; max-height: 100px; overflow: hidden;">
            <img class="logo" src="{{asset('storage/' .$currentInstitute->logo)}}" />
        </a>
        <button class="navbar-toggler responsive_menu_btn" type="button" data-toggle="collapse" data-target="#navbarNavDropdown"
                aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <!-- Left menu items -->
            <ul class="navbar-nav mr-auto">
                <!-- Left menu item empty -->
            </ul>

            <!-- Right menu items -->
            <ul class="nav navbar-nav navbar-right main-menu-right">
{{--                @dd( request()->is('/'));--}}
                <li class="nav-item {{ request()->is('/') ? 'active' : '' }}">
                    <a href="{{ route('/') }}" class="btn ">প্রথম পাতা</a>
                </li>
                <li class="nav-item {{ request()->is('course-management/courses-search*') ? 'active' : '' }}">
                    <a href="{{ route('course_management::course_search') }}" class="btn ">কোর্স সমূহ</a>
                </li>
                <li class="nav-item {{ request()->is('course-management/yearly-training-calendar*') ? 'active' : '' }}">
                    <a href="{{ route('course_management::yearly-training-calendar.index') }}" class="btn ">প্রশিক্ষণ বর্ষপঞ্জি</a>
                </li>
                <li class="nav-item {{ request()->is('course-management/skill-videos*') ? 'active' : '' }}">
                    <a href="{{ route('course_management::youth.skill_videos') }}" class="btn ">ভিডিও সমূহ</a>
                </li>
                <li class="nav-item {{ request()->is('course-management/advice-page*') ? 'active' : '' }}">
                    <a href="{{ route('course_management::advice-page') }}" class="btn ">পরামর্শ</a>
                </li>
                <li class="nav-item {{ request()->is('course-management/general-ask-page*') ? 'active' : '' }}">
                    <a href="{{ route('course_management::general-ask-page') }}" class="btn">সাধারণ জিজ্ঞাসা</a>
                </li>
                <li class="nav-item {{ request()->is('course-management/contact-us-page*') ? 'active' : '' }}">
                    <a href="{{ route('course_management::contact-us-page') }}" class="btn">যোগাযোগ</a>
                </li>
            </ul>
        </div>
    </nav>
</div>

