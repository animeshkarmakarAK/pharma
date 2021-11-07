<?php

namespace Module\CourseManagement\App\Services;

use App\Helpers\Classes\AuthHelper;
use App\Helpers\Classes\DatatableHelper;
use App\Helpers\Classes\FileHandler;
use Illuminate\Validation\Rules\RequiredIf;
use Module\CourseManagement\App\Models\Batch;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Module\CourseManagement\App\Models\Programme;
use Module\CourseManagement\App\Models\PublishCourse;
use Yajra\DataTables\Facades\DataTables;

class BatchService
{
    public function createBatch(array $data): Batch
    {
        if (!empty($data['course_coordinator_signature'])) {
            $filename = FileHandler::storePhoto($data['course_coordinator_signature'], 'batch/signature/course-coordinator');
            $data['course_coordinator_signature'] = 'batch/signature/course-coordinator/' . $filename;
        }

        if (!empty($data['course_director_signature'])) {
            $filename = FileHandler::storePhoto($data['course_director_signature'], 'batch/signature/course-director');
            $data['course_director_signature'] = 'batch/signature/course-director/' .  $filename;
        }

        $data['course_id'] = $this->courseIdByPublishCourseId($data['publish_course_id']);
        return Batch::create($data);
    }

    public function updateBatch(Batch $batch, array $data):Batch
    {
        if ($batch->course_coordinator_signature && !empty($data['course_coordinator_signature'])) {
            FileHandler::deleteFile($batch->course_coordinator_signature);
        }

        if (!empty($data['course_coordinator_signature'])) {
            $filename = FileHandler::storePhoto($data['course_coordinator_signature'], 'batch/signature/course-coordinator');
            $data['course_coordinator_signature'] = 'batch/signature/course-coordinator/' . $filename;
        }

        if ($batch->course_director_signature && !empty($data['course_director_signature'])) {
            FileHandler::deleteFile($batch->course_director_signature);
        }

        if (!empty($data['course_director_signature'])) {
            $filename = FileHandler::storePhoto($data['course_director_signature'], 'batch/signature/course-director');
            $data['course_director_signature'] = 'batch/signature/course-director/' .  $filename;
        }
        $data['course_id'] = $this->courseIdByPublishCourseId($data['publish_course_id']);

        $batch->fill($data);
        $batch->save();
        return $batch;
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
            'code' => 'required|string|max: 191|unique:batches,code,' . $id,
            'institute_id' => 'required|int',
            'publish_course_id' => 'required|int',
            'max_student_enrollment' => ['required', 'int'],
            'start_date' => ['required', 'date', 'after:today,' . $id],
            'end_date' => ['required', 'date', 'after:start_date'],
            'start_time' => ['required'],
            'end_time' => ['required'],
            'course_coordinator_signature' => [
                new RequiredIf($id == null),
                'image',
                'mimes:jpg,bmp,png,jpeg,svg',
                'dimensions:width=300,height=80',
            ],
            'course_director_signature' => [
                new RequiredIf($id == null),
                'image',
                'mimes:jpg,bmp,png,jpeg,svg',
                'dimensions:width=300,height=80',
            ],
        ];

        if (!empty($id)) {
            $rules['start_date'] = [
                'start_date' => ['required', 'date']
            ];
        }

        $customMessages = [
            'start_date.after' => 'Start Date will must be greater than Today'
        ];

        return \Illuminate\Support\Facades\Validator::make($request->all(), $rules, $customMessages);
    }

    public function getBatchLists(Request $request): JsonResponse
    {
        $authUser = AuthHelper::getAuthUser();
        /** @var Builder|Batch $batches */
        $batches = Batch::acl()->select(
            [
                'batches.id as id',
                'batches.title_en',
                'batches.title_bn',
                'institutes.title_en as institutes.title_en',
                'courses.title_en as courses.title_en',
                'batches.max_student_enrollment as batches.max_student_enrollment',
                'batches.start_date',
                'batches.end_date',
                'batches.start_time',
                'batches.end_time',
                'batches.row_status',
                'batches.batch_status',
                'batches.created_at',
                'batches.updated_at',
            ]
        );
        $batches->join('institutes', 'batches.institute_id', '=', 'institutes.id');
        $batches->join('courses', 'batches.course_id', '=', 'courses.id');

        return DataTables::eloquent($batches)
            ->addColumn('action', DatatableHelper::getActionButtonBlock(static function (Batch $batch) use ($authUser) {
                $str = '';
                if ($authUser->can('view', $batch)) {
                    $str .= '<a href="' . route('course_management::admin.batches.show', $batch->id) . '" class="btn btn-outline-info btn-sm"> <i class="fas fa-eye"></i> ' . __('generic.read_button_label') . '</a>';
                }
                if ($authUser->can('viewBachYouth', $batch)) {
                    $str .= '<a href="' . route('course_management::admin.batches.youths', $batch->id) . '" class="btn btn-outline-success btn-sm"> <i class="fas fa-users"></i> ' . __('Trainee List') . '</a>';
                }

                if ($authUser->can('update', $batch)) {
                    $str .= '<a href="' . route('course_management::admin.batches.edit', $batch->id) . '" class="btn btn-outline-warning btn-sm"> <i class="fas fa-edit"></i> ' . __('generic.edit_button_label') . '</a>';
                }
                if ($authUser->can('delete', $batch)) {
                    $str .= '<a href="#" data-action="' . route('course_management::admin.batches.destroy', $batch->id) . '" class="btn btn-outline-danger btn-sm delete"> <i class="fas fa-trash"></i> ' . __('generic.delete_button_label') . '</a>';
                }
                return $str;
            }))
            ->addColumn('batch_status', function (Batch $batch) {
                $str = '';
                $str .= '<div class="btn-group" role="group" aria-label="Basic example">';
                if($batch->batch_status != Batch::BATCH_STATUS_COMPLETE){
                    $str .= '<a type="button" href="' . route('course_management::admin.batch-on-going', $batch->id) . '" class="btn btn-outline-secondary btn-sm '.($batch->batch_status == Batch::BATCH_STATUS_ON_GOING? 'active':'').'"> <i class="fas fa-running"></i> ' . __($batch->batch_status ==null ? 'Start the Batch':'Now On Going') . '</a>';
                }

                if($batch->batch_status != null){
                    $str .= '<a type="button" href="' . route('course_management::admin.batch-complete', $batch->id) . '" class="btn btn-outline-secondary btn-sm '.($batch->batch_status == Batch::BATCH_STATUS_COMPLETE ? ' active ':'').'"> <i class="fas fa-check-square"></i> ' .  __($batch->batch_status !=Batch::BATCH_STATUS_COMPLETE ? 'Complete Now':'Completed') . '</a>';
                }
                $str .= '</div>';
                return $str;
            })
            ->rawColumns(['action', 'batch_status'])
            ->toJson();
    }

    private function courseIdByPublishCourseId(int $publishCourseId)
    {
        return PublishCourse::findOrFail($publishCourseId)->course_id;
    }

    public function changeBatchStatus(Batch $branch, array $data): Batch
    {
        $branch->fill($data);
        $branch->save();
        return $branch;
    }

}
