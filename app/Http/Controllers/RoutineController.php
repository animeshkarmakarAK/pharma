<?php

namespace App\Http\Controllers;

use App\Helpers\Classes\AuthHelper;
use App\Models\Batch;
use App\Models\Routine;
use App\Models\RoutineSlot;
use App\Models\TrainingCenter;
use App\Models\User;
use App\Models\UserType;
use App\Services\RoutineService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\ValidationException;

class RoutineController extends Controller
{
    const VIEW_PATH = 'backend.routines.';
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
        $batches = Batch::acl()->active()->pluck('title', 'id');
        $trainingCenters = TrainingCenter::acl()->active()->pluck('title', 'id');
        $trainers = User::acl()->where(['user_type_id' => UserType::USER_TYPE_TRAINER_USER_CODE])->get();

        return view(self::VIEW_PATH . 'edit-add', compact('batches', 'trainingCenters', 'trainers'));
    }


    public function store(Request $request): RedirectResponse
    {
        $authUser = AuthHelper::getAuthUser();
        if ($authUser->isInstituteUser()) {
            $request->merge(['institute_id', $authUser->institute_id]);
        }

        $validatedData = $this->routineService->validator($request)->validate();

        try {
            $this->routineService->createRoutine($validatedData);
        } catch (\Throwable $exception) {
            Log::debug($exception->getMessage());
            return back()->with([
                'message' => __('generic.something_wrong_try_again'),
                'alert-type' => 'error'
            ]);
        }

        return redirect()->route('admin.routines.index')->with([
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
        $routineClasses = RoutineSlot::where(['routine_id' => $routine->id])->get();
        return view(self::VIEW_PATH . 'read', compact('routine', 'routineClasses'));
    }

    /**
     * @param Routine $routine
     * @return View
     */
    public function edit(Routine $routine): View
    {
        $routineData = Routine::where(['id' => $routine->id])->with('routineSlots')->get();
        $trainers = User::acl()->where(['user_type_id' => UserType::USER_TYPE_TRAINER_USER_CODE])->get();
        return view(self::VIEW_PATH . 'edit-add', compact('routine', 'trainers', 'routineData'));
    }

    /**
     * @param Request $request
     * @param Routine $routine
     * @return RedirectResponse
     * @throws ValidationException
     */
    public function update(Request $request, Routine $routine): RedirectResponse
    {
        $this->routineService->validator($request)->validate();

        try {
            $this->routineService->updateRoutine($routine, $request->all());
        } catch (\Throwable $exception) {
            Log::debug($exception->getMessage());
            return back()->with([
                'message' => __('generic.something_wrong_try_again'),
                'alert-type' => 'error'
            ]);
        }

        return redirect()->route('admin.routines.index')->with([
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


    /**
     * @return View
     */
    public function dailyRoutine(): View
    {
        return view(self::VIEW_PATH . 'daily-routine');
    }

}
