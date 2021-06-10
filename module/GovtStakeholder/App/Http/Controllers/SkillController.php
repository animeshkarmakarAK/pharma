<?php

namespace Module\GovtStakeholder\App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Module\GovtStakeholder\App\Models\Skill;
use Module\GovtStakeholder\App\Services\SkillService;

class SkillController extends BaseController
{
    const VIEW_PATH = 'backend.skills.';
    public SkillService $skillService;

    public function __construct(SkillService $skillService)
    {
        $this->skillService = $skillService;
        $this->authorizeResource(Skill::class);
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
        $skill = new Skill();
        return view(self::VIEW_PATH . 'edit-add', compact('skill'));
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
        $validatedData = $this->skillService->validator($request)->validate();

        try {
            $this->skillService->createSkill($validatedData);
        } catch (\Throwable $exception) {
            Log::debug($exception->getMessage());
            return back()->with([
                'message' => __('generic.something_wrong_try_again'),
                'alert-type' => 'error'
            ]);
        }
        return back()->with([
            'message' => __('generic.object_created_successfully', ['object' => 'Skill']),
            'alert-type' => 'success'
        ]);
    }

    /**
     * @param Skill $skill
     * @return View
     */
    public function show(Skill $skill): View
    {
        return view(self::VIEW_PATH . 'read', compact('skill'));
    }

    /**
     * @param Skill $skill
     * @return View
     */
    public function edit(Skill $skill): View
    {
        return view(self::VIEW_PATH . 'edit-add', compact('skill'));
    }

    /**
     * @param Request $request
     * @param Skill $skill
     * @return RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, Skill $skill): RedirectResponse
    {
        $validatedData = $this->skillService->validator($request)->validate();

        try {
            $this->skillService->updateSkill($skill, $validatedData);
        } catch (\Throwable $exception) {
            Log::debug($exception->getMessage());
            return back()->with([
                'message' => __('generic.something_wrong_try_again'),
                'alert-type' => 'error'
            ]);
        }

        return back()->with([
            'message' => __('generic.object_updated_successfully', ['object' => 'Skill']),
            'alert-type' => 'success'
        ]);
    }

    /**
     * @param Skill $skill
     * @return RedirectResponse
     */
    public function destroy(Skill $skill): RedirectResponse
    {
        try {
            $this->skillService->deleteSkill($skill);
        } catch (\Throwable $exception) {
            Log::debug($exception->getMessage());
            return back()->with([
                'message' => __('generic.something_wrong_try_again'),
                'alert-type' => 'error'
            ]);
        }

        return back()->with([
            'message' => __('generic.object_deleted_successfully', ['object' => 'Skill']),
            'alert-type' => 'success'
        ]);
    }


    public function getDatatable(Request $request): JsonResponse
    {
        return $this->skillService->getSkillLists($request);
    }
}
