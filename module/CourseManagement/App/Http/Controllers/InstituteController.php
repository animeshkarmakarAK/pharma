<?php
namespace Module\CourseManagement\App\Http\Controllers;

use App\Helpers\Classes\Helper;
use Module\CourseManagement\App\Models\Institute;
use Module\CourseManagement\App\Services\InstituteService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class InstituteController extends Controller
{
    const VIEW_PATH = 'course_management::backend.institutes.';

    protected InstituteService $instituteService;

    public function __construct(InstituteService $instituteService)
    {
        $this->instituteService = $instituteService;
        $this->authorizeResource(Institute::class);
    }

    public function index(): View
    {
        return \view(self::VIEW_PATH . 'browse');
    }

    public function create(): View
    {
        $institute = new Institute();
        return \view(self::VIEW_PATH . 'edit-add', compact('institute'));
    }

    public function store(Request $request): RedirectResponse
    {
        $instituteValidatedData = $this->instituteService->validator($request)->validate();


        try {
            $this->instituteService->createInstitute($instituteValidatedData);
        } catch (\Throwable $exception) {
            Log::debug($exception->getMessage());
            return back()->with([
                'message' => __('generic.something_wrong_try_again'),
                'alert-type' => 'error'
            ]);
        }

        return back()->with([
            'message' => __('generic.object_created_successfully', ['object' => 'Institute']),
            'alert-type' => 'success'
        ]);
    }

    public function edit(Request $request, Institute $institute): View
    {
        return \view(self::VIEW_PATH . 'edit-add', compact('institute'));
    }

    public function show(Institute $institute): View
    {
        return \view(self::VIEW_PATH . 'read', compact('institute'));
    }


    public function update(Request $request, Institute $institute): RedirectResponse
    {
        $validatedData = $this->instituteService->validator($request, $institute->id)->validate();

        try {
            $this->instituteService->updateInstitute($institute, $validatedData);
            Helper::forgetDomainConfig($institute);
        } catch (\Throwable $exception) {
            Log::debug($exception->getMessage());
            return back()->with([
                'message' => __('generic.something_wrong_try_again'),
                'alert-type' => 'error'
            ]);
        }

        return back()->with([
            'message' => __('generic.object_updated_successfully', ['object' => 'Institute']),
            'alert-type' => 'success'
        ]);
    }


    public function destroy(Institute $institute): RedirectResponse
    {
        try {
            Helper::forgetDomainConfig($institute);
            $this->instituteService->deleteInstitute($institute);
        } catch (\Throwable $exception) {
            Log::debug($exception->getMessage());
            return back()->with([
                'message' => __('generic.something_wrong_try_again'),
                'alert-type' => 'error'
            ]);
        }

        return back()->with([
            'message' => __('generic.object_deleted_successfully', ['object' => 'Institute']),
            'alert-type' => 'success'
        ]);
    }


    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function getDatatable(Request $request): JsonResponse
    {
        return $this->instituteService->getListDataForDatatable($request);
    }

    public function checkCode(Request $request): JsonResponse
    {
        $institute = Institute::where(['code' => $request->code])->first();

        return response()->json($institute === null ? 'true' : 'Code already in use!', 200);
    }
}
