<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;

class LocalizationController extends BaseController
{
    public function changeLanguage(Request $request, string $language)
    {
        try {
            App::setLocale($language);
            session()->put('locale', $language);
        } catch (\Throwable $exception) {
            Log::debug($exception->getMessage());
            return back()->with(['message' => 'Something Wrong. Please Try Again', 'alert-type' => 'error']);
        }

        return back()->with(['message' => 'Language Successfully Changed', 'alert-type' => 'success']);
    }
}
