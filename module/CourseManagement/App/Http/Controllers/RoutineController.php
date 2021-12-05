<?php

namespace Module\CourseManagement\App\Http\Controllers;

use App\Helpers\Classes\AuthHelper;
use App\Helpers\Classes\DatatableHelper;
use Illuminate\Validation\ValidationException;
use App\Models\User;
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

use Session;

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
        $trainers = User::where(['institute_id' => $authUser->institute_id, 'user_type_id' => 1 ])->get();

        return view(self::VIEW_PATH . 'edit-add', compact('batches','trainingCenters','trainers'));
    }


    public function store(Request $request): RedirectResponse
    {

        $validatedData = $this->routineService->validator($request)->validate();
        $authUser = AuthHelper::getAuthUser();
        try {
            $validatedData['institute_id'] = $authUser->institute_id;
            $validatedData['created_by'] = $authUser->id;
            $this->routineService->createRoutine($validatedData);

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
        $routineData = Routine::where(['id'=>$routine->id])->with('routineClass')->get();
        $authUser = AuthHelper::getAuthUser();
        $trainers = User::where(['institute_id' => $authUser->institute_id, 'user_type_id' => 1])->get();
        return view(self::VIEW_PATH . 'edit-add', compact('routine', 'trainers','routineData'));
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
        try {
            $this->routineService->updateRoutine($routine, $request->all());
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


    public function weeklyGetDatatable(Request $request): JsonResponse
    {

        return $this->routineService->getWeeklyRoutineLists($request);
    }

    /**
     * @param Routine $routine
     * @return View
     */
    public function weeklyRoutine(Routine $routine)
    {
        @$user_id = Session::get('user_id');
        @$batch_id = Session::get('batch_id');
        @$training_center_id= Session::get('training_center_id');
        $authUser = AuthHelper::getAuthUser();
        $parameters = [];
        $routines = [];
        if ($batch_id && $user_id){

            $user = User::where(['id' => $user_id])->first();
            $user_name = $user->name_en;

            $batch = Batch::where(['id' => $batch_id])->first();
            $batch_name = $batch->title_en;

            $trainingCenter = TrainingCenter::where(['id' => $training_center_id])->first();
            $training_center_name = $trainingCenter->title_en;

            $parameters['training_center_id'] = $training_center_id;
            $parameters['training_center_name'] = $training_center_name;
            $parameters['batch_id'] = $batch_id;
            $parameters['batch_name'] = $batch_name;
            $parameters['user_id'] = $user_id;
            $parameters['user_name'] = $user_name;
            $routines = Routine::with('routineClass')
                ->where(['institute_id'=>$authUser->institute_id, 'batch_id'=>$batch_id])
                ->whereHas('routineClass', function ($query) use($user_id) {
                        $query->where('user_id', $user_id);
                    })
                ->get();
        }elseif ($batch_id){
            $batch = Batch::where(['id' => $batch_id])->first();
            $batch_name = $batch->title_en;

            $trainingCenter = TrainingCenter::where(['id' => $training_center_id])->first();
            $training_center_name = $trainingCenter->title_en;

            $parameters['training_center_id'] = $training_center_id;
            $parameters['training_center_name'] = $training_center_name;
            $parameters['batch_id'] = $batch_id;
            $parameters['batch_name'] = $batch_name;
            $routines = Routine::with('routineClass')
                ->where(['institute_id'=>$authUser->institute_id, 'batch_id'=>$batch_id])
                ->get();
        }

        //return $parameters;
        return view(self::VIEW_PATH . 'weekly-routine',compact('routines','parameters'));
    }



    public function weeklyRoutineFilter(Request $request)
    {
        //dd($request->all());

        $this->validate($request, [
            'training_center_id' => 'required',
            'batch_id' => 'required'

        ]);
        @Session::forget(['user_id','batch_id','training_center_id']);
        $user_id = $request->get('user_id');
        $batch_id = $request->get('batch_id');
        $training_center_id = $request->get('training_center_id');


        Session::put(['user_id'=>$user_id,'batch_id'=>$batch_id,'training_center_id'=>$training_center_id]);
        return redirect(route('course_management::admin.weekly-routine'));


    }
}
