@php
    $currentInstitute = domainConfig('institute');
    $layout = $currentInstitute ? 'master::layouts.custom1' : 'master::layouts.front-end';
@endphp

@extends($layout)
@push('css')
    <style>
        .custom-input-box {
            padding: 10px;
        }

        .custom-input-box:hover {
            cursor: pointer;
        }

        .card-body {
            min-height: 300px;
        }

        p {
            line-height: normal;
        }

        .courses-search-custom {
            cursor: pointer;
            transition: .4s;
        }

        .courses-search-custom:hover {
            background: #f2f4f5;
            border-radius: 5px;
            transition: .4s;
        }

        #institute_name_list, #course_name_list, #program_name_list {
            max-height: 400px;
            overflow-y: auto;
        }

        .institute_overlay, .course_overlay, .program_overlay {
            display: block;
            height: 100%;
            opacity: 0.7;
            position: absolute;
            width: 100%;
            z-index: 1052;
            left: 35%;
            bottom: -75%;
        }
    </style>
@endpush

@section('content')
    <div id="modal"></div>

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header custom-bg-gradient-info">
                        <h1 class="text-center text-primary mt-4">পছন্দের কোর্স খুঁজুন</h1>
                    </div>
                    <div class="card-body bg-gray-light">
                        <div class="row justify-content-center">
                            @if(!empty(domainConfig('institute')))
                                <input type="hidden" id="domain-institute" value="{{ domainConfig('institute')->id }}">
                            @else
                                <div class="col-md-3">
                                    <div class="card">
                                        <div class="card-header bg-success">
                                            <h4 class="text-center">প্রতিষ্ঠান সমূহ</h4>
                                        </div>
                                        <div class="card-header">
                                            <input type="text" class="form-control" name="institute_name"
                                                   id="institute_name" value=""
                                                   placeholder="প্রতিষ্ঠানের নাম লিখুন">
                                        </div>
                                        <div class="card-body">
                                            <div id="institute_name_list"></div>
                                            <div id="institute_pagination" style="display: none"></div>
                                            <div class="institute_overlay" style="display: none">
                                                <i class="fas fa-2x fa-sync-alt fa-spin"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            <div class="col-md-3">
                                <div class="card">
                                    <div class="card-header bg-info">
                                        <h4 class="text-center">কোর্স সমূহ</h4>
                                    </div>
                                    <div class="card-header">
                                        <input type="text" class="form-control" name="course_name"
                                               id="course_name"
                                               value="" placeholder="কোর্সের নাম লিখুন">
                                    </div>
                                    <div class="card-body">
                                        <div id="course_name_list"></div>
                                        <div id="course_pagination" style="display: none"></div>
                                        <div class="course_overlay" style="display: none">
                                            <i class="fas fa-2x fa-sync-alt fa-spin"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card">
                                    <div class="card-header bg-warning">
                                        <h4 class="text-center"> প্রোগ্রাম সমূহ</h4>
                                    </div>
                                    <div class="card-header">
                                        <input type="text" class="form-control" name="program_name"
                                               id="program_name"
                                               value="" placeholder="প্রোগ্রামের নাম লিখুন">
                                    </div>
                                    <div class="card-body">
                                        <div id="program_name_list"></div>
                                        <div id="program_pagination" style="display: none"></div>
                                        <div class="program_overlay" style="display: none">
                                            <i class="fas fa-2x fa-sync-alt fa-spin"></i>
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

    <div class="modal modal-primary fade" tabindex="-1" id="course_list_modal" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content" style="background-color: #e6eaeb">
                <div class="modal-header bg-info">
                    <h4 style="text-align: center; margin-top: 5px">কোর্স সমূহ</h4>
                    <button type="button" class="close" data-dismiss="modal"
                            aria-label="{{ __('voyager::generic.close') }}">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body p-0 m-2">
                    <div class="card">
                        <div class="card-header">
                            <input type="text" class="form-control"
                                   id="course_name_modal"
                                   data-institute-id=""
                                   data-programme-id=""
                                   value="" placeholder="কোর্সের নাম লিখুন">
                        </div>
                        <div class="card-body">
                            <div class="col-12 bg-blue-light overflow-auto" id="course_name_list_modal"
                                 style="max-height:300px;">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal modal-danger fade" tabindex="-1" id="course_details_modal" role="dialog">
        <div class="modal-dialog" style="max-width: 80%;">
            <div class="modal-content modal-xlg" style="background-color: #e6eaeb">
            </div>
        </div>
    </div>

    <div class="modal modal-danger fade" tabindex="-1" id="course_details_modal_for_mukto_path" role="dialog">
        <div class="modal-dialog" style="max-width: 80%;">
            <div class="modal-content modal-xlg" style="background-color: #e6eaeb">
                <div class="modal-header custom-bg-gradient-info">
                    <div style=" height:40px;">
                        <h4 style="text-align: center; margin-top: 5px">কোর্সের বর্ণনা</h4>
                    </div>
                    <button type="button" class="close" data-dismiss="modal"
                            aria-label="{{ __('voyager::generic.close') }}">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header d-flex justify-content-between custom-bg-gradient-info">
                                    <img id="mp_cover_image" class="img-fluid" alt="Responsive image"
                                         src="http://lorempixel.com/900/300/"
                                         style="height: 300px; width: 100%">
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6 custom-view-box">
                                            <p class="label-text">কোর্সের নাম </p>
                                            <div class="input-box" id="mp_course_title"></div>
                                        </div>

                                        <div class="col-md-6 custom-view-box">
                                            <p class="label-text">কোর্স ফি</p>
                                            <div class="input-box" id="mp_course_fee"></div>
                                        </div>

                                        <div class="col-md-12 custom-view-box">
                                            <p class="label-text">কোর্সের বর্ণনা</p>
                                            <div class="input-box" id="mp_course_description"></div>
                                        </div>
                                        <div class="col-md-6 custom-view-box">
                                            <p class="label-text">পূর্বশর্ত </p>
                                            <div class="input-box" id="mp_prerequisite"></div>
                                        </div>
                                        <div class="col-md-6 custom-view-box">
                                            <p class="label-text">পূর্ব যোগ্যতা</p>
                                            <div class="input-box" id="mp_eligibility"></div>
                                        </div>
                                        <div class="col-md-6 custom-view-box">
                                            <p class="label-text">ইন্সটিটিউটের নাম </p>
                                            <div class="input-box" id="mp_institute_name_field"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12 text-right">
                            <button type="button" class="btn btn-lg btn-success">Apply Now</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script>
        const muktoPathImageBasePath = 'http://admin.muktopaathdemo.orangebd.com/cache-images/219x145x1/uploads/images/';
        const muktoPathCourses = @json(\App\Helpers\Classes\Helper::getMuktoPathCourses());

        console.log(muktoPathCourses)
        const searchAPI = function ({model, columns}) {
            const config = {
                url: '{{route('web-api.model-resources')}}',
                urlCurrent: '',
            }
            return function (filters = {}, resetPage = true, url = null) {
                if (!config.url?.length) {
                    console.log('stop execute')
                    return false;
                }
                if (url != null) {
                    config.urlCurrent = url;
                }

                return $.ajax({
                    url: resetPage ? config.url : (config.urlCurrent || config.url),
                    type: "POST",
                    data: {
                        _token: '{{csrf_token()}}',
                        resource: {
                            model: model,
                            columns: columns,
                            paginate: true,
                            page: 1,
                            per_page: 25,
                            filters
                        }
                    }
                }).done(function (response) {
                    config.urlCurrent = response?.next_page_url;
                    return response;
                });
            };
        };

        function RemoveHTMLTags(html) {
            if (html.toString().length === 0) {
                return '';
            }
            return html.replace(/(<([^>]+)>)/ig, "");
        }

        function openMuktopathCourse(courseId) {
            let course = muktoPathCourses.find((item) => item.id === courseId);
            console.log(course)

            $('#mp_course_title').text(course?.course_alias_name);
            $('#mp_institute_name_field').text(course?.institution_name_bn);
            $('#mp_prerequisite').html(course?.requirement);
            $('#mp_course_description').html(RemoveHTMLTags(course?.details));
            $('#mp_cover_image').attr('src', muktoPathImageBasePath + course.thumnail?.file_encode_path);
            $("#mp_course_fee").text(course?.payment_point_amount > 0 ? (course?.payment_point_amount + '/=') : 'Free');
            $("#course_details_modal_for_mukto_path").modal('show');
        }

        async function courseDetailsModalOpen(courseId) {
            let response = await $.get('{{route('course_management::course-details.ajax', ['publish_course_id' => '__'])}}'.replace('__', courseId));
            if (response?.length) {
                $("#course_details_modal").find(".modal-content").html(response);
            } else {
                let notFound = `<div class="alert alert-danger">Not Found</div>
                            </div>`
                $("#course_details_modal").find(".modal-content").html(notFound);
            }
            $("#course_details_modal").modal('show');
        }

        const template = function ({id, imageUrl, title, description, selector}) {
            return `<div class="media mb-2 p-2 shadow-sm ${selector} courses-search-custom" data-id="${id}">
                                <img class="d-flex img-rounded align-self-start mr-3" src="${imageUrl}" alt="Student" style="width: 40px;">
                                <div class="media-body">
                                    <h6 class="mt-0 font-weight-bold">${title}</h6>
                                    <p>${description}</p>
                                </div>
                            </div>`;
        };

        const instituteFetch = searchAPI({
            model: "{{base64_encode(\Module\CourseManagement\App\Models\Institute::class)}}",
            columns: 'title_bn|logo|address'
        });
        const courseFetch = searchAPI({
            model: "{{base64_encode(\Module\CourseManagement\App\Models\PublishCourse::class)}}",
            columns: 'id|institute.title_bn|course.title_bn|course.cover_image'
        });
        const courseFetchForProgramme = searchAPI({
            model: "{{base64_encode(\Module\CourseManagement\App\Models\PublishCourse::class)}}",
            columns: 'id|institute.title_bn|course.title_bn|course.cover_image'
        });
        const programmeFetch = searchAPI({
            model: "{{base64_encode(\Module\CourseManagement\App\Models\Programme::class)}}",
            columns: 'title_bn|logo|institute.title_bn'
        });

        function instituteSearch(search = '', resetPage = true, url = null) {
            const filters = {};
            if (search?.length) {
                filters['title_bn'] = {
                    type: 'contain',
                    value: search
                };
            }

            $('.institute_overlay').show();
            instituteFetch(filters, resetPage, url)?.then(function (response) {
                $('.institute_overlay').hide();
                $('#institute_pagination').html(response?.data?.next_page_url);

                let html = '';
                $.each(response.data.data, function (i, item) {
                    html += template({
                        id: item.id,
                        imageUrl: '{{asset('/storage/')}}/' + item.logo,
                        title: item.title_bn,
                        description: item.address,
                        selector: 'institute'
                    });
                });
                if (resetPage) {
                    $('#institute_name_list').html(html);
                } else {
                    $('#institute_name_list').append(html);
                }
            });
        }

        function courseSearch(search = '', institute_id = '', el = '#course_name_list', url = null, resetPage = true) {
            const filters = {};
            if (search?.toString()?.length) {
                filters['title_bn'] = {
                    type: 'contain',
                    value: search
                };
            }
            if (institute_id?.toString()?.length) {
                filters['institute_id'] = institute_id;
            }
            filters['row_status'] = '{{\Module\CourseManagement\App\Models\Course::ROW_STATUS_ACTIVE}}'

            let domainInstitute = $('#domain-institute').val();
            if (domainInstitute?.toString()?.length) {
                filters['institute_id'] = domainInstitute;
            }

            $('.course_overlay').show();
            courseFetch(filters, resetPage, url)?.then(function (response) {
                console.log('search')
                $('.course_overlay').hide();
                $('#course_pagination').html(response?.data?.next_page_url);
                let html = '';

                if (resetPage) {
                    let muktoPathCoursesFiltered = muktoPathCourses;
                    if (search.toString().length) {
                        muktoPathCoursesFiltered = muktoPathCoursesFiltered.filter((item) => item.course_alias_name.includes(search));
                    }

                    $.each(muktoPathCoursesFiltered, function (i, item) {
                        html += template({
                            id: item.id,
                            imageUrl: muktoPathImageBasePath + item.thumnail?.file_encode_path,
                            title: item.course_alias_name,
                            description: item.institution_name_bn,
                            selector: 'course mukto-path',
                        });
                    });
                }

                $.each(response.data.data, function (i, item) {
                    html += template({
                        id: item.id,
                        imageUrl: '{{asset('/storage/')}}/' + item.course_cover_image,
                        title: item.course_title_bn,
                        description: item.institute_title_bn,
                        selector: 'course',
                    });
                });

                if (resetPage) {
                    $(el ? el : '#course_name_list_modal').html(html);
                } else {
                    $(el ? el : '#course_name_list_modal').append(html);
                }
            });
        }

        function courseSearchForProgramme(search = '', programme_id = '') {
            const filters = {};
            if (search?.toString()?.length) {
                filters['title_bn'] = {
                    type: 'contain',
                    value: search
                };
            }
            if (programme_id?.toString()?.length) {
                filters['programme_id'] = programme_id;
            }
            let domainInstitute = $('#domain-institute').val();
            if (domainInstitute?.toString()?.length) {
                filters['institute_id'] = domainInstitute;
            }

            courseFetchForProgramme(filters)?.then(function (response) {
                let html = '';
                $.each(response.data.data, function (i, item) {
                    html += template({
                        id: item.id,
                        imageUrl: '{{asset('/storage/')}}/' + item.course_cover_image,
                        title: item.course_title_bn,
                        description: item.institute_title_bn,
                        selector: 'course',
                    });
                });
                $('#course_name_list_modal').html(html);
            });
        }

        function programmeSearch(search = '', resetPage = true, url = null) {
            const filters = {};
            if (search?.toString()?.length) {
                filters['title_bn'] = {
                    type: 'contain',
                    value: search
                };
            }
            let domainInstitute = $('#domain-institute').val();
            if (domainInstitute?.toString()?.length) {
                filters['institute_id'] = domainInstitute;
            }

            $('.program_overlay').show();
            programmeFetch(filters, resetPage, url)?.then(function (response) {
                $('.program_overlay').hide();
                $('#program_pagination').html(response?.data?.next_page_url);
                let html = '';
                $.each(response.data.data, function (i, item) {
                    html += template({
                        id: item.id,
                        imageUrl: '{{asset('/storage/')}}/' + item.logo,
                        title: item.title_bn,
                        description: item.institute_title_bn,
                        selector: 'programme',
                    });

                    if (resetPage) {
                        $('#program_name_list').html(html);
                    } else {
                        $('#program_name_list').append(html);
                    }
                });
            });
        }

        $(document).ready(function () {
            $('#institute_name_list').on('scroll', _.debounce(function () {
                let url = $('#institute_pagination').text();
                if (Math.ceil($(this).scrollTop()) + Math.ceil($(this).innerHeight()) >= $(this)[0].scrollHeight && url) {
                    instituteSearch('', false, url);
                }
            }, 200));


            $('#course_name_list').on('scroll', _.debounce(function () {
                let url = $('#course_pagination').text();
                if (Math.ceil($(this).scrollTop()) + Math.ceil($(this).innerHeight()) >= $(this)[0].scrollHeight && url) {
                    courseSearch('', '', '#course_name_list', url, false);
                }
            }, 200));

            $('#program_name_list').on('scroll', _.debounce(function () {
                let url = $('#program_pagination').text();
                if (Math.ceil($(this).scrollTop()) + Math.ceil($(this).innerHeight()) >= $(this)[0].scrollHeight && url) {
                    programmeSearch('', false, url);
                }
            }, 200));


            let domainInstitute = $('#domain-institute').val();
            if (!domainInstitute) {
                instituteSearch();
            }
            courseSearch();
            programmeSearch();

            $('#institute_name').keyup(function () {
                let search = $(this).val();
                if (search?.length) {
                    instituteSearch(search);
                } else {
                    instituteSearch();
                }
            });

            $('#course_name').keyup(function () {
                let search = $(this).val();
                if (search?.length) {
                    courseSearch(search);
                } else {
                    courseSearch();
                }
            });

            $('#course_name_modal').keyup(function () {
                let search = $(this).val();
                let instituteId = $(this).data('institute-id');
                let programmeId = $(this).data('programme-id');

                if (instituteId) {
                    if (search?.length) {
                        courseSearch(search, instituteId, '#course_name_list_modal');
                    } else {
                        courseSearch('', instituteId, '#course_name_list_modal');
                    }
                } else if (programmeId) {
                    if (search?.length) {
                        courseSearchForProgramme(search, programmeId, '#course_name_list_modal');
                    } else {
                        courseSearchForProgramme('', programmeId, '#course_name_list_modal');
                    }
                }
            });
            $('#program_name').keyup(function () {
                let search = $(this).val();
                if (search?.length) {
                    programmeSearch(search);
                }
            })

            $(document).on('click', '.institute', function () {
                const institute_id = $(this).data('id');
                if (institute_id?.toString()?.length) {
                    $('#course_list_modal').modal('show');
                    $('#course_name_modal').attr('data-institute-id', institute_id);
                    $('#course_name_modal').attr('data-programme-id', '');
                    courseSearch('', institute_id, '', '#course_name_list_modal');
                }
            });
            $(document).on('click', '.course', function () {
                const course_id = $(this).data('id');
                console.log(course_id)
                if ($(this).hasClass('mukto-path')) {
                    openMuktopathCourse(course_id);
                } else {
                    courseDetailsModalOpen(course_id);
                }
            });
            $(document).on('click', '.programme', function () {
                const programme_id = $(this).data('id');
                if (programme_id?.toString()?.length) {
                    $('#course_list_modal').modal('show');
                    $('#course_name_modal').attr('data-institute-id', '');
                    $('#course_name_modal').attr('data-programme-id', programme_id);
                    courseSearchForProgramme('', programme_id);
                }
            });
        });
    </script>

@endpush
