<?php

namespace Module\GovtStakeholder\App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Module\GovtStakeholder\App\Models\Rank;
use Module\GovtStakeholder\App\Services\RankService;

class RankController extends BaseController
{
    const VIEW_PATH = 'backend.ranks.';
    public RankService $rankService;

    public function __construct(RankService $rankService)
    {
        $this->rankService = $rankService;
        $this->authorizeResource(Rank::class);
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
        $rank = new Rank();
        return view(self::VIEW_PATH . 'edit-add', compact('rank'));
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
        $validatedData = $this->rankService->validator($request)->validate();

        try {
            $this->rankService->createRank($validatedData);
        } catch (\Throwable $exception) {
            Log::debug($exception->getMessage());
            return back()->with([
                'message' => __('generic.something_wrong_try_again'),
                'alert-type' => 'error'
            ]);
        }
        return back()->with([
            'message' => __('generic.object_created_successfully', ['object' => 'Rank']),
            'alert-type' => 'success'
        ]);
    }

    /**
     * @param Rank $rank
     * @return View
     */
    public function show(Rank $rank): View
    {
        return view(self::VIEW_PATH . 'read', compact('rank'));
    }

    /**
     * @param Rank $rank
     * @return View
     */
    public function edit(Rank $rank): View
    {
        return view(self::VIEW_PATH . 'edit-add', compact('rank'));
    }

    /**
     * @param Request $request
     * @param Rank $rank
     * @return RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, Rank $rank): RedirectResponse
    {
        $validatedData = $this->rankService->validator($request)->validate();

        try {
            $this->rankService->updateRank($rank, $validatedData);
        } catch (\Throwable $exception) {
            Log::debug($exception->getMessage());
            return back()->with([
                'message' => __('generic.something_wrong_try_again'),
                'alert-type' => 'error'
            ]);
        }

        return back()->with([
            'message' => __('generic.object_updated_successfully', ['object' => 'Rank']),
            'alert-type' => 'success'
        ]);
    }

    /**
     * @param Rank $rank
     * @return RedirectResponse
     */
    public function destroy(Rank $rank): RedirectResponse
    {
        try {
            $this->rankService->deleteRank($rank);
        } catch (\Throwable $exception) {
            Log::debug($exception->getMessage());
            return back()->with([
                'message' => __('generic.something_wrong_try_again'),
                'alert-type' => 'error'
            ]);
        }

        return back()->with([
            'message' => __('generic.object_deleted_successfully', ['object' => 'Rank']),
            'alert-type' => 'success'
        ]);
    }


    public function getDatatable(Request $request): JsonResponse
    {
        return $this->rankService->getRankLists($request);
    }
}
