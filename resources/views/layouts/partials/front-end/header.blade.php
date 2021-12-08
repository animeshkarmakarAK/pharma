@php
    $slug = request()->segment(count(request()->segments()));

    $institute = \App\Helpers\Classes\Helper::validInstituteSlug($slug);

    $currentInstitute =  null;
    if ($institute) {
        $currentInstitute = $institute;
    }else {
        $slug = null;
    }

@endphp

<div class="container-fluid">
    <div class="container">
        <header class="navbar navbar-expand flex-column flex-md-row bd-navbar">
            <div class="navbar-nav-scroll">
                <div class="nise3-logo" style="height: 70px;">
                    <a href="{{ route('/') }}">
                        <img class="float-left"
                             src="{{!empty($currentInstitute) ? asset('storage/' .$currentInstitute->logo) : asset('assets/logo/dpg/logo.svg')}}"
                             height="100%"
                             alt="Logo"/>
                    </a>
                    <div class="float-left px-1" style="max-width: 311px; padding: 20px;">
                        <p class="slogan slogan-tag">{{ $currentInstitute ? $currentInstitute->title_en : "DPG Training & Certificate Management" }}</p>
                    </div>
                </div>
            </div>
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
                    <a href="{{ route('/', ['instituteSlug' => $slug]) }}" class="btn ">প্রথম পাতা</a>
                </li>

                <li class="nav-item {{ request()->routeIs('course_management::institute-page') ? 'active-menu' : '' }}">
                    <a href="{{ route('course_management::institute-page', ['instituteSlug' => $slug]) }}" class="btn ">SSP's</a>
                </li>

                <li class="nav-item {{ request()->is('course-management/courses-search*') ? 'active-menu' : '' }}">
                    <a href="{{ route('course_management::course_search', ['instituteSlug' => $slug]) }}" class="btn ">কোর্স
                        সমূহ</a>
                </li>

                @if($slug)
                    <li class="nav-item {{ request()->is('course-management/yearly-training-calendar*') || request()->is('course-management/fiscal-year*') ? 'active-menu' : '' }}">
                        <a href="{{ route('course_management::fiscal-year', $slug) }}" class="btn ">
                            প্রশিক্ষণ বর্ষপঞ্জি
                        </a>
                    </li>
                @endif


                <li class="nav-item {{ request()->is('course-management/skill-videos*') ? 'active-menu' : '' }}">
                    <a href="{{ route('course_management::youth.skill_videos', $slug) }}" class="btn ">ভিডিও সমূহ</a>
                </li>

                <li class="nav-item {{ request()->is('course-management/general-ask-page*') ? 'active-menu' : '' }}">
                    <a href="{{ route('course_management::general-ask-page', $slug) }}" class="btn">সাধারণ জিজ্ঞাসা</a>
                </li>

                @if($slug)
                    <li class="nav-item {{ request()->is('course-management/contact-us-page*') ? 'active-menu' : '' }}">
                        <a href="{{ route('course_management::contact-us-page', $slug) }}" class="btn">যোগাযোগ</a>
                    </li>
                @endif

            </ul>

            <!-- Right menu items -->
            <ul class="nav navbar-nav navbar-right">
                @if(!auth()->guard('web')->check() && !auth()->guard('youth')->check())
                    <li class="nav-item">
                        <a class="btn"
                           href="{{ route('course_management::trainee-registrations.index') }}"
                           id="bd-versions" aria-haspopup="true">
                            <i class="fa fa-file"> </i>&nbsp;Trainee Registration
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="btn"
                           href="{{ route('ssp-registration') }}"
                           id="bd-versions" aria-haspopup="true">
                            <i class="fa fa-file"> </i>&nbsp;SSP Registration
                        </a>
                    </li>


                    <li class="nav-item">
                        <a class="btn"
                           href="{{ route('course_management::youth.login-form') }}"
                           id="bd-versions" aria-haspopup="true">
                            <i class="fa fa-file"> </i>&nbsp; ফি জমা
                        </a>
                    </li>
                @endif

                @if(!\Illuminate\Support\Facades\Auth::guard('web')->check() && !\Illuminate\Support\Facades\Auth::guard('youth')->check())
                    <li class="nav-item">
                        <a class="btn"
                           href="{{ route('course_management::youth.login-form') }}"
                           id="bd-versions">
                            <i class="far fa-user"></i>&nbsp; প্রশিক্ষণার্থী লগইন
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
                    <li class="nav-item dropdown">
                        <a class="dropdown-toggle btn" href="#" id="navbarDropdown" role="button"
                           data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            প্রোফাইল
                        </a>
                        <div class="dropdown-menu menu-bg-color" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item"
                               href="{{ route('course_management::youth') }}">
                                <i class="fas fa-clipboard-list"></i>&nbsp; আমার প্রোফাইল
                            </a>
                            <a class="dropdown-item"
                               href="{{ route('course_management::youth-enrolled-courses') }}">
                                <i class="fas fa-clipboard-list"></i> &nbsp; আমার কোর্স সমূহ
                            </a>
                            <a class="dropdown-item"
                               href="{{ route('course_management::youth-current-organization') }}">
                                <i class="fas fa-clipboard-list"></i> &nbsp; আমার কর্মস্থল
                            </a>
                        </div>
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



