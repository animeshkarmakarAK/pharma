@php
    /** @var \Module\CourseManagement\App\Models\PublishCourse $publishCourse */
@endphp

<div class="modal-header custom-bg-gradient-info">
    <div style=" height:40px;">
        <h4 style="text-align: center; margin-top: 5px">কোর্সের বর্ণনা</h4>
    </div>
    <button type="button" class="close" data-dismiss="modal"
            aria-label="{{ __('voyager::generic.close') }}">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body">
    <div class="row">
        <div class="col-md-12 col-sm-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between custom-bg-gradient-info"
                     style="background: url('{{asset('storage/'. optional($publishCourse->course)->cover_image)}}') no-repeat center center;
                         background-size: cover; min-height: 40vh;"
                >
                    {{--<img id="cover_image" class="img-fluid" alt="Responsive image"
                         src="{{asset('storage/'. optional($publishCourse->course)->cover_image)}}"
                         style="height: 300px; width: 100%">--}}
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 custom-view-box">
                            <p class="label-text">কোর্সের নাম </p>
                            <div class="input-box" id="course_title">
                                {{optional($publishCourse->course)->title_bn}}
                            </div>
                        </div>

                        <div class="col-md-6 custom-view-box">
                            <p class="label-text">কোর্স ফি</p>
                            <div class="input-box" id="course_fee">
                                {{optional($publishCourse->course)->course_fee}}
                            </div>
                        </div>

                        <div class="col-md-6 custom-view-box">
                            <p class="label-text">কোর্স সময়কাল</p>
                            <div class="input-box" id="course_duration">
                                {{optional($publishCourse->course)->duration}}
                            </div>
                        </div>

                        <div class="col-md-6 custom-view-box">
                            <p class="label-text">যাদের জন্য কোর্স</p>
                            <div class="input-box" id="target_group">
                                {{optional($publishCourse->course)->target_group}}
                            </div>
                        </div>

                        <div class="col-md-6 custom-view-box">
                            <p class="label-text">কোর্সের লক্ষ্য</p>
                            <div class="input-box" id="objects">
                                {{optional($publishCourse->course)->objects}}
                            </div>
                        </div>

                        <div class="col-md-6 custom-view-box">
                            <p class="label-text">কোর্স বিষয়বস্তু</p>
                            <div class="input-box" id="contents">
                                {{optional($publishCourse->course)->contents}}
                            </div>
                        </div>

                        <div class="col-md-6 custom-view-box">
                            <p class="label-text">প্রশিক্ষণ পদ্ধতি</p>
                            <div class="input-box" id="training_methodology">
                                {{optional($publishCourse->course)->training_methodology}}
                            </div>
                        </div>

                        <div class="col-md-6 custom-view-box">
                            <p class="label-text">মূল্যায়ন পদ্ধতি</p>
                            <div class="input-box" id="evaluation_system">
                                {{optional($publishCourse->course)->evaluation_system}}
                            </div>
                        </div>

                        <div class="col-md-12 custom-view-box">
                            <p class="label-text">কোর্সের বর্ণনা</p>
                            <div class="input-box" id="description">
                                <p>{{optional($publishCourse->course)->description}}</p>
                            </div>
                        </div>
                        <div class="col-md-6 custom-view-box">
                            <p class="label-text">পূর্বশর্ত </p>
                            <div class="input-box" id="prerequisite">
                                {{optional($publishCourse->course)->prerequisite}}
                            </div>
                        </div>
                        <div class="col-md-6 custom-view-box">
                            <p class="label-text">পূর্ব যোগ্যতা</p>
                            <div class="input-box" id="eligibility">
                                {{optional($publishCourse->course)->eligibility}}
                            </div>
                        </div>
                        <div class="col-md-6 custom-view-box">
                            <p class="label-text">অ্যাক্টিভ স্ট্যাটাস</p>
                            <div class="input-box" id="active_status">
                                {!! $publishCourse->getCurrentRowStatus(true) !!}
                            </div>
                        </div>
                        <div class="col-md-6 custom-view-box">
                            <p class="label-text">ইন্সটিটিউটের নাম </p>
                            <div class="input-box" id="institute_name_field">
                                {{optional($publishCourse->institute)->title_en}}
                            </div>
                        </div>
                        <div class="col-md-6 custom-view-box">
                            <p class="label-text">ইন্সটিটিউটের ঠিকানা</p>
                            <div class="input-box" id="institute_address">
                                {{optional($publishCourse->institute)->address}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title">কোর্স সেশন তালিকা</h2>
                </div>
                @if($publishCourse->courseSessions)
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover table-sm">
                                <thead>
                                <tr>
                                    <th>নিবন্ধন শুরু</th>
                                    <th>নিবন্ধন শেষ</th>
                                    <th>ক্লাস শুরু</th>
                                    <th>মোট আসন</th>
                                    <th>&nbsp;</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($publishCourse->courseSessions as $session)
                                    <tr>
                                        <td>{{optional($session->application_start_date)->format('d/m/Y')}}</td>
                                        <td>{{optional($session->application_end_date)->format('d/m/Y')}}</td>
                                        <td>{{optional($session->course_start_date)->format('d/m/Y')}}</td>
                                        <td>{{$session->max_seat_available}}</td>
                                        <td colspan="3">
                                            @if($session->course_start_date && $session->course_start_date->gt(now()))
                                                <button type="button" style="min-width: 130px;"
                                                        class="btn btn-success btn-block course-apply-btn"
                                                        onclick="window.location.href = `{{route('course_management::youth-registrations.store')}}?publish_course_id={{$publishCourse->id}}`"
                                                >আবেদন করুন
                                                </button>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @else
                    <div class="card-body">
                        <div class="col-md-12">
                            <div class="alert alert-warning">
                                No session found for this course.
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
