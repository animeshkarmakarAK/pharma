<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Batch;
use App\Models\Course;
use App\Models\Institute;
use App\Models\Programme;
use Illuminate\Contracts\View\View;

class CourseSearchController extends Controller
{
    /**
     * items of youth course search page in frontend
     *
     * @return View
     */
    const VIEW_PATH = 'frontend.search-courses.';

    public function findCourse(): View
    {
        /** @var Institute $currentInstitute */
        $currentInstitute = app('currentInstitute');
        $programmes = Programme::query();

        $maxEnrollmentNumber = [];

        if ($currentInstitute) {
            $programmes->where('institute_id', $currentInstitute->id);
        }

        $programmes = $programmes->get();


        return view(self::VIEW_PATH . 'course-list', compact('programmes', 'maxEnrollmentNumber'));
    }

    /**
     * @param mixed ...$args
     * @return View
     */
    public function courseDetails(...$args): View
    {
        $courseId = $args[0];

        if (count($args) > 1 || !is_numeric($args[0])) {
            $courseId = $args[1];
        }

        $course = Course::findOrFail($courseId);

        return view(self::VIEW_PATH . 'course-details', ['course' => $course]);
    }
    /**
     * @param mixed ...$args
     * @return View
     */
    public function courseApply(...$args): View
    {
        $courseId = $args[0];

        if (count($args) > 1 || !is_numeric($args[0])) {
            $courseId = $args[1];
        }

        $course = Course::findOrFail($courseId);
        $batches = Batch::findorFail($course->institute_id)->get();

        return view(self::VIEW_PATH . 'course-apply', compact('course','batches'));
    }

}
