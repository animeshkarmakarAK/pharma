<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use App\Models\User;
use App\Services\TrainerService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Module\CourseManagement\App\Models\YouthAcademicQualification;

class TrainerController extends BaseController
{
    const  VIEW_PATH = "master::acl.trainers.";

    protected TrainerService $trainerService;

    public function __construct(TrainerService $trainerService)
    {
        $this->trainerService = $trainerService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(int $userId): View
    {
        $trainer = User::findOrFail($userId);
        $trainerInstitute = User::where('institute_id', $trainer->institute_id)
            ->where('user_type_id', User::USER_TYPE_INSTITUTE_USER_CODE)
            ->first();



        $academicQualifications = $trainer->trainerAcademicQualifications()->get()->keyBy('examination');


        return \view(self::VIEW_PATH . 'additional-information', ['trainer' => $trainer, 'trainerInstitute' => $trainerInstitute, 'academicQualifications' => $academicQualifications]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
//        $validated = $this->trainerService->validator($request)->validate();
        DB::beginTransaction();
        try {
            $trainer = $this->trainerService->storeTrainerInfo($request->all());
            DB::commit();
        } catch (\Throwable $exception) {
            DB::rollBack();
            Log::debug($exception->getMessage());

            return response()->json([
                'message' => __('generic.something_wrong_try_again'),
                'alertType' => 'error'
            ]);
        }

        return response()->json([
            'message' => __('আপনার রেজিস্ট্রেশন সফল হয়েছে'),
            'alertType' => 'success',
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
