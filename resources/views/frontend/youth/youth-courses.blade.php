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
                        <div class="card-title float-left font-weight-bold text-primary">আমার কোর্স সমূহ</div>
                        <div class="youth-access-key float-right d-inline-flex">
                            <p class="label-text font-weight-bold">&nbsp;</p>
                            <div class="font-weight-bold">
                                &nbsp;
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="datatable-container">
                            <table id="dataTable" class="table table-bordered table-striped dataTable">
                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>


    <!-----------modal Start----------->
    <div class="modal modal-danger fade" tabindex="-1" id="pay-now-modal" role="dialog" data-backdrop="static">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header custom-bg-gradient-info">
                    <h4 class="modal-title">
                        <i class="fas fa-exclamation-triangle"></i></i> {{ __('Do you want to pay now?') }}
                    </h4>
                    <button type="button" class="close" data-dismiss="modal"
                            aria-label="{{ __('voyager::generic.close') }}">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-right"
                            data-dismiss="modal">{{ __('Cancel') }}</button>
                    <form action="#" id="pay-now-form" method="POST">
                        {{--{{ method_field("DELETE") }}--}}
                        {{ csrf_field() }}
                        <input type="submit" class="btn btn-danger pull-right"
                               value="{{ __('Confirm') }}">
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-----------modal End------------->

@endsection

@push('css')
    <link rel="stylesheet" href="{{asset('/css/datatable-bundle.css')}}">
@endpush

@push('js')
    <script type="text/javascript" src="{{asset('/js/datatable-bundle.js')}}"></script>
    <script>
        $(function () {
            let params = serverSideDatatableFactory({
                url: '{{ route('frontend.youth-courses-datatable') }}',
                order: [[2, "asc"]],
                columns: [
                    {
                        title: "SL#",
                        data: null,
                        defaultContent: "SL#",
                        searchable: false,
                        orderable: false,
                        visible: true,
                    },
                    {
                        title: "কোর্সের নাম",
                        data: "course_title_bn",
                        name: "courses.title_bn"
                    },
                    {
                        title: "কোর্স ফি",
                        data: "course_fee",
                        name: "courses.course_fee"
                    },
                    {
                        title: "এনরোল স্টেটাস",
                        data: "enroll_status",
                        name: "youth_course_enrolls.enroll_status"
                    },
                    {
                        title: "পেমেন্ট স্টেটাস",
                        data: "payment_status",
                        name: "youth_course_enrolls.payment_status"
                    },
                    {
                        title: "ব্যাচ স্টেটাস",
                        data: "batch_status",
                        //name: "youth_course_enrolls.payment_status"
                    },
                    {
                        title: "ফি প্রদানের শেষ সময়",
                        data: "enroll_last_date",
                        //name: "youth_course_enrolls.payment_status"
                    },
                    {
                        title: "পদক্ষেপ",
                        data: "action",
                        orderable: false,
                        searchable: false,
                        visible: true
                    }
                ]
            });
            const datatable = $('#dataTable').DataTable(params);
            bindDatatableSearchOnPresEnterOnly(datatable);

            $(document, 'td').on('click', '.pay-now', function (e) {
                $('#pay-now-form')[0].action = $(this).data('action');
                $('#pay-now-modal').modal('show');
            });
        });
    </script>
@endpush


