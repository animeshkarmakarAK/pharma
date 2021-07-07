<?php

namespace Module\GovtStakeholder\App\Services;

use App\Helpers\Classes\AuthHelper;
use App\Helpers\Classes\DatatableHelper;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Module\GovtStakeholder\App\Models\Organization;
use Yajra\DataTables\Facades\DataTables;
use App\Helpers\Classes\FileHandler;


class OrganizationService
{
    public function createOrganization(array $data): Organization
    {
        if (!empty($data['logo'])) {
            $filename = FileHandler::storePhoto($data['logo'], Organization::LOGO_FOLDER_NAME);
            $data['logo'] = $filename ? Organization::LOGO_FOLDER_NAME . '/' . $filename : Organization::DEFAULT_LOGO;
        } else {
            $data['logo'] = Organization::DEFAULT_LOGO;
        }

        return Organization::create($data);
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
            'domain' => [
                'required',
                'string',
                'max:191',
                'regex:/^(http|https):\/\/[a-zA-Z-\-\.0-9]+$/',
                'unique:organizations,domain,' . $id
            ],

            'description' => [
                'nullable',
                'max:255',
            ],
            'organization_type_id' => [
                'required',
            ],
            'fax_no' => [
                'nullable',
                'max: 50',
                'regex: /^\+?[0-9]{6,}$/',
            ],
            'contact_person_designation' => [
                'required',
                'max: 191',
            ],
            'contact_person_email' => [
                'required',
                'regex: /\S+@\S+\.\S+/'
            ],
            'contact_person_mobile' => [
                'required',
                'regex: /^(?:\+88|88)?(01[3-9]\d{8})$/',
            ],
            'contact_person_name' => [
                'required',
                'max: 191',
            ],
            'mobile' => [
                'required',
                'regex: /^(?:\+88|88)?(01[3-9]\d{8})$/',
            ],
            'email' => [
                'required',
                'regex : /^[^\s@]+@[^\s@]+$/',
            ],
            'logo' => [
                'required_if:' . $id . ',null',
                'image',
                'mimes:jpeg,jpg,png,gif',
                'max:500',
            ],
            'address' => [
                'required',
                'max: 191'
            ]
        ];
        $messages = [
            'logo.max' => 'Please upload maximum 500kb size of image',
        ];
        return \Illuminate\Support\Facades\Validator::make($request->all(), $rules, $messages);
    }

    public function updateOrganization(Organization $organization, array $data): Organization
    {
        if ($organization->logo && !$organization->logoIsDefault() && !empty($data['logo'])) {
            FileHandler::deleteFile($organization->logo);
        }

        if (!empty($data['logo'])) {
            $filename = FileHandler::storePhoto($data['logo'], Organization::LOGO_FOLDER_NAME);
            $data['logo'] = Organization::LOGO_FOLDER_NAME . '/' . $filename;
        } else {
            unset($data['logo']);
        }

        if (empty($organization->logo)) {
            $data['logo'] = Organization::DEFAULT_LOGO;
        }

        $organization->update($data);
        return $organization;
    }


    public function getListDataForDatatable(Request $request): JsonResponse
    {
        $authUser = AuthHelper::getAuthUser();

        /** @var Builder|Organization $organization */
        $organization = Organization::acl($attribute = 'id')->select([
            'organizations.id',
            'organizations.title_en',
            'organizations.title_bn',
            'organizations.mobile',
            'organizations.email',
            'organizations.contact_person_name',
            'organization_types.title_en as organization_types_title',
        ]);
        $organization->join('organization_types', 'organizations.organization_type_id', '=', 'organization_types.id');


        return DataTables::eloquent($organization)
            ->addColumn('action', DatatableHelper::getActionButtonBlock(static function (Organization $organization) use ($authUser) {
                $str = '';
                if ($authUser->can('view', $organization)) {
                    $str .= '<a href="' . route('govt_stakeholder::admin.organizations.show', $organization->id) . '" class="btn btn-outline-info btn-sm"> <i class="fas fa-eye"></i> ' . __('generic.read_button_label') . '</a>';
                }
                if ($authUser->can('update', $organization)) {
                    $str .= '<a href="' . route('govt_stakeholder::admin.organizations.edit', $organization->id) . '" class="btn btn-outline-warning btn-sm"> <i class="fas fa-edit"></i> ' . __('generic.edit_button_label') . ' </a>';
                }
                if ($authUser->can('delete', $organization)) {
                    $str .= '<a href="#" data-action="' . route('govt_stakeholder::admin.organizations.destroy', $organization->id) . '" class="btn btn-outline-danger btn-sm delete"> <i class="fas fa-trash"></i> ' . __('generic.delete_button_label') . '</a>';
                }
                return $str;
            }))
            ->rawColumns(['action'])
            ->toJson();
    }


    public function deleteOrganization(Organization $organization): bool
    {
        return $organization->delete();
    }
}
