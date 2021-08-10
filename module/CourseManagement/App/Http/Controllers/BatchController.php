<?php

namespace Module\CourseManagement\App\Http\Controllers;

use Module\CourseManagement\App\Models\Batch;
use Module\CourseManagement\App\Services\BatchService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class BatchController extends Controller
{
    const VIEW_PATH = 'course_management::backend.batches.';
    public BatchService $batchService;

    public function __construct(BatchService $batchService)
    {
        $this->batchService = $batchService;
        $this->authorizeResource(Batch::class);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|View|\Illuminate\Http\Response
     */
    public function index()
    {
        return \view(self::VIEW_PATH . 'browse');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|View|\Illuminate\Http\Response
     */
    public function create()
    {
        return \view(self::VIEW_PATH . 'edit-add')->with([
            'batch' => new Batch(),
        ]);

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
        $this->batchService->validator($request)->validate();

        try {
            $this->batchService->createBatch($request->all());
        } catch (\Throwable $exception) {
            Log::debug($exception->getMessage());
            Log::debug($exception->getTraceAsString());
            return back()->with([
                'message' => __('generic.something_wrong_try_again'),
                'alert-type' => 'error'
            ]);
        }

        return redirect()->route('course_management::admin.batches.index')->with([
            'message' => __('generic.object_created_successfully', ['object' => 'Batch']),
            'alert-type' => 'success'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param \Module\CourseManagement\App\Models\Batch $trainingBatch
     * @return \Illuminate\Http\Response
     */
    public function show(Batch $batch): View
    {
        return \view(self::VIEW_PATH . 'read', compact('batch'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \Module\CourseManagement\App\Models\Batch $trainingBatch
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function edit(Batch $batch): View
    {
        return \view(self::VIEW_PATH . 'edit-add')->with([
            'batch' => $batch,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Module\CourseManagement\App\Models\Batch $trainingBatch
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, Batch $batch): RedirectResponse
    {
        $this->batchService->validator($request, $batch->id)->validate();

        try {
            $this->batchService->updateBatch($batch, $request->all());
        } catch (\Throwable $exception) {
            Log::debug($exception->getMessage());
            return back()->with([
                'message' => __('generic.something_wrong_try_again'),
                'alert-type' => 'error'
            ]);
        }

        return back()->with([
            'message' => __('generic.object_updated_successfully', ['object' => 'Batch updated']),
            'alert-type' => 'success'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Batch $batch
     * @return RedirectResponse
     */
    public function destroy(Batch $batch): RedirectResponse
    {
        try {
            $this->batchService->deleteBatch($batch);
        } catch (\Throwable $exception) {
            Log::debug($exception->getMessage());
            return back()->with([
                'message' => __('generic.something_wrong_try_again'),
                'alert-type' => 'error'
            ]);
        }

        return back()->with([
            'message' => __('generic.object_deleted_successfully', ['object' => 'Batch']),
            'alert-type' => 'success'
        ]);
    }

    public function getDatatable(Request $request): JsonResponse
    {
        return $this->batchService->getBatchLists($request);

    }

    public function checkCode(Request $request): JsonResponse
    {
        $batch = Batch::where(['code' => $request->code])->first();
        if ($batch == null) {
            return response()->json(true);
        } else {
            return response()->json('Code already in use!');
        }
    }
}
