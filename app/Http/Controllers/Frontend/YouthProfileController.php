<?php

namespace App\Http\Controllers\Frontend;

use App\Helpers\Classes\AuthHelper;
use App\Http\Controllers\BaseController;
use App\Models\Youth;
use App\Models\YouthFamilyMemberInfo;
use App\Services\YouthProfileService;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;

class YouthProfileController extends BaseController
{
    const VIEW_PATH = "frontend.youth-profile.";

    protected YouthProfileService $youthProfileService;

    public function __construct(YouthProfileService $youthProfileService)
    {
        $this->youthProfileService = $youthProfileService;
    }

    public function editPersonalInfo(): View
    {
        $authTrainee = AuthHelper::getAuthUser('youth');

        return \view(self::VIEW_PATH . 'edit-personal-info', with(['trainee' => $authTrainee]));
    }


    /**
     * @param \Illuminate\Http\Request $request
     * @param $id
     * @return RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function updatePersonalInfo(\Illuminate\Http\Request $request, $id): RedirectResponse
    {
        $validated = $this->youthProfileService->validator($request, $id)->validate();

        try {
            $this->youthProfileService->updatePersonalInfo($validated, $id);
        } catch (\Throwable $exception) {
            Log::debug($exception->getMessage());

            return back()->with([
                'message' => __('generic.something_wrong_try_again'),
                'alertType' => 'error'
            ]);
        }

        return back()->with([
            'message' => __('personal information updated successfully!'),
            'alertType' => 'success',
        ]);
    }


    public function addEditEducation(int $id): View
    {
        $youth = Youth::findOrFAil($id);
        $authTrainee = AuthHelper::getAuthUser('youth');
        $academicQualifications = $youth->youthAcademicQualifications->keyBy('examination');

        return \view(self::VIEW_PATH . 'add-edit-education', with(['trainee' => $authTrainee, 'academicQualifications' => $academicQualifications]));
    }

    public function storeEducationInfo(\Illuminate\Http\Request $request): JsonResponse
    {
        $validated = $this->youthProfileService->educationInfoValidator($request);

        try {
            $this->youthProfileService->storeAcademicInfo($validated);
        } catch (\Throwable $exception) {
            Log::debug($exception->getMessage());

            return response()->json([
                'message' => __('generic.something_wrong_try_again'),
                'alertType' => 'error'
            ]);
        }

        return response()->json([
            'message' => __('education information stored successfully!'),
            'alertType' => 'success',
        ]);
    }

    public function editGuardianInfo(int $id = null): View
    {
        $guardian = new YouthFamilyMemberInfo();

        if ($id) {
            $guardian = YouthFamilyMemberInfo::find($id);
        }

        return \view(self::VIEW_PATH . 'add-guardian-information', compact('guardian'));
    }


    public function storeGuardianInfo(\Illuminate\Http\Request $request): RedirectResponse
    {
        $validated = $this->youthProfileService->guardianInfoValidator($request)->validate();

        try {
            $this->youthProfileService->storeGuardian($validated);
        } catch (\Throwable $exception) {
            Log::debug($exception->getMessage());

            return back()->with([
                'message' => __('generic.something_wrong_try_again'),
                'alertType' => 'error'
            ]);
        }

        return back()->with([
            'message' => __('guardian added successfully!'),
            'alertType' => 'success',
        ]);
    }

    public function updateGuardianInfo(\Illuminate\Http\Request $request, int $id): RedirectResponse
    {
        $validated = $this->youthProfileService->guardianInfoValidator($request)->validate();

        try {
            $this->youthProfileService->updateGuardian($validated, $id);
        } catch (\Throwable $exception) {
            Log::debug($exception->getMessage());

            return back()->with([
                'message' => __('generic.something_wrong_try_again'),
                'alertType' => 'error'
            ]);
        }

        return back()->with([
            'message' => __('guardian information updated successfully!'),
            'alertType' => 'success',
        ]);
    }



}
