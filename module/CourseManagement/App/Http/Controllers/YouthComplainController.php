<?php

namespace Module\CourseManagement\App\Http\Controllers;

use App\Helpers\Classes\AuthHelper;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Module\CourseManagement\App\Models\YouthComplainToOrganization;
use Module\CourseManagement\App\Services\YouthComplainService;

class YouthComplainController extends Controller
{

    const VIEW_PATH = 'course_management::backend.complains-list.';
    protected YouthComplainService $youthComplainService;

    public function __construct(YouthComplainService $youthComplainService)
    {
        $this->youthComplainService = $youthComplainService;
        $this->authorizeResource(YouthComplainToOrganization::class);
    }

    public function index()
    {
        return view(self::VIEW_PATH . 'youth-complains');
    }

    public function getYouthComplainList(Request $request): \Illuminate\Http\JsonResponse
    {
        return $this->youthComplainService->getYouthComplainListsDatatable($request);
    }

    public function show(YouthComplainToOrganization $youthComplainToOrganization)
    {
        $authUser = AuthHelper::getAuthUser();

        if (!empty($authUser->institute_id) && $authUser->institute_id != $youthComplainToOrganization->institute_id) {
            return redirect()->route('course_management::admin.youth-complains')->with([
                'message' => "Something is wrong",
                'alert-type' => "error"
            ]);
        }

        if(!empty($authUser->institute_id)){
            $youthComplainToOrganization->read_at = Carbon::now();
            $youthComplainToOrganization->save();
        }
        
        return view(self::VIEW_PATH . 'youth-single-complain', compact('youthComplainToOrganization'));
    }
}
