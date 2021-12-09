<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Course;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\CourseSession;
use App\Models\Institute;
use App\Models\PublishCourse;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;


class YearlyTrainingCalendarController extends Controller
{
    const VIEW_PATH = "frontend.";

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
            'courses.title_en as description',//this for tooltip
            DB::raw('DATE(course_sessions.application_start_date) as start'),
            DB::raw('DATE_ADD(DATE(course_sessions.application_end_date), INTERVAL 1 Day) as end'),
            'publish_courses.institute_id',
            'publish_courses.training_center_id',
        ]);
        $courseSessions->join('course_sessions', 'publish_courses.id', '=', 'course_sessions.publish_course_id');
        $courseSessions->join('courses', 'publish_courses.course_id', '=', 'courses.id');
        $courseSessions->where(['publish_courses.institute_id' => $currentInstitute->id]);


        if (!empty($request->input('institute_id'))) {
            $courseSessions->where('publish_courses.institute_id', $request->input('institute_id'));
        }

        if (!empty($request->input('training_center_id'))) {
            $trainingCenterId = '"' . $request->input('training_center_id') . '"';
            $courseSessions->where('publish_courses.training_center_id', 'LIKE', '%' . $trainingCenterId . '%');
            $courseSessions->orWhere(function ($query) use ($currentInstitute) {
                $query->where(['publish_courses.institute_id' => $currentInstitute->id])
                    ->where(['publish_courses.training_center_id' => null]);
            });
        }

        return $courseSessions->get()->toArray();
    }

    public function fiscalYear($instituteSlug): view
    {
        $currentInstitute = Institute::where('slug', $instituteSlug)->first();
        $year = (date('m') > 6) ? date('Y') + 1 : date('Y');
        $from = date(($year - 1) . '-07-01');
        $to = date($year . '-06-30');

        $courses = Course::get();

        $totalCourseVenues = [];


        $totalCourseVenue = [];
        foreach ($totalCourseVenues as $venueCourse) {
            $totalCourseVenue[$venueCourse->course_id] = $venueCourse;
        }

        return \view(self::VIEW_PATH . 'training-calendar.fiscal-year', compact('totalCourseVenue', 'courses'/*, 'totalAnnualTrainingTarget'*/));
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
                    ->where('training_centers.title_en', 'LIKE', '%' . $query . '%')
                    ->orWhere('branches.title_en', 'LIKE', '%' . $query . '%')
                    ->orwhere('institutes.title_en', 'LIKE', '%' . $query . '%')
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

