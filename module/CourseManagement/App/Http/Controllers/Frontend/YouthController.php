<?php

namespace Module\CourseManagement\App\Http\Controllers\Frontend;

use App\Mail\YouthRegistrationSuccessMail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Module\CourseManagement\App\Http\Controllers\Controller;
use Module\CourseManagement\App\Models\Video;
use Module\CourseManagement\App\Models\Youth;
use Module\CourseManagement\App\Services\YouthRegistrationService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;


class YouthController extends Controller
{
    const VIEW_PATH = "course_management::frontend.";
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

        return \view(self::VIEW_PATH . 'youth.youth-profile')->with(
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
        return \view(self::VIEW_PATH . 'skill-videos');
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
                $videos->where('videos.title_en', 'LIKE', '%' . $request->input('searchQuery') . '%')
                    ->orWhere('videos.title_bn', 'LIKE', '%' . $request->input('searchQuery') . '%')
                    ->orWhere('videos.description', 'LIKE', '%' . $request->input('searchQuery') . '%')
                    ->orWhere('video_categories.title_en', 'LIKE', '%' . $request->input('searchQuery') . '%')
                    ->orWhere('video_categories.title_bn', 'LIKE', '%' . $request->input('searchQuery') . '%');
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
        return \view(self::VIEW_PATH . 'static-contents.advice-page');
    }

    public function generalAskPage(): View
    {
        return \view(self::VIEW_PATH . 'static-contents.general-ask-page');
    }

    public function contactUsPage(): View
    {
        return \view(self::VIEW_PATH . 'static-contents.contact-us-page');
    }

    public function sendMailToRecoverAccessKey(Request $request): \Illuminate\Http\RedirectResponse
    {
        $youth = Youth::where('email', $request->input('email'))->first();

        if (empty($youth)) {
            return back()->with([
                'message' => __('ইমেইল এড্রেস পাওয়া যায়নি!'),
                'alert-type' => 'error'
            ])->withInput();
        }

        $youthEmailAddress = $youth->email;
        $mailMsg = "Access Key Recovery Mail";
        $mailSubject = env("MAIL_FROM_NAME") . "- Recover access key";
        try {
            Mail::to($youthEmailAddress)->send(new \Module\CourseManagement\App\Mail\YouthRegistrationSuccessMail($mailSubject, $youth->access_key, $mailMsg));
        } catch (\Throwable $exception) {
            Log::debug($exception->getMessage());
            return back()->with([
                'message' => __('ইমেইল প্রেরণ ব্যর্থ হয়েছে'),
                'alert-type' => 'error'
            ])->withInput();
        }

        return back()->with([
            'message' => __('রিকোভারির জন্য আপনাকে ইমেইল করা হয়েছে'),
            'alert-type' => 'success'
        ]);
    }


    public function checkYouthEmailUniqueness(Request $request): JsonResponse
    {
        $youth = Youth::where('email', $request->email)->first();
        if ($youth == null) {
            return response()->json(true);
        }
        return response()->json("এই ই-মেইল টি ইতিমধ্যে ব্যবহৃত হয়েছে!");
    }

}

