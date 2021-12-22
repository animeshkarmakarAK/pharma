<?php

namespace App\Http\Controllers;

use App\Models\Batch;
use App\Models\BatchCertificate;
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

    public function index(int $id)
    {
        $batchCertificate = Batch::findOrFail($id);
        return \view(self::VIEW_PATH . 'browse', compact('batchCertificate'));
    }

    public function create(int $id)
    {
        $batchCertificate = BatchCertificate::find($id)->with('batch')->first();

        //dd($batchCertificate->batch());
        return \view(self::VIEW_PATH . 'edit-add', compact('batchCertificate','id'));
    }
    public function store(Request $request)
    {
        //dd($request->all());

        $traineeCertificateValidatedData = $this->traineeCertificateService->validator($request)->validate();
        dd( $traineeCertificateValidatedData );
       /* try {
           // $this->courseService->createCourse($courseValidatedData);
        } catch (\Throwable $exception) {
            Log::debug($exception->getMessage());
            return back()->with([
                'message' => __('generic.something_wrong_try_again'),
                'alert-type' => 'error'
            ])->withInput();
        }

        return redirect()->route('admin.courses.index')->with([
            'message' => __('generic.object_created_successfully', ['object' => 'Course']),
            'alert-type' => 'success'
        ]);*/
       // return \view(self::VIEW_PATH . 'edit-add', compact('batchCertificate'));
    }



    public function getDatatable(Request $request, int $id): JsonResponse
    {
        return $this->traineeBatchService->getTraineeBatchLists($request, $id);
    }


}
