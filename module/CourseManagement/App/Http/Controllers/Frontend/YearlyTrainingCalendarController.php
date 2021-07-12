<?php

namespace Module\CourseManagement\App\Http\Controllers\Frontend;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
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
        $from = date(($year-1).'-07-01');
        $to = date($year.'-6-30');

        //$courses = CourseSession::join('publish_courses', 'course_sessions.course_id', 'publish_courses.course_id')
        $courses = CourseSession::join('courses', 'course_sessions.course_id', 'courses.id')
            ->whereBetween('course_sessions.application_start_date', [$from, $to])
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

        $totalCourseVenue = DB::select('SELECT course_name,course_fee, course_id,COUNT(*) as total_venue from (SELECT  courses.title_bn as course_name,courses.course_fee as course_fee, course_id,publish_courses.institute_id,branch_id,training_center_id, count(course_id) AS total_course_id FROM `publish_courses` join `courses` on courses.id = publish_courses.course_id GROUP BY course_id, institute_id, branch_id, training_center_id) as publish_courses_vertual_table group by course_id');

        $totalAnnualTrainingTarget = CourseSession::select(
            'course_id',
            DB::raw('SUM(course_sessions.max_seat_available) as total_seat'),

        )
            ->join('courses', 'course_sessions.course_id', 'courses.id')
            ->groupBy('course_id')
            ->pluck('total_seat', 'course_id');


        return \view(self::VIEW_PATH . 'training-calendar.fiscal-year', compact('totalCourseVenue', 'courses', 'totalAnnualTrainingTarget'));
    }


    public function venueList(Request $request, $id): view
    {
        $query = $request->query('search');
        $publishedCourses = PublishCourse::select(
            'publish_courses.institute_id',
            'publish_courses.branch_id',
            'publish_courses.training_center_id',
            'publish_courses.course_id',
        )
            ->join('institutes', 'publish_courses.institute_id', '=', 'institutes.id')
            ->leftJoin('branches', 'publish_courses.branch_id', '=', 'branches.id')
            ->leftJoin('training_centers', 'publish_courses.training_center_id', '=', 'training_centers.id')
            ->where(['publish_courses.course_id' => $id])
            ->where(function ($result) use ($query) {
                $result
                    ->where('training_centers.title_bn', 'LIKE', '%' . $query . '%')
                    ->orWhere('branches.title_bn', 'LIKE', '%' . $query . '%')
                    ->orwhere('institutes.title_bn', 'LIKE', '%' . $query . '%')
                    ->orWhere('training_centers.address', 'LIKE', '%' . $query . '%')
                    ->orWhere('branches.address', 'LIKE', '%' . $query . '%')
                    ->orWhere('institutes.address', 'LIKE', '%' . $query . '%')
                    ->orWhere('institutes.primary_mobile', 'LIKE', '%' . $query . '%');
            })
            ->groupBy(['publish_courses.institute_id', 'publish_courses.branch_id', 'publish_courses.training_center_id', 'publish_courses.course_id'])
            ->get();

        return \view(self::VIEW_PATH . 'training-calendar.venue-list', compact('publishedCourses'));
    }

}

