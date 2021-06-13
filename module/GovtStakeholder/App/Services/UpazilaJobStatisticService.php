<?php

namespace Module\GovtStakeholder\App\Services;

use App\Helpers\Classes\AuthHelper;
use App\Helpers\Classes\DatatableHelper;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Module\GovtStakeholder\App\Models\UpazilaJobStatistic;
use Yajra\DataTables\Facades\DataTables;

class UpazilaJobStatisticService
{
    public function createUpazilaJobStatistic(array $data): UpazilaJobStatistic
    {
        $data['survey_date'] = date('Y-m-01', strtotime($data['survey_date']));
        return UpazilaJobStatistic::create($data);
    }

    public function updateUpazilaJobStatistic(UpazilaJobStatistic $upazilaJobStatistic, array $data): UpazilaJobStatistic
    {
        $data['survey_date'] = date('Y-m-01', strtotime($data['survey_date']));
        $upazilaJobStatistic->fill($data);
        $upazilaJobStatistic->save();

        return $upazilaJobStatistic;
    }

    public function deleteUpazilaJobStatistic(UpazilaJobStatistic $upazilaJobStatistic): bool
    {
        return $upazilaJobStatistic->delete();
    }

    public function validator(Request $request, $id = null): Validator
    {
        $rules = [
            'loc_upazila_id' => [
                'required',
                'int',
                'exists:loc_upazilas,id',
            ],
            'job_sector_id' => [
                'required',
                'int',
                'exists:job_sectors,id',
            ],
            'total_unemployed' => ['required', 'int'],
            'total_employed' => ['required', 'int'],
            'total_vacancy' => ['required', 'int'],
            'total_new_recruitment' => ['required', 'int'],
            'total_new_skilled_youth' => ['required', 'int'],
            'total_skilled_youth' => ['required', 'int'],
            'survey_date' => [
                'required',
                static function ($attribute, $value, $fail) use ($request, $id) {
                    $surveyDate = date('Y-m-01', strtotime($value));

                    $result = UpazilaJobStatistic::where('loc_upazila_id', $request->input('loc_upazila_id'))
                        ->where('job_sector_id', $request->input('job_sector_id'))
                        ->where('survey_date', $surveyDate);
                    if (!empty($id)) {
                        $result->where('id', '!=', $id);
                    }

                    if ($result->count()) {
                        $fail('Survey report already added for this month');
                    }
                }
            ],

            'row_status' => [
                'required_if:' . $id . ',!=,null',
            ],
        ];

        return \Illuminate\Support\Facades\Validator::make($request->all(), $rules);
    }

    public function getServiceLists(Request $request): JsonResponse
    {
        $authUser = AuthHelper::getAuthUser();
        /** @var Builder|UpazilaJobStatistic $upazilaJobStatistics */
        $upazilaJobStatistics = UpazilaJobStatistic::select(
            [
                'upazila_job_statistics.id',
                'loc_upazilas.title_en as loc_upazila_title_en',
                'job_sectors.title_en as job_sector_title_en',
                'upazila_job_statistics.survey_date',
                'upazila_job_statistics.row_status',
            ]
        );
        $upazilaJobStatistics->join('loc_upazilas', 'upazila_job_statistics.loc_upazila_id', '=', 'loc_upazilas.id');
        $upazilaJobStatistics->join('job_sectors', 'upazila_job_statistics.job_sector_id', '=', 'job_sectors.id');


        return DataTables::eloquent($upazilaJobStatistics)
            ->addColumn('action', DatatableHelper::getActionButtonBlock(static function (UpazilaJobStatistic $upazilaJobStatistic) use ($authUser) {
                $str = '';
                if ($authUser->can('view', $upazilaJobStatistic)) {
                    $str .= '<a href="' . route('govt_stakeholder::admin.upazila-job-statistics.show', $upazilaJobStatistic->id) . '" class="btn btn-outline-info btn-sm"> <i class="fas fa-eye"></i> Read </a>';
                }
                if ($authUser->can('update', $upazilaJobStatistic)) {
                    $str .= '<a href="' . route('govt_stakeholder::admin.upazila-job-statistics.edit', $upazilaJobStatistic->id) . '" class="btn btn-outline-warning btn-sm"> <i class="fas fa-edit"></i> Edit </a>';
                }
                if ($authUser->can('delete', $upazilaJobStatistic)) {
                    $str .= '<a href="#" data-action="' . route('govt_stakeholder::admin.upazila-job-statistics.destroy', $upazilaJobStatistic->id) . '" class="btn btn-outline-danger btn-sm delete"> <i class="fas fa-trash"></i> Delete</a>';
                }

                return $str;
            }))
            ->editColumn('row_status', function (UpazilaJobStatistic $upazilaJobStatistic) {
                return $upazilaJobStatistic->row_status == UpazilaJobStatistic::ROW_STATUS_ACTIVE ? '<a href="#" class="badge badge-success">Active</a>' : '<a href="#" class="badge badge-danger">Inactive</a>';
            })
            ->rawColumns(['action', 'row_status'])
            ->toJson();
    }
}
