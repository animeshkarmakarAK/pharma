<?php

namespace Module\GovtStakeholder\App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Module\GovtStakeholder\App\Models\HumanResource;
use Module\GovtStakeholder\App\Services\HumanResourceService;

class HumanResourceController extends BaseController
{
    const VIEW_PATH = "govt_stakeholder::backend.human-resources.";
    protected HumanResourceService $humanResourceService;

    public function __construct(HumanResourceService $humanResourceService)
    {
        $this->humanResourceService = $humanResourceService;
        $this->authorizeResource(HumanResource::class);

    }

    /**
     * @return View
     */
    public function index(): View
    {
        return \view(self::VIEW_PATH . 'browse');
    }
    /**
     * show the form for creating a new human resource
     * @return View
     */
    public function create(): View
    {
        $humanResource = new HumanResource();
        return \view(self::VIEW_PATH . 'edit-add', compact('humanResource'));
    }

    /**
     * store a resource in storage
     *
     * @param Request $request
     * @return RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $validatedData = $this->humanResourceService->validator($request)->validate();

        try {
            $this->humanResourceService->createHumanResource($validatedData);
        } catch (\Throwable $exception) {
            Log::debug($exception->getMessage());
            return back()->withInput([
                'message' => __('generic.something_wrong_try_again'),
                'alert-type' => 'error'
            ]);
        }

        return back()->with([
            'message' => __('generic.object_created_successfully', ['object' => 'Human Resource']),
            'alert-type' => 'success'
        ]);
    }


    /**
     * @param HumanResource $humanResource
     * @return View
     */
    public function edit(HumanResource $humanResource): View
    {
        return \view(self::VIEW_PATH . 'edit-add', compact('humanResource'));
    }

    /**
     * @param HumanResource $humanResource
     * @return View
     */
    public function show(HumanResource $humanResource): View
    {
        return \view(self::VIEW_PATH . 'read', compact('humanResource'));
    }

    /**
     * @param Request $request
     * @param HumanResource $humanResource
     * @return RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, HumanResource $humanResource): RedirectResponse
    {
        $validatedData = $this->humanResourceService->validator($request)->validate();

        try {
            $this->humanResourceService->updateHumanResource($humanResource, $validatedData);
        } catch (\Throwable $exception) {
            Log::debug($exception->getMessage());
            return back()->with([
                'message' => __('generic.something_wrong_try_again'),
                'alert-type' => 'error'
            ]);
        }

        return back()->with([
            'message' => __('generic.object_updated_successfully', ['object' => 'Human Resource']),
            'alert-type' => 'success'
        ]);
    }


    public function destroy(HumanResource $humanResource): RedirectResponse
    {
        try {
            $humanResource->delete();
        } catch (\Throwable $exception) {
            Log::debug($exception->getMessage());
            return back()->with([
                'message' => __('generic.something_wrong_try_again'),
                'alert-type' => 'error'
            ]);
        }

        return back()->with([
            'message' => __('generic.object_deleted_successfully', ['object' => 'Human Resource']),
            'alert-type' => 'success'
        ]);
    }

    public function getDatatable(Request $request): JsonResponse
    {
        return $this->humanResourceService->getListDataForDatatable($request);
    }

    /**
     * add a new resource in tree -- human resource
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
