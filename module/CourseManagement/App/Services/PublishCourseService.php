<?php


namespace Module\CourseManagement\App\Services;

use App\Helpers\Classes\DatatableHelper;
use Module\CourseManagement\App\Models\CourseSession;
use Module\CourseManagement\App\Models\PublishCourse;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class PublishCourseService
{
    public function createPublishCourse(array $data): PublishCourse
    {
        $publishCourse = PublishCourse::create($data);

        foreach ($data['course_sessions'] as $session) {
            $session['course_id'] = $data['course_id'];
            $courseSessions[] = $session;
            $publishCourse->courseSessions()->create($session);
        }
        return $publishCourse;
    }

    public function validator(Request $request, $id = null): Validator
    {
        $rules = [
            'institute_id' => ['required', 'int'],
            'course_id' => ['required', 'int'],
            'training_center_id' => ['nullable', 'int'],
            'programme_id' => ['nullable', 'int'],
            'title_en' => 'nullable|int',
            'title_bn' => 'nullable|int',
            'application_form_type_id' => ['required', 'int'],
            'branch_id' => ['nullable', 'int'],
            'course_sessions' => ["required","array","min:1"],
            'course_sessions.*.session_name_en' => ['required', 'string', 'max:30'],
            'course_sessions.*.session_name_bn' => [
                'required',
                'string',
                'max:30',
                'regex:/^[\x{0980}-\x{09FF}\s\-\*!@#%\+=\._\^\'()]*$/u',
            ],
            'course_sessions.*.number_of_batches' => ['required', 'int'],
            'course_sessions.*.application_start_date' => ['required', 'date'],
            'course_sessions.*.application_end_date' => ['required', 'date'],
            'course_sessions.*.course_start_date' => ['required', 'date'],
            'course_sessions.*.max_seat_available' => ['required', 'int']
        ];

        $messages = [
            'course_sessions.*.session_name_bn.regex' => "Session name(Bangla) should be in Bangla",
        ];

        return \Illuminate\Support\Facades\Validator::make($request->all(), $rules, $messages);
    }


    public function getListDataForDatatable(Request $request): JsonResponse
    {
        /** @var Builder|PublishCourse $publishCourses */
        $publishCourses = PublishCourse::acl()->select([
            'publish_courses.id as id',
            'publish_courses.course_id',
            'publish_courses.institute_id',
            'institutes.title_en as institute_title',
            'publish_courses.application_form_type_id',
            'publish_courses.created_by',
            'users.name_en as course_publisher_name',
            'publish_courses.created_at',
            'courses.title_en as course_title',
            'branches.title_en as branch_name',
            'programmes.title_en as programme_name',
            'training_centers.title_en as training_center_name',
            'publish_courses.updated_at'
        ]);
        $publishCourses->join('courses', 'publish_courses.course_id', '=', 'courses.id');
        $publishCourses->join('institutes', 'publish_courses.institute_id', '=', 'institutes.id');
        $publishCourses->leftJoin('users', 'publish_courses.created_by', '=', 'users.id');
        $publishCourses->leftJoin('programmes', 'publish_courses.programme_id', '=', 'programmes.id');
        $publishCourses->leftJoin('branches', 'publish_courses.branch_id', '=', 'branches.id');
        $publishCourses->leftJoin('training_centers', 'publish_courses.training_center_id', '=', 'training_centers.id');

        return DataTables::eloquent($publishCourses)
            ->addColumn('action', DatatableHelper::getActionButtonBlock(static function (PublishCourse $publishCourse) {
                $str = '';
                $str .= '<a href="' . route('course_management::admin.publish-courses.show', $publishCourse->id) . '" class="btn btn-outline-info btn-sm"> <i class="fas fa-eye"></i> ' . __('generic.read_button_label') . ' </a>';
                $str .= '<a href="' . route('course_management::admin.publish-courses.edit', $publishCourse->id) . '" class="btn btn-outline-warning btn-sm"> <i class="fas fa-edit"></i> ' . __('generic.edit_button_label') . ' </a>';
                $str .= '<a href="#" data-action="' . route('course_management::admin.publish-courses.destroy', $publishCourse->id) . '" class="btn btn-outline-danger btn-sm delete"> <i class="fas fa-trash"></i> ' . __('generic.delete_button_label') . '</a>';
                return $str;
            }))
            ->rawColumns(['action'])
            ->toJson();
    }

    public function updatePublishCourse(PublishCourse $publishCourse, array $data): PublishCourse
    {
        $publishCourse->fill($data);
        $publishCourse->save();

        foreach ($data['course_sessions'] as $session) {
            $session['course_id'] = $data['course_id'];
            $courseSessions[] = $session;
            if (empty($session['id'])) {
                $publishCourse->courseSessions()->create($session);
                continue;
            }

            $courseSession = CourseSession::findOrFail($session['id']);
            if (!empty($session['delete']) && $session['delete'] == 1) {
                $courseSession->delete();
            } else {
                $courseSession->update($session);
            }
        }

        return $publishCourse;
    }

    /**
     * @throws \Exception
     */
    public function deletePublishCourse(PublishCourse $publishCourse): PublishCourse
    {
        if (!$publishCourse->delete()) {
            throw new \Exception();
        }
        return $publishCourse;
    }

}
