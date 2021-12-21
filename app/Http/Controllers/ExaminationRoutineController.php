<?php

namespace App\Http\Controllers;

use App\Helpers\Classes\AuthHelper;
use App\Models\User;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\ValidationException;
use App\Models\Batch;
use App\Models\Examination;
use App\Models\ExaminationRoutine;
use App\Models\ExaminationRoutineDetail;
use App\Models\Routine;
use App\Models\TrainingCenter;
use App\Services\ExaminationRoutineService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;


class ExaminationRoutineController extends Controller
{
    const VIEW_PATH = 'backend.examination-routines.';
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
        return \view(self::VIEW_PATH . 'browse');
    }

    /**
     * @param ExaminationRoutine  $examinationRoutine
     * @return View
     */

    public function create(ExaminationRoutine $examinationRoutine ): View
    {
        $batches = Batch::acl()->active()->pluck('title','id');
        $trainingCenters = TrainingCenter::acl()->active()->pluck('title','id');
        $trainers = User::acl()->where(['user_type_id' => 1 ])->get();
        $examinations = Examination::acl()->get();

        return view(self::VIEW_PATH . 'edit-add', compact('examinationRoutine','batches','trainingCenters','trainers','examinations'));
    }


    public function store(Request $request): RedirectResponse
    {
        $validatedData = $this->examinationRoutineService->validator($request)->validate();
        $trainingCenter =  TrainingCenter::where('id',$validatedData['training_center_id'])->first();
        $authUser = AuthHelper::getAuthUser();
        try {
            $validatedData['institute_id'] = $trainingCenter->institute_id;
            $validatedData['created_by'] = $authUser->id;

            $this->examinationRoutineService->createExaminationRoutine($validatedData);
        } catch (\Throwable $exception) {
            Log::debug($exception->getMessage());
            return back()->with([
                'message' => __('generic.something_wrong_try_again'),
                'alert-routine' => 'error'
            ]);
        }

        return redirect()->route('admin.examination-routines.index')->with([
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
        return view(self::VIEW_PATH . 'read', compact('examinationRoutine','examinationRoutineDetails'));
    }

    /**
     * @param ExaminationRoutine $examinationRoutine
     * @return View
     */
    public function edit(ExaminationRoutine $examinationRoutine): View
    {
        $trainers = User::acl()->where(['user_type_id' => 1])->get();
        $examinations = Examination::acl()->get();


        return view(self::VIEW_PATH . 'edit-add', compact('examinationRoutine','trainers','examinations'));
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     * @throws ValidationException
     */
    public function update(Request $request, ExaminationRoutine $examinationRoutine): RedirectResponse
    {
        $this->examinationRoutineService->validator($request)->validate();
        try {
            $this->examinationRoutineService->updateExaminationRoutine($examinationRoutine, $request->all());
        } catch (\Throwable $exception) {
            Log::debug($exception->getMessage());
            return back()->with([
                'message' => __('generic.something_wrong_try_again'),
                'alert-routine' => 'error'
            ]);
        }

        return redirect()->route('admin.examination-routines.index')->with([
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
    public function examinationRoutine(Routine $routine)
    {
        @$examination_id = Session::get('examination_id');
        @$batch_id = Session::get('batch_id');
        @$training_center_id= Session::get('training_center_id');
        $authUser = User::acl()->get();
        $parameters = [];
        $examinationRoutines = [];
        if ($batch_id && $examination_id){

            $examination = Examination::acl()->where(['id' => $examination_id])->first();
            $examination_name = $examination->code . " - ". substr($examination->exam_details, 0, 100) ;

            $batch = Batch::where(['id' => $batch_id])->first();
            $batch_name = $batch->title;

            $trainingCenter = TrainingCenter::where(['id' => $training_center_id])->first();
            $training_center_name = $trainingCenter->title;

            $parameters['training_center_id'] = $training_center_id;
            $parameters['training_center_name'] = $training_center_name;
            $parameters['batch_id'] = $batch_id;
            $parameters['batch_name'] = $batch_name;
            $parameters['examination_id'] = $examination_id;
            $parameters['examination_name'] = $examination_name;
            $examinationRoutines = ExaminationRoutine::with('examinationRoutineDetail')
                ->where(['institute_id'=>$authUser->institute_id, 'batch_id'=>$batch_id])
                ->whereHas('examinationRoutineDetail', function ($query) use ($examination_id) {
                    $query->where('examination_id','=', $examination_id);
                })
                ->get();
        }elseif ($batch_id){
            $batch = Batch::where(['id' => $batch_id])->first();
            $batch_name = $batch->title;

            $trainingCenter = TrainingCenter::where(['id' => $training_center_id])->first();
            $training_center_name = $trainingCenter->title;

            $parameters['training_center_id'] = $training_center_id;
            $parameters['training_center_name'] = $training_center_name;
            $parameters['batch_id'] = $batch_id;
            $parameters['batch_name'] = $batch_name;
            $examinationRoutines = ExaminationRoutine::with('examinationRoutineDetail')
                ->where(['institute_id'=>$authUser->institute_id, 'batch_id'=>$batch_id])
                ->get();
        }
        return view(self::VIEW_PATH . 'examination-routine',compact('examinationRoutines','parameters'));
    }



    public function examinationRoutineFilter(Request $request)
    {

        $this->validate($request, [
            'training_center_id' => 'required',
            'batch_id' => 'required'

        ]);
        @Session::forget(['examination_id','batch_id','training_center_id']);
        $examination_id = $request->get('examination_id');
        $batch_id = $request->get('batch_id');
        $training_center_id = $request->get('training_center_id');
        Session::put(['examination_id'=>$examination_id,'batch_id'=>$batch_id,'training_center_id'=>$training_center_id]);
        return redirect(route('admin.examination-routine'));
    }
}
