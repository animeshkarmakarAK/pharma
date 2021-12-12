@php
    $currentInstitute = domainConfig('institute');
    $layout = 'master::layouts.front-end';
@endphp
@extends($layout)

@section('title')
    অ্যালবাম সমূহ
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card mb-2">
                    <div class="card-header p-5">
                        <h2 class="text-center text-dark font-weight-bold">গ্যালারীর অ্যালবাম সমূহ</h2>
                    </div>
                    <div class="px-5 py-4">
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-1">
                                        <label
                                            style="color: #757575; line-height: calc(1.5em + .75rem); font-size: 1rem; font-weight: 400;">
                                            <i class="fa fa-filter"></i>&nbsp;&nbsp; ফিল্টার
                                        </label>
                                    </div>

                                    <div class="form-group col-md-3">
                                        <select class="form-control select2-ajax-wizard"
                                                name="programme_id"
                                                id="programme_id">

                                            <option value="">প্রোগ্রাম নির্বাচন করুন</option>
                                            @foreach($programmes as $programme)
                                                <option value="{{ $programme->id }}" >{{ $programme->title_bn }}</option>
                                            @endforeach

                                        </select>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <select class="form-control select2-ajax-wizard"
                                                name="batch_id"
                                                id="batch_id"
                                        >
                                            <option value="">ব্যাচ নির্বাচন করুন</option>
                                            @foreach($batches as $batch)
                                                <option value="{{ $batch->id }}" >{{ $batch->title_bn }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <button class="btn btn-success button-bg "
                                                id="gallery-album-search-btn">{{ __('অনুসন্ধান') }}</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row" id="container-album"></div>
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
    <style>
        .album-body{
            max-height: 100px;
            overflow: hidden;
        }
        .form-control {
            border: 1px solid #671688;
            color: #671688;
        }
        .form-control:focus {
            border-color: #671688;
        }
        .button-bg {
            color: #ffffff;
            background-color: #671688 !important;
            border-color: #671688 !important;
        }
        .button-bg:hover {
            color: #ffffff;
            background-color: #671688 !important;
            border-color: #671688 !important;
        }
        .gallery-heading-wrap {
            text-overflow: ellipsis;
            white-space: nowrap;
            overflow: hidden;
        }
        .gallery-heading-wrap:hover {
            overflow: visible;
            white-space: normal;
            cursor: pointer;
        }
        .card{
            box-shadow: 0px 5px 5px #e5e5e5;
            transition: 0.3s;
        }
        .card-title {
            float: none !important;
        }
    </style>

@endpush

@push('js')
    <script>
        const template = function (item) {
            let html = ` <div class="col-md-3 mb-3">`;
            html += `<div class="card m-1">`;
            let src = "{{ route('frontend.gallery-category', '__') }}".replace('__', item.id)
            html += '<a href="' + src + '">';
            html += '<img class="card-img-top" src="/storage/' + item.image + '" height="200" alt="Card image cap">';
            html += '</a>';
            html += `<div class="card-body album-body">`;
            html += '<h5 class="card-title  gallery-heading-wrap pb-2">অ্যালবাম: <span class="font-weight-bold">' + item.title_bn + '</span></h5>';
            if (item.programme_title_bn) {
                html += '<h6 class="card-text  gallery-heading-wrap ">প্রোগ্রাম: ' + item?.programme_title_bn ?? "" + '</h6>';
            }
            if (item.batch_title_bn) {
                html += '<p class="card-text">ব্যাচ:' + item.batch_title_bn + '</p>';
            }
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
                            per_page: 8,
                            filters,
                        }
                    }
                }).done(function (response) {
                    return response;
                });
            };
        };

        let baseUrl = '{{route('web-api.model-resources')}}';
        const galleryAlbumFetch = searchAPI({
            model: "{{base64_encode(\App\Models\GalleryCategory::class)}}",
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

            galleryAlbumFetch(url, filters)?.then(function (response) {
                console.table('response', response);
                $('.overlay').hide();
                window.scrollTo(0, 0);
                let html = '';
                if (response?.data?.data.length <= 0) {
                    html += '<div class="col-md-12 text-center mt-5"><i class="fa fa-sad-tear fa-2x text-warning mb-3"></i><div class="text-center text-danger h3">কোন অ্যালবাম খুঁজে পাওয়া যায়নি!</div></div>';
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
