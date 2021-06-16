<?php

namespace Module\GovtStakeholder\App\Http\Controllers;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Module\GovtStakeholder\App\Models\HumanResource;
use Module\GovtStakeholder\App\Models\HumanResourceTemplate;

class HumanResourceController extends BaseController
{
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
                Rule::in([1, 2, 0, 99]),
            ]
        ];

        return \Illuminate\Support\Facades\Validator::make($request->all(), $rules);

    }

    /**
     * add a new node in tree -- human resource
     *
     * @param Request $request
     * @return JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function addNode(Request $request): JsonResponse
    {
        $validatedData = $this->validator($request)->validate();
        try {
            $newNode = HumanResource::create($validatedData);
        } catch (\Throwable $exception) {
            return response()->json([
                'message' => __('generic.something_wrong_try_again'),
                'alertType' => 'error'
            ]);
        }

        $newNode["name"] = $newNode->title_en;
        $newNode["parent"] = $newNode->parent_id;

        return response()->json([
            'nodeData' => $newNode,
        ]);
    }

    /**
     * request is coming from employee-hierarchy edit operation
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function updateNode(Request $request, HumanResource $humanResource): JsonResponse
    {
        $validatedData = $this->validator($request)->validate();
        try {
            $humanResource->update($validatedData);
        } catch (\Throwable $exception) {
            return response()->json([
                'message' => __('generic.something_wrong_try_again'),
                'alertType' => 'error'
            ]);
        }


        $humanResource["name"] = $humanResource->title_en;
        $humanResource["parent"] = $humanResource->parent_id;

        return response()->json([
            'nodeData' => $humanResource,
        ]);
    }

    /**
     * delete a tree node -- human resource
     * @param HumanResource $humanResource
     * @return JsonResponse
     */
    public function deleteNode(HumanResource $humanResource): JsonResponse
    {
        $organizationUnit = $humanResource->organizationUnit;

        try {
            $humanResource->delete();
        } catch (\Throwable $exception) {
            return response()->json([
                'message' => __('generic.something_wrong_try_again'),
                'alertType' => 'error'
            ]);
        }

        return response()->json([
            'message' => __('Deleted node successfully!'),
            'alertType' => 'success',
        ]);
    }

    /**
     * @param Request $request
     * @param HumanResource $humanResource
     * @return JsonResponse
     */
    public function updateNodeOnDrag(Request $request, HumanResource $humanResource): JsonResponse
    {
        $validatedData = $request->validate([
            'parent_id' => [
                'int',
                'exists:human_resources,id'
            ]
        ]);

        try {
            $humanResource->update($validatedData);
        } catch (\Throwable $exception) {
            Log::error($exception->getMessage());
            return \response()->json("Update Failed");
        }

        return \response()->json("update successful");

    }
}
