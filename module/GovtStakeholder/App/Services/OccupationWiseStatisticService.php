<?php

namespace Module\GovtStakeholder\App\Services;

use App\Helpers\Classes\AuthHelper;
use App\Helpers\Classes\DatatableHelper;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Module\GovtStakeholder\App\Models\OccupationWiseStatistic;
use Yajra\DataTables\Facades\DataTables;

class OccupationWiseStatisticService
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
        /** @var Builder|OccupationWiseStatistic $occupationWiseStatistics */
        $occupationWiseStatistics = OccupationWiseStatistic::select(
            [
                'occupation_wise_statistics.id',
                'institutes.title_en as institute_title_en',
                'occupations.title_en as occupation_title_en',
                'occupation_wise_statistics.current_month_skilled_youth',
                'occupation_wise_statistics.next_month_skill_youth',
                'occupation_wise_statistics.row_status',
                'occupation_wise_statistics.survey_date',
            ]
        )->where('institute_id',1);
        $occupationWiseStatistics->join('institutes', 'occupation_wise_statistics.institute_id', '=', 'institutes.id');
        $occupationWiseStatistics->join('occupations', 'occupation_wise_statistics.occupation_id', '=', 'occupations.id');


        return DataTables::eloquent($occupationWiseStatistics)
            ->addColumn('action', DatatableHelper::getActionButtonBlock(static function (OccupationWiseStatistic $occupationWiseStatistic) use ($authUser) {
                $str = '';
                if ($authUser->can('view', $occupationWiseStatistic)) {
                    $str .= '<a href="' . route('govt_stakeholder::admin.occupation-wise-statistics.show', $occupationWiseStatistic->id) . '" class="btn btn-outline-info btn-sm"> <i class="fas fa-eye"></i> Read </a>';
                }
                if ($authUser->can('update', $occupationWiseStatistic)) {
                    $str .= '<a href="' . route('govt_stakeholder::admin.occupation-wise-statistics.edit', $occupationWiseStatistic->id) . '" class="btn btn-outline-warning btn-sm"> <i class="fas fa-edit"></i> Edit </a>';
                }
                if ($authUser->can('delete', $occupationWiseStatistic)) {
                    $str .= '<a href="#" data-action="' . route('govt_stakeholder::admin.occupation-wise-statistics.destroy', $occupationWiseStatistic->id) . '" class="btn btn-outline-danger btn-sm delete"> <i class="fas fa-trash"></i> Delete</a>';
                }

                return $str;
            }))
            ->editColumn('row_status', function (OccupationWiseStatistic $occupationWiseStatistic) {
                return $occupationWiseStatistic->row_status == OccupationWiseStatistic::ROW_STATUS_ACTIVE ? '<a href="#" class="badge badge-success">Active</a>' : '<a href="#" class="badge badge-danger">Inactive</a>';
            })
            ->rawColumns(['action', 'row_status'])
            ->toJson();
    }
}
