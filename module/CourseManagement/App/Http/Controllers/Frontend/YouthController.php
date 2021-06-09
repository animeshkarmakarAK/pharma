<?php

namespace Module\CourseManagement\App\Http\Controllers\Frontend;

use Module\CourseManagement\App\Http\Controllers\Controller;
use Module\CourseManagement\App\Models\Video;
use Module\CourseManagement\App\Models\Youth;
use Module\CourseManagement\App\Services\YouthRegistrationService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;


class YouthController extends Controller
{
    protected YouthRegistrationService $youthRegistrationService;

    public function __construct(YouthRegistrationService $youthRegistrationService)
    {
        $this->youthRegistrationService = $youthRegistrationService;
    }

    /**
     * Display a listing of the resource.
     *
     * @param $id
     * @return View
     */
    public function index($id): View
    {
        $youth = Youth::findOrFail($id);

        $youth->load([
            'youthRegistration',
        ]);
        $youthFamilyMembers = $this->youthRegistrationService->getYouthFamilyMemberInfo($youth);

        return \view('frontend.youth.youth-profile')->with(
            [
                'youth' => $youth,
                'father' => $youthFamilyMembers['father'],
                'mother' => $youthFamilyMembers['mother'],
                'guardian' => $youthFamilyMembers['guardian'],
                'haveYouthFamilyMembersInfo' => $youthFamilyMembers['haveYouthFamilyMembersInfo'],
            ]);

    }

    public function videos(): View
    {
        return \view('frontend.skill-videos');
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function videoSearch(Request $request): JsonResponse
    {
        if ($request->json()) {

            $videos = Video::select([
                'videos.id as id',
                'videos.title_en',
                'videos.title_bn',
                'videos.description',
                'videos.youtube_video_id',
                'videos.video_type',
                'videos.uploaded_video_path',
                'videos.institute_id',
                'videos.video_category_id',
                'videos.created_at',
                'videos.updated_at',
            ]);
            $videos->where('videos.row_status', Video::ROW_STATUS_ACTIVE);
            $videos->leftJoin('video_categories', 'video_category_id', '=', 'video_categories.id');

            if ($request->input('searchQuery')) {
                $videos->where('videos.title_en', 'LIKE', '%'.$request->input('searchQuery').'%')
                    ->orWhere('videos.title_bn', 'LIKE', '%'.$request->input('searchQuery').'%')
                    ->orWhere('videos.description', 'LIKE', '%'.$request->input('searchQuery').'%')
                    ->orWhere('video_categories.title_en', 'LIKE', '%'.$request->input('searchQuery').'%')
                    ->orWhere('video_categories.title_bn', 'LIKE', '%'.$request->input('searchQuery').'%');
            }

            if (!empty($request->input('institute_id'))) {
                $videos->where('videos.institute_id', $request->input('institute_id'));
            }
            if (!empty($request->input('video_category_id'))) {
                $videos->where('videos.video_category_id', $request->input('video_category_id'));
            }

            if (!empty($request->input('video_id'))) {
                $videos->where('videos.id', $request->input('video_id'));
            }
            $videos = $videos->paginate(15);


            return response()->json([
                'videos' => $videos,
                'links' => $videos->links()->render(),
            ]);
        }
    }

    public function advicePage(): View
    {
        return \view('frontend.static-contents.advice-page');

    }

    public function generalAskPage(): View
    {
        return \view('frontend.static-contents.general-ask-page');

    }

    public function contactUsPage(): View
    {
        return \view('frontend.static-contents.contact-us-page');

    }
}

