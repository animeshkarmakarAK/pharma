<?php

namespace Module\GovtStakeholder\App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Module\GovtStakeholder\App\Models\JobSector;
use Module\GovtStakeholder\App\Models\UpazilaJobStatistic;
use Module\GovtStakeholder\App\Services\UpazilaJobStatisticService;

class UpazilaJobStatisticController extends BaseController
{
    const VIEW_PATH = 'govt_stakeholder::backend.upazila-job-statistics.';
    public UpazilaJobStatisticService $upazilaJobStatisticService;

    public function __construct(UpazilaJobStatisticService $upazilaJobStatisticService)
    {
        $this->upazilaJobStatisticService = $upazilaJobStatisticService;
        $this->authorizeResource(UpazilaJobStatistic::class);
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
        $jobSectors = JobSector::active()->get();
        $upazilaJobStatistic = new UpazilaJobStatistic();
        return view(self::VIEW_PATH . 'edit-add', compact('upazilaJobStatistic','jobSectors'));
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
        $validatedData = $this->upazilaJobStatisticService->validator($request)->validate();

        try {
            $this->upazilaJobStatisticService->createUpazilaJobStatistic($validatedData);
        } catch (\Throwable $exception) {
            Log::debug($exception->getMessage());
            return back()->with([
                'message' => __('generic.something_wrong_try_again'),
                'alert-type' => 'error'
            ]);
        }
        return back()->with([
            'message' => __('generic.object_created_successfully', ['object' => 'Upazila Job Statistic']),
            'alert-type' => 'success'
        ]);
    }

    /**
     * @param UpazilaJobStatistic $upazilaJobStatistic
     * @return View
     */
    public function show(UpazilaJobStatistic $upazilaJobStatistic): View
    {
        return view(self::VIEW_PATH . 'read', compact('upazilaJobStatistic'));
    }

    /**
     * @param UpazilaJobStatistic $upazilaJobStatistic
     * @return View
     */
    public function edit(UpazilaJobStatistic $upazilaJobStatistic): View
    {
        $upazilaJobStatistics = UpazilaJobStatistic::where(['loc_upazila_id'=>$upazilaJobStatistic->loc_upazila_id, 'survey_date'=>$upazilaJobStatistic->survey_date])->get()->keyBy('job_sector_id');
        $jobSectors = JobSector::active()->get();
        return view(self::VIEW_PATH . 'edit-add', compact('upazilaJobStatistic','jobSectors', 'upazilaJobStatistics'));
    }

    /**
     * @param Request $request
     * @param UpazilaJobStatistic $upazilaJobStatistic
     * @return RedirectResponse
     * @throws ValidationException
     */
    public function update(Request $request, UpazilaJobStatistic $upazilaJobStatistic): RedirectResponse
    {
        $validatedData = $this->upazilaJobStatisticService->validator($request, $upazilaJobStatistic->id)->validate();

        //dd($validatedData);

        try {
            $this->upazilaJobStatisticService->updateUpazilaJobStatistic($upazilaJobStatistic, $validatedData);
        } catch (\Throwable $exception) {
            Log::debug($exception->getMessage());
            return back()->with([
                'message' => __('generic.something_wrong_try_again'),
                'alert-type' => 'error'
            ]);
        }

        return back()->with([
            'message' => __('generic.object_updated_successfully', ['object' => 'Upazila Job Statistic']),
            'alert-type' => 'success'
        ]);
    }

    /**
     * @param UpazilaJobStatistic $upazilaJobStatistic
     * @return RedirectResponse
     */
    public function destroy(UpazilaJobStatistic $upazilaJobStatistic): RedirectResponse
    {
        try {
            $this->upazilaJobStatisticService->deleteUpazilaJobStatistic($upazilaJobStatistic);
        } catch (\Throwable $exception) {
            Log::debug($exception->getMessage());
            return back()->with([
                'message' => __('generic.something_wrong_try_again'),
                'alert-type' => 'error'
            ]);
        }

        return back()->with([
            'message' => __('generic.object_deleted_successfully', ['object' => 'Upazila Job Statistic']),
            'alert-type' => 'success'
        ]);
    }


    public function getDatatable(Request $request): JsonResponse
    {
        return $this->upazilaJobStatisticService->getServiceLists($request);
    }
}
