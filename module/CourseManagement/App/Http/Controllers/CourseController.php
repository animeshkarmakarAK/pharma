<?php


namespace Module\CourseManagement\App\Http\Controllers;


use Module\CourseManagement\App\Models\Course;
use Module\CourseManagement\App\Services\CourseService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CourseController extends Controller
{
    const VIEW_PATH = 'course_management::backend.courses.';
    protected CourseService $courseService;

    /**
     * CourseController constructor.
     * @param CourseService $courseService
     */
    public function __construct(CourseService $courseService)
    {
        $this->courseService = $courseService;
        $this->authorizeResource(Course::class);
    }

    /**
     * @return View
     */
    public function index(): View
    {
        return \view(self::VIEW_PATH . 'browse');
    }

    /**
     * @return View
     */
    public function create(): View
    {
        $course = new Course();
        return \view(self::VIEW_PATH . 'edit-add', compact('course'));
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $courseValidatedData = $this->courseService->validator($request)->validate();
        $this->courseService->createCourse($courseValidatedData);
        try {

        } catch (\Throwable $exception) {
            Log::debug($exception->getMessage());
            return back()->with([
                'message' => __('generic.something_wrong_try_again'),
                'alert-type' => 'error'
            ]);
        }

        return redirect()->route('course_management::admin.courses.index')->with([
            'message' => __('generic.object_created_successfully', ['object' => 'Course']),
            'alert-type' => 'success'
        ]);
    }

    /**
     * @param Request $request
     * @param Course $course
     * @return View
     */
    public function edit(Request $request, Course $course): View
    {
        return \view(self::VIEW_PATH . 'edit-add', compact('course'));
    }

    /**
     * @param Course $course
     * @return View
     */
    public function show(Course $course): View
    {
        return \view(self::VIEW_PATH . 'read', compact('course'));
    }

    /**
     * @param Request $request
     * @param Course $course
     * @return RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, Course $course): RedirectResponse
    {
        $this->courseService->validator($request, $course->id)->validate();
        try {
            $this->courseService->updateCourse($course, $request);
        } catch (\Throwable $exception) {
            Log::debug($exception->getMessage());
            return back()->with([
                'message' => __('generic.something_wrong_try_again'),
                'alert-type' => 'error'
            ]);
        }

        return redirect()->route('course_management::admin.courses.index')->with([
            'message' => __('generic.object_updated_successfully', ['object' => 'Course']),
            'alert-type' => 'success'
        ]);
    }


    /**
     * @param Course $course
     * @return RedirectResponse
     */
    public function destroy(Course $course): RedirectResponse
    {
        try {
            $this->courseService->deleteCourse($course);
        } catch (\Throwable $exception) {
            Log::debug($exception->getMessage());
            return back()->with([
                'message' => __('generic.something_wrong_try_again'),
                'alert-type' => 'error'
            ]);
        }

        return back()->with([
            'message' => __('generic.object_deleted_successfully', ['object' => 'course']),
            'alert-type' => 'success'
        ]);
    }


    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function getDatatable(Request $request): JsonResponse
    {
        return $this->courseService->getListDataForDatatable($request);
    }

    public function checkCode(Request $request): JsonResponse
    {
        $course = Course::where(['code' => $request->code])->first();
        if ($course == null) {
            return response()->json(true);
        } else {
            return response()->json('Code already in use!');
        }
    }



}
