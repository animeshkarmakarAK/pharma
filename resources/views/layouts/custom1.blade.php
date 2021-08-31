<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="csrf-token" content="{{csrf_token()}}"/>

    <title>@yield('title')</title>

    <!-- Bootstrap v4 with admin-lte v3 -->
    <link rel="stylesheet" href="{{asset('/css/app.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/overlayscrollbars/1.13.0/css/OverlayScrollbars.min.css">
    <style>
        .site-header {
            background: #4B77BE;
        }
        .top_hr {
            background: #a4cd72;
            height: 4px;
            margin: 0;
            padding: 0;
        }

        .main-menu {
            /*height: 80px;*/
        }

        .logo {
            margin-left: 15px;
        }

        .menu-text {
            line-height: 7px;
        }
        .menu-text-one {
            /*padding: 10px 0 0 0;*/
            font-size: 1.2rem;
            font-weight: bold;
            line-height: 12px;
            color: #636363;
        }
        .menu-text-two {
            letter-spacing: 1px;
            font-weight: bold;
            /* line-height: 2px; */
            color: #6b6464;
        }
        .main-menu-right {
            margin-right: 15px;
        }
        .main-menu-right li a {
            color: #5d5959;
        }
        .main-menu-right li.active a {
            color: #4B77BE;
            transition: .4s;
        }
        .main-menu-right li a:hover {
            color: #4B77BE;
            transition: .4s;
        }
        /*sliders css*/
        .slider-left-content h1 {
            color: #4B77BE;
            font-size: 1.5rem;
            font-weight: bold;
            margin-bottom: 50px;
        }
        .slider-left-content p {
            margin-bottom: 45px;
        }
        .slider-left-content a {
            background: #4B77BE;
            padding: 15px 25px;
            color: #fff;
            border: 1px solid #4B77BE;
            letter-spacing: 2px;
            transition: .4s;
        }
        .slider-left-content a:hover {
            background: #4c4c4c;
            border: 1px solid #4c4c4c;
            transition: .4s;
        }

        .slider-right-content {
        }

        .slider-right-content img {
            float: right;
            height: 250px !important;
            width: 100% !important;
            margin-top: 30px;
        }

        .slider-previous-icon, .slider-next-icon{
            color: #080808;
        }
        .slider-previous-link, .slider-next-link{
            width: 8% !important;
        }

        .about-us-section {
            background: #ffffff;
        }

        section {
            padding: 90px 0;
        }

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
            background-color: #4B77BE;
        }

        .section-heading:before {
            position: absolute;
            content: "";
            left: 50%;
            top: 37px;
            height: 1px;
            width: 90px;
            margin-left: -50px;
        }

        .section-heading:after {
            background-color: #4B77BE;
        }

        .section-heading:after {
            position: absolute;
            content: "";
            left: 50%;
            top: 35px;
            height: 5px;
            width: 40px;
            margin-left: -25px;
            border-radius: 4px;
        }

        .template-space {
            min-height: 20px;
        }

        h2.para-heading {
            text-transform: uppercase;
            font-size: 1.2rem;
            margin: 0 0 25px;
            font-weight: bold;
            letter-spacing: 0.5pt;
            color: #4B77BE;
        }

        ul.sidebar-list {
            padding: 0 0 0 10px;
        }

        .sidebar-list li {
            list-style: none;
            font-size: 1rem;
        }

        .sidebar-list li:before {
            color: #4B77BE;
        }

        .sidebar-list li i {
            /*color: #4B77BE;*/
            color: #4B77BE;
        }

        .notice-portlet {

        }

        .notice-portlet-title {
            border-radius: 5px 5px 0 0 !important;
            background: #4b77be;
            padding: 10px 15px;
            width: 100%;
        }

        .portlet-body {
            padding: 10px 15px;
            border-radius: 0 0 8px 8px !important;
            border: 1px solid #4b77be;
        }

        .banner-section {
            background: #ffffff;
            padding: 90px 0 0 0;
        }
        .banner-bar {
            border: 1px solid #eee;
            padding: 10px 15px;
            text-align: center;
            border-radius: 3px;
            margin: 0 10px;
            background: #fcfcfc;
            transition: .4s;
            cursor: pointer;
        }
        .banner-bar:hover{
            background: #ececec;
            transition: .4s;
        }

        .banner-bar img {
            height: 60px;
            padding: 15px;
        }

        .banner-bar h3 {
            color: #4B77BE;
        }

        .banner-bar h3 span {
            font-size: 1rem;
            font-weight: bold;
        }

        .banner-bar p {
            line-height: 30px;
            font-size: 1rem;
            color: #4c4c4ce8;
        }

        .profile-box {
            border: 1px solid #eee;
            padding: 30px 15px;
            background: #ffffff;
            text-align: center;
            cursor: pointer;
            transition: .4s;
            margin-bottom: 10px;
        }

        .profile-box:hover {
            padding: 25px 15px 25px;
            box-shadow: 0px 0px 20px #bbb;
        }

        .profile-box img {
            height: 50px;
            margin-bottom: 10px;
        }

        .profile-box h4 {
            line-height: 25px;
            font-size: 1.1rem;
            margin-top: 10px;
            min-height: 51px;
        }

        .profile-box h4 span {
            color: #4B77BE;
        }

        .article-box {
            padding: 10px 15px;
            cursor: pointer;
        }

        .article-box article {
            border: 1px solid #f0f0f0;
        }

        .news-post {
            position: relative;
            overflow: hidden;
        }

        .news-post .img-box {
            height: 260px;
            transition: .4s;
        }

        .news-post:hover{
            /*padding: 25px 15px 25px;*/
            box-shadow: 0px 0px 20px #bbb;
            transition: .4s;
        }

        .news-post .img-box span {
            position: absolute;
            background: #4B77BE;
            padding: 6px 20px;
            color: white;
            font-size: 1.1rem;
            font-weight: bold;
            letter-spacing: 2px;
        }

        .news-post .img-box span a {
        }

        .news-post .img-box span a img {
        }

        .news-post .post-content-text {
            height: 150px;
            width: 100%;
            background: #000000b3;
            color: white;
            text-align: center;
            padding: 10px 15px 0 15px;
            position: absolute;
            left: 0;
            bottom: -58px;
            transition: .4s;
        }

        .article-box:hover .news-post .post-content-text {
            transition: .4s;
            bottom: 0px;
        }

        .news-post .post-content-text h4 {
            font-size: 1rem;
        }

        .news-post .post-content-text h4 span {
            line-height: 25px;
            display: block;
            height: 47px;
            overflow: hidden;
        }

        .news-post .post-content-text h4 i {
            color: white;
            padding: 0 5px;
        }

        .news-post .post-more {
            margin-top: 20px;
        }

        .news-post .post-more a {
            padding: 5px 20px;
            color: #fff;
            background: #4B77BE;
            font-size: .8rem;
            transition: .5s;
        }

        .news-post .post-more a:hover {
            background: #3663ac;
            transition: .5s;
        }

        .service-box-button {
            background: #4B77BE;
            color: white;
            padding: 10px 25px;
            display: inline-block;
            margin: 30px 0 0 0;
            transition: .4s;
        }

        .service-box-button:hover {
            background: #383838;
            color: white;
            transition: .4s;
        }

        .aside-cta {
            background: #1c397b;
            padding: 25px 0;
        }

        .aside-cta h3 {
            font-size: 1.2rem;
            margin-right: 30%;
        }

        .purchase-button {
        }

        .email-submit {
            background: #e2e2e2;
            padding: 5px 10px;
            border: 1px solid #e2e2e2;
            border-radius: 3px;
        }

        .email-submit:focus {
            border: 1px solid #e2e2e2;
            outline: none;
        }

        .submit-btn {
            background: #4B77BE;
            padding: 5px 15px;
            border: 1px solid #4B77BE;
            border-radius: 3px;
            color: #fff;
            transition: .4s;
        }

        .submit-btn:hover {
            background: #242724;
            border: 1px solid #242724;
            transition: .4s;
        }
        /*.submit-btn:disabled {
            cursor: not-allowed;
        }*/

        .footer-item {
            line-height: 30px;
        }

        .main-footer {
            padding: 50px 0 50px 0;
            background: #ffffff;
        }

        .footer-widget {
        }

        .footer-widget img {
        }

        .footer-widget p {
            margin-top: 10px;
            font-size: 1rem;
        }

        .footer-widget span {
            display: block;
            margin: 30px 0;
        }

        .footer-widget span a {
            background: #4B77BE;
            padding: 10px 30px;
            color: #fff;
            border-radius: 5px;
            border: 1px solid #4B77BE;
            transition: .4s;
        }

        .footer-widget span a:hover {
            background: #383838;
            border: 1px solid #383838;
            transition: .4s;
        }

        .footer-item {
        }

        .footer-widget-address {
        }

        .footer-widget-address h3 {
            color: #4B77BE;
            font-size: 1.1rem;
            font-weight: bold;
            margin-bottom: 30px;
        }

        .footer-widget-address p {
            float: left;
            width: 100%;
        }

        .footer-widget-address p i {
            color: #4B77BE;
            float: left;
            padding: 8px 10px 0 0;
        }

        .footer-widget-address p span {
            float: left;
        }

        .footer-widget-quick-links {
        }

        .footer-widget-quick-links h3 {
            color: #4B77BE;
            font-size: 1.1rem;
            font-weight: bold;
        }

        .footer-widget-quick-links ul {
            list-style: none;
            column-count: 2;
            font-size: 1rem;
            color: #4B77BE;
            margin-top: 30px;
        }

        .footer-widget-quick-links ul li {
            line-height: 37px;
        }

        .footer-widget-quick-links ul li i {
            margin-right: 5px;
        }

        .footer-widget-quick-links ul li a {
            color: #555;
            transition: .4s;
        }

        .footer-widget-quick-links ul li a:hover {
            color: #4B77BE;
            transition: .4s;
        }

        .footer-2 {
            background: #eeeeee;
            padding: 25px 0;
        }

        .footer-2 h3 {
            font-size: 1rem;
            color: #6a6565;
            font-weight: bold;
        }

        .footer-2 img {
            height: 50px;
        }
        .footer-email{
            color: #869099;
        }

        /*--------Back to top css--------*/
        .back-to-top {
            position: fixed;
            bottom: 25px;
            right: 25px;
            display: none;
            background: #4B77BE;
            border: 1px solid #4B77BE;
            color: #fff;
        }

        .input-group-text-border{
            border: 2px solid #ddf1ff;
            background: #f2f7f8 !important;
        }
        .form-submit-btn{
            background: #4B77BE;
            border: 1px solid #4B77BE;
            transition: .4s;
        }
        .form-submit-btn:hover{
            background: #383b38;
            border: 1px solid #383b38;
            transition: .4s;
        }
        .form-area{
            border-radius: 10px;
        }
        .form-area i{
            color: #4B77BE;
        }


    </style>
    <style>
        @media screen and (max-width: 424px) {
            .navbar-brand{
                max-width: 70% !important;
                display: inline-block;
            }
            .navbar-brand img{
                width: 100%;
            }
        }
    </style>
    @stack('css')
