@php
    $currentInstitute = domainConfig('institute');
    $layout = $currentInstitute ? 'master::layouts.custom1' : 'master::layouts.front-end';


@endphp
@extends($layout)

@section('content')

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header custom-bg-gradient-info">
                        <h1 class="text-center text-primary">কেন্দ্রের তালিকা সমূহ</h1>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <!-- BEGIN BORDERED TABLE PORTLET-->
                            <div class="portlet light bordered">

                                <div class="portlet-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <p><input class="form-control center-search" id="search_center"
                                                      placeholder="অনুসন্ধান">
                                            </p>
                                        </div>
                                        <div class="col-md-12">
                                            <ul class="center-list" id="center_list">
                                                <?php
                                                    $sl=0;
                                                ?>
                                                @foreach($publishedCourses as $publishedCourse)
                                                    <li style="list-style: none;">
                                                        <p>
                                                            {{ \App\Helpers\Classes\NumberToBanglaWord::engToBn(++$sl) }}) {{ $publishedCourse->trainingCenter? $publishedCourse->trainingCenter->title_bn.',':''}}
                                                        {{ $publishedCourse->branch? $publishedCourse->branch->title_bn.',':''}}
                                                        {{ $publishedCourse->institute? $publishedCourse->institute->title_bn: ''}}
                                                        </p>
                                                        <p class="personmobile">
                                                            {{ $publishedCourse->institute? $publishedCourse->institute->primary_mobile: ''}} </p>
                                                        <address>
                                                            <i>ঠিকানা :
                                                                <?php

                                                                if($publishedCourse->trainingCenter){
                                                                    echo $publishedCourse->trainingCenter->address;
                                                                }elseif ($publishedCourse->branch){
                                                                    echo $publishedCourse->branch->address;
                                                                }else{
                                                                    echo $publishedCourse->institute->address;
                                                                }

                                                                ?>
                                                                </i>
                                                        </address>
                                                        <hr>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- END BORDERED TABLE PORTLET-->
                            <script>
                                var centerListAsm = [{
                                    "title": "\u0989\u09aa-\u09aa\u09b0\u09bf\u099a\u09be\u09b2\u0995\u09c7\u09b0 \u0995\u09be\u09b0\u09cd\u09af\u09be\u09b2\u09df,  \u09e7\u09e8, \u0997\u099c\u09a8\u09ac\u09c0 \u09b0\u09cb\u09a1, \u09ae\u09cb\u09b9\u09be\u09ae\u09cd\u09ae\u09a6\u09aa\u09c1\u09b0, \u09a2\u09be\u0995\u09be",
                                    "address": "\u09e7\u09e8, \u0997\u099c\u09a8\u09ac\u09c0 \u09b0\u09cb\u09a1, \u09ae\u09cb\u09b9\u09be\u09ae\u09cd\u09ae\u09a6\u09aa\u09c1\u09b0, \u09a2\u09be\u0995\u09be",
                                    "contact_person": "",
                                    "mobile": "02-8128843 "
                                }, {
                                    "title": "\u0989\u09aa-\u09aa\u09b0\u09bf\u099a\u09be\u09b2\u0995\u09c7\u09b0 \u0995\u09be\u09b0\u09cd\u09af\u09be\u09b2\u09df  \u09af\u09c1\u09ac \u0989\u09a8\u09cd\u09a8\u09df\u09a8 \u0985\u09a7\u09bf\u09a6\u09aa\u09cd\u09a4\u09b0, \u09ac\u09c7\u09b2\u099f\u09bf\u09df\u09be, \u099c\u09be\u09ae\u09be\u09b2\u09aa\u09c1\u09b0\u0964",
                                    "address": " \u09ac\u09c7\u09b2\u099f\u09bf\u09df\u09be, \u099c\u09be\u09ae\u09be\u09b2\u09aa\u09c1\u09b0\u0964",
                                    "contact_person": "",
                                    "mobile": "0981-63668 "
                                }, {
                                    "title": "\u0989\u09aa-\u09aa\u09b0\u09bf\u099a\u09be\u09b2\u0995\u09c7\u09b0 \u0995\u09be\u09b0\u09cd\u09af\u09be\u09b2\u09df, \u09af\u09c1\u09ac \u0989\u09a8\u09cd\u09a8\u09df\u09a8 \u0985\u09a7\u09bf\u09a6\u09aa\u09cd\u09a4\u09b0,  \u09b8\u09be\u0995\u09c1\u09df\u09be, \u09a8\u09c7\u09a4\u09cd\u09b0\u0995\u09cb\u09a8\u09be\u0964",
                                    "address": "\u09b8\u09be\u0995\u09c1\u09df\u09be, \u09a8\u09c7\u09a4\u09cd\u09b0\u0995\u09cb\u09a8\u09be\u0964\r\n\r\n\r\n\r\n",
                                    "contact_person": "",
                                    "mobile": "0951-61841 "
                                }, {
                                    "title": "\u0989\u09aa-\u09aa\u09b0\u09bf\u099a\u09be\u09b2\u0995\u09c7\u09b0 \u0995\u09be\u09b0\u09cd\u09af\u09be\u09b2\u09df, \u09af\u09c1\u09ac \u0989\u09a8\u09cd\u09a8\u09df\u09a8 \u0985\u09a7\u09bf\u09a6\u09aa\u09cd\u09a4\u09b0,  \u09ae\u09a7\u09cd\u09af \u09ac\u09df\u09b0\u09be, \u09ad\u09be\u09a4\u09b6\u09be\u09b2\u09be, \u09b6\u09c7\u09b0\u09aa\u09c1\u09b0",
                                    "address": " \u09ad\u09be\u09a4\u09b6\u09be\u09b2\u09be, \u09b6\u09c7\u09b0\u09aa\u09c1\u09b0",
                                    "contact_person": "",
                                    "mobile": "0931-61612 "
                                }, {
                                    "title": "\u0989\u09aa-\u09aa\u09b0\u09bf\u099a\u09be\u09b2\u0995\u09c7\u09b0 \u0995\u09be\u09b0\u09cd\u09af\u09be\u09b2\u09df, \u09af\u09c1\u09ac \u0989\u09a8\u09cd\u09a8\u09df\u09a8 \u0985\u09a7\u09bf\u09a6\u09aa\u09cd\u09a4\u09b0,  \u09a6\u09cb\u09df\u09c7\u09b2 \u09ad\u09ac\u09a8 (\u09ea\u09b0\u09cd\u09a5 \u09a4\u09b2\u09be) \u09ac\u09be\u09b8\u09b7\u09cd\u099f\u09cd\u09af\u09be\u09a8\u09cd\u09a1 \u09b8\u0982\u09b2\u0997\u09cd\u09a8, \u09ae\u09be\u09a8\u09bf\u0995\u0997\u099e\u09cd\u099c\u0964",
                                    "address": "\u09a6\u09cb\u09df\u09c7\u09b2 \u09ad\u09ac\u09a8 (\u09ea\u09b0\u09cd\u09a5 \u09a4\u09b2\u09be) \u09ac\u09be\u09b8\u09b7\u09cd\u099f\u09cd\u09af\u09be\u09a8\u09cd\u09a1 \u09b8\u0982\u09b2\u0997\u09cd\u09a8, \u09ae\u09be\u09a8\u09bf\u0995\u0997\u099e\u09cd\u099c\u0964",
                                    "contact_person": "",
                                    "mobile": "0651-61703 "
                                }, {
                                    "title": "\u0989\u09aa-\u09aa\u09b0\u09bf\u099a\u09be\u09b2\u0995\u09c7\u09b0 \u0995\u09be\u09b0\u09cd\u09af\u09be\u09b2\u09df, \u09af\u09c1\u09ac \u0989\u09a8\u09cd\u09a8\u09df\u09a8 \u0985\u09a7\u09bf\u09a6\u09aa\u09cd\u09a4\u09b0 \u099a\u09bf\u09a8\u09bf\u09ae\u09aa\u09c1\u09b0, \u09a8\u09b0\u09b8\u09bf\u0982\u09a6\u09c0\u0964",
                                    "address": "\u09af\u09c1\u09ac \u0989\u09a8\u09cd\u09a8\u09df\u09a8 \u0985\u09a7\u09bf\u09a6\u09aa\u09cd\u09a4\u09b0 \u099a\u09bf\u09a8\u09bf\u09ae\u09aa\u09c1\u09b0, \u09a8\u09b0\u09b8\u09bf\u0982\u09a6\u09c0",
                                    "contact_person": "",
                                    "mobile": "0628-61274 "
                                }, {
                                    "title": "\u0989\u09aa-\u09aa\u09b0\u09bf\u099a\u09be\u09b2\u0995\u09c7\u09b0 \u0995\u09be\u09b0\u09cd\u09af\u09be\u09b2\u09df, \u09af\u09c1\u09ac \u0989\u09a8\u09cd\u09a8\u09df\u09a8 \u0985\u09a7\u09bf\u09a6\u09aa\u09cd\u09a4\u09b0,  \u09a5\u09be\u09a8\u09be\u09aa\u09be\u09dc\u09be \u09ad\u09be\u0982\u0997\u09be\u09b0 \u09ae\u09cb\u09dc, \u09ae\u09c1\u09a8\u09cd\u09b8\u09bf\u0997\u099e\u09cd\u099c\u0964 ",
                                    "address": "\u09a5\u09be\u09a8\u09be\u09aa\u09be\u09dc\u09be \u09ad\u09be\u0982\u0997\u09be\u09b0 \u09ae\u09cb\u09dc, \u09ae\u09c1\u09a8\u09cd\u09b8\u09bf\u0997\u099e\u09cd\u099c\u0964 \r\n",
                                    "contact_person": "",
                                    "mobile": "0651-61703 "
                                }, {
                                    "title": "\u0989\u09aa-\u09aa\u09b0\u09bf\u099a\u09be\u09b2\u0995\u09c7\u09b0 \u0995\u09be\u09b0\u09cd\u09af\u09be\u09b2\u09df, \u09af\u09c1\u09ac \u0989\u09a8\u09cd\u09a8\u09df\u09a8 \u0985\u09a7\u09bf\u09a6\u09aa\u09cd\u09a4\u09b0 \u09a8\u0997\u09b0 \u099c\u09be\u09b2\u09ab\u09c8, \u099f\u09be\u0982\u0997\u09be\u0987\u09b2",
                                    "address": "\u09a8\u0997\u09b0 \u099c\u09be\u09b2\u09ab\u09c8, \u099f\u09be\u0982\u0997\u09be\u0987\u09b2\r\n",
                                    "contact_person": "",
                                    "mobile": "0921-53337 "
                                }, {
                                    "title": "\u0989\u09aa-\u09aa\u09b0\u09bf\u099a\u09be\u09b2\u0995\u09c7\u09b0 \u0995\u09be\u09b0\u09cd\u09af\u09be\u09b2\u09df, \u09af\u09c1\u09ac \u0989\u09a8\u09cd\u09a8\u09df\u09a8 \u0985\u09a7\u09bf\u09a6\u09aa\u09cd\u09a4\u09b0 \u099c\u09c7\u09b2\u09be \u09aa\u09b0\u09bf\u09b7\u09a6 \u09ad\u09ac\u09a8, \u09ae\u09df\u09ae\u09a8\u09b8\u09bf\u0982\u09b9",
                                    "address": "\u09af\u09c1\u09ac \u0989\u09a8\u09cd\u09a8\u09df\u09a8 \u0985\u09a7\u09bf\u09a6\u09aa\u09cd\u09a4\u09b0 \u099c\u09c7\u09b2\u09be \u09aa\u09b0\u09bf\u09b7\u09a6 \u09ad\u09ac\u09a8, \u09ae\u09df\u09ae\u09a8\u09b8\u09bf\u0982\u09b9",
                                    "contact_person": "",
                                    "mobile": "01711235466"
                                }, {
                                    "title": "\u0989\u09aa-\u09aa\u09b0\u09bf\u099a\u09be\u09b2\u0995\u09c7\u09b0 \u0995\u09be\u09b0\u09cd\u09af\u09be\u09b2\u09df, \u09af\u09c1\u09ac \u0989\u09a8\u09cd\u09a8\u09df\u09a8 \u0985\u09a7\u09bf\u09a6\u09aa\u09cd\u09a4\u09b0 \u09b0\u09cd\u09aa\u09c2\u09ac \u0997\u0982\u0997\u09be\u09b0\u09cd\u09ac\u09a6\u09c0, \u09ab\u09b0\u09bf\u09a6\u09aa\u09c1\u09b0\u0964",
                                    "address": "\u09af\u09c1\u09ac \u0989\u09a8\u09cd\u09a8\u09df\u09a8 \u0985\u09a7\u09bf\u09a6\u09aa\u09cd\u09a4\u09b0 \u09b0\u09cd\u09aa\u09c2\u09ac \u0997\u0982\u0997\u09be\u09b0\u09cd\u09ac\u09a6\u09c0, \u09ab\u09b0\u09bf\u09a6\u09aa\u09c1\u09b0\u0964",
                                    "contact_person": "",
                                    "mobile": "0631-63421 "
                                }, {
                                    "title": "\u0989\u09aa-\u09aa\u09b0\u09bf\u099a\u09be\u09b2\u0995\u09c7\u09b0 \u0995\u09be\u09b0\u09cd\u09af\u09be\u09b2\u09df, \u09af\u09c1\u09ac \u0989\u09a8\u09cd\u09a8\u09df\u09a8 \u0985\u09a7\u09bf\u09a6\u09aa\u09cd\u09a4\u09b0, \u09e8\u09a8\u0982 \u09ac\u09c7\u09dc\u09be \u09ad\u09be\u0982\u0997\u09be \u09b8\u09dc\u0995, \u09b0\u09be\u099c\u09ac\u09be\u09dc\u09c0\u0964",
                                    "address": "\u09af\u09c1\u09ac \u0989\u09a8\u09cd\u09a8\u09df\u09a8 \u0985\u09a7\u09bf\u09a6\u09aa\u09cd\u09a4\u09b0, \u09e8\u09a8\u0982 \u09ac\u09c7\u09dc\u09be \u09ad\u09be\u0982\u0997\u09be \u09b8\u09dc\u0995, \u09b0\u09be\u099c\u09ac\u09be\u09dc\u09c0\u0964",
                                    "contact_person": "",
                                    "mobile": "0641-65569 "
                                }, {
                                    "title": "\u0989\u09aa-\u09aa\u09b0\u09bf\u099a\u09be\u09b2\u0995\u09c7\u09b0 \u0995\u09be\u09b0\u09cd\u09af\u09be\u09b2\u09df, \u09af\u09c1\u09ac \u0989\u09a8\u09cd\u09a8\u09df\u09a8 \u0985\u09a7\u09bf\u09a6\u09aa\u09cd\u09a4\u09b0,  \u0996\u09be\u0997\u09a6\u09c0, \u09ae\u09be\u09a6\u09be\u09b0\u09c0\u09aa\u09c1\u09b0\u0964",
                                    "address": "\u09af\u09c1\u09ac \u0989\u09a8\u09cd\u09a8\u09df\u09a8 \u0985\u09a7\u09bf\u09a6\u09aa\u09cd\u09a4\u09b0,  \u0996\u09be\u0997\u09a6\u09c0, \u09ae\u09be\u09a6\u09be\u09b0\u09c0\u09aa\u09c1\u09b0\u0964",
                                    "contact_person": "",
                                    "mobile": "0661-55465 "
                                }, {
                                    "title": "\u0989\u09aa-\u09aa\u09b0\u09bf\u099a\u09be\u09b2\u0995\u09c7\u09b0 \u0995\u09be\u09b0\u09cd\u09af\u09be\u09b2\u09df, \u09af\u09c1\u09ac \u0989\u09a8\u09cd\u09a8\u09df\u09a8 \u0985\u09a7\u09bf\u09a6\u09aa\u09cd\u09a4\u09b0, \u09ae\u09c7\u0987\u09a8 \u09b0\u09cb\u09a1, \u09b6\u09b0\u09c0\u09df\u09a4\u09aa\u09c1\u09b0",
                                    "address": "\u09af\u09c1\u09ac \u0989\u09a8\u09cd\u09a8\u09df\u09a8 \u0985\u09a7\u09bf\u09a6\u09aa\u09cd\u09a4\u09b0, \u09ae\u09c7\u0987\u09a8 \u09b0\u09cb\u09a1, \u09b6\u09b0\u09c0\u09df\u09a4\u09aa\u09c1\u09b0",
                                    "contact_person": "",
                                    "mobile": "0601-55723 "
                                }, {
                                    "title": "\u0989\u09aa-\u09aa\u09b0\u09bf\u099a\u09be\u09b2\u0995\u09c7\u09b0 \u0995\u09be\u09b0\u09cd\u09af\u09be\u09b2\u09df, \u09af\u09c1\u09ac \u0989\u09a8\u09cd\u09a8\u09df\u09a8 \u0985\u09a7\u09bf\u09a6\u09aa\u09cd\u09a4\u09b0 \u09b8\u09c1\u09b2\u09ad \u09ad\u09bf\u09b2\u09be, \u09e7\u09eb\u09e6, \u09aa\u09be\u099a\u09c1\u09dc\u09bf\u09df\u09be, \u0997\u09cb\u09aa\u09be\u09b2\u0997\u099e\u09cd\u099c",
                                    "address": "\u09b8\u09c1\u09b2\u09ad \u09ad\u09bf\u09b2\u09be, \u09e7\u09eb\u09e6, \u09aa\u09be\u099a\u09c1\u09dc\u09bf\u09df\u09be, \u0997\u09cb\u09aa\u09be\u09b2\u0997\u099e\u09cd\u099c",
                                    "contact_person": "",
                                    "mobile": "0668-55086 "
                                }, {
                                    "title": "\u0989\u09aa-\u09aa\u09b0\u09bf\u099a\u09be\u09b2\u0995\u09c7\u09b0 \u0995\u09be\u09b0\u09cd\u09af\u09be\u09b2\u09df, \u09af\u09c1\u09ac \u0989\u09a8\u09cd\u09a8\u09df\u09a8 \u0985\u09a7\u09bf\u09a6\u09aa\u09cd\u09a4\u09b0, \u099c\u09be\u09b2\u0995\u09c1\u09dc\u09bf, \u09a8\u09be\u09b0\u09be\u09df\u09a3\u0997\u099e\u09cd\u099c",
                                    "address": "\u09af\u09c1\u09ac \u0989\u09a8\u09cd\u09a8\u09df\u09a8 \u0985\u09a7\u09bf\u09a6\u09aa\u09cd\u09a4\u09b0, \u099c\u09be\u09b2\u0995\u09c1\u09dc\u09bf, \u09a8\u09be\u09b0\u09be\u09df\u09a3\u0997\u099e\u09cd\u099c",
                                    "contact_person": "",
                                    "mobile": "024-7696081"
                                }, {
                                    "title": "\u0989\u09aa-\u09aa\u09b0\u09bf\u099a\u09be\u09b2\u0995\u09c7\u09b0 \u0995\u09be\u09b0\u09cd\u09af\u09be\u09b2\u09df, \u09af\u09c1\u09ac \u0989\u09a8\u09cd\u09a8\u09df\u09a8 \u0985\u09a7\u09bf\u09a6\u09aa\u09cd\u09a4\u09b0, \u09ae\u09cb\u09b2\u09cd\u09b2\u09be\u09aa\u09be\u09dc\u09be, \u0995\u09bf\u09b6\u09cb\u09b0\u0997\u099e\u09cd\u099c\u0964",
                                    "address": "\u09af\u09c1\u09ac \u0989\u09a8\u09cd\u09a8\u09df\u09a8 \u0985\u09a7\u09bf\u09a6\u09aa\u09cd\u09a4\u09b0, \u09ae\u09cb\u09b2\u09cd\u09b2\u09be\u09aa\u09be\u09dc\u09be, \u0995\u09bf\u09b6\u09cb\u09b0\u0997\u099e\u09cd\u099c\u0964",
                                    "contact_person": "",
                                    "mobile": "01709330449"
                                }, {
                                    "title": "\u0989\u09aa-\u09aa\u09b0\u09bf\u099a\u09be\u09b2\u0995\u09c7\u09b0 \u0995\u09be\u09b0\u09cd\u09af\u09be\u09b2\u09df, \u09af\u09c1\u09ac \u0989\u09a8\u09cd\u09a8\u09df\u09a8 \u0985\u09a7\u09bf\u09a6\u09aa\u09cd\u09a4\u09b0 \u09b7\u09b7\u09cd\u09a0\u09c0\u09a4\u09b2\u09be, \u09b0\u09be\u099c\u09b6\u09be\u09b9\u09c0\u0964",
                                    "address": "\u09af\u09c1\u09ac \u0989\u09a8\u09cd\u09a8\u09df\u09a8 \u0985\u09a7\u09bf\u09a6\u09aa\u09cd\u09a4\u09b0 \u09b7\u09b7\u09cd\u09a0\u09c0\u09a4\u09b2\u09be, \u09b0\u09be\u099c\u09b6\u09be\u09b9\u09c0\u0964",
                                    "contact_person": "",
                                    "mobile": "0721-772604"
                                }, {
                                    "title": "\u0989\u09aa-\u09aa\u09b0\u09bf\u099a\u09be\u09b2\u0995\u09c7\u09b0 \u0995\u09be\u09b0\u09cd\u09af\u09be\u09b2\u09df, \u09af\u09c1\u09ac \u0989\u09a8\u09cd\u09a8\u09df\u09a8 \u0985\u09a7\u09bf\u09a6\u09aa\u09cd\u09a4\u09b0 \u09ae\u09b6\u09b0\u09aa\u09c1\u09b0, \u09a8\u0993\u0997\u09be\u0981\u0964",
                                    "address": "\u09af\u09c1\u09ac \u0989\u09a8\u09cd\u09a8\u09df\u09a8 \u0985\u09a7\u09bf\u09a6\u09aa\u09cd\u09a4\u09b0 \u09ae\u09b6\u09b0\u09aa\u09c1\u09b0, \u09a8\u0993\u0997\u09be\u0981\u0964",
                                    "contact_person": "",
                                    "mobile": "01718213986"
                                }, {
                                    "title": "\u0989\u09aa-\u09aa\u09b0\u09bf\u099a\u09be\u09b2\u0995\u09c7\u09b0 \u0995\u09be\u09b0\u09cd\u09af\u09be\u09b2\u09df, \u09af\u09c1\u09ac \u0989\u09a8\u09cd\u09a8\u09df\u09a8 \u0985\u09a7\u09bf\u09a6\u09aa\u09cd\u09a4\u09b0,  \u099a\u0995\u09b0\u09be\u09ae\u09aa\u09c1\u09b0, \u09a8\u09be\u099f\u09cb\u09b0\u0964",
                                    "address": " \u09af\u09c1\u09ac \u0989\u09a8\u09cd\u09a8\u09df\u09a8 \u0985\u09a7\u09bf\u09a6\u09aa\u09cd\u09a4\u09b0,  \u099a\u0995\u09b0\u09be\u09ae\u09aa\u09c1\u09b0, \u09a8\u09be\u099f\u09cb\u09b0\u0964",
                                    "contact_person": "",
                                    "mobile": "0771-66669 "
                                }, {
                                    "title": "\u0989\u09aa-\u09aa\u09b0\u09bf\u099a\u09be\u09b2\u0995\u09c7\u09b0 \u0995\u09be\u09b0\u09cd\u09af\u09be\u09b2\u09df, \u09af\u09c1\u09ac \u0989\u09a8\u09cd\u09a8\u09df\u09a8 \u0985\u09a7\u09bf\u09a6\u09aa\u09cd\u09a4\u09b0, \u09ac\u09be\u0982\u09b2\u09be\u09a6\u09c7\u09b6 \u09ac\u09cd\u09af\u09be\u0982\u0995 \u09ae\u09cb\u09dc, \u09a7\u09be\u09aa, \u09b0\u0982\u09aa\u09c1\u09b0\u0964",
                                    "address": "\u09ac\u09be\u0982\u09b2\u09be\u09a6\u09c7\u09b6 \u09ac\u09cd\u09af\u09be\u0982\u0995 \u09ae\u09cb\u09dc, \u09a7\u09be\u09aa, \u09b0\u0982\u09aa\u09c1\u09b0\u0964",
                                    "contact_person": "",
                                    "mobile": "0521-62506 "
                                }, {
                                    "title": "\u0989\u09aa-\u09aa\u09b0\u09bf\u099a\u09be\u09b2\u0995\u09c7\u09b0 \u0995\u09be\u09b0\u09cd\u09af\u09be\u09b2\u09df, \u09af\u09c1\u09ac \u0989\u09a8\u09cd\u09a8\u09df\u09a8 \u0985\u09a7\u09bf\u09a6\u09aa\u09cd\u09a4\u09b0, \u099a\u09be\u09aa\u09be\u0987\u09a8\u09ac\u09be\u09ac\u0997\u099e\u09cd\u099c, \u09b0\u09be\u099c\u09b6\u09be\u09b9\u09c0\u0964",
                                    "address": "\u099a\u09be\u09aa\u09be\u0987\u09a8\u09ac\u09be\u09ac\u0997\u099e\u09cd\u099c, \u09b0\u09be\u099c\u09b6\u09be\u09b9\u09c0\u0964\r\n",
                                    "contact_person": "",
                                    "mobile": "0781-55709 "
                                }, {
                                    "title": "\u0989\u09aa-\u09aa\u09b0\u09bf\u099a\u09be\u09b2\u0995\u09c7\u09b0 \u0995\u09be\u09b0\u09cd\u09af\u09be\u09b2\u09df, \u09af\u09c1\u09ac \u0989\u09a8\u09cd\u09a8\u09df\u09a8 \u0985\u09a7\u09bf\u09a6\u09aa\u09cd\u09a4\u09b0,  \u09b9\u09be\u09b8\u09aa\u09be\u09a4\u09be\u09b2 \u09b0\u09cb\u09a1, \u09a8\u09c0\u09b2\u09ab\u09be\u09ae\u09be\u09b0\u09c0\u0964",
                                    "address": "  \u09b9\u09be\u09b8\u09aa\u09be\u09a4\u09be\u09b2 \u09b0\u09cb\u09a1, \u09a8\u09c0\u09b2\u09ab\u09be\u09ae\u09be\u09b0\u09c0\u0964",
                                    "contact_person": "",
                                    "mobile": "0551-61640 "
                                }, {
                                    "title": "\u0989\u09aa-\u09aa\u09b0\u09bf\u099a\u09be\u09b2\u0995\u09c7\u09b0 \u0995\u09be\u09b0\u09cd\u09af\u09be\u09b2\u09df, \u09af\u09c1\u09ac \u0989\u09a8\u09cd\u09a8\u09df\u09a8 \u0985\u09a7\u09bf\u09a6\u09aa\u09cd\u09a4\u09b0,  \u098f\u09df\u09be\u09b0\u09aa\u09cb\u09b0\u09cd\u099f \u09b0\u09cb\u09a1, \u09b2\u09be\u09b2\u09ae\u09a8\u09bf\u09b0\u09b9\u09be\u099f\u0964",
                                    "address": "\u098f\u09df\u09be\u09b0\u09aa\u09cb\u09b0\u09cd\u099f \u09b0\u09cb\u09a1, \u09b2\u09be\u09b2\u09ae\u09a8\u09bf\u09b0\u09b9\u09be\u099f\u0964",
                                    "contact_person": "",
                                    "mobile": "0591-61579 "
                                }, {
                                    "title": "\u0989\u09aa-\u09aa\u09b0\u09bf\u099a\u09be\u09b2\u0995\u09c7\u09b0 \u0995\u09be\u09b0\u09cd\u09af\u09be\u09b2\u09df, \u09af\u09c1\u09ac \u0989\u09a8\u09cd\u09a8\u09df\u09a8 \u0985\u09a7\u09bf\u09a6\u09aa\u09cd\u09a4\u09b0 \u0995\u09ae\u09b0\u09aa\u09c1\u09b0 \u09a4\u09c1\u09b2\u09b6\u09c0\u0998\u09be\u099f, \u0997\u09be\u0987\u09ac\u09be\u09a8\u09cd\u09a7\u09be\u0964",
                                    "address": "\u09af\u09c1\u09ac \u0989\u09a8\u09cd\u09a8\u09df\u09a8 \u0985\u09a7\u09bf\u09a6\u09aa\u09cd\u09a4\u09b0 \u0995\u09ae\u09b0\u09aa\u09c1\u09b0 \u09a4\u09c1\u09b2\u09b6\u09c0\u0998\u09be\u099f, \u0997\u09be\u0987\u09ac\u09be\u09a8\u09cd\u09a7\u09be\u0964",
                                    "contact_person": "",
                                    "mobile": "0541-61728 "
                                }, {
                                    "title": "\u0989\u09aa-\u09aa\u09b0\u09bf\u099a\u09be\u09b2\u0995\u09c7\u09b0 \u0995\u09be\u09b0\u09cd\u09af\u09be\u09b2\u09df, \u09af\u09c1\u09ac \u0989\u09a8\u09cd\u09a8\u09df\u09a8 \u0985\u09a7\u09bf\u09a6\u09aa\u09cd\u09a4\u09b0, \u099a\u0995\u09b6\u09bf\u09df\u09be\u09b2\u0995\u09cb\u09b2, \u09b8\u09bf\u09b0\u09be\u099c\u0997\u099e\u09cd\u099c",
                                    "address": "\u09af\u09c1\u09ac \u0989\u09a8\u09cd\u09a8\u09df\u09a8 \u0985\u09a7\u09bf\u09a6\u09aa\u09cd\u09a4\u09b0, \u099a\u0995\u09b6\u09bf\u09df\u09be\u09b2\u0995\u09cb\u09b2, \u09b8\u09bf\u09b0\u09be\u099c\u0997\u099e\u09cd\u099c",
                                    "contact_person": "",
                                    "mobile": "0751-62135 "
                                }, {
                                    "title": "\u0989\u09aa-\u09aa\u09b0\u09bf\u099a\u09be\u09b2\u0995\u09c7\u09b0 \u0995\u09be\u09b0\u09cd\u09af\u09be\u09b2\u09df, \u09af\u09c1\u09ac \u0989\u09a8\u09cd\u09a8\u09df\u09a8 \u0985\u09a7\u09bf\u09a6\u09aa\u09cd\u09a4\u09b0,  \u09b9\u09be\u09a8\u09be\u0987\u09b2, \u099c\u09df\u09aa\u09c1\u09b0\u09b9\u09be\u099f\u0964",
                                    "address": " \u09b9\u09be\u09a8\u09be\u0987\u09b2, \u099c\u09df\u09aa\u09c1\u09b0\u09b9\u09be\u099f\u0964",
                                    "contact_person": "",
                                    "mobile": "05723-56036"
                                }, {
                                    "title": "\u0989\u09aa-\u09aa\u09b0\u09bf\u099a\u09be\u09b2\u0995\u09c7\u09b0 \u0995\u09be\u09b0\u09cd\u09af\u09be\u09b2\u09df, \u09af\u09c1\u09ac \u0989\u09a8\u09cd\u09a8\u09df\u09a8 \u0985\u09a7\u09bf\u09a6\u09aa\u09cd\u09a4\u09b0, \u099c\u0997\u09a8\u09cd\u09a8\u09be\u09a5\u09aa\u09c1\u09b0, \u09a0\u09be\u0995\u09c1\u09b0\u0997\u09be\u0981\u0993\u0964",
                                    "address": "\u099c\u0997\u09a8\u09cd\u09a8\u09be\u09a5\u09aa\u09c1\u09b0, \u09a0\u09be\u0995\u09c1\u09b0\u0997\u09be\u0981\u0993\u0964",
                                    "contact_person": "",
                                    "mobile": "0561-52160 "
                                }, {
                                    "title": "\u0989\u09aa-\u09aa\u09b0\u09bf\u099a\u09be\u09b2\u0995\u09c7\u09b0 \u0995\u09be\u09b0\u09cd\u09af\u09be\u09b2\u09df, \u09af\u09c1\u09ac \u0989\u09a8\u09cd\u09a8\u09df\u09a8 \u0985\u09a7\u09bf\u09a6\u09aa\u09cd\u09a4\u09b0,  \u09ec\u09ef\u09ec, \u09b8\u09c1\u09b2\u09a4\u09be\u09a8\u09aa\u09c1\u09b0, \u09ae\u09cc\u09b2\u09ad\u09c0\u09ac\u09be\u099c\u09be\u09b0\u0964",
                                    "address": " \u09ec\u09ef\u09ec, \u09b8\u09c1\u09b2\u09a4\u09be\u09a8\u09aa\u09c1\u09b0, \u09ae\u09cc\u09b2\u09ad\u09c0\u09ac\u09be\u099c\u09be\u09b0\u0964",
                                    "contact_person": "",
                                    "mobile": "0861-53542 "
                                }, {
                                    "title": "\u0989\u09aa-\u09aa\u09b0\u09bf\u099a\u09be\u09b2\u0995\u09c7\u09b0 \u0995\u09be\u09b0\u09cd\u09af\u09be\u09b2\u09df, \u09af\u09c1\u09ac \u0989\u09a8\u09cd\u09a8\u09df\u09a8 \u0985\u09a7\u09bf\u09a6\u09aa\u09cd\u09a4\u09b0 \u099f\u09bf\u09b2\u09be\u0998\u09b0, \u09b8\u09bf\u09b2\u09c7\u099f\u0964",
                                    "address": "\u09af\u09c1\u09ac \u0989\u09a8\u09cd\u09a8\u09df\u09a8 \u0985\u09a7\u09bf\u09a6\u09aa\u09cd\u09a4\u09b0 \u099f\u09bf\u09b2\u09be\u0998\u09b0, \u09b8\u09bf\u09b2\u09c7\u099f\u0964",
                                    "contact_person": "",
                                    "mobile": "0821-716443"
                                }, {
                                    "title": "\u0989\u09aa-\u09aa\u09b0\u09bf\u099a\u09be\u09b2\u0995\u09c7\u09b0 \u0995\u09be\u09b0\u09cd\u09af\u09be\u09b2\u09df, \u09af\u09c1\u09ac \u0989\u09a8\u09cd\u09a8\u09df\u09a8 \u0985\u09a7\u09bf\u09a6\u09aa\u09cd\u09a4\u09b0 \u09af\u09c1\u09ac \u09ad\u09ac\u09a8, \u0997\u09c1\u09aa\u09be\u09df\u09be, \u09b9\u09ac\u09bf\u0997\u099e\u09cd\u099c",
                                    "address": "\u09af\u09c1\u09ac \u0989\u09a8\u09cd\u09a8\u09df\u09a8 \u0985\u09a7\u09bf\u09a6\u09aa\u09cd\u09a4\u09b0 \u09af\u09c1\u09ac \u09ad\u09ac\u09a8, \u0997\u09c1\u09aa\u09be\u09df\u09be, \u09b9\u09ac\u09bf\u0997\u099e\u09cd\u099c",
                                    "contact_person": "",
                                    "mobile": "0831-52514 "
                                }, {
                                    "title": "\u0989\u09aa-\u09aa\u09b0\u09bf\u099a\u09be\u09b2\u0995\u09c7\u09b0 \u0995\u09be\u09b0\u09cd\u09af\u09be\u09b2\u09df, \u09af\u09c1\u09ac \u0989\u09a8\u09cd\u09a8\u09df\u09a8 \u0985\u09a7\u09bf\u09a6\u09aa\u09cd\u09a4\u09b0, \u09a6\u0983 \u0986\u09b2\u09c7\u0995\u09be\u09a8\u09cd\u09a6\u09be, \u09ac\u09be\u0982\u09b2\u09be\u09ac\u09be\u099c\u09be\u09b0, \u09ac\u09b0\u09bf\u09b6\u09be\u09b2\u0964 ",
                                    "address": "\u09ac\u09be\u0982\u09b2\u09be\u09ac\u09be\u099c\u09be\u09b0, \u09ac\u09b0\u09bf\u09b6\u09be\u09b2\u0964 ",
                                    "contact_person": "",
                                    "mobile": "04328-63632"
                                }, {
                                    "title": "\u0989\u09aa-\u09aa\u09b0\u09bf\u099a\u09be\u09b2\u0995\u09c7\u09b0 \u0995\u09be\u09b0\u09cd\u09af\u09be\u09b2\u09df, \u09af\u09c1\u09ac \u0989\u09a8\u09cd\u09a8\u09df\u09a8 \u0985\u09a7\u09bf\u09a6\u09aa\u09cd\u09a4\u09b0 \u0995\u09be\u09b2\u09c0\u09a8\u09be\u09a5 \u09b0\u09be\u09df\u09c7\u09b0 \u09ac\u09be\u099c\u09be\u09b0, \u09ad\u09cb\u09b2\u09be",
                                    "address": "\u09af\u09c1\u09ac \u0989\u09a8\u09cd\u09a8\u09df\u09a8 \u0985\u09a7\u09bf\u09a6\u09aa\u09cd\u09a4\u09b0 \u0995\u09be\u09b2\u09c0\u09a8\u09be\u09a5 \u09b0\u09be\u09df\u09c7\u09b0 \u09ac\u09be\u099c\u09be\u09b0, \u09ad\u09cb\u09b2\u09be",
                                    "contact_person": "",
                                    "mobile": "0491-61197 "
                                }, {
                                    "title": "\u0989\u09aa-\u09aa\u09b0\u09bf\u099a\u09be\u09b2\u0995\u09c7\u09b0 \u0995\u09be\u09b0\u09cd\u09af\u09be\u09b2\u09df, \u09af\u09c1\u09ac \u0989\u09a8\u09cd\u09a8\u09df\u09a8 \u0985\u09a7\u09bf\u09a6\u09aa\u09cd\u09a4\u09b0 \u09ac\u09be\u0987\u09aa\u09be\u0987\u09b2 \u09b8\u09dc\u0995, \u09ae\u09be\u099b\u09ae\u09bf\u09aa\u09c1\u09b0, \u09aa\u09bf\u09b0\u09cb\u099c\u09aa\u09c1\u09b0",
                                    "address": "\u09af\u09c1\u09ac \u0989\u09a8\u09cd\u09a8\u09df\u09a8 \u0985\u09a7\u09bf\u09a6\u09aa\u09cd\u09a4\u09b0 \u09ac\u09be\u0987\u09aa\u09be\u0987\u09b2 \u09b8\u09dc\u0995, \u09ae\u09be\u099b\u09ae\u09bf\u09aa\u09c1\u09b0, \u09aa\u09bf\u09b0\u09cb\u099c\u09aa\u09c1\u09b0",
                                    "contact_person": "",
                                    "mobile": "0461-62500 "
                                }, {
                                    "title": "\u0989\u09aa-\u09aa\u09b0\u09bf\u099a\u09be\u09b2\u0995\u09c7\u09b0 \u0995\u09be\u09b0\u09cd\u09af\u09be\u09b2\u09df, \u09af\u09c1\u09ac \u0989\u09a8\u09cd\u09a8\u09df\u09a8 \u0985\u09a7\u09bf\u09a6\u09aa\u09cd\u09a4\u09b0, \u09ac\u09be\u09b8\u09a8\u09cd\u09a1\u09be, \u099d\u09be\u09b2\u0995\u09be\u09a0\u09bf",
                                    "address": "\u09af\u09c1\u09ac \u0989\u09a8\u09cd\u09a8\u09df\u09a8 \u0985\u09a7\u09bf\u09a6\u09aa\u09cd\u09a4\u09b0, \u09ac\u09be\u09b8\u09a8\u09cd\u09a1\u09be, \u099d\u09be\u09b2\u0995\u09be\u09a0\u09bf",
                                    "contact_person": "",
                                    "mobile": "0498-62860 "
                                }, {
                                    "title": "\u0989\u09aa-\u09aa\u09b0\u09bf\u099a\u09be\u09b2\u0995\u09c7\u09b0 \u0995\u09be\u09b0\u09cd\u09af\u09be\u09b2\u09df, \u09af\u09c1\u09ac \u0989\u09a8\u09cd\u09a8\u09df\u09a8 \u0985\u09a7\u09bf\u09a6\u09aa\u09cd\u09a4\u09b0,  \u0986\u0987\u09a8\u099c\u09c0\u09ac\u09c0 \u09b8\u09dc\u0995, \u09ac\u09b0\u0997\u09c1\u09a8\u09be\u0964",
                                    "address": "\u0986\u0987\u09a8\u099c\u09c0\u09ac\u09c0 \u09b8\u09dc\u0995, \u09ac\u09b0\u0997\u09c1\u09a8\u09be\u0964",
                                    "contact_person": "",
                                    "mobile": "0448-62407 "
                                }, {
                                    "title": "\u0989\u09aa-\u09aa\u09b0\u09bf\u099a\u09be\u09b2\u0995\u09c7\u09b0 \u0995\u09be\u09b0\u09cd\u09af\u09be\u09b2\u09df, \u09af\u09c1\u09ac \u0989\u09a8\u09cd\u09a8\u09df\u09a8 \u0985\u09a7\u09bf\u09a6\u09aa\u09cd\u09a4\u09b0 \u09a4\u09be\u09b2\u09a4\u09b2\u09be, \u0996\u09c1\u09b2\u09a8\u09be \u09b0\u09cb\u09a1, \u09b8\u09be\u09a4\u0995\u09cd\u09b7\u09c0\u09b0\u09be\u0964",
                                    "address": "\u09af\u09c1\u09ac \u0989\u09a8\u09cd\u09a8\u09df\u09a8 \u0985\u09a7\u09bf\u09a6\u09aa\u09cd\u09a4\u09b0 \u09a4\u09be\u09b2\u09a4\u09b2\u09be, \u0996\u09c1\u09b2\u09a8\u09be \u09b0\u09cb\u09a1, \u09b8\u09be\u09a4\u0995\u09cd\u09b7\u09c0\u09b0\u09be\u0964",
                                    "contact_person": "",
                                    "mobile": "01911263750"
                                }, {
                                    "title": "\u0989\u09aa-\u09aa\u09b0\u09bf\u099a\u09be\u09b2\u0995\u09c7\u09b0 \u0995\u09be\u09b0\u09cd\u09af\u09be\u09b2\u09df, \u09af\u09c1\u09ac \u0989\u09a8\u09cd\u09a8\u09df\u09a8 \u0985\u09a7\u09bf\u09a6\u09aa\u09cd\u09a4\u09b0,  \u09af\u09c1\u09ac \u09ad\u09ac\u09a8, \u09ac\u09be\u09b0\u09be\u0995\u09aa\u09c1\u09b0, \u09b8\u09c1\u09a8\u09cd\u09a6\u09b0\u09ac\u09a8\u09be, \u09ac\u09be\u0997\u09c7\u09b0\u09b9\u09be\u099f\u0964",
                                    "address": "\u09ac\u09be\u09b0\u09be\u0995\u09aa\u09c1\u09b0, \u09b8\u09c1\u09a8\u09cd\u09a6\u09b0\u09ac\u09a8\u09be, \u09ac\u09be\u0997\u09c7\u09b0\u09b9\u09be\u099f\u0964",
                                    "contact_person": "",
                                    "mobile": "01711965592"
                                }, {
                                    "title": "\u0989\u09aa-\u09aa\u09b0\u09bf\u099a\u09be\u09b2\u0995\u09c7\u09b0 \u0995\u09be\u09b0\u09cd\u09af\u09be\u09b2\u09df, \u09af\u09c1\u09ac \u0989\u09a8\u09cd\u09a8\u09df\u09a8 \u0985\u09a7\u09bf\u09a6\u09aa\u09cd\u09a4\u09b0, \u09aa\u09be\u09b0\u09a8\u09be\u09a8\u09cd\u09a6\u09df\u09be\u09b2\u09c0, \u09ae\u09be\u0997\u09c1\u09b0\u09be\u0964",
                                    "address": "\u09aa\u09be\u09b0\u09a8\u09be\u09a8\u09cd\u09a6\u09df\u09be\u09b2\u09c0, \u09ae\u09be\u0997\u09c1\u09b0\u09be\u0964",
                                    "contact_person": "",
                                    "mobile": "01712035863"
                                }, {
                                    "title": "\u0989\u09aa-\u09aa\u09b0\u09bf\u099a\u09be\u09b2\u0995\u09c7\u09b0 \u0995\u09be\u09b0\u09cd\u09af\u09be\u09b2\u09df, \u09af\u09c1\u09ac \u0989\u09a8\u09cd\u09a8\u09df\u09a8 \u0985\u09a7\u09bf\u09a6\u09aa\u09cd\u09a4\u09b0 \u09b2\u09be\u0989\u09a6\u09bf\u09df\u09be, \u099d\u09bf\u09a8\u09be\u0987\u09a6\u09b9\u0964",
                                    "address": "\u09af\u09c1\u09ac \u0989\u09a8\u09cd\u09a8\u09df\u09a8 \u0985\u09a7\u09bf\u09a6\u09aa\u09cd\u09a4\u09b0 \u09b2\u09be\u0989\u09a6\u09bf\u09df\u09be, \u099d\u09bf\u09a8\u09be\u0987\u09a6\u09b9\u0964",
                                    "contact_person": "",
                                    "mobile": "01556346062"
                                }, {
                                    "title": "\u0989\u09aa-\u09aa\u09b0\u09bf\u099a\u09be\u09b2\u0995\u09c7\u09b0 \u0995\u09be\u09b0\u09cd\u09af\u09be\u09b2\u09df, \u09af\u09c1\u09ac \u0989\u09a8\u09cd\u09a8\u09df\u09a8 \u0985\u09a7\u09bf\u09a6\u09aa\u09cd\u09a4\u09b0 \u09ac\u099f\u09a4\u09c8\u09b2 \u09ac\u09b8\u09bf\u0995\u09bf, \u0995\u09c1\u09b7\u09cd\u099f\u09bf\u09df\u09be\u0964",
                                    "address": " \u09af\u09c1\u09ac \u0989\u09a8\u09cd\u09a8\u09df\u09a8 \u0985\u09a7\u09bf\u09a6\u09aa\u09cd\u09a4\u09b0 \u09ac\u099f\u09a4\u09c8\u09b2 \u09ac\u09b8\u09bf\u0995\u09bf, \u0995\u09c1\u09b7\u09cd\u099f\u09bf\u09df\u09be\u0964",
                                    "contact_person": "",
                                    "mobile": "01715232825"
                                }, {
                                    "title": "\u0989\u09aa-\u09aa\u09b0\u09bf\u099a\u09be\u09b2\u0995\u09c7\u09b0 \u0995\u09be\u09b0\u09cd\u09af\u09be\u09b2\u09df, \u09af\u09c1\u09ac \u0989\u09a8\u09cd\u09a8\u09df\u09a8 \u0985\u09a7\u09bf\u09a6\u09aa\u09cd\u09a4\u09b0,  \u09b8\u09cd\u099f\u09c7\u09a1\u09bf\u09df\u09be\u09ae \u09b0\u09cb\u09a1, \u09ae\u09c7\u09b9\u09c7\u09b0\u09aa\u09c1\u09b0\u0964",
                                    "address": "\u09af\u09c1\u09ac \u0989\u09a8\u09cd\u09a8\u09df\u09a8 \u0985\u09a7\u09bf\u09a6\u09aa\u09cd\u09a4\u09b0,  \u09b8\u09cd\u099f\u09c7\u09a1\u09bf\u09df\u09be\u09ae \u09b0\u09cb\u09a1, \u09ae\u09c7\u09b9\u09c7\u09b0\u09aa\u09c1\u09b0\u0964",
                                    "contact_person": "",
                                    "mobile": "01822844572"
                                }, {
                                    "title": "\u0989\u09aa-\u09aa\u09b0\u09bf\u099a\u09be\u09b2\u0995\u09c7\u09b0 \u0995\u09be\u09b0\u09cd\u09af\u09be\u09b2\u09df, \u09af\u09c1\u09ac \u0989\u09a8\u09cd\u09a8\u09df\u09a8 \u0985\u09a7\u09bf\u09a6\u09aa\u09cd\u09a4\u09b0,  \u09a8\u09c1\u09b0\u09a8\u0997\u09b0 \u099c\u09be\u09ab\u09b0\u09aa\u09c1\u09b0, \u099a\u09c1\u09df\u09be\u09a1\u09be\u0999\u09cd\u0997\u09be\u0964",
                                    "address": "\u09a8\u09c1\u09b0\u09a8\u0997\u09b0 \u099c\u09be\u09ab\u09b0\u09aa\u09c1\u09b0, \u099a\u09c1\u09df\u09be\u09a1\u09be\u0999\u09cd\u0997\u09be\u0964",
                                    "contact_person": "",
                                    "mobile": "01711065327"
                                }, {
                                    "title": "\u0989\u09aa-\u09aa\u09b0\u09bf\u099a\u09be\u09b2\u0995\u09c7\u09b0 \u0995\u09be\u09b0\u09cd\u09af\u09be\u09b2\u09df, \u09af\u09c1\u09ac \u0989\u09a8\u09cd\u09a8\u09df\u09a8 \u0985\u09a7\u09bf\u09a6\u09aa\u09cd\u09a4\u09b0 \u09af\u09c1\u09ac \u09ad\u09ac\u09a8, \u09b9\u09be\u09b2\u09bf\u09b6\u09b9\u09b0 \u09b9\u09be\u0989\u099c\u0982\u09bf \u09b8\u09cd\u099f\u09cd\u09b0\u099f\u09c7, \u099a\u099f\u09cd\u099f\u0997\u09cd\u09b0\u09be\u09ae\u0964",
                                    "address": "\u09af\u09c1\u09ac \u0989\u09a8\u09cd\u09a8\u09df\u09a8 \u0985\u09a7\u09bf\u09a6\u09aa\u09cd\u09a4\u09b0 \u09af\u09c1\u09ac \u09ad\u09ac\u09a8, \u09b9\u09be\u09b2\u09bf\u09b6\u09b9\u09b0 \u09b9\u09be\u0989\u099c\u0982\u09bf \u09b8\u09cd\u099f\u09cd\u09b0\u099f\u09c7, \u099a\u099f\u09cd\u099f\u0997\u09cd\u09b0\u09be\u09ae\u0964",
                                    "contact_person": "",
                                    "mobile": "01712061680"
                                }, {
                                    "title": "\u0989\u09aa-\u09aa\u09b0\u09bf\u099a\u09be\u09b2\u0995\u09c7\u09b0 \u0995\u09be\u09b0\u09cd\u09af\u09be\u09b2\u09df, \u09af\u09c1\u09ac \u0989\u09a8\u09cd\u09a8\u09df\u09a8 \u0985\u09a7\u09bf\u09a6\u09aa\u09cd\u09a4\u09b0 \u09ac\u09be\u09b2\u09be\u0998\u09be\u099f\u09be, \u09ac\u09be\u09a8\u09cd\u09a6\u09b0\u09ac\u09be\u09a8\u0964",
                                    "address": "\u09af\u09c1\u09ac \u0989\u09a8\u09cd\u09a8\u09df\u09a8 \u0985\u09a7\u09bf\u09a6\u09aa\u09cd\u09a4\u09b0 \u09ac\u09be\u09b2\u09be\u0998\u09be\u099f\u09be, \u09ac\u09be\u09a8\u09cd\u09a6\u09b0\u09ac\u09be\u09a8\u0964",
                                    "contact_person": "",
                                    "mobile": "01711204161"
                                }, {
                                    "title": "\u0989\u09aa-\u09aa\u09b0\u09bf\u099a\u09be\u09b2\u0995\u09c7\u09b0 \u0995\u09be\u09b0\u09cd\u09af\u09be\u09b2\u09df, \u09af\u09c1\u09ac \u0989\u09a8\u09cd\u09a8\u09df\u09a8 \u0985\u09a7\u09bf\u09a6\u09aa\u09cd\u09a4\u09b0, \u0989\u09aa-\u09aa\u09b0\u09bf\u099a\u09be\u09b2\u0995\u09c7\u09b0 \u0995\u09be\u09b0\u09cd\u09af\u09be\u09b2\u09df, \u09af\u09c1\u09ac \u0989\u09a8\u09cd\u09a8\u09df\u09a8 \u0985\u09a7\u09bf\u09a6\u09aa\u09cd\u09a4\u09b0, \u09af\u09c1\u09ac \u09ad\u09ac\u09a8, \u09ad\u09c7\u09a6\u09ac\u09c7\u09a6\u09c0, \u09b0\u09be\u0999\u09cd\u0997\u09be\u09ae\u09be\u099f\u09bf \u09aa\u09be\u09b0\u09cd\u09ac\u09a4\u09cd\u09af \u099c\u09c7\u09b2\u09be\u0964",
                                    "address": " \u09b0\u09be\u0999\u09cd\u0997\u09be\u09ae\u09be\u099f\u09bf \u09aa\u09be\u09b0\u09cd\u09ac\u09a4\u09cd\u09af \u099c\u09c7\u09b2\u09be\u0964",
                                    "contact_person": "",
                                    "mobile": "01837617002"
                                }, {
                                    "title": "\u0989\u09aa-\u09aa\u09b0\u09bf\u099a\u09be\u09b2\u0995\u09c7\u09b0 \u0995\u09be\u09b0\u09cd\u09af\u09be\u09b2\u09df, \u09af\u09c1\u09ac \u0989\u09a8\u09cd\u09a8\u09df\u09a8 \u0985\u09a7\u09bf\u09a6\u09aa\u09cd\u09a4\u09b0, \u0996\u09be\u0997\u09dc\u09be\u09aa\u09c1\u09b0, \u0996\u09be\u0997\u09dc\u09be\u099b\u099f\u09bf \u09aa\u09be\u09b0\u09cd\u09ac\u09a4\u09cd\u09af \u099c\u09c7\u09b2\u09be\u0964",
                                    "address": "\u09af\u09c1\u09ac \u0989\u09a8\u09cd\u09a8\u09df\u09a8 \u0985\u09a7\u09bf\u09a6\u09aa\u09cd\u09a4\u09b0, \u0996\u09be\u0997\u09dc\u09be\u09aa\u09c1\u09b0, \u0996\u09be\u0997\u09dc\u09be\u099b\u099f\u09bf \u09aa\u09be\u09b0\u09cd\u09ac\u09a4\u09cd\u09af \u099c\u09c7\u09b2\u09be\u0964",
                                    "contact_person": "",
                                    "mobile": "01715073655"
                                }, {
                                    "title": "\u0989\u09aa-\u09aa\u09b0\u09bf\u099a\u09be\u09b2\u0995\u09c7\u09b0 \u0995\u09be\u09b0\u09cd\u09af\u09be\u09b2\u09df, \u09af\u09c1\u09ac \u0989\u09a8\u09cd\u09a8\u09df\u09a8 \u0985\u09a7\u09bf\u09a6\u09aa\u09cd\u09a4\u09b0 \u0997\u09be\u09ac\u09c1\u09df\u09be, \u09a8\u09cb\u09df\u09be\u0996\u09be\u09b2\u09c0\u0964",
                                    "address": "\u09af\u09c1\u09ac \u0989\u09a8\u09cd\u09a8\u09df\u09a8 \u0985\u09a7\u09bf\u09a6\u09aa\u09cd\u09a4\u09b0 \u0997\u09be\u09ac\u09c1\u09df\u09be, \u09a8\u09cb\u09df\u09be\u0996\u09be\u09b2\u09c0\u0964",
                                    "contact_person": "",
                                    "mobile": "01712208723"
                                }, {
                                    "title": "\u0989\u09aa-\u09aa\u09b0\u09bf\u099a\u09be\u09b2\u0995\u09c7\u09b0 \u0995\u09be\u09b0\u09cd\u09af\u09be\u09b2\u09df, \u09af\u09c1\u09ac \u0989\u09a8\u09cd\u09a8\u09df\u09a8 \u0985\u09a7\u09bf\u09a6\u09aa\u09cd\u09a4\u09b0,  \u09ae\u099c\u09c1 \u099a\u09cc\u09a7\u09c1\u09b0\u09c0\u09b9\u09be\u099f \u09b0\u09cb\u09a1, \u09a6\u0995\u09cd\u09b7\u09a8\u09bf \u09ac\u09be\u099e\u09cd\u099c\u09be\u09a8\u0997\u09b0, \u09b2\u0995\u09cd\u09b7\u09c0\u09aa\u09c1\u09b0\u0964",
                                    "address": "\u09af\u09c1\u09ac \u0989\u09a8\u09cd\u09a8\u09df\u09a8 \u0985\u09a7\u09bf\u09a6\u09aa\u09cd\u09a4\u09b0,  \u09ae\u099c\u09c1 \u099a\u09cc\u09a7\u09c1\u09b0\u09c0\u09b9\u09be\u099f \u09b0\u09cb\u09a1, \u09a6\u0995\u09cd\u09b7\u09a8\u09bf \u09ac\u09be\u099e\u09cd\u099c\u09be\u09a8\u0997\u09b0, \u09b2\u0995\u09cd\u09b7\u09c0\u09aa\u09c1\u09b0\u0964",
                                    "contact_person": "",
                                    "mobile": "01712450501"
                                }, {
                                    "title": "\u0989\u09aa-\u09aa\u09b0\u09bf\u099a\u09be\u09b2\u0995\u09c7\u09b0 \u0995\u09be\u09b0\u09cd\u09af\u09be\u09b2\u09df, \u09af\u09c1\u09ac \u0989\u09a8\u09cd\u09a8\u09df\u09a8 \u0985\u09a7\u09bf\u09a6\u09aa\u09cd\u09a4\u09b0 \u09aa\u09cb\u09b8\u09cd\u099f \u0985\u09ab\u09bf\u09b8 \u09b0\u09cb\u09a1, \u09ab\u09c7\u09a8\u09c0\u0964",
                                    "address": "\u09af\u09c1\u09ac \u0989\u09a8\u09cd\u09a8\u09df\u09a8 \u0985\u09a7\u09bf\u09a6\u09aa\u09cd\u09a4\u09b0 \u09aa\u09cb\u09b8\u09cd\u099f \u0985\u09ab\u09bf\u09b8 \u09b0\u09cb\u09a1, \u09ab\u09c7\u09a8\u09c0\u0964",
                                    "contact_person": "",
                                    "mobile": "01709330604"
                                }, {
                                    "title": "\u0989\u09aa-\u09aa\u09b0\u09bf\u099a\u09be\u09b2\u0995\u09c7\u09b0 \u0995\u09be\u09b0\u09cd\u09af\u09be\u09b2\u09df, \u09af\u09c1\u09ac \u0989\u09a8\u09cd\u09a8\u09df\u09a8 \u0985\u09a7\u09bf\u09a6\u09aa\u09cd\u09a4\u09b0, \u0995\u09c3\u09b7\u09cd\u09a3\u09a8\u0997\u09b0, \u09a6\u09c1\u09b0\u09cd\u0997\u09be\u09aa\u09c1\u09b0, \u0995\u09c1\u09ae\u09bf\u09b2\u09cd\u09b2\u09be\u0964",
                                    "address": " \u0995\u09c3\u09b7\u09cd\u09a3\u09a8\u0997\u09b0, \u09a6\u09c1\u09b0\u09cd\u0997\u09be\u09aa\u09c1\u09b0, \u0995\u09c1\u09ae\u09bf\u09b2\u09cd\u09b2\u09be\u0964",
                                    "contact_person": "",
                                    "mobile": "01819806898"
                                }, {
                                    "title": "\u0989\u09aa-\u09aa\u09b0\u09bf\u099a\u09be\u09b2\u0995\u09c7\u09b0 \u0995\u09be\u09b0\u09cd\u09af\u09be\u09b2\u09df, \u09af\u09c1\u09ac \u0989\u09a8\u09cd\u09a8\u09df\u09a8 \u0985\u09a7\u09bf\u09a6\u09aa\u09cd\u09a4\u09b0,  \u0995\u09be\u09a6\u09b0\u09bf \u09ae\u09cd\u09af\u09be\u09a8\u09b6\u09a8, \u0995\u09be\u09a8\u09cd\u09a6\u09aa\u09bf\u09be\u09dc\u09be, \u09ac\u09bf-\u09ac\u09be\u09dc\u09c0\u09df\u09be\u0964",
                                    "address": "\u09af\u09c1\u09ac \u0989\u09a8\u09cd\u09a8\u09df\u09a8 \u0985\u09a7\u09bf\u09a6\u09aa\u09cd\u09a4\u09b0,  \u0995\u09be\u09a6\u09b0\u09bf \u09ae\u09cd\u09af\u09be\u09a8\u09b6\u09a8, \u0995\u09be\u09a8\u09cd\u09a6\u09aa\u09bf\u09be\u09dc\u09be, \u09ac\u09bf-\u09ac\u09be\u09dc\u09c0\u09df\u09be\u0964",
                                    "contact_person": "",
                                    "mobile": "01716467266"
                                }, {
                                    "title": " \u0989\u09aa-\u09aa\u09b0\u09bf\u099a\u09be\u09b2\u0995\u09c7\u09b0 \u0995\u09be\u09b0\u09cd\u09af\u09be\u09b2\u09df, \u09af\u09c1\u09ac \u0989\u09a8\u09cd\u09a8\u09df\u09a8 \u0985\u09a7\u09bf\u09a6\u09aa\u09cd\u09a4\u09b0, \u09a4\u09bf\u09a8\u09ae\u09be\u09a5\u09be \u09b0\u09c7\u09b2\u0997\u09c7\u099f, \u09ac\u0997\u09c1\u09dc\u09be\u0964  ",
                                    "address": "\u09af\u09c1\u09ac \u0989\u09a8\u09cd\u09a8\u09df\u09a8 \u0985\u09a7\u09bf\u09a6\u09aa\u09cd\u09a4\u09b0, \u09a4\u09bf\u09a8\u09ae\u09be\u09a5\u09be \u09b0\u09c7\u09b2\u0997\u09c7\u099f, \u09ac\u0997\u09c1\u09dc\u09be\u0964  ",
                                    "contact_person": "",
                                    "mobile": "01553372464"
                                }, {
                                    "title": "\u0989\u09aa-\u09aa\u09b0\u09bf\u099a\u09be\u09b2\u0995\u09c7\u09b0 \u0995\u09be\u09b0\u09cd\u09af\u09be\u09b2\u09df, \u09af\u09c1\u09ac \u0989\u09a8\u09cd\u09a8\u09df\u09a8 \u0985\u09a7\u09bf\u09a6\u09aa\u09cd\u09a4\u09b0, \u09af\u09c1\u09ac \u09ad\u09ac\u09a8,  \u09ae\u09b9\u09c7\u09a8\u09cd\u09a6\u09cd\u09b0\u09aa\u09c1\u09b0, \u09aa\u09be\u09ac\u09a8\u09be",
                                    "address": "\u09af\u09c1\u09ac \u0989\u09a8\u09cd\u09a8\u09df\u09a8 \u0985\u09a7\u09bf\u09a6\u09aa\u09cd\u09a4\u09b0, \u09af\u09c1\u09ac \u09ad\u09ac\u09a8, \u09ae\u09b9\u09c7\u09a8\u09cd\u09a6\u09cd\u09b0\u09aa\u09c1\u09b0, \u09aa\u09be\u09ac\u09a8\u09be",
                                    "contact_person": "",
                                    "mobile": "01711154183"
                                }, {
                                    "title": "\u0989\u09aa-\u09aa\u09b0\u09bf\u099a\u09be\u09b2\u0995\u09c7\u09b0 \u0995\u09be\u09b0\u09cd\u09af\u09be\u09b2\u09df, \u09af\u09c1\u09ac \u0989\u09a8\u09cd\u09a8\u09df\u09a8 \u0985\u09a7\u09bf\u09a6\u09aa\u09cd\u09a4\u09b0, \u09b8\u09a6\u09a8, \u0995\u09be\u09b6\u09bf\u09aa\u09c1\u09b0, \u09a6\u09bf\u09a8\u09be\u099c\u09aa\u09c1\u09b0",
                                    "address": "\u09af\u09c1\u09ac \u0989\u09a8\u09cd\u09a8\u09df\u09a8 \u0985\u09a7\u09bf\u09a6\u09aa\u09cd\u09a4\u09b0, \u09b8\u09a6\u09a8, \u0995\u09be\u09b6\u09bf\u09aa\u09c1\u09b0, \u09a6\u09bf\u09a8\u09be\u099c\u09aa\u09c1\u09b0",
                                    "contact_person": "",
                                    "mobile": "01716020371"
                                }, {
                                    "title": "\u0989\u09aa-\u09aa\u09b0\u09bf\u099a\u09be\u09b2\u0995\u09c7\u09b0 \u0995\u09be\u09b0\u09cd\u09af\u09be\u09b2\u09df, \u09af\u09c1\u09ac \u0989\u09a8\u09cd\u09a8\u09df\u09a8 \u0985\u09a7\u09bf\u09a6\u09aa\u09cd\u09a4\u09b0, \u09af\u09c1\u09ac \u09ad\u09ac\u09a8, \u09b6\u09bf\u0982\u09aa\u09be\u09dc\u09be, \u09aa\u099e\u09cd\u099a\u0997\u09dc",
                                    "address": "\u09af\u09c1\u09ac \u0989\u09a8\u09cd\u09a8\u09df\u09a8 \u0985\u09a7\u09bf\u09a6\u09aa\u09cd\u09a4\u09b0, \u09af\u09c1\u09ac \u09ad\u09ac\u09a8, \u09b6\u09bf\u0982\u09aa\u09be\u09dc\u09be, \u09aa\u099e\u09cd\u099a\u0997\u09dc",
                                    "contact_person": "",
                                    "mobile": "01715309395"
                                }, {
                                    "title": "\u0989\u09aa-\u09aa\u09b0\u09bf\u099a\u09be\u09b2\u0995\u09c7\u09b0 \u0995\u09be\u09b0\u09cd\u09af\u09be\u09b2\u09df, \u09af\u09c1\u09ac \u0989\u09a8\u09cd\u09a8\u09df\u09a8 \u0985\u09a7\u09bf\u09a6\u09aa\u09cd\u09a4\u09b0,\u0986\u09b0,\u0995\u09c7,\u09b0\u09cb\u09a1, \u0995\u09c1\u09dc\u09bf\u0997\u09cd\u09b0\u09be\u09ae",
                                    "address": "\u09af\u09c1\u09ac \u0989\u09a8\u09cd\u09a8\u09df\u09a8 \u0985\u09a7\u09bf\u09a6\u09aa\u09cd\u09a4\u09b0,\u0986\u09b0,\u0995\u09c7,\u09b0\u09cb\u09a1, \u0995\u09c1\u09dc\u09bf\u0997\u09cd\u09b0\u09be\u09ae",
                                    "contact_person": "",
                                    "mobile": "01709331036"
                                }, {
                                    "title": "\u0989\u09aa-\u09aa\u09b0\u09bf\u099a\u09be\u09b2\u0995\u09c7\u09b0 \u0995\u09be\u09b0\u09cd\u09af\u09be\u09b2\u09df, \u09af\u09c1\u09ac \u0989\u09a8\u09cd\u09a8\u09df\u09a8 \u0985\u09a7\u09bf\u09a6\u09aa\u09cd\u09a4\u09b0, \u09af\u09c1\u09ac \u09ad\u09ac\u09a8, \u09b2\u09bf\u0982 \u09b0\u09cb\u09a1, \u0995\u0995\u09cd\u09b8\u09ac\u09be\u099c\u09be\u09b0",
                                    "address": "\u09af\u09c1\u09ac \u0989\u09a8\u09cd\u09a8\u09df\u09a8 \u0985\u09a7\u09bf\u09a6\u09aa\u09cd\u09a4\u09b0, \u09af\u09c1\u09ac \u09ad\u09ac\u09a8, \u09b2\u09bf\u0982 \u09b0\u09cb\u09a1, \u0995\u0995\u09cd\u09b8\u09ac\u09be\u099c\u09be\u09b0",
                                    "contact_person": "",
                                    "mobile": "01817512402"
                                }, {
                                    "title": "\u0989\u09aa-\u09aa\u09b0\u09bf\u099a\u09be\u09b2\u0995\u09c7\u09b0 \u0995\u09be\u09b0\u09cd\u09af\u09be\u09b2\u09df, \u09af\u09c1\u09ac \u0989\u09a8\u09cd\u09a8\u09df\u09a8 \u0985\u09a7\u09bf\u09a6\u09aa\u09cd\u09a4\u09b0, \u09af\u09c1\u09ac \u09ad\u09ac\u09a8, \u09b8\u09c7\u09a8\u0997\u09be\u0993, \u0986\u09b6\u09bf\u0995\u09be\u09a0\u09bf, \u099a\u09be\u0981\u09a6\u09aa\u09c1\u09b0",
                                    "address": " \u09af\u09c1\u09ac \u0989\u09a8\u09cd\u09a8\u09df\u09a8 \u0985\u09a7\u09bf\u09a6\u09aa\u09cd\u09a4\u09b0, \u09af\u09c1\u09ac \u09ad\u09ac\u09a8, \u09b8\u09c7\u09a8\u0997\u09be\u0993, \u0986\u09b6\u09bf\u0995\u09be\u09a0\u09bf, \u099a\u09be\u0981\u09a6\u09aa\u09c1\u09b0",
                                    "contact_person": "",
                                    "mobile": "01780418262"
                                }, {
                                    "title": "\u0989\u09aa-\u09aa\u09b0\u09bf\u099a\u09be\u09b2\u0995\u09c7\u09b0 \u0995\u09be\u09b0\u09cd\u09af\u09be\u09b2\u09df, \u09af\u09c1\u09ac \u0989\u09a8\u09cd\u09a8\u09df\u09a8 \u0985\u09a7\u09bf\u09a6\u09aa\u09cd\u09a4\u09b0, \u09b8\u09cb\u09a8\u09be\u09a1\u09be\u0999\u09cd\u0997\u09be, \u0996\u09c1\u09b2\u09a8\u09be",
                                    "address": "\u09af\u09c1\u09ac \u0989\u09a8\u09cd\u09a8\u09df\u09a8 \u0985\u09a7\u09bf\u09a6\u09aa\u09cd\u09a4\u09b0, \u09b8\u09cb\u09a8\u09be\u09a1\u09be\u0999\u09cd\u0997\u09be, \u0996\u09c1\u09b2\u09a8\u09be",
                                    "contact_person": "",
                                    "mobile": "01732050150"
                                }, {
                                    "title": "\u0989\u09aa-\u09aa\u09b0\u09bf\u099a\u09be\u09b2\u0995\u09c7\u09b0 \u0995\u09be\u09b0\u09cd\u09af\u09be\u09b2\u09df, \u09af\u09c1\u09ac \u0989\u09a8\u09cd\u09a8\u09df\u09a8 \u0985\u09a7\u09bf\u09a6\u09aa\u09cd\u09a4\u09b0, \u0995\u09bf\u09b8\u09ae\u09a4 \u09a8\u0993\u09df\u09be \u09aa\u09be\u09dc\u09be, \u09ae\u09be\u0997\u09c1\u09b0\u09be \u09b0\u09cb\u09a1, \u09af\u09b6\u09cb\u09b0",
                                    "address": "\u09af\u09c1\u09ac \u0989\u09a8\u09cd\u09a8\u09df\u09a8 \u0985\u09a7\u09bf\u09a6\u09aa\u09cd\u09a4\u09b0, \u0995\u09bf\u09b8\u09ae\u09a4 \u09a8\u0993\u09df\u09be \u09aa\u09be\u09dc\u09be, \u09ae\u09be\u0997\u09c1\u09b0\u09be \u09b0\u09cb\u09a1, \u09af\u09b6\u09cb\u09b0",
                                    "contact_person": "",
                                    "mobile": "01718014170"
                                }, {
                                    "title": "\u0989\u09aa-\u09aa\u09b0\u09bf\u099a\u09be\u09b2\u0995\u09c7\u09b0 \u0995\u09be\u09b0\u09cd\u09af\u09be\u09b2\u09df, \u09af\u09c1\u09ac \u0989\u09a8\u09cd\u09a8\u09df\u09a8 \u0985\u09a7\u09bf\u09a6\u09aa\u09cd\u09a4\u09b0, \u09a6\u09c2\u09b0\u09cd\u0997\u09be\u09aa\u09c1\u09b0, \u09a8\u09dc\u09be\u0987\u09b2",
                                    "address": "\u09af\u09c1\u09ac \u0989\u09a8\u09cd\u09a8\u09df\u09a8 \u0985\u09a7\u09bf\u09a6\u09aa\u09cd\u09a4\u09b0, \u09a6\u09c2\u09b0\u09cd\u0997\u09be\u09aa\u09c1\u09b0, \u09a8\u09dc\u09be\u0987\u09b2",
                                    "contact_person": "",
                                    "mobile": "01712768448"
                                }, {
                                    "title": "\u0989\u09aa-\u09aa\u09b0\u09bf\u099a\u09be\u09b2\u0995\u09c7\u09b0 \u0995\u09be\u09b0\u09cd\u09af\u09be\u09b2\u09df, \u09af\u09c1\u09ac \u0989\u09a8\u09cd\u09a8\u09df\u09a8 \u0985\u09a7\u09bf\u09a6\u09aa\u09cd\u09a4\u09b0, \u09a6\u09c1\u09b0\u09cd\u0997\u09be\u09aa\u09c1\u09b0, \u09aa\u099f\u09c1\u09df\u09be\u0996\u09be\u09b2\u09c0",
                                    "address": " \u09af\u09c1\u09ac \u0989\u09a8\u09cd\u09a8\u09df\u09a8 \u0985\u09a7\u09bf\u09a6\u09aa\u09cd\u09a4\u09b0, \u09a6\u09c1\u09b0\u09cd\u0997\u09be\u09aa\u09c1\u09b0, \u09aa\u099f\u09c1\u09df\u09be\u0996\u09be\u09b2\u09c0",
                                    "contact_person": "",
                                    "mobile": "01711119185"
                                }, {
                                    "title": "\u0989\u09aa-\u09aa\u09b0\u09bf\u099a\u09be\u09b2\u0995\u09c7\u09b0 \u0995\u09be\u09b0\u09cd\u09af\u09be\u09b2\u09df, \u09af\u09c1\u09ac \u0989\u09a8\u09cd\u09a8\u09df\u09a8 \u0985\u09a7\u09bf\u09a6\u09aa\u09cd\u09a4\u09b0, \u09ae\u09be\u0987\u099c\u09ac\u09be\u09dc\u09c0 \u09b0\u09cb\u09a1, \u09a8\u09ac\u09c0\u09a8\u0997\u09b0, \u09b8\u09c1\u09a8\u09be\u09ae\u0997\u099e\u09cd\u099c",
                                    "address": "\u09af\u09c1\u09ac \u0989\u09a8\u09cd\u09a8\u09df\u09a8 \u0985\u09a7\u09bf\u09a6\u09aa\u09cd\u09a4\u09b0, \u09ae\u09be\u0987\u099c\u09ac\u09be\u09dc\u09c0 \u09b0\u09cb\u09a1, \u09a8\u09ac\u09c0\u09a8\u0997\u09b0, \u09b8\u09c1\u09a8\u09be\u09ae\u0997\u099e\u09cd\u099c",
                                    "contact_person": "",
                                    "mobile": "01716048418"
                                }, {
                                    "title": "\u09af\u09c1\u09ac \u09aa\u09cd\u09b0\u09b6\u09bf\u0995\u09cd\u09b7\u09a3 \u0995\u09c7\u09a8\u09cd\u09a6\u09cd\u09b0  \u09af\u09c1\u09ac \u0989\u09a8\u09cd\u09a8\u09df\u09a8 \u0985\u09a7\u09bf\u09a6\u09aa\u09cd\u09a4\u09b0, \u09b6\u09bf\u09ac\u09a4\u09b2\u09be, \u099a\u09be\u0981\u09aa\u09be\u0987\u09a8\u09ac\u09be\u09ac\u0997\u099e\u09cd\u099c",
                                    "address": "\u09af\u09c1\u09ac \u0989\u09a8\u09cd\u09a8\u09df\u09a8 \u0985\u09a7\u09bf\u09a6\u09aa\u09cd\u09a4\u09b0, \u09b6\u09bf\u09ac\u09a4\u09b2\u09be, \u099a\u09be\u0981\u09aa\u09be\u0987\u09a8\u09ac\u09be\u09ac\u0997\u099e\u09cd\u099c",
                                    "contact_person": "",
                                    "mobile": "01935055645"
                                }, {
                                    "title": "\u0989\u09aa-\u09aa\u09b0\u09bf\u099a\u09be\u09b2\u0995\u09c7\u09b0 \u0995\u09be\u09b0\u09cd\u09af\u09be\u09b2\u09df, \u09af\u09c1\u09ac \u0989\u09a8\u09cd\u09a8\u09df\u09a8 \u0985\u09a7\u09bf\u09a6\u09aa\u09cd\u09a4\u09b0,  \u09a1\u09bf\/\u09eb\u09e9, \u09a6\u0995\u09cd\u09b7\u09a8\u09bf \u099b\u09be\u09df\u09be\u09ac\u09bf\u09a5\u09c0, \u0997\u09be\u099c\u09c0\u09aa\u09c1\u09b0",
                                    "address": "\u0989\u09aa-\u09aa\u09b0\u09bf\u099a\u09be\u09b2\u0995\u09c7\u09b0 \u0995\u09be\u09b0\u09cd\u09af\u09be\u09b2\u09df, \u09af\u09c1\u09ac \u0989\u09a8\u09cd\u09a8\u09df\u09a8 \u0985\u09a7\u09bf\u09a6\u09aa\u09cd\u09a4\u09b0, \r\n\u09a1\u09bf\/\u09eb\u09e9, \u09a6\u0995\u09cd\u09b7\u09a8\u09bf \u099b\u09be\u09df\u09be\u09ac\u09bf\u09a5\u09c0, \u0997\u09be\u099c\u09c0\u09aa\u09c1\u09b0",
                                    "contact_person": "",
                                    "mobile": ""
                                }, {
                                    "title": "\u0989\u09aa\u099c\u09c7\u09b2\u09be \u09af\u09c1\u09ac \u0989\u09a8\u09cd\u09a8\u09df\u09a8 \u0995\u09b0\u09cd\u09ae\u0995\u09b0\u09cd\u09a4\u09be\u09b0 \u0995\u09be\u09b0\u09cd\u09af\u09be\u09b2\u09df,\u0997\u09be\u099c\u09c0\u09aa\u09c1\u09b0 \u09b8\u09a6\u09b0",
                                    "address": "\u0989\u09aa\u099c\u09c7\u09b2\u09be \u09af\u09c1\u09ac \u0989\u09a8\u09cd\u09a8\u09df\u09a8 \u0995\u09b0\u09cd\u09ae\u0995\u09b0\u09cd\u09a4\u09be\u09b0 \u0995\u09be\u09b0\u09cd\u09af\u09be\u09b2\u09df,\u0997\u09be\u099c\u09c0\u09aa\u09c1\u09b0 \u09b8\u09a6\u09b0",
                                    "contact_person": null,
                                    "mobile": null
                                }, {
                                    "title": "\u0989\u09aa\u099c\u09c7\u09b2\u09be \u09af\u09c1\u09ac \u0989\u09a8\u09cd\u09a8\u09df\u09a8 \u0995\u09b0\u09cd\u09ae\u0995\u09b0\u09cd\u09a4\u09be\u09b0 \u0995\u09be\u09b0\u09cd\u09af\u09be\u09b2\u09af\u09bc,\u0996\u09be\u0997\u09dc\u09be\u099b\u09dc\u09bf \u09b8\u09a6\u09b0",
                                    "address": "\u0989\u09aa\u099c\u09c7\u09b2\u09be \u09af\u09c1\u09ac \u0989\u09a8\u09cd\u09a8\u09df\u09a8 \u0995\u09b0\u09cd\u09ae\u0995\u09b0\u09cd\u09a4\u09be\u09b0 \u0995\u09be\u09b0\u09cd\u09af\u09be\u09b2\u09af\u09bc,\u0996\u09be\u0997\u09dc\u09be\u099b\u09dc\u09bf \u09b8\u09a6\u09b0",
                                    "contact_person": null,
                                    "mobile": null
                                }];
                            </script>
                            <script>
                                //console.log(centerListAsm);

                                function regenerateCenterList(searchTerm) {
                                    if (centerListAsm && centerListAsm.length) {
                                        var filteredList;
                                        if (searchTerm) {
                                            filteredList = centerListAsm.filter(function (centerOb) {
                                                return (centerOb.title.includes(searchTerm) ||
                                                    centerOb.address.includes(searchTerm) ||
                                                    (centerOb.contact_person && centerOb.contact_person.includes(searchTerm)) ||
                                                    (centerOb.mobile && centerOb.mobile.includes(searchTerm))
                                                );
                                            });
                                        } else {
                                            filteredList = centerListAsm;
                                        }

                                        var htmlStr = "";
                                        var centerIndex = 1;
                                        filteredList.forEach(function (centerOb) {
                                            htmlStr += "<li><p>" + centerIndex.toString().getDigitBanglaFromEnglish() + ') ' + centerOb.title + "</p>";
                                            if (centerOb.contact_person || centerOb.mobile) {
                                                htmlStr += "<p class='personmobile'>";
                                                htmlStr += centerOb.contact_person ? centerOb.contact_person + ",&nbsp;&nbsp;" : "";
                                                htmlStr += centerOb.mobile ? centerOb.mobile : "";
                                                htmlStr += "</p>";
                                            }
                                            htmlStr += "<address><i>" + centerOb.address + "</i></address></li>";
                                            centerIndex++;
                                        });

                                        $("#center_list").html(htmlStr);
                                    }
                                }

                                $(function () {
                                    $("#search_center").blur(function (e) {
                                        var searchTerm = e.target.value;
                                        regenerateCenterList(searchTerm);
                                    });
                                    $("#search_center").keypress(function (e) {
                                        var code = e.keyCode || e.which;
                                        if (code == 13) { //Enter keycode
                                            var searchTerm = e.target.value;
                                            regenerateCenterList(searchTerm)
                                        }
                                    });
                                });
                            </script>
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </div>

@endsection
@push('css')
    <style>


    </style>
@endpush
@push('js')


@endpush
