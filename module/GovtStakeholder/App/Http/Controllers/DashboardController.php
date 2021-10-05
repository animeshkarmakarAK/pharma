<?php

namespace Module\GovtStakeholder\App\Http\Controllers;

use App\Helpers\Classes\AuthHelper;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Module\CourseManagement\App\Models\Batch;
use Module\CourseManagement\App\Models\Branch;
use Module\CourseManagement\App\Models\Course;
use Module\CourseManagement\App\Models\Institute;
use Module\CourseManagement\App\Models\Programme;
use Module\CourseManagement\App\Models\TrainingCenter;
use Module\CourseManagement\App\Models\Youth;
use Module\CourseManagement\App\Models\YouthBatch;
use Module\GovtStakeholder\App\Models\OrganizationUnit;
use Module\GovtStakeholder\App\Models\UpazilaJobStatistic;

class DashboardController
{
    private function getEmployeesEmploymentInformation($jobSectorStatistic, $authUser): array
    {
        $jobSectorStatistic->where(function ($query) use ($authUser) {
            $query->whereMonth('upazila_job_statistics.survey_date', Carbon::now()->month)
                ->whereYear('upazila_job_statistics.survey_date', Carbon::now()->year);

            if ($authUser->isDCUser()) {
                $query->where('loc_upazilas.loc_district_id', $authUser->loc_district_id);
            }

            if ($authUser->isDivcomUser()) {
                $query->where('loc_upazilas.loc_division_id', $authUser->loc_division_id);
            }
        })
            ->orWhere(function ($query) use ($authUser) {
                $lastMonth = Carbon::now()->subMonth();
                $query->whereMonth('upazila_job_statistics.survey_date', $lastMonth->month)
                    ->whereYear('upazila_job_statistics.survey_date', $lastMonth->year);

                if ($authUser->isDCUser()) {
                    $query->where('loc_upazilas.loc_district_id', $authUser->loc_district_id);
                }

                if ($authUser->isDivcomUser()) {
                    $query->where('loc_upazilas.loc_division_id', $authUser->loc_division_id);
                }
            });

        $data = [];
        $data['totalUnemployed'] = $jobSectorStatistic->sum('total_unemployed');
        $data['totalEmployed'] = $jobSectorStatistic->sum('total_employed');
        $data['totalVacant'] = $jobSectorStatistic->sum('total_vacancy');

        return $data;
    }

    private function redirectToInstituteUserDashboard(): array
    {
        $mostDemandableCourses = DB::table('youth_batches')
            ->select(
                DB::raw('count(batches.course_id) as total'),
                'batches.course_id',
                'courses.title_en as course_title_en',
                'courses.title_bn as course_title_bn',
            )
            ->join('batches', 'youth_batches.batch_id', '=', 'batches.id')
            ->join('courses', 'batches.course_id', '=', 'courses.id')
            ->groupBy('batches.course_id')
            ->orderBy('total','DESC')->limit(6)
            ->get();

        $totalInstitute = Institute::active()->count();
        $totalYouth = Youth::active()->count();
        $totalCourse = Course::acl()->active()->count();
        $totalBranch = Branch::acl()->active()->count();
        $totalTrainingCenter = TrainingCenter::acl()->active()->count();
        $totalProgramme = Programme::acl()->active()->count();
        $totalBatch = Batch::acl()->count();

        $data = [];
        $data['total_institute'] = $totalInstitute;
        $data['total_youth'] = $totalYouth;
        $data['total_course'] = $totalCourse;
        $data['total_branch'] = $totalBranch;
        $data['total_training_center'] = $totalTrainingCenter;
        $data['total_programme'] = $totalProgramme;
        $data['totalBatch'] = $totalBatch;
        $data['most_demandable_courses'] = $mostDemandableCourses->toJson();
        return $data;
    }


