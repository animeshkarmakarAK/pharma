<?php

namespace Module\CourseManagement\App\Http\Controllers\Frontend;

use Illuminate\Contracts\View\View;
use Module\CourseManagement\App\Http\Controllers\Controller;
use Module\CourseManagement\App\Models\Institute;

class InstitutePageController extends Controller
{
    /**
     * items of youth course search page in frontend
     *
     * @return View
     */
    const VIEW_PATH = 'course_management::frontend.institute-list.';

    public function index($instituteSlug = null): View
    {
//        $currentInstitute = Institute::where('slug', $instituteSlug)->get();

        $institutes = Institute::all();

        return view(self::VIEW_PATH . 'index', compact('institutes'));
    }

    /**
     * @param int $id
     * @return View
     */
    public function details(int $id): View
    {
        $institute = Institute::findOrFail($id);
        return \view('course_management::frontend.ssp.details', compact('institute'));
    }
}
