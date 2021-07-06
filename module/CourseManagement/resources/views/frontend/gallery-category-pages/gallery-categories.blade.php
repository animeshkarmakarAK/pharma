@php
    $currentInstitute = domainConfig('institute');
    $layout = $currentInstitute ? 'master::layouts.custom1' : 'master::layouts.front-end';
@endphp
@extends($layout)

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header custom-bg-gradient-info">
                            <h1 class="text-center text-primary mt-4">গ্যালারীর অ্যালবাম সমূহ</h1>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-1 offset-1">
                                <i class="fa fa-filter">Filter</i>
                            </div>
                            <div class="form-group col-md-3">
                                <select class="form-control select2-ajax-wizard"
                                        name="programme_id"
                                        id="programme_id"
                                        data-model="{{base64_encode(\Module\CourseManagement\App\Models\Programme::class)}}"
                                        data-label-fields="{title_en}"
                                        data-dependent-fields="#batch_id"
                                        data-placeholder="প্রোগ্রাম নির্বাচন করুন"
                                >
                                </select>
                            </div>
                            <div class="form-group col-md-3">
                                <select class="form-control select2-ajax-wizard"
                                        name="batch_id"
                                        id="batch_id"
                                        data-model="{{base64_encode(\Module\CourseManagement\App\Models\Batch::class)}}"
                                        data-label-fields="{title_en}"
                                        data-depend-on-optional="programme_id"
                                        data-placeholder="ব্যাচ নির্বাচন করুন"
                                >
                                </select>
                            </div>
                            <div class="col-md-1">
                                <button class="btn btn-success"
                                        id="gallery-album-search-btn">{{ __('অনুসন্ধান') }}</button>
                            </div>
                        </div>
                        <div class="row" id="container-album">

                        </div>
                        <div class="row mb-5">
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
    </div>
@endsection

@push('css')

@endpush

@push('js')
    <script>
        const template = function (item) {
            let html = ` <div class="col-md-3">`;
            html += `<div class="card">`;
            let src = "{{ route('course_management::gallery-category', '__') }}".replace('__', item.id)
            html += '<a href="' + src + '">';
            html += '<img class="card-img-top" src="/storage/' + item.image + '" height="250" alt="Card image cap">';
            html += '</a>';
            html += `<div class="card-body">`;
            html += '<h5 class="card-title">' + item.title_bn + '</h5>';
            html += '<p class="card-text">Programme: ' + item?.programme_title_bn ?? "N/A" + '</p>';
            html += '<p class="card-text">Batch: ' + item.batch_title_bn ?? "N/A" + '</p>';
            html += '</div></div></div>';
            return html;
        };

        const paginatorLinks = function (link) {
            let html = '';
            if (link.active) {
                html += '<li class="page-item active"><a class="page-link">' + link.label + '</a></li>';
            } else if (!link.url) {
                html += '<li class="page-item"><a class="page-link">' + link.label + '</a></li>';
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
                            per_page: 5,
                            filters,
                        }
                    }
                }).done(function (response) {
                    return response;
                });
            };
        };

        let baseUrl = '{{route('web-api.model-resources')}}';
        const skillVideoFetch = searchAPI({
            model: "{{base64_encode(\Module\CourseManagement\App\Models\GalleryCategory::class)}}",
            columns: 'title_en|title_bn|image|batch.title_bn|programme.title_bn|institute_id'
        });

        function albumSearch(url = baseUrl) {
            $('.overlay').show();
            let currentInstitute = {!! $currentInstitute !!};
            let programme = $('#programme_id').val();
            let batch = $('#batch_id').val();

            const filters = {};
            if (currentInstitute) {
                filters['institute_id'] = currentInstitute.id;
            }
            if (programme?.toString()?.length) {
                filters['programme_id'] = programme;
            }
            if (batch?.toString()?.length) {
                filters['batch_id'] = batch;
            }

            skillVideoFetch(url, filters)?.then(function (response) {
                console.table('response', response);
                $('.overlay').hide();
                window.scrollTo(0, 0);
                let html = '';
                if (response?.data?.data.length <= 0) {
                    html += '<div class="col-md-12 justify-content-center"><div class="text-center h3">কোন অ্যালবাম খুঁজে পাওয়া যায়নি!</div></div>';
                }
                $.each(response.data?.data, function (i, item) {
                    html += template(item);
                });

                $('#container-album').html(html);
                // $('.prev-next-button').html(response?.pagination);
                console.table("response", response.data.links);

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
            albumSearch();

            $(document).on('click', '.pagination .page-link', function (e) {
                e.preventDefault();
                let url = $(this).attr('href');
                if (url) {
                    albumSearch(url);
                }
            });

            $('#gallery-album-search-btn').on('click', function () {
                albumSearch();
            });
        });
    </script>

@endpush
