<?php

namespace Module\CourseManagement\App\Http\Controllers;

use App\Helpers\Classes\AuthHelper;
use Exception;
use Illuminate\Support\Facades\Response;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Module\CourseManagement\App\Models\Batch;
use Module\CourseManagement\App\Models\Institute;
use Module\CourseManagement\App\Models\Youth;
use Module\CourseManagement\App\Models\YouthAcademicQualification;
use Module\CourseManagement\App\Models\YouthFamilyMemberInfo;
use Module\CourseManagement\App\Models\YouthOrganization;
use Module\CourseManagement\App\Services\YouthService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Module\GovtStakeholder\App\Models\Organization;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class YouthManagementController extends Controller
{
    const VIEW_PATH = 'course_management::backend.youths.';
    protected YouthService $youthService;

    public function __construct(YouthService $youthService)
    {
        $this->youthService = $youthService;
    }

    public function index(): View
    {
        $institutes = Institute::acl()->active()->get();
        $organizations = Organization::acl()->get();

        return \view(self::VIEW_PATH . 'youth-list', compact('institutes', 'organizations'));
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function getDatatable(Request $request): JsonResponse
    {
        return $this->youthService->getListDataForDatatable($request);
    }

    public function addYouthToOrganization(Request $request): \Illuminate\Http\RedirectResponse
    {
        //$validatedData = $this->youthService->validateAddYouthToOrganization($request)->validate();

        $organization = Organization::findOrFail($request['organization_id']);

        DB::beginTransaction();
        try {
            $validatedData = $this->youthService->validateAddYouthToOrganization($request)->validate();
            $this->youthService->addYouthToOrganization($organization, $validatedData['youth_ids']);
            DB::commit();
        } catch (\Throwable $exception) {
            DB::rollBack();
            Log::debug($exception->getMessage());
            Log::debug($exception->getTraceAsString());
            return back()->with([
                'message' => __('generic.something_wrong_try_again'),
                'alert-type' => 'error'
            ]);
        }

        return back()->with([
            'message' => __('Youth added to batch'),
            'alert-type' => 'success'
        ]);
    }

    public function getYouthAssignedOrganizations(Request $request)
    {
        $organizations = Youth::where("id", $request->id)->first();
        return $organizations ? $organizations->youthOrganizations()->get() : [];
    }

}
