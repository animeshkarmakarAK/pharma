<?php

namespace Module\GovtStakeholder\App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Module\GovtStakeholder\App\Models\Occupation;
use Module\GovtStakeholder\App\Models\OccupationWiseStatistic;
use Module\GovtStakeholder\App\Services\OccupationWiseStatisticService;

class OccupationWiseStatisticController extends BaseController
{
    const VIEW_PATH = 'govt_stakeholder::backend.occupation-wise-statistics.';
    public OccupationWiseStatisticService $occupationWiseStatisticService;

    public function __construct(OccupationWiseStatisticService $occupationWiseStatisticService)
    {
        $this->occupationWiseStatisticService = $occupationWiseStatisticService;
        $this->authorizeResource(OccupationWiseStatistic::class);
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
        $occupationWiseStatistic = new OccupationWiseStatistic();
        $occupations = Occupation::select('id', 'title_en')->get();
        return view(self::VIEW_PATH . 'edit-add', compact(['occupationWiseStatistic','occupations']));
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
        $validatedData = $this->occupationWiseStatisticService->validator($request)->validate();
        try {
            $this->occupationWiseStatisticService->createOccupationWiseStatistic($validatedData);
        } catch (\Throwable $exception) {
            Log::debug($exception->getMessage());
            return back()->withInput([
                'message' => __('generic.something_wrong_try_again'),
                'alert-type' => 'error'
            ]);
        }

        return redirect()->route('govt_stakeholder::admin.occupation-wise-statistics.index')->with([
            'message' => __('generic.object_created_successfully', ['object' => 'Occupation Wise Statistic']),
            'alert-type' => 'success'
        ]);
    }

    /**
     * @param OccupationWiseStatistic $occupationWiseStatistic
     * @return View
     */
    public function show(OccupationWiseStatistic $occupationWiseStatistic): View
    {
        $occupationWiseStatistics = OccupationWiseStatistic::where([['survey_date',$occupationWiseStatistic->survey_date],['institute_id',$occupationWiseStatistic->institute_id]])->get()->keyBy('occupation_id');
        return view(self::VIEW_PATH . 'read', compact(['occupationWiseStatistic','occupationWiseStatistics']));
    }

    /**
     * @param OccupationWiseStatistic $occupationWiseStatistic
     * @return View
     */
    public function edit(OccupationWiseStatistic $occupationWiseStatistic): View
    {
        $occupations=Occupation::all();
        $occupationWiseStatistics = OccupationWiseStatistic::where([['survey_date',$occupationWiseStatistic->survey_date],['institute_id',$occupationWiseStatistic->institute_id]])->get()->keyBy('occupation_id');
        return view(self::VIEW_PATH . 'edit-add', compact(['occupations','occupationWiseStatistics','occupationWiseStatistic']));
    }

    /**
     * @param Request $request
     * @param OccupationWiseStatistic $occupationWiseStatistic
     * @return RedirectResponse
     * @throws ValidationException
     */
    public function update(Request $request, OccupationWiseStatistic $occupationWiseStatistic): RedirectResponse
    {
        $validatedData = $this->occupationWiseStatisticService->validator($request, $occupationWiseStatistic->id)->validate();

        try {
            $this->occupationWiseStatisticService->updateOccupationWiseStatistic($occupationWiseStatistic, $validatedData);
        } catch (\Throwable $exception) {
            Log::debug($exception->getMessage());
            return back()->withInput([
                'message' => __('generic.something_wrong_try_again'),
                'alert-type' => 'error'
            ]);
        }

        return redirect()->route('govt_stakeholder::admin.occupation-wise-statistics.index')->with([
            'message' => __('generic.object_updated_successfully', ['object' => 'Occupation Wise Statistic']),
            'alert-type' => 'success'
        ]);
    }

    /**
     * @param OccupationWiseStatistic $occupationWiseStatistic
     * @return RedirectResponse
     */
    public function destroy(OccupationWiseStatistic $occupationWiseStatistic): RedirectResponse
    {
        try {
            $this->occupationWiseStatisticService->deleteOccupationWiseStatistic($occupationWiseStatistic);
        } catch (\Throwable $exception) {
            Log::debug($exception->getMessage());
            return back()->with([
                'message' => __('generic.something_wrong_try_again'),
                'alert-type' => 'error'
            ]);
        }

        return back()->with([
            'message' => __('generic.object_deleted_successfully', ['object' => 'Occupation Wise Statistic']),
            'alert-type' => 'success'
        ]);
    }


    public function getDatatable(Request $request): JsonResponse
    {
        return $this->occupationWiseStatisticService->getServiceLists($request);
    }
}
