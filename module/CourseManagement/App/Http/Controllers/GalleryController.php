<?php

namespace Module\CourseManagement\App\Http\Controllers;

use Module\CourseManagement\App\Models\Gallery;
use Module\CourseManagement\App\Models\Institute;
use Module\CourseManagement\App\Services\GalleryService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class GalleryController extends Controller
{
    const VIEW_PATH = 'course_management::backend.galleries.';
    protected GalleryService $galleryService;

    /**
     * CourseController constructor.
     * @param GalleryService $galleryService
     */
    public function __construct(GalleryService $galleryService)
    {
        $this->galleryService = $galleryService;
        $this->authorizeResource(Gallery::class);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return \view(self::VIEW_PATH . 'browse');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $institutes = Institute::acl()->active()->get();
        return \view(self::VIEW_PATH . 'edit-add', compact( 'institutes'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): \Illuminate\Http\RedirectResponse
    {
        $galleryValidatedData = $this->galleryService->validator($request)->validate();
        try {
            $this->galleryService->createGallery($galleryValidatedData);
        } catch (\Throwable $exception) {
            Log::debug($exception->getMessage());
            return back()->with([
                'message' => __('generic.something_wrong_try_again'),
                'alert-type' => 'error'
            ]);
        }
        return redirect()->route('course_management::admin.galleries.index')->with([
            'message' => __('generic.object_created_successfully', ['object' => 'Gallery']),
            'alert-type' => 'success'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  Module\CourseManagement\App\Models\Gallery  $gallery
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function show(Gallery $gallery)
    {
        return \view(self::VIEW_PATH . 'read', compact('gallery'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Module\CourseManagement\App\Models\Gallery  $gallery
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function edit(Gallery $gallery)
    {
        $institutes = Institute::acl()->active()->get();

        return \view(self::VIEW_PATH . 'edit-add', compact('gallery', 'institutes'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Module\CourseManagement\App\Models\Gallery  $gallery
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Gallery $gallery): \Illuminate\Http\RedirectResponse
    {
        $galleryValidatedData = $this->galleryService->validator($request)->validate();

        try {
            $this->galleryService->updateGallery($gallery, $galleryValidatedData);
        } catch (\Throwable $exception) {
            Log::debug($exception->getMessage());
            return back()->with([
                'message' => __('generic.something_wrong_try_again'),
                'alert-type' => 'error'
            ]);
        }

        return redirect()->route('course_management::admin.galleries.index')->with([
            'message' => __('generic.object_updated_successfully', ['object' => 'Gallery']),
            'alert-type' => 'success'
        ]);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  Module\CourseManagement\App\Models\Gallery  $gallery
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Gallery $gallery): \Illuminate\Http\RedirectResponse
    {
        try {
            $this->galleryService->deleteGallery($gallery);
        } catch (\Throwable $exception) {
            Log::debug($exception->getMessage());
            return back()->with([
                'message' => __('generic.something_wrong_try_again'),
                'alert-type' => 'error'
            ]);
        }

        return back()->with([
            'message' => __('generic.object_deleted_successfully', ['object' => 'gallery']),
            'alert-type' => 'success'
        ]);
    }

    public function getDatatable(Request $request): JsonResponse
    {
        return $this->galleryService->getListDataForDatatable($request);
    }
}
