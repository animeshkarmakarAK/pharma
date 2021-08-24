<?php

namespace Module\CourseManagement\App\Http\Controllers\Frontend;

use App\Models\LocDivision;
use Module\CourseManagement\App\Http\Controllers\Controller;
use Module\CourseManagement\App\Models\ApplicationFormType;
use Module\CourseManagement\App\Models\Course;
use Module\CourseManagement\App\Models\PublishCourse;
use Module\CourseManagement\App\Models\Youth;
use Module\CourseManagement\App\Models\YouthRegistration;
use Module\CourseManagement\App\Services\YouthRegistrationService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class YouthRegistrationController extends Controller
{
    const VIEW_PATH = 'course_management::frontend.youth-registrations.';
    protected YouthRegistrationService $youthRegistrationService;

    public function __construct(YouthRegistrationService $youthRegistrationService)
    {
        $this->youthRegistrationService = $youthRegistrationService;
    }

    /**
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        $publishedCourseId = $request->query('publish_course_id');

        $divisions = LocDivision::active()->get();
        /** @var PublishCourse $publishedCourse */
        $publishCourse = [];
        if ($publishedCourseId) {
            $publishCourse = PublishCourse::where('id', $publishedCourseId)->firstOrFail();
            if (!$publishCourse) {
                $publishCourse = [];
            }

            $publishCourse->load([
                'institute',
                'course',
                'programme',
                'trainingCenter',
                'branch',
                'applicationFormType'
            ]);

        }

        $institutes = DB::table('institutes')
            ->join('courses', 'courses.institute_id', '=', 'institutes.id')
            ->select('institutes.*')
            ->where('courses.row_status', Course::ROW_STATUS_ACTIVE)
            ->distinct()
            ->get();
        return \view(self::VIEW_PATH . 'application-form')->with([
            'institutes' => $institutes,
            'divisions' => $divisions,
            'publishCourse' => $publishCourse
        ]);
    }

    /**
     * applied youth for registration data view
     *
     * @param $youthRegistrationId
     * @return View
     */
    public function show($youthRegistrationId): View
    {
        $youthRegistrationData = YouthRegistration::findOrFail($youthRegistrationId);
        $youth = Youth::where('id', $youthRegistrationData->youth_id)->first();

        $familyMembers = $this->youthRegistrationService->getYouthFamilyMemberInfo($youth);
        $youthAcademicQualifications = $this->youthRegistrationService->getYouthAcademicQualification($youth);
        $youthSelfInfo = $this->youthRegistrationService->getYouthInfo($youth);

        return \view(self::VIEW_PATH . 'read')
            ->with([
                'youthRegistrationData' => $youthRegistrationData,
                'father' => $familyMembers['father'],
                'mother' => $familyMembers['mother'],
                'guardian' => $familyMembers['guardian'],
                'academicQualifications' => $youthAcademicQualifications,
                'youthSelfInfo' => $youthSelfInfo,
                'youth' => $youth,
            ]);
    }


    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */

    public function store(Request $request): JsonResponse
    {
        $validated = $this->youthRegistrationService->validator($request)->validate();
        DB::beginTransaction();
        try {
            $youth = $this->youthRegistrationService->createRegistration($validated);
            DB::commit();
        } catch (\Throwable $exception) {
            DB::rollBack();
            Log::debug($exception->getMessage());

            return response()->json([
                'message' => __('generic.something_wrong_try_again'),
                'alertType' => 'error'
            ]);

        }

        $accessKey = $youth->access_key;
        $redirectTo = route('course_management::youth-registration.success', $accessKey);

        return response()->json([
            'message' => __('generic.object_created_successfully', ['object' => 'Registration']),
            'alertType' => 'success',
            'accessKey' => $accessKey,
            'redirectTo' => $redirectTo,
        ]);

    }

    public function registrationSuccess($accessKey)
    {
        return \view('course_management::frontend/youth-registrations/application-success-message', compact('accessKey'));
    }
}
