<?php

namespace Module\CourseManagement\App\Http\Controllers;

use Module\CourseManagement\App\Models\ApplicationFormType;
use Module\CourseManagement\App\Models\Branch;
use Module\CourseManagement\App\Models\Course;
use Module\CourseManagement\App\Models\CourseSession;
use Module\CourseManagement\App\Models\Institute;
use Module\CourseManagement\App\Models\Programme;
use Module\CourseManagement\App\Models\PublishCourse;
use Module\CourseManagement\App\Models\TrainingCenter;
use Module\CourseManagement\App\Services\PublishCourseService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PublishCourseController extends Controller
{
    const VIEW_PATH = 'course_management::backend.publish-courses.';

    protected PublishCourseService $publishCourseService;

    public function __construct(PublishCourseService $publishCourseService)
    {
        $this->publishCourseService = $publishCourseService;
        $this->authorizeResource(PublishCourse::class);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(): View
    {
        /*$myVal = 31;
        $value = '"' . $myVal . '"';
        $test = PublishCourse::where('training_center_id','LIKE', '%' . $value . '%')->get();
        dd($test);*/
        return \view(self::VIEW_PATH . 'browse');
    }

    /**
     * @return View
     */
    public function create(): View
    {
        $courses = Course::active()->get();
        $programmes = Programme::active()->get();
        $branches = Branch::active()->get();
        $trainingCenters = TrainingCenter::active()->get();
        $applicationFormTypes = ApplicationFormType::active()->get();


        return \view(self::VIEW_PATH . 'edit-add')->with([
            'publishCourse' => new PublishCourse(),
            'institutes' => Institute::active()->get(),
            'courses' => $courses,
            'branches' => $branches,
            'trainingCenters' => $trainingCenters,
            'programmes' => $programmes,
            'applicationFormTypes' => $applicationFormTypes,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $validatedData = $this->publishCourseService->validator($request)->validate();

        DB::beginTransaction();
        try {
            $this->publishCourseService->createPublishCourse($validatedData);
            DB::commit();
        } catch (\Throwable $exception) {
            DB::rollBack();
            Log::debug($exception->getMessage());
            return back()->with([
                'message' => __('generic.something_wrong_try_again'),
                'alert-type' => 'error'
            ]);
        }

        return redirect()->route('course_management::admin.publish-courses.index')->with([
            'message' => __('generic.object_created_successfully', ['object' => 'Course Publish']),
            'alert-type' => 'success'
        ]);
    }

    /**
     * @param PublishCourse $publishCourse
     * @return View
     */
    public function show(PublishCourse $publishCourse): View
    {
        $courseSessions = CourseSession::where(['publish_course_id'=>$publishCourse->id])->get();

        return \view(self::VIEW_PATH . 'read', compact('publishCourse','courseSessions'));
    }

    /**
     * @param PublishCourse $publishCourse
     */
    public function edit(PublishCourse $publishCourse)
    {
        $publishCourse->load('courseSessions');
        $courses = Course::active()->get();
        $programmes = Programme::active()->get();
        $branches = Branch::active()->get();
        $trainingCenters = TrainingCenter::active()->get();
        $applicationFormTypes = ApplicationFormType::active()->get();


        return \view(self::VIEW_PATH . 'edit-add', compact('publishCourse'))->with([
            'institutes' => Institute::active()->get(),
            'publishCourse' => $publishCourse,
            'courses' => $courses,
            'branches' => $branches,
            'trainingCenters' => $trainingCenters,
            'programmes' => $programmes,
            'applicationFormTypes' => $applicationFormTypes,
        ]);
    }

    /**
     * @param Request $request
     * @param PublishCourse $publishCourse
     * @return RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, PublishCourse $publishCourse): RedirectResponse
    {
        $this->publishCourseService->validator($request, $publishCourse->id)->validate();

        DB::beginTransaction();
        try {
            $this->publishCourseService->updatePublishCourse($publishCourse, $request->all());
            DB::commit();
        } catch (\Throwable $exception) {
            DB::rollBack();
            Log::debug($exception->getMessage());
            return back()->with([
                'message' => __('generic.something_wrong_try_again'),
                'alert-type' => 'error'
            ]);
        }

        return redirect()->route('course_management::admin.publish-courses.index')->with([
            'message' => __('generic.object_updated_successfully', ['object' => 'Course Publish']),
            'alert-type' => 'success'
        ]);
    }

    /**
     * @param PublishCourse $publishCourse
     * @return RedirectResponse
     */
    public function destroy(PublishCourse $publishCourse): RedirectResponse
    {
        try {
            $publishCourse->delete();
        } catch (\Throwable $exception) {
            Log::debug($exception->getMessage());
            return back()->with([
                'message' => __('generic.something_wrong_try_again'),
                'alert-type' => 'error'
            ]);
        }

        return back()->with([
            'message' => __('generic.object_deleted_successfully', ['object' => 'Course Config']),
            'alert-type' => 'success'
        ]);
    }

    public function getDatatable(Request $request): JsonResponse
    {
        return $this->publishCourseService->getListDataForDatatable($request);
    }
}
