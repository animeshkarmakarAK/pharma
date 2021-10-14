<?php

namespace Module\CourseManagement\App\Services;


use App\Helpers\Classes\AuthHelper;
use App\Helpers\Classes\DatatableHelper;
use Illuminate\Support\Facades\DB;
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
        ];
        return \Illuminate\Support\Facades\Validator::make($request->all(), $rules);
    }

    public function getListDataForDatatable($request): JsonResponse
    {
        $instituteId = AuthHelper::getAuthUser()->institute_id;
        $youth = Youth::select([
            DB::raw('max(youths.id) AS id'),
            DB::raw('max(youths.youth_registration_no) AS youth_registration_no'),
            DB::raw('max(youths.name_en) AS name_en'),
            DB::raw('max(youths.name_bn) AS name_bn'),
            DB::raw('max(institutes.title_en) AS institute_title_en'),
            DB::raw('max(institutes.id) AS institute_id'),
        ]);
        $youth->join('youth_course_enrolls', 'youths.id', '=', 'youth_course_enrolls.youth_id');
        $youth->join('publish_courses', 'publish_courses.id', '=', 'youth_course_enrolls.publish_course_id');
        $youth->join('institutes', 'institutes.id', '=', 'publish_courses.institute_id');
        $youth->groupBy('youth_registration_no');

        if ($instituteId) {
            $youth->where(['institutes.id' => $instituteId]);
        }

        return DataTables::eloquent($youth)
            ->addColumn('action', DatatableHelper::getActionButtonBlock(static function (Youth $youth) {
                $str = '';
                $str .= '<a href="' . route('course_management::youth-registrations.show', $youth->id) . '" class="btn btn-outline-info btn-sm"> <i class="fas fa-eye"></i> ' . __('generic.read_button_label') . ' </a>';
                $str .= '<a href="#" class="btn btn-outline-primary btn-sm already-assigned-btn" id="'.$youth->id.'"> <i class="fas fa-eye"></i> ' . __('Already Assigned') . ' </a>';
                return $str;
            }))
            ->rawColumns(['action', 'already_added_to_organization'])
            ->toJson();
    }

    public function addYouthToOrganization(Organization $organization, array $youthIds): array
    {
        return $organization->youthOrganization()->syncWithoutDetaching($youthIds);

//        foreach ($youthIds as $youthId) {
//            /** @var YouthRegistration $youth */
//            $youth = Youth::findOrFail($youthId);
//
//            YouthOrganization::where("youth_id",$youth->id)->delete();
//
////            YouthOrganization::updateOrCreate(
////                [
////                    'organization_id' => $organization->id,
////                    'youth_id' => $youth->id,
////                ]
////            );
////            $youth->save();
//        }
//        return true;
    }
}
