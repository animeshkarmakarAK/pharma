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
use Module\GovtStakeholder\App\Models\OrganizationUnit;
use Module\GovtStakeholder\App\Models\OrganizationUnitStatistic;
use Module\GovtStakeholder\App\Services\OrganizationUnitStatisticService;

class OrganizationUnitStatisticController extends BaseController
{
    const VIEW_PATH = 'govt_stakeholder::backend.organization-unit-statistics.';
    public  OrganizationUnitStatisticService $organizationUnitStatisticService;

    public function __construct(OrganizationUnitStatisticService $organizationUnitStatisticService)
    {
        $this->organizationUnitStatisticService = $organizationUnitStatisticService;
//        $this->authorizeResource(OrganizationUnitStatisticPolicy::class);
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
        $organizationUnitStatistic = new OrganizationUnitStatistic();
        $organizationUnits = OrganizationUnit::get();
        return view(self::VIEW_PATH . 'edit-add', compact(['organizationUnitStatistic', 'organizationUnits']));
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
        $validatedData = $this->organizationUnitStatisticService->validator($request)->validate();

        $organizationUnitStatistic = OrganizationUnitStatistic::where([['survey_date',$validatedData['survey_date']]])->first();

        if($organizationUnitStatistic){
            return back()->with([
                'message' => 'Organization Unit Statistics for this month is already exist',
                'alert-type' => 'error'
            ]);
        }
        try {
            $this->organizationUnitStatisticService->createOrganizationUnitStatistic($validatedData);
        } catch (\Throwable $exception) {
            Log::debug($exception->getMessage());
            return back()->with([
                'message' => __('generic.something_wrong_try_again'),
                'alert-type' => 'error'
            ]);
        }
        return back()->with([
            'message' => __('generic.object_created_successfully', ['object' => 'Organization Unit Statistic']),
            'alert-type' => 'success'
        ]);
    }

    /**
     * @param OccupationWiseStatistic $occupationWiseStatistic
     * @return View
     */
    public function show(OccupationWiseStatistic $occupationWiseStatistic): View
    {
        return view(self::VIEW_PATH . 'read', compact('occupationWiseStatistic'));
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
            return back()->with([
                'message' => __('generic.something_wrong_try_again'),
                'alert-type' => 'error'
            ]);
        }

        return back()->with([
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
        return $this->organizationUnitStatisticService->getServiceLists($request);
    }
}
