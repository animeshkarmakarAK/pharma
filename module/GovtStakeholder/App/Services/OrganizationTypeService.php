<?php

namespace Module\GovtStakeholder\App\Services;

use App\Helpers\Classes\AuthHelper;
use App\Helpers\Classes\DatatableHelper;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Module\GovtStakeholder\App\Models\OrganizationType;
use Yajra\DataTables\Facades\DataTables;

class OrganizationTypeService
{
    public function createOrganizationType(array $data): OrganizationType
    {
        return OrganizationType::create($data);
    }

    public function validator(Request $request, $id = null): Validator
    {
        $rules = [
            'title_en' => [
                'max:191',
                'required',
                'string'
            ],
            'title_bn' => [
                'required',
                'string',
                'max:191',
            ],
            'is_government' => [
                'required',
                'boolean'
            ],
            'row_status' => [
                'required_if:' . $id . ',!=,null',
            ],
        ];
        return \Illuminate\Support\Facades\Validator::make($request->all(), $rules);
    }

    public function updateOrganizationType(OrganizationType $organizationType, array $data): bool
    {
        return $organizationType->update($data);
    }

    public function getListDataForDatatable(Request $request): JsonResponse
    {
        $authUser = AuthHelper::getAuthUser();

        /** @var Builder|OrganizationType $organizationType */
        $organizationType = OrganizationType::select([
            'organization_types.id as id',
            'organization_types.title_en',
            'organization_types.title_bn',
            'organization_types.is_government',
            'organization_types.row_status'
        ]);


        return DataTables::eloquent($organizationType)
            ->addColumn('action', DatatableHelper::getActionButtonBlock(static function (OrganizationType $organizationType) use ($authUser) {
                $str = '';
                if ($authUser->can('view', $organizationType)) {
                    $str .= '<a href="' . route('admin.organization-types.show', $organizationType->id) . '" class="btn btn-outline-info btn-sm"> <i class="fas fa-eye"></i> ' . __('generic.read_button_label') . '</a>';
                }
                if ($authUser->can('update', $organizationType)) {
                    $str .= '<a href="' . route('admin.organization-types.edit', $organizationType->id) . '" class="btn btn-outline-warning btn-sm"> <i class="fas fa-edit"></i> ' . __('generic.edit_button_label') . ' </a>';
                }
                if ($authUser->can('delete', $organizationType)) {
                    $str .= '<a href="#" data-action="' . route('admin.organization-types.destroy', $organizationType->id) . '" class="btn btn-outline-danger btn-sm delete"> <i class="fas fa-trash"></i> ' . __('generic.delete_button_label') . '</a>';
                }
                return $str;
            }))
            ->editColumn('is_government', function (OrganizationType $organizationType) {
                return $organizationType->is_government ? 'Government' : 'Non Government';
            })
            ->rawColumns(['action'])
            ->toJson();
        //TODO:row_status will be added later
    }

    public function deleteOrganizationType(OrganizationType $organizationType): bool
    {
        return $organizationType->delete();
    }
}
