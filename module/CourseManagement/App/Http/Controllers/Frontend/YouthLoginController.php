<?php

namespace Module\CourseManagement\App\Http\Controllers\Frontend;

use App\Helpers\Classes\AuthHelper;
use Module\CourseManagement\App\Models\Institute;
use Module\CourseManagement\App\Models\Youth;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class YouthLoginController
{
    public function loginForm()
    {
        if (AuthHelper::checkAuthUser('youth')) {
            return redirect()->route('/');
        }

        $currentInstitute = domainConfig('institute');

        return view('acl.auth.custom1.youth-login', compact('currentInstitute'));
    }

    public function passwordResetForm()
    {
        if (AuthHelper::checkAuthUser('youth')) {
            return redirect()->route('/');
        }

        $currentInstitute = domainConfig('institute');

        return view('acl.auth.custom1.youth-password-reset', compact('currentInstitute'));
    }

    public function login(Request $request)
    {

        $youth = Youth::where('access_key', $request->input('access_key'))->first();
        if ($youth && $youth->id && Auth::guard('youth')->loginUsingId($youth->id)) {
            Auth::shouldUse('youth');
            return $request->wantsJson()
                ? new JsonResponse([], 204)
                : redirect()->route('course_management::youth')
                    ->with(['message' => 'লগইন সফল হয়েছে', 'alert-type' => 'success']);
        }

        return redirect()->back()
            ->with(['message' => 'আপনি ভুল এক্সেস-কী প্রদান করেছেন, আবার চেষ্টা করুন', 'alert-type' => 'error']);
    }

    public function logout(): \Illuminate\Http\RedirectResponse
    {
        if (AuthHelper::checkAuthUser('youth')) {
            Auth::guard('youth')->logout();
        }

        return redirect()->route('/')
            ->with(['message' => 'সফলভাবে লগ আউট হয়েছে.', 'alert-type' => 'success']);
    }
}
