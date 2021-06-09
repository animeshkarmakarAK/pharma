<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;

class HomeController extends Controller
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(): View
    {
        $currentInstitute = domainConfig('institute');

        if ($currentInstitute) {
            $currentInstituteCourses = \App\Models\PublishCourse::where([
                'institute_id' => $currentInstitute->id,
            ]);

            $galleries = Gallery::orderBy('id', 'DESC')->where(['institute_id' => $currentInstitute->id])->limit(8)->get();
            $galleryCategories = GalleryCategory::orderBy('id', 'DESC')->where(['institute_id' => $currentInstitute->id])->get();

            $sliders = Slider::active()
                ->where(['institute_id' => $currentInstitute->id])
                ->limit(10)
                ->get();

            $staticPage = StaticPage::orderBy('id', 'DESC')
                ->where('page_id', StaticPage::PAGE_ID_ABOUT_US)
                ->where(['institute_id' => $currentInstitute->id],)
                ->limit(1)
                ->first();

            $institute = [
                'courses' => $currentInstituteCourses->count(),
                'training_centers' => TrainingCenter::where(['institute_id' => $currentInstitute->id])->count(),
                'youth_registrations' => YouthRegistration::where(['institute_id' => $currentInstitute->id])->count(),
            ];

            $currentInstituteCourses = $currentInstituteCourses->limit(10)->get();

            return view('custom_welcome', compact('currentInstituteCourses', 'galleries', 'sliders', 'staticPage', 'institute', 'galleryCategories'));
        }

        $institute = [
            'courses' => PublishCourse::count(),
            'training_centers' => TrainingCenter::count(),
            'youth_registrations' => YouthRegistration::count(),
        ];

        return view('welcome', compact('institute'));
    }

}
