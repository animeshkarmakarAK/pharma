<?php

namespace Module\CourseManagement\App\Http\Controllers;

use App\Helpers\Classes\AuthHelper;
use Illuminate\Http\Request;
use Module\CourseManagement\App\Services\OrganizationComplainService;
use Module\CourseManagement\App\Services\YouthComplainService;

class OrganizationComplainController extends Controller
{

    const VIEW_PATH = 'course_management::backend.complains-list.';
    protected OrganizationComplainService $organizationComplainService;

    public function __construct(OrganizationComplainService $organizationComplainService)
    {
        $this->organizationComplainService = $organizationComplainService;
    }

    public function organizationComplainIndex()
    {
        $authUser = AuthHelper::getAuthUser();
        return view(self::VIEW_PATH.'organization-complains');
    }
    public function getOrganizationComplainList(Request $request): \Illuminate\Http\JsonResponse
    {
        return $this->organizationComplainService->getOrganizationComplainListsDatatable($request);
    }
}
