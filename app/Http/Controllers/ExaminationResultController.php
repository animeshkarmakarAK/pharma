<?php

namespace App\Http\Controllers;

use App\Helpers\Classes\AuthHelper;
use App\Models\BaseModel;
use App\Models\User;
use App\Models\YouthCourseEnroll;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use App\Models\Batch;
use App\Models\Examination;
use App\Models\ExaminationResult;
use App\Models\Trainee;
use App\Models\TraineeBatch;
use App\Services\ExaminationResultService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ExaminationResultController extends Controller
{
    const VIEW_PATH = 'backend.examination-results.';
    public ExaminationResultService $examinationResultService;

    public function __construct(ExaminationResultService $examinationResultService)
    {
        $this->examinationResultService = $examinationResultService;
        $this->authorizeResource(ExaminationResult::class);
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
        $examinationResult = new Batch();
        $examinations = Examination::with('examinationType')->where(['row_status' => Examination::EXAMINATION_ROW_STATUS_ACTIVE, 'status'=> Examination::EXAMINATION_STATUS_COMPLETE])->get();
        return view(self::VIEW_PATH . 'edit-add', compact('examinationResult','examinations'));
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */

    public function store(Request $request): RedirectResponse
    {

        $validatedData = $this->examinationResultService->validator($request)->validate();
        $authUser = User::acl()->get();
        $examination = Examination::where(['id'=> $request->examination_id])->first();
        $batch_id = $examination->batch_id;
        $training_center_id  = $examination->training_center_id;
        try {
            $validatedData['batch_id'] = $batch_id;
            $validatedData['training_center_id'] = $training_center_id;
            $validatedData['institute_id'] = $authUser->institute_id;
            $validatedData['created_by'] = $authUser->id;
            $validatedData['user_id'] = $authUser->id;
            $this->examinationResultService->createExaminationResult($validatedData);
        } catch (\Throwable $exception) {
            Log::debug($exception->getMessage());
            return back()->with([
                'message' => __('generic.something_wrong_try_again'),
                'alert-result' => 'error'
            ]);
        }

        return redirect()->route('admin.examination-results.index')->with([
            'message' => __('generic.object_created_successfully', ['object' => 'ExaminationResult']),
            'alert-result' => 'success'
        ]);
    }

    /**
     * @param ExaminationResult $examinationResult
     * @return View
     */
    public function show(ExaminationResult $examinationResult): View
    {
        return view(self::VIEW_PATH . 'read', compact('examinationResult'));
    }

    /**
     * @param ExaminationResult $examinationResult
     * @return View
     */
    public function edit(ExaminationResult $examinationResult)
    {

        $examinations = Examination::with('examinationType')->where(['row_status' => BaseModel::ROW_STATUS_ACTIVE])->get();
        $trainees = Trainee::where(['id' => $examinationResult->trainee_id])->pluck('name','id');
        return view(self::VIEW_PATH . 'edit-add', compact('examinationResult','examinations','trainees'));
    }

    /**
     * @param Request $request
     * @param ExaminationResult $examinationResult
     * @return RedirectResponse
     * @throws ValidationException
     */
    public function update(Request $request, ExaminationResult $examinationResult): RedirectResponse
    {
        $validatedData = $this->examinationResultService->validator($request)->validate();
        $examination = Examination::where(['id'=> $request->examination_id])->first();
        $batch_id = $examination->batch_id;
        $training_center_id  = $examination->training_center_id;
        try {
            $validatedData['batch_id'] = $batch_id;
            $validatedData['training_center_id'] = $training_center_id;
            $this->examinationResultService->updateExaminationResult($examinationResult, $validatedData);
        } catch (\Throwable $exception) {
            Log::debug($exception->getMessage());
            return back()->with([
                'message' => __('generic.something_wrong_try_again'),
                'alert-result' => 'error'
            ]);
        }

        return redirect()->route('admin.examination-results.index')->with([
            'message' => __('generic.object_updated_successfully', ['object' => 'ExaminationResult']),
            'alert-result' => 'success'
        ]);
    }

    /**
     * @param ExaminationResult $examinationResult
     * @return RedirectResponse
     */
    public function destroy(ExaminationResult $examinationResult): RedirectResponse
    {
        try {
            $this->examinationResultService->deleteExaminationResult($examinationResult);
        } catch (\Throwable $exception) {
            Log::debug($exception->getMessage());
            return back()->with([
                'message' => __('generic.something_wrong_try_again'),
                'alert-result' => 'error'
            ]);
        }

        return back()->with([
            'message' => __('generic.object_deleted_successfully', ['object' => 'ExaminationResult']),
            'alert-result' => 'success'
        ]);
    }


    public function getDatatable(Request $request): JsonResponse
    {
        return $this->examinationResultService->getExaminationResultLists($request);
    }

    public function getTrainees($examinationIid)
    {
        $examination = Examination::where(['id'=>$examinationIid])->first();
        $batchId = $examination->batch_id;
        $traineeBatches = TraineeBatch::select(
            [
                'trainees.id as id',
                'trainee_course_enrolls.id as trainee_registrations.trainee_registration_no',
                'trainees.trainee_registration_no as trainee_registration_no',
                'trainees.name as trainee_name',
                DB::raw('DATE_FORMAT(trainee_batches.enrollment_date,"%d %b, %Y %h:%i %p") AS enrollment_date'),
            ]
        );
        $traineeBatches->join('batches', 'trainee_batches.batch_id', '=', 'batches.id');
        $traineeBatches->leftJoin('trainee_course_enrolls', 'trainee_batches.trainee_course_enroll_id', '=', 'trainee_course_enrolls.id');
        $traineeBatches->join('trainees', 'trainee_course_enrolls.trainee_id', '=', 'trainees.id');
        $traineeBatches->where('batches.id', $batchId);

        $data = $traineeBatches->get();

        return $data->toArray();


    }

    /**
     * @return View
     */
    public function batchResult($examinationId): View
    {
        $examination = Examination::find($examinationId);
        $examinationResult = ExaminationResult::where(['examination_id' => $examinationId])->get();
        if($examinationResult){
            $trainees = YouthBatch::select(
                [
                    'youths.id as id',
                    'youths.name as name',
                    'examinations.id as examination_id',
                    'examinations.total_mark as total_mark',
                    'examination_results.achieved_marks as achieved_marks',
                    'examination_results.feedback as feedback',
                ]
            )
                ->join('batches', 'youth_batches.batch_id', '=', 'batches.id')
                ->leftJoin('youth_course_enrolls', 'youth_batches.youth_course_enroll_id', '=', 'youth_course_enrolls.id')
                ->join('youths', 'youth_course_enrolls.youth_id', '=', 'youths.id')
                ->leftjoin('examinations', 'batches.id', '=', 'examinations.batch_id')
                ->leftjoin('examination_results', 'examinations.id', '=', 'examination_results.examination_id')
                ->where([
                    'batches.id' => $examination->batch_id,
                    'youth_course_enrolls.enroll_status' => YouthCourseEnroll::ENROLL_STATUS_ACCEPT
                ])
                ->get();
            dd($trainees);
            return \view(self::VIEW_PATH . 'batch-result',compact('trainees','examinationResult'));

        }
        $trainees = YouthBatch::select(
            [
                'youths.id as id',
                'youths.name as name',
                'examinations.id as examination_id',
                'examinations.total_mark as total_mark',
            ]
        )
        ->join('batches', 'youth_batches.batch_id', '=', 'batches.id')
        ->leftJoin('youth_course_enrolls', 'youth_batches.youth_course_enroll_id', '=', 'youth_course_enrolls.id')
        ->join('youths', 'youth_course_enrolls.youth_id', '=', 'youths.id')
        ->leftjoin('examinations', 'batches.id', '=', 'examinations.batch_id')
        ->where([
            'batches.id' => $examination->batch_id,
            'youth_course_enrolls.enroll_status' => YouthCourseEnroll::ENROLL_STATUS_ACCEPT
        ])
        ->get();
        return \view(self::VIEW_PATH . 'batch-result',compact('trainees'));
    }

    /**
     * @param ExaminationResult $examination
     * @param Request $request
     * @return RedirectResponse
     */

    public function batchResultstore(Request $request): RedirectResponse
    {
        $validatedData = $this->examinationResultService->resultValidator($request)->validate();

        try {
            $this->examinationResultService->createBatchResult($validatedData);
        } catch (\Throwable $exception) {
            Log::debug($exception->getMessage());
            return back()->with([
                'message' => __('generic.something_wrong_try_again'),
                'alert-result' => 'error'
            ]);
        }

        return redirect()->route('admin.examinations.index')->with([
            'message' => __('generic.object_created_successfully', ['object' => 'Examination Result']),
            'alert-result' => 'success'
        ]);
    }
}
