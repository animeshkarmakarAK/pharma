<?php

namespace Module\CourseManagement\App\Http\Controllers;

use Module\CourseManagement\App\Models\Batch;
use Module\CourseManagement\App\Models\Institute;
use Module\CourseManagement\App\Models\YouthCourseEnroll;
use Module\CourseManagement\App\Models\YouthBatch;
use Module\CourseManagement\App\Services\YouthManagementService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class YouthRegistrationManagementController extends Controller
{
    const VIEW_PATH = 'course_management::backend.youth-registrations.';
    protected YouthManagementService $youthManagementService;

    public function __construct(YouthManagementService $youthManagementService)
    {
        $this->youthManagementService = $youthManagementService;
    }

    public function index(): View
    {
        $institutes = Institute::acl()->active()->get();
        $batches = \Module\CourseManagement\App\Models\Batch::acl()->get();
        return \view(self::VIEW_PATH . 'applications-for-registration', compact('institutes', 'batches'));
    }



    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function getDatatable(Request $request): JsonResponse
    {
        return $this->youthManagementService->getListDataForDatatable($request);
    }

    public function addYouthToBatch(Request $request): \Illuminate\Http\RedirectResponse
    {
        $validatedData = $this->youthManagementService->validateAddYouthToBatch($request)->validate();

        $batch = Batch::findOrFail($validatedData['batch_id']);

        DB::beginTransaction();
        try {
            $this->youthManagementService->addYouthToBatch($batch, $validatedData['youth_enroll_ids']);
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

    public function addSingleYouthToBatch(Request $request , $youthId): \Illuminate\Http\RedirectResponse
    {
        $youthCourseEnroll = YouthCourseEnroll::findOrFail($youthId);
        DB::beginTransaction();
        try {
            YouthBatch::updateOrCreate(
                [
                    'batch_id' => $request->single_batch_id,
                    'youth_course_enroll_id' => $youthCourseEnroll->id
                ],
                [
                    'enrollment_date' => now(),
                    'enrollment_status' => YouthBatch::ENROLLMENT_STATUS_ENROLLED
                ]
            );
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
            'message' => __('Youth has been added to batch'),
            'alert-type' => 'success'
        ]);
    }
}
