<?php

namespace Module\CourseManagement\App\Http\Controllers;

use Illuminate\Validation\ValidationException;
use Module\CourseManagement\App\Models\Batch;
use Module\CourseManagement\App\Models\Examination;
use Module\CourseManagement\App\Services\ExaminationService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ExaminationController extends Controller
{
    const VIEW_PATH = 'course_management::backend.examinations.';
    public ExaminationService $examinationService;

    public function __construct(ExaminationService $examinationService)
    {
        $this->examinationService = $examinationService;
        $this->authorizeResource(Examination::class);
    }

    /**
     * @return View
     */
    public function index(): View
    {
        return \view(self::VIEW_PATH . 'browse');
    }

    /**
     * @return View
     */
    public function create(): View
    {
        $examination = new Batch();
        return view(self::VIEW_PATH . 'edit-add', compact('examination'));
    }


    public function store(Request $request): RedirectResponse
    {
        $validatedData = $this->examinationService->validator($request)->validate();

        try {
            $this->examinationService->createExamination($validatedData);
        } catch (\Throwable $exception) {
            Log::debug($exception->getMessage());
            return back()->with([
                'message' => __('generic.something_wrong_try_again'),
                'alert-type' => 'error'
            ]);
        }

        return redirect()->route('course_management::admin.examinations.index')->with([
            'message' => __('generic.object_created_successfully', ['object' => 'Examination']),
            'alert-type' => 'success'
        ]);
    }

    /**
     * @param Examination $examination
     * @return View
     */
    public function show(Examination $examination): View
    {
        return view(self::VIEW_PATH . 'read', compact('examination'));
    }

    /**
     * @param Examination $examination
     * @return View
     */
    public function edit(Examination $examination): View
    {
        return view(self::VIEW_PATH . 'edit-add', compact('examination'));
    }

    /**
     * @param Request $request
     * @param int $id
     * @return RedirectResponse
     * @throws ValidationException
     */
    public function update(Request $request, Examination $examination): RedirectResponse
    {
        $validatedData = $this->examinationService->validator($request)->validate();

        try {
            $this->examinationService->updateExamination($examination, $validatedData);
        } catch (\Throwable $exception) {
            Log::debug($exception->getMessage());
            return back()->with([
                'message' => __('generic.something_wrong_try_again'),
                'alert-type' => 'error'
            ]);
        }

        return redirect()->route('course_management::admin.examinations.index')->with([
            'message' => __('generic.object_updated_successfully', ['object' => 'Examination']),
            'alert-type' => 'success'
        ]);
    }

    /**
     * @param Examination $examination
     * @return RedirectResponse
     */
    public function destroy(Examination $examination): RedirectResponse
    {
        try {
            $this->examinationService->deleteExamination($examination);
        } catch (\Throwable $exception) {
            Log::debug($exception->getMessage());
            return back()->with([
                'message' => __('generic.something_wrong_try_again'),
                'alert-type' => 'error'
            ]);
        }

        return back()->with([
            'message' => __('generic.object_deleted_successfully', ['object' => 'Examination']),
            'alert-type' => 'success'
        ]);
    }


    public function getDatatable(Request $request): JsonResponse
    {
        return $this->examinationService->getExaminationLists($request);
    }
}
