<?php

namespace App\Http\Controllers\Admin;


use App\Helpers\Classes\AuthHelper;
use App\Http\Controllers\BaseController;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UserController extends BaseController
{
    const  VIEW_PATH = "master::acl.users.";

    protected UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
        $this->authorizeResource(User::class);
    }

    public function index()
    {
        return view(self::VIEW_PATH . 'browse');
    }

    public function create(): View
    {
        $user = new User();

        return \view('master::acl.users.ajax.edit-add', compact('user'));
    }


    /**
     * @param Request $request
     * @return JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): JsonResponse
    {
        $validatedData = $this->userService->validator($request)->validate();

        DB::beginTransaction();
        try {
            $this->userService->createUser($validatedData);
            DB::commit();
        } catch (\Throwable $exception) {
            DB::rollback();
            Log::debug($exception->getMessage());
            return response()->json(['message' => __('generic.something_wrong_try_again'), 'alert-type' => 'error']);
        }

        return response()->json(['message' => __('generic.object_created_successfully', ['object' => 'User']), 'alert-type' => 'success']);
    }

    /**
     * @param User $user
     * @param Request $request
     * @return string
     */
    public function show(User $user, Request $request): View
    {
        return \view('master::acl.users.ajax.read', compact('user'));
    }

    /**
     * @param User $user
     * @return string
     */
    public function edit(User $user): View
    {
        return \view('master::acl.users.ajax.edit-add', compact('user'));
    }

    public function update(User $user, Request $request): JsonResponse
    {
        $validatedData = $this->userService->validator($request, $user->id)->validate();

        DB::beginTransaction();
        try {
            $this->userService->updateUser($user, $validatedData);
            DB::commit();
        } catch (\Throwable $exception) {
            DB::rollBack();
            Log::debug($exception->getMessage());
            Log::debug($exception->getTraceAsString());
            return response()->json(['message' => __('generic.something_wrong_try_again'), 'alert-type' => 'error']);
        }

        return response()->json(['message' => __('generic.object_updated_successfully', ['object' => 'User']), 'alert-type' => 'success']);
    }

    /**
     *  Remove the specified resource from storage.
     *
     * @param User $user
     * @return RedirectResponse
     */
    public function destroy(User $user): RedirectResponse
    {
        try {
            $this->userService->deleteUser($user);
        } catch (\Exception $exception) {
            return back()->with([
                'message' => __('generic.something_wrong_try_again'),
                'alert-type' => 'error'
            ]);
        }

        return back()->with([
            'message' => __('generic.object_deleted_successfully', ['object' => 'User']),
            'alert-type' => 'success'
        ]);
    }

    public function getDatatable(Request $request): JsonResponse
    {
        return $this->userService->getListDataForDatatable($request);
    }

    public function userPermissionIndex(User $user): View
    {
        $this->authorize('viewUserPermission', $user);

        $roles = Role::all();

        $userPermissions = $user->allPermissionKey()->all();
        $customPermissions = $user->getCustomPermissions()->all();
        $userExtraRoles = $user->roles()->pluck('id', 'id')->toArray();

        $permissionsGroupByTable = Permission::all()->groupBy('table_name');
        return \view(
            self::VIEW_PATH . 'permissions',
            compact(
                'user',
                'permissionsGroupByTable',
                'customPermissions',
                'userExtraRoles',
                'userPermissions',
                'roles'
            )
        );
    }

    public function userRoleSync(Request $request, User $user): RedirectResponse
    {
        $this->authorize('changeUserRole', $user);

        $request->validate([
            'role_id' => 'required|integer',
            'role_ids' => 'nullable|array',
        ]);

        $roleId = $request->input('role_id');
        $roleIds = $request->input('role_ids', []);

        try {
            $this->userService->syncUserRoles($user, $roleId, $roleIds);
        } catch (\Throwable $exception) {
            Log::debug($exception->getMessage());
            return back()->with([
                'message' => __('generic.something_wrong_try_again'),
                'alert-type' => 'error'
            ]);
        }

        return back()->with([
            'message' => __('generic.object_updated_successfully', ['object' => 'User Role']),
            'alert-type' => 'success'
        ]);
    }

    public function userPermissionSync(Request $request, User $user): RedirectResponse
    {
        $permissions = $request->input('permissions', []);

        try {
            $this->userService->syncUserPermission($user, $permissions);
        } catch (\Throwable $exception) {
            Log::debug($exception->getMessage());
            return back()->with([
                'message' => __('generic.something_wrong_try_again'),
                'alert-type' => 'error'
            ]);
        }

        return back()->with([
            'message' => __('generic.object_updated_successfully', ['object' => 'User Permission']),
            'alert-type' => 'success'
        ]);
    }

    public function checkUserEmailUniqueness(Request $request): JsonResponse
    {
        $youth = User::where('email', $request->email)->first();
        if ($youth == null) {
            return response()->json(true);
        }
        return response()->json("This email address already in use");
    }


    public function checkUserEmail(Request $request): JsonResponse
    {
        $user = User::where(['email' => $request->email])->first();
        if ($user == null) {
            return response()->json(true);
        } else {
            return response()->json('Email already in use!');
        }
    }

    public function trainers(User $user): View
    {
        $trainerList = User::where('institute_id', $user->institute_id)->where('user_type_id', user::USER_TYPE_TRAINER_USER_CODE)->get();
        dd($trainerList);
        return \view(self::VIEW_PATH . 'trainers', compact('trainerList'));
    }
}
