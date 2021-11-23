<?php

namespace Module\SmefManagement\App\Http\Controllers\Frontend;

use Module\SmefManagement\App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;

class SmefHomeController extends Controller
{
    /**
     * items of youth course search page in frontend
     *
     * @return View
     */
    const VIEW_PATH = 'smef_management::frontend.';

    public function index()
    {
        return view(self::VIEW_PATH.'home');
    }

}
