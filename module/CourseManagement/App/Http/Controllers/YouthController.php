<?php

namespace Module\CourseManagement\App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Module\CourseManagement\App\Models\Institute;
use Module\CourseManagement\App\Models\Youth;
use Module\CourseManagement\App\Services\YouthService;
use Module\CourseManagement\App\Services\YouthManagementService;

class YouthController extends Controller
{
    const VIEW_PATH = 'course_management::backend.youths.';
    protected YouthService $youthService;

    public function __construct(YouthService $youthService)
    {
        $this->youthService = $youthService;
    }

    public function youthAcceptList() {
        $institutes = Institute::acl()->active()->get();
        $batches = \Module\CourseManagement\App\Models\Batch::acl()->get();
        return \view(self::VIEW_PATH . 'youth-accept-list', compact('institutes', 'batches'));
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function getAcceptDatatable(Request $request): JsonResponse
    {
        return $this->youthService->getListForAcceptListDatatable($request);
    }
}
