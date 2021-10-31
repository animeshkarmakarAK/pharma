<?php


namespace Module\CourseManagement\App\Http\Controllers\Frontend;


use Module\CourseManagement\App\Models\Batch;
use Module\CourseManagement\App\Models\Gallery;
use Module\CourseManagement\App\Models\GalleryCategory;
use Module\CourseManagement\App\Models\Programme;

class galleryCategoryPageController
{
    const VIEW_PATH = "course_management::frontend.gallery-category-pages.";

    public function allGalleryCategoryPage()
    {

        $currentInstitute = domainConfig('institute');
        $galleryCategories = GalleryCategory::active()
            ->orderBy('id', 'DESC')
            ->where(['institute_id' => $currentInstitute->id])
            ->where(['featured' => 1])
            ->get();

        $programmes = Programme::where('institute_id',$currentInstitute->id)->get();
        $batches = Batch::where('institute_id',$currentInstitute->id)->get();

        return view(self::VIEW_PATH . 'gallery-categories', compact('galleryCategories','programmes','batches'));
    }

    public function singleGalleryCategoryPage(GalleryCategory $galleryCategory)
    {
        $galleryCategoryId = $galleryCategory->id;
        $today = Date('y-m-d H:i:s');
        $galleries = Gallery::where('gallery_category_id',$galleryCategoryId);
        $galleries = $galleries->where('publish_date','<=',$today);
        $galleries = $galleries->where('archive_date','>=',$today)->get();
        //$galleries = $galleryCategory->galleries;
        return view(self::VIEW_PATH . 'gallery-category', compact('galleryCategory', 'galleries'));
    }
}
