<?php


namespace App\Services;

use App\Helpers\Classes\AuthHelper;
use App\Helpers\Classes\DatatableHelper;
use App\Helpers\Classes\FileHandler;
use App\Models\Permission;
use App\Models\User;
use App\Models\UserType;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\RequiredIf;
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
        $data = $this->setAndClearData($data);

        return User::create($data);
    }

    protected function setAndClearData(array $data): array
    {
        if ($data['user_type_id'] == UserType::USER_TYPE_DC_USER_CODE) {
            $data['institute_id'] = null;
            $data['loc_division_id'] = null;
        } elseif ($data['user_type_id'] == UserType::USER_TYPE_INSTITUTE_USER_CODE) {
            $data['loc_district_id'] = null;
            $data['loc_division_id'] = null;
        } elseif ($data['user_type_id'] == UserType::USER_TYPE_TRAINER_USER_CODE) {
            $data['loc_district_id'] = null;
            $data['institute_id'] = auth()->user()->institute_id;
            $data['loc_division_id'] = null;
        } elseif ($data['user_type_id'] == UserType::USER_TYPE_DIVCOM_USER_CODE) {
            $data['loc_district_id'] = null;
            $data['institute_id'] = null;
        } else {
            $data['loc_district_id'] = null;
            $data['institute_id'] = null;
            $data['loc_division_id'] = null;
        }

        return $data;
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
            'institute_id' => [
                'requiredIf:user_type_id,' . UserType::USER_TYPE_INSTITUTE_USER_CODE,
                'int',
                'exists:institutes,id'
            ],
            'loc_district_id' => [
                'requiredIf:user_type_id,' . UserType::USER_TYPE_DC_USER_CODE,
                'int',
                'exists:loc_districts,id'
            ],
            'loc_division_id' => [
                'requiredIf:user_type_id,' . UserType::USER_TYPE_DIVCOM_USER_CODE,
                'int',
                'exists:loc_divisions,id'
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

//        if (empty($user->role_id)) {
        $userType = UserType::findOrFail($data['user_type_id']);
        $data['role_id'] = $userType->default_role_id;
//        }

        $data = $this->setAndClearData($data);
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
            'institutes.title_en as institute_name',
            'loc_districts.title_en as loc_district_name',
            'user_types.title as user_type_title',
            'users.email',
            'users.created_at',
            'users.updated_at'
        ]);
        $users->join('user_types', 'users.user_type_id', '=', 'user_types.id');
        $users->leftJoin('institutes', 'users.institute_id', '=', 'institutes.id');
        $users->leftJoin('loc_districts', 'users.loc_district_id', '=', 'loc_districts.id');
        $users->where('users.user_type_id', '!=', User::USER_TYPE_TRAINER_USER_CODE);

        if ($authUser->isInstituteUser()) {
            $users->where('users.institute_id', $authUser->institute_id)
                ->where('users.user_type_id', $authUser->user_type_id);
        }

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
                if ($authUser->isInstituteUser()) {
                    $str .= '<a href="'. route('admin.users.trainers', $user->id) .'"  data-action="' . route('admin.users.trainers', $user->id) . '" class="btn btn-outline-info btn-sm info"> <i class="fas fa-trash"></i> ' . __('generic.trainers') . '</a>';
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
