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

            return view('course_management::custom_welcome', compact('currentInstituteCourses', 'galleries', 'sliders', 'staticPage', 'institute', 'galleryCategories'));
        }

        $institute = [
            'courses' => PublishCourse::count(),
            'training_centers' => TrainingCenter::count(),
            'youth_registrations' => YouthRegistration::count(),
        ];

        return view('course_management::welcome', compact('institute'));
    }

}
