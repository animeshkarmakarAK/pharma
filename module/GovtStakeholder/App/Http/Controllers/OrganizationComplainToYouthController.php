<?php

namespace Module\GovtStakeholder\App\Http\Controllers;

use App\Helpers\Classes\AuthHelper;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Module\CourseManagement\App\Models\OrganizationComplainToYouth;
use Module\CourseManagement\App\Models\Youth;
use Module\CourseManagement\App\Models\YouthOrganization;
use Module\GovtStakeholder\App\Services\OrganizationComplainToYouthService;

class OrganizationComplainToYouthController extends BaseController
{
    const VIEW_PATH = 'govt_stakeholder::backend.organization-complains.';
    public OrganizationComplainToYouthService $organizationComplainToYouthService;

    public function __construct(OrganizationComplainToYouthService $organizationComplainToYouthService)
    {
        $this->organizationComplainToYouthService = $organizationComplainToYouthService;
        $this->authorizeResource(OrganizationComplainToYouth::class);
    }

    public function organizationComplainForm($youthId)
    {
        $youth = Youth::findOrFail($youthId);
        $organizationId = AuthHelper::getAuthUser()->organization_id;
        $organization = YouthOrganization::where(['youth_id' => $youth->id, 'organization_id' => $organizationId])->first();

        if (!empty($organization)) {
            return \view(self::VIEW_PATH . 'organization-complain-form', compact('youth'));
        } else {
            return redirect()->back()->with([
                'message' => 'Something is wrong, Try again later.',
                'alert-type' => 'error'
            ]);
        }
    }

    /**
     * @throws ValidationException
     */
    public function organizationComplainToYouth(Request $request): RedirectResponse
    {
        $organizationTotalComplainedToYouth = OrganizationComplainToYouth::where(['youth_id' => $request->youth_id, 'organization_id' => $request->organization_id, 'institute_id' => $request->institute_id])->count();

        if ($organizationTotalComplainedToYouth >= OrganizationComplainToYouth::COMPLAIN_LIMITATION) {
            return back()->with([
                'message' => __('Your limit exceeded for complain'),
                'alert-type' => 'error'
            ]);
        }

        $validateData = $this->organizationComplainToYouthService->validateOrganizationComplainToYouth($request)->validate();

        try {
            $this->organizationComplainToYouthService->addOrganizationComplainToYouth($validateData);
        } catch (\Throwable $exception) {
            Log::debug($exception->getMessage());
            return back()->with([
                'message' => __('generic.something_wrong_try_again'),
                'alert-type' => 'error'
            ]);
        }

        return redirect()->route('govt_stakeholder::admin.organization-youths')->with([
            'message' => __('Your complain successfully submitted to Institute'),
            'alert-type' => 'success'
        ]);
    }
}
