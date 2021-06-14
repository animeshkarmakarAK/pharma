<?php

namespace Module\GovtStakeholder\App\Http\Controllers;

class DashboardController
{
    public function dashboard()
    {
        return view('govt_stakeholder::backend.dashboard');
    }
}
