<?php

namespace Module\GovtStakeholder\App\Services;

use App\Helpers\Classes\AuthHelper;
use App\Helpers\Classes\DatatableHelper;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Module\GovtStakeholder\App\Models\Service;
use Yajra\DataTables\Facades\DataTables;

class ServiceService
{
    public function createService(array $data): Service
    {
        return Service::create($data);
    }

    public function updateService(Service $service, array $data): Service
    {
        $service->fill($data);
        $service->save();

        return $service;
    }

    public function deleteService(Service $service): void
    {
        $service->delete();
    }

    public function validator(Request $request): Validator
    {
        $rules = [
            'title_en' => [
                'required',
                'string',
                'max:191',
            ],
            'title_bn' => [
                'required',
                'string',
                'max: 191',
            ],
            'organization_id' => [
                'required',
                'int',
                'exists:organizations,id',
            ],
        ];
        return \Illuminate\Support\Facades\Validator::make($request->all(), $rules);
    }

    public function getServiceLists(Request $request): JsonResponse
    {
        $authUser = AuthHelper::getAuthUser();
        /** @var Builder|Service $servicees */
        $servicees = Service::acl()->select(
            [
                'services.id as id',
                'services.title_en',
                'services.title_bn',
                'organizations.title_en as organization_title_en',
                'services.row_status',
                'services.created_at',
                'services.updated_at',
            ]
        );
        $servicees->join('organizations', 'services.organization_id', '=', 'organizations.id');

        return DataTables::eloquent($servicees)
            ->addColumn('action', DatatableHelper::getActionButtonBlock(static function (Service $service) use ($authUser) {
                $str = '';
                if ($authUser->can('view', $service)) {
                    $str .= '<a href="' . route('govt_stakeholder::admin.services.show', $service->id) . '" class="btn btn-outline-info btn-sm"> <i class="fas fa-eye"></i> Read </a>';
                }
                if ($authUser->can('update', $service)) {
                    $str .= '<a href="' . route('govt_stakeholder::admin.services.edit', $service->id) . '" class="btn btn-outline-warning btn-sm"> <i class="fas fa-edit"></i> Edit </a>';
                }
                if ($authUser->can('delete', $service)) {
                    $str .= '<a href="#" data-action="' . route('govt_stakeholder::admin.services.destroy', $service->id) . '" class="btn btn-outline-danger btn-sm delete"> <i class="fas fa-trash"></i> Delete</a>';
                }

                return $str;
            }))
            ->rawColumns(['action'])
            ->toJson();
    }


}
