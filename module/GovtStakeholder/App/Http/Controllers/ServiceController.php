<?php

namespace Module\GovtStakeholder\App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Module\GovtStakeholder\App\Models\Service;
use Module\GovtStakeholder\App\Services\ServiceService;

class ServiceController extends BaseController
{
    const VIEW_PATH = 'backend.services.';
    public ServiceService $serviceService;

    public function __construct(ServiceService $serviceService)
    {
        $this->serviceService = $serviceService;
        $this->authorizeResource(Service::class);
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
        $service = new Service();
        return view(self::VIEW_PATH . 'edit-add', compact('service'));
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
        $validatedData = $this->serviceService->validator($request)->validate();

        try {
            $this->serviceService->createService($validatedData);
        } catch (\Throwable $exception) {
            Log::debug($exception->getMessage());
            return back()->with([
                'message' => __('generic.something_wrong_try_again'),
                'alert-type' => 'error'
            ]);
        }
        return back()->with([
            'message' => __('generic.object_created_successfully', ['object' => 'Service']),
            'alert-type' => 'success'
        ]);
    }

    /**
     * @param Service $service
     * @return View
     */
    public function show(Service $service): View
    {
        return view(self::VIEW_PATH . 'read', compact('service'));
    }

    /**
     * @param Service $service
     * @return View
     */
    public function edit(Service $service): View
    {
        return view(self::VIEW_PATH . 'edit-add', compact('service'));
    }

    /**
     * @param Request $request
     * @param Service $service
     * @return RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, Service $service): RedirectResponse
    {
        $validatedData = $this->serviceService->validator($request)->validate();

        try {
            $this->serviceService->updateService($service, $validatedData);
        } catch (\Throwable $exception) {
            Log::debug($exception->getMessage());
            return back()->with([
                'message' => __('generic.something_wrong_try_again'),
                'alert-type' => 'error'
            ]);
        }

        return back()->with([
            'message' => __('generic.object_updated_successfully', ['object' => 'Service']),
            'alert-type' => 'success'
        ]);
    }

    /**
     * @param Service $service
     * @return RedirectResponse
     */
    public function destroy(Service $service): RedirectResponse
    {
        try {
            $this->serviceService->deleteService($service);
        } catch (\Throwable $exception) {
            Log::debug($exception->getMessage());
            return back()->with([
                'message' => __('generic.something_wrong_try_again'),
                'alert-type' => 'error'
            ]);
        }

        return back()->with([
            'message' => __('generic.object_deleted_successfully', ['object' => 'Service']),
            'alert-type' => 'success'
        ]);
    }


    public function getDatatable(Request $request): JsonResponse
    {
        return $this->serviceService->getServiceLists($request);
    }
}
