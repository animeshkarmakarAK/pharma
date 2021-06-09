<?php

namespace Module\CourseManagement\App\Services;

use App\Helpers\Classes\AuthHelper;
use App\Helpers\Classes\DatatableHelper;
use Module\CourseManagement\App\Models\Batch;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class BatchService
{
    public function createBatch(array $data): Batch
    {
        return Batch::create($data);
    }

    public function updateBatch(Batch $branch, array $data): Batch
    {
        $branch->fill($data);
        $branch->save();
        return $branch;
    }

    public function deleteBatch(Batch $batch): ?bool
    {
        return $batch->delete();
    }

    public function validator(Request $request, $id = null): Validator
    {
        $rules = [
            'title_en' => 'required|string|max:191',
            'title_bn' => 'required|string|max: 191',
            'code' => 'required|string|max: 191|unique:batches,code,'.$id,
            'institute_id' => 'required|int',
            'course_id' => 'required|int',
            'max_student_enrollment' => ['required', 'int'],
            'start_date' => ['required', 'date', 'after:today,' . $id],
            'end_date' => ['required', 'date', 'after:start_date'],
            'start_time' => ['required'],
            'end_time' => ['required'],
        ];
        return \Illuminate\Support\Facades\Validator::make($request->all(), $rules);
    }

    public function getBatchLists(Request $request): JsonResponse
    {
        $authUser = AuthHelper::getAuthUser();
        /** @var Builder|Batch $batches */
        $batches = Batch::select(
            [
                'batches.id as id',
                'batches.title_en as batches.title_en',
                'batches.title_bn',
                'institutes.title_en as institutes.title_en',
                'courses.title_en as courses.title_en',
                'batches.max_student_enrollment as batches.max_student_enrollment',
                'batches.start_date',
                'batches.end_date',
                'batches.start_time',
                'batches.end_time',
                'batches.row_status',
                'batches.created_at',
                'batches.updated_at',
            ]
        );
        $batches->join('institutes', 'batches.institute_id', '=', 'institutes.id');
        $batches->join('courses', 'batches.course_id', '=', 'courses.id');
        $batches->acl();

        return DataTables::eloquent($batches)
            ->addColumn('action', DatatableHelper::getActionButtonBlock(static function (Batch $batch) use ($authUser){
                $str = '';
                if($authUser->can('view',$batch)){
                    $str .= '<a href="' . route('admin.batches.show', $batch->id) . '" class="btn btn-outline-info btn-sm"> <i class="fas fa-eye"></i> Read </a>';
                }
                if($authUser->can('viewBachYouth', $batch)) {
                    $str .= '<a href="' . route('admin.batches.youths', $batch->id) . '" class="btn btn-outline-success btn-sm"> <i class="fas fa-users"></i> Youths </a>';
                }

                if($authUser->can('update',$batch)){
                    $str .= '<a href="' . route('admin.batches.edit', $batch->id) . '" class="btn btn-outline-warning btn-sm"> <i class="fas fa-edit"></i> Edit </a>';
                }
                if($authUser->can('delete',$batch)){
                    $str .= '<a href="#" data-action="' . route('admin.batches.destroy', $batch->id) . '" class="btn btn-outline-danger btn-sm delete"> <i class="fas fa-trash"></i> Delete</a>';
                }
                return $str;
            }))
            ->rawColumns(['action'])
            ->toJson();
    }


}
