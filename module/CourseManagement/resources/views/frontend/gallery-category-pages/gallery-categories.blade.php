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
                                        data-placeholder="নির্বাচন করুন"
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
                                        data-placeholder="নির্বাচন করুন"
                                >
                                </select>
                            </div>
                            <div class="col-md-1">
                                <button class="btn btn-success" id="skill-video-search-btn">{{ __('অনুসন্ধান') }}</button>
                            </div>
                        </div>

                        <div class="card-body bg-gray-light">
                            <div class="row">
                                @foreach($galleryCategories as $galleryCategory)
                                    <div class="col-md-3">
                                        <a href="{{ route('course_management::gallery-category', $galleryCategory->id) }}">
                                            <div class="card mr-1 text-center">
                                                <div
                                                    style="background: url('{{asset('/storage/'. $galleryCategory->image)}}') no-repeat center center / cover; height: 180px">
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
