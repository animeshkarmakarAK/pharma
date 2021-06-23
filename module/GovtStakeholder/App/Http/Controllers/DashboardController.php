<?php

namespace Module\GovtStakeholder\App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Module\GovtStakeholder\App\Models\UpazilaJobStatistic;
use Illuminate\Http\Request;

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
            //->take(5)
            ->get();

        $data['employment_statistic'] = array_reverse($employmentStatistic->get()->toArray());
        //dd($employmentStatistic);
        $jobSectorStatistic=UpazilaJobStatistic::where('loc_upazilas.loc_district_id', 1);
        $jobSectorStatistic->join('loc_upazilas', 'upazila_job_statistics.loc_upazila_id', '=', 'loc_upazilas.id');
        $jobSectorStatistic->join('job_sectors', 'upazila_job_statistics.job_sector_id', '=', 'job_sectors.id');
        $jobSectorStatistic->select(['upazila_job_statistics.job_sector_id as group','job_sectors.title_bn as sector', DB::raw("SUM(upazila_job_statistics.total_unemployed) as UnEmployed"),
            DB::raw("SUM(upazila_job_statistics.total_employed) as Employed")])
            ->groupBy('upazila_job_statistics.job_sector_id','job_sectors.title_bn')
            ->orderBy('upazila_job_statistics.job_sector_id', 'ASC')
            ->get();

        $data['job_sector_statistic'] = $jobSectorStatistic->get()->toArray();
        //dd($data['employment_statistic']);
        return view('govt_stakeholder::backend.dashboard', compact('data'));
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
