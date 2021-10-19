<?php

namespace Module\CourseManagement\App\Services;


use App\Helpers\Classes\AuthHelper;
use App\Helpers\Classes\DatatableHelper;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Module\CourseManagement\App\Models\Batch;
use Module\CourseManagement\App\Models\Youth;
use Module\CourseManagement\App\Models\YouthBatch;
use Module\CourseManagement\App\Models\YouthCourseEnroll;
use Module\CourseManagement\App\Models\YouthOrganization;
use Module\CourseManagement\App\Models\YouthRegistration;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

use Illuminate\Support\Carbon;
use Module\GovtStakeholder\App\Models\Organization;
use Yajra\DataTables\Facades\DataTables;

class YouthService
{
    public function validateAddYouthToOrganization(Request $request): Validator
    {
        $rules = [
            'organization_id' => ['bail', 'required'],
            'youth_ids' => ['bail', 'required', 'array', 'min:1'],
            'youth_ids.*' => [
                "required",
                Rule::notIn(DB::table('youth_organizations')->pluck('youth_id')->toArray())
            ]
        ];
        return \Illuminate\Support\Facades\Validator::make($request->all(), $rules);
    }

    public function getListDataForDatatable($request): JsonResponse
    {
        $instituteId = AuthHelper::getAuthUser()->institute_id;
        $youths = Youth::select([
            DB::raw('max(youths.id) AS id'),
            DB::raw('max(youths.youth_registration_no) AS youth_registration_no'),
            DB::raw('max(youths.name_en) AS name_en'),
            DB::raw('max(youths.name_bn) AS name_bn'),
            DB::raw('max(institutes.title_en) AS institute_title_en'),
            DB::raw('max(institutes.id) AS institute_id'),
            DB::raw('max(youth_organizations.organization_id) AS youth_organization_id'),
            DB::raw('max(organizations.title_en) AS organization_title_en'),
        ]);
        $youths->leftJoin('youth_course_enrolls', 'youths.id', '=', 'youth_course_enrolls.youth_id');
        $youths->leftJoin('publish_courses', 'publish_courses.id', '=', 'youth_course_enrolls.publish_course_id');
        $youths->leftJoin('institutes', 'institutes.id', '=', 'publish_courses.institute_id');

        $youths->leftJoin('youth_organizations', 'youth_organizations.youth_id', '=', 'youths.id');
        $youths->leftJoin('organizations', 'organizations.id', '=', 'youth_organizations.organization_id');
        $youths->groupBy('youth_registration_no');
        //$youths->groupBy('institute_title_en');

        if ($instituteId) {
            $youths->where(['institutes.id' => $instituteId]);
        }

        $youthNameEn = $request->youth_name_en;
        $youthNameBn = $request->youth_name_bn;
        $youthRegNo = $request->reg_no;
        $organizationId = $request->input('organization_id');

        if ($organizationId) {
            $youths->where(['youth_organizations.organization_id' => $organizationId]);
        }
        if ($youthNameEn) {
            $youths->where('youths.name_en', 'LIKE', '%' . $youthNameEn . '%');
        }
        if ($youthNameBn) {
            $youths->where('youths.name_bn', 'LIKE', '%' . $youthNameBn . '%');
        }
        if ($youthRegNo) {
            $youths->where('youths.youth_registration_no', $youthRegNo);
        }


        return DataTables::eloquent($youths)
            ->addColumn('action', DatatableHelper::getActionButtonBlock(static function (Youth $youth) {
                $str = '';
                $str .= '<a href="' . route('course_management::youth-registrations.show', $youth->id) . '" class="btn btn-outline-info btn-sm"> <i class="fas fa-eye"></i> ' . __('generic.read_button_label') . ' </a>';
                /*$str .= '<a href="' . route('course_management::youth-registrations.show', $youth->id) . '" class="btn btn-outline-info btn-sm"> <i class="fas fa-eye"></i> ' . __('Remove From Organization') . ' </a>';*/
                return $str;
            }))
            ->addColumn('already_added_to_organization', static function (Youth $youth) {
                $youthOrganization = YouthOrganization::where(['youth_id' => $youth->id])->first();
                $str = '';
                $str .= '<span class="badge ' . (!empty($youthOrganization) ? "badge-success" : "badge-warning") . '"> <i class="fas ' . (!empty($youthOrganization) ? 'fa-paperclip' : 'fa-unlink') . '"></i> ' . (!empty($youthOrganization) ? $youthOrganization->organization->title_en : 'Not assigned') . ' </a>';
                return $str;
            })
            ->addColumn('already_added_check', static function (Youth $youth) {
                $youthOrganization = YouthOrganization::where(['youth_id' => $youth->id])->first();
                return !empty($youthOrganization) ? 1 : 0;
            })
            ->rawColumns(['action', 'already_added_to_organization', 'already_added_check'])
            ->toJson();
    }

    public function addYouthToOrganization(Organization $organization, array $youthIds): bool
    {
        foreach ($youthIds as $youthId) {
            /** @var Youth $youth */
            $youth = Youth::findOrFail($youthId);
            YouthOrganization::updateOrCreate(
                [
                    'organization_id' => $organization->id,
                    'youth_id' => $youth->id,
                ]
            );
            $youth->save();
        }
        return true;
    }
}
