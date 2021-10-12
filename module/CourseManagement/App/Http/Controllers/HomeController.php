<?php

namespace Module\CourseManagement\App\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Module\CourseManagement\App\Models\Gallery;
use Module\CourseManagement\App\Models\GalleryCategory;
use Module\CourseManagement\App\Models\PublishCourse;
use Module\CourseManagement\App\Models\Slider;
use Module\CourseManagement\App\Models\StaticPage;
use Module\CourseManagement\App\Models\TrainingCenter;
use Module\CourseManagement\App\Models\YouthRegistration;

class HomeController extends BaseController
{
    /**
     * Show the application dashboard.
     * @return Renderable
     */
    public function index()
    {
        $currentInstitute = domainConfig('institute');

        if ($currentInstitute) {
            $currentInstituteCourses = PublishCourse::where([
                'institute_id' => $currentInstitute->id,
            ]);


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
            foreach ($currentInstituteCourses as $course){
                $maxEnrollmentNumber[] = \Module\CourseManagement\App\Models\CourseSession::where('publish_course_id', $course->id)->sum('max_seat_available');
            }

            return view('course_management::welcome', compact('currentInstituteCourses', 'galleries', 'sliders', 'staticPage', 'institute', 'galleryCategories','galleryAllCategories','maxEnrollmentNumber'));
        }

        $institute = [
            'courses' => PublishCourse::count(),
            'training_centers' => TrainingCenter::count(),
            'youth_registrations' => YouthRegistration::count(),
        ];

        return view('course_management::welcome', compact('institute'));
    }

    public function success()
    {
        return redirect()->route('course_management::youth-enrolled-courses', auth()->guard('youth')->user()->id)
            ->with(['message' => 'আপনার পেমেন্ট সফলভাবে পরিশোধ করা হয়েছে, দয়া করে অপেক্ষা করুন', 'alert-type' => 'success']);
    }

    public function fail()
    {
        return redirect()->route('course_management::youth-enrolled-courses', auth()->guard('youth')->user()->id)
            ->with(['message' => 'পেমেন্ট ব্যর্থ হয়েছে, অনুগ্রহ করে পরে আবার চেষ্টা করুন', 'alert-type' => 'warning']);
    }

    public function cancel()
    {
        return redirect()->route('course_management::youth-enrolled-courses', auth()->guard('youth')->user()->id)
            ->with(['message' => 'পেমেন্ট বাতিল হয়েছে, দয়া করে আবার চেষ্টা করুন', 'alert-type' => 'error']);
    }

}
