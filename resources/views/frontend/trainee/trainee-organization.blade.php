@php
    $currentInstitute = app('currentInstitute');
    $layout = 'master::layouts.front-end';
@endphp
@extends($layout)

@section('title')
    আমার কোর্স সমূহ
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row trainee-profile" id="trainee-profile">
            <div class="col-md-3 mt-2">
                <div class="user-details card mb-3">
                    <div
                        class="card-header custom-bg-gradient-info">
                        <div class="card-title float-left font-weight-bold text-primary">বিস্তারিত</div>
                        <div class="trainee-access-key float-right d-inline-flex">
                            <p class="label-text font-weight-bold">এক্সেস-কী &nbsp;:&nbsp; </p>
                            <div class="font-weight-bold">
                                {{ "  ".$trainee->access_key ?? 'N/A' }}
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="user-image text-center">
                            <img
                                src="{{ asset('storage/'. $trainee->student_pic) }}"
                                height="100" width="100" class="rounded-circle" alt="Trainee profile picture">
                        </div>
                        <div class="d-flex justify-content-center user-info normal-line-height mt-3">
                            <div>
                                {{ optional($trainee)->name }}
                            </div>
                            <p class="text-center ml-2">({{ optional($trainee)->name}})</p>
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
                            <p class="medium-text">{{ $trainee->mobile ? $trainee->mobile : "N/A" }}</p>
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
                            <p class="medium-text">{{ $trainee->email ?? "N/A"}}</p>
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
                                src="{{ asset('storage/'. $trainee->student_signature_pic) }}"
                                height="40" alt="Trainee profile picture">
                        </div>
                    </div>
                </div>

            </div>

            <div class="col-md-9 mt-2">
                <div class="card bg-white">
                    <div
                        class="card-header custom-bg-gradient-info">
                        <div class="card-title float-left font-weight-bold text-primary">আমার কর্মস্থল</div>
                        <div class="trainee-access-key float-right d-inline-flex">
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
                                        <div class="col-md-3 mb-3">
                                            <div class="text-center border rounded p-2">
                                                <img
                                                    src="{{ !empty($organization)? asset('storage/'. $organization->organization->logo) :'' }}"
                                                    class="" alt="My Industry Logo" width="80px">
                                                <div>
                                                    <h5 class="text-bold mt-3">{{ !empty($organization)?$organization->organization->title:'' }}</h5>
                                                    <a href="{{ route('frontend.trainee-complain-to-organization-form') }}"
                                                       class="btn btn-primary mt-3">অভিযোগ করুন</a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12 mb-3 mx-auto border rounded p-2">
                                            <h5 class="">আমার অভিযোগ সমূহ : </h5>
                                            <div class="table-responsive">
                                                <table class="table table-hover">
                                                    <thead>
                                                    <tr>
                                                        <th scope="col">ক্রম</th>
                                                        <th scope="col">প্রাপক</th>
                                                        <th scope="col">ইন্ডাস্ট্রির নাম</th>
                                                        <th scope="col">শিরোনাম</th>
                                                        <th scope="col">অভিযোগের তারিখ</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach($traineeComplains as $key => $traineeComplain)
                                                        <tr title="{{ $traineeComplain->complain_message }}">
                                                            <th scope="row">{{ \App\Helpers\Classes\NumberToBanglaWord::engToBn(++$key)  }}</th>
                                                            <td>{{ $traineeComplain->institute->title }}</td>
                                                            <td>{{ $traineeComplain->organization->title }}</td>
                                                            <td>{{ $traineeComplain->complain_title }}</td>
                                                            <td>{{ \App\Helpers\Classes\EnglishToBanglaDate::dateFormatEnglishToBangla(date('j F, Y h:i A', strtotime($traineeComplain->created_at))) }}</td>
                                                        </tr>
                                                    @endforeach
                                                    </tbody>
                                                </table>
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


