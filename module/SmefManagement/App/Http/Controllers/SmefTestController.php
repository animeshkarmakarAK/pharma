<?php

namespace Module\SmefManagement\App\Http\Controllers;

use Module\SmefManagement\App\Models\ApplicationFormType;
use Module\SmefManagement\App\Services\ApplicationFormTypeService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ApplicationFormTypeController extends Controller
{
    const VIEW_PATH = 'course_management::backend.application-form-types.';

    protected ApplicationFormTypeService $applicationFormTypeService;

    public function __construct(ApplicationFormTypeService $applicationFormTypeService)
    {
        $this->applicationFormTypeService = $applicationFormTypeService;
        //$this->authorizeResource(ApplicationFormType::class);
    }

    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index(): View
    {
        return \view(self::VIEW_PATH . 'browse');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create(): View
    {
        $applicationFormType = new ApplicationFormType();
        return \view(self::VIEW_PATH . 'edit-add', compact('applicationFormType'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $validatedData = $this->applicationFormTypeService->validator($request)->validate();

        try {
            $this->applicationFormTypeService->createApplicationFormType($validatedData);
        } catch (\Throwable $exception) {
            Log::debug($exception->getMessage());
            return back()->with([
                'message' => __('generic.something_wrong_try_again'),
                'alert-type' => 'error'
            ]);
        }

        return redirect()->route('course_management::admin.application-form-types.index')->with([
            'message' => __('generic.object_created_successfully', ['object' => 'Application form type']),
            'alert-type' => 'success'
        ]);
    }


    /**
     * Display the specified resource.
     *
     * @param ApplicationFormType $applicationFormType
     * @return View
     */
    public function show(ApplicationFormType $applicationFormType): View
    {
        return \view(self::VIEW_PATH . 'read', compact('applicationFormType'));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param ApplicationFormType $applicationFormType
     * @return View
     */
    public function edit(ApplicationFormType $applicationFormType): View
    {
        return \view(self::VIEW_PATH . 'edit-add', compact('applicationFormType'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param ApplicationFormType $applicationFormType
     * @return RedirectResponse
     */
    public function update(Request $request, ApplicationFormType $applicationFormType): RedirectResponse
    {
        //dd($request->all());
        $this->applicationFormTypeService->validator($request, $applicationFormType->id)->validate();

        try {
            $this->applicationFormTypeService->updateApplicationFormType($applicationFormType, $request);
        } catch (\Throwable $exception) {
            Log::debug($exception->getMessage());
            return back()->with([
                'message' => __('generic.something_wrong_try_again'),
                'alert-type' => 'error'
            ]);
        }

        return redirect()->route('course_management::admin.application-form-types.index')->with([
            'message' => __('generic.object_updated_successfully', ['object' => 'Application form type']),
            'alert-type' => 'success'
        ]);

    }


    /**
     * Remove the specified resource from storage.
     *
     * @param ApplicationFormType $applicationFormType
     * @return RedirectResponse
     */
    public function destroy(ApplicationFormType $applicationFormType): RedirectResponse
    {
        try {
            $this->applicationFormTypeService->deleteApplicationFormType($applicationFormType);
        } catch (\Throwable $exception) {
            if(!empty($exception->errorInfo[1]==1451)){
                return back()->with([
                    'message' => __('This application form type already assigned to publish course, Please delete published course'),
                    'alert-type' => 'error'
                ]);
            }
            Log::debug($exception->getMessage());
            return back()->with([
                'message' => __('generic.something_wrong_try_again'),
                'alert-type' => 'error'
            ]);
        }

        return back()->with([
            'message' => __('generic.object_deleted_successfully', ['object' => 'Application form type']),
            'alert-type' => 'success'
        ]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function getDatatable(Request $request): JsonResponse
    {
        return $this->applicationFormTypeService->getListDataForDatatable($request);
    }
}
