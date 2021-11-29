<?php

namespace Module\CourseManagement\App\Services;


use App\Helpers\Classes\AuthHelper;
use App\Helpers\Classes\DatatableHelper;
use App\Helpers\Classes\FileHandler;
use Module\CourseManagement\App\Models\Course;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;


class CourseService
{
    public function createCourse(array $data): Course
    {
        $filename = null;
        if (!empty($data['cover_image'])) {
            $filename = FileHandler::storePhoto($data['cover_image'], 'course');
        }
        if ($filename) {
            $data['cover_image'] = 'course/' . $filename;
        } else {
            $data['cover_image'] = Course::DEFAULT_COVER_IMAGE;
        }

        return Course::create($data);
    }

    /**
     * @param Request $request
     * @param null $id
     * @return Validator
     */
    public function validator(Request $request, $id = null): Validator
    {
        $rules = [
            'title_en' => [
                'required',
                'string',
                'max:191'
            ],
            'code' => [
                'required',
                'string',
                'max:191',
                'unique:courses,code,'.$id
            ],
            'course_fee' => [
                'required',
                'min:0'
            ],
            'duration' => [
                'nullable',
                'string',
                'max: 30',
            ],
            'target_group' => [
                'nullable',
                'string',
                'max: 5000',
            ],
            'objects' => [
                'nullable',
                'string',
                'max: 5000',
            ],
            'contents' => [
                'nullable',
                'string',
                'max: 5000',
            ],
            'training_methodology' => [
                'nullable',
                'string',
                'max: 5000',
            ],
            'evaluation_system' => [
                'nullable',
                'string',
                'max: 5000',
            ],
            'description' => [
                'nullable',
                'string',
                'max:5000'
            ],
            'prerequisite' => [
                'nullable',
                'string',
                'max:5000'
            ],
            'eligibility' => [
                'nullable',
                'string',
                'max:5000'
            ],
            'institute_id' => [
                'required',
                'int'
            ],
            'cover_image' => [
                'nullable',
                'image',
                'mimes:jpg,bmp,png,jpeg,svg',
                'max:500',
                'dimensions:width=820,height=312'
            ]
        ];

        return \Illuminate\Support\Facades\Validator::make($request->all(), $rules);
    }


    /**
     * @param Course $course
     * @param Request $request
     * @return bool
     * @throws \Exception
     */
    public function updateCourse(Course $course, Request $request): Course
    {
        $data = $request->all();

        if (!empty($data['cover_image'])) {
            if (!empty($course->cover_image) && $course->cover_image !== Course::DEFAULT_COVER_IMAGE) {
                FileHandler::deleteFile($course->cover_image);
            }

            $filename = FileHandler::storePhoto($data['cover_image'], 'course');
            if ($filename) {
                $data['cover_image'] = 'course/' . $filename;
            } else {
                $data['cover_image'] = Course::DEFAULT_COVER_IMAGE;
            }
        }
        $course->fill($data);
        if (!$course->save()) {
            throw new \Exception();
        }

        return $course;
    }


    /**
     * @param Course $course
     * @return Course
     * @throws \Exception
     */
    public function deleteCourse(Course $course): bool
    {
        if (!$course->delete()) {
            throw new \Exception('Unable to delete course.');
        }
        return true;
    }


    public function getListDataForDatatable(Request $request): JsonResponse
    {
        $authUser = AuthHelper::getAuthUser();
        /** @var Builder|Course $courses */

        $courses = Course::acl()->select([
            'courses.id as id',
            'courses.title_en',
            'courses.duration',
            'courses.code',
            'courses.course_fee',
            'courses.target_group',
            'courses.contents',
            'courses.objects',
            'courses.training_methodology',
            'courses.evaluation_system',
            'courses.row_status',
            'courses.created_at',
            'courses.updated_at',
            'institutes.title_en as institute_title',
        ]);
        $courses->join('institutes', 'courses.institute_id', '=', 'institutes.id');

        return DataTables::eloquent($courses)
            ->addColumn('action', DatatableHelper::getActionButtonBlock(static function (Course $course) use ($authUser) {
                $str = '';
                if ($authUser->can('view', $course)) {
                    $str .= '<a href="' . route('course_management::admin.courses.show', $course->id) . '" class="btn btn-outline-info btn-sm"> <i class="fas fa-eye"></i> ' . __('generic.read_button_label') . ' </a>';
                }
                if ($authUser->can('update', $course)) {

                    $str .= '<a href="' . route('course_management::admin.courses.edit', $course->id) . '" class="btn btn-outline-warning btn-sm"> <i class="fas fa-edit"></i> ' . __('generic.edit_button_label') . ' </a>';
                }
                if ($authUser->can('delete', $course)) {
                    $str .= '<a href="#" data-action="' . route('course_management::admin.courses.destroy', $course->id) . '" class="btn btn-outline-danger btn-sm delete"> <i class="fas fa-trash"></i> ' . __('generic.delete_button_label') . '</a>';
                }
                return $str;
            }))
            ->editColumn('row_status', function (Course $course) {
                return $course->getCurrentRowStatus(true);
            })
            ->rawColumns(['action','row_status'])
            ->toJson();
    }
}
