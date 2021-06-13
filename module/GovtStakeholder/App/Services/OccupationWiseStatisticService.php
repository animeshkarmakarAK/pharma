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
    public function createOccupationWiseStatistic(array $data): OccupationWiseStatistic
    {
        return OccupationWiseStatistic::create($data);
    }

    public function updateOccupationWiseStatistic(OccupationWiseStatistic $occupationWiseStatistic, array $data): OccupationWiseStatistic
    {
        $occupationWiseStatistic->fill($data);
        $occupationWiseStatistic->save();

        return $occupationWiseStatistic;
    }

    public function deleteOccupationWiseStatistic(OccupationWiseStatistic $occupationWiseStatistic): bool
    {
        return $occupationWiseStatistic->delete();
    }

    public function validator(Request $request, $id = null): Validator
    {
        $rules = [
            'institute_id' => [
                'required',
                'int',
                'exists:institutes,id',
            ],
            'occupation_id' => [
                'required',
                'int',
                'exists:occupations,id',
            ],
            'current_month_skilled_youth' => ['required', 'int'],
            'next_month_skill_youth' => ['required', 'int'],
            'row_status' => [
                'required_if:' . $id . ',!=,null',
            ],
        ];

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
            ]
        );
        $occupationWiseStatistics->join('institutes', 'occupation_wise_statistics.institute_id', '=', 'institutes.id');
        $occupationWiseStatistics->join('occupations', 'occupation_wise_statistics.occupation_id', '=', 'occupations.id');


        return DataTables::eloquent($occupationWiseStatistics)
            ->addColumn('action', DatatableHelper::getActionButtonBlock(static function (OccupationWiseStatistic $occupationWiseStatistic) use ($authUser) {
                $str = '';
                if ($authUser->can('view', $occupationWiseStatistic)) {
                    $str .= '<a href="' . route('admin.occupation-wise-statistics.show', $occupationWiseStatistic->id) . '" class="btn btn-outline-info btn-sm"> <i class="fas fa-eye"></i> Read </a>';
                }
                if ($authUser->can('update', $occupationWiseStatistic)) {
                    $str .= '<a href="' . route('admin.occupation-wise-statistics.edit', $occupationWiseStatistic->id) . '" class="btn btn-outline-warning btn-sm"> <i class="fas fa-edit"></i> Edit </a>';
                }
                if ($authUser->can('delete', $occupationWiseStatistic)) {
                    $str .= '<a href="#" data-action="' . route('admin.occupation-wise-statistics.destroy', $occupationWiseStatistic->id) . '" class="btn btn-outline-danger btn-sm delete"> <i class="fas fa-trash"></i> Delete</a>';
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
