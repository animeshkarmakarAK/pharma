<?php

namespace Module\GovtStakeholder\App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Module\GovtStakeholder\App\Models\OrganizationUnit;
use Module\GovtStakeholder\App\Services\OrganizationUnitService;

class OrganizationUnitController extends BaseController
{
    const VIEW_PATH = 'backend.organization-units.';
    protected OrganizationUnitService $organizationUnitService;

    public function __construct(OrganizationUnitService $organizationUnitService)
    {
        $this->organizationUnitService = $organizationUnitService;
        $this->authorizeResource(OrganizationUnit::class);
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
        $organizationUnit = new OrganizationUnit();
        return \view(self::VIEW_PATH . 'edit-add', compact('organizationUnit'));
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
        $organizationUnitValidatedData = $this->organizationUnitService->validator($request)->validate();

        try {
            $this->organizationUnitService->createOrganizationUnit($organizationUnitValidatedData);
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
     * @param OrganizationUnit $organizationUnit
     * @return View
     */
    public function edit(OrganizationUnit $organizationUnit): View
    {
        return \view(self::VIEW_PATH . 'edit-add', compact('organizationUnit'));
    }

    /**
     * @param OrganizationUnit $organizationUnit
     * @return View
     */
    public function show(OrganizationUnit $organizationUnit): View
    {
        return \view(self::VIEW_PATH . 'read', compact('organizationUnit'));
    }


    /**
     * store update value of organization unit type
     *
     * @param Request $request
     * @param OrganizationUnit $organizationUnit
     * @return RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, OrganizationUnit $organizationUnit): RedirectResponse
    {
        $validatedData = $this->organizationUnitService->validator($request, $organizationUnit->id)->validate();

        try {
            $this->organizationUnitService->updateOrganizationUnit($organizationUnit, $validatedData);
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
     * @param OrganizationUnit $organizationUnit
     * @return RedirectResponse
     */
    public function destroy(OrganizationUnit $organizationUnit): RedirectResponse
    {
        try {
            $organizationUnit->delete();
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
        return $this->organizationUnitService->getListDataForDatatable();
    }
}
