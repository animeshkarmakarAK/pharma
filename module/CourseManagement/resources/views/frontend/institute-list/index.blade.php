@php
    $layout = 'master::layouts.front-end';
@endphp

@extends($layout)

@section('title')
    Institutes
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card mb-2">
                    <div class="card-header p-5">
                        <h2 class="card-header-title text-center text-dark font-weight-bold">Institutes</h2>
                    </div>
                    <div class="card-background-white px-5 py-4">
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-1">
                                        <label
                                            style="color: #757575; line-height: calc(1.5em + .75rem); font-size: 1rem; font-weight: 400;">
                                            &nbsp;&nbsp;<i class="fa fa-filter mr-2"></i> ফিল্টার
                                        </label>
                                    </div>

                                    <div class="col-md-2">
                                        <button class="btn btn-success button-bg mb-2"
                                                id="skill-video-search-btn">{{ __('অনুসন্ধান') }}</button>
                                    </div>

                                    <div class="col-md-3 mb-3">
                                        <div class="input-group">
                                            <input type="search" name="search" id="search" class="form-control"
                                                   placeholder="অনুসন্ধান করুন ..." style="border: 1px solid #e5e5e5;">
                                            <div class="input-group-append">
                                                <button class="btn button-bg text-white" type="button">
                                                    <i class="fa fa-search"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col">
                                        <div class="overlay" style="display: none; background: inherit; color: inherit">
                                            <i class="fas fa-2x fa-sync-alt fa-spin"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row justify-content-center pt-4" id="container-publish-courses"></div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="prev-next-button float-right">

                                </div>
                                <div class="overlay" style="display: none">
                                    <i class="fas fa-2x fa-sync-alt fa-spin"></i>
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
                .card-background-white {
                    background: #faf8fb;
                }

                .form-control {
                    border: 1px solid #671688;
                    color: #671688;
                }

                .form-control:focus {
                    border-color: #671688;
                }

                .button-bg {
                    background: #671688;
                    border-color: #671688;
                }

                .button-bg:hover {
                    color: #ffffff;
                    background-color: #671688 !important;;
                    border-color: #671688 !important;;
                }

                .button-bg:active {
                    color: #ffffff;
                    background-color: #671688 !important;
                    border-color: #671688 !important;;
                }

                .button-bg:focus {
                    color: #ffffff;
                    background-color: #671688 !important;;
                    border-color: #671688 !important;;
                }

                .button-bg:visited {
                    color: #ffffff;
                    background-color: #671688 !important;;
                    border-color: #671688 !important;;
                }

                .card-header-title {
                    min-height: 48px;
                }

                .card-bar-home-course img {
                    height: 14vw;
                }

                .gray-color {
                    color: #73727f;
                }

                .course-heading-wrap {
                    text-overflow: ellipsis;
                    white-space: nowrap;
                    overflow: hidden;
                }

                .course-heading-wrap:hover {
                    overflow: visible;
                    white-space: normal;
                    cursor: pointer;
                }

                .course-p {
                    font-size: 14px;
                    font-weight: 400;
                    color: #671688;
                }

                .header-bg {
                    background: #671688;
                    color: white;
                }

                .modal-header .close, .modal-header .mailbox-attachment-close {
                    padding: 1rem;
                    margin: -1rem -1rem -1rem auto;
                    color: white;
                    outline: none;
                }

                .card-p1 {
                    color: #671688;
                }
            </style>
        @endpush
        @push('js')

            <script>
                let banglaNumber = {
                    0: "০",
                    1: "১",
                    2: "২",
                    3: "৩",
                    4: "৪",
                    5: "৫",
                    6: "৬",
                    7: "৭",
                    8: "৮",
                    9: "৯",
                };
                const engToBdNum = (str) => {
                    for (var x in banglaNumber) {
                        str = str.replace(new RegExp(x, "g"), banglaNumber[x]);
                    }
                    return str;
                };

                const template = function (item) {
                    let html = '';
                    html += '<div class="col-md-3">';
                    html += '<div class="card card-main mb-3">';
                    html += '<div class="card-bar-home-course">';
                    html += '<div class="pb-3">';
                    html += '<img class="slider-img border-top-radius"';
                    html += 'src="{{asset('/storage/'. '__')}}"'.replace('__', item?.cover_image) + '" width="100%"';
                    html += 'alt="icon">';
                    html += '</div>';
                    html += '<div class="text-left pl-4 pr-4 pt-1 pb-1">';

                    html += '<p class="font-weight-bold course-heading-wrap">' + item?.title_en + '</p>';
                    html += '<p class="font-weight-light mb-1"><i';
                    html += 'class="fas fa-clock gray-color"></i> <span ';
                    html += 'class="course-p"><i class="fas fa-clock gray-color mr-2"></i>' + (item?.post_head_name ? item.post_head_name : ' সময়কাল নির্ধারিত হয়নি') +
                        '</span>';
                    html += '</p>';
                    html += '<p class="font-weight-light mb-0"><i';
                    html += 'class="fas fa-user-plus gray-color"></i>';
                    html += '<span ';
                    html += 'class="course-p"><i class="fas fa-user-plus gray-color mr-2"></i>' +
                        'আসন সংখ্যা ( <span class="max-enroll">' + item?.total_seat + '</span> )</span>';
                    html += '</p>';

                    html += '<p class="float-right">';
                    html += '<a href="javascript:;"';
                    html += 'onclick="courseDetailsModalOpen(' + item?.id + ')"';
                    html += 'class="btn btn-primary btn-sm">বিস্তারিত</a>';
                    html += '</p>';
                    html += '</div>';
                    html += '</div>';
                    html += '</div> ';
                    html += '</div>';

                    return html;
                }

                const paginatorLinks = function (link) {
                    if (link.label == 'pagination.previous') {
                        link.label = 'Previous'
                    }
                    if (link.label == 'pagination.next') {
                        link.label = 'Next'
                    }
                    let html = '';
                    if (link.active) {
                        html += '<li class="page-item active">' +
                            '<a class="page-link">' + link.label + '</a>' +
                            '</li>';
                    } else if (!link.url) {
                        html += '<li class="page-item">' +
                            '<a class="page-link">' + link.label + '</a>' +
                            '</li>';
                    } else {
                        html += '<li class="page-item"><a class="page-link" href="' + link.url + '">' + link.label + '</a></li>';
                    }
                    return html;
                }


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
                const instituteFetch = searchAPI({
                    model: "{{base64_encode(\Module\CourseManagement\App\Models\Institute::class)}}",
                    columns: 'id|title_en'
                });

                function instituteSearch(url = baseUrl) {
                    $('.overlay').show();
                    let searchQuery = $('#search').val();

                    const filters = {};
                    if (searchQuery?.toString()?.length) {
                        filters['institute.title_en'] = {
                            type: 'contain',
                            value: searchQuery
                        };
                    }

                    instituteFetch(url, filters)?.then(function (response) {
                        $('.overlay').hide();
                        window.scrollTo(0, 0);
                        let html = '';
                        if (response?.data?.data.length <= 0) {
                            html += '<div class="text-center mt-5" "><i class="fa fa-sad-tear fa-2x text-warning mb-3"></i><div class="text-center text-danger h3">কোন কোর্স খুঁজে পাওয়া যায়নি!</div>';
                        }

                        $.each(response.data?.data, function (i, item) {
                            html += template(item);
                        });

                        $('#container-publish-courses').html(html);

                        let link_html = '<nav> <ul class="pagination">';
                        let links = response?.data?.links;
                        if (links.length > 3) {
                            $.each(links, function (i, link) {
                                link_html += paginatorLinks(link);
                            });
                        }
                        link_html += '</ul></nav>';
                        $('.prev-next-button').html(link_html);
                    });
                }

                $(document).ready(function () {
                    instituteSearch();
                    $(document).on('click', '.pagination .page-link', function (e) {
                        e.preventDefault();
                        let url = $(this).attr('href');
                        if (url) {
                            instituteSearch(url);
                        }
                    });

                    $("#search").on("keyup change", function (e) {
                        instituteSearch();
                    })
                });
            </script>
    @endpush

