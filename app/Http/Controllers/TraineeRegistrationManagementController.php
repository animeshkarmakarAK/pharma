<?php

namespace App\Http\Controllers;

use App\Models\Batch;
use App\Models\Institute;
use App\Models\TraineeCourseEnroll;
use App\Models\TraineeBatch;
use App\Services\TraineeManagementService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TraineeRegistrationManagementController extends Controller
{
    const VIEW_PATH = 'backend.trainee-registrations.';
    protected TraineeManagementService $traineeManagementService;

    public function __construct(TraineeManagementService $traineeManagementService)
    {
        $this->traineeManagementService = $traineeManagementService;
    }

    public function index(): View
    {
        $institutes = Institute::acl()->active()->get();
        $batches = \App\Models\Batch::acl()->get();
        return \view(self::VIEW_PATH . 'applications-for-registration', compact('institutes', 'batches'));
    }


    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function getDatatable(Request $request): JsonResponse
    {
        return $this->traineeManagementService->getListDataForDatatable($request);
    }

    public function addTraineeToBatch(Request $request): \Illuminate\Http\RedirectResponse
    {
        $validatedData = $this->traineeManagementService->validateAddTraineeToBatch($request)->validate();

        $batch = Batch::findOrFail($validatedData['batch_id']);

        DB::beginTransaction();
        try {
            $this->traineeManagementService->addTraineeToBatch($batch, $validatedData['trainee_enroll_ids']);
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
            'message' => __('Trainee added to batch'),
            'alert-type' => 'success'
        ]);
    }

    public function addSingleTraineeToBatch(Request $request , $traineeId): \Illuminate\Http\RedirectResponse
    {
        $traineeCourseEnroll = TraineeCourseEnroll::findOrFail($traineeId);
        DB::beginTransaction();
        try {
            TraineeBatch::updateOrCreate(
                [
                    'batch_id' => $request->single_batch_id,
                    'trainee_course_enroll_id' => $traineeCourseEnroll->id
                ],
                [
                    'enrollment_date' => now(),
                    'enrollment_status' => TraineeBatch::ENROLLMENT_STATUS_ENROLLED
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
            'message' => __('Trainee has been added to batch'),
            'alert-type' => 'success'
        ]);
    }
}
