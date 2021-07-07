<?php

namespace Module\CourseManagement\App\Http\Controllers\Frontend;

use Module\CourseManagement\App\Http\Controllers\Controller;
use Module\CourseManagement\App\Models\Course;
use Module\CourseManagement\App\Models\CourseSession;
use Module\CourseManagement\App\Models\PublishCourse;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;


class YearlyTrainingCalendarController extends Controller
{
    const VIEW_PATH = "course_management::frontend.";

    public function index(): View
    {
        return \view(self::VIEW_PATH . 'training-calendar.yearly-training-calendar');
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

    public function fiscalYear(): view
    {
        $year = (date('m') > 6) ? date('Y') + 1 : date('Y');

        $courses = CourseSession::join('courses', 'course_sessions.course_id', 'courses.id')
            ->Where('application_start_date', 'like', '%' . ($year - 1) . '%')
            ->orWhere('application_start_date', 'like', '%' . ($year) . '%')
            ->get()
            ->groupBy('course_id');
        //dd($courses);

        $totalVenueCourses = DB::select('SELECT course_id,COUNT(*) as total_course from (SELECT course_id,institute_id,branch_id,training_center_id, count(course_id) AS total_course_id FROM `publish_courses` GROUP BY course_id, institute_id, branch_id, training_center_id) as publish_courses_vertual_table group by course_id');

        $totalVenue = [];
        foreach ($totalVenueCourses as $totalVenueCourse) {
            $totalVenue[$totalVenueCourse->course_id] = $totalVenueCourse->total_course;
        }

        //$courses = Course::active()->get();
        return \view(self::VIEW_PATH . 'training-calendar.fiscal-year', compact( 'totalVenue', 'courses'));
    }


    public function venueList($id): view
    {
        $publishedCourses = PublishCourse::select(
            'institute_id',
            'branch_id',
            'training_center_id'
        )
            ->where(['course_id'=>$id])
            ->groupBy(['institute_id', 'branch_id', 'training_center_id'])
            ->get();
        return \view(self::VIEW_PATH . 'training-calendar.venue-list', compact('publishedCourses'));

    }

}

