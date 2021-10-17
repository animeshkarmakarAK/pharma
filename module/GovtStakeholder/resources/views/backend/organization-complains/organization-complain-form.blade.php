@php
    $institute = domainConfig('institute');
    $organization = \App\Helpers\Classes\AuthHelper::getAuthUser();
@endphp
@extends('master::layouts.master')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header text-primary custom-bg-gradient-info">
                        <h3 class="card-title font-weight-bold">Complain for Youth</h3>
                        <div class="card-tools float-right">
                            <a
                                onclick="window.history.go(-1); return false;"
                                class="btn btn-sm btn-outline-primary btn-rounded">
                                <i class="fas fa-backward"></i> Back to list
                            </a>
                        </div>
                    </div>


                <!-- /.card-header -->
                    <div class="card-body">
                        <div class="">
                            <div class="col-md-12">
                                <form action="{{ route('govt_stakeholder::admin.organization-complain-to-youths') }}"
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
                                                   value="{{ !empty($institute)?$institute->id:''}}">
                                            <input type="hidden" name="organization_id" id="organization_id"
                                                   class="institute_id"
                                                   value="{{ !empty($organization)?$organization->organization_id:''}}">
                                            <input class="form-control" type="text"
                                                   value="{{ !empty($institute)?$institute->title_en:''}}" readonly>

                                        </div>
                                    </div>
                                    <div class="form-group row" aria-required="true">
                                        <label for="name" class="col-sm-2 control-label">
                                            Youth Name
                                        </label>
                                        <div class="col-md-10">
                                            <input type="hidden" name="youth_id" id="youth_id" class="youth_id"
                                                   value="{{ !empty($youth)?$youth->id:''}}">
                                            <input required="required"
                                                   class="form-control" type="text"
                                                   value="{{ !empty($youth)?$youth->name_en:''}}"
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
