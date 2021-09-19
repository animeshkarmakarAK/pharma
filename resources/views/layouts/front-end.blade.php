<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="csrf-token" content="{{csrf_token()}}"/>

    <title>{{'NISE3'}} - @yield('title', 'TMS')</title>

    <!-- Bootstrap v4 with admin-lte v3 -->
    <link rel="stylesheet" href="{{asset('/css/app.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/overlayscrollbars/1.13.0/css/OverlayScrollbars.min.css">

    <style>
        /*new style start*/
        .menu-bg-color{
            background: #671688;
            padding: 0;
        }
        .menu-bg-color li a{
            color: #fff;
            padding: 10px 15px;
            border-radius: unset;
            transition: .5s;
        }
        .menu-bg-color li a:hover{
            background: #9c36c6;
            border-radius: unset;
            color: #FFFFFF;
            transition: .5s;
        }
        .navbar-right li a:hover{
            background: #E67E22;
            border-radius: unset;
            color: #FFFFFF;
            transition: .5s;
        }
        /*new style end*/

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
            color: #9c36c6;
            transition: .4s;
        }

        .main-menu-right li a:hover {
            color: #9c36c6;
            transition: .4s;
        }

        /*sliders css*/
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
            background: #9c36c6;
            padding: 15px 25px;
            color: #fff;
            border: 1px solid #9c36c6;
            border-radius: 5px;
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
            height: 135px !important;
            width: 100% !important;
            margin-top: 150px;
        }

        .slider-previous-icon, .slider-next-icon {
            border: 1px solid #6C6B76;
            padding: 12px;
            border-radius: 50%;
        }
        .slider-previous-icon i, .slider-next-icon i {
            display: block;
            width: 10px;
            color: #6C6B76;
            font-size: 10px;
        }


        .slider-previous-link, .slider-next-link {
            width: 8% !important;
        }

        .player-icon{
            position: absolute !important;
            left: 45%;
            top: 45%;
            font-size: 35px;
            color: #65546B;
            z-index: 99999;
        }


        section {
            padding: 30px 0;
        }

        .custom-btn{
            background: #9c36c6;
            padding: 10px 30px;
            color: #fff;
            border-radius: 5px;
            border: 1px solid #9c36c6;
            transition: .4s;
        }
        .custom-btn:hover{
            background: #383838;
            border: 1px solid #383838;
            transition: .4s;
            color: #fff;
        }

        h2.para-heading {
            text-transform: uppercase;
            font-size: 1.2rem;
            margin: 0 0 25px;
            font-weight: bold;
            letter-spacing: 0.5pt;
            color: #9c36c6;
        }

        ul.sidebar-list {
            padding: 0 0 0 10px;
        }

        .sidebar-list li {
            list-style: none;
            font-size: 1rem;
        }

        .sidebar-list li:before {
            color: #9c36c6;
        }

        .sidebar-list li i {
            /*color: #9c36c6;*/
            color: #9c36c6;
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

        .banner-bar:hover {
            background: #ececec;
            transition: .4s;
        }

        .banner-bar img {
            height: 80px;
            padding-bottom: 15px;
        }

        .banner-bar h3 {
            color: #9c36c6;
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

        .instant-view-box {
            padding: 15px;
            background: #ffffff;
            text-align: center;
            cursor: pointer;
            transition: .4s;
            margin-bottom: 10px;
            box-shadow: -5px 0 5px -5px #33333391, 5px 7px 5px -5px #33333391;
            border-radius: 10px;
            overflow: hidden;
        }
        .instant-view-box .custom-icon{
            color: #9c36c6;

        }

        .instant-view-box:hover {
            box-shadow: 0 0 20px #bbb;
        }

        .article-box {
            padding: 10px 15px;
            cursor: pointer;
        }

        .article-box article {
        }

        .news-post {
            position: relative;
            overflow: hidden;
        }

        .news-post .img-box {
            height: 260px;
            transition: .4s;
        }

        .news-post:hover {
            /*padding: 25px 15px 25px;*/
            box-shadow: 0 0 20px #bbb;
            transition: .4s;
        }

        .news-post .img-box span {
            position: absolute;
            background: #9c36c6;
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
            bottom: 0;
        }

        .news-post .post-content-text h4 {
            font-size: 1rem;
        }

        .news-post .post-content-text h4 span {
            line-height: 25px;
            color: #9c36c6;
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
            background: #9c36c6;
            font-size: .8rem;
            transition: .5s;
        }

        .news-post .post-more a:hover {
            background: #3e9241;
            transition: .5s;
        }

        .service-box-button {
            background: #9c36c6;
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
            background: #9c36c6;
            padding: 5px 15px;
            border: 1px solid #9c36c6;
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
            background: #9c36c6;
            padding: 10px 30px;
            color: #fff;
            border-radius: 5px;
            border: 1px solid #9c36c6;
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
            color: #9c36c6;
            font-size: 1.1rem;
            font-weight: bold;
            margin-bottom: 30px;
        }

        .footer-widget-address p {
            float: left;
            width: 100%;
        }

        .footer-widget-address p i {
            color: #9c36c6;
            float: left;
            padding: 8px 10px 0 0;
        }

        .footer-widget-address p span {
            float: left;
        }

        .footer-widget-quick-links {
        }

        .footer-widget-quick-links h3 {
            color: #9c36c6;
            font-size: 1.1rem;
            font-weight: bold;
        }

        .footer-widget-quick-links ul {
            list-style: none;
            column-count: 2;
            font-size: 1rem;
            color: #9c36c6;
            margin-top: 30px;
            padding-left: 0;
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
            color: #9c36c6;
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

        /*--------Back to top css--------*/
        .back-to-top {
            position: fixed;
            bottom: 25px;
            right: 25px;
            display: none;
            background: #9c36c6;
            border: 1px solid #9c36c6;
            color: #fff;
        }

        .input-group-text-border {
            border: 2px solid #ddf1ff;
            background: #f2f7f8 !important;
        }

        .form-submit-btn {
            background: #9c36c6;
            border: 1px solid #9c36c6;
            transition: .4s;
        }

        .form-submit-btn:hover {
            background: #383b38;
            border: 1px solid #383b38;
            transition: .4s;
        }

        .form-area {
            border-radius: 10px;
        }

        .form-area i {
            color: #9c36c6;
        }

    </style>
    @stack('css')
</head>
<body class="hold-transition skin-blue sidebar-collapse">
<div class="wrapper">
    @yield('header', \Illuminate\Support\Facades\View::make('master::layouts.partials.front-end.header'))
    @yield('full_page_content')

    @sectionMissing('full_page_content')
        <div class="content-wrapper" style="padding-top: 50px">
            @yield('content')
        </div>
    @endif

    @yield('footer', \Illuminate\Support\Facades\View::make('master::layouts.partials.front-end.footer'))
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
