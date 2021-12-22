<?php

namespace App\Http\Controllers;

use App\Helpers\Classes\AuthHelper;
use App\Models\Batch;
use App\Models\Examination;
use App\Models\ExaminationType;
use App\Models\TrainingCenter;
use App\Services\ExaminationService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class ExaminationController extends Controller
{
    const VIEW_PATH = 'backend.examinations.';
    public ExaminationService $examinationService;

    public function __construct(ExaminationService $examinationService)
    {
        $this->examinationService = $examinationService;
        $this->authorizeResource(Examination::class);
    }

    /**
     * @return View
     */
    public function index()
    {
        return \view(self::VIEW_PATH . 'browse');
    }

    /**
     * @return View
     */
    public function create(): View
    {
        $batches = Batch::acl()->active()->pluck('title', 'id');
        $trainingCenters = TrainingCenter::acl()->active()->pluck('title', 'id');
        $examinationTypes = ExaminationType::acl()->active()->pluck('title', 'id');

        return view(self::VIEW_PATH . 'edit-add', compact('batches', 'trainingCenters', 'examinationTypes'));
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

        return redirect()->route('admin.examinations.index')->with([
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
    public function edit(Examination $examination)
    {
        $examinationTypes = ExaminationType::acl()->active()->pluck('title', 'id');

        return view(self::VIEW_PATH . 'edit-add', compact('examination', 'examinationTypes'));
    }

    /**
     * @param Request $request
     * @param Examination $examination
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

        return redirect()->route('admin.examinations.index')->with([
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


    public function examinationStatus($id): RedirectResponse
    {
        $examination = Examination::find($id);
        if (!$examination) {
            return back()->with([
                'message' => __('generic.something_wrong_try_again'),
                'alert-type' => 'error'
            ]);
        }

        $status = $examination->status;

        if ($status == Examination::EXAMINATION_STATUS_NOT_PUBLISH) {
            $examination->status = Examination::EXAMINATION_STATUS_PUBLISH;
            $examination->save();
            return back()->with([
                'message' => __('generic.object_published_successfully', ['object' => 'Examination']),
                'alert-type' => 'success'
            ]);
        } else if ($status == Examination::EXAMINATION_STATUS_PUBLISH) {
            $examination->status = Examination::EXAMINATION_STATUS_COMPLETE;
            $examination->save();
            return back()->with([
                'message' => __('generic.object_completed_successfully', ['object' => 'Examination']),
                'alert-type' => 'success'
            ]);
        } else {
            $examination->status = Examination::EXAMINATION_STATUS_NOT_PUBLISH;
            $examination->save();

        }
        return back()->with([
            'message' => __('generic.object_not_published_yet', ['object' => 'Examination']),
            'alert-type' => 'success'
        ]);
    }


    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function examinationCodeCheck(Request $request): JsonResponse
    {
        $course = Examination::where(['code' => $request->code])->first();
        if ($course == null) {
            return response()->json(true);
        } else {
            return response()->json('Code already in use!');
        }
    }
}