</head>
<body class="hold-transition skin-blue sidebar-collapse">
<div class="wrapper">
    @yield('header', \Illuminate\Support\Facades\View::make('master::.layouts.partials.custom1.header'))
    @yield('full_page_content')

    @sectionMissing('full_page_content')
        <div class="content-wrapper">
            @yield('content')
        </div>
    @endif

    @yield('footer', \Illuminate\Support\Facades\View::make('master::.layouts.partials.custom1.footer'))
</div>
<script src="{{asset('/js/app.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/overlayscrollbars/1.13.0/js/OverlayScrollbars.min.js"></script>
<script src="{{asset('/js/admin-lte.js')}}"></script>
<script src="{{asset('/js/on-demand.js')}}"></script>
<script>
    @if(\Illuminate\Support\Facades\Session::has('alerts'))
    let alerts = {!! json_encode(\Illuminate\Support\Facades\Session::get('alerts')) !!};
    helpers.displayAlerts(alerts, toastr);
    @endif

    @if(\Illuminate\Support\Facades\Session::has('message'))
    let alertType = {!! json_encode(\Illuminate\Support\Facades\Session::get('alert-type', 'info')) !!};
    let alertMessage = {!! json_encode(\Illuminate\Support\Facades\Session::get('message')) !!};
    let alerter = toastr[alertType];
    alerter ? alerter(alertMessage) : toastr.error("toastr alert-type " + alertType + " is unknown");
    @endif
</script>
@stack('js')
</body>
</html>
