<?php


namespace Module\CourseManagement\App\Http\Controllers\Frontend;


use Module\CourseManagement\App\Models\GalleryCategory;

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
        return view(self::VIEW_PATH . 'gallery-categories', compact('galleryCategories'));
    }

    public function singleGalleryCategoryPage(GalleryCategory $galleryCategory)
    {
        $galleries = $galleryCategory->galleries;
        return view(self::VIEW_PATH . 'gallery-category', compact('galleryCategory', 'galleries'));
    }
}
