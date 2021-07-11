<?php

namespace Module\CourseManagement\App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use Module\CourseManagement\App\Http\Controllers\Controller;
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

    public function allEvent(Request $request)
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

        if (!empty($request->input('institute_id'))) {
            $courseSessions->where('publish_courses.institute_id', $request->input('institute_id'));
        }
        if (!empty($request->input('branch_id'))) {
            $courseSessions->where('publish_courses.branch_id', $request->input('branch_id'));
        }
        if (!empty($request->input('training_center_id'))) {
            $courseSessions->where('publish_courses.training_center_id', $request->input('training_center_id'));
        }

        return $courseSessions->get()->toArray();
    }


    public function fiscalYear(): view
    {
        $year = (date('m') > 6) ? date('Y') + 1 : date('Y');

        $courses = CourseSession::join('publish_courses', 'course_sessions.course_id', 'publish_courses.course_id')
            ->Where('application_start_date', 'like', '%' . ($year - 1) . '%')
            ->orWhere('application_start_date', 'like', '%' . ($year) . '%')
            ->get()
            ->groupBy('course_id')
            ->values();
//
//        $tmp = CourseSession::select(
//           'publish_courses.institute_id',
//            'publish_courses.branch_id',
//            'publish_courses.course_id',
//            DB::raw('count(publish_courses.institute_id) as total'))
//            ->join('publish_courses', 'course_sessions.publish_course_id', '=', 'publish_courses.id')
//            ->groupBy('publish_courses.course_id')
//            ->get();
//        dd($tmp);

        $totalCourseVenue = DB::select('SELECT course_name,course_fee, course_id,COUNT(*) as total_venue from (SELECT  courses.title_en as course_name,courses.course_fee as course_fee, course_id,publish_courses.institute_id,branch_id,training_center_id, count(course_id) AS total_course_id FROM `publish_courses` join `courses` on courses.id = publish_courses.course_id GROUP BY course_id, institute_id, branch_id, training_center_id) as publish_courses_vertual_table group by course_id');

        $totalAnnualTrainingTarget = CourseSession::select(
            'course_id',
            DB::raw('SUM(course_sessions.max_seat_available) as total_seat'),

        )
            ->join('courses','course_sessions.course_id','courses.id')
            ->groupBy('course_id')
            ->pluck('total_seat','course_id');




        return \view(self::VIEW_PATH . 'training-calendar.fiscal-year', compact('totalCourseVenue', 'courses','totalAnnualTrainingTarget'));
    }


    public function venueList($id): view
    {
        $publishedCourses = PublishCourse::select(
            'institute_id',
            'branch_id',
            'training_center_id'
        )
            ->where(['course_id' => $id])
            ->groupBy(['institute_id', 'branch_id', 'training_center_id'])
            ->get();
        return \view(self::VIEW_PATH . 'training-calendar.venue-list', compact('publishedCourses'));
    }

    public function venueListSearch(Request $request): view
    {
        //dd($request->all());
        $publishedCourses = PublishCourse::select(
            'publish_courses.institute_id',
            'publish_courses.branch_id',
            'publish_courses.training_center_id'
        )
            ->join('institutes','publish_courses.institute_id','institutes.id')
            ->join('branches','publish_courses.branch_id','branches.id')
            ->join('training_centers','publish_courses.training_center_id','training_centers.id')
            ->where(['course_id' => $request->course_id])
            ->orWhere('institutes.title_bn', 'LIKE', '%' . $request->input('searchValue') . '%')
            ->orWhere('branches.title_bn', 'LIKE', '%' . $request->input('searchValue') . '%')
            ->orWhere('training_centers.title_bn', 'LIKE', '%' . $request->input('searchValue') . '%')
            ->groupBy(['publish_courses.institute_id', 'publish_courses.branch_id', 'publish_courses.training_center_id'])
            ->get();

        //dd(count($publishedCourses));
        return \view(self::VIEW_PATH . 'training-calendar.venue-list', compact('publishedCourses'));
    }

}

