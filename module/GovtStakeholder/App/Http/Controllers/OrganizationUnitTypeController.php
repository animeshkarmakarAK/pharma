<?php

namespace Module\GovtStakeholder\App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Module\GovtStakeholder\App\Models\OrganizationUnitType;
use Module\GovtStakeholder\App\Services\OrganizationUnitTypeService;

class OrganizationUnitTypeController extends BaseController
{
    const VIEW_PATH = 'govt_stakeholder::backend.organization-unit-types.';
    protected OrganizationUnitTypeService $organizationUnitTypeService;

    public function __construct(OrganizationUnitTypeService $organizationUnitTypeService)
    {
        $this->organizationUnitTypeService = $organizationUnitTypeService;
        $this->authorizeResource(OrganizationUnitType::class);
    }

    /**
     *display a listing of resource
     *
     * @return View
     */
    public function index(): View
    {
        return \view(self::VIEW_PATH . 'browse');
    }

    /**
     * show the form for creating a new organization unit type
     * @return View
     */
    public function create(): View
    {
        $organizationUnitType = new OrganizationUnitType();
        return \view(self::VIEW_PATH . 'edit-add', compact('organizationUnitType'));
    }

    /**
     *  Store a newly created resource in storage.
     *
     * @param Request $request
     * @return RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $organizationUnitTypeValidatedData = $this->organizationUnitTypeService->validator($request)->validate();

        try {
            $this->organizationUnitTypeService->createOrganizationUnitType($organizationUnitTypeValidatedData);
        } catch (\Throwable $exception) {
            Log::debug($exception->getMessage());
            return back()->with([
                'message' => __('generic.something_wrong_try_again'),
                'alert-type' => 'error'
            ]);
        }

        return back()->with([
            'message' => __('generic.object_created_successfully', ['object' => 'Organization Unit Type']),
            'alert-type' => 'success'
        ]);
    }

    /**
     * show a form to update a resource
     *
     * @param OrganizationUnitType $organizationUnitType
     * @return View
     */
    public function edit(OrganizationUnitType $organizationUnitType): View
    {
        return \view(self::VIEW_PATH . 'edit-add', compact('organizationUnitType'));
    }

    /**
     * @param OrganizationUnitType $organizationUnitType
     * @return View
     */
    public function show(OrganizationUnitType $organizationUnitType): View
    {
        return \view(self::VIEW_PATH . 'read', compact('organizationUnitType'));
    }


    /**
     * store update value of organization unit type
     *
     * @param Request $request
     * @param OrganizationUnitType $organizationUnitType
     * @return RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, OrganizationUnitType $organizationUnitType): RedirectResponse
    {
        $validatedData = $this->organizationUnitTypeService->validator($request, $organizationUnitType->id)->validate();

        try {
            $this->organizationUnitTypeService->updateOrganizationUnitType($organizationUnitType, $validatedData);
        } catch (\Throwable $exception) {
            Log::debug($exception->getMessage());
            return back()->with([
                'message' => __('generic.something_wrong_try_again'),
                'alert-type' => 'error'
            ]);
        }

        return back()->with([
            'message' => __('generic.object_updated_successfully', ['object' => 'Organization Unit Type']),
            'alert-type' => 'success'
        ]);
    }


    /**
     * delete organization unit type
     *
     * @param OrganizationUnitType $organizationUnitType
     * @return RedirectResponse
     */
    public function destroy(OrganizationUnitType $organizationUnitType): RedirectResponse
    {
        try {
            $organizationUnitType->delete();
        } catch (\Throwable $exception) {
            Log::debug($exception->getMessage());
            return back()->with([
                'message' => __('generic.something_wrong_try_again'),
                'alert-type' => 'error'
            ]);
        }

        return back()->with([
            'message' => __('generic.object_deleted_successfully', ['object' => 'Organization Unit Type']),
            'alert-type' => 'success'
        ]);
    }


    /**
     * datatable list of all resource
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function getDatatable(Request $request): JsonResponse
    {
        return $this->organizationUnitTypeService->getListDataForDatatable($request);
    }

    /**
     * @param OrganizationUnitType $organizationUnitType
     * @return View
     */
    public function employeeHierarchy(OrganizationUnitType $organizationUnitType): View
    {
        $humanResources = optional($organizationUnitType->getHierarchy())->toArray();
        return \view(self::VIEW_PATH . 'employee-hierarchy', compact('humanResources', 'organizationUnitType'));
    }
}
