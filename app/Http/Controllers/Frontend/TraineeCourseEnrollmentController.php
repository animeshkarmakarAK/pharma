<?php

namespace App\Http\Controllers\Frontend;

use App\Helpers\Classes\AuthHelper;
use App\Http\Controllers\BaseController;
use App\Models\TraineeCourseEnroll;
use App\Services\TraineeCourseEnrollmentService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

        $authTrainee = AuthHelper::getAuthUser('trainee');
        $isAlreadyEnrolled = TraineeCourseEnroll::where('trainee_id', $authTrainee->id)
            ->where('course_id', $validatedData['course_id'])
            ->first();

        if ($isAlreadyEnrolled) {
            return response()->json([
                'message' => __('You have already enrolled this course'),
                'alertType' => 'info'
            ]);
        }

        DB::beginTransaction();

        try {
            $this->traineeCourseEnrollmentService->saveCourseEnrollData($validatedData);
            DB::commit();
        } catch (\Throwable $exception) {
            DB::rollBack();
            Log::debug($exception->getMessage());

            return response()->json([
                'message' => __('generic.something_wrong_try_again'),
                'alertType' => 'error'
            ]);
        }

        return response()->json([
            'message' => __('Course enrollment successful!'),
            'alertType' => 'success'
        ]);
    }
}
