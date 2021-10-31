<?php

namespace Module\CourseManagement\App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Module\CourseManagement\App\Models\Institute;
use Module\CourseManagement\App\Models\Youth;
use Module\CourseManagement\App\Services\YouthService;
use Module\CourseManagement\App\Services\YouthManagementService;

class YouthController extends Controller
{
    const VIEW_PATH = 'course_management::backend.youths.';
    protected YouthService $youthService;

    public function __construct(YouthService $youthService)
    {
        $this->youthService = $youthService;
    }

    public function youthAcceptList() {
        $institutes = Institute::acl()->active()->get();
        $batches = \Module\CourseManagement\App\Models\Batch::acl()->get();
        return \view(self::VIEW_PATH . 'youth-accept-list', compact('institutes', 'batches'));
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function getAcceptDatatable(Request $request): JsonResponse
    {
        return $this->youthService->getListForAcceptListDatatable($request);
    }

    public function youthAcceptNowAll(Request $request): \Illuminate\Http\RedirectResponse
    {
        $mobiles = $request->mobile;

        DB::beginTransaction();
        try {
            $validatedData = $this->youthService->validateAcceptNowAll($request)->validate();
            $this->youthService->addToTraineeAcceptedList($validatedData['youth_ids'],$mobiles);
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
            'message' => __('Youth has been accepted'),
            'alert-type' => 'success'
        ]);
    }

    public function youthRejectNowAll(Request $request): \Illuminate\Http\RedirectResponse
    {
        $mobiles = $request->mobile;

        DB::beginTransaction();
        try {
            $validatedData = $this->youthService->validateRejectNowAll($request)->validate();
            $this->youthService->rejectTraineeAll($validatedData['youth_ids']);
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
            'message' => __('Youth has been rejected'),
            'alert-type' => 'success'
        ]);
    }
}
