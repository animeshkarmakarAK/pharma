<?php

namespace Module\CourseManagement\App\Http\Controllers;

use Module\CourseManagement\App\Helpers\Classes\DatatableHelper;
use Module\CourseManagement\App\Models\Branch;
use Module\CourseManagement\App\Models\Institute;
use Module\CourseManagement\App\Models\TrainingCenter;
use Module\CourseManagement\App\Services\TrainingCenterService;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;

class TrainingCenterController extends Controller
{
    const VIEW_PATH = 'course_management::backend.training-centers.';
    public TrainingCenterService $trainingCenterService;

    public function __construct(TrainingCenterService $trainingCenterService)
    {
        $this->trainingCenterService = $trainingCenterService;
        $this->authorizeResource(TrainingCenter::class);
    }

    /**
     * @return View
     */
    public function index(): View
    {
        return view(self::VIEW_PATH . 'browse');
    }

    /**
     * @return View
     */
    public function create(): view
    {
        $institutes = Institute::active()->get();
        $branches = Branch::active()->get();

        $trainingCenter = new TrainingCenter();
        return view(self::VIEW_PATH . 'edit-add', compact('trainingCenter', 'institutes', 'branches'));

    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        $validatedData = $this->trainingCenterService->validator($request)->validate();
        try {
            $this->trainingCenterService->createTrainingCenter($validatedData);
        } catch (\Throwable $exception) {
            Log::debug($exception->getMessage());
            return back()->with([
                'message' => __('generic.something_wrong_try_again'),
                'alert-type' => 'error'
            ]);
        }
        return back()->with([
            'message' => __('generic.object_created_successfully', ['object' => 'Training center']),
            'alert-type' => 'success'
        ]);
    }

    /**
     * @param TrainingCenter $trainingCenter
     * @return View
     */
    public function show(TrainingCenter $trainingCenter): View
    {
        return view(self::VIEW_PATH . 'read', compact('trainingCenter'));
    }

    /**
     * @param TrainingCenter $trainingCenter
     * @return View
     */
    public function edit(TrainingCenter $trainingCenter): View
    {
        $institutes = Institute::active()->get();
        $branches = Branch::where(['institute_id' => $trainingCenter->institute_id])->get();
        //dd($branches);

        return view(self::VIEW_PATH . 'edit-add', compact('trainingCenter', 'institutes', 'branches'));
    }

    /**
     * @param Request $request
     * @param TrainingCenter $trainingCenter
     * @return RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     *
     */
    public function update(Request $request, TrainingCenter $trainingCenter)
    {
        $validateData = $this->trainingCenterService->validator($request, $trainingCenter->id)->validate();

        try {
            $this->trainingCenterService->updateTrainingCenter($trainingCenter, $validateData);
        } catch (\Throwable $exception) {
            Log::debug($exception->getMessage());
            return back()->with([
                'message' => __('generic.something_wrong_try_again'),
                'alert-type' => 'error'
            ]);
        }

        return back()->with([
            'message' => __('generic.object_updated_successfully', ['object' => 'Training center']),
            'alert-type' => 'success'
        ]);

    }

    /**
     * @param TrainingCenter $trainingCenter
     * @return RedirectResponse
     */
    public function destroy(TrainingCenter $trainingCenter): RedirectResponse
    {
        try {
            $this->trainingCenterService->deleteTrainingCenter($trainingCenter);
        } catch (\Throwable $exception) {
            Log::debug($exception->getMessage());
            return back()->with([
                'message' => __('generic.something_wrong_try_again'),
                'alert-type' => 'error'
            ]);
        }

        return back()->with([
            'message' => __('generic.object_deleted_successfully', ['object' => 'Training center']),
            'alert-type' => 'success'
        ]);
    }

    public function getDatatable(Request $request): JsonResponse
    {
        return $this->trainingCenterService->getListDataForDatatable($request);
    }
}

