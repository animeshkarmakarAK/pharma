<?php

namespace Module\GovtStakeholder\App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Module\GovtStakeholder\App\Models\Organization;
use Module\GovtStakeholder\App\Models\OrganizationInformation;
use Module\GovtStakeholder\App\Services\OrganizationInformationService;

/**
 * Class OrganizationInformationController
 * @package App\Http\Controllers
 *
 */
class OrganizationInformationController extends BaseController
{
    const VIEW_PATH = 'govt_stakeholder::backend.organizations.';

    protected OrganizationInformationService $organizationInformationService;

    public function __construct(OrganizationInformationService $organizationInformationService)
    {
        $this->organizationInformationService = $organizationInformationService;
        $this->authorizeResource(OrganizationInformation::class);
    }


    public function organizationInformation() {
        return \view(self::VIEW_PATH . 'organization-information');
    }


    /**
     * @param Request $request
     * @return JsonResponse
     */

    public function getOrganizationInformation(Request $request): JsonResponse
    {

    }

    public function organizationInformationCreate()
    {
        return \view(self::VIEW_PATH . 'orginfo-edit-add');
    }

    public function organizationInformationStore(Request $request): RedirectResponse

    {
        $organizationInfoValidatedData = $this->organizationInformationService->validator($request)->validate();
        $this->organizationInformationService->createOrganizationInformation($organizationInfoValidatedData);

        try {

        } catch (\Throwable $exception) {
            Log::debug($exception->getMessage());
            return back()->with([
                'message' => __('generic.something_wrong_try_again'),
                'alert-type' => 'error'
            ]);
        }

        return back()->with([
            'message' => __('generic.object_created_successfully', ['object' => 'OrganizationInformation']),
            'alert-type' => 'success'
        ]);
    }

}
