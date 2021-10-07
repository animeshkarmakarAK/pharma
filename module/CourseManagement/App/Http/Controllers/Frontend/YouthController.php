<?php

namespace Module\CourseManagement\App\Http\Controllers\Frontend;

use App\Mail\YouthRegistrationSuccessMail;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Module\CourseManagement\App\Http\Controllers\Controller;
use Module\CourseManagement\App\Models\Payment;
use Module\CourseManagement\App\Models\Video;
use Module\CourseManagement\App\Models\Youth;
use Module\CourseManagement\App\Models\YouthAcademicQualification;
use Module\CourseManagement\App\Models\YouthCourseEnroll;
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
     * @return \Illuminate\Contracts\Foundation\Application|View|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function index($id)
    {
        $youthId = auth()->guard('youth')->user()->id;
        if ($id != $youthId) {
            return redirect()->back()->with(['message' => 'wrong url', 'alert-type' => 'error']);
        }

        $youth = Youth::findOrFail($youthId);

        $youth->load([
            'youthRegistration',
        ]);
        $academicQualifications = YouthAcademicQualification::where(['youth_id' => $youth->id])->get();

        $youthSelfInfo = YouthFamilyMemberInfo::where(['youth_id' => $youth->id, 'relation_with_youth' => 'self'])->first();

        $youthFamilyMembers = $this->youthRegistrationService->getYouthFamilyMemberInfo($youth);

        return \view(self::VIEW_PATH . 'youth.youth-profile')->with(
            [
                'youth' => $youth,
                'father' => $youthFamilyMembers['father'],
                'mother' => $youthFamilyMembers['mother'],
                'guardian' => $youthFamilyMembers['guardian'],
                'haveYouthFamilyMembersInfo' => $youthFamilyMembers['haveYouthFamilyMembersInfo'],
                'youthSelfInfo' => $youthSelfInfo,
                'academicQualifications' => $academicQualifications,
            ]);
    }

    public function youthEnrolledCourses($id)
    {
        if(!auth()->guard('youth')->user()){
            return redirect()->route('course_management::youth.login-form');
        }
        $youthId = auth()->guard('youth')->user()->id;
        if ($id != $youthId) {
            return redirect()->back()->with(['message' => 'wrong url', 'alert-type' => 'error']);
        }

        $youth = Youth::findOrFail($youthId);

        $youth->load([
            'youthRegistration',
        ]);
        $academicQualifications = YouthAcademicQualification::where(['youth_id' => $youth->id])->get();

        $youthSelfInfo = YouthFamilyMemberInfo::where(['youth_id' => $youth->id, 'relation_with_youth' => 'self'])->first();

        $youthFamilyMembers = $this->youthRegistrationService->getYouthFamilyMemberInfo($youth);

        return \view(self::VIEW_PATH . 'youth.youth-courses')->with(
            [
                'youth' => $youth,
                'father' => $youthFamilyMembers['father'],
                'mother' => $youthFamilyMembers['mother'],
                'guardian' => $youthFamilyMembers['guardian'],
                'haveYouthFamilyMembersInfo' => $youthFamilyMembers['haveYouthFamilyMembersInfo'],
                'youthSelfInfo' => $youthSelfInfo,
                'academicQualifications' => $academicQualifications,
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
                'message' => __('কারিগরি সমস্যা, দয়া করে আবার চেষ্টা করুন'),
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
        $youthNidNo = YouthFamilyMemberInfo::where(['nid' => $request->nid, 'relation_with_youth' => 'self'])->first();

        if ($youthNidNo == null) {
            return response()->json(true);
        }
        return response()->json("এই এন.আই.ডি দ্বারা ইতিমধ্যে রেজিস্ট্রেশন করা হয়েছে!");
    }

    public function checkYouthUniqueBirthCertificateNo(Request $request): JsonResponse
    {
        $youthBirthNo = YouthFamilyMemberInfo::where(['birth_certificate_no' => $request->birth_certificate_no, 'relation_with_youth' => 'self'])->first();
        if ($youthBirthNo == null) {
            return response()->json(true);
        }
        return response()->json("এই জন্ম সনদ দ্বারা ইতিমধ্যে রেজিস্ট্রেশন করা হয়েছে!");
    }

    public function checkYouthUniquePassportId(Request $request): JsonResponse
    {
        $youthPassportNo = YouthFamilyMemberInfo::where(['passport_number' => $request->passport_number, 'relation_with_youth' => 'self'])->first();
        if ($youthPassportNo == null) {
            return response()->json(true);
        }
        return response()->json("এই পাসপোর্ট দ্বারা ইতিমধ্যে রেজিস্ট্রেশন করা হয়েছে!");
        //ইতিমধ্যে এই নম্বর দ্বারা নিবন্ধিত
    }

    public function youthCourseGetDatatable(Request $request): JsonResponse
    {
        return $this->youthRegistrationService->getListDataForDatatable($request);
    }

    public function youthCourseEnrollPayNow($youthCourseEnroll)
    {
        $YouthCourseEnroll = YouthCourseEnroll::findOrFail($youthCourseEnroll);
        $youthId = $YouthCourseEnroll->youth_id;
        $userInfo['id'] = $YouthCourseEnroll->id;
        $userInfo['youth_id'] = $YouthCourseEnroll->youth_id;
        $userInfo['mobile'] = $YouthCourseEnroll->youth->mobile;
        $userInfo['email'] = $YouthCourseEnroll->youth->email;
        $userInfo['address'] = "Dhaka-1212";
        $userInfo['name'] = $YouthCourseEnroll->youth->name_en;

        $paymentInfo['trID'] = $youthId . rand(100, 999);
        $paymentInfo['amount'] = $YouthCourseEnroll->publishCourse->course->course_fee;
        $paymentInfo['orderID'] = $YouthCourseEnroll->id;

        $activeDebug = true;

        $token = $this->ekPayPaymentGateway($userInfo, $paymentInfo, $activeDebug);
        if (!empty($token)) {
            $token = 'https://sandbox.ekpay.gov.bd/ekpaypg/v1?sToken=' . $token . '&trnsID=' . $paymentInfo['trID'];
        }

        return redirect($token);
    }

    public function ekPayPaymentGateway($userInfo, $paymentInfo, $activeDebug = false)
    {
        $marchantID = 'eporcha_test';
        $marchantKey = 'EprCsa@tST12';
        $mac_addr = '1.1.1.1';
        $applicationURL = route('/');

        $time = Carbon::now()->format('Y-m-d H:i:s');

        $customerCleanName = preg_replace('/[^A-Za-z0-9 \-\.]/', '', $userInfo['name']);

        $data = '{
           "mer_info":{
              "mer_reg_id":"' . $marchantID . '",
              "mer_pas_key":"' . $marchantKey . '"
           },
           "req_timestamp":"' . $time . ' GMT+6",
           "feed_uri":{
              "s_uri":"' . $applicationURL . '/success",
              "f_uri":"' . $applicationURL. '/fail",
              "c_uri":"' . $applicationURL . '/cancel"
           },
           "cust_info":{
              "cust_id":"' . $userInfo['id'] . '",
              "cust_name":"' . $customerCleanName . '",
              "cust_mobo_no":"' . $userInfo['mobile'] . '",
              "cust_email":"' . $userInfo['email'] . '",
              "cust_mail_addr":"' . $userInfo['address'] . '"
           },
           "trns_info":{
              "trnx_id":"' . $paymentInfo['trID'] . '",
              "trnx_amt":"' . $paymentInfo['amount'] . '",
              "trnx_currency":"BDT",
              "ord_id":"' . $paymentInfo['orderID'] . '",
			  "ord_det":"course_fee"
           },
           "ipn_info":{
              "ipn_channel":"1",
              "ipn_email":"imiladul@gmail.com",
              "ipn_uri":"' . $applicationURL . '/api/ipn-handler"
           },
           "mac_addr":"' . $mac_addr . '"
        }';

        $url = 'https://sandbox.ekpay.gov.bd/ekpaypg/v1/merchant-api';

        if ($activeDebug) {
            Log::debug("Youth Name: ".$userInfo['name']. ' , Youth Enroll ID: '.$paymentInfo['orderID']);
            Log::debug($data);
        }
        try {
            // Setup cURL
            $ch = \curl_init($url);
            \curl_setopt_array($ch, array(
                CURLOPT_POST => TRUE,
                CURLOPT_RETURNTRANSFER => TRUE,
                CURLOPT_HTTPHEADER => array(
                    //'Authorization: '.$authToken,
                    'Content-Type: application/json'
                ),
                CURLOPT_POSTFIELDS => $data,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_SSL_VERIFYHOST => 0,
                CURLOPT_SSL_VERIFYPEER => 0
            ));

            // Send the request
            $response = \curl_exec($ch);
        } catch (\Exception $exception) {
            //ipnLog("Curl request failed." . $exception->getMessage());
        }

        // Decode the response
        $responseData = json_decode($response, TRUE);
        return $responseData['secure_token'];
    }

    public function ipnHandler(Request $request)
    {
        $data['youth_course_enroll_id'] = $request->cust_info['cust_id'];
        $data['cust_name'] = $request->cust_info['cust_name'];
        $data['cust_mobo_no'] = $request->cust_info['cust_mobo_no'];
        $data['cust_email'] = $request->cust_info['cust_email'];
        $data['cust_mail_addr'] = $request->cust_info['cust_mail_addr'];

        $data['log'] = $request/*->msg_det . ' msg_code:' . $request->msg_code*/;
        $data['payment_type'] = $request->pi_det_info['pi_type'];
        //$data['payment_date'] = explode(' ', $request->req_timestamp)[0];
        $data['payment_date'] = Carbon::now();
        $data['payment_status'] = $request->msg_code == 100 ? '1' : '2';


        $data['transaction_id'] = $request->trnx_info['trnx_id'];
        $data['mer_trnx_id'] = $request->trnx_info['mer_trnx_id'];
        $data['amount'] = $request->trnx_info['trnx_amt'];
        $data['curr'] = $request->trnx_info['curr'];
        $data['pi_trnx_id'] = $request->trnx_info['pi_trnx_id'];
        //$data['pi_charge'] = $request->trnx_info['pi_charge'];
        $data['ekpay_charge'] = $request->trnx_info['ekpay_charge'];
        $data['pi_discount'] = $request->trnx_info['pi_discount'];
        $data['total_ser_chrg'] = $request->trnx_info['total_ser_chrg'];
        $data['discount'] = $request->trnx_info['discount'];
        $data['promo_discount'] = $request->trnx_info['promo_discount'];
        $data['total_pabl_amt'] = $request->trnx_info['total_pabl_amt'];


        //dd($request->all());
        if (!empty($request)) {
            Log::debug("SandBox Request");
            Log::debug($request);
        }

        $payment = new Payment();
        $payment->fill($data);
        $payment->save();

        $youthCourseEnroll = YouthCourseEnroll::findOrFail($data['youth_course_enroll_id']);
        $newData['payment_status'] = YouthCourseEnroll::PAYMENT_STATUS_PAID;

        if ($youthCourseEnroll->enroll_status == YouthCourseEnroll::ENROLL_STATUS_ACCEPT){
            $youthCourseEnroll->update($newData);
        }
    }
}

