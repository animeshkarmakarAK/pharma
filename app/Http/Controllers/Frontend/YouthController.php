<?php

namespace App\Http\Controllers\Frontend;

use App\Helpers\Classes\AuthHelper;
use App\Http\Controllers\Controller;
use App\Models\Institute;
use App\Models\Payment;
use App\Models\QuestionAnswer;
use App\Models\Video;
use App\Models\VideoCategory;
use App\Models\Youth;
use App\Models\YouthAcademicQualification;
use App\Models\YouthBatch;
use App\Models\YouthCourseEnroll;
use App\Models\YouthFamilyMemberInfo;
use App\Services\CertificateGenerator;
use App\Services\YouthRegistrationService;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;


class YouthController extends Controller
{
    const VIEW_PATH = "frontend.";
    protected YouthRegistrationService $youthRegistrationService;

    public function __construct(YouthRegistrationService $youthRegistrationService)
    {
        $this->youthRegistrationService = $youthRegistrationService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $youth = AuthHelper::getAuthUser('youth');

        if (!$youth) {
            return redirect()->route('frontend.youth.login-form')->with([
                    'message' => 'You are not Auth user, Please login',
                    'alert-type' => 'error']
            );
        }

        $youth = Youth::findOrFail($youth->id);

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

    public function youthEnrolledCourses()
    {
        $youth = AuthHelper::getAuthUser('youth');
        if (!$youth) {
            return redirect()->route('frontend.youth.login-form')->with([
                    'message' => 'You are not Auth user, Please login',
                    'alert-type' => 'error']
            );
        }

        $youth = Youth::findOrFail($youth->id);

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

    public function youthCertificateView(YouthCourseEnroll $youthCourseEnroll)
    {
        $youth = AuthHelper::getAuthUser('youth');

        if (!$youth) {
            return redirect()->route('frontend.youth.login-form')->with([
                    'message' => 'You are not Auth user, Please login',
                    'alert-type' => 'error']
            );
        }

        $youthBatch = YouthBatch::where(['youth_course_enroll_id' => $youthCourseEnroll->id])->first();

        $familyInfo = YouthFamilyMemberInfo::where("youth_id", $youthCourseEnroll->youth_id)->where('relation_with_youth', "father")->first();
        $institute = $youthCourseEnroll->publishCourse->institute;
        $path = "youth-certificates/" . date('Y/F/', strtotime($youthBatch->batch->start_date)) . "course/" . Str::slug($youthCourseEnroll->publishCourse->course->title) . "/batch/" . $youthBatch->batch->title;

        $youthInfo = [
            'youth_id' => $youthCourseEnroll->youth_id,
            'youth_name' => $youthCourseEnroll->youth->name,
            'youth_father_name' => $familyInfo->member_name,
            'publish_course_id' => $youthCourseEnroll->publish_course_id,
            'publish_course_name' => $youthCourseEnroll->publishCourse->course->title,
            'path' => $path,
            "register_no" => $youthCourseEnroll->youth->youth_registration_no,
            'institute_title' => $institute->title,
            'from_date' => $youthBatch->batch->start_date,
            'to_date' => $youthBatch->batch->end_date,
            'batch_name' => $youthBatch->batch->title,
            'course_coordinator_signature' => "storage/{$youthBatch->batch->trainingCenter->course_coordinator_signature}",
            'course_director_signature' => "storage/{$youthBatch->batch->trainingCenter->course_director_signature}",
        ];

        $template = 'frontend.youth/certificate/certificate-one';
        $pdf = app(CertificateGenerator::class);
        return redirect(asset("storage/" . $pdf->generateCertificate($template, $youthInfo)));
    }

    public function videos(): View
    {
        $currentInstitute = app('currentInstitute');

        $youthVideoCategories = VideoCategory::query();
        $youthVideos = Video::query();

        if ($currentInstitute) {
            $youthVideoCategories->where(['institute_id' => $currentInstitute->id]);
            $youthVideos->where(['institute_id' => $currentInstitute->id]);
        }

        $youthVideoCategories = $youthVideoCategories->get();
        $youthVideos = $youthVideos->get();

        return \view(self::VIEW_PATH . 'skill-videos', compact('youthVideos', 'youthVideoCategories'));
    }

    public function singleVideo($videoId): View
    {
        $youthVideos = Video::findOrFail($videoId);
        return \view(self::VIEW_PATH . 'skill-single-video', compact('youthVideos'));
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
                'videos.title',
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
                $videos->where('videos.title', 'LIKE', '%' . $request->input('searchQuery') . '%')
                    ->orWhere('videos.title', 'LIKE', '%' . $request->input('searchQuery') . '%')
                    ->orWhere('videos.description', 'LIKE', '%' . $request->input('searchQuery') . '%')
                    ->orWhere('video_categories.title', 'LIKE', '%' . $request->input('searchQuery') . '%');
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
        $currentInstitute = app('currentInstitute');
        if (!$currentInstitute) {
            abort(404, 'Not found');
        }

        return \view(self::VIEW_PATH . 'static-contents.advice-page', compact('currentInstitute'));
    }

    public function generalAskPage(): View
    {
        /** @var Institute $currentInstitute */
        $currentInstitute = app('currentInstitute');

        /** @var QuestionAnswer|Builder $faqs */
        $faqs = QuestionAnswer::query();

        if ($currentInstitute) {
            $faqs->where('institute_id', $currentInstitute->id);
        } else {
            $faqs->withoutInstitute();
        }
        $faqs = $faqs->get();

        return \view(self::VIEW_PATH . 'static-contents.general-ask-page', compact('faqs'));
    }

    public function contactUsPage(): View
    {
        /** @var Institute $currentInstitute */
        $currentInstitute = app('currentInstitute');
        if (!$currentInstitute) {
            abort(404, 'Not found');
        }

        return \view(self::VIEW_PATH . 'static-contents.contact-us-page', compact('currentInstitute'));
    }

    public function sendMailToRecoverAccessKey(Request $request): RedirectResponse
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
            Mail::to($youthEmailAddress)->send(new \App\Mail\YouthRegistrationSuccessMail($mailSubject, $youth->access_key, $mailMsg));
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
        $userInfo['name'] = $YouthCourseEnroll->youth->name;

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
        /*$marchantID = 'eporcha_test';
        $marchantKey = 'EprCsa@tST12';*/

        $merchantID = 'nise_test';
        $merchantKey = 'NiSe@TsT11';

        $macAddress = '1.1.1.1';
        $applicationURL = route('frontend.main');

        $time = Carbon::now()->format('Y-m-d H:i:s');

        $customerCleanName = preg_replace('/[^A-Za-z0-9 \-\.]/', '', $userInfo['name']);

        $data = '{
           "mer_info":{
              "mer_reg_id":"' . $merchantID . '",
              "mer_pas_key":"' . $merchantKey . '"
           },
           "req_timestamp":"' . $time . ' GMT+6",
           "feed_uri":{
              "s_uri":"' . $applicationURL . '/success",
              "f_uri":"' . $applicationURL . '/fail",
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
           "mac_addr":"' . $macAddress . '"
        }';

        $url = 'https://sandbox.ekpay.gov.bd/ekpaypg/v1/merchant-api';

        if ($activeDebug) {
            Log::debug("Youth Name: " . $userInfo['name'] . ' , Youth Enroll ID: ' . $paymentInfo['orderID']);
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
        if (!empty($request)) {
            Log::debug("=========================================");

            Log::debug("SandBox Request: ");
            Log::debug($request);

            Log::debug("=========================================");
        }

        Log::debug("=============Debug=============");
        Log::debug($request->msg_code);
        Log::debug($request->cust_info['cust_id']);
        Log::debug("===============================");


        if ($request->msg_code == 1020) {
            $youthCourseEnroll = YouthCourseEnroll::findOrFail($request->cust_info['cust_id']);


            $newData['payment_status'] = YouthCourseEnroll::PAYMENT_STATUS_PAID;

            if ($youthCourseEnroll->enroll_status == YouthCourseEnroll::ENROLL_STATUS_ACCEPT) {
                $youthCourseEnroll->update($newData);
            }

            $mailSubject = "Your payment successfully complete";
            $youthEmailAddress = $request->cust_info['cust_email'];
            $mailMsg = "Congratulation! Your payment successfully completed.";
            $youthName = $youthCourseEnroll->youth->name;
            Mail::to($youthEmailAddress)->send(new \App\Mail\YouthPaymentSuccessMail($mailSubject, $youthCourseEnroll->youth->access_key, $mailMsg, $youthName));

            return 'Payment successful';
        }

        $data['youth_course_enroll_id'] = $request->cust_info['cust_id'];
        $data['transaction_id'] = $request->trnx_info['trnx_id'];
        $data['amount'] = $request->trnx_info['trnx_amt'];
        $data['log'] = $request;
        $data['payment_type'] = $request->pi_det_info['pi_type'];
        $data['payment_date'] = Carbon::now();
        $data['payment_status'] = $request->msg_code == 1020 ? '1' : '2';

        $payment = new Payment();
        $payment->fill($data);
        $payment->save();
    }

    public function certificate(): View
    {
        return \view(self::VIEW_PATH . 'youth/certificate/certificate');
    }

    public function certificateDownload()
    {
        $youthInfo = [
            'name' => 'Miladul Islam',
            'father_name' => "Father's Name",
            "register_no" => time(),
            'institute_title' => "BITAC",
            'from_date' => "10/08/2021",
            'to_date' => "10/10/2021",
        ];

        $template = self::VIEW_PATH . 'youth/certificate/certificate-two';
        $pdf = app(CertificateGenerator::class);
        return $pdf->generateCertificate($template, $youthInfo);
    }

    public function certificateTwo()
    {
        return \view(self::VIEW_PATH . 'youth/certificate/certificate-two');
    }
}

