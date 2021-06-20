<?php

namespace Module\GovtStakeholder\App\Http\Controllers;

use App\Helpers\Classes\AuthHelper;
use App\Models\LocDistrict;
use App\Models\LocUpazila;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Module\GovtStakeholder\App\Models\UpazilaJobStatistic;

class DashboardController
{
    public function dashboard()
    {

        return view('govt_stakeholder::backend.dashboard');
    }

    public function dashboardUpazilaJobStatistic(Request $request)
    {
        $upazilaJobStatistics = UpazilaJobStatistic::select(
            [
                DB::raw('SUM(total_unemployed) as total_unemployed'),
                DB::raw('SUM(total_employed) as total_employed'),
                DB::raw('SUM(total_vacancy) as total_vacancy'),
                DB::raw('SUM(total_new_recruitment) as total_new_recruitment'),
                DB::raw('SUM(total_new_skilled_youth) as total_new_skilled_youth'),
                DB::raw('SUM(total_skilled_youth) as total_skilled_youth'),
                DB::raw('loc_upazilas.title_en as upazila_title'),
            ]
        );
        $upazilaJobStatistics->join('loc_upazilas', 'upazila_job_statistics.loc_upazila_id', 'loc_upazilas.id');
        $upazilaJobStatistics->join('loc_districts', 'loc_upazilas.loc_district_id', 'loc_districts.id');
        $upazilaJobStatistics->where('loc_districts.id', $request->input('district_id'));
        $upazilaJobStatistics->where('upazila_job_statistics.survey_date', date('Y-m-01'));

        $upazilaJobStatistics->groupBy(
            'upazila_job_statistics.loc_upazila_id',
        );
        return $upazilaJobStatistics->get();
    }
}
