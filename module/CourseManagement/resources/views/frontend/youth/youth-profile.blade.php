@extends('master::layouts.front-end')

@section('content')
    <div class="container-fluid">
        <div class="row youth-profile" id="youth-profile">
            <div class="col-md-4">
                <div class="user-details card mb-3">
                    <div
                        class="card-header custom-bg-gradient-info">
                        <div class="card-title float-left font-weight-bold text-primary">Youth Details</div>
                        <div class="youth-access-key float-right d-inline-flex">
                            <p class="label-text font-weight-bold">Access Key#: </p>
                            <div>
                                {{ $youth->access_key ?? 'N/A' }}
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="user-image text-center">
                            <img
                                src="{{ asset('storage/'. $youth->youthRegistration->student_pic) }}"
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
                            <p class="medium-text ml-2">{{ __('generic.phone')  }}</p>
                        </div>
                        <div class="phone">
                            <p class="medium-text">{{ $youth->mobile ? $youth->mobile : "N/A" }}</p>
                        </div>
                    </div>
                    <div class="card-header">
                        <div class="row">
                            <div class="text-center">
                                <i class="fa fa-envelope text-primary"></i>
                            </div>
                            <p class="medium-text ml-2 text-primary">{{ __('generic.email') }}</p>
                        </div>
                        <div class="email">
                            <p class="medium-text">{{ $youth->email ?? "N/A"}}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-8">
                <div class="card bg-white">
                    <div class="card-header custom-bg-gradient-info text-primary">
                        <h3 class="card-title font-weight-bold">{{ __('Youth Info') }}</h3>

                        <div class="card-tools">
                            <a href="#" class="btn btn-sm btn-outline-warning" onclick="Export()">
                                <i class="fas fa-backward"></i> Download as PDF
                            </a>
                        </div>
                    </div>

                    <div class="card-body row">
                        <div class="col-md-6 custom-view-box">
                            <p class="label-text">{{ __('Name(EN)') }}</p>
                            <div class="input-box">
                                {{ optional($youth)->name_en}}
                            </div>
                        </div>

                        <div class="col-md-6 custom-view-box">
                            <p class="label-text">{{ __('Name(BN)') }}</p>
                            <div class="input-box">
                                {{ optional($youth)->name_bn}}
                            </div>
                        </div>

                        <div class="col-md-6 custom-view-box">
                            <p class="label-text">{{ __('Email')}}</p>
                            <div class="input-box">
                                {{ optional($youth)->email ?? "N/A"}}
                            </div>
                        </div>

                        <div class="col-md-6 custom-view-box">
                            <p class="label-text">{{ __('Mobile') }}</p>
                            <div class="input-box">
                                {{ $youth->mobile ?? "" }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card bg-white">
                    <div class="card-header custom-bg-gradient-info text-primary">
                        <h3 class="card-title font-weight-bold">{{ __('Youth Address') }}</h3>
                    </div>
                    <div class="card-body">
                        <div class="row mt-2">
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-header">
                                        <div class="card-title">Present Address</div>
                                    </div>
                                    <div class="card-body row">
                                        <div class="col-md-6 custom-view-box">
                                            <p class="label-text">{{ __('Division') }}</p>
                                            <div class="input-box">
                                                {{ optional($youth->presentAddressDivision)->title ?? "" }}
                                            </div>
                                        </div>
                                        <div class="col-md-6 custom-view-box">
                                            <p class="label-text">{{ __('District') }}</p>
                                            <div class="input-box">
                                                {{ optional($youth->presentAddressDistrict)->title ?? "" }}
                                            </div>
                                        </div>
                                        <div class="col-md-6 custom-view-box">
                                            <p class="label-text">{{ __('Upazila') }}</p>
                                            <div class="input-box">
                                                {{ optional($youth->presentAddressUpazila)->title ?? "" }}
                                            </div>
                                        </div>
                                        <div class="col-md-6 custom-view-box">
                                            <p class="label-text">{{ __('Post Code') }}</p>
                                            <div class="input-box">
                                                {{ $youth->present_address_house_address['postal_code'] ?? "" }}
                                            </div>
                                        </div>
                                        <div class="col-md-6 custom-view-box">
                                            <p class="label-text">{{ __('Village Name') }}</p>
                                            <div class="input-box">
                                                {{ $youth->present_address_house_address['village_name'] ?? "" }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-header">
                                        <div class="card-title">Permanent Address</div>
                                    </div>
                                    <div class="card-body row">
                                        <div class="col-md-6 custom-view-box">
                                            <p class="label-text">{{ __('Division') }}</p>
                                            <div class="input-box">
                                                {{ $youth->permanentAddressDivision->title ?? "" }}
                                            </div>
                                        </div>
                                        <div class="col-md-6 custom-view-box">
                                            <p class="label-text">{{ __('District') }}</p>
                                            <div class="input-box">
                                                {{ optional($youth->permanentAddressDistrict)->title }}
                                            </div>
                                        </div>
                                        <div class="col-md-6 custom-view-box">
                                            <p class="label-text">{{ __('Upazila') }}</p>
                                            <div class="input-box">
                                                {{ optional($youth->permanentAddressUpazila)->title }}
                                            </div>
                                        </div>
                                        <div class="col-md-6 custom-view-box">
                                            <p class="label-text">{{ __('Post Code') }}</p>
                                            <div class="input-box">
                                                {{ $youth->permanent_address_house_address['postal_code'] ?? "" }}
                                            </div>
                                        </div>
                                        <div class="col-md-6 custom-view-box">
                                            <p class="label-text">{{ __('Village Name') }}</p>
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

                @if($haveYouthFamilyMembersInfo)
                    <div class="card">
                        <div class="card-header custom-bg-gradient-info">
                            <div class="card-title text-primary font-weight-bold">Family Members Information</div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="card">
                                        <div class="card-header">
                                            <div class="card-title">
                                                Father
                                            </div>
                                        </div>
                                        <div class="card-body row">
                                            <div class="col-md-6 custom-view-box">
                                                <p class="label-text">{{ __('Name') }}</p>
                                                <div class="input-box">
                                                    {{ optional($father)->member_name_en }}
                                                </div>
                                            </div>
                                            <div class="col-md-6 custom-view-box">
                                                <p class="label-text">{{ __('Mobile') }}</p>
                                                <div class="input-box">
                                                    {{ optional($father)->mobile}}
                                                </div>
                                            </div>
                                            <div class="col-md-6 custom-view-box">
                                                <p class="label-text">{{ __('NID') }}</p>
                                                <div class="input-box">
                                                    {{ optional($father)->nid }}
                                                </div>
                                            </div>
                                            <div class="col-md-6 custom-view-box">
                                                <p class="label-text">{{ __('Date of Birth') }}</p>
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
                                                Mother
                                            </div>
                                        </div>
                                        <div class="card-body row">
                                            <div class="col-md-6 custom-view-box">
                                                <p class="label-text">{{ __('Name') }}</p>
                                                <div class="input-box">
                                                    {{ optional($mother)->member_name_en}}
                                                </div>
                                            </div>
                                            <div class="col-md-6 custom-view-box">
                                                <p class="label-text">{{ __('Mobile') }}</p>
                                                <div class="input-box">
                                                    {{ optional($mother)->mobile}}
                                                </div>
                                            </div>
                                            <div class="col-md-6 custom-view-box">
                                                <p class="label-text">{{ __('NID') }}</p>
                                                <div class="input-box">
                                                    {{ optional($mother)->nid }}
                                                </div>
                                            </div>
                                            <div class="col-md-6 custom-view-box">
                                                <p class="label-text">{{ __('Date of Birth') }}</p>
                                                <div class="input-box">
                                                    {{  !empty($mother) ?  \Illuminate\Support\Carbon::parse($mother->date_of_birth)->format('d M Y') : '' }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @if(!empty($guardian) && $guardian == $father)
                                    <p class="label-text font-weight-bold mr-1">Guardian: </p> Father
                                @elseif(!empty($guardian) && $guardian == $mother)
                                    <p class="label-text font-weight-bold mr-1">Guardian: </p> Mother
                                @elseif(!empty($guardian))
                                    <div class="col-md-6">
                                        <div class="card">
                                            <div class="card-header">
                                                <div class="card-title">
                                                    Guardian
                                                </div>
                                            </div>
                                            <div class="card-body row">
                                                <div class="col-md-6 custom-view-box">
                                                    <p class="label-text">{{ __('Name') }}</p>
                                                    <div class="input-box">
                                                        {{ $guardian->member_name_en ?? "" }}
                                                    </div>
                                                </div>
                                                <div class="col-md-6 custom-view-box">
                                                    <p class="label-text">{{ __('Mobile') }}</p>
                                                    <div class="input-box">
                                                        {{ $guardian->mobile ?? "" }}
                                                    </div>
                                                </div>
                                                <div class="col-md-6 custom-view-box">
                                                    <p class="label-text">{{ __('NID') }}</p>
                                                    <div class="input-box">
                                                        {{ $guardian->nid ?? "" }}
                                                    </div>
                                                </div>
                                                <div class="col-md-6 custom-view-box">
                                                    <p class="label-text">{{ __('Date of Birth') }}</p>
                                                    <div class="input-box">
                                                        {{ \Illuminate\Support\Carbon::parse($guardian->date_of_birth)->format('d M Y') ?? "" }}
                                                    </div>
                                                </div>
                                                <div class="col-md-6 custom-view-box">
                                                    <p class="label-text">{{ __('Relation with youth') }}</p>
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
    @include('utils.delete-confirm-modal')
@endsection

@push('js')
    <script src="{{ asset('jsfiles/html2canvas.min.js') }}"></script>
    <script src="{{ asset('jsfiles/pdfmake.min.js') }}"></script>
    <script type="text/javascript">
        function Export() {
            html2canvas(document.getElementById('youth-profile'), {
                onrendered: function (canvas) {
                    let data = canvas.toDataURL();
                    let docDefinition = {
                        content: [{
                            image: data,
                            width: 500,
                        }]
                    };
                    pdfMake.createPdf(docDefinition).download("_profile.pdf");
                }
            });
        }
    </script>

@endpush


