<?php

namespace App\Services;

use App\Helpers\Classes\DatatableHelper;
use Illuminate\Support\Facades\DB;
use App\Models\YouthBatch;
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
                'youth_course_enrolls.id as youth_registrations.youth_registration_no',
                'youths.youth_registration_no as youth_registration_no',
                'youths.name as youth_name',
                DB::raw('DATE_FORMAT(youth_batches.enrollment_date,"%d %b, %Y %h:%i %p") AS enrollment_date'),
            ]
        );
        $youthBatches->join('batches', 'youth_batches.batch_id', '=', 'batches.id');
        $youthBatches->leftJoin('youth_course_enrolls', 'youth_batches.youth_course_enroll_id', '=', 'youth_course_enrolls.id');
        $youthBatches->join('youths', 'youth_course_enrolls.youth_id', '=', 'youths.id');
        $youthBatches->where('batches.id', $batchId);

        return DataTables::eloquent($youthBatches)
            ->addColumn('action', DatatableHelper::getActionButtonBlock(static function (YouthBatch $youthBatches) {
                $str = '';
                $str .= '<a href="' . route('frontend.youth-registrations.show', $youthBatches->id) . '" class="btn btn-outline-info btn-sm"> <i class="fas fa-eye"></i> Read </a>';
                return $str;
            }))
            ->rawColumns(['action'])
            ->toJson();
    }
}
