<?php

namespace App\Services;

use App\Helpers\Classes\AuthHelper;
use App\Helpers\Classes\DatatableHelper;
use App\Models\Skill;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class SkillService
{
    public function createSkill(array $data): Skill
    {
        return Skill::create($data);
    }

    public function updateSkill(Skill $skill, array $data): Skill
    {
        $skill->fill($data);
        $skill->save();

        return $skill;
    }

    public function deleteSkill(Skill $skill): void
    {
        $skill->delete();
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

    public function getSkillLists(Request $request): JsonResponse
    {
        $authUser = AuthHelper::getAuthUser();
        /** @var Builder|Skill $skilles */
        $skilles = Skill::select(
            [
                'skills.id as id',
                'skills.title_en',
                'skills.title_bn',
                'organizations.title_en as organization_title_en',
                'skills.row_status',
                'skills.created_at',
                'skills.updated_at',
            ]
        );
        $skilles->LeftJoin('organizations', 'skills.organization_id', '=', 'organizations.id');
        $skilles->acl();

        return DataTables::eloquent($skilles)
            ->addColumn('action', DatatableHelper::getActionButtonBlock(static function (Skill $skill) use ($authUser) {
                $str = '';
                if ($authUser->can('view', $skill)) {
                    $str .= '<a href="' . route('admin.skills.show', $skill->id) . '" class="btn btn-outline-info btn-sm"> <i class="fas fa-eye"></i> Read </a>';
                }
                if ($authUser->can('update', $skill)) {
                    $str .= '<a href="' . route('admin.skills.edit', $skill->id) . '" class="btn btn-outline-warning btn-sm"> <i class="fas fa-edit"></i> Edit </a>';
                }
                if ($authUser->can('delete', $skill)) {
                    $str .= '<a href="#" data-action="' . route('admin.skills.destroy', $skill->id) . '" class="btn btn-outline-danger btn-sm delete"> <i class="fas fa-trash"></i> Delete</a>';
                }

                return $str;
            }))
            ->rawColumns(['action'])
            ->toJson();
    }


}
