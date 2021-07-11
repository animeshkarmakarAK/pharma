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


        //search
        const searchAPI = function ({model, columns}) {
            return function (url, filters = {}) {
                return $.ajax({
                    url: url,
                    type: "GET",
                    data: {
                        _token: '{{csrf_token()}}',
                        resource: {
                            model: model,
                            columns: columns,
                            filters,
                        }
                    }
                }).done(function (response) {
                    return response;
                });
            };
        };

        let baseUrl = '{{route('web-api.model-resources')}}';

        const venueFetch = searchAPI({
            model: "<?php echo e(base64_encode(\Module\CourseManagement\App\Models\PublishCourse::class)); ?>",
            columns: 'branch.title_bn|training_centre.title_bn|institute.title_bn'
        });

        function venueSearch(search = '', resetPage = true, url = null) {
            const filters = {};
            let course = $('#course_id').val();
            filters['course_id'] = course;
            if (search?.toString()?.length) {
                filters['title_bn'] = {
                    type: 'contain',
                    value: search
                };
            }
            /*let domainInstitute = $('#domain-institute').val();
            if (domainInstitute?.toString()?.length) {
                filters['institute_id'] = domainInstitute;
            }*/

            console.log(filters);

            $('.venue_overlay').show();
            venueFetch(url,filters)?.then(function (response) {

                $('.venue_overlay').hide();
                //$('#program_pagination').html(response?.data?.next_page_url);
                let html = '';
                $.each(response.data.data, function (i, item) {
                    html += template({
                        id: item.id,
                        //imageUrl: '{{asset('/storage/')}}/' + item.logo,
                        title: item.title_bn,
                        description: item.institute_title_bn,
                        selector: 'programme',
                    });
                });
                if (resetPage) {
                    $('#venue_name_list').html(html);
                } else {
                    $('#venue_name_list').append(html);
                }
            });
        }


        $(document).ready(function () {
            $('#venue_name').keyup(function () {
                let searchString = $(this).val();
                if (searchString?.length) {
                    venueSearch(searchString);
                } else {
                    venueSearch();
                }

            })
        })

    </script>


@endpush
