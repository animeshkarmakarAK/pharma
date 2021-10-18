<?php

namespace Module\CourseManagement\App\Http\Controllers;

use App\Helpers\Classes\AuthHelper;
use Illuminate\Http\Request;
use Module\CourseManagement\App\Services\YouthComplainService;

class YouthComplainController extends Controller
{

    const VIEW_PATH = 'course_management::backend.complains-list.';
    protected YouthComplainService $youthComplainService;

    public function __construct(YouthComplainService $youthComplainService)
    {
        $this->youthComplainService = $youthComplainService;
    }

    public function youthComplainIndex()
    {
        $authUser = AuthHelper::getAuthUser();
        return view(self::VIEW_PATH.'youth-complains');
    }
    public function getYouthComplainList(Request $request){
        //dd($request->all());
        return $this->youthComplainService->getYouthComplainListsDatatable($request);
    }
    public function getOrganizationComplainList(){}
}
