<?php

namespace Module\CourseManagement\App\Http\Controllers;

use App\Helpers\Classes\AuthHelper;
use App\Helpers\Classes\DatatableHelper;
use Illuminate\Validation\ValidationException;
use Module\CourseManagement\App\Models\Batch;
use Module\CourseManagement\App\Models\Examination;
use Module\CourseManagement\App\Models\ExaminationType;
use Module\CourseManagement\App\Models\TrainingCenter;
use Module\CourseManagement\App\Services\ExaminationService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;

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
    public function index()
    {
        return \view(self::VIEW_PATH . 'browse');
    }

    /**
     * @return View
     */
    public function create(): View
    {
        $authUser = AuthHelper::getAuthUser();
        $batches = Batch::where(['row_status' => 1, 'institute_id'=>$authUser->institute_id])->pluck('title_en','id');
        $trainingCenters = TrainingCenter::where(['row_status' => 1, 'institute_id'=>$authUser->institute_id])->pluck('title_en','id');
        $examinationTypes = ExaminationType::where(['row_status' => 1, 'institute_id'=>$authUser->institute_id])->pluck('title','id');

        return view(self::VIEW_PATH . 'edit-add', compact('batches','trainingCenters','examinationTypes'));
    }


    public function store(Request $request): RedirectResponse
    {
        $validatedData = $this->examinationService->validator($request)->validate();
        $authUser = AuthHelper::getAuthUser();
        try {
            $validatedData['institute_id'] = $authUser->institute_id;
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
    public function edit(Examination $examination)
    {
        //return $examination;

       /* $batches = Batch::where(['row_status' => 1, 'institute_id'=>$authUser->institute_id])->pluck('title_en','id');
        $trainingCenters = TrainingCenter::where(['row_status' => 1, 'institute_id'=>$authUser->institute_id])->pluck('title_en','id');
        $examinationTypes = ExaminationType::where(['row_status' => 1, 'institute_id'=>$authUser->institute_id])->pluck('title','id');*/
        $authUser = AuthHelper::getAuthUser();
        $examinationTypes = ExaminationType::where(['row_status' => 1, 'institute_id' => $authUser->institute_id])->pluck('title','id');
        return view(self::VIEW_PATH . 'edit-add', compact('examination','examinationTypes'));
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
