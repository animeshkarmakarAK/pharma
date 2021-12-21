<?php

namespace App\Services;

use App\Helpers\Classes\DatatableHelper;
use Illuminate\Support\Facades\DB;
use App\Models\TraineeBatch;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class TraineeBatchService
{
    public function getTraineeBatchLists(Request $request, int $batchId): JsonResponse
    {
        /** @var Builder $traineeBatches */
        $traineeBatches = TraineeBatch::select(
            [
                'trainees.id as id',
                'trainee_course_enrolls.id as trainee_registrations.trainee_registration_no',
                'trainees.trainee_registration_no as trainee_registration_no',
                'trainees.name as trainee_name',
                DB::raw('DATE_FORMAT(trainee_batches.enrollment_date,"%d %b, %Y %h:%i %p") AS enrollment_date'),
            ]
        );
        $traineeBatches->join('batches', 'trainee_batches.batch_id', '=', 'batches.id');
        $traineeBatches->leftJoin('trainee_course_enrolls', 'trainee_batches.trainee_course_enroll_id', '=', 'trainee_course_enrolls.id');
        $traineeBatches->join('trainees', 'trainee_course_enrolls.trainee_id', '=', 'trainees.id');
        $traineeBatches->where('batches.id', $batchId);

        return DataTables::eloquent($traineeBatches)
            ->addColumn('action', DatatableHelper::getActionButtonBlock(static function (TraineeBatch $traineeBatches) {
                $str = '';
                $str .= '<a href="' . route('frontend.trainee-registrations.show', $traineeBatches->id) . '" class="btn btn-outline-info btn-sm"> <i class="fas fa-eye"></i> Read </a>';
                return $str;
            }))
            ->rawColumns(['action'])
            ->toJson();
    }
}
