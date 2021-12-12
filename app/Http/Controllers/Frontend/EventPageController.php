<?php


namespace App\Http\Controllers\Frontend;


use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Event;
use App\Models\Gallery;
use App\Models\GalleryCategory;
use App\Models\PublishCourse;

class EventPageController
{
    const VIEW_PATH = "frontend.events.";


    public function singleEventPage(Event $event)
    {
        return view(self::VIEW_PATH . 'event', compact('event'));
    }

    public function instituteEvent(Request $request)
    {
        $currentInstitute = app('currentInstitute');
        $events = Event::select([
            DB::raw('DATE(DATE_FORMAT(events.date, "%Y-%c-%d")) as start'),
            DB::raw('DATE(DATE_FORMAT(events.date, "%Y-%c-%d")) as end'),
            DB::raw('count(*) as title')
        ]);
        $events->where(['events.institute_id' => $currentInstitute->id]);
        $events->groupBy('start');
        return $events->get()->toArray();
    }
    public function instituteEventDate(Request $request)
    {
        $currentInstitute = app('currentInstitute');
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
