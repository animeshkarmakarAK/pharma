@php
    $currentInstitute = domainConfig('institute');
    $layout = 'master::layouts.front-end';
@endphp
@extends($layout)

@section('title')
    ইয়ুথ প্রোফাইল
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row youth-profile" id="youth-profile">
            <div class="col-md-4 mt-2">
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

                <div class="card bg-white">
                    <div class="card-header custom-bg-gradient-info text-primary">
                        <h3 class="card-title font-weight-bold">ঠিকানা</h3>
                    </div>
                    <div class="card-body">
                        <div class="row mt-2">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-header">
                                        <div class="card-title">বর্তমান ঠিকানা</div>
                                    </div>
                                    <div class="card-body row">
                                        <div class="col-md-6 custom-view-box">
                                            <p class="label-text">বিভাগ</p>
                                            <div class="input-box">
                                                {{ optional($youth->presentAddressDivision)->title ?? "" }}
                                            </div>
                                        </div>
                                        <div class="col-md-6 custom-view-box">
                                            <p class="label-text">জেলা</p>
                                            <div class="input-box">
                                                {{ optional($youth->presentAddressDistrict)->title ?? "" }}
                                            </div>
                                        </div>
                                        <div class="col-md-6 custom-view-box">
                                            <p class="label-text">উপজেলা</p>
                                            <div class="input-box">
                                                {{ optional($youth->presentAddressUpazila)->title ?? "" }}
                                            </div>
                                        </div>
                                        <div class="col-md-6 custom-view-box">
                                            <p class="label-text">পোস্ট অফিস</p>
                                            <div class="input-box">
                                                {{ $youth->present_address_house_address['postal_code'] ?? "" }}
                                            </div>
                                        </div>
                                        <div class="col-md-6 custom-view-box">
                                            <p class="label-text">গ্রাম</p>
                                            <div class="input-box">
                                                {{ $youth->present_address_house_address['village_name'] ?? "" }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-header">
                                        <div class="card-title">স্থায়ী ঠিকানা</div>
                                    </div>
                                    <div class="card-body row">
                                        <div class="col-md-6 custom-view-box">
                                            <p class="label-text">বিভাগ</p>
                                            <div class="input-box">
                                                {{ $youth->permanentAddressDivision->title ?? "" }}
                                            </div>
                                        </div>
                                        <div class="col-md-6 custom-view-box">
                                            <p class="label-text">জেলা</p>
                                            <div class="input-box">
                                                {{ optional($youth->permanentAddressDistrict)->title }}
                                            </div>
                                        </div>
                                        <div class="col-md-6 custom-view-box">
                                            <p class="label-text">উপজেলা</p>
                                            <div class="input-box">
                                                {{ optional($youth->permanentAddressUpazila)->title }}
                                            </div>
                                        </div>
                                        <div class="col-md-6 custom-view-box">
                                            <p class="label-text">পোস্ট অফিস</p>
                                            <div class="input-box">
                                                {{ $youth->permanent_address_house_address['postal_code'] ?? "" }}
                                            </div>
                                        </div>
                                        <div class="col-md-6 custom-view-box">
                                            <p class="label-text">গ্রাম</p>
                                            <div class="input-box">
                                                {{ $youth->permanent_address_house_address['village_name'] ?? "" }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <div class="col-md-8 mt-2">
                <div class="card bg-white">
                    <div
                        class="card-header custom-bg-gradient-info">
                        <div class="card-title float-left font-weight-bold text-primary">ব্যাক্তিগত তথ্য</div>
                        <div class="card-tools">
                            <a href="#" class="btn btn-sm btn-warning"
                               id="downloadPDF" onclick="Export()">
                                <i class="fas fa-backward"></i> ডাউনলোড পিডিএফ
                            </a>
                        </div>
                        <div class="youth-access-key float-right d-inline-flex">
                            <p class="label-text font-weight-bold">&nbsp;</p>
                            <div class="font-weight-bold">
                                &nbsp;
                            </div>
                        </div>
                    </div>

                    <div class="card-body row">
                        <div class="col-md-6 custom-view-box">
                            <p class="label-text">নাম(ইংলিশ)</p>
                            <div class="input-box">
                                {{ optional($youth)->name_en}}
                            </div>
                        </div>

                        <div class="col-md-6 custom-view-box">
                            <p class="label-text">নাম(বাংলা)</p>
                            <div class="input-box">
                                {{ optional($youth)->name_bn}}
                            </div>
                        </div>
                        {{--@dd($youthSelfInfo)--}}

                        <div class="col-md-6 custom-view-box">
                            <p class="label-text">লিঙ্গ</p>
                            <div class="input-box">
                                {{ optional($youthSelfInfo)->gender==1 ?'পুরুষ': (optional($youthSelfInfo)->gender==2 ?'নারী':'হিজড়া')}}
                            </div>
                        </div>

                        <div class="col-md-6 custom-view-box">
                            <p class="label-text">জন্ম তারিখ</p>
                            <div class="input-box">
                                {{ optional($youthSelfInfo)->date_of_birth ?? "N/A"}}
                            </div>
                        </div>

                        <div class="col-md-6 custom-view-box">
                            <p class="label-text">বৈবাহিক অবস্থা</p>
                            <div class="input-box">
                                {{ optional($youthSelfInfo)->marital_status ==1 ?'বিবাহিত':"অবিবাহিত"}}
                            </div>
                        </div>

                        <div class="col-md-6 custom-view-box">
                            <p class="label-text">ধর্ম</p>
                            <div class="input-box">
                                {{ optional($youthSelfInfo)->religion ==1 ?'ইসলাম':(optional($youthSelfInfo)->religion ==2 ?'হিন্দু':(optional($youthSelfInfo)->religion ==3 ?'খ্রিস্টান':(optional($youthSelfInfo)->religion ==4 ?'বৌদ্ধ':(optional($youthSelfInfo)->religion ==5 ?'জৈন':'অন্যান্য'))))}}
                            </div>
                        </div>

                        <div class="col-md-6 custom-view-box">
                            <p class="label-text">জাতীয়তা</p>
                            <div class="input-box">
                                {{ optional($youthSelfInfo)->nationality =='bd' ?'বাংলাদেশী':'অন্যান্য'}}
                            </div>
                        </div>

                        <div class="col-md-6 custom-view-box">
                            <p class="label-text">এন.আই.ডি নাম্বার</p>
                            <div class="input-box">
                                {{ optional($youthSelfInfo)->nid ??'N/A'}}
                            </div>
                        </div>
                        <div class="col-md-6 custom-view-box">
                            <p class="label-text">জন্ম সনদ</p>
                            <div class="input-box">
                                {{ optional($youthSelfInfo)->birth_certificate_no ??'N/A'}}
                            </div>
                        </div>
                        <div class="col-md-6 custom-view-box">
                            <p class="label-text">পাসপোর্ট নাম্বার</p>
                            <div class="input-box">
                                {{ optional($youthSelfInfo)->passport_number ??'N/A'}}
                            </div>
                        </div>

                    </div>
                </div>

                <div class="card">
                    <div class="card-header custom-bg-gradient-info">
                        <div class="card-title text-primary font-weight-bold">শিক্ষাগত যোগ্যতা</div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <table class="table table-bordered rounded">
                                <tr>
                                    <td>পরীক্ষা</td>
                                    <td>বোর্ড</td>
                                    <td>বিভাগ</td>
                                    <td>ফলাফল</td>
                                    <td>পাসের বছর</td>
                                    <td>রোল নং</td>
                                    <td>কোর্স সময়কাল</td>
                                </tr>
                                @if(count($academicQualifications) > 0)
                                    @foreach($academicQualifications as $key => $academicQualification)
                                        <tr>
                                            <td class="text-center">
                                                @switch($academicQualification->examination)
                                                    @case(\App\Models\YouthAcademicQualification::EXAMINATION_JSC)
                                                    {{ $academicQualification->getExamination() .'/'. $academicQualification->getJSCExaminationName() }}
                                                    @break
                                                    @case(\App\Models\YouthAcademicQualification::EXAMINATION_SSC)
                                                    {{ $academicQualification->getExamination() .'/'. $academicQualification->getSSCExaminationName() }}
                                                    @break
                                                    @case(\App\Models\YouthAcademicQualification::EXAMINATION_HSC)
                                                    {{ $academicQualification->getExamination() .'/'. $academicQualification->getHSCExaminationName() }}
                                                    @break
                                                    @case(\App\Models\YouthAcademicQualification::EXAMINATION_GRADUATION)
                                                    {{ $academicQualification->getExamination() .'/'. $academicQualification->getGraduationExaminationName() }}
                                                    @break
                                                    @case(\App\Models\YouthAcademicQualification::EXAMINATION_MASTERS)
                                                    {{ $academicQualification->getExamination() .'/'. $academicQualification->getMastersExaminationName() }}
                                                    @break
                                                @endswitch
                                            </td>

                                            <td class="text-center">
                                                @if($academicQualification->examination == \App\Models\YouthAcademicQualification::EXAMINATION_JSC || $academicQualification->examination == \App\Models\YouthAcademicQualification::EXAMINATION_SSC || $academicQualification->examination == \App\Models\YouthAcademicQualification::EXAMINATION_HSC)
                                                    {{ $academicQualification->getExaminationTakingBoard() }}
                                                @else
                                                    {{ $academicQualification->getCurrentUniversity() }}
                                                @endif
                                            </td>

                                            <td class="text-center">
                                                {{ ($academicQualification->getExaminationGroup() ? $academicQualification->getExaminationGroup() : $academicQualification->subject) ?:'N/A' }}
                                            </td>

                                            <td class="text-center">
                                                {{ $academicQualification->grade == null ? $academicQualification->getExaminationResult() :$academicQualification->grade . ($academicQualification->getExaminationResult()? '/'.$academicQualification->getExaminationResult():'') }}
                                            </td>

                                            <td class="text-center">
                                                {{ $academicQualification->passing_year }}
                                            </td>

                                            <td class="text-center">
                                                {{ $academicQualification->roll_no ?? 'N/A'}}
                                            </td>

                                            <td class="text-center">
                                                {{ $academicQualification->course_duration ? $academicQualification->course_duration . ' Years' : 'N/A' }}
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            </table>
                        </div>
                    </div>
                </div>

                @if($haveYouthFamilyMembersInfo)
                    <div class="card">
                        <div class="card-header custom-bg-gradient-info">
                            <div class="card-title text-primary font-weight-bold">পরিবারের সদস্যদের তথ্য</div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="card">
                                        <div class="card-header">
                                            <div class="card-title">
                                                পিতা
                                            </div>
                                        </div>
                                        <div class="card-body row">
                                            <div class="col-md-6 custom-view-box">
                                                <p class="label-text">নাম</p>
                                                <div class="input-box">
                                                    {{ optional($father)->member_name_en }}
                                                </div>
                                            </div>
                                            <div class="col-md-6 custom-view-box">
                                                <p class="label-text">মোবাইল</p>
                                                <div class="input-box">
                                                    {{ optional($father)->mobile}}
                                                </div>
                                            </div>
                                            <div class="col-md-6 custom-view-box">
                                                <p class="label-text">এন.আই.ডি</p>
                                                <div class="input-box">
                                                    {{ optional($father)->nid }}
                                                </div>
                                            </div>
                                            <div class="col-md-6 custom-view-box">
                                                <p class="label-text">জন্মতারিখ</p>
                                                <div class="input-box">
                                                    {{ !empty($father) ? \Illuminate\Support\Carbon::parse($father->date_of_birth)->format('d M Y') : ''}}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card">
                                        <div class="card-header">
                                            <div class="card-title">
                                                মাতা
                                            </div>
                                        </div>
                                        <div class="card-body row">
                                            <div class="col-md-6 custom-view-box">
                                                <p class="label-text">নাম</p>
                                                <div class="input-box">
                                                    {{ optional($mother)->member_name_en}}
                                                </div>
                                            </div>
                                            <div class="col-md-6 custom-view-box">
                                                <p class="label-text">মোবাইল</p>
                                                <div class="input-box">
                                                    {{ optional($mother)->mobile}}
                                                </div>
                                            </div>
                                            <div class="col-md-6 custom-view-box">
                                                <p class="label-text">এন.আই.ডি</p>
                                                <div class="input-box">
                                                    {{ optional($mother)->nid }}
                                                </div>
                                            </div>
                                            <div class="col-md-6 custom-view-box">
                                                <p class="label-text">জন্মতারিখ</p>
                                                <div class="input-box">
                                                    {{  !empty($mother) ?  \Illuminate\Support\Carbon::parse($mother->date_of_birth)->format('d M Y') : '' }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @if(!empty($guardian) && $guardian == $father)
                                    <p class="label-text font-weight-bold mr-1">অভিভাবক: </p> পিতা
                                @elseif(!empty($guardian) && $guardian == $mother)
                                    <p class="label-text font-weight-bold mr-1">অভিভাবক: </p> মাতা
                                @elseif(!empty($guardian))
                                    <div class="col-md-6">
                                        <div class="card">
                                            <div class="card-header">
                                                <div class="card-title">
                                                    অভিভাবক
                                                </div>
                                            </div>
                                            <div class="card-body row">
                                                <div class="col-md-6 custom-view-box">
                                                    <p class="label-text">নাম</p>
                                                    <div class="input-box">
                                                        {{ $guardian->member_name_en ?? "" }}
                                                    </div>
                                                </div>
                                                <div class="col-md-6 custom-view-box">
                                                    <p class="label-text">মোবাইল</p>
                                                    <div class="input-box">
                                                        {{ $guardian->mobile ?? "" }}
                                                    </div>
                                                </div>
                                                <div class="col-md-6 custom-view-box">
                                                    <p class="label-text">এন.আই.ডি</p>
                                                    <div class="input-box">
                                                        {{ $guardian->nid ?? "" }}
                                                    </div>
                                                </div>
                                                <div class="col-md-6 custom-view-box">
                                                    <p class="label-text">জন্মতারিখ</p>
                                                    <div class="input-box">
                                                        {{ \Illuminate\Support\Carbon::parse($guardian->date_of_birth)->format('d M Y') ?? "" }}
                                                    </div>
                                                </div>
                                                <div class="col-md-6 custom-view-box">
                                                    <p class="label-text">সম্পর্ক</p>
                                                    <div class="input-box">
                                                        {{ $guardian->relation_with_youth ?? "" }}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script src="{{ asset('jsfiles/html2canvas.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.40/pdfmake.min.js"></script>
    <script type="text/javascript">
        function getClippedRegion(image, x, y, width, height) {
            let canvas = document.createElement("canvas"), ctx = canvas.getContext("2d");
            canvas.width = width;
            canvas.height = height;
            ctx.drawImage(image, x, y, width, height, 0, 0, width, height);

            return {
                image: canvas.toDataURL(),
                width: 500
            };
        }

        function Export() {
            $('#downloadPDF').hide();
            $('meta').attr('name', 'viewport').attr('initial-scal', '1.0');
            html2canvas($("#youth-profile")[0], {
                onrendered: function (canvas) {
                    let splitAt = 775;
                    let images = [];
                    let y = 0;
                    while (canvas.height > y) {
                        images.push(getClippedRegion(canvas, 0, y, canvas.width, splitAt));
                        y += splitAt;
                    }

                    let docDefinition = {
                        content: images,
                        pageSize: {width: 580, height: 850},
                    };
                    pdfMake.createPdf(docDefinition).download("youth-profile.pdf");

                    setTimeout(function () {
                        window.location.reload(true);
                    }, 5000);
                }
            });
        }
    </script>

@endpush