    public function dashboard()
    {
        $authUser = AuthHelper::getAuthUser();
        $months = [];

        $startDate = Carbon::now()->subMonths(6)->startOfMonth();
        $incrementDate = Carbon::now()->subMonths(6)->startOfMonth();
        $endDate = Carbon::now();

        for ($i = 0; $i < 6; $i++) {
            $months[$incrementDate->format('F')] = [];
            $incrementDate->addMonth();
        }

        $data = [];
        $employmentStatistic = UpazilaJobStatistic::query();

        $employmentStatistic->join('loc_upazilas', 'upazila_job_statistics.loc_upazila_id', '=', 'loc_upazilas.id');

        if ($authUser->isDCUser()) {
            $employmentStatistic->where('loc_upazilas.loc_district_id', $authUser->loc_district_id);
        }

        if ($authUser->isDivcomUser()) {
            $employmentStatistic->where('loc_upazilas.loc_division_id', $authUser->loc_division_id);
        }

        $employmentStatistic->select([DB::raw("SUM(upazila_job_statistics.total_unemployed) as total_unemployed"),
            DB::raw("SUM(upazila_job_statistics.total_employed) as total_employed"),
            DB::raw("SUM(upazila_job_statistics.total_vacancy) as total_vacancy"),
            DB::raw("SUM(upazila_job_statistics.total_new_recruitment) as total_new_recruitment"),
            DB::raw("SUM(upazila_job_statistics.total_skilled_youth) as total_skilled_youth"),
            DB::raw('DATE_FORMAT(upazila_job_statistics.survey_date, "%b") as survey_date')])
            ->whereBetween(DB::raw('date(upazila_job_statistics.survey_date)'), [$startDate, $endDate])
            ->groupBy('upazila_job_statistics.survey_date')
            ->orderBy('upazila_job_statistics.survey_date', 'DESC');
        $employmentStatistic = $employmentStatistic->get()->keyBy('survey_date');

        $results = [];
        foreach ($months as $month => $values) {
            if (empty($employmentStatistic[$month])) {
                $results[$month] = [
                    'total_unemployed' => 0,
                    'total_employed' => 0,
                    'total_vacancy' => 0,
                    'total_new_recruitment' => 0,
                    'total_skilled_youth' => 0,
                    'survey_date' => $month
                ];
            } else {
                $results[$month] = $employmentStatistic[$month]->toArray();
            }
        }

        $data['employment_statistic'] = array_values($results);

        $jobSectorStatistic = UpazilaJobStatistic::query();
        $jobSectorStatistic->join('loc_upazilas', 'upazila_job_statistics.loc_upazila_id', '=', 'loc_upazilas.id');

        $lastTwoMonthsEmploymentInfos = $this->getEmployeesEmploymentInformation($jobSectorStatistic, $authUser);

        if ($authUser->isDCUser()) {
            /** if current month info or last current month info exist then get info */
            $lastTwoMonthsEmploymentInfos = $this->getEmployeesEmploymentInformation($jobSectorStatistic, $authUser);
        }

        if ($authUser->isDivcomUser()) {
            $jobSectorStatistic->where('loc_upazilas.loc_division_id', $authUser->loc_division_id);
        }

        $jobSectorStatistic->join('job_sectors', 'upazila_job_statistics.job_sector_id', '=', 'job_sectors.id');
        $jobSectorStatistic->select(['upazila_job_statistics.job_sector_id as group', 'job_sectors.title_bn as sector', DB::raw("SUM(upazila_job_statistics.total_unemployed) as UnEmployed"),
            DB::raw("SUM(upazila_job_statistics.total_employed) as Employed")])
            ->groupBy('upazila_job_statistics.job_sector_id', 'job_sectors.title_bn')
            ->orderBy('upazila_job_statistics.job_sector_id', 'ASC')
            ->get();

        $data['job_sector_statistic'] = $jobSectorStatistic->get()->toArray();

        if ($authUser->isInstituteUser()) {
            $data = $this->redirectToInstituteUserDashboard();
            return \view('govt_stakeholder::backend.institute-dashboard', compact('data'));
        }

        if ($authUser->isDCUser()) {
            $totalOrganizationUnit = OrganizationUnit::where('loc_district_id', $authUser->loc_district_id)->count();
        } else {
            $totalOrganizationUnit = OrganizationUnit::count();
        }

        return view('govt_stakeholder::backend.dashboard', with([
            'data' => $data,
            'totalOrganizationUnit' => $totalOrganizationUnit,
            'lastTwoMonthsEmploymentInfos' => $lastTwoMonthsEmploymentInfos
        ]));
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
        $upazilaJobStatistics->where('upazila_job_statistics.survey_date', date('Y-m-01'));


        if ($request->input('division_id')) {
            $upazilaJobStatistics->join('loc_divisions', 'loc_upazilas.loc_division_id', 'loc_divisions.id');
            $upazilaJobStatistics->where('loc_divisions.id', $request->input('division_id'));
        } else {
            $upazilaJobStatistics->join('loc_districts', 'loc_upazilas.loc_district_id', 'loc_districts.id');
            $upazilaJobStatistics->where('loc_districts.id', $request->input('district_id'));
        }

        $upazilaJobStatistics->groupBy(
            'upazila_job_statistics.loc_upazila_id',
        );
        return $upazilaJobStatistics->get();
    }
}
