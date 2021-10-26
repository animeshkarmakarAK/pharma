<?php


namespace Module\CourseManagement\App\Http\Controllers\Frontend;


use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Module\CourseManagement\App\Models\Event;
use Module\CourseManagement\App\Models\Gallery;
use Module\CourseManagement\App\Models\GalleryCategory;
use Module\CourseManagement\App\Models\PublishCourse;

class eventPageController
{
    const VIEW_PATH = "course_management::frontend.events.";


    public function singleEventPage(Event $event)
    {
        return view(self::VIEW_PATH . 'event', compact('event'));
    }

    public function instituteEvent(Request $request)
    {
        $currentInstitute = domainConfig('institute');
        $events = Event::select([
            DB::raw('DATE(DATE_FORMAT(events.date, "%Y-%c-%d")) as start'),
            DB::raw('DATE(DATE_FORMAT(events.date, "%Y-%c-%d")) as end'),
            DB::raw('count(*) as title')
        ]);
        $events->where(['events.institute_id' => $currentInstitute->id]);
        $events->groupBy('start');

        /*if (!empty($request->date)) {
            $events->where('events.date', 'LIKE', '%' . $request->date . '%');
        }*/
        return $events->get()->toArray();
    }
    public function instituteEventDate(Request $request)
    {
        $currentInstitute = domainConfig('institute');
        $currentInstituteEvents = Event::where([
            'institute_id' => $currentInstitute->id,
        ]);
        if (!empty($request->date)) {
            $currentInstituteEvents->where('events.date', 'LIKE', '%' . $request->date . '%');
        }
        $currentInstituteEvents->orderBy('date', 'ASC');
        $currentInstituteEvents = $currentInstituteEvents->limit(5);
        return $currentInstituteEvents->get()->toArray();
    }
}
