<?php

namespace Module\GovtStakeholder\App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Module\GovtStakeholder\App\Models\RankType;
use Module\GovtStakeholder\App\Services\RankTypeService;

class RankTypeController extends BaseController
{
    const VIEW_PATH = 'backend.rank-types.';
    public RankTypeService $rankTypeService;

    public function __construct(RankTypeService $rankTypeService)
    {
        $this->rankTypeService = $rankTypeService;
        $this->authorizeResource(RankType::class);
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
        $rankType = new RankType();
        return view(self::VIEW_PATH . 'edit-add', compact('rankType'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $validatedData = $this->rankTypeService->validator($request)->validate();

        try {
            $this->rankTypeService->createRankType($validatedData);
        } catch (\Throwable $exception) {
            Log::debug($exception->getMessage());
            return back()->with([
                'message' => __('generic.something_wrong_try_again'),
                'alert-type' => 'error'
            ]);
        }
        return back()->with([
            'message' => __('generic.object_created_successfully', ['object' => 'RankType']),
            'alert-type' => 'success'
        ]);
    }

    /**
     * @param RankType $rankType
     * @return View
     */
    public function show(RankType $rankType): View
    {
        return view(self::VIEW_PATH . 'read', compact('rankType'));
    }

    /**
     * @param RankType $rankType
     * @return View
     */
    public function edit(RankType $rankType): View
    {
        return view(self::VIEW_PATH . 'edit-add', compact('rankType'));
    }

    /**
     * @param Request $request
     * @param RankType $rankType
     * @return RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, RankType $rankType): RedirectResponse
    {
        $validatedData = $this->rankTypeService->validator($request)->validate();

        try {
            $this->rankTypeService->updateRankType($rankType, $validatedData);
        } catch (\Throwable $exception) {
            Log::debug($exception->getMessage());
            return back()->with([
                'message' => __('generic.something_wrong_try_again'),
                'alert-type' => 'error'
            ]);
        }

        return back()->with([
            'message' => __('generic.object_updated_successfully', ['object' => 'Rank Type']),
            'alert-type' => 'success'
        ]);
    }

    /**
     * @param RankType $rankType
     * @return RedirectResponse
     */
    public function destroy(RankType $rankType): RedirectResponse
    {
        try {
            $this->rankTypeService->deleteRankType($rankType);
        } catch (\Throwable $exception) {
            Log::debug($exception->getMessage());
            return back()->with([
                'message' => __('generic.something_wrong_try_again'),
                'alert-type' => 'error'
            ]);
        }

        return back()->with([
            'message' => __('generic.object_deleted_successfully', ['object' => 'Rank Type']),
            'alert-type' => 'success'
        ]);
    }


    public function getDatatable(Request $request): JsonResponse
    {
        return $this->rankTypeService->getRankTypeLists($request);
    }
}
