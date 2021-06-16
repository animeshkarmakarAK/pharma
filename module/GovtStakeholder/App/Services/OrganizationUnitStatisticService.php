<?php

namespace Module\GovtStakeholder\App\Services;

use App\Helpers\Classes\AuthHelper;
use App\Helpers\Classes\DatatableHelper;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Module\GovtStakeholder\App\Models\OccupationWiseStatistic;
use Module\GovtStakeholder\App\Models\OrganizationUnitStatistic;
use Yajra\DataTables\Facades\DataTables;

class OrganizationUnitStatisticService
{
    public function createOccupationWiseStatistic(array $data): bool
    {
        $data = array_map(function ($newData) use($data) {
            $newData['institute_id']='1';// TODO: dynamic institute id will be the actual value
            $newData['survey_date']=$data['survey_date'];
           return $newData;
       },$data['monthly_reports']);

        return  OccupationWiseStatistic::insert($data);
    }

    public function updateOccupationWiseStatistic(OccupationWiseStatistic $occupationWiseStatistic, array $data): bool
    {
        //dd($data);

        $data = array_map(function ($newData) use($data){
            if(empty($newData['id'])){
                $newData['id']=null;
            }
            $newData['survey_date']=$data['survey_date'];
            $newData['institute_id']='1';// TODO: dynamic institute id will be the actual value
            return $newData;
        },$data['monthly_reports']);

        //dd($data);
        return OccupationWiseStatistic::upsert(
            $data,
            ['id'],
            [
                'current_month_skilled_youth',
                'next_month_skill_youth',
            ]
        );

    }

    public function deleteOccupationWiseStatistic(OccupationWiseStatistic $occupationWiseStatistic): bool
    {
        return OccupationWiseStatistic::where([['survey_date',$occupationWiseStatistic->survey_date],['institute_id',$occupationWiseStatistic->institute_id]])->delete();
    }

    public function validator(Request $request, $id = null): Validator
    {
        $rules = [
            'monthly_reports.*.current_month_skilled_youth' => ['required', 'int'],
            'monthly_reports.*.next_month_skill_youth' => ['required', 'int'],
            'monthly_reports.*.occupation_id' => ['required', 'int'],
            'survey_date'=>['required','date'],
        ];
        if($id){
            $rules['monthly_reports.*.id']=['int'];
            $rules['monthly_reports.*.survey_date']=['date'];
        }

        return \Illuminate\Support\Facades\Validator::make($request->all(), $rules);
    }

    public function getServiceLists(Request $request): JsonResponse
    {
        $authUser = AuthHelper::getAuthUser();
        /** @var Builder|OrganizationUnitStatistic $organizationUnitStatistics */
        $organizationUnitStatistics = OrganizationUnitStatistic::select(
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
            ->addColumn('action', DatatableHelper::getActionButtonBlock(static function (OrganizationUnitStatistic $organizationUnitStatistic) use ($authUser) {
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
            ->rawColumns(['action'])
            ->toJson();
    }
}
