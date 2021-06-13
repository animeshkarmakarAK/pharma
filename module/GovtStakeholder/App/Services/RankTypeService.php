<?php

namespace Module\GovtStakeholder\App\Services;

use App\Helpers\Classes\AuthHelper;
use App\Helpers\Classes\DatatableHelper;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Module\GovtStakeholder\App\Models\RankType;
use Yajra\DataTables\Facades\DataTables;

class RankTypeService
{
    public function createRankType(array $data): RankType
    {
        return RankType::create($data);
    }

    public function updateRankType(RankType $rankType, array $data): RankType
    {
        $rankType->fill($data);
        $rankType->save();

        return $rankType;
    }

    public function deleteRankType(RankType $rankType): void
    {
        $rankType->delete();
    }

    public function validator(Request $request): Validator
    {
        $rules = [
            'title_en' => [
                'required',
                'string',
                'max:191',
            ],
            'title_bn' => [
                'required',
                'string',
                'max: 191',
            ],
            'organization_id' => [
                'nullable',
                'int',
                'exists:organizations,id',
            ],
            'description' => [
                'nullable',
                'string',
                'max:255',
            ],
        ];
        return \Illuminate\Support\Facades\Validator::make($request->all(), $rules);
    }

    public function getRankTypeLists(Request $request): JsonResponse
    {
        $authUser = AuthHelper::getAuthUser();
        /** @var Builder|RankType $rankTypes */
        $rankTypes = RankType::select(
            [
                'rank_types.id',
                'rank_types.title_en',
                'rank_types.title_bn',
                'organizations.title_en as organization_title_en',
                'rank_types.row_status',
                'rank_types.created_at',
                'rank_types.updated_at',
            ]
        );
        $rankTypes->leftJoin('organizations', 'rank_types.organization_id', '=', 'organizations.id');

        return DataTables::eloquent($rankTypes)
            ->addColumn('action', DatatableHelper::getActionButtonBlock(static function (RankType $rankType) use ($authUser) {
                $str = '';
                if ($authUser->can('view', $rankType)) {
                    $str .= '<a href="' . route('govt_stakeholder::admin.rank-types.show', $rankType->id) . '" class="btn btn-outline-info btn-sm"> <i class="fas fa-eye"></i> Read </a>';
                }
                if ($authUser->can('update', $rankType)) {
                    $str .= '<a href="' . route('govt_stakeholder::admin.rank-types.edit', $rankType->id) . '" class="btn btn-outline-warning btn-sm"> <i class="fas fa-edit"></i> Edit </a>';
                }
                if ($authUser->can('delete', $rankType)) {
                    $str .= '<a href="#" data-action="' . route('govt_stakeholder::admin.rank-types.destroy', $rankType->id) . '" class="btn btn-outline-danger btn-sm delete"> <i class="fas fa-trash"></i> Delete</a>';
                }

                return $str;
            }))
            ->rawColumns(['action'])
            ->toJson();
    }


}
