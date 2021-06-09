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
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between custom-bg-gradient-info">
                    <img id="cover_image" class="img-fluid" alt="Responsive image"
                         src="{{asset('storage/'. optional($publishCourse->course)->cover_image)}}"
                         style="height: 300px; width: 100%">
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 custom-view-box">
                            <p class="label-text">কোর্সের নাম </p>
                            <div class="input-box" id="course_title">
                                {{optional($publishCourse->course)->title_en}}
                            </div>
                        </div>

                        <div class="col-md-6 custom-view-box">
                            <p class="label-text">কোর্স ফি</p>
                            <div class="input-box" id="course_fee">
                                {{optional($publishCourse->course)->course_fee}}
                            </div>
                        </div>

                        <div class="col-md-12 custom-view-box">
                            <p class="label-text">কোর্সের বর্ণনা</p>
                            <div class="input-box" id="course_discription">
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
                            <p class="label-text">একটিভ স্ট্যাটাস</p>
                            <div class="input-box" id="active_status">
                                {{optional($publishCourse->course)->row_status == 1 ? 'Active' : 'Inactive'}}
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
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title">Course session list</h2>
                </div>
                @if($publishCourse->courseSessions)
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover table-sm">
                                <thead>
                                <tr>
                                    <th>রেজিস্ট্রেশান শুরু</th>
                                    <th>রেজিস্ট্রেশান শেষ</th>
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
                                        <td>
                                            @if($session->course_start_date && $session->course_start_date->gt(now()))
                                                <button type="button"
                                                        class="btn btn-success course-apply-btn"
                                                        onclick="window.location.href = `{{route('youth-registrations.store')}}?publish_course_id={{$publishCourse->id}}`"
                                                >
                                                    আবেদন করুন
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
