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
                        <div class="card-body bg-gray-light">
                            <div class="row">
                                @foreach($galleryCategories as $galleryCategory)
                                    <div class="col-md-3">
                                        <a href="{{ route('gallery-category', $galleryCategory->id) }}">
                                            <div class="card mr-1 text-center">
                                                <div style="background: url('{{asset('/storage/'. $galleryCategory->image)}}') no-repeat center center / cover; height: 180px">
                                                </div>
                                                <div class="card-body">
                                                    <h5 class="card-title">{{ $galleryCategory->title_bn }}</h5>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                @endforeach

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

    </script>

@endpush
