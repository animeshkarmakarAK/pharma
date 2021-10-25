<?php


namespace Module\CourseManagement\App\Http\Controllers\Frontend;


use Module\CourseManagement\App\Models\Event;
use Module\CourseManagement\App\Models\Gallery;
use Module\CourseManagement\App\Models\GalleryCategory;

class eventPageController
{
    const VIEW_PATH = "course_management::frontend.events.";


    public function singleEventPage(Event $event)
    {
        return view(self::VIEW_PATH . 'event', compact('event'));
    }
}
