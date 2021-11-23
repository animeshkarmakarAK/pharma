<?php

namespace Module\SmefManagement\App\Http\Controllers\Frontend;

use Module\SmefManagement\App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;

class SmefRegistrationController extends Controller
{
    /**
     * items of youth course search page in frontend
     *
     * @return View
     */
    const VIEW_PATH = 'smef_management::frontend.smef-registrations.';

    public function index()
    {
        return view(self::VIEW_PATH.'reg-form');
    }

}
