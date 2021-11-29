<?php


namespace Module\CourseManagement\App\Services;


use App\Helpers\Classes\AuthHelper;
use Module\CourseManagement\App\Models\VideoCategory;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Yajra\DataTables\Facades\DataTables;

class VideoCategoryService
{
    public function createVideoCategory(array $data)
    {
        return VideoCategory::create($data);
    }

    public function updateVideoCategory(VideoCategory $videoCategory, $data): bool
    {
        return $videoCategory->update($data);
    }


    public function validator($request, $id = null): Validator
    {
        $rules = [
            'title_en' => [
                'required',
                'string',
                'max:191',
            ],
            'institute_id' => [
                'required',
                'int',
                'exists:institutes,id',
            ],
            'parent_id' => [
                'nullable',
                'int',
                'exists:video_categories,id',
            ],
            'row_status' =>[
              'nullable',
              'int',
              'exists:row_status,code',
            ],
        ];

        return \Illuminate\Support\Facades\Validator::make($request->all(), $rules);
    }

    public function getListDataForDatatable(\Illuminate\Http\Request $request): JsonResponse
    {
        $authUser = AuthHelper::getAuthUser();
        /** @var Builder|VideoCategory $videoCategory */

        $videoCategories = VideoCategory::acl()->select([
            'video_categories.id as id',
            'video_categories.title_en',
            'video_categories.parent_id',
//            'parent.title_en as video_parent_category_title_en',
            'video_categories.created_at',
            'video_categories.updated_at',
            'institutes.title_en as institute_name',
            'video_categories.row_status',
        ]);

        $videoCategories->join('institutes', 'video_categories.institute_id','=', 'institutes.id');
//        $videoCategories->leftJoin('video_categories as parent', 'parent.parent_id','=', 'video_categories.id');

        return DataTables::eloquent($videoCategories)
            ->addColumn('parent', static function(VideoCategory  $videoCategory){
                $parent = VideoCategory::find($videoCategory->parent_id);
                return $parent ? $parent->title_en : "N/A";
            })
            ->addColumn('action', static function (VideoCategory $videoCategory) use ($authUser) {
                $str = '';
                if ($authUser->can('view', $videoCategory)) {
                    $str .= '<a href="' . route('course_management::admin.video-categories.show', $videoCategory->id) . '" class="btn btn-outline-info btn-sm"> <i class="fas fa-eye"></i> ' . __('generic.read_button_label') . ' </a>';
                }

                if ($authUser->can('update', $videoCategory)) {
                    $str .= '<a href="' . route('course_management::admin.video-categories.edit', $videoCategory->id) . '" class="btn btn-outline-warning btn-sm"> <i class="fas fa-edit"></i> ' . __('generic.edit_button_label') . ' </a>';
                }
                if ($authUser->can('delete', $videoCategory)) {
                    $str .= '<a href="#" data-action="' . route('course_management::admin.video-categories.destroy', $videoCategory->id) . '" class="btn btn-outline-danger btn-sm delete"> <i class="fas fa-trash"></i> ' . __('generic.delete_button_label') . '</a>';
                }

                return $str;
            })
            ->editColumn('row_status', function (VideoCategory $videoCategory) {
                return $videoCategory->getCurrentRowStatus(true);
            })
            ->rawColumns(['action', 'parent', 'row_status'])
            ->toJson();
    }
}
