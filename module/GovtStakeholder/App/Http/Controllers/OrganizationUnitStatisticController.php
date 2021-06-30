<?php

namespace Module\GovtStakeholder\App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Module\GovtStakeholder\App\Models\OrganizationUnit;
use Module\GovtStakeholder\App\Models\organizationUnitStatistic;
use Module\GovtStakeholder\App\Services\OrganizationUnitStatisticService;

class OrganizationUnitStatisticController extends BaseController
{
    const VIEW_PATH = 'govt_stakeholder::backend.organization-unit-statistics.';
    public OrganizationUnitStatisticService $organizationUnitStatisticService;

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
        $organizationUnits = OrganizationUnit::get();
        $organizationUnitStatistic = new OrganizationUnitStatistic();
        return view(self::VIEW_PATH . 'edit-add', compact('organizationUnitStatistic', 'organizationUnits'));
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

        $organizationUnitStatistic = organizationUnitStatistic::where([['survey_date', $validatedData['survey_date']]])->first();

        if ($organizationUnitStatistic) {
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


    public function show(OrganizationUnitStatistic $organizationUnitStatistic): View
    {
        return view(self::VIEW_PATH . 'read', compact('organizationUnitStatistic'));
    }

    /**
     * @param organizationUnitStatistic $organizationUnitStatistic
     * @return View
     */
    public function edit(OrganizationUnitStatistic $organizationUnitStatistic): View
    {
        $organizationUnitStatistics = OrganizationUnitStatistic::where(['survey_date' => $organizationUnitStatistic->survey_date])->get()->keyBy('organization_unit_id');

        $organizationUnits = OrganizationUnit::get();
        return view(self::VIEW_PATH . 'edit-add', compact('organizationUnitStatistic', 'organizationUnits', 'organizationUnitStatistics'));
    }


    public function update(Request $request, OrganizationUnitStatistic $organizationUnitStatistic): RedirectResponse
    {
        $validatedData = $this->organizationUnitStatisticService->validator($request, $organizationUnitStatistic->id)->validate();

        try {
            $this->organizationUnitStatisticService->updateOrganizationUnitStatistic($organizationUnitStatistic, $validatedData);
        } catch (\Throwable $exception) {
            Log::debug($exception->getMessage());
            return back()->withInput([
                'message' => __('generic.something_wrong_try_again'),
                'alert-type' => 'error'
            ]);
        }

        return back()->with([
            'message' => __('generic.object_updated_successfully', ['object' => 'Organization Unit Statistic']),
            'alert-type' => 'success'
        ]);
    }

    /**
     * @param organizationUnitStatistic $organizationUnitStatistic
     * @return RedirectResponse
     */

    public function destroy(OrganizationUnitStatistic $organizationUnitStatistic): RedirectResponse
    {
        try {
            $organizationUnitStatistic->delete();
        } catch (\Throwable $exception) {
            Log::debug($exception->getMessage());
            return back()->withInput([
                'message' => __('generic.something_wrong_try_again'),
                'alert-type' => 'error'
            ]);
        }

        return back()->with([
            'message' => __('generic.object_deleted_successfully', ['object' => 'Organization Unit Statistic']),
            'alert-type' => 'success'
        ]);
    }


    public function getDatatable(Request $request): JsonResponse
    {
        return $this->organizationUnitStatisticService->getServiceLists($request);
    }

    public function vacantStatisticsOfOrganizationUnit(Request $request)
    {
        return $this->organizationUnitStatisticService->getStatistics($request);
    }

    public function unemploymentStatisticOccupationWise(Request $request)
    {
        return $this->organizationUnitStatisticService->unemploymentStatistic($request);
    }

}
