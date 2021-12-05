<?php

namespace Module\CourseManagement\App\Http\Controllers;

use Module\CourseManagement\App\Models\StaticPage;
use Module\CourseManagement\App\Models\Institute;
use Module\CourseManagement\App\Services\StaticPageService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class StaticPageController extends Controller
{
    const VIEW_PATH = 'course_management::backend.static-page.';
    protected StaticPageService $staticPageService;

    public function __construct(StaticPageService $staticPageService)
    {
        $this->staticPageService = $staticPageService;
        $this->authorizeResource(StaticPage::class);
    }

    public function index(): View
    {
        return \view(self::VIEW_PATH . 'browse');
    }

    public function create(): View
    {
        $institutes = Institute::acl()->active()->get();
        $page = StaticPage::select('id', 'page_id')->get();
        return \view(self::VIEW_PATH . 'edit-add', compact('institutes', 'page'));
    }

    public function store(Request $request): RedirectResponse
    {
        $staticPageValidatedData = $this->staticPageService->validator($request)->validate();

        try {
            $this->staticPageService->createStaticPage($staticPageValidatedData);
        } catch (\Throwable $exception) {
            Log::debug($exception->getMessage());
            return back()->with([
                'message' => __('generic.something_wrong_try_again'),
                'alert-type' => 'error'
            ]);
        }

        return redirect()->route('course_management::admin.static-page.index')->with([
            'message' => __('generic.object_created_successfully', ['object' => 'Static Page']),
            'alert-type' => 'success'
        ]);
    }

    public function edit(Request $request, StaticPage $staticPage): View
    {
        $institutes = Institute::acl()->active()->get();
        $page = StaticPage::select('id', 'page_id')->get();

        return \view(self::VIEW_PATH . 'edit-add', compact('staticPage', 'institutes', 'page'));
    }

    public function show(StaticPage $staticPage): View
    {
        return \view(self::VIEW_PATH . 'read', compact('staticPage'));
    }


    public function update(Request $request, StaticPage $staticPage): RedirectResponse
    {
        $validatedData = $this->staticPageService->validator($request, $staticPage->id)->validate();

        try {
            $this->staticPageService->updateStaticPage($staticPage, $validatedData);
        } catch (\Throwable $exception) {
            Log::debug($exception->getMessage());
            return back()->with([
                'message' => __('generic.something_wrong_try_again'),
                'alert-type' => 'error'
            ]);
        }

        return redirect()->route('course_management::admin.static-page.index')->with([
            'message' => __('generic.object_updated_successfully', ['object' => 'Static Page']),
            'alert-type' => 'success'
        ]);
    }


    public function destroy(StaticPage $staticPage): RedirectResponse
    {
        try {
            $this->staticPageService->deleteStaticPage($staticPage);
        } catch (\Throwable $exception) {
            Log::debug($exception->getMessage());
            return back()->with([
                'message' => __('generic.something_wrong_try_again'),
                'alert-type' => 'error'
            ]);
        }

        return back()->with([
            'message' => __('generic.object_deleted_successfully', ['object' => 'StaticPage']),
            'alert-type' => 'success'
        ]);
    }


    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function getDatatable(Request $request): JsonResponse
    {
        return $this->staticPageService->getListDataForDatatable($request);
    }

    public function imageUpload(Request $request): object
    {
        return $this->staticPageService->staticPageImage($request);
    }


    public function checkCode(Request $request): JsonResponse
    {
        $staticPage = StaticPage::where([
            ['page_id', '=', $request->page_id],
            ['institute_id', '=', $request->institute_id]
        ]);

        if ($request->id && $request->id != 0) {
            $staticPage->where('id', '!=', $request->id);
        }

        if ($staticPage->first() == null) {
            return response()->json(true);
        } else {
            return response()->json('Page Id already in use!');
        }
    }
}
