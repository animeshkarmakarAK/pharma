<?php

namespace Module\CourseManagement\App\Http\Controllers\Frontend;

use Module\CourseManagement\App\Http\Controllers\Controller;
use Module\CourseManagement\App\Models\PublishCourse;
use Illuminate\Contracts\View\View;
use \Module\CourseManagement\App\Models\Institute;
use \Module\CourseManagement\App\Models\Course;
use \Module\CourseManagement\App\Models\Programme;

class CourseSearchController extends Controller
{
    /**
     * items of youth course search page in frontend
     *
     * @return View
     */
    const VIEW_PATH = 'course_management::frontend.search-courses.';

    public function findCourse($instituteSlug = null): View
    {
        $currentInstitute = Institute::where('slug', $instituteSlug)->first();
        $programmes = null;
        $publishCourses = null;

        $maxEnrollmentNumber = [];

        if ($currentInstitute) {
            $programmes = Programme::where('institute_id', $currentInstitute->id)->get();
            $publishCourses = PublishCourse::where('institute_id', $currentInstitute->id)->get();

        } else {
            $programmes = Programme::all();
            $publishCourses = PublishCourse::all();
        }

        foreach ($publishCourses as $publishCourse) {
            $maxEnrollmentNumber[] = \Module\CourseManagement\App\Models\CourseSession::select('publish_course_id', \DB::raw("SUM(max_seat_available) as total_seat"))
                ->groupBy('publish_course_id')->get();
        }

        return view(self::VIEW_PATH . 'course-list-new', compact('programmes', 'publishCourses', 'maxEnrollmentNumber'));
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
