<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use \Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Role;
use App\Models\UserType;
use App\Services\UserTypeService;

class UserTypeController extends BaseController
{
    const VIEW_PATH = 'master::acl.user-types.';
    public UserTypeService $userTypeService;

    public function __construct(UserTypeService $userTypeService)
    {
        $this->userTypeService = $userTypeService;
        $this->authorizeResource(UserType::class);
    }

    public function index()
    {
        $userTypes = UserType::all();
        return \view(self::VIEW_PATH . 'browse', compact('userTypes'));
    }

    public function edit(UserType $userType)
    {
        $roles = Role::where('is_deletable', 0)->get();

        return \view(self::VIEW_PATH . 'edit', compact('userType', 'roles'));
    }

    public function update(UserType $userType, Request $request): RedirectResponse
    {
        $this->userTypeService->validatorUserType($request)->validate();

        try {
            $this->userTypeService->updateUserType($userType, $request);
        } catch (\Throwable $exception) {
            Log::debug($exception->getMessage());
            return back()->with([
                'message' => __('generic.something_wrong_try_again'),
                'alert-type' => 'error'
            ]);
        }
        return back()->with([
            'message' => __('generic.object_updated_successfully', ['object' => 'User Type']),
            'alert-type' => 'success'
        ]);
    }

}
