<?php

namespace Module\CourseManagement\App\Http\Controllers\Frontend;

use Illuminate\Contracts\View\View;
use Module\CourseManagement\App\Http\Controllers\Controller;
use Module\CourseManagement\App\Models\Institute;
use Module\CourseManagement\App\Models\Programme;
use Module\CourseManagement\App\Models\PublishCourse;

class InstitutePageController extends Controller
{
    /**
     * items of youth course search page in frontend
     *
     * @return View
     */
    const VIEW_PATH = 'course_management::frontend.institute-list.';

    public function index($instituteSlug): View
    {
        $currentInstitute = Institute::where('slug', $instituteSlug)->get();

        $institutes = Institute::all();

        return view(self::VIEW_PATH . 'index', compact('institutes'));
    }

    /**
     * @param int $publishCourseId
     * @return string
     */
    public function courseDetails(int $publishCourseId): string
    {
        $publishCourse = PublishCourse::findOrFail($publishCourseId);
        return \Illuminate\Support\Facades\View::make(self::VIEW_PATH . 'course-details-ajax', ['publishCourse' => $publishCourse])->render();
    }

}
