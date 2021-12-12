<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
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
     * @param int $courseId
     * @param string|null $instituteSlug
     * @return View
     */
    public function courseDetails(string $instituteSlug = null, int $courseId): View
    {
        $course = Course::findOrFail($courseId);

        return view(self::VIEW_PATH . 'course-details', ['course' => $course]);
    }

}
