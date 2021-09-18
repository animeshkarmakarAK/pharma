<div class="container-fluid">
    <div class="container">
        <header class="navbar navbar-expand flex-column flex-md-row bd-navbar">
            <div class="navbar-nav-scroll">
                <div class="nise3-logo" style="height: 50px">
                    <img src="{{asset('/assets/company/images/nise-logo.jpeg')}}" height="100%" alt="Logo"/>
                </div>
            </div>

            <ul class="navbar-nav flex-row ml-md-auto d-md-flex">
                <li class="nav-item dropdown">
                    <a class="nav-item nav-link" href="">
                        <i class="fa fa-paper-plane"></i>&nbsp;
                        info@dss.gov.bd
                    </a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-item nav-link" href="">
                        <i class="fas fa-phone"></i>
                        +৮৮০২-৫৫০০৬৫৯৫, +৮৮০২-৫৫০০৬৫৯৫
                    </a>
                </li>
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

            <!-- Right menu items -->
            <ul class="nav navbar-nav navbar-right">
                <li class="nav-item active">
                    <a href="{{ route('/') }}" class="btn ">
                        <i class="fa fa-file"></i>&nbsp;
                        অনলাইন আবেদন
                    </a>
                </li>
                <li class="nav-item ">
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
                </li>

            </ul>
        </div>
    </div>
</nav>
