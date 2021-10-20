<?php

namespace Module\GovtStakeholder\App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Module\CourseManagement\App\Models\YouthOrganization;
use Module\GovtStakeholder\App\Services\OrganizationYouthService;

class OrganizationYouthController extends BaseController
{
    const VIEW_PATH = 'govt_stakeholder::backend.organization-youths.';
    public OrganizationYouthService $organizationYouthService;

    public function __construct(OrganizationYouthService $organizationYouthService)
    {
        $this->organizationYouthService = $organizationYouthService;
        $this->authorizeResource(YouthOrganization::class);
    }

    /**
     * @return View
     */
    public function index(): View
    {
        return \view(self::VIEW_PATH . 'youth-list');
    }


    public function getDatatable(Request $request): JsonResponse
    {
        return $this->organizationYouthService->getOrganizationYouthLists($request);
    }

}
