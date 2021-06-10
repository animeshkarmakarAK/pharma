<?php


namespace Module\GovtStakeholder\App\Services;


use App\Helpers\Classes\AuthHelper;
use App\Helpers\Classes\DatatableHelper;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Module\GovtStakeholder\App\Models\OrganizationUnitType;
use Yajra\DataTables\Facades\DataTables;

class OrganizationUnitTypeService
{
    public function createOrganizationUnitType(array $data): OrganizationUnitType
    {
        return OrganizationUnitType::create($data);
    }

    public function updateOrganizationUnitType(OrganizationUnitType $organizationUnitType, array $data): bool
    {
        return $organizationUnitType->update($data);
    }

    public function validator(Request $request, $id = null): Validator
    {
        $rules = [
            'title_en' => [
                'required',
                'string',
                'max: 191'
            ],
            'title_bn' => [
                'required',
                'string',
                'max: 191'
            ],
            'row_status' => [
                Rule::requiredIf(function () use($id) {
                    return !empty($id);
                }),
                'int',
                'exists:row_status,code',
            ]
        ];

        return \Illuminate\Support\Facades\Validator::make($request->all(), $rules);

    }

    public function getListDataForDatatable(\Illuminate\Http\Request $request): JsonResponse
    {
        $authUser = AuthHelper::getAuthUser();
        /** @var Builder|OrganizationUnitType $organizationUnitType */

        $organizationUnitType = OrganizationUnitType::select([
            'organization_unit_types.id',
            'organization_unit_types.title_en',
            'organization_unit_types.title_bn',
            'organization_unit_types.created_at',
            'organization_unit_types.updated_at',
            'organization_unit_types.row_status'
        ]);

        return DataTables::eloquent($organizationUnitType)
            ->addColumn('action', DatatableHelper::getActionButtonBlock( static function (OrganizationUnitType $organizationUnitType) use ($authUser) {
                $str = '';
                if ($authUser->can('view', $organizationUnitType)) {
                    $str .= '<a href="' . route('admin.organization-unit-types.show', $organizationUnitType->id) . '" class="btn btn-outline-info btn-sm"> <i class="fas fa-eye"></i> ' . __('generic.read_button_label') . ' </a>';
                }

                if ($authUser->can('update', $organizationUnitType)) {
                    $str .= '<a href="' . route('admin.organization-unit-types.edit', $organizationUnitType->id) . '" class="btn btn-outline-warning btn-sm"> <i class="fas fa-edit"></i> ' . __('generic.edit_button_label') . ' </a>';
                }
                if ($authUser->can('delete', $organizationUnitType)) {
                    $str .= '<a href="#" data-action="' . route('admin.organization-unit-types.destroy', $organizationUnitType->id) . '" class="btn btn-outline-danger btn-sm delete"> <i class="fas fa-trash"></i> ' . __('generic.delete_button_label') . '</a>';
                }

                $str .= '<a href="' . route('admin.organization-unit-types.hierarchy', $organizationUnitType->id) . '" class="btn btn-outline-secondary btn-sm"> <i class="fas fa-tree"></i> ' . 'hierarchy' . '</a>';

                return $str;
            }))
            ->editColumn('row_status', static function (OrganizationUnitType $organizationUnitType) {
                return $organizationUnitType->getCurrentRowStatus(true);
            })
            ->rawColumns(['action', 'row_status'])
            ->toJson();
    }

}
