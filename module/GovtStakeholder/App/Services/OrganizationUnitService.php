<?php


namespace Module\GovtStakeholder\App\Services;


use App\Helpers\Classes\AuthHelper;
use App\Helpers\Classes\DatatableHelper;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Module\GovtStakeholder\App\Models\OrganizationUnit;
use Yajra\DataTables\Facades\DataTables;

class OrganizationUnitService
{
    public function createOrganizationUnit(array $data): OrganizationUnit
    {
        $organizationUnit = OrganizationUnit::create($data);
        $organizationUnitType = $organizationUnit->organizationUnitType;

        $humanResourceTemplates = $organizationUnitType->humanResources;
        foreach ($humanResourceTemplates as $humanResourceTemplate) {
            //template is now human resource
            $humanResource = $humanResourceTemplates;
            $humanResource['human_resource_template_id'] = $humanResourceTemplate->id;
            $organizationUnit->humanResources()->create($humanResource);
        }
    }

    public function updateOrganizationUnit(OrganizationUnit $organizationUnit, array $data): bool
    {
        return $organizationUnit->update($data);
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
            'organization_id' => [
                'required',
                'int',
                'exists: organizations,id',
            ],
            'loc_division_id' => [
                'required',
                'int',
                'exists: loc_division,id',
            ],
            'loc_district_id' => [
                'required',
                'int',
                'exists: loc_districts,id',
            ],
            'loc_upazila_id' => [
                'required',
                'int',
                'exists: loc_upazila,id',
            ],
            'address' => [
                'nullable',
                'string',
                'max:191',
            ],
            'mobile' => [
                'nullable',
                'string',
                'max:20',
            ],
            'email' => [
                'nullable',
                'string',
                'max:191',
            ],
            'fax_no' => [
                'nullable',
                'string',
                'max:50',
            ],
            'contact_person_name' => [
                'nullable',
                'string',
                'max:191',
            ],
            'contact_person_mobile' => [
                'nullable',
                'string',
                'max:20',
            ],
            'contact_person_designation' => [
                'nullable',
                'string',
                'max:191',
            ],
            'employee_size' => [
                'required',
                'int',
            ],
            'row_status' => [
                Rule::requiredIf(function () use ($id) {
                    return !empty($id);
                }),
                'int',
                'exists:row_status,code',
            ],
        ];

        return \Illuminate\Support\Facades\Validator::make($request->all(), $rules);

    }

    public function getListDataForDatatable(): JsonResponse
    {
        $authUser = AuthHelper::getAuthUser();
        /** @var Builder|OrganizationUnit $organizationUnit */

        $organizationUnit = OrganizationUnit::select([
            'organization_units.id',
            'organization_units.title_en',
            'organization_units.title_bn',
            'organization_units.address',
            'organization_units.mobile',
            'organization_units.email',
            'organization_units.fax_no',
            'organization_units.contact_person_name',
            'organization_units.contact_person_mobile',
            'organization_units.contact_person_email',
            'organization_units.contact_person_designation',
            'organization_units.employee_size',
            'organization_units.row_status',
            'organization_units.created_at',
            'organization_units.updated_at',
            'organizations.title_en as organization_name',
            'loc_divisions.title_en as division_name',
            'loc_districts.title_en as district_name',
            'loc_upazilas.title_en as upazila_name',
            'organization_unit_types.title_en as organization_unit_name'
        ]);

        $organizationUnit->join('organizations', 'organization_units.organization_id', '=', 'organizations.id');
        $organizationUnit->leftJoin('loc_divisions', 'organization_units.loc_division_id', '=', 'loc_divisions.id');
        $organizationUnit->leftJoin('loc_districts', 'organization_units.loc_district_id', '=', 'loc_districts.id');
        $organizationUnit->leftJoin('loc_upazilas', 'organization_units.loc_upazila_id', '=', 'loc_upazilas.id');
        $organizationUnit->join('organization_unit_types', 'organization_units.organization_unit_type_id', '=', 'organization_unit_types.id');

        return DataTables::eloquent($organizationUnit)
            ->addColumn('action', DatatableHelper::getActionButtonBlock(static function (OrganizationUnit $organizationUnit) use ($authUser) {
                $str = '';
                if ($authUser->can('view', $organizationUnit)) {
                    $str .= '<a href="' . route('admin.organization-units.show', $organizationUnit->id) . '" class="btn btn-outline-info btn-sm"> <i class="fas fa-eye"></i> ' . __('generic.read_button_label') . ' </a>';
                }

                if ($authUser->can('update', $organizationUnit)) {
                    $str .= '<a href="' . route('admin.organization-units.edit', $organizationUnit->id) . '" class="btn btn-outline-warning btn-sm"> <i class="fas fa-edit"></i> ' . __('generic.edit_button_label') . ' </a>';
                }
                if ($authUser->can('delete', $organizationUnit)) {
                    $str .= '<a href="#" data-action="' . route('admin.organization-units.destroy', $organizationUnit->id) . '" class="btn btn-outline-danger btn-sm delete"> <i class="fas fa-trash"></i> ' . __('generic.delete_button_label') . '</a>';
                }
                return $str;
            }))
            ->editColumn('row_status', static function (OrganizationUnit $organizationUnit) {
                return $organizationUnit->getCurrentRowStatus(true);
            })
            ->rawColumns(['action', 'row_status'])
            ->toJson();
    }
}
