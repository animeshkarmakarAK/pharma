<?php


namespace Module\CourseManagement\App\Http\Controllers\Frontend;


use Module\CourseManagement\App\Http\Controllers\BaseController;
use Module\CourseManagement\App\Models\StaticPage;

class StaticContentController extends BaseController
{
    public function index(string $pid)
    {
        $currentInstitute = domainConfig('institute');
        $staticContent = StaticPage::where('page_id', $pid);
        if ($currentInstitute) {
            $staticContent->where('institute_id', $currentInstitute->id);
        }
        $staticContent = $staticContent->firstOrFail();

        return view('course_management::frontend.static-contents.browse', compact('staticContent'));
    }
}
