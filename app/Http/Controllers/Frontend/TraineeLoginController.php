<?php

namespace App\Http\Controllers\Frontend;

use App\Helpers\Classes\AuthHelper;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TraineeLoginController
{
    public function loginForm()
    {
        if (AuthHelper::checkAuthUser('trainee')) {
            return redirect()->route('frontend.main');
        }

        $currentInstitute = app('currentInstitute');

        return view('acl.auth.trainee-login', compact('currentInstitute'));
    }

    public function passwordResetForm()
    {
        if (AuthHelper::checkAuthUser('trainee')) {
            return redirect()->route('frontend.main');
        }

        $currentInstitute = app('currentInstitute');

        return view('acl.auth.trainee-password-reset', compact('currentInstitute'));
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::guard('trainee')->attempt($credentials)) {
            Auth::shouldUse('trainee');
            return $request->wantsJson()
                ? new JsonResponse([], 204)
                : redirect()->route('frontend.trainee-enrolled-courses')
                    ->with(['message' => 'লগইন সফল হয়েছে', 'alert-type' => 'success']);
        }

        return redirect()->back()
            ->with(['message' => 'email or password is incorrect, আবার চেষ্টা করুন', 'alert-type' => 'error']);
    }

    public function logout(): \Illuminate\Http\RedirectResponse
    {
        if (AuthHelper::checkAuthUser('trainee')) {
            Auth::guard('trainee')->logout();
        }

        return redirect()->route('frontend.main')
            ->with(['message' => 'সফলভাবে লগ আউট হয়েছে.', 'alert-type' => 'success']);
    }
}
