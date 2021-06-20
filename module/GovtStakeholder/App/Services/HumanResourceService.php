<?php


namespace Module\GovtStakeholder\App\Services;


use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Module\GovtStakeholder\App\Models\HumanResource;

class HumanResourceService
{
    public function createHumanResource(array $data): HumanResource
    {
        return HumanResource::create($data);
    }

    public function updateHumanResource(HumanResource $humanResource, array $data): bool
    {
        return $humanResource::update($data);
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
            'organization_unit_id' => [
                'required',
                'int',
                'exists:organization_units,id'
            ],
            'parent_id' => [
                'nullable',
                'int',
                'exists:human_resources,id'
            ],
            'human_resource_template_id' => [
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
            ],
            'status' => [
                'nullable',
                'int',
                Rule::in([HumanResource::ROW_STATUS_ACTIVE, HumanResource::ROW_STATUS_INACTIVE, HumanResource::ROW_STATUS_DELETED]),
            ]
        ];

        return \Illuminate\Support\Facades\Validator::make($request->all(), $rules);

    }

}
