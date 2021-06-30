<?php

namespace Module\CourseManagement\App\Http\Controllers\Frontend;

use Module\CourseManagement\App\Http\Controllers\Controller;
use Module\CourseManagement\App\Models\PublishCourse;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;


class YearlyTrainingCalendarController extends Controller
{
    const VIEW_PATH = "course_management::frontend.";
    public function index(): View
    {
        return \view(self::VIEW_PATH.'yearly-training-calendar');
    }

    public function allEvent()
    {
        $currentInstitute = domainConfig('institute');
        $courseSessions = PublishCourse::select([
            'publish_courses.id as publish_course_id',
            'courses.title_en as title',
            DB::raw('DATE(course_sessions.application_start_date) as start'),
            DB::raw('DATE_ADD(DATE(course_sessions.application_end_date), INTERVAL 1 Day) as end'),
        ]);
        $courseSessions->join('course_sessions', 'publish_courses.id', '=', 'course_sessions.publish_course_id');
        $courseSessions->join('courses', 'publish_courses.course_id', '=', 'courses.id');
        $courseSessions->where('publish_courses.institute_id', '=', $currentInstitute->id);

        return $courseSessions->get()->toArray();
    }

}

