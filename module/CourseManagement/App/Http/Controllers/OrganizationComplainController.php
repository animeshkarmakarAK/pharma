<?php

namespace Module\CourseManagement\App\Http\Controllers;

use App\Helpers\Classes\AuthHelper;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Module\CourseManagement\App\Models\OrganizationComplainToYouth;
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
        return view(self::VIEW_PATH . 'organization-complains');
    }

    public function getOrganizationComplainList(Request $request): \Illuminate\Http\JsonResponse
    {
        return $this->organizationComplainService->getOrganizationComplainListsDatatable($request);
    }

    public function organizationComplainGetOne(int $id)
    {
        $authUser = AuthHelper::getAuthUser();
        $organizationComplainToYouth = OrganizationComplainToYouth::findOrFail($id);

        if (!empty($authUser->institute_id) && $authUser->institute_id != $organizationComplainToYouth->institute_id) {
            return redirect()->route('course_management::admin.youth-complains')->with([
                'message' => "Something is wrong",
                'alert-type' => "error"
            ]);
        }

        $organizationComplainToYouth->read_at = Carbon::now();
        $organizationComplainToYouth->save();

        return view(self::VIEW_PATH . 'organization-single-complain', compact('organizationComplainToYouth'));
    }
}
