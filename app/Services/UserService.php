<?php


namespace App\Services;


use App\Helpers\Classes\AuthHelper;
use App\Helpers\Classes\DatatableHelper;
use App\Helpers\Classes\FileHandler;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\RequiredIf;
use App\Models\Permission;
use App\Models\User;
use App\Models\UserType;
use Yajra\DataTables\Facades\DataTables;

class UserService
{
    public function createUser(array $data): User
    {

        if (!empty($data['profile_pic'])) {
            $filename = FileHandler::storePhoto($data['profile_pic'], User::PROFILE_PIC_FOLDER_NAME);
            $data['profile_pic'] = $filename ? User::PROFILE_PIC_FOLDER_NAME . '/' . $filename : User::DEFAULT_PROFILE_PIC;
        }

        $data['password'] = Hash::make($data['password']);

        $userType = UserType::findOrFail($data['user_type_id']);
        $data['role_id'] = $userType->default_role_id;

        return User::create($data);
    }

    public function validator(Request $request, $id = null): Validator
    {
        $rules = [
            'name_en' => [
                'bail',
                'required',
                'string'
            ],
            'name_bn' => [
                'nullable',
                'string'
            ],
            'email' => [
                'bail',
                'required',
                'email'
            ],
            'user_type_id' => [
                'bail',
                'required',
                'exists:user_types,code'
            ],
            'password' => [
                'bail',
                new RequiredIf($id == null),
                'confirmed'
            ],
            'profile_pic' => 'nullable|mimes:jpeg,jpg,png,gif|max:10000'
        ];
        if (AuthHelper::getAuthUser()->id == $id && !empty($request->input('password'))) {
            $rules['old_password'] = [
                'bail',
                static function ($attribute, $value, $fail) {
                    if (!Hash::check($value, AuthHelper::getAuthUser()->password)) {
                        $fail(__('Credentials does not match.'));
                    }
                }
            ];
        }

        return \Illuminate\Support\Facades\Validator::make($request->all(), $rules);
    }

    public function updateUser(User $user, array $data): User
    {
        $authUser = AuthHelper::getAuthUser();

        if (!empty($data['profile_pic'])) {
            if (!empty($user->profile_pic) && !$user->profilePicIsDefault()) {
                FileHandler::deleteFile($user->profile_pic);
            }
            $filename = FileHandler::storePhoto($data['profile_pic'], User::PROFILE_PIC_FOLDER_NAME);
            $data['profile_pic'] = $filename ? User::PROFILE_PIC_FOLDER_NAME . '/' . $filename : User::DEFAULT_PROFILE_PIC;
        }

        if (!empty($data['password']) && $authUser->can('changePassword', $user)) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        if (empty($user->role_id)) {
            $userType = UserType::findOrFail($data['user_type_id']);
            $data['role_id'] = $userType->default_role_id;
        }

        $user->update($data);
        return $user;
    }


    public function getListDataForDatatable(Request $request): JsonResponse
    {
        $authUser = AuthHelper::getAuthUser();

        /** @var Builder|User $users */
        $users = User::select([
            'users.id as id',
            'users.name_en',
            'users.name_bn',
            'users.user_type_id',
            'user_types.title as user_type_title',
            'users.email',
            'users.created_at',
            'users.updated_at'
        ]);
        $users->join('user_types', 'users.user_type_id', '=', 'user_types.id');

        return DataTables::eloquent($users)
            ->addColumn('action', DatatableHelper::getActionButtonBlock(static function (User $user) use ($authUser) {
                $str = '';
                if ($authUser->can('view', $user)) {
                    $str .= '<a href="#" data-url="' . route('admin.users.show', $user->id) . '" class="btn btn-outline-info btn-sm dt-view"> <i class="fas fa-eye"></i> ' . __('generic.read_button_label') . '</a>';
                }
                if ($authUser->can('update', $user)) {
                    $str .= '<a href="#" data-url="' . route('admin.users.edit', $user->id) . '" class="btn btn-outline-warning btn-sm dt-edit"> <i class="fas fa-edit"></i> ' . __('generic.edit_button_label') . ' </a>';
                }
                if ($authUser->can('delete', $user)) {
                    $str .= '<a href="#" data-action="' . route('admin.users.destroy', $user->id) . '" class="btn btn-outline-danger btn-sm delete"> <i class="fas fa-trash"></i> ' . __('generic.delete_button_label') . '</a>';
                }
                return $str;
            }))
            ->rawColumns(['action'])
            ->toJson();
    }


    public function deleteUser(User $user): bool
    {
        if ($user->profile_pic && !$user->profilePicIsDefault()) {
            FileHandler::deleteFile($user->profile_pic);
        }

        return $user->delete();
    }

    public function syncUserPermission(User $user, array $permissions): User
    {
        $permissionKeys = Permission::whereIn('id', $permissions)->pluck('key');
        $rolePermissions = $user->getAllRolePermissionKeys();
        $inactivePermissionKeys = $rolePermissions->diff($permissionKeys);
        $activePermissionKeys = $permissionKeys->diff($rolePermissions);

        $inactivePermissions = Permission::whereIn('key', $inactivePermissionKeys)->pluck('id');
        $activePermissions = Permission::whereIn('key', $activePermissionKeys)->pluck('id');

        $user->permissions()->sync([]);
        $user->permissions()->attach($inactivePermissions, ['status' => 0]);
        $user->permissions()->attach($activePermissions, ['status' => 1]);

        /** TODO: not a good idea */
        Cache::forget('userwise_permissions_' . $user->id);

        return $user;
    }

    public function syncUserRoles(User $user, $roleId, $roleIds): User
    {
        if (count($roleIds)) {
            $roleIds = array_diff($roleIds, [$roleId]);
            $user->roles()->sync($roleIds);
        }
        $user->role_id = $roleId;
        $user->save();

        return $user;
    }
}
