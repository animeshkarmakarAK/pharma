<?php

namespace Module\GovtStakeholder\App\Services;

use App\Helpers\Classes\AuthHelper;
use App\Helpers\Classes\DatatableHelper;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Module\GovtStakeholder\App\Models\OrganizationType;
use Module\GovtStakeholder\App\Models\OrganizationInformation;
use Yajra\DataTables\Facades\DataTables;

class OrganizationInformationService
{
    public function createOrganizationInformation(array $data): OrganizationInformation
    {
//        dd($data);
        $organizationInfo = new OrganizationInformation;
        $organizationInfo->informant_name = $data['informant_name'];
        $organizationInfo->informant_email = $data['informant_email'];
        $organizationInfo->informant_mobile = $data['informant_mobile'];
        $organizationInfo->informant_date = $data['informant_date'];
        $organizationInfo->respondent_name = $data['respondent_name'];
        if($data['respondent_designation'] == 'other'){
            $organizationInfo->respondent_designation = $data['respondent_others_detail'];
        }
        else{
            $organizationInfo->respondent_designation = "";
        }

//        $organizationInfo->industry_sector = $data['industry_sector'];
//        $organizationInfo->industry_started = $data['industry_started'];
        $organizationInfo->industry_association = $data['industry_association'];
        $organizationInfo->industry_type = $data['industry_type'];

        $organizationInfo->total_employee_one = $data['total_employee_one'];
        $organizationInfo->full_time_employee_one = $data['full_time_employee_one'];
        $organizationInfo->half_time_employee_one = $data['half_time_employee_one'];
        $organizationInfo->female_number_one = $data['female_number_one'];
        $organizationInfo->male_number_one = $data['male_number_one'];

        if($data['others_number_one'] == 'yes'){
            $organizationInfo->others_total_number = $data['others_total_number'];
        }
        else{
            $organizationInfo->others_number_one = $data['others_number_one'];
        }
        if($data['disabled_person'] == 'yes'){
            $organizationInfo->others_total_number = $data['disabled_person_number'];
        }
        else{
            $organizationInfo->disabled_person = $data['disabled_person'];
        }

        if($data['unhelped_group'] == 'yes'){
            $organizationInfo->others_total_number = $data['unhelped_group_number'];
        }
        else{
            $organizationInfo->unhelped_group = $data['unhelped_group'];
        }

        $organizationInfo->senior_level_one = $data['senior_level_one'];
        $organizationInfo->middle_level_one = $data['middle_level_one'];
        $organizationInfo->junior_level_one = $data['junior_level_one'];

        if($data['outside_employee'] == 'yes'){
            $organizationInfo->other_country_employee_number = $data['other_country_employee_number'];
            $organizationInfo->senior_level_two = $data['senior_level_two'];
            $organizationInfo->middle_level_two = $data['middle_level_two'];
            $organizationInfo->junior_level_two = $data['junior_level_two'];
            if($data['employee_problem'] == 'yes'){
                $organizationInfo->employee_problem = $data['employee_problem_detail'];
            }
            else{
                $organizationInfo->employee_problem = $data['employee_problem'];
            }
        }
        else{
            $organizationInfo->outside_employee = $data['outside_employee'];
        }
        $organizationInfo->decision_problem_1 = $data['decision_problem_1'];
        $organizationInfo->decision_problem_2 = $data['decision_problem_2'];
        $organizationInfo->decision_problem_3 = $data['decision_problem_3'];
        $organizationInfo->decision_problem_4 = $data['decision_problem_4'];
        $organizationInfo->decision_problem_5 = $data['decision_problem_5'];

        return $organizationInfo->save();
    }

    public function validator(Request $request, $id = null): Validator
    {
        $rules = [
            'informant_name' => [
                'required'
            ],
            'informant_mobile' => [
                'required'
            ],
            'informant_email' => [
                'required'
            ],
            'informant_date' => [
                'required'
            ],
            'respondent_name' => [
                'required'
            ],
            'respondent_designation' => [
                'required'
            ],
            'industry_association' => [
                'required'
            ],
            'industry_association' => [
                'required'
            ],
            'industry_type' => [
                'required'
            ],
            'total_employee_one' => [
                'required'
            ],
            'full_time_employee_one' => [
                'required'
            ],
            'half_time_employee_one' => [
                'required'
            ],
            'female_number_one' => [
                'required'
            ],
            'male_number_one' => [
                'required'
            ],
            'others_number_one' => [
                'required'
            ],
            'disabled_person' => [
                'required'
            ],
            'unhelped_group' => [
                'required'
            ],
            'senior_level_one' => [
                'required'
            ],
            'middle_level_one' => [
                'required'
            ],
            'junior_level_one' => [
                'required'
            ],
            'outside_employee' => [
                'required'
            ],
            'employee_recruitment' => [
                'required'
            ],
            'institute_facilities' => [
                'required'
            ],
            'recruitment_media' => [
                'required'
            ],
            'decision_problem_1' => [
                'required'
            ],
            'decision_problem_2' => [
                'required'
            ],
            'decision_problem_3' => [
                'required'
            ],
            'decision_problem_4' => [
                'required'
            ],
            'decision_problem_5' => [
                'required'
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
                    $str .= '<a href="' . route('govt_stakeholder::admin.organization-types.show', $organizationType->id) . '" class="btn btn-outline-info btn-sm"> <i class="fas fa-eye"></i> ' . __('generic.read_button_label') . '</a>';
                }
                if ($authUser->can('update', $organizationType)) {
                    $str .= '<a href="' . route('govt_stakeholder::admin.organization-types.edit', $organizationType->id) . '" class="btn btn-outline-warning btn-sm"> <i class="fas fa-edit"></i> ' . __('generic.edit_button_label') . ' </a>';
                }
                if ($authUser->can('delete', $organizationType)) {
                    $str .= '<a href="#" data-action="' . route('govt_stakeholder::admin.organization-types.destroy', $organizationType->id) . '" class="btn btn-outline-danger btn-sm delete"> <i class="fas fa-trash"></i> ' . __('generic.delete_button_label') . '</a>';
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
