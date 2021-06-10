<?php

namespace Module\GovtStakeholder\App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Module\GovtStakeholder\App\Models\HumanResourceTemplate;
use Module\GovtStakeholder\App\Models\OrganizationUnitType;
use Module\GovtStakeholder\App\Services\HumanResourceTemplateService;
use SebastianBergmann\Diff\Exception;

class HumanResourceTemplateController extends BaseController
{
    const VIEW_PATH = "govt_stakeholder::backend.human-resource-templates.";

    protected HumanResourceTemplateService $humanResourceTemplateService;

    public function __construct(HumanResourceTemplateService $humanResourceTemplateService)
    {
        $this->humanResourceTemplateService = $humanResourceTemplateService;
        $this->authorizeResource(HumanResourceTemplate::class);
    }

    /**
     * @return View
     */
    public function index(): View
    {
        return \view(self::VIEW_PATH . 'browse');
    }

    /**
     * show the form for creating a new human resource template
     * @return View
     */
    public function create(): View
    {
        $humanResourceTemplate = new HumanResourceTemplate();
        return \view(self::VIEW_PATH . 'edit-add', compact('humanResourceTemplate'));
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
        $validatedData = $this->humanResourceTemplateService->validator($request)->validate();

        try {
            $this->humanResourceTemplateService->createHumanResourceTemplate($validatedData);
        } catch (\Throwable $exception) {
            Log::debug($exception->getMessage());
            return back()->with([
                'message' => __('generic.something_wrong_try_again'),
                'alert-type' => 'error'
            ]);
        }

        return back()->with([
            'message' => __('generic.object_created_successfully', ['object' => 'Human Resource Template']),
            'alert-type' => 'success'
        ]);
    }

    /**
     * @param HumanResourceTemplate $humanResourceTemplate
     * @return View
     */
    public function edit(HumanResourceTemplate $humanResourceTemplate): View
    {
        return \view(self::VIEW_PATH . 'edit-add', compact('humanResourceTemplate'));
    }

    /**
     * @param HumanResourceTemplate $humanResourceTemplate
     * @return View
     */
    public function show(HumanResourceTemplate $humanResourceTemplate): View
    {
        return \view(self::VIEW_PATH . 'read', compact('humanResourceTemplate'));
    }

    /**
     * @param Request $request
     * @param HumanResourceTemplate $humanResourceTemplate
     * @return RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, HumanResourceTemplate $humanResourceTemplate): RedirectResponse
    {
        $validatedData = $this->humanResourceTemplateService->validator($request)->validate();

        try {
            $this->humanResourceTemplateService->updateHumanResourceTemplate($humanResourceTemplate, $validatedData);
        } catch (\Throwable $exception) {
            Log::debug($exception->getMessage());
            return back()->with([
                'message' => __('generic.something_wrong_try_again'),
                'alert-type' => 'error'
            ]);
        }

        return back()->with([
            'message' => __('generic.object_updated_successfully', ['object' => 'Human Resource Template']),
            'alert-type' => 'success'
        ]);
    }


    public function destroy(HumanResourceTemplate $humanResourceTemplate): RedirectResponse
    {
        try {
            $humanResourceTemplate->delete();
        } catch (\Throwable $exception) {
            Log::debug($exception->getMessage());
            return back()->with([
                'message' => __('generic.something_wrong_try_again'),
                'alert-type' => 'error'
            ]);
        }

        return back()->with([
            'message' => __('generic.object_deleted_successfully', ['object' => 'Human Resource Template']),
            'alert-type' => 'success'
        ]);
    }
    public function getDatatable(Request $request): JsonResponse
    {
        return $this->humanResourceTemplateService->getListDataForDatatable($request);
    }

    /**
     * request is coming from employee-hierarchy edit operation
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function updateNode(Request $request, HumanResourceTemplate $humanResourceTemplate): JsonResponse
    {
        $validatedData = $this->humanResourceTemplateService->validator($request)->validate();
        try {
            $this->humanResourceTemplateService->updateHumanResourceTemplate($humanResourceTemplate, $validatedData);
        }catch(\Throwable $exception) {
            return response()->json([
                'message' => __('generic.something_wrong_try_again'),
                'alertType' => 'error'
            ]);
        }

        $organizationUnitType = OrganizationUnitType::findOrFail($request->input('organization_unit_type_id'));
        $employeeHierarchy = $organizationUnitType->getHierarchy();

        $newNode = $humanResourceTemplate;
        $newNode["name"] = $newNode->title_en;
        $newNode["parent"] = $newNode->parent_id;

        return response()->json([
            'nodeData' => $newNode,
        ]);
    }

    /**
     * request of add a new node in hierarchy tree
     *
     * @param Request $request
     * @return JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function addNode(Request $request): JsonResponse
    {
        $validatedData = $this->humanResourceTemplateService->validator($request)->validate();
        try {
            $newNode = $this->humanResourceTemplateService->createHumanResourceTemplate($validatedData);
        }catch(\Throwable $exception) {
            return response()->json([
                'message' => __('generic.something_wrong_try_again'),
                'alertType' => 'error'
            ]);
        }

        $organizationUnitType = OrganizationUnitType::findOrFail($request->input('organization_unit_type_id'));
        $employeeHierarchy = $organizationUnitType->getHierarchy();


        $newNode["name"] = $newNode->title_en;
        $newNode["parent"] = $newNode->parent_id;

        return response()->json([
            'nodeData' => $newNode,
        ]);
    }

    public function deleteNode(HumanResourceTemplate $humanResourceTemplate): JsonResponse
    {
        $organizationUnitType = $humanResourceTemplate->organizationUnitType;

        try {
            $humanResourceTemplate->delete();
        }catch(\Throwable $exception) {
            return response()->json([
                'message' => __('generic.something_wrong_try_again'),
                'alertType' => 'error'
            ]);
        }

        $employeeHierarchy = $organizationUnitType->getHierarchy();

        return response()->json([
            'message' => __('Deleted node successfully!'),
            'alertType' => 'success',
            'treeData' => $employeeHierarchy,
        ]);
    }

    public function updateNodeOnDrag(Request  $request, HumanResourceTemplate $humanResourceTemplate): JsonResponse
    {
        $validatedData = $request->validate([
            'parent_id' => [
                'int',
                'exists:human_resource_templates,id'
            ]
        ]);

        try {
            $humanResourceTemplate->update($validatedData);
        }catch (Exception $exception) {
            return \response()->json("Update Failed");
        }

        return \response()->json("update successful");

    }
}
