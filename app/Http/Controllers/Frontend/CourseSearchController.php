<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\PublishCourse;
use Illuminate\Contracts\View\View;
use \App\Models\Institute;
use \App\Models\Programme;

class CourseSearchController extends Controller
{
    /**
     * items of youth course search page in frontend
     *
     * @return View
     */
    const VIEW_PATH = 'frontend.search-courses.';

    public function findCourse($instituteSlug = null): View
    {
        $currentInstitute = Institute::where('slug', $instituteSlug)->first();
        $programmes = null;

        $maxEnrollmentNumber = [];

        if ($currentInstitute) {
            $programmes = Programme::where('institute_id', $currentInstitute->id)->get();

        } else {
            $programmes = Programme::all();
        }


        return view(self::VIEW_PATH . 'course-list-new', compact('programmes', 'maxEnrollmentNumber'));
    }

    /**
     * @param int $publishCourseId
     * @return View
     */
    public function courseDetails(int $publishCourseId): View
    {
        $publishCourse = PublishCourse::findOrFail($publishCourseId);
        return \Illuminate\Support\Facades\View::make(self::VIEW_PATH . 'course-details', ['publishCourse' => $publishCourse]);
    }

}
