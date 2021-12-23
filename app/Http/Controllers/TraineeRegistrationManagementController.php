<?php

namespace App\Http\Controllers;

use App\Models\Batch;
use App\Models\Institute;
use App\Models\TraineeCourseEnroll;
use App\Models\TraineeBatch;
use App\Services\TraineeManagementService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class TraineeRegistrationManagementController extends Controller
{
    const VIEW_PATH = 'backend.trainee-registrations.';
    protected TraineeManagementService $traineeManagementService;

    public function __construct(TraineeManagementService $traineeManagementService)
    {
        $this->traineeManagementService = $traineeManagementService;
    }

    public function index(): View
    {
        $institutes = Institute::acl()->active()->get();
        $batches = \App\Models\Batch::acl()->get();
        return \view(self::VIEW_PATH . 'applications-for-registration', compact('institutes', 'batches'));
    }


    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function getDatatable(Request $request): JsonResponse
    {
        return $this->traineeManagementService->getListDataForDatatable($request);
    }
    public function preferredBatch($id): JsonResponse
    {
       return $this->traineeManagementService->getPreferdBatch($id);
    }

    public function confirmBatch(Request $request): JsonResponse
    {
        try {
            if($request->status==1){
                TraineeCourseEnroll::where('id',$request->id)
                    ->update(['enroll_status'=>1,'batch_id'=>$request->batch_id]);
            }else{
                TraineeCourseEnroll::where('id',$request->id)
                    ->update(['enroll_status'=>2,'batch_id'=>null]);
            }

        } catch (\Throwable $exception) {
            Log::debug($exception->getMessage());
            dd($exception->getMessage());
            return back()->with([
                'message' => __('Something is wrong, Please try again'),
                'alert-type' => 'error'
            ]);
        }

        return response()->json(['message' => 'success']);

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


    public function addTraineeToBatch(Request $request): \Illuminate\Http\RedirectResponse
    {
        $validatedData = $this->traineeManagementService->validateAddTraineeToBatch($request)->validate();

        $batch = Batch::findOrFail($validatedData['batch_id']);

        DB::beginTransaction();
        try {
            $this->traineeManagementService->addTraineeToBatch($batch, $validatedData['trainee_enroll_ids']);
            DB::commit();
        } catch (\Throwable $exception) {
            DB::rollBack();
            Log::debug($exception->getMessage());
            Log::debug($exception->getTraceAsString());
            return back()->with([
                'message' => __('generic.something_wrong_try_again'),
                'alert-type' => 'error'
            ]);
        }

        return back()->with([
            'message' => __('Trainee added to batch'),
            'alert-type' => 'success'
        ]);
    }

    public function addSingleTraineeToBatch(Request $request , $traineeId): \Illuminate\Http\RedirectResponse
    {
        $traineeCourseEnroll = TraineeCourseEnroll::findOrFail($traineeId);
        DB::beginTransaction();
        try {
            TraineeBatch::updateOrCreate(
                [
                    'batch_id' => $request->single_batch_id,
                    'trainee_course_enroll_id' => $traineeCourseEnroll->id
                ],
                [
                    'enrollment_date' => now(),
                    'enrollment_status' => TraineeBatch::ENROLLMENT_STATUS_ENROLLED
                ]
            );
            DB::commit();
        } catch (\Throwable $exception) {
            DB::rollBack();
            Log::debug($exception->getMessage());
            Log::debug($exception->getTraceAsString());
            return back()->with([
                'message' => __('generic.something_wrong_try_again'),
                'alert-type' => 'error'
            ]);
        }

        return back()->with([
            'message' => __('Trainee has been added to batch'),
            'alert-type' => 'success'
        ]);
    }
}
