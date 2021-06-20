<?php

namespace Module\GovtStakeholder\App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Module\GovtStakeholder\App\Models\UpazilaJobStatistic;

class DashboardController
{
    public function dashboard()
    {
        $data = [];
        $employmentStatistic = UpazilaJobStatistic::where('loc_upazilas.loc_district_id', 1);
        $employmentStatistic->join('loc_upazilas', 'upazila_job_statistics.loc_upazila_id', '=', 'loc_upazilas.id');
        $employmentStatistic->select([DB::raw("SUM(upazila_job_statistics.total_unemployed) as total_unemployed"),
            DB::raw("SUM(upazila_job_statistics.total_employed) as total_employed"),
            DB::raw("SUM(upazila_job_statistics.total_vacancy) as total_vacancy"),
            DB::raw("SUM(upazila_job_statistics.total_new_recruitment) as total_new_recruitment"),
            DB::raw("SUM(upazila_job_statistics.total_skilled_youth) as total_skilled_youth")])
            ->groupBy('upazila_job_statistics.survey_date')
            ->orderBy('upazila_job_statistics.survey_date', 'DESC')
            ->take(5)
            ->get();

        $data['employment_statistic'] = $employmentStatistic->get()->toArray();
        //dd($upazilaJobStatistic->get()->toArray());
        $jobSectorStataistic=UpazilaJobStatistic::where('loc_upazilas.loc_district_id', 1);
        $jobSectorStataistic->join('loc_upazilas', 'upazila_job_statistics.loc_upazila_id', '=', 'loc_upazilas.id');
        $jobSectorStataistic->select(['upazila_job_statistics.job_sector_id as group', DB::raw("SUM(upazila_job_statistics.total_unemployed) as UnEmployed"),
            DB::raw("SUM(upazila_job_statistics.total_employed) as Employed")])
            ->groupBy('upazila_job_statistics.job_sector_id')
            ->orderBy('upazila_job_statistics.job_sector_id', 'ASC')
            ->take(6)
            ->get();

        $data['job_sector_statistic'] = $jobSectorStataistic->get()->toArray();


        return view('govt_stakeholder::backend.dashboard', compact('data'));
    }


}
