<?php

namespace Module\CourseManagement\App\Http\Controllers;

use App\Helpers\Classes\AuthHelper;
use App\Helpers\Classes\DatatableHelper;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Module\CourseManagement\App\Models\Batch;
use Module\CourseManagement\App\Models\Examination;
use Module\CourseManagement\App\Models\ExaminationResult;
use Module\CourseManagement\App\Models\Youth;
use Module\CourseManagement\App\Models\YouthBatch;
use Module\CourseManagement\App\Services\ExaminationResultService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;


class ExaminationResultController extends Controller
{
    const VIEW_PATH = 'course_management::backend.examination-results.';
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
        /*$examinationResults = ExaminationResult::with('user','youth','examination','batch','trainingCenter')->select(
            [
                'examination_results.*'
            ]
        );

        return DataTables::eloquent($examinationResults)->toJson();*/

        return \view(self::VIEW_PATH . 'browse');
    }

    /**
     * @return View
     */
    public function create(): View
    {
        $examinationResult = new Batch();
        $examinations = Examination::with('examinationType')->where(['row_status' => 1,'status'=>2])->get();
        //dd($examinations);
        return view(self::VIEW_PATH . 'edit-add', compact('examinationResult','examinations'));
    }


    public function store(Request $request): RedirectResponse
    {

        $validatedData = $this->examinationResultService->validator($request)->validate();
        //dd($validatedData);
        $authUser = AuthHelper::getAuthUser();
        $examination = Examination::where(['id'=> $request->examination_id])->first();
        //dd($examination);
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

        return redirect()->route('course_management::admin.examination-results.index')->with([
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
        //dd($examinationResult);
        return view(self::VIEW_PATH . 'read', compact('examinationResult'));
    }

    /**
     * @param ExaminationResult $examinationResult
     * @return View
     */
    public function edit(ExaminationResult $examinationResult)
    {

        //return $examinationResult->youth_id;
        $examinations = Examination::with('examinationType')->where(['row_status' => 1])->get();

        $youths = Youth::where(['id' => $examinationResult->youth_id])->pluck('name_en','id');
        //dd($youths);

        return view(self::VIEW_PATH . 'edit-add', compact('examinationResult','examinations','youths'));
    }

    /**
     * @param Request $request
     * @param int $id
     * @return RedirectResponse
     * @throws ValidationException
     */
    public function update(Request $request, ExaminationResult $examinationResult): RedirectResponse
    {
        //dd($examinationResult);
        $validatedData = $this->examinationResultService->validator($request)->validate();
        $examination = Examination::where(['id'=> $request->examination_id])->first();
        //dd($examination);
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

        return redirect()->route('course_management::admin.examination-results.index')->with([
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

    public function getYouths($examinationIid)
    {
        $examination = Examination::where(['id'=>$examinationIid])->first();
        $batchId = $examination->batch_id;
        $youthBatches = YouthBatch::select(
            [
                'youths.id as id',
                'youth_course_enrolls.id as youth_registrations.youth_registration_no',
                'youths.youth_registration_no as youth_registration_no',
                'youths.name_en as youth_name_en',
                DB::raw('DATE_FORMAT(youth_batches.enrollment_date,"%d %b, %Y %h:%i %p") AS enrollment_date'),
            ]
        );
        $youthBatches->join('batches', 'youth_batches.batch_id', '=', 'batches.id');
        $youthBatches->leftJoin('youth_course_enrolls', 'youth_batches.youth_course_enroll_id', '=', 'youth_course_enrolls.id');
        $youthBatches->join('youths', 'youth_course_enrolls.youth_id', '=', 'youths.id');
        $youthBatches->where('batches.id', $batchId);

        $data = $youthBatches->get();

        return $data->toArray();


    }
}
