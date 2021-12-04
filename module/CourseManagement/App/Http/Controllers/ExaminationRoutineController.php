<?php

namespace Module\CourseManagement\App\Http\Controllers;

use App\Helpers\Classes\AuthHelper;
use App\Helpers\Classes\DatatableHelper;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Validation\ValidationException;
use Module\CourseManagement\App\Models\ExaminationRoutine;
use Module\CourseManagement\App\Services\ExaminationRoutineService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;


class ExaminationRoutineController extends Controller
{
    const VIEW_PATH = 'course_management::backend.examination-routines.';
    public ExaminationRoutineService $examinationRoutineService;

    public function __construct(ExaminationRoutineService $examinationRoutineService)
    {
        $this->examinationRoutineService = $examinationRoutineService;
        $this->authorizeResource(ExaminationRoutine::class);
    }

    /**
     * @return View
     */
    public function index()
    {
        /*$examinationRoutines = ExaminationRoutine::select(
            [
                'examination_routines.id as id',
                'examination_routines.title',
                'examination_routines.created_at',
                'examination_routines.updated_at',
            ]
        );
        return DataTables::eloquent($examinationRoutines)->toJson();*/

        return \view(self::VIEW_PATH . 'browse');
    }

    /**
     * @return View
     */
    public function create(): View
    {
        $examinationRoutine = new ExaminationRoutine();
        return view(self::VIEW_PATH . 'edit-add', compact('examinationRoutine'));
    }


    public function store(Request $request): RedirectResponse
    {
        $validatedData = $this->examinationRoutineService->validator($request)->validate();
        $authUser = AuthHelper::getAuthUser();
        try {
            $validatedData['institute_id'] = $authUser->institute_id;
            $validatedData['created_by'] = $authUser->id;
            $this->examinationRoutineService->createExaminationRoutine($validatedData);
        } catch (\Throwable $exception) {
            Log::debug($exception->getMessage());
            return back()->with([
                'message' => __('generic.something_wrong_try_again'),
                'alert-routine' => 'error'
            ]);
        }

        return redirect()->route('course_management::admin.examination-routines.index')->with([
            'message' => __('generic.object_created_successfully', ['object' => 'ExaminationRoutine']),
            'alert-routine' => 'success'
        ]);
    }

    /**
     * @param ExaminationRoutine $examinationRoutine
     * @return View
     */
    public function show(ExaminationRoutine $examinationRoutine): View
    {
        //dd($examinationRoutine);
        return view(self::VIEW_PATH . 'read', compact('examinationRoutine'));
    }

    /**
     * @param ExaminationRoutine $examinationRoutine
     * @return View
     */
    public function edit(ExaminationRoutine $examinationRoutine): View
    {
        return view(self::VIEW_PATH . 'edit-add', compact('examinationRoutine'));
    }

    /**
     * @param Request $request
     * @param int $id
     * @return RedirectResponse
     * @throws ValidationException
     */
    public function update(Request $request, ExaminationRoutine $examinationRoutine): RedirectResponse
    {
        //dd($examinationRoutine);
        $validatedData = $this->examinationRoutineService->validator($request)->validate();

        try {
            $this->examinationRoutineService->updateExaminationRoutine($examinationRoutine, $validatedData);
        } catch (\Throwable $exception) {
            Log::debug($exception->getMessage());
            return back()->with([
                'message' => __('generic.something_wrong_try_again'),
                'alert-routine' => 'error'
            ]);
        }

        return redirect()->route('course_management::admin.examination-routines.index')->with([
            'message' => __('generic.object_updated_successfully', ['object' => 'ExaminationRoutine']),
            'alert-routine' => 'success'
        ]);
    }

    /**
     * @param ExaminationRoutine $examinationRoutine
     * @return RedirectResponse
     */
    public function destroy(ExaminationRoutine $examinationRoutine): RedirectResponse
    {
        try {
            $this->examinationRoutineService->deleteExaminationRoutine($examinationRoutine);
        } catch (\Throwable $exception) {
            Log::debug($exception->getMessage());
            return back()->with([
                'message' => __('generic.something_wrong_try_again'),
                'alert-routine' => 'error'
            ]);
        }

        return back()->with([
            'message' => __('generic.object_deleted_successfully', ['object' => 'ExaminationRoutine']),
            'alert-routine' => 'success'
        ]);
    }


    public function getDatatable(Request $request): JsonResponse
    {
        return $this->examinationRoutineService->getExaminationRoutineLists($request);
    }
}
