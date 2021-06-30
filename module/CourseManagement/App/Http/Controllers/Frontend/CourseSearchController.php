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

    public function findCourse(): View
    {
        $institutes = Institute::active()->whereHas('courses')->get();
        $programmes = Programme::active()->whereHas('publishCourses')->get();
        $courses = Course::active()->get();

        return view(self::VIEW_PATH.'course-list', compact('institutes', 'programmes', 'courses'));
    }

    /**
     * @param int $publishCourseId
     * @return string
     */
    public function courseDetails(int $publishCourseId): string
    {
        $publishCourse = PublishCourse::findOrFail($publishCourseId);
        return \Illuminate\Support\Facades\View::make(self::VIEW_PATH.'course-details-ajax', ['publishCourse' => $publishCourse])->render();
    }

}
