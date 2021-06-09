<?php

namespace Module\CourseManagement\App\Http\Controllers;

use Module\CourseManagement\App\Models\Batch;
use Module\CourseManagement\App\Services\YouthBatchService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class YouthBatchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    const VIEW_PATH = 'course_management::backend.youth-batches.';
    public YouthBatchService $youthBatchService;

    public function __construct(YouthBatchService $youthBatchService)
    {
        $this->youthBatchService = $youthBatchService;
    }

    public function index(int $id)
    {
        $batch = Batch::findOrFail($id);

        return \view(self::VIEW_PATH . 'browse', compact('batch'));
    }

    public function getDatatable(Request $request, int $id): JsonResponse
    {
        return $this->youthBatchService->getYouthBatchLists($request, $id);
    }
}
