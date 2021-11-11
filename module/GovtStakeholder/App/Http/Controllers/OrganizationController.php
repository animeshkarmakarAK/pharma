<?php

namespace Module\GovtStakeholder\App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Module\GovtStakeholder\App\Models\Organization;
use Module\GovtStakeholder\App\Services\OrganizationService;

/**
 * Class OrganizationController
 * @package App\Http\Controllers
 *
 */
class OrganizationController extends BaseController
{
    const VIEW_PATH = 'govt_stakeholder::backend.organizations.';

    protected OrganizationService $organizationService;

    public function __construct(OrganizationService $organizationService)
    {
        $this->organizationService = $organizationService;
        $this->authorizeResource(Organization::class);
    }

    public function index(): View
    {
        return \view(self::VIEW_PATH . 'browse');
    }

    public function create(): View
    {
        $organization = new Organization();
        return \view(self::VIEW_PATH . 'edit-add', compact('organization'));
    }

    public function store(Request $request): RedirectResponse
    {
        $organizationValidatedData = $this->organizationService->validator($request)->validate();

        try {
            $this->organizationService->createOrganization($organizationValidatedData);
        } catch (\Throwable $exception) {
            Log::debug($exception->getMessage());
            return back()->with([
                'message' => __('generic.something_wrong_try_again'),
                'alert-type' => 'error'
            ]);
        }

        return back()->with([
            'message' => __('generic.object_created_successfully', ['object' => 'Organization']),
            'alert-type' => 'success'
        ]);
    }

    public function edit(Request $request, Organization $organization): View
    {
        return \view(self::VIEW_PATH . 'edit-add', compact('organization'));
    }

    public function show(Organization $organization): View
    {
        return \view(self::VIEW_PATH . 'read', compact('organization'));
    }


    public function update(Request $request, Organization $organization): RedirectResponse
    {

        $validatedData = $this->organizationService->validator($request, $organization->id)->validate();
        try {
            $this->organizationService->updateOrganization($organization, $validatedData);
        } catch (\Throwable $exception) {
            Log::debug($exception->getMessage());
            return back()->with([
                'message' => __('generic.something_wrong_try_again'),
                'alert-type' => 'error'
            ]);
        }

        return back()->with([
            'message' => __('generic.object_updated_successfully', ['object' => 'Organization']),
            'alert-type' => 'success'
        ]);
    }


    public function destroy(Organization $organization): RedirectResponse
    {
        try {
            $this->organizationService->deleteOrganization($organization);
        } catch (\Throwable $exception) {
            Log::debug($exception->getMessage());
            return back()->with([
                'message' => __('generic.something_wrong_try_again'),
                'alert-type' => 'error'
            ]);
        }
        return back()->with([
            'message' => __('generic.object_deleted_successfully', ['object' => 'organization']),
            'alert-type' => 'success'
        ]);
    }


    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function getDatatable(Request $request): JsonResponse
    {
        return $this->organizationService->getListDataForDatatable($request);
    }

}
