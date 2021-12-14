<?php

namespace App\Http\Controllers\Frontend;

use App\Helpers\Classes\AuthHelper;
use App\Http\Controllers\BaseController;
use App\Models\Youth;
use App\Services\YouthProfileService;
use http\Env\Request;
use Illuminate\Contracts\View\View;
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

        return \view(self::VIEW_PATH. 'edit-personal-info', with(['trainee' => $authTrainee]));
    }

    /**
     * @param \Illuminate\Http\Request $request
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
}
