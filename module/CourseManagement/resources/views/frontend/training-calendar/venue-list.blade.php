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
                                            <p>
                                                <input class="form-control center-search" name="searchValue"
                                                       id="venue_name"
                                                       placeholder="অনুসন্ধান">
                                                <input type="hidden" name="course_id" id="course_id"
                                                       value="{{ collect(request()->segments())->last() }}">
                                            </p>
                                        </div>
                                        <div class="col-md-12">
                                            <ul class="center-list" id="center_list">
                                                <?php
                                                $sl = 0;
                                                ?>
                                                @foreach($publishedCourses as $publishedCourse)
                                                    <li style="list-style: none;">
                                                        <p>
                                                            {{ \App\Helpers\Classes\NumberToBanglaWord::engToBn(++$sl) }}
                                                            ) {{ $publishedCourse->trainingCenter? $publishedCourse->trainingCenter->title_bn.',':''}}
                                                            {{ $publishedCourse->branch? $publishedCourse->branch->title_bn.',':''}}
                                                            {{ $publishedCourse->institute? $publishedCourse->institute->title_bn: ''}}
                                                        </p>
                                                        <p class="personmobile">
                                                            {{ $publishedCourse->institute? $publishedCourse->institute->primary_mobile: ''}} </p>
                                                        <address>
                                                            <i>ঠিকানা :
                                                                <?php

                                                                if ($publishedCourse->trainingCenter) {
                                                                    echo $publishedCourse->trainingCenter->address;
                                                                } elseif ($publishedCourse->branch) {
                                                                    echo $publishedCourse->branch->address;
                                                                } else {
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
                                        <div class="col-md-12">
                                            <div id="venue_name_list"></div>
                                            <div class="venue_overlay" style="display: none"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
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

    <script type="text/javascript">

        const searchAPI = function ({model, columns}) {
            return function (url, filters = {}) {
                return $.ajax({
                    url: url,
                    type: "POST",
                    data: {
                        _token: '{{csrf_token()}}',
                        resource: {
                            model: model,
                            columns: columns,
                            paginate: true,
                            page: 1,
                            per_page: 16,
                            filters,
                        }
                    }
                }).done(function (response) {
                    return response;
                });
            };
        };

        let baseUrl = '{{route('web-api.model-resources')}}';
        const courseVenueFetch = searchAPI({
            model: "{{base64_encode(\Module\CourseManagement\App\Models\PublishCourse::class)}}",
            columns: 'id|course.title_bn'
        });

        function courseVenueSearch(url = baseUrl) {
            $('.overlay').show();
            let searchQuery = $('#venue_name').val();

            const filters = {};
            if (searchQuery?.toString()?.length) {
                filters['course.title_en'] = {
                    type: 'contain',
                    value: searchQuery
                };
                filters['course.title_bn'] = {
                    type: 'contain',
                    value: searchQuery
                };
                filters['branch.address'] = {
                    type: 'contain',
                    value: searchQuery
                };
            }

            courseVenueFetch(url, filters)?.then(function (response) {
                $('.overlay').hide();
                window.scrollTo(0,0);
            });
        }

        $(document).ready(function () {
            courseVenueSearch();

            $('#venue_name').on('keyup', function () {
                courseVenueSearch();
            });
        });
    </script>
@endpush
