<?php

namespace Module\CourseManagement\App\Http\Controllers\Frontend;

use App\Mail\YouthRegistrationSuccessMail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Module\CourseManagement\App\Http\Controllers\Controller;
use Module\CourseManagement\App\Models\Video;
use Module\CourseManagement\App\Models\Youth;
use Module\CourseManagement\App\Models\YouthFamilyMemberInfo;
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
        $test = 'amama';
        $data = [
            [
                "question" => "প্রশ্ন ১: কেন্দ্র ভিত্তিক প্রশিক্ষণ ট্রেড সমূহ কি কি?",
                "answer" => 'উত্তরঃ দয়া করে কোর্সসমূহ পাতায় দেখুন ( <a target="_blank" href="' . route('course_management::course_search') . '">এখানে ক্লিক করুন</a> ) ',
            ],
            [
                "question" => "প্রশ্ন ২: প্রশিক্ষণের বিষয়ে বিস্তারিত জানার জন্য কোথায় যোগাযোগ করব?",
                "answer" => "উত্তরঃ যোগাযোগ পাতায় দেখুন ( <a target='_blank' href='" . route('course_management::contact-us-page') . "'>এখানে ক্লিক করুন</a> )",
            ],
            [
                "question" => "প্রশ্ন ৩: প্রশিক্ষণ গ্রহণের জন্য ভর্তি ফরম কোথা থেকে এবং কিভাবে পাব?",
                "answer" => "উত্তরঃ অনলাইন আবেদন পাতা থেকে আপনার পছন্দনীয় কোর্সে ভর্তির আবেদন করুন ( <a target='_blank' href='" . route('course_management::youth-registrations.index') . "'>এখানে ক্লিক করে অনলাইন আবেদন করুন</a>)",
            ],
            [
                "question" => "প্রশ্ন ৪: নিজ বাড়িতে থেকে প্রশিক্ষণ গ্রহণের সুযোগ আছে কিনা?",
                "answer" => "উত্তরঃ বিটাক এর সকল প্রশিক্ষণ শিল্পকারখানা ভিত্তিক কারিগরি প্রশিক্ষণ। তাই নিজ বাড়িতে বসে করার সুযোগ নেই।",
            ],
            [
                "question" => "প্রশ্ন ৫: অনলাইনে কোন প্রশিক্ষণ কোর্স আছে কিনা",
                "answer" => "উত্তরঃ অনলাইনে প্রশিক্ষণের আবেদন করা যাবে কিন্তু প্রশিক্ষণ বিটাকের নির্ধারিত কেন্দ্রে এসে নিতে হবে।",
            ],
            [
                "question" => "প্রশ্ন ৬: পড়াশোনা করার পাশাপাশি প্রশিক্ষণ গ্রহণের সুযোগ আছে কিনা?",
                "answer" => "উত্তরঃ বিটাকের সকল প্রশিক্ষণ সকাল ৯ টা থেকে বিকাল ৫ টার মধ্যেই সম্পন্ন করা হয়। সান্ধ্যকালিন কোন কোর্স নেই বিটাকে।",
            ],
            [
                "question" => "প্রশ্ন ৭: বিদেশ গমনেচ্ছু প্রার্থীদের প্রশিক্ষণ গ্রহণের কোনো সুযোগ আছে কিনা?",
                "answer" => "উত্তরঃ বিদেশ গমনেচ্ছু প্রার্থী বিটাক এর কোন প্রশিক্ষণ নিজের জন্য উপযোগী মনে করলে সেটা যথাযথ প্রক্রিয়ার মাধ্যমে গ্রহন করতে পারবেন।",
            ],
            [
                "question" => "প্রশ্ন ৮: বিটাকে একটি ট্রেনিং নেওয়ার পর আরেকটি ট্রেনিং নেওয়ার কোনো সুযোগ আছে কিনা?",
                "answer" => "উত্তরঃ বিভিন্ন প্রকল্পের অধীন যে সমস্ত প্রশিক্ষণ প্রদান করা হয় সেসমস্ত প্রশিক্ষণ ব্যাতিত অন্যান্য প্রশিক্ষণ একাধিক নিতে পারবেন।",
            ],
            [
                "question" => "প্রশ্ন ৯: প্রশিক্ষণ শেষে চাকরির কোন ব্যবস্থা আছে কিনা থাকলে কোন কোন প্রতিষ্ঠান হতে পারে",
                "answer" => "উত্তরঃ বিভিন্ন প্রশিক্ষণ কোর্স সম্পন্ন হলে জব ফেয়ার আয়োজন করা হয়ে থাকে। সেখান থেকে বিভিন্ন বেসরকারি প্রতিষ্ঠান প্রশিক্ষনার্থিদের বাছাই করে চাকুরীতে নিয়োগ দিয়ে থাকে।",
            ],
            [
                "question" => "প্রশ্ন ১০: প্রতিবন্ধীদের জন্য কোনো প্রশিক্ষণ কোর্স চালু রয়েছে কিনা?",
                "answer" => "উত্তরঃ আলাদাভাবে প্রতিবন্ধীদের জন্য কোন প্রশিক্ষণ কোর্স চালু নেই।",
            ],
        ];
        return \view(self::VIEW_PATH . 'static-contents.general-ask-page', compact('data'));
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
        $mailSubject = "Youth - Account Recover Access Key";
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

    public function checkYouthUniqueNID(Request $request): JsonResponse
    {
        $youth = YouthFamilyMemberInfo::where(['nid' => $request->nid, 'relation_with_youth' => 'self'])->first();
        if ($youth == null) {
            return response()->json(true);
        }
        return response()->json("এই এন.আই.ডি নাম্বার টি ইতিমধ্যে ব্যবহৃত হয়েছে!");
    }

    public function checkYouthUniqueBarthId(Request $request): JsonResponse
    {
        $youth = YouthFamilyMemberInfo::where(['birth_certificate_no' => $request->birth_reg_no, 'relation_with_youth' => 'self'])->first();
        if ($youth == null) {
            return response()->json(true);
        }
        return response()->json("এই জন্ম সনদ টি ইতিমধ্যে ব্যবহৃত হয়েছে!");
    }

    public function checkYouthUniquePassportId(Request $request): JsonResponse
    {
        $youth = YouthFamilyMemberInfo::where(['passport_number' => $request->passport_number, 'relation_with_youth' => 'self'])->first();
        if ($youth == null) {
            return response()->json(true);
        }
        return response()->json("এই পাসপোর্ট নাম্বার টি ইতিমধ্যে ব্যবহৃত হয়েছে!");
    }

}

