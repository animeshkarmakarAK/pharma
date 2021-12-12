<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Youth;
use App\Models\YouthCourseEnroll;
use App\Services\YouthRegistrationService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class YouthRegistrationController extends Controller
{
    const VIEW_PATH = 'frontend.trainee-registration.';
    protected YouthRegistrationService $youthRegistrationService;

    public function __construct(YouthRegistrationService $youthRegistrationService)
    {
        $this->youthRegistrationService = $youthRegistrationService;
    }

    /**
     * @return View
     */
    public function index(): View
    {
        return \view(self::VIEW_PATH . 'registration-form');
    }

    /**
     * applied youth for registration data view
     *
     * @param $youthId
     * @return View
     */
    public function show($youthId): View
    {
        $youth = Youth::findOrFail($youthId);

        $familyMembers = $this->youthRegistrationService->getYouthFamilyMemberInfo($youth);
        $youthAcademicQualifications = $this->youthRegistrationService->getYouthAcademicQualification($youth);
        $youthSelfInfo = $this->youthRegistrationService->getYouthInfo($youth);

        return \view(self::VIEW_PATH . 'read')
            ->with([
                'father' => $familyMembers['father'],
                'mother' => $familyMembers['mother'],
                'guardian' => $familyMembers['guardian'],
                'academicQualifications' => $youthAcademicQualifications,
                'youthSelfInfo' => $youthSelfInfo,
                'youth' => $youth,
            ]);
    }


    /**
     * @param Request $request
     * @return RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->youthRegistrationService->validator($request)->validate();

        try {
            $this->youthRegistrationService->createRegistration($validated);
        } catch (\Throwable $exception) {
            Log::debug($exception->getMessage());

            return back()->with([
                'message' => __('generic.something_wrong_try_again'),
                'alertType' => 'error'
            ]);
        }

        return back()->with([
            'message' => __('আপনার রেজিস্ট্রেশন সফল হয়েছে'),
            'alertType' => 'success',
        ]);

    }

    public function registrationSuccess($accessKey)
    {
        return \view('frontend/youth-registrations/application-success-message', compact('accessKey'));
    }


    public function acceptYouthCourseEnroll($youthCourseEnrollId)
    {
        $youthCourseEnroll = YouthCourseEnroll::findOrFail($youthCourseEnrollId);

        /**
         * Check youth application already rejected or not
         * */
        if ($youthCourseEnroll->enroll_status == YouthCourseEnroll::ENROLL_STATUS_REJECT) {
            return back()->with([
                'message' => __('Already rejected this application'),
                'alert-type' => 'warning'
            ]);
        }

        /**
         * Check youth application already accepted or not
         * */
        if ($youthCourseEnroll->enroll_status == YouthCourseEnroll::ENROLL_STATUS_ACCEPT) {
            return back()->with([
                'message' => __('Already accepted this application'),
                'alert-type' => 'warning'
            ]);
        }

        try {
            if (!empty($youthCourseEnroll->youth->mobile)) {
                try {
                    $link = route('frontend.youth-enrolled-courses');
                    $youthName = strtoupper($youthCourseEnroll->youth->name);
                    $messageBody = "Dear $youthName, Your course enrolment is accepted. Please payment within 72 hours. visit " . $link . " for payment";
                    $smsResponse = sms()->send($youthCourseEnroll->youth->mobile, $messageBody);
                    if (!$smsResponse->is_successful()) {
                        sms()->send($youthCourseEnroll->youth->mobile, $messageBody);
                    }
                } catch (\Throwable $exception) {
                    Log::debug($exception->getMessage());
                }
            }

            /**
             * Send mail to youth for conformation
             * */
            $youthEmailAddress = $youthCourseEnroll->youth->email;
            $mailMsg = "Congratulations! Your application has been accepted, Please pay now within 72 hours.<p>Payment Link: https://www.test.com.bd</p>";
            $mailSubject = "Congratulations! Your application has been accepted";
            $youthName = $youthCourseEnroll->youth->name;
            try {
                Mail::to($youthEmailAddress)->send(new \App\Mail\YouthApplicationAcceptMail($mailSubject, $youthCourseEnroll->youth->access_key, $mailMsg, $youthName));
            } catch (\Throwable $exception) {
                Log::debug($exception->getMessage());
                return back()->with([
                    'message' => __('Something is wrong, Please try again'),
                    'alert-type' => 'error'
                ])->withInput();
            }

            /**
             * Changing Enroll Status
             * */
            $this->youthRegistrationService->changeYouthCourseEnrollStatusAccept($youthCourseEnroll);

        } catch (\Throwable $exception) {
            return response()->json([
                'message' => __('generic.something_wrong_try_again'),
                'alertType' => 'error'
            ]);
        }


        return redirect()->back()->with([
            'message' => __('Youth course enroll accepted & notifying to youth'),
            'alertType' => 'success',
        ]);
    }

    public function rejectYouthCourseEnroll($youthCourseEnrollId)
    {
        $youthCourseEnroll = YouthCourseEnroll::findOrFail($youthCourseEnrollId);

        /**
         * Check youth application already accepted or not
         * */
        if ($youthCourseEnroll->enroll_status == YouthCourseEnroll::ENROLL_STATUS_ACCEPT) {
            return back()->with([
                'message' => __('Already accepted this application'),
                'alert-type' => 'warning'
            ]);
        }

        /**
         * Check youth application already accepted or not
         * */
        if ($youthCourseEnroll->enroll_status == YouthCourseEnroll::ENROLL_STATUS_REJECT) {
            return back()->with([
                'message' => __('Already rejected this application'),
                'alert-type' => 'warning'
            ]);
        }

        try {

            /**
             * Send mail to youth for reject conformation
             * */
            $youthEmailAddress = $youthCourseEnroll->youth->email;
            $mailMsg = 'Sorry! Your application has been rejected, Please enroll again by your account access key. <p>Courses link: <a href="' . (route('frontend.course_search')) . '">Courses</a></p>';
            $mailSubject = "Your application has been rejected";
            $youthName = $youthCourseEnroll->youth->name;
            try {
                Mail::to($youthEmailAddress)->send(new \App\Mail\YouthApplicationRejectMail($mailSubject, $youthCourseEnroll->youth->access_key, $mailMsg, $youthName));
            } catch (\Throwable $exception) {
                Log::debug($exception->getMessage());
                return back()->with([
                    'message' => __('Something wrong try again'),
                    'alert-type' => 'error'
                ])->withInput();
            }

            /**
             * Changing Enroll Status
             * */
            $this->youthRegistrationService->changeYouthCourseEnrollStatusReject($youthCourseEnroll);

        } catch (\Throwable $exception) {
            return response()->json([
                'message' => __('generic.something_wrong_try_again'),
                'alertType' => 'error'
            ]);
        }


        return redirect()->back()->with([
            'message' => __('Youth course enroll rejected & notifying to youth'),
            'alertType' => 'success',
        ]);


    }
}
