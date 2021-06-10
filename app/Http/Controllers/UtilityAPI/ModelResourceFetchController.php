<?php

namespace App\Http\Controllers\UtilityAPI;

use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use Module\CourseManagement\App\Services\WebAPI\ModelResourceService;

class ModelResourceFetchController extends BaseController
{
    const FILTER_MAPS = [
        'contain' => 'LIKE',
        'equal' => '=',
        'not-equal' => '!='
    ];

    /**
     * @throws \App\Exceptions\CustomException
     */
    public function modelResources(Request $request): \Illuminate\Http\JsonResponse
    {
        $modelResService = new ModelResourceService();
        $modelResService->bootstrap($request);

        $query = $modelResService->model->query();

        $selectableColumns = $modelResService->getSelectableColumns($query);
        $query->select($selectableColumns);
        $modelResService->applyFilters($query);
        $modelResService->applySearch($query, $request);
        $modelResService->applyScopes($query);

        return $modelResService->getResults($query, $request);
    }
}
