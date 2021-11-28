<?php

namespace Module\CourseManagement\App\Http\Controllers;

use App\Services\CertificateGenerator;
use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Module\CourseManagement\App\Models\Institute;
use Module\CourseManagement\App\Models\Youth;
use Module\CourseManagement\App\Models\YouthAcademicQualification;
use Module\CourseManagement\App\Models\YouthBatch;
use Module\CourseManagement\App\Models\YouthCourseEnroll;
use Module\CourseManagement\App\Models\YouthFamilyMemberInfo;
use Module\CourseManagement\App\Services\YouthService;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class YouthManagementController extends Controller
{
    const VIEW_PATH = 'course_management::backend.youths.';
    protected YouthService $youthService;

    public function __construct(YouthService $youthService)
    {
        $this->youthService = $youthService;
    }

    public function index(): View
    {
        $institutes = Institute::acl()->active()->get();

        return \view(self::VIEW_PATH . 'youth-list', compact('institutes'));
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function getDatatable(Request $request): JsonResponse
    {
        return $this->youthService->getListDataForDatatable($request);
    }


    public function importYouth(Request $request)
    {
        $youthData = (new \Module\CourseManagement\App\Models\YouthImport())->toArray($request->file('youth_csv_file'))[0];
        DB::beginTransaction();
        try {
            foreach ($youthData as $key => $youthDatum) {
                $validatedData = $this->youthService->youthImportDataValidate($youthDatum, $key)->validate();
                $youth = new Youth();
                $youth->fill($validatedData);
                $youth->save();

                if (!empty($youth->id)) {
                    $youthFamilyInfos = $youthDatum['youth_family_info'];
                    if (!empty($youthFamilyInfos['is_guardian'])) {
                        $isGuardian = $youthFamilyInfos['is_guardian'];
                        unset($youthFamilyInfos['is_guardian']);
                    }
                    foreach ($youthFamilyInfos as $familyInfo) {
                        $familyInfo['is_guardian'] = $isGuardian;
                        $familyInfo['is_guardian_data_exist'] = array_key_exists(3, $youthFamilyInfos);
                        $familyValidatedData = $this->youthService->youthFamilyInfoImportDataValidate($familyInfo, $key)->validate();
                        $familyValidatedData['youth_id'] = $youth->id;
                        $youthFamily = new YouthFamilyMemberInfo();
                        $youthFamily->fill($familyValidatedData);
                        $youthFamily->save();
                    }
                    foreach ($youthDatum['youth_academic_info'] as $academicInfo) {
                        $academicValidatedData = $this->youthService->youthAcademicInfoImportDataValidate($academicInfo, $key)->validate();
                        $academicValidatedData['youth_id'] = $youth->id;
                        $youthAcademic = new YouthAcademicQualification();
                        $youthAcademic->fill($academicValidatedData);
                        $youthAcademic->save();
                    }

                }
            }
            DB::commit();
            return [
                "status" => "success",
                "code" => ResponseAlias::HTTP_OK,
                "message" => "Successfully imported"
            ];
        } catch (Exception $e) {
            DB::rollBack();
            if ($e instanceof ValidationException) {
                return [
                    "status" => "fail",
                    "code" => ResponseAlias::HTTP_UNPROCESSABLE_ENTITY,
                    "message" => "validation error",
                    'errors' => $e->errors()
                ];
            }
            return [
                "status" => "success",
                "code" => ResponseAlias::HTTP_INTERNAL_SERVER_ERROR,
                'message' => $e->getMessage(),//__('generic.something_wrong_try_again'),
                'alert-type' => 'error'
            ];
        }

    }

    public function youthCertificateList($youthId)
    {
        $youth = Youth::findOrFail($youthId);

        $youthCourseEnrolls = YouthCourseEnroll::select([
            'youth_course_enrolls.id as id',
            'youths.name_en as youth_name_en',
            'youth_batches.batch_id as youth_batch_id',
            'publish_courses.id as publish_course_id',
            'batches.title_en as batch_title_en',
            'batches.batch_status',
        ]);
        $youthCourseEnrolls->join('publish_courses', 'publish_courses.id', '=', 'youth_course_enrolls.publish_course_id');
        $youthCourseEnrolls->leftJoin('youth_batches', 'youth_batches.youth_course_enroll_id', '=', 'youth_course_enrolls.id');
        $youthCourseEnrolls->leftJoin('batches', 'youth_batches.batch_id', '=', 'batches.id');
        $youthCourseEnrolls->join('youths', 'youths.id', '=', 'youth_course_enrolls.youth_id');
        $youthCourseEnrolls->where('youth_course_enrolls.youth_id', $youth->id);
        $youthCourseEnrolls = $youthCourseEnrolls->get();

        return \view(self::VIEW_PATH . 'youth-certificate-list', compact('youthCourseEnrolls', 'youth'));
    }

    public function youthCertificateCourseWise(YouthCourseEnroll $youthCourseEnroll)
    {
        $youthBatch = YouthBatch::where(['youth_course_enroll_id' => $youthCourseEnroll->id])->first();
        $familyInfo = YouthFamilyMemberInfo::where("youth_id", $youthCourseEnroll->youth_id)->where('relation_with_youth', "father")->first();
        $institute = $youthCourseEnroll->publishCourse->institute;
        $path = "youth-certificates/" . date('Y/F/', strtotime($youthBatch->batch->start_date)) . "course/" . Str::slug($youthCourseEnroll->publishCourse->course->title_en) . "/batch/" . $youthBatch->batch->title_en;

        $youthInfo = [
            'youth_id' => $youthCourseEnroll->youth_id,
            'youth_name' => $youthCourseEnroll->youth->name_en,
            'youth_father_name' => $familyInfo->member_name_en,
            'publish_course_id' => $youthCourseEnroll->publish_course_id,
            'publish_course_name' => $youthCourseEnroll->publishCourse->course->title_en,
            'path' => $path,
            "register_no" => $youthCourseEnroll->youth->youth_registration_no,
            'institute_name' => $institute->title_en,
            'from_date' => $youthBatch->batch->start_date,
            'to_date' => $youthBatch->batch->end_date,
            'batch_name' => $youthBatch->batch->title_en,
            'course_coordinator_signature' => "storage/{$youthBatch->batch->trainingCenter->course_coordinator_signature}",
            'course_director_signature' => "storage/{$youthBatch->batch->trainingCenter->course_director_signature}",
        ];

        $template = 'course_management::frontend.youth/certificate/certificate-one';
        $pdf = app(CertificateGenerator::class);
        return redirect(asset("storage/" . $pdf->generateCertificate($template, $youthInfo)));
        //return Storage::download($pdf->generateCertificate($template, $youthInfo));
    }
}
