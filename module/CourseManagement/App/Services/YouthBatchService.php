<?php

namespace Module\CourseManagement\App\Services;

use App\Helpers\Classes\DatatableHelper;
use Illuminate\Support\Facades\DB;
use Module\CourseManagement\App\Models\YouthBatch;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class YouthBatchService
{
    public function getYouthBatchLists(Request $request, int $batchId): JsonResponse
    {
        /** @var Builder $youthBatches */
        $youthBatches = YouthBatch::select(
            [
                'youths.id as id',
                'youth_registrations.youth_registration_no as youth_registrations.youth_registration_no',
                'youth_registrations.id as youth_registration_id',
                'youths.name_en as youth_name_en',
                DB::raw('DATE_FORMAT(youth_batches.enrollment_date,"%d %b, %Y %h:%i %p") AS enrollment_date'),
            ]
        );
        $youthBatches->join('batches', 'youth_batches.batch_id', '=', 'batches.id');
        $youthBatches->leftJoin('youth_registrations', 'youth_batches.youth_registration_id', '=', 'youth_registrations.id');
        $youthBatches->join('youths', 'youth_batches.youth_id', '=', 'youths.id');
        $youthBatches->where('batches.id', $batchId);

        return DataTables::eloquent($youthBatches)
            ->addColumn('action', DatatableHelper::getActionButtonBlock(static function (YouthBatch $youthBatches) {
                $str = '';
                $str .= '<a href="' . route('course_management::youth-registrations.show', $youthBatches->youth_registration_id) . '" class="btn btn-outline-info btn-sm"> <i class="fas fa-eye"></i> Read </a>';
                //$str .= '<a href="' . route('course_management::admin.youth-batches.edit', $youthBatches->id) . '" class="btn btn-outline-warning btn-sm"> <i class="fas fa-edit"></i> Edit </a>';
                //$str .= '<a href="#" data-action="' . route('course_management::admin.youth-batches.destroy', $youthBatches->id) . '" class="btn btn-outline-danger btn-sm delete"> <i class="fas fa-trash"></i> Delete</a>';
                return $str;
            }))
            ->rawColumns(['action'])
            ->toJson();
    }
}
