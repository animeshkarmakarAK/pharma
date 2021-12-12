<?php


namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\BaseController;
use App\Models\Institute;
use App\Models\StaticPage;

class StaticContentController extends BaseController
{
    public function index(string $pid)
    {
        $currentInstitute = app('currentInstitute');

        $staticContent = StaticPage::where('page_id', $pid);
        if ($currentInstitute) {
            $staticContent->where('institute_id', $currentInstitute->id);
        } else {
            $staticContent->whereNull('institute_id');
        }
        $staticContent = $staticContent->firstOrFail();

        return view('frontend.static-contents.browse', compact('staticContent'));
    }
}
