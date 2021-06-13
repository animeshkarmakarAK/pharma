<?php

namespace Module\GovtStakeholder\App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Module\GovtStakeholder\App\Models\Occupation;
use Module\GovtStakeholder\App\Services\OccupationService;

/**
 * Class OccupationController
 * @package App\Http\Controllers
 *
 */
class OccupationController extends BaseController
{
    const VIEW_PATH = 'govt_stakeholder::backend.occupations.';

    protected OccupationService $occupationService;

    public function __construct(OccupationService $occupationService)
    {
        $this->occupationService = $occupationService;
        $this->authorizeResource(Occupation::class);
    }

    public function index(): View
    {
        return \view(self::VIEW_PATH . 'browse');
    }

    public function create(): View
    {
        $occupation = new Occupation();
        return \view(self::VIEW_PATH . 'edit-add', compact('occupation'));
    }

    public function store(Request $request): RedirectResponse
    {
        $occupationValidatedData = $this->occupationService->validator($request)->validate();

        try {
            $this->occupationService->createOccupation($occupationValidatedData);
        } catch (\Throwable $exception) {
            Log::debug($exception->getMessage());
            return back()->with([
                'message' => __('generic.something_wrong_try_again'),
                'alert-type' => 'error'
            ]);
        }

        return back()->with([
            'message' => __('generic.object_created_successfully', ['object' => 'Occupation']),
            'alert-type' => 'success'
        ]);
    }

    public function edit(Request $request, Occupation $occupation): View
    {
        //dd($occupation);
        return \view(self::VIEW_PATH . 'edit-add', compact('occupation'));
    }

    public function show(Occupation $occupation): View
    {
        return \view(self::VIEW_PATH . 'read', compact('occupation'));
    }


    public function update(Request $request, Occupation $occupation): RedirectResponse
    {

        $validatedData = $this->occupationService->validator($request, $occupation->id)->validate();
        try {
            $this->occupationService->updateOccupation($occupation, $validatedData);
        } catch (\Throwable $exception) {
            Log::debug($exception->getMessage());
            return back()->with([
                'message' => __('generic.something_wrong_try_again'),
                'alert-type' => 'error'
            ]);
        }

        return back()->with([
            'message' => __('generic.object_updated_successfully', ['object' => 'Occupation']),
            'alert-type' => 'success'
        ]);
    }


    public function destroy(Occupation $occupation): RedirectResponse
    {
        try {
            $this->occupationService->deleteOccupation($occupation);
        } catch (\Throwable $exception) {
            Log::debug($exception->getMessage());
            return back()->with([
                'message' => __('generic.something_wrong_try_again'),
                'alert-type' => 'error'
            ]);
        }

        return back()->with([
            'message' => __('generic.object_deleted_successfully', ['object' => 'occupation']),
            'alert-type' => 'success'
        ]);
    }


    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function getDatatable(Request $request): JsonResponse
    {
        return $this->occupationService->getListDataForDatatable($request);
    }


}
