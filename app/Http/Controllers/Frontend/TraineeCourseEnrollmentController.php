<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\BaseController;
use App\Services\TraineeCourseEnrollmentService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class TraineeCourseEnrollmentController extends BaseController
{
    const VIEW_PATH = "frontend.";
    protected TraineeCourseEnrollmentService $traineeCourseEnrollmentService;

    public function __construct(TraineeCourseEnrollmentService $traineeCourseEnrollmentService)
    {
        $this->traineeCourseEnrollmentService = $traineeCourseEnrollmentService;
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws ValidationException
     */
    public function courseEnroll(Request $request): JsonResponse
    {
        $validatedData = $this->traineeCourseEnrollmentService->validator($request)->validate();

        DB::beginTransaction();

        try {
            $this->traineeCourseEnrollmentService->saveCourseEnrollData($validatedData);
            DB::commit();
        } catch (\Throwable $exception) {
            DB::rollBack();
            Log::debug($exception->getMessage());

            return response()->json([
                'message' => __('generic.something_wrong_try_again'),
                'alert-type' => 'error'
            ]);
        }

        return response()->json([
            'message' => __('generic.object_created_successfully', ['object' => 'User']),
            'alert-type' => 'success'
        ]);
    }
}
