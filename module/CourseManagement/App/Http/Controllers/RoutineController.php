<?php

namespace Module\CourseManagement\App\Http\Controllers;

use App\Helpers\Classes\AuthHelper;
use App\Helpers\Classes\DatatableHelper;
use Illuminate\Validation\ValidationException;
use Module\CourseManagement\App\Models\Batch;
use Module\CourseManagement\App\Models\Routine;
use Module\CourseManagement\App\Models\RoutineClass;
use Module\CourseManagement\App\Models\TrainingCenter;
use Module\CourseManagement\App\Services\RoutineService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;

class RoutineController extends Controller
{
    const VIEW_PATH = 'course_management::backend.routines.';
    public RoutineService $routineService;

    public function __construct(RoutineService $routineService)
    {
        $this->routineService = $routineService;
        $this->authorizeResource(Routine::class);
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

        return view(self::VIEW_PATH . 'edit-add', compact('batches','trainingCenters'));
    }


    public function store(Request $request): RedirectResponse
    {
        $validatedData = $this->routineService->validator($request)->validate();
        $authUser = AuthHelper::getAuthUser();
        $validatedData['institute_id'] = $authUser->institute_id;
        $validatedData['created_by'] = $authUser->id;
        $this->routineService->createRoutine($validatedData);
        try {

        } catch (\Throwable $exception) {
            Log::debug($exception->getMessage());
            return back()->with([
                'message' => __('generic.something_wrong_try_again'),
                'alert-type' => 'error'
            ]);
        }

        return redirect()->route('course_management::admin.routines.index')->with([
            'message' => __('generic.object_created_successfully', ['object' => 'Routine']),
            'alert-type' => 'success'
        ]);
    }

    /**
     * @param Routine $routine
     * @return View
     */
    public function show(Routine $routine): View
    {
        $routineClasses = RoutineClass::where(['routine_id' => $routine->id])->get();
        return view(self::VIEW_PATH . 'read', compact('routine','routineClasses'));
    }

    /**
     * @param Routine $routine
     * @return View
     */
    public function edit(Routine $routine)
    {
        //return $routine;

       /* $batches = Batch::where(['row_status' => 1, 'institute_id'=>$authUser->institute_id])->pluck('title_en','id');
        $trainingCenters = TrainingCenter::where(['row_status' => 1, 'institute_id'=>$authUser->institute_id])->pluck('title_en','id');
        $routineTypes = RoutineType::where(['row_status' => 1, 'institute_id'=>$authUser->institute_id])->pluck('title','id');*/
        $authUser = AuthHelper::getAuthUser();

        return view(self::VIEW_PATH . 'edit-add', compact('routine'));
    }

    /**
     * @param Request $request
     * @param int $id
     * @return RedirectResponse
     * @throws ValidationException
     */
    public function update(Request $request, Routine $routine): RedirectResponse
    {
        $validatedData = $this->routineService->validator($request)->validate();
        $this->routineService->updateRoutine($routine, $request->all());

        try {

        } catch (\Throwable $exception) {
            Log::debug($exception->getMessage());
            return back()->with([
                'message' => __('generic.something_wrong_try_again'),
                'alert-type' => 'error'
            ]);
        }

        return redirect()->route('course_management::admin.routines.index')->with([
            'message' => __('generic.object_updated_successfully', ['object' => 'Routine']),
            'alert-type' => 'success'
        ]);
    }

    /**
     * @param Routine $routine
     * @return RedirectResponse
     */
    public function destroy(Routine $routine): RedirectResponse
    {
        try {
            $this->routineService->deleteRoutine($routine);
        } catch (\Throwable $exception) {
            Log::debug($exception->getMessage());
            return back()->with([
                'message' => __('generic.something_wrong_try_again'),
                'alert-type' => 'error'
            ]);
        }

        return back()->with([
            'message' => __('generic.object_deleted_successfully', ['object' => 'Routine']),
            'alert-type' => 'success'
        ]);
    }


    public function getDatatable(Request $request): JsonResponse
    {
        return $this->routineService->getRoutineLists($request);
    }
}
