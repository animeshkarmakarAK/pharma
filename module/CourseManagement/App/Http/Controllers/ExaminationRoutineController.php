<?php

namespace Module\CourseManagement\App\Http\Controllers;

use App\Helpers\Classes\AuthHelper;
use App\Helpers\Classes\DatatableHelper;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Validation\ValidationException;
use Module\CourseManagement\App\Models\Batch;
use Module\CourseManagement\App\Models\Examination;
use Module\CourseManagement\App\Models\ExaminationRoutine;
use Module\CourseManagement\App\Models\ExaminationRoutineDetail;
use Module\CourseManagement\App\Models\Routine;
use Module\CourseManagement\App\Models\RoutineClass;
use Module\CourseManagement\App\Models\TrainingCenter;
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

        $authUser = AuthHelper::getAuthUser();
        $batches = Batch::where(['row_status' => 1, 'institute_id'=>$authUser->institute_id])->pluck('title_en','id');
        $trainingCenters = TrainingCenter::where(['row_status' => 1, 'institute_id'=>$authUser->institute_id])->pluck('title_en','id');
        $trainers = User::where(['institute_id' => $authUser->institute_id, 'user_type_id' => 1 ])->get();
        $examinations = Examination::where(['institute_id' => $authUser->institute_id ])->get();

        return view(self::VIEW_PATH . 'edit-add', compact('examinationRoutine','batches','trainingCenters','trainers','examinations'));
    }


    public function store(Request $request): RedirectResponse
    {
        //dd($request->all());
        $validatedData = $this->examinationRoutineService->validator($request)->validate();
        $authUser = AuthHelper::getAuthUser();
        try {
            $validatedData['institute_id'] = $authUser->institute_id;
            $validatedData['created_by'] = $authUser->id;

            //dd($validatedData);
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
        $examinationRoutineDetails = ExaminationRoutineDetail::with('examination','examinationRoutine')->where(['examination_routine_id' => $examinationRoutine->id])->get();
        //dd($examinationRoutineDetails);
        return view(self::VIEW_PATH . 'read', compact('examinationRoutine','examinationRoutineDetails'));
    }

    /**
     * @param ExaminationRoutine $examinationRoutine
     * @return View
     */
    public function edit(ExaminationRoutine $examinationRoutine): View
    {
        //$examinationRoutine = ExaminationRoutine::where(['id'=>$examinationRoutine->id])->with('ExaminationRoutineDetail')->get();
        $authUser = AuthHelper::getAuthUser();
        $trainers = User::where(['institute_id' => $authUser->institute_id, 'user_type_id' => 1])->get();
        $examinations = Examination::where(['institute_id' => $authUser->institute_id])->get();


        return view(self::VIEW_PATH . 'edit-add', compact('examinationRoutine','trainers','examinations'));
    }

    /**
     * @param Request $request
     * @param int $id
     * @return RedirectResponse
     * @throws ValidationException
     */
    public function update(Request $request, ExaminationRoutine $examinationRoutine): RedirectResponse
    {
        $validatedData = $this->examinationRoutineService->validator($request)->validate();
        //dd($validatedData);
        try {
            $this->examinationRoutineService->updateExaminationRoutine($examinationRoutine, $request->all());
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
