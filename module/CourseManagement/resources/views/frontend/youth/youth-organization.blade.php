@php
    $currentInstitute = domainConfig('institute');
    $layout = 'master::layouts.front-end';
@endphp
@extends($layout)

@section('title')
    আমার কোর্স সমূহ
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row youth-profile" id="youth-profile">
            <div class="col-md-3 mt-2">
                <div class="user-details card mb-3">
                    <div
                        class="card-header custom-bg-gradient-info">
                        <div class="card-title float-left font-weight-bold text-primary">বিস্তারিত</div>
                        <div class="youth-access-key float-right d-inline-flex">
                            <p class="label-text font-weight-bold">এক্সেস-কী &nbsp;:&nbsp; </p>
                            <div class="font-weight-bold">
                                {{ "  ".$youth->access_key ?? 'N/A' }}
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="user-image text-center">
                            <img
                                src="{{ asset('storage/'. $youth->student_pic) }}"
                                height="100" width="100" class="rounded-circle" alt="Youth profile picture">
                        </div>
                        <div class="d-flex justify-content-center user-info normal-line-height mt-3">
                            <div>
                                {{ optional($youth)->name_bn }}
                            </div>
                            <p class="text-center ml-2">({{ optional($youth)->name_en}})</p>
                        </div>
                    </div>
                </div>

                <div class="user-contact card bg-white mb-3">
                    <div class="card-header">
                        <div class="row">
                            <div class="text-center">
                                <i class="fa fa-phone"></i>
                            </div>
                            <p class="medium-text ml-2 text-primary">{{ __('মোবাইল')  }}</p>
                        </div>
                        <div class="phone">
                            <p class="medium-text">{{ $youth->mobile ? $youth->mobile : "N/A" }}</p>
                        </div>
                    </div>
                    <div class="card-header">
                        <div class="row">
                            <div class="text-center">
                                <i class="fa fa-envelope"></i>
                            </div>
                            <p class="medium-text ml-2 text-primary">{{ __('ই-মেইল') }}</p>
                        </div>
                        <div class="email">
                            <p class="medium-text">{{ $youth->email ?? "N/A"}}</p>
                        </div>
                    </div>
                    <div class="card-header">
                        <div class="row">
                            <div class="text-center">
                                <i class="fas fa-edit"></i>
                            </div>
                            <p class="medium-text ml-2 text-primary">{{ __('স্বাক্ষর') }}</p>
                        </div>
                        <div class="email">
                            <img
                                src="{{ asset('storage/'. $youth->student_signature_pic) }}"
                                height="40" alt="Youth profile picture">
                        </div>
                    </div>
                </div>

            </div>

            <div class="col-md-9 mt-2">
                <div class="card bg-white">
                    <div
                        class="card-header custom-bg-gradient-info">
                        <div class="card-title float-left font-weight-bold text-primary">আমার কর্মস্থল</div>
                        <div class="youth-access-key float-right d-inline-flex">
                            <p class="label-text font-weight-bold">&nbsp;</p>
                            <div class="font-weight-bold">
                                &nbsp;
                            </div>
                        </div>
                    </div>

                    @if(!empty($organization))
                        <div class="card-body row">
                            <div class="card col-md-12 p-2">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <img
                                                src="{{ !empty($organization)? asset('storage/'. $organization->organization->logo) :'' }}"
                                                class="" alt="My Industry Logo" style="width: 80px">
                                            <div>
                                                <h5 class="card-title text-bold mt-3">{{ !empty($organization)?$organization->organization->title_en:'' }}</h5>
                                                <p class="card-text">
                                                    Address: {{ !empty($organization)?$organization->organization->address:'' }}
                                                </p>
                                                <a href="{{ route('course_management::youth-complain-to-organization-form') }}"
                                                   class="btn btn-primary mt-3">অভিযোগ করুন</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    @else
                        <div class="card-body">
                            <h5 class="pb-5">আপনি এখন কোন প্রতিষ্ঠানের সাথে যুক্ত নন</h5>
                        </div>
                    @endif
                </div>


            </div>
        </div>
    </div>


@endsection

@push('css')

@endpush

@push('js')

@endpush


