<?php

namespace Module\GovtStakeholder\App\Services;

use App\Helpers\Classes\AuthHelper;
use App\Helpers\Classes\DatatableHelper;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Module\CourseManagement\App\Models\YouthOrganization;
use Yajra\DataTables\Facades\DataTables;

class OrganizationYouthService
{
    public function getOrganizationYouthLists(Request $request): JsonResponse
    {
        $authUser = AuthHelper::getAuthUser();

        /** @var Builder|YouthOrganization $youths */
        $youths = YouthOrganization::select(
            [
                'youth_organizations.id',
                'youth_organizations.youth_id as youth_id',
                'youths.name_en as youth_name_en',
                'youths.name_bn as youth_name_bn',
                'youths.youth_registration_no',
                'youth_organizations.organization_id',
                'organizations.title_en as organization_title_en',
                'organizations.title_bn as organization_title_bn',
                'youth_organizations.row_status',
                'youth_organizations.created_at',
                'youth_organizations.updated_at',
            ]
        );
        $youths->LeftJoin('organizations', 'youth_organizations.organization_id', '=', 'organizations.id');
        $youths->LeftJoin('youths', 'youth_organizations.youth_id', '=', 'youths.id');

        if (!empty($authUser->organization_id)) {
            $youths->where(['organization_id' => $authUser->organization_id]);
        }


        return DataTables::eloquent($youths)
            ->addColumn('action', DatatableHelper::getActionButtonBlock(static function (YouthOrganization $youth) use ($authUser) {
                $str = '';
                $str .= '<a href="' . route('course_management::youth-registrations.show', $youth->youth_id) . '" class="btn btn-outline-info btn-sm"> <i class="fas fa-address-card"></i> CV View </a>';
                $str .= '<a href="' . route('course_management::admin.youths.certificate.course', $youth->youth_id) . '" class="btn btn-outline-warning btn-sm"> <i class="fas fa-user-graduate"></i> Certificate View</a>';
                if (!empty($authUser->organization_id)) {
                    $str .= '<a href="' . route('govt_stakeholder::admin.organization-complain-form', $youth->youth_id) . '" data-action="' . '" class="btn btn-outline-danger btn-sm complain"> <i class="fas fa-skull-crossbones"></i> Feedback</a>';
                }
                return $str;
            }))
            ->rawColumns(['action'])
            ->toJson();
    }

}
