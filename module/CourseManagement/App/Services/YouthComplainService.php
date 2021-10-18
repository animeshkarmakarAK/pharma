<?php

namespace Module\CourseManagement\App\Services;

use App\Helpers\Classes\AuthHelper;
use App\Helpers\Classes\DatatableHelper;
use Illuminate\Support\Facades\DB;
use Module\CourseManagement\App\Models\VisitorFeedback;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Module\CourseManagement\App\Models\YouthComplainToOrganization;
use Yajra\DataTables\Facades\DataTables;

class YouthComplainService
{
    public function getYouthComplainListsDatatable(Request $request): JsonResponse
    {
        $authUser = AuthHelper::getAuthUser();
        /** @var Builder|YouthComplainToOrganization $youthComplains */
        $youthComplains = YouthComplainToOrganization::select(
            [
                'youth_complain_to_organizations.id',
                'youth_complain_to_organizations.institute_id',
                'institutes.title_en as institute_name',
                'youth_complain_to_organizations.youth_id',
                'youths.name_en as youth_name_en',
                'youths.name_bn as youth_name_bn',
                'youths.youth_registration_no',
                'youths.mobile',
                'youths.email',

                'youth_complain_to_organizations.organization_id',
                'organizations.title_en as organization_title_en',
                'organizations.title_bn as organization_title_bn',

                'youth_complain_to_organizations.complain_title',
                'youth_complain_to_organizations.complain_message',

                'youth_complain_to_organizations.read_at',
                'youth_complain_to_organizations.created_at',
                'youth_complain_to_organizations.row_status',
            ]
        );

        $youthComplains->join('institutes', 'youth_complain_to_organizations.institute_id', '=', 'institutes.id');
        $youthComplains->join('youths', 'youth_complain_to_organizations.youth_id', '=', 'youths.id');
        $youthComplains->join('organizations', 'youth_complain_to_organizations.organization_id', '=', 'organizations.id');
        $youthComplains->orderBy('id', 'DESC');

        if (!empty($authUser->institute_id)) {
            $youthComplains->where('youth_complain_to_organizations.institute_id', '=', $authUser->institute_id);
        }
        return DataTables::eloquent($youthComplains)
            ->addColumn('action', DatatableHelper::getActionButtonBlock(static function (YouthComplainToOrganization $youthComplain) use ($authUser) {
                $str = '';
                if ($authUser->can('view', $youthComplain)) {
                    $str .= '<a href="' . route('course_management::admin.visitor-feedback.show', $youthComplain->id) . '" class="btn btn-outline-info btn-sm"> <i class="fas fa-eye"></i>  ' . __('generic.read_button_label') . '</a>';
                }
                if ($authUser->can('delete', $youthComplain)) {
                    $str .= '<a href="#" data-action="' . route('course_management::admin.visitor-feedback.destroy', $youthComplain->id) . '" class="btn btn-outline-danger btn-sm delete"> <i class="fas fa-trash"></i> ' . __('generic.delete_button_label') . '</a>';
                }
                return $str;
            }))
            ->editColumn('read_at', function (YouthComplainToOrganization $youthComplain) {
                $str = '';
                $str .= '<a href="#" data-action="' . route('course_management::admin.branches.destroy', $youthComplain->id) . '" class="badge badge-' . ($youthComplain->read_at ? 'success' : 'danger') . '">' . ($youthComplain->read_at ? 'Read' : 'Unread') . '</a>';
                return $str;
            })
            /*->editColumn('form_type', function (YouthComplainToOrganization $youthComplain) {
                return $visitorFeedback->form_type == VisitorFeedback::FORM_TYPE_FEEDBACK ? 'Feedback' : 'Contact';
            })*/
            ->editColumn('created_at', function (YouthComplainToOrganization $youthComplain) {
                return Date('d M, Y h:i:s', strtotime($youthComplain['created_at']));
            })
            ->rawColumns(['action', 'read_at', /*'form_type',*/ 'created_at'])
            ->toJson();

    }
}
