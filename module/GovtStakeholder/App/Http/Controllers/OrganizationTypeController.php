<?php

namespace Module\GovtStakeholder\App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;
use Module\GovtStakeholder\App\Models\OrganizationType;
use Module\GovtStakeholder\App\Services\OrganizationTypeService;


class OrganizationTypeController extends BaseController
{
    const VIEW_PATH = 'govt_stakeholder::backend.organization-types.';

    protected OrganizationTypeService $organizationTypeService;

    public function __construct(OrganizationTypeService $organizationTypeService)
    {
        $this->organizationTypeService = $organizationTypeService;
        $this->authorizeResource(OrganizationType::class);
    }

    public function index(): View
    {
        return \view(self::VIEW_PATH . 'browse');
    }

    public function create(): View
    {
        $organizationType = new OrganizationType();
        return \view(self::VIEW_PATH . 'edit-add', compact('organizationType'));
    }

    public function store(Request $request): RedirectResponse
    {
        $organizationTypeValidatedData = $this->organizationTypeService->validator($request)->validate();

        try {
            $this->organizationTypeService->createOrganizationType($organizationTypeValidatedData);
        } catch (\Throwable $exception) {
            Log::debug($exception->getMessage());
            return back()->with([
                'message' => __('generic.something_wrong_try_again'),
                'alert-type' => 'error'
            ]);
        }

        return back()->with([
            'message' => __('generic.object_created_successfully', ['object' => 'OrganizationType']),
            'alert-type' => 'success'
        ]);
    }

    public function edit(Request $request, OrganizationType $organizationType): View
    {
        return \view(self::VIEW_PATH . 'edit-add', compact('organizationType'));
    }

    public function show(OrganizationType $organizationType): View
    {
        return \view(self::VIEW_PATH . 'read', compact('organizationType'));
    }


    public function update(Request $request, OrganizationType $organizationType): RedirectResponse
    {
        $validatedData = $this->organizationTypeService->validator($request, $organizationType->id)->validate();
        try {
            $this->organizationTypeService->updateOrganizationType($organizationType, $validatedData);
        } catch (\Throwable $exception) {
            Log::debug($exception->getMessage());
            return back()->with([
                'message' => __('generic.something_wrong_try_again'),
                'alert-type' => 'error'
            ]);
        }

        return back()->with([
            'message' => __('generic.object_updated_successfully', ['object' => 'OrganizationType']),
            'alert-type' => 'success'
        ]);
    }


    public function destroy(OrganizationType $organizationType): RedirectResponse
    {
        try {
            $organizationType->delete();
        } catch (\Throwable $exception) {
            Log::debug($exception->getMessage());
            return back()->with([
                'message' => __('generic.something_wrong_try_again'),
                'alert-type' => 'error'
            ]);
        }

        return back()->with([
            'message' => __('generic.object_deleted_successfully', ['object' => 'organizationType']),
            'alert-type' => 'success'
        ]);
    }


    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function getDatatable(Request $request): JsonResponse
    {
        return $this->organizationTypeService->getListDataForDatatable($request);
    }


}
