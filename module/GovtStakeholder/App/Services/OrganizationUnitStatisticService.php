<?php

namespace Module\GovtStakeholder\App\Services;

use App\Helpers\Classes\AuthHelper;
use App\Helpers\Classes\DatatableHelper;
use Carbon\Carbon;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Module\GovtStakeholder\App\Models\organizationUnitStatistic;
use Yajra\DataTables\Facades\DataTables;

class OrganizationUnitStatisticService
{
    public function createOrganizationUnitStatistic(array $data): bool
    {
        $data = array_map(function ($newData) use ($data) {
            $newData['survey_date'] = $data['survey_date'];
            return $newData;
        }, $data['monthly_reports']);


        return organizationUnitStatistic::insert($data);
    }

    public function updateOrganizationUnitStatistic(organizationUnitStatistic $organizationUnitStatistic, array $data): bool
    {

        $data = array_map(function ($newData) use ($data, $organizationUnitStatistic) {
            $newData['survey_date'] = $data['survey_date'];
            $newData['id'] = $organizationUnitStatistic->id;
            return $newData;
        }, $data['monthly_reports']);

        return organizationUnitStatistic::upsert(
            $data, ['id'], ['total_vacancy', 'total_new_recruits', 'total_occupied_position']
        );

    }


    public function validator(Request $request, $id = null): Validator
    {
        $rules = [
            'monthly_reports.*.organization_unit_id' => ['required', 'int'],
            'monthly_reports.*.total_new_recruits' => ['required', 'int'],
            'monthly_reports.*.total_vacancy' => ['required', 'int'],
            'monthly_reports.*.total_occupied_position' => ['required', 'int'],
            'survey_date' => ['required', 'date'],
        ];

        if ($id) {
//            $rules['monthly_reports.*.id'] = ['int'];
            $rules['monthly_reports.*.survey_date'] = ['date'];
        }

        return \Illuminate\Support\Facades\Validator::make($request->all(), $rules);
    }

    public function getServiceLists(Request $request): JsonResponse
    {
        $authUser = AuthHelper::getAuthUser();
        /** @var Builder|organizationUnitStatistic $organizationUnitStatistics */
        $organizationUnitStatistics = organizationUnitStatistic::select(
            [
                'organization_unit_statistics.id',
                'organization_units.title_en as organization_unit_name',
                'organization_unit_statistics.total_occupied_position',
                'organization_unit_statistics.total_vacancy',
                'organization_unit_statistics.total_new_recruits',
                'organization_unit_statistics.survey_date',
            ]);

        $organizationUnitStatistics->join('organization_units', 'organization_unit_statistics.organization_unit_id', '=', 'organization_units.id');

        return DataTables::eloquent($organizationUnitStatistics)
            ->addColumn('action', DatatableHelper::getActionButtonBlock(static function (organizationUnitStatistic $organizationUnitStatistic) use ($authUser) {
                $str = '';
                if ($authUser->can('view', $organizationUnitStatistic)) {
                    $str .= '<a href="' . route('govt_stakeholder::admin.organization-unit-statistics.show', $organizationUnitStatistic->id) . '" class="btn btn-outline-info btn-sm"> <i class="fas fa-eye"></i> Read </a>';
                }
                if ($authUser->can('update', $organizationUnitStatistic)) {
                    $str .= '<a href="' . route('govt_stakeholder::admin.organization-unit-statistics.edit', $organizationUnitStatistic->id) . '" class="btn btn-outline-warning btn-sm"> <i class="fas fa-edit"></i> Edit </a>';
                }
                if ($authUser->can('delete', $organizationUnitStatistic)) {
                    $str .= '<a href="#" data-action="' . route('govt_stakeholder::admin.organization-unit-statistics.destroy', $organizationUnitStatistic->id) . '" class="btn btn-outline-danger btn-sm delete"> <i class="fas fa-trash"></i> Delete</a>';
                }

                return $str;
            }))
            ->editColumn('survey_date', function (OrganizationUnitStatistic $organizationUnitStatistic) {
                $date = new Carbon($organizationUnitStatistic->survey_date);
                return $date->monthName;
            })
            ->rawColumns(['action'])
            ->toJson();
    }

    public function getStatistics(Request $request): JsonResponse
    {
        /** @var organizationUnitStatistic|Builder $organizationUnitStatistics */
        $organizationUnitStatistics = organizationUnitStatistic::select(
            [
                'organization_unit_statistics.id',
                'organization_unit_statistics.total_new_recruits',
                'organization_unit_statistics.total_vacancy',
                'organization_unit_statistics.total_occupied_position',
                'organization_unit_statistics.survey_date',
                'organization_units.title_bn as organization_unit_name',
                'organization_unit_types.title_bn as organization_unit_type_name',
            ]);

        $organizationUnitStatistics->rightJoin('organization_units', function($query) use($request) {
            $query->on('organization_unit_statistics.organization_unit_id', '=', 'organization_units.id');
            if ($request->input('month')) {
                $query->whereMonth('survey_date', $request->input('month'));
            }

            if ($request->input('loc_division_id')) {
                $query->where('organization_units.loc_division_id', $request->input('loc_division_id'));
            }

            if ($request->input('loc_district_id')) {
                $query->where('organization_units.loc_district_id', $request->input('loc_district_id'));
            }
        });

        $organizationUnitStatistics->leftJoin('organization_unit_types', 'organization_units.organization_unit_type_id', '=', 'organization_unit_types.id');

        return DataTables::eloquent($organizationUnitStatistics)
            ->editColumn('survey_date', function () {
                return "";
            })
            ->toJson();
    }

    public function unemploymentStatistic(Request $request): JsonResponse
    {
        $organizationUnitStatistics = organizationUnitStatistic::leftJoin('organization_units','organization_unit_statistics.organization_unit_id', '=', 'organization_units.id')->groupBy('organization_unit_id', 'organization_unit_name')
            ->selectRaw('sum(total_new_recruits) as sum_new_recruits, sum(total_vacancy) as sum_vacancy, sum(total_occupied_position) as sum_occupied_position, organization_units.title_bn as organization_unit_name');

        if ($request->input('loc_division_id')) {
            $organizationUnitStatistics->where('organization_units.loc_division_id', $request->input('loc_division_id'));
        }

        if ($request->input('loc_district_id')) {
            $organizationUnitStatistics->where('organization_units.loc_district_id', $request->input('loc_district_id'));
        }
        return DataTables::eloquent($organizationUnitStatistics)
            ->toJson();
    }

}
