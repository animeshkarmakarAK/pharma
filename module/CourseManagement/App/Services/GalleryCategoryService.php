<?php

namespace Module\CourseManagement\App\Services;

use App\Helpers\Classes\AuthHelper;
use App\Helpers\Classes\DatatableHelper;
use Module\CourseManagement\App\Models\GalleryCategory;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;


class GalleryCategoryService
{
    public function createGalleryCategory(array $data): GalleryCategory
    {
        return GalleryCategory::create($data);
    }

    /**
     * @param Request $request
     * @param null $id
     * @return Validator
     */
    public function validator(Request $request): Validator
    {
        $rules = [
            'title_en' => ['required', 'string', 'max:191'],
            'title_bn' => ['required', 'string', 'max:191'],
            'institute_id' => ['required', 'int', 'exists:institutes,id'],
        ];
        return \Illuminate\Support\Facades\Validator::make($request->all(), $rules);
    }

    /**
     * @param GalleryCategory $galleryCategory
     * @param array $data
     * @return GalleryCategory
     */
    public function updateGalleryCategory(GalleryCategory $galleryCategory, array $data): GalleryCategory
    {
        $galleryCategory->fill($data);
        $galleryCategory->save();
        return $galleryCategory;
    }


    /**
     * @param GalleryCategory $galleryCategory
     * @return bool
     * @throws \Exception
     */
    public function deleteGalleryCategory(GalleryCategory $galleryCategory): bool
    {
        return $galleryCategory->delete();
    }


    public function getListDataForDatatable(Request $request): JsonResponse
    {
        $authUser = AuthHelper::getAuthUser();

        /** @var Builder|GalleryCategory $galleryCategories */
        $galleryCategories = GalleryCategory::select([
            'gallery_categories.id',
            'gallery_categories.title_en',
            'gallery_categories.title_bn',
            'institutes.title_en as institute_title_en'
        ]);
        $galleryCategories->join('institutes', 'gallery_categories.institute_id', 'institutes.id');

        return DataTables::eloquent($galleryCategories)
            ->addColumn('action', DatatableHelper::getActionButtonBlock(static function (GalleryCategory $galleryCategory) use ($authUser) {
                $str = '';
                if ($authUser->can('view', $galleryCategory)) {
                    $str .= '<a href="' . route('admin.gallery-categories.show', $galleryCategory->id) . '" class="btn btn-outline-info btn-sm"> <i class="fas fa-eye"></i> ' . __('generic.read_button_label') . ' </a>';
                }
                if ($authUser->can('update', $galleryCategory)) {

                    $str .= '<a href="' . route('admin.gallery-categories.edit', $galleryCategory->id) . '" class="btn btn-outline-warning btn-sm"> <i class="fas fa-edit"></i> ' . __('generic.edit_button_label') . ' </a>';
                }
                if ($authUser->can('delete', $galleryCategory)) {
                    $str .= '<a href="#" data-action="' . route('admin.gallery-categories.destroy', $galleryCategory->id) . '" class="btn btn-outline-danger btn-sm delete"> <i class="fas fa-trash"></i> ' . __('generic.delete_button_label') . '</a>';
                }
                return $str;
            }))
            ->rawColumns(['action'])
            ->toJson();
    }
}
