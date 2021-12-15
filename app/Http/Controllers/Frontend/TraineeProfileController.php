<?php

namespace App\Http\Controllers\Frontend;

use App\Helpers\Classes\AuthHelper;
use App\Http\Controllers\BaseController;
use App\Models\Trainee;
use App\Models\TraineeFamilyMemberInfo;
use App\Services\TraineeProfileService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;

class TraineeProfileController extends BaseController
{
    const VIEW_PATH = "frontend.trainee-profile.";

    protected TraineeProfileService $traineeProfileService;

    public function __construct(TraineeProfileService $traineeProfileService)
    {
        $this->traineeProfileService = $traineeProfileService;
    }

    public function editPersonalInfo(): View
    {
        $authTrainee = AuthHelper::getAuthUser('trainee');

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
        $validated = $this->traineeProfileService->validator($request, $id)->validate();

        try {
            $this->traineeProfileService->updatePersonalInfo($validated, $id);
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
        $trainee = Trainee::findOrFAil($id);
        $authTrainee = AuthHelper::getAuthUser('trainee');
        $academicQualifications = $trainee->traineeAcademicQualifications->keyBy('examination');

        return \view(self::VIEW_PATH . 'add-edit-education', with(['trainee' => $authTrainee, 'academicQualifications' => $academicQualifications]));
    }

    public function storeEducationInfo(\Illuminate\Http\Request $request): JsonResponse
    {
        $validated = $this->traineeProfileService->educationInfoValidator($request);

        try {
            $this->traineeProfileService->storeAcademicInfo($validated);
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
        $guardian = new TraineeFamilyMemberInfo();

        if ($id) {
            $guardian = TraineeFamilyMemberInfo::find($id);
        }

        return \view(self::VIEW_PATH . 'add-guardian-information', compact('guardian'));
    }


    public function storeGuardianInfo(\Illuminate\Http\Request $request): RedirectResponse
    {
        $validated = $this->traineeProfileService->guardianInfoValidator($request)->validate();

        try {
            $this->traineeProfileService->storeGuardian($validated);
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
        $validated = $this->traineeProfileService->guardianInfoValidator($request)->validate();

        try {
            $this->traineeProfileService->updateGuardian($validated, $id);
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
