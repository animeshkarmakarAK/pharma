<?php

namespace App\Http\Controllers\Admin;


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

    public function create(): string
    {
        $user = new User();

        return \Illuminate\Support\Facades\View::make('master::acl.users.edit-add', ['user' => $user])->render();
    }


    /**
     * @param Request $request
     * @return RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $validatedData = $this->userService->validator($request)->validate();

        DB::beginTransaction();
        try {
            $this->userService->createUser($validatedData);
            DB::commit();
        } catch (\Throwable $exception) {
            DB::rollback();
            Log::debug($exception->getMessage());
            return back()->with([
                'message' => __('generic.something_wrong_try_again'),
                'alert-type' => 'error'
            ]);
        }

        return back()->with([
            'message' => __('generic.object_created_successfully', ['object' => 'user']),
            'alert-type' => 'success'
        ]);

    }

    /**
     * @param User $user
     * @return string
     */
    public function show(User $user, Request $request): string
    {
        return \Illuminate\Support\Facades\View::make('master::acl.users.read', ['user' => $user])->render();
    }

    /**
     * @param User $user
     * @return string
     */
    public function edit(User $user): string
    {
        return \Illuminate\Support\Facades\View::make('master::acl.users.edit-add', ['user' => $user])->render();
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

            return response()->json(['message' => 'Something wrong. Please try again.', 'alert-type' => 'error']);
        }

        return response()->json(['message' => 'Profile update successful', 'alert-type' => 'success']);
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
            return back()->with(['alert-type' => 'error', 'message' => __('Something wrong.')]);
        }

        return back()->with(['alert-type' => 'success', 'message' => __('Delete successful')]);
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
}
