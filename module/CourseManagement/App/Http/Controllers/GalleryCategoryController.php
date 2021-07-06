<?php

namespace Module\CourseManagement\App\Http\Controllers;

use App\Helpers\Classes\AuthHelper;
use Module\CourseManagement\App\Models\GalleryCategory;
use Module\CourseManagement\App\Services\GalleryCategoryService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class GalleryCategoryController extends Controller
{
    const VIEW_PATH = 'course_management::backend.gallery-categories.';
    protected GalleryCategoryService $galleryCategoryService;

    /**
     * CourseController constructor.
     * @param GalleryCategoryService $galleryCategoryService
     */
    public function __construct(GalleryCategoryService $galleryCategoryService)
    {
        $this->galleryCategoryService = $galleryCategoryService;
        $this->authorizeResource(GalleryCategory::class);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index(): View
    {
        return \view(self::VIEW_PATH . 'browse');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function create(): View
    {
        return \view(self::VIEW_PATH . 'edit-add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $validatedData = $this->galleryCategoryService->validator($request)->validate();
        try {
            $this->galleryCategoryService->createGalleryCategory($validatedData);
        } catch (\Throwable $exception) {
            Log::debug($exception->getMessage());
            return back()->with([
                'message' => __('generic.something_wrong_try_again'),
                'alert-type' => 'error'
            ]);
        }
        return back()->with([
            'message' => __('generic.object_created_successfully', ['object' => 'Gallery Category']),
            'alert-type' => 'success'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param GalleryCategory $galleryCategory
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|View
     */
    public function show(GalleryCategory $galleryCategory)
    {
        return view(self::VIEW_PATH . 'read', compact('galleryCategory'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param GalleryCategory $galleryCategory
     * @return View
     */
    public function edit(GalleryCategory $galleryCategory): View
    {
        return view(self::VIEW_PATH . 'edit-add', compact('galleryCategory'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param GalleryCategory $galleryCategory
     * @return RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, GalleryCategory $galleryCategory): RedirectResponse
    {
        $validatedData = $this->galleryCategoryService->validator($request, $galleryCategory->id)->validate();

        try {
            $this->galleryCategoryService->updateGalleryCategory($galleryCategory, $validatedData);
        } catch (\Throwable $exception) {
            Log::debug($exception->getMessage());
            return back()->with([
                'message' => __('generic.something_wrong_try_again'),
                'alert-type' => 'error'
            ]);
        }

        return back()->with([
            'message' => __('generic.object_updated_successfully', ['object' => 'Gallery Category']),
            'alert-type' => 'success'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param GalleryCategory $galleryCategory
     * @return RedirectResponse
     */
    public function destroy(GalleryCategory $galleryCategory): RedirectResponse
    {
        try {
            $this->galleryCategoryService->deleteGalleryCategory($galleryCategory);
        } catch (\Throwable $exception) {
            Log::debug($exception->getMessage());
            return back()->with([
                'message' => __('generic.something_wrong_try_again'),
                'alert-type' => 'error'
            ]);
        }

        return back()->with([
            'message' => __('generic.object_deleted_successfully', ['object' => 'Gallery Category']),
            'alert-type' => 'success'
        ]);
    }

    public function getDatatable(Request $request): JsonResponse
    {
        return $this->galleryCategoryService->getListDataForDatatable($request);
    }

    /**
     * @return View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function showFeaturedGalleries(): View
    {
//        $this->authorize('viewAny'); TODO:permission: only super admin|institute user can see this page to edit
        $currentInstitute = domainConfig('institute');
        $authUser = AuthHelper::getAuthUser();
        $albums = GalleryCategory::active();
        if ($currentInstitute) {
            $albums->where('institute_id', $currentInstitute->id);
        }
        if ($authUser->isInstituteUser()) {
            $albums->where('institute_id', $authUser->institute_id);
        }
        $albums = $albums->with('galleries')->get();

        return \view(self::VIEW_PATH . 'featured', compact('albums'));
    }

    public function changeFeaturedGalleries(Request $request): JsonResponse
    {
        $galleryCategoryId = $request->data["id"];
        $maxFeaturedGallery = $request->data["maxFeaturedGallery"];
        $isFeatured = $request->data["featured"];
        $isFeatured = $isFeatured == "true";
        $galleryCategory = GalleryCategory::find($galleryCategoryId);
        $galleryCategories = GalleryCategory::where('institute_id', $galleryCategory->institute_id)->get();

        if ($isFeatured && count($galleryCategories) > $maxFeaturedGallery) {
            return response()->json([
                'message' => 'Max ' . $maxFeaturedGallery . ' features are supported',
                'alertType' => 'error',
            ]);
        }
        //update the feature
        $galleryCategory->update(['featured' => $isFeatured]);

        return response()->json([
            'message' => __('generic.object_updated_successfully', ['object' => 'Featured Galleries']),
            'alertType' => 'success',
        ]);
    }
}
