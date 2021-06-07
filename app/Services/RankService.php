<?php

namespace App\Services;

use App\Helpers\Classes\AuthHelper;
use App\Helpers\Classes\DatatableHelper;
use App\Models\Rank;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class RankService
{
    public function createRank(array $data): Rank
    {
        if (empty($data['order'])) {
            unset($data['order']);
        }
        return Rank::create($data);
    }

    public function updateRank(Rank $rank, array $data): Rank
    {
        $rank->fill($data);
        $rank->save();

        return $rank;
    }

    public function deleteRank(Rank $rank): void
    {
        $rank->delete();
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
            'rank_type_id' => [
                'required',
                'int',
                'exists:rank_types,id',
            ],
            'grade' => [
                'nullable',
                'string',
                'max:100',
            ],
            'order' => [
                'nullable',
                'int',
            ],
            'organization_id' => [
                'nullable',
                'int',
                'exists:organizations,id',
            ],
        ];
        return \Illuminate\Support\Facades\Validator::make($request->all(), $rules);
    }

    public function getRankLists(Request $request): JsonResponse
    {
        $authUser = AuthHelper::getAuthUser();
        /** @var Builder|Rank $ranks */
        $ranks = Rank::select(
            [
                'ranks.id',
                'ranks.title_en',
                'ranks.title_bn',
                'ranks.grade',
                'ranks.order',
                'organizations.title_en as organization_title_en',
                'rank_types.title_en as rank_type_title_en',
                'ranks.row_status',
                'ranks.created_at',
                'ranks.updated_at',
            ]
        );
        $ranks->leftJoin('organizations', 'ranks.organization_id', '=', 'organizations.id');
        $ranks->join('rank_types', 'ranks.rank_type_id', '=', 'rank_types.id');

        return DataTables::eloquent($ranks)
            ->addColumn('action', DatatableHelper::getActionButtonBlock(static function (Rank $rank) use ($authUser) {
                $str = '';
                if ($authUser->can('view', $rank)) {
                    $str .= '<a href="' . route('admin.ranks.show', $rank->id) . '" class="btn btn-outline-info btn-sm"> <i class="fas fa-eye"></i> Read </a>';
                }
                if ($authUser->can('update', $rank)) {
                    $str .= '<a href="' . route('admin.ranks.edit', $rank->id) . '" class="btn btn-outline-warning btn-sm"> <i class="fas fa-edit"></i> Edit </a>';
                }
                if ($authUser->can('delete', $rank)) {
                    $str .= '<a href="#" data-action="' . route('admin.ranks.destroy', $rank->id) . '" class="btn btn-outline-danger btn-sm delete"> <i class="fas fa-trash"></i> Delete</a>';
                }

                return $str;
            }))
            ->rawColumns(['action'])
            ->toJson();
    }


}
