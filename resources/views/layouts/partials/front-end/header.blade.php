<div class="site-header">
    <header class="navbar navbar-expand flex-column flex-md-row bd-navbar">
        <div class="navbar-nav-scroll">
            {{--<ul class="navbar-nav bd-navbar-nav flex-row">--}}
            <ul class="navbar-nav flex-row ml-md-auto d-none d-md-flex">
                <li class="nav-item">
                    <a class="nav-link text-white" href="#"
                       onclick="ga('send', 'event', 'Navbar', 'Community links', 'Bootstrap');">
                        <i class="fa fa-paper-plane"></i>&nbsp;
                        info@dss.gov.bd</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="#"
                       onclick="ga('send', 'event', 'Navbar', 'Community links', 'Docs');">
                        <i class="fas fa-phone-volume"></i>
                        +৮৮০২-৫৫০০৬৫৯৫</a>
                </li>
            </ul>
        </div>

        {{--<ul class="navbar-nav flex-row ml-md-auto d-none d-md-flex">--}}
        <ul class="navbar-nav flex-row ml-md-auto d-md-flex">
            @auth('web')
                <li class="nav-item dropdown">

                    <a class="nav-item nav-link mr-md-2 text-white" href="{{ route('admin.dashboard') }}"
                       id="bd-versions">
                        <i class="fas fa-clipboard-list"></i>&nbsp; ড্যাশবোর্ড
                    </a>
                </li>
            @else
                <li class="nav-item dropdown">
                    <a class="nav-item nav-link mr-md-2 text-white" href="{{ route('login') }}"
                       id="bd-versions">
                        <i class="far fa-user"></i>&nbsp; লগইন
                    </a>
                </li>
            @endauth
        </ul>
    </header>
</div>
<hr class="top_hr">
<div class="main-menu sticky-top">
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="{{ route('/') }}">
            <img class="logo" src="{{asset('/assets/company/images/nise-logo.jpeg')}}" height="70px">
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown"
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
                <li class="nav-item active">
                    <a href="{{ route('/') }}" class="btn ">প্রথম পাতা</a>
                </li>
                <li class="nav-item ">
                    <a href="#" class="btn ">পরামর্শ</a>
                </li>
                <li class="nav-item ">
                    <a href="#" class="btn ">প্রশিক্ষণ বর্ষপঞ্জি</a>
                </li>
                <li class="nav-item ">
                    <a href="#" class="btn">সাধারণ জিজ্ঞাসা</a>
                </li>
                <li class="nav-item ">
                    <a href="#" class="btn">যোগাযোগ</a>
                </li>

            </ul>
        </div>
    </nav>
</div>
