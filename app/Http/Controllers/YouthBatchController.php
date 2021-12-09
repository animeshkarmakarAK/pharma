<?php

namespace App\Http\Controllers;

use App\Models\BaseModel as BaseModelAlias;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use App\Models\BaseModel;
use App\Models\Batch;
use App\Models\Youth;
use App\Models\YouthAcademicQualification;
use App\Models\YouthBatch;
use App\Models\YouthCourseEnroll;
use App\Models\YouthFamilyMemberInfo;
use App\Services\YouthBatchService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Services\YouthService;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class YouthBatchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    const VIEW_PATH = 'backend.youth-batches.';
    public YouthBatchService $youthBatchService;

    public function __construct(YouthBatchService $youthBatchService)
    {
        $this->youthBatchService = $youthBatchService;
    }

    public function index(int $id)
    {
        $batch = Batch::findOrFail($id);

        return \view(self::VIEW_PATH . 'browse', compact('batch'));
    }

    public function getDatatable(Request $request, int $id): JsonResponse
    {
        return $this->youthBatchService->getYouthBatchLists($request, $id);
    }


    public function importYouth(Request $request, int $batch_id)
    {
        $youthData = (new \App\Models\YouthImport())->toArray($request->file('import_youth_file'))[0];

        DB::beginTransaction();
        try {
            $publishCourseId = Batch::findOrFail($batch_id)->publish_course_id;
            foreach ($youthData as $key => $youthDatum) {
                $validatedData = app(YouthService::class)->youthImportDataValidate($youthDatum, ($key+1))->validate();
                $youth = new Youth();
                $youth->fill($validatedData);
                $youth->save();

                if (!empty($youth->id)) {
                    $youthFamilyInfos = $youthDatum['youth_family_info'];
                    foreach ($youthFamilyInfos as $familyInfo) {
                        $familyInfo['is_guardian_data_exist'] = array_key_exists(3, $youthFamilyInfos);
                        $familyValidatedData = app(YouthService::class)->youthFamilyInfoImportDataValidate($familyInfo, ($key+1))->validate();
                        $familyValidatedData['youth_id'] = $youth->id;
                        $youthFamily = new YouthFamilyMemberInfo();
                        $youthFamily->fill($familyValidatedData);
                        $youthFamily->save();
                    }
                    foreach ($youthDatum['youth_academic_info'] as $academicInfo) {
                        $academicValidatedData = app(YouthService::class)->youthAcademicInfoImportDataValidate($academicInfo,($key+1))->validate();
                        $academicValidatedData['youth_id'] = $youth->id;
                        $youthAcademic = new YouthAcademicQualification();
                        $youthAcademic->fill($academicValidatedData);
                        $youthAcademic->save();
                    }

                    $youthCourseEnrollInfo = [
                        "publish_course_id" => $publishCourseId,
                        "enroll_status" => YouthCourseEnroll::ENROLL_STATUS_ACCEPT,
                        "payment_status" => YouthCourseEnroll::PAYMENT_STATUS_PAID,
                    ];

                    $youthEnrolment = $youth->youthCourseEnroll()->create($youthCourseEnrollInfo);
                    if ($youthEnrolment) {

                        $youthBatch = app(YouthBatch::class);
                        $youthBatch->batch_id = $batch_id;
                        $youthBatch->youth_course_enroll_id = $youthEnrolment->id;
                        $youthBatch->enrollment_date = date('Y-m-d');
                        $youthBatch->enrollment_status = YouthBatch::ENROLLMENT_STATUS_ENROLLED;
                        $youthBatch->save();
                    }

                }
            }
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            if ($e instanceof ValidationException) {
                return [
                    "status" => "fail",
                    "code" => ResponseAlias::HTTP_UNPROCESSABLE_ENTITY,
                    "message" => "validation error",
                    'errors' => array_values($e->errors())
                ];
            }
            return [
                "status" => "success",
                "code" => ResponseAlias::HTTP_INTERNAL_SERVER_ERROR,
                'message' => $e->getMessage(),//__('generic.something_wrong_try_again'),
                'alert-type' => 'error'
            ];
        }

        return [
            "status" => "success",
            "code" => ResponseAlias::HTTP_OK,
            "message" => "Successfully imported"
        ];
    }
}
