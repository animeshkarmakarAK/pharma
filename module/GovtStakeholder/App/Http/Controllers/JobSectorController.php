<?php

namespace Module\GovtStakeholder\App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Module\GovtStakeholder\App\Models\JobSector;
use Module\GovtStakeholder\App\Services\JobSectorService;

class JobSectorController extends BaseController
{
    const VIEW_PATH = 'backend.job-sectors.';
    public JobSectorService $jobSectorService;

    public function __construct(JobSectorService $jobSectorService)
    {
        $this->jobSectorService = $jobSectorService;
        $this->authorizeResource(JobSector::class);
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
        $jobSector = new JobSector();
        return view(self::VIEW_PATH . 'edit-add', compact('jobSector'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return RedirectResponse
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $validatedData = $this->jobSectorService->validator($request)->validate();

        try {
            $this->jobSectorService->createJobSector($validatedData);
        } catch (\Throwable $exception) {
            Log::debug($exception->getMessage());
            return back()->with([
                'message' => __('generic.something_wrong_try_again'),
                'alert-type' => 'error'
            ]);
        }
        return back()->with([
            'message' => __('generic.object_created_successfully', ['object' => 'Job Sector']),
            'alert-type' => 'success'
        ]);
    }

    /**
     * @param JobSector $jobSector
     * @return View
     */
    public function show(JobSector $jobSector): View
    {
        return view(self::VIEW_PATH . 'read', compact('jobSector'));
    }

    /**
     * @param JobSector $jobSector
     * @return View
     */
    public function edit(JobSector $jobSector): View
    {
        return view(self::VIEW_PATH . 'edit-add', compact('jobSector'));
    }

    /**
     * @param Request $request
     * @param JobSector $jobSector
     * @return RedirectResponse
     * @throws ValidationException
     */
    public function update(Request $request, JobSector $jobSector): RedirectResponse
    {
        $validatedData = $this->jobSectorService->validator($request)->validate();

        try {
            $this->jobSectorService->updateJobSector($jobSector, $validatedData);
        } catch (\Throwable $exception) {
            Log::debug($exception->getMessage());
            return back()->with([
                'message' => __('generic.something_wrong_try_again'),
                'alert-type' => 'error'
            ]);
        }

        return back()->with([
            'message' => __('generic.object_updated_successfully', ['object' => 'Job Sector']),
            'alert-type' => 'success'
        ]);
    }

    /**
     * @param JobSector $jobSector
     * @return RedirectResponse
     */
    public function destroy(JobSector $jobSector): RedirectResponse
    {
        try {
            $this->jobSectorService->deleteJobSector($jobSector);
        } catch (\Throwable $exception) {
            Log::debug($exception->getMessage());
            return back()->with([
                'message' => __('generic.something_wrong_try_again'),
                'alert-type' => 'error'
            ]);
        }

        return back()->with([
            'message' => __('generic.object_deleted_successfully', ['object' => 'Job Sector']),
            'alert-type' => 'success'
        ]);
    }


    public function getDatatable(Request $request): JsonResponse
    {
        return $this->jobSectorService->getServiceLists($request);
    }
}
