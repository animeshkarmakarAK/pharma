<?php

namespace Module\GovtStakeholder\App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Module\GovtStakeholder\App\Models\UpazilaJobStatistic;

class DashboardController
{
    public function dashboard()
    {
        $data = [];
        $upazilaJobStatistic = UpazilaJobStatistic::where('loc_upazilas.loc_district_id', 1);
        $upazilaJobStatistic->join('loc_upazilas', 'upazila_job_statistics.loc_upazila_id', '=', 'loc_upazilas.id');
        $upazilaJobStatistic->select([DB::raw("SUM(upazila_job_statistics.total_unemployed) as total_unemployed"),
            DB::raw("SUM(upazila_job_statistics.total_employed) as total_employed"),
            DB::raw("SUM(upazila_job_statistics.total_vacancy) as total_vacancy"),
            DB::raw("SUM(upazila_job_statistics.total_new_recruitment) as total_new_recruitment"),
            DB::raw("SUM(upazila_job_statistics.total_skilled_youth) as total_skilled_youth")])
            ->groupBy('upazila_job_statistics.job_sector_id')
            ->get();

        dd($upazilaJobStatistic->get()->toArray());

        return view('govt_stakeholder::backend.dashboard', compact('data'));
    }


}
