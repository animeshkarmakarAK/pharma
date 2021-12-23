<?php

namespace App\Http\Controllers;

use App\Models\Batch;
use App\Models\BatchCertificate;
use App\Models\Certificate;
use App\Models\Trainee;
use App\Models\TraineeAcademicQualification;
use App\Models\TraineeBatch;
use App\Models\TraineeCourseEnroll;
use App\Models\TraineeFamilyMemberInfo;
use App\Services\TraineeBatchService;
use App\Services\TraineeCertificateService;
use App\Services\TraineeService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class TraineeCertificateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    const VIEW_PATH = 'backend.trainee-certificates.';
    public TraineeCertificateService $traineeCertificateService;

    /**
     * CourseController constructor.
     * @param TraineeCertificateService $traineeCertificateService
     */

    public function __construct(TraineeCertificateService $traineeCertificateService)
    {
        $this->traineeCertificateService = $traineeCertificateService;
    }

    public function index() :View
    {
        return \view(self::VIEW_PATH . 'browse');
    }

    public function create(int $id)
    {
        $batchCertificate = BatchCertificate::find($id)->with('batch')->first();

        //dd($batchCertificate->batch());
        return \view(self::VIEW_PATH . 'edit-add', compact('batchCertificate','id'));
    }



    public function getBatchDatatable(Request $request): JsonResponse
    {
        return $this->traineeCertificateService->getTraineeBatchLists($request);

    }

    public function certificateEdit($id) :View
    {

        $batchCertificate = BatchCertificate::where('batch_id',$id)->first();
        $batch = Batch::find($id)->with('course')->first();

        return \view(self::VIEW_PATH . 'edit-add-certificate', compact('batch','batchCertificate','id'));

    }

    public function store(Request $request)
    {
        $traineeCertificateValidatedData = $this->traineeCertificateService->validator($request)->validate();
         try {
             $this->traineeCertificateService->createBatchCertificate($traineeCertificateValidatedData);
         } catch (\Throwable $exception) {
             Log::debug($exception->getMessage());
             return back()->with([
                 'message' => __('generic.something_wrong_try_again'),
                 'alert-type' => 'error'
             ])->withInput();
         }

         return redirect()->route('admin.batches.certificates')->with([
             'message' => __('generic.object_created_successfully', ['object' => 'BatchCertificate']),
             'alert-type' => 'success'
         ]);
    }

    public function getDatatable(Request $request, int $id): JsonResponse
    {
        return $this->traineeCertificateService->getTraineeBatchLists($request, $id);

    }


}
