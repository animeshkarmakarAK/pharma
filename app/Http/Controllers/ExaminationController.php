<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use App\Models\Batch;
use App\Models\Examination;
use App\Models\ExaminationType;
use App\Models\TrainingCenter;
use App\Services\ExaminationService;

class ExaminationController extends Controller
{
    const VIEW_PATH = 'backend.examinations.';
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
        $batches = Batch::acl()->active()->pluck('title_en','id');
        $trainingCenters = TrainingCenter::active()->acl()->pluck('title_en','id');
        $examinationTypes = ExaminationType::active()->acl()->pluck('title','id');

        return view(self::VIEW_PATH . 'edit-add', compact('batches','trainingCenters','examinationTypes'));
    }


    public function store(Request $request): RedirectResponse
    {
        $validatedData = $this->examinationService->validator($request)->validate();
        $authUser = User::acl()->get();

        $statement = DB::select("show table status like 'examinations'");
        $ainid = $statement[0]->Auto_increment;


        try {
            $validatedData['code'] = $ainid + 1000;
            $validatedData['institute_id'] = $authUser->institute_id;
            $validatedData['created_by'] = $authUser->id;
            $this->examinationService->createExamination($validatedData);
        } catch (\Throwable $exception) {
            Log::debug($exception->getMessage());
            return back()->with([
                'message' => __('generic.something_wrong_try_again'),
                'alert-type' => 'error'
            ]);
        }

        return redirect()->route('admin.examinations.index')->with([
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

        $authUser = User::acl()->get();
        $examinationTypes = ExaminationType::acl()->where(['row_status' => 1, ])->pluck('title','id');
        return view(self::VIEW_PATH . 'edit-add', compact('examination','examinationTypes'));
    }

    /**
     * @param Request $request
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

        return redirect()->route('admin.examinations.index')->with([
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
    public function status($id)
    {
        $examination = Examination::find($id);
        if (!$examination){
            return back()->with([
                'message' => __('generic.something_wrong_try_again'),
                'alert-type' => 'error'
            ]);
        }

        $status = $examination->status;
        if ($status == 0) {
            $examination->status = 1;
            $examination->save();
        } else if($status == 1) {
            $examination->status = 2;
            $examination->save();
        } else {
            $examination->status = 0;
            $examination->save();
        }

        return back()->with([
            'message' => __('generic.object_deleted_successfully', ['object' => 'Examination']),
            'alert-type' => 'success'
        ]);
    }
}
