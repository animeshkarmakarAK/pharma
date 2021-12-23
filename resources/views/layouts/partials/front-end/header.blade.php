@php
    /** @var \App\Models\Institute $currentInstitute */
    $currentInstitute =  app('currentInstitute');
@endphp

<div class="container-fluid">
    <div class="container">
        <header class="navbar navbar-expand flex-column flex-md-row bd-navbar">
            <div class="navbar-nav-scroll">
                <div class="nise3-logo" style="height: 70px;">
                    <a href="{{ route('frontend.main') }}">
                        <img class="float-left"
                             src="{{$currentInstitute ? asset('storage/' .$currentInstitute->logo) : asset('assets/logo/dpg/logo.svg')}}"
                             height="100%"
                             alt="Logo"/>
                    </a>
                    <div class="float-left px-1" style="max-width: 311px; padding: 20px;">
                        <p class="slogan slogan-tag">{{ $currentInstitute ? $currentInstitute->title : "DPG Training & Certificate Management" }}</p>
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
                    <a href="{{ route('frontend.main', ['instituteSlug' => $currentInstitute->slug ?? '']) }}"
                       class="btn ">{{__('generic.first_page')}}</a>
                </li>
                @if(!$currentInstitute)
                    <li class="nav-item {{ request()->is('institute-list*') ? 'active-menu' : '' }}">
                        <a href="{{ route('frontend.institute-list') }}" class="btn ">SSP's</a>
                    </li>
                @endif

                <li class="nav-item {{ request()->is('course-management/courses-search*') ? 'active-menu' : '' }}">
                    <a href="{{ route('frontend.course_search', ['instituteSlug' => $currentInstitute->slug ?? '']) }}"
                       class="btn ">{{__('generic.courses')}}</a>
                </li>

                @if($currentInstitute && $currentInstitute->slug)
                    <li class="nav-item {{ request()->is('course-management/yearly-training-calendar*') || request()->is('course-management/fiscal-year*') ? 'active-menu' : '' }}">
                        <a href="{{ route('frontend.fiscal-year', $currentInstitute->slug ?? '') }}" class="btn ">
                        {{__('generic.calendar')}}
                        </a>
                    </li>
                @endif


                <li class="nav-item {{ request()->is('course-management/skill-videos*') ? 'active-menu' : '' }}">
                    <a href="{{ route('frontend.skill_videos', $currentInstitute->slug ?? '') }}" class="btn ">{{__('generic.videos')}}</a>
                </li>

                <li class="nav-item {{ request()->is('course-management/general-ask-page*') ? 'active-menu' : '' }}">
                    <a href="{{ route('frontend.general-ask-page', $currentInstitute->slug ?? '') }}" class="btn">{{__('generic.faq')}}</a>
                </li>

                @if($currentInstitute && $currentInstitute->slug)
                    <li class="nav-item {{ request()->is('course-management/contact-us-page*') ? 'active-menu' : '' }}">
                        <a href="{{ route('frontend.contact-us-page', $currentInstitute->slug) }}"
                           class="btn">{{__('generic.contact')}}</a>
                    </li>
                @endif

            </ul>

            <!-- Right menu items -->
            <ul class="nav navbar-nav navbar-right">
                @if(!auth()->guard('web')->check() && !auth()->guard('trainee')->check())
                    <li class="nav-item">
                        <a class="btn"
                           href="{{ route('frontend.trainee-registrations.index') }}"
                           id="bd-versions" aria-haspopup="true">
                            <i class="fa fa-file"> </i>&nbsp; {{__('generic.trainee_registration')}}
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="btn"
                           href="{{ route('frontend.ssp-registration') }}"
                           id="bd-versions" aria-haspopup="true">
                            <i class="fa fa-file"> </i>&nbsp; {{__('generic.ssc_registration')}}
                        </a>
                    </li>
{{--                    <li class="nav-item">--}}
{{--                        <a class="btn"--}}
{{--                           href="{{ route('frontend.trainee.login-form') }}"--}}
{{--                           id="bd-versions" aria-haspopup="true">--}}
{{--                            <i class="fa fa-file"> </i>&nbsp; {{__('generic.fee_deposit')}}--}}
{{--                        </a>--}}
{{--                    </li>--}}
                @endif

                @if(!\Illuminate\Support\Facades\Auth::guard('web')->check() && !\Illuminate\Support\Facades\Auth::guard('trainee')->check())
                    <li class="nav-item">
                        <a class="btn"
                           href="{{ route('frontend.trainee.login-form') }}"
                           id="bd-versions">
                            <i class="far fa-user"></i>&nbsp; {{__('generic.trainee_login')}}
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="btn" href="{{ route('admin.login-form') }}"
                           id="bd-versions">
                            <i class="far fa-user"></i>&nbsp; {{__('generic.login')}}
                        </a>
                    </li>
                @endif

                @auth('web')
                    <li class="nav-item dropdown">
                        <a class="nav-item nav-link mr-md-2 text-white" href="{{ route('admin.dashboard') }}"
                           id="bd-versions">
                            <i class="fas fa-clipboard-list"></i>&nbsp; {{__('generic.dashboard')}}
                        </a>
                    </li>
                @elseauth('trainee')
                    <li class="nav-item dropdown">
                        <a class="dropdown-toggle btn" href="#" id="navbarDropdown" role="button"
                           data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            {{__('generic.profile')}}
                        </a>
                        <div class="dropdown-menu menu-bg-color" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item"
                               href="{{ route('frontend.trainee') }}">
                                <i class="fas fa-clipboard-list"></i>&nbsp; {{__('generic.my_profile')}}
                            </a>
                            <a class="dropdown-item"
                               href="{{ route('frontend.trainee-enrolled-courses') }}">
                                <i class="fas fa-clipboard-list"></i> &nbsp; {{__('generic.my_courses')}}
                            </a>
                        </div>
                    </li>

                    <li class="nav-item">
                        <a class="btn" href="#"
                           onclick="document.getElementById('trainee-logout').submit()"
                           id="bd-versions">
                            <i class="fas fa-lock-open"></i>&nbsp; {{__('generic.logout')}}
                        </a>
                        <form id="trainee-logout" style="display: none" method="post"
                              action="{{route('frontend.trainee.logout-submit')}}">
                            @csrf
                        </form>
                    </li>
                @endauth
            </ul>
        </div>
    </div>
</nav>



