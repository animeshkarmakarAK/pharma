<?php

namespace Module\GovtStakeholder\App\Services;


use App\Helpers\Classes\AuthHelper;
use App\Helpers\Classes\DatatableHelper;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Module\GovtStakeholder\App\Models\HumanResourceTemplate;
use Yajra\DataTables\Facades\DataTables;


class HumanResourceTemplateService
{
    public function createHumanResourceTemplate(array $data): HumanResourceTemplate
    {
        return HumanResourceTemplate::create($data);
    }

    public function validator(Request $request): Validator
    {
        $rules = [
            'title_en' => [
                'required',
                'string',
                'max: 191'
            ],
            'title_bn' => [
                'required',
                'string',
                'max: 191'
            ],
            'organization_id' => [
                'required',
                'int',
                'exists:organizations,id'
            ],
            'organization_unit_type_id' => [
                'required',
                'int',
                'exists:organization_unit_types,id'
            ],
            'parent_id' => [
                'nullable',
                'int',
                'exists:human_resource_templates,id'
            ],
            'rank_id' => [
                'nullable',
                'int',
                'exists:ranks,id'
            ],
            'display_order' => [
                'required',
                'int',
                'min:0',
            ],
            'is_designation' => [
                'required',
                'int',
            ],
            'skill_id' => [
                'nullable',
                'array'
            ],
            'skill_id.*' => [
                'nullable',
                'int',
                'distinct'
            ]
        ];

        return \Illuminate\Support\Facades\Validator::make($request->all(), $rules);

    }

    public function getListDataForDatatable(\Illuminate\Http\Request $request): JsonResponse
    {
        $authUser = AuthHelper::getAuthUser();
        /** @var Builder|HumanResourceTemplate $humanResourceTemplate */

        $humanResourceTemplate = HumanResourceTemplate::select([
            'human_resource_templates.id',
            'human_resource_templates.title_en',
            'human_resource_templates.title_bn',
            'human_resource_templates.display_order',
            'human_resource_templates.is_designation',
            'human_resource_templates.skill_ids as skills',
            'human_resource_templates.created_at',
            'human_resource_templates.updated_at',
            'human_resource_templates.title_en as parent',
            'organizations.title_en as organization_title',
            'organization_unit_types.title_en as organization_unit_type_title',
            'ranks.id as rank_title',
        ]);

        $humanResourceTemplate->join('organizations', 'human_resource_templates.organization_id', '=', 'organizations.id');
        $humanResourceTemplate->join('organization_unit_types', 'human_resource_templates.organization_unit_type_id', '=', 'organization_unit_types.id');
        $humanResourceTemplate->leftJoin('ranks', 'human_resource_templates.rank_id', '=', 'ranks.id');
        $humanResourceTemplate->leftJoin('human_resource_templates as t2', 'human_resource_templates.parent_id', '=', 't2.id');

        return DataTables::eloquent($humanResourceTemplate)
            ->addColumn('action', DatatableHelper::getActionButtonBlock(static function (HumanResourceTemplate $humanResourceTemplate) use ($authUser) {
                $str = '';
                if ($authUser->can('view', $humanResourceTemplate)) {
                    $str .= '<a href="' . route('govt_stakeholder::admin.human-resource-templates.show', $humanResourceTemplate->id) . '" class="btn btn-outline-info btn-sm"> <i class="fas fa-eye"></i> ' . __('generic.read_button_label') . ' </a>';
                }

                if ($authUser->can('update', $humanResourceTemplate)) {
                    $str .= '<a href="' . route('govt_stakeholder::admin.human-resource-templates.edit', $humanResourceTemplate->id) . '" class="btn btn-outline-warning btn-sm"> <i class="fas fa-edit"></i> ' . __('generic.edit_button_label') . ' </a>';
                }
                if ($authUser->can('delete', $humanResourceTemplate)) {
                    $str .= '<a href="#" data-action="' . route('govt_stakeholder::admin.human-resource-templates.destroy', $humanResourceTemplate->id) . '" class="btn btn-outline-danger btn-sm delete"> <i class="fas fa-trash"></i> ' . __('generic.delete_button_label') . '</a>';
                }

                return $str;
            }))
            ->editColumn('is_designation', function (HumanResourceTemplate $humanResourceTemplate) {
                if ($humanResourceTemplate->is_designation) {
                    return 'Yes';
                } else {
                    return 'No';
                }
            })
            ->rawColumns(['action'])
            ->toJson();
    }

    public function updateHumanResourceTemplate(HumanResourceTemplate $humanResourceTemplate, array $data): bool
    {
        return $humanResourceTemplate->update($data);
    }
}

