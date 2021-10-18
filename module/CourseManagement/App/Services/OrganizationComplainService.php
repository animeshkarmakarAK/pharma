<?php

namespace Module\CourseManagement\App\Services;

use App\Helpers\Classes\AuthHelper;
use App\Helpers\Classes\DatatableHelper;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Module\CourseManagement\App\Models\OrganizationComplainToYouth;
use Yajra\DataTables\Facades\DataTables;

class OrganizationComplainService
{
    public function getOrganizationComplainListsDatatable(Request $request): JsonResponse
    {
        $authUser = AuthHelper::getAuthUser();
        /** @var Builder|OrganizationComplainToYouth $organizationComplainToYouths */
        $organizationComplainToYouths = OrganizationComplainToYouth::select(
            [
                'organization_complain_to_youths.id',
                'organization_complain_to_youths.institute_id',
                'institutes.title_en as institute_name',
                'organization_complain_to_youths.youth_id',
                'youths.name_en as youth_name_en',
                'youths.name_bn as youth_name_bn',
                'youths.youth_registration_no',
                'youths.mobile',
                'youths.email',

                'organization_complain_to_youths.organization_id',
                'organizations.title_en as organization_title_en',
                'organizations.title_bn as organization_title_bn',

                'organization_complain_to_youths.complain_title',
                'organization_complain_to_youths.complain_message',

                'organization_complain_to_youths.read_at',
                'organization_complain_to_youths.created_at',
                'organization_complain_to_youths.row_status',
            ]
        );

        $organizationComplainToYouths->join('institutes', 'organization_complain_to_youths.institute_id', '=', 'institutes.id');
        $organizationComplainToYouths->join('youths', 'organization_complain_to_youths.youth_id', '=', 'youths.id');
        $organizationComplainToYouths->join('organizations', 'organization_complain_to_youths.organization_id', '=', 'organizations.id');
        $organizationComplainToYouths->orderBy('id', 'DESC');

        if (!empty($authUser->institute_id)) {
            $organizationComplainToYouths->where('organization_complain_to_youths.institute_id', '=', $authUser->institute_id);
        }

        return DataTables::eloquent($organizationComplainToYouths)
            ->addColumn('action', DatatableHelper::getActionButtonBlock(static function (OrganizationComplainToYouth $organizationComplainToYouth) use ($authUser) {
                $str = '';
                if ($authUser->can('view', $organizationComplainToYouth)) {
                    $str .= '<a href="' . route('course_management::admin.visitor-feedback.show', $organizationComplainToYouth->id) . '" class="btn btn-outline-info btn-sm"> <i class="fas fa-eye"></i>  ' . __('generic.read_button_label') . '</a>';
                }
                if ($authUser->can('delete', $organizationComplainToYouth)) {
                    $str .= '<a href="#" data-action="' . route('course_management::admin.visitor-feedback.destroy', $organizationComplainToYouth->id) . '" class="btn btn-outline-danger btn-sm delete"> <i class="fas fa-trash"></i> ' . __('generic.delete_button_label') . '</a>';
                }
                return $str;
            }))
            ->editColumn('read_at', function (OrganizationComplainToYouth $organizationComplainToYouth) {
                $str = '';
                $str .= '<a href="#" data-action="' . route('course_management::admin.branches.destroy', $organizationComplainToYouth->id) . '" class="badge badge-' . ($organizationComplainToYouth->read_at ? 'success' : 'danger') . '">' . ($organizationComplainToYouth->read_at ? 'Read' : 'Unread') . '</a>';
                return $str;
            })
            ->editColumn('created_at', function (OrganizationComplainToYouth $organizationComplainToYouth) {
                return Date('d M, Y h:i:s', strtotime($organizationComplainToYouth['created_at']));
            })
            ->rawColumns(['action', 'read_at', 'created_at'])
            ->toJson();

    }
}
