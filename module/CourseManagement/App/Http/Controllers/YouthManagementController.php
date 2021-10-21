<?php

namespace Module\CourseManagement\App\Http\Controllers;

use App\Helpers\Classes\AuthHelper;
use App\Services\CertificateGenerator;
use Exception;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Module\CourseManagement\App\Models\Batch;
use Module\CourseManagement\App\Models\Institute;
use Module\CourseManagement\App\Models\Youth;
use Module\CourseManagement\App\Models\YouthAcademicQualification;
use Module\CourseManagement\App\Models\YouthCourseEnroll;
use Module\CourseManagement\App\Models\YouthFamilyMemberInfo;
use Module\CourseManagement\App\Models\YouthOrganization;
use Module\CourseManagement\App\Services\YouthService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Module\GovtStakeholder\App\Models\Organization;
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
        $organizations = Organization::acl()->get();

        return \view(self::VIEW_PATH . 'youth-list', compact('institutes', 'organizations'));
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function getDatatable(Request $request): JsonResponse
    {
        return $this->youthService->getListDataForDatatable($request);
    }

    public function addYouthToOrganization(Request $request): \Illuminate\Http\RedirectResponse
    {
        $organization = Organization::findOrFail($request['organization_id']);

        DB::beginTransaction();
        try {
            $validatedData = $this->youthService->validateAddYouthToOrganization($request)->validate();
            $this->youthService->addYouthToOrganization($organization, $validatedData['youth_ids']);
            DB::commit();
        } catch (\Throwable $exception) {
            DB::rollBack();
            Log::debug($exception->getMessage());
            Log::debug($exception->getTraceAsString());
            return back()->with([
                'message' => __('generic.something_wrong_try_again'),
                'alert-type' => 'error'
            ]);
        }

        return back()->with([
            'message' => __('Youth added to batch'),
            'alert-type' => 'success'
        ]);
    }

    public function getYouthAssignedOrganizations(Request $request)
    {
        $organizations = Youth::where("id", $request->id)->first();
        return $organizations ? $organizations->youthOrganizations()->get() : [];
    }

    public function youthCertificateList(Youth $youth)
    {
        $youthCourseEnrolls = YouthCourseEnroll::where('youth_id', $youth->id)->get();

        return \view(self::VIEW_PATH . 'youth-certificate-list', compact('youthCourseEnrolls', 'youth'));
    }

    public function youthCertificateCourseWise(YouthCourseEnroll $youthCourseEnroll)
    {
        $familyInfo = YouthFamilyMemberInfo::where("youth_id", $youthCourseEnroll->youth_id)->where('relation_with_youth', "father")->first();

        $institute = $youthCourseEnroll->publishCourse->institute;

        $path = "youth-certificates/" . date('Y/F/', strtotime($youthCourseEnroll->publishCourse->batch->updated_at)) . "course/" . Str::slug($youthCourseEnroll->publishCourse->course->title_en) . "/pushed_course_id_" . $youthCourseEnroll->publishCourse->id;

        $youthInfo = [
            'youth_id' => $youthCourseEnroll->youth_id,
            'youth_name' => $youthCourseEnroll->youth->name_en,
            'youth_father_name' => $familyInfo->member_name_en,
            'publish_course_id' => $youthCourseEnroll->publish_course_id,
            'path' => $path,
            "register_no" => $youthCourseEnroll->youth->youth_registration_no,
            'institute_name' => $institute->title_en,
            'from_date' => date('d/m/Y', strtotime($youthCourseEnroll->publishCourse->created_at)),
            'to_date' => date('d/m/Y', strtotime($youthCourseEnroll->publishCourse->batch->updated_at)),
        ];
        $template = 'course_management::frontend.youth/certificate/certificate-one';
        $pdf = app(CertificateGenerator::class);
        //return redirect(asset("storage/".$pdf->generateCertificate($template, $youthInfo)));
        return Storage::download($pdf->generateCertificate($template, $youthInfo));

    }

}
