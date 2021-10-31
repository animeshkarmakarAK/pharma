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
                        <div class="card-title float-left font-weight-bold text-primary">আমার অভিযোগ</div>
                        <div class="youth-access-key float-right d-inline-flex">
                            <p class="label-text font-weight-bold">&nbsp;</p>
                            <div class="font-weight-bold">
                                &nbsp;
                            </div>
                        </div>
                    </div>

                    <div class="card-body row">
                        <div class="card col-md-12 p-2">
                            <div class="card-body">
                                <div class="">
                                    <div class="col-md-12">
                                        <form action="{{ route('course_management::youth-complain-to-organization') }}"
                                              method="POST"
                                              id="complain-form"
                                              class="edit-add-form">
                                            @csrf
                                            <div class="form-group row">
                                                <div class="col-sm-2">
                                                    <label for="receiver" class="control-label">
                                                        To
                                                    </label>
                                                </div>
                                                <div class="col-sm-10">
                                                    <input type="hidden" name="institute_id" id="institute_id"
                                                           class="institute_id"
                                                           value="{{ !empty($currentInstitute)?$currentInstitute->id:''}}">
                                                    <input type="hidden" name="youth_id" id="youth_id"
                                                           class="youth_id"
                                                           value="{{ !empty($youth)?$youth->id:''}}">
                                                    <input class="form-control" type="text"
                                                           value="{{ !empty($currentInstitute)?$currentInstitute->title_en:''}}" readonly>

                                                </div>
                                            </div>
                                            <div class="form-group row" aria-required="true">
                                                <label for="name" class="col-sm-2 control-label">
                                                    Industry Name
                                                </label>
                                                <div class="col-md-10">
                                                    <input type="hidden" name="organization_id" id="organization_id" class="organization_id"
                                                           value="{{ !empty($youthOrganization)?$youthOrganization->organization_id:''}}">
                                                    <input required="required"
                                                           class="form-control" type="text"
                                                           value="{{ !empty($youthOrganization)?$youthOrganization->organization->title_en:''}}"
                                                           readonly>

                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="email" class="col-md-2"
                                                       aria-required="true">Complain Title <span
                                                        style="color: red"> * </span></label>
                                                <div class="col-md-10">
                                                    <input maxlength="50" name="complain_title" id="complain_title"
                                                           class="form-control complain_title"
                                                           type="text">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="complain_message"
                                                       class="col-sm-2">
                                                    Complain Message
                                                    <span style="color: red"> * </span></label>
                                                <div class="col-sm-10">
                                                        <textarea name="complain_message"
                                                                  id="complain_message"
                                                                  class="form-control complain_message"
                                                                  rows="4"
                                                        ></textarea>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-md-12 text-center">
                                                    <div class="submit">
                                                        <input type="submit" class="btn btn-default btn_save"
                                                               value="Complain Now">
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
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
    <x-generic-validation-error-toastr></x-generic-validation-error-toastr>
    <script>
        const complainForm = $('#complain-form');
        complainForm.validate({
            rules: {
                complain_title: {
                    required: true,
                },
                complain_message: {
                    required: true,
                },
            },
            messages: {
                complain_title: {
                    required: "Please enter a complain title",
                },
                complain_message: {
                    required: "Please enter complain message",
                },
            },
            submitHandler: function (htmlForm) {
                $('.overlay').show();
                htmlForm.submit();
            }
        });

    </script>

@endpush


