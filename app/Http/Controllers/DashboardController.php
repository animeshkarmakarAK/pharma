<?php

namespace App\Http\Controllers;

class DashboardController
{
    public function dashboard()
    {
        return view('master::backend.dashboard');
    }
}
