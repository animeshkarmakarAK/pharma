<?php

namespace Module\CourseManagement\App\Http\Controllers;

use Module\CourseManagement\App\Repositories\InstituteRepository;
use Module\CourseManagement\App\Services\InstituteService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ExampleInstituteController extends Controller
{
    const VIEW_PATH = 'course_management::backend.institutes.';

    public InstituteService $instituteService;
    public InstituteRepository $instituteRepository;

    public function __construct(InstituteRepository $instituteRepository, InstituteService $instituteService)
    {
        $this->instituteRepository = $instituteRepository;
        $this->instituteService = $instituteService;
    }
    public function index(): View
    {
        // check authorization

        return \view(self::VIEW_PATH . 'browse');
    }

    public function create(): View
    {
        return \view(self::VIEW_PATH . 'edit-add');
    }

    public function store(Request $request): JsonResponse
    {
        $model = $this->instituteRepository->getModel();

        // check authorization
        $this->authorize('add', $model);


        // check validation
        $this->instituteService->validator($request->all())->validate();

        try {
            // creation logic goes here.
            $this->instituteService->createInstitute($request->all());
        } catch (\Throwable $throwable) {
            return response()->json([]);
        }

        return response()->json([]);
    }

    public function edit(Request $request, int $id): View
    {
        // check authorization

        return \view(self::VIEW_PATH . 'edit-add');
    }

    public function update(Request $request, int $id): JsonResponse
    {
        // check authorization
        // check validation

        try {
            // creation login goes here.
        } catch (\Throwable $throwable) {
            return response()->json([]);
        }

        return response()->json([]);
    }

    public function destroy(int $id): RedirectResponse
    {
        // check authorization

        try {
            // creation login goes here.
        } catch (\Throwable $throwable) {
            return redirect()->back()->with([]);
        }

        return redirect()->back()->with([]);
    }

    public function getDatatable(Request $request): JsonResponse
    {
        // check authorization

        try {
            // creation login goes here.
            $this->instituteService->getListDataForDatatable($request);
        } catch (\Throwable $throwable) {
            return response()->json([]);
        }

        return response()->json([]);
    }
}
