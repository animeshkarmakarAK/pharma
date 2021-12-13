<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Event;
use App\Models\Gallery;
use App\Models\GalleryCategory;
use App\Models\Institute;
use App\Models\IntroVideo;
use App\Models\Slider;
use App\Models\StaticPage;
use App\Models\TrainingCenter;
use App\Models\User;
use App\Models\YouthCourseEnroll;
use App\Models\YouthRegistration;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class HomeController extends BaseController
{
    /**
     * Show the application dashboard.
     * @return View
     */
    public function index(): View
    {
        /** @var Institute|null $currentInstitute */
        $currentInstitute = app('currentInstitute');

        $courses = Course::query();
        $runningCourses = Course::select([
            'courses.id as id',
            'courses.institute_id as institute_id',
            'courses.training_center_id as training_center_id',
            'courses.branch_id as branch_id',
            'courses.title',
            'courses.course_fee',
            'courses.duration',
            'courses.cover_image',
            'courses.row_status',
        ]);
        $galleries = Gallery::orderBy('id', 'DESC');
        $galleryCategories = GalleryCategory::active()
            ->orderBy('id', 'DESC');
        $sliders = Slider::active();
        $staticPage = StaticPage::orderBy('id', 'DESC')
            ->where('page_id', StaticPage::PAGE_ID_ABOUT_US);
        $trainingCenters = TrainingCenter::query();
        $youthRegistrations = YouthRegistration::query();
        $events = Event::query();
        $introVideo = IntroVideo::orderBy('id', 'DESC');
        /** @var User|Builder $trainers */
        $trainers = User::where('user_type_id', User::USER_TYPE_TRAINER_USER_CODE);

        if ($currentInstitute) {
            $courses->where('institute_id', $currentInstitute->id);
            $runningCourses->where(['courses.institute_id' => $currentInstitute->id]);
            $galleries->where(['institute_id' => $currentInstitute->id]);
            $galleryCategories->where(['institute_id' => $currentInstitute->id]);
            $sliders->where(['institute_id' => $currentInstitute->id]);
            $staticPage->where(['institute_id' => $currentInstitute->id]);
            $trainingCenters->where('institute_id', $currentInstitute->id);
            $youthRegistrations->where('institute_id', $currentInstitute->id);
            $events->where('institute_id', $currentInstitute->id);
            $trainers->where('institute_id', $currentInstitute->id);
        }

        $events->whereDate('date', '>=', Carbon::now()->format('Y-m-d'));
        $events->orderBy('date', 'ASC');

        $statistics = [
            'total_course' => $courses->count('id'),
            'total_training_center' => $trainingCenters->count('id'),
            'total_registered_trainee' => $youthRegistrations->count('id'),
            'total_trainer' => $trainers->count('id'),
        ];

        $runningCourses = $runningCourses->get();

        $galleries = $galleries->limit(8)->get();
        $galleryCategories = $galleryCategories->where(['featured' => 1])
            ->get();
        $sliders = $sliders->limit(10)
            ->get();
        $staticPage = $staticPage->limit(1)
            ->first();

        $courses = $courses->limit(8)->get();
        $upcomingCourses = $courses;
        $events = $events->limit(5)->get();
        $introVideo = $introVideo->first();
        $skillServiceProviders = Institute::acl()->select(
        'institutes.id as institute_id',
                'institutes.title as institute_title',
                'institutes.logo as institute_logo',
                'institutes.address as institute_address',
                DB::raw('count(youth_course_enrolls.id) as total_student'),
                DB::raw('count(courses.id) as total_courses')
            )
            ->join('courses', 'institutes.id', '=', 'courses.institute_id')
            ->join('youth_course_enrolls', 'courses.id', '=', 'youth_course_enrolls.course_id')
            ->where(['youth_course_enrolls.enroll_status' => YouthCourseEnroll::ENROLL_STATUS_ACCEPT])
            ->groupBy('youth_course_enrolls.id')
            ->get();

        return view('landing-page.welcome', compact('courses', 'upcomingCourses', 'galleries', 'sliders', 'staticPage', 'statistics', 'galleryCategories', 'events', 'introVideo', 'runningCourses','skillServiceProviders'));
    }

    public function success(): \Illuminate\Http\RedirectResponse
    {
        return redirect()->route('frontend.youth-enrolled-courses')
            ->with(['message' => 'আপনার পেমেন্ট সফলভাবে পরিশোধ করা হয়েছে, দয়া করে অপেক্ষা করুন', 'alert-type' => 'success']);
    }

    public function fail(): \Illuminate\Http\RedirectResponse
    {
        return redirect()->route('frontend.youth-enrolled-courses')
            ->with(['message' => 'পেমেন্ট ব্যর্থ হয়েছে, অনুগ্রহ করে পরে আবার চেষ্টা করুন', 'alert-type' => 'warning']);
    }

    public function cancel(): \Illuminate\Http\RedirectResponse
    {
        return redirect()->route('frontend.youth-enrolled-courses')
            ->with(['message' => 'পেমেন্ট বাতিল হয়েছে, দয়া করে আবার চেষ্টা করুন', 'alert-type' => 'error']);
    }

    public function sspRegistrationForm(): View
    {
        return \view('frontend.ssp.registration-form');
    }
}
