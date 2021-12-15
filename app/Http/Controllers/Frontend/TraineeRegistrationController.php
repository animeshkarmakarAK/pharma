<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Trainee;
use App\Models\TraineeCourseEnroll;
use App\Services\TraineeRegistrationService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class TraineeRegistrationController extends Controller
{
    const VIEW_PATH = 'frontend.trainee-registration.';
    protected TraineeRegistrationService $traineeRegistrationService;

    public function __construct(TraineeRegistrationService $traineeRegistrationService)
    {
        $this->traineeRegistrationService = $traineeRegistrationService;
    }

    /**
     * @return View
     */
    public function index(): View
    {
        return \view(self::VIEW_PATH . 'registration-form');
    }

    /**
     * applied trainee for registration data view
     * @param $traineeId
     * @return array
     */
    public function show($traineeId): array
    {
        $trainee = Trainee::findOrFail($traineeId);
        $familyMembers = $this->traineeRegistrationService->getTraineeFamilyMemberInfo($trainee);
        $traineeAcademicQualifications = $this->traineeRegistrationService->getTraineeAcademicQualification($trainee);
        $traineeSelfInfo = $this->traineeRegistrationService->getTraineeInfo($trainee);

        return [
                'father' => $familyMembers['father'],
                'mother' => $familyMembers['mother'],
                'guardian' => $familyMembers['guardian'],
                'academicQualifications' => $traineeAcademicQualifications,
                'traineeSelfInfo' => $traineeSelfInfo,
                'trainee' => $trainee,
            ];
    }


    /**
     * @param Request $request
     * @return RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $this->traineeRegistrationService->validator($request)->validate();

        try {
            $this->traineeRegistrationService->createRegistration($validated);
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
        return \view('frontend/trainee-registrations/application-success-message', compact('accessKey'));
    }


    public function acceptTraineeCourseEnroll($traineeCourseEnrollId)
    {
        $traineeCourseEnroll = TraineeCourseEnroll::findOrFail($traineeCourseEnrollId);

        /**
         * Check trainee application already rejected or not
         * */
        if ($traineeCourseEnroll->enroll_status == TraineeCourseEnroll::ENROLL_STATUS_REJECT) {
            return back()->with([
                'message' => __('Already rejected this application'),
                'alert-type' => 'warning'
            ]);
        }

        /**
         * Check trainee application already accepted or not
         * */
        if ($traineeCourseEnroll->enroll_status == TraineeCourseEnroll::ENROLL_STATUS_ACCEPT) {
            return back()->with([
                'message' => __('Already accepted this application'),
                'alert-type' => 'warning'
            ]);
        }

        try {
            if (!empty($traineeCourseEnroll->trainee->mobile)) {
                try {
                    $link = route('frontend.trainee-enrolled-courses');
                    $traineeName = strtoupper($traineeCourseEnroll->trainee->name);
                    $messageBody = "Dear $traineeName, Your course enrolment is accepted. Please payment within 72 hours. visit " . $link . " for payment";
                    $smsResponse = sms()->send($traineeCourseEnroll->trainee->mobile, $messageBody);
                    if (!$smsResponse->is_successful()) {
                        sms()->send($traineeCourseEnroll->trainee->mobile, $messageBody);
                    }
                } catch (\Throwable $exception) {
                    Log::debug($exception->getMessage());
                }
            }

            /**
             * Send mail to trainee for conformation
             * */
            $traineeEmailAddress = $traineeCourseEnroll->trainee->email;
            $mailMsg = "Congratulations! Your application has been accepted, Please pay now within 72 hours.<p>Payment Link: https://www.test.com.bd</p>";
            $mailSubject = "Congratulations! Your application has been accepted";
            $traineeName = $traineeCourseEnroll->trainee->name;
            try {
                Mail::to($traineeEmailAddress)->send(new \App\Mail\TraineeApplicationAcceptMail($mailSubject, $traineeCourseEnroll->trainee->access_key, $mailMsg, $traineeName));
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
            $this->traineeRegistrationService->changeTraineeCourseEnrollStatusAccept($traineeCourseEnroll);

        } catch (\Throwable $exception) {
            return response()->json([
                'message' => __('generic.something_wrong_try_again'),
                'alertType' => 'error'
            ]);
        }


        return redirect()->back()->with([
            'message' => __('Trainee course enroll accepted & notifying to trainee'),
            'alertType' => 'success',
        ]);
    }

    public function rejectTraineeCourseEnroll($traineeCourseEnrollId)
    {
        $traineeCourseEnroll = TraineeCourseEnroll::findOrFail($traineeCourseEnrollId);

        /**
         * Check trainee application already accepted or not
         * */
        if ($traineeCourseEnroll->enroll_status == TraineeCourseEnroll::ENROLL_STATUS_ACCEPT) {
            return back()->with([
                'message' => __('Already accepted this application'),
                'alert-type' => 'warning'
            ]);
        }

        /**
         * Check trainee application already accepted or not
         * */
        if ($traineeCourseEnroll->enroll_status == TraineeCourseEnroll::ENROLL_STATUS_REJECT) {
            return back()->with([
                'message' => __('Already rejected this application'),
                'alert-type' => 'warning'
            ]);
        }

        try {

            /**
             * Send mail to trainee for reject conformation
             * */
            $traineeEmailAddress = $traineeCourseEnroll->trainee->email;
            $mailMsg = 'Sorry! Your application has been rejected, Please enroll again by your account access key. <p>Courses link: <a href="' . (route('frontend.course_search')) . '">Courses</a></p>';
            $mailSubject = "Your application has been rejected";
            $traineeName = $traineeCourseEnroll->trainee->name;
            try {
                Mail::to($traineeEmailAddress)->send(new \App\Mail\TraineeApplicationRejectMail($mailSubject, $traineeCourseEnroll->trainee->access_key, $mailMsg, $traineeName));
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
            $this->traineeRegistrationService->changeTraineeCourseEnrollStatusReject($traineeCourseEnroll);

        } catch (\Throwable $exception) {
            return response()->json([
                'message' => __('generic.something_wrong_try_again'),
                'alertType' => 'error'
            ]);
        }


        return redirect()->back()->with([
            'message' => __('Trainee course enroll rejected & notifying to trainee'),
            'alertType' => 'success',
        ]);


    }
}
