<?php

namespace Module\CourseManagement\App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Contracts\View\View;
use Module\CourseManagement\App\Models\Event;
use Module\CourseManagement\App\Models\Gallery;
use Module\CourseManagement\App\Models\GalleryCategory;
use Module\CourseManagement\App\Models\IntroVideo;
use Module\CourseManagement\App\Models\PublishCourse;
use Module\CourseManagement\App\Models\Slider;
use Module\CourseManagement\App\Models\StaticPage;
use Module\CourseManagement\App\Models\TrainingCenter;
use Module\CourseManagement\App\Models\YouthRegistration;

class HomeController extends BaseController
{
    /**
     * Show the application dashboard.
     * @return View
     */
    public function index(): View
    {
        $currentInstitute = domainConfig('institute');
        if ($currentInstitute) {
            $currentInstituteCourses = PublishCourse::where([
                'institute_id' => $currentInstitute->id,
            ]);


            $runningCourses = PublishCourse::select([
                'publish_courses.id as id',
                'publish_courses.course_id',
                'courses.title_en',
                'courses.title_bn',
                'courses.course_fee',
                'courses.duration',
                'courses.cover_image',
                'course_sessions.max_seat_available',
                'course_sessions.session_name_bn',
                'course_sessions.application_start_date',
                'course_sessions.application_end_date'
            ]);
            $runningCourses->join('courses', 'courses.id', '=', 'publish_courses.course_id');
            $runningCourses->join('course_sessions', 'course_sessions.publish_course_id', '=', 'publish_courses.id');
            $runningCourses->whereDate('course_sessions.application_start_date', '<=', Carbon::now()->format('Y-m-d'))
                ->whereDate('course_sessions.application_end_date', '>=', Carbon::now()->format('Y-m-d'));
            $runningCourses->where(['publish_courses.institute_id' => $currentInstitute->id]);
            $runningCourses = $runningCourses->get();


            $upcomingCourses = PublishCourse::select([
                'publish_courses.id as id',
                'publish_courses.course_id',
                'courses.title_en',
                'courses.title_bn',
                'courses.course_fee',
                'courses.duration',
                'courses.cover_image',
                'course_sessions.max_seat_available',
                'course_sessions.session_name_bn',
                'course_sessions.application_start_date',
                'course_sessions.application_end_date'
            ]);
            $upcomingCourses->join('courses', 'courses.id', '=', 'publish_courses.course_id');
            $upcomingCourses->join('course_sessions', 'course_sessions.publish_course_id', '=', 'publish_courses.id');
            $upcomingCourses->whereDate('course_sessions.application_start_date', '>', Carbon::now()->format('Y-m-d'));
            $upcomingCourses->where(['publish_courses.institute_id' => $currentInstitute->id]);
            $upcomingCourses = $upcomingCourses->get();


            $galleries = Gallery::orderBy('id', 'DESC')->where(['institute_id' => $currentInstitute->id])->limit(8)->get();
            $galleryCategories = GalleryCategory::active()
                ->orderBy('id', 'DESC')
                ->where(['institute_id' => $currentInstitute->id])
                ->where(['featured' => 1])
                ->get();
            $galleryAllCategories = GalleryCategory::where(['institute_id' => $currentInstitute->id])->get();

            $sliders = Slider::active()
                ->where(['institute_id' => $currentInstitute->id])
                ->limit(10)
                ->get();

            $staticPage = StaticPage::orderBy('id', 'DESC')
                ->where('page_id', StaticPage::PAGE_ID_ABOUT_US)
                ->where(['institute_id' => $currentInstitute->id])
                ->limit(1)
                ->first();

            $institute = [
                'courses' => $currentInstituteCourses->count(),
                'training_centers' => TrainingCenter::where(['institute_id' => $currentInstitute->id])->count(),
                'youth_registrations' => YouthRegistration::where(['institute_id' => $currentInstitute->id])->count(),
            ];
            $currentInstituteCourses = $currentInstituteCourses->limit(8)->get();
            $maxEnrollmentNumber = [];
            foreach ($currentInstituteCourses as $course) {
                $maxEnrollmentNumber[] = \Module\CourseManagement\App\Models\CourseSession::where('publish_course_id', $course->id)->sum('max_seat_available');
            }

            $currentInstituteEvents = Event::where([
                'institute_id' => $currentInstitute->id,
            ]);
            $currentInstituteEvents->whereDate('date', '>=', Carbon::now()->format('Y-m-d'));
            $currentInstituteEvents->orderBy('date', 'ASC');
            $currentInstituteEvents = $currentInstituteEvents->limit(5)->get();

            $introVideo = IntroVideo::where([
                'institute_id' => $currentInstitute->id,
            ])->orderBy('id', 'DESC')->first();

            return view('course_management::welcome', compact('currentInstituteCourses', 'galleries', 'sliders', 'staticPage', 'institute', 'galleryCategories', 'galleryAllCategories', 'maxEnrollmentNumber', 'currentInstituteEvents', 'introVideo', 'runningCourses', 'upcomingCourses'));
        }

        $institute = [
            'courses' => PublishCourse::count(),
            'training_centers' => TrainingCenter::count(),
            'youth_registrations' => YouthRegistration::count(),
        ];

        return view('course_management::home');
    }

    public function success()
    {
        return redirect()->route('course_management::youth-enrolled-courses')
            ->with(['message' => 'আপনার পেমেন্ট সফলভাবে পরিশোধ করা হয়েছে, দয়া করে অপেক্ষা করুন', 'alert-type' => 'success']);
    }

    public function fail()
    {
        return redirect()->route('course_management::youth-enrolled-courses')
            ->with(['message' => 'পেমেন্ট ব্যর্থ হয়েছে, অনুগ্রহ করে পরে আবার চেষ্টা করুন', 'alert-type' => 'warning']);
    }

    public function cancel()
    {
        return redirect()->route('course_management::youth-enrolled-courses')
            ->with(['message' => 'পেমেন্ট বাতিল হয়েছে, দয়া করে আবার চেষ্টা করুন', 'alert-type' => 'error']);
    }

}
