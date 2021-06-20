<?php

namespace Module\GovtStakeholder\App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Module\GovtStakeholder\App\Models\HumanResource;
use Module\GovtStakeholder\App\Services\HumanResourceService;

class HumanResourceController extends BaseController
{
    protected HumanResourceService $humanResourceService;

    public function __construct(HumanResourceService $humanResourceService)
    {
        $this->humanResourceService = $humanResourceService;
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
        $validatedData = $this->humanResourceService->validator($request)->validate();
        try {
            $newNode = $this->humanResourceService->createHumanResource($validatedData);
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
        $validatedData = $this->humanResourceService->validator($request)->validate();
        try {
            $this->humanResourceService->updateHumanResource($humanResource, $request->all());
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
        $validatedData = $this->humanResourceService->validator($request)->validate();

        $validatedData = $request->validate([
            'parent_id' => [
                'int',
                'exists:human_resources,id'
            ]
        ]);

        try {
            $this->humanResourceService->updateHumanResource($humanResource, $validatedData);
        } catch (\Throwable $exception) {
            Log::error($exception->getMessage());
            return \response()->json("Update Failed");
        }

        return \response()->json("update successful");

    }
}
