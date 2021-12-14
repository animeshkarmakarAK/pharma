<?php


namespace App\Services;

use App\Helpers\Classes\AuthHelper;
use App\Helpers\Classes\FileHandler;
use App\Models\Youth;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class YouthProfileService
{

    public function validator(Request $request, $id): Validator
    {
        $rules = [
            'name' => 'required|string|max:191',
            'mobile' => 'required|string|max:20',
            'date_of_birth' => 'required|date',
            'email' => 'required|string|max:191|email|unique:youths,email,'.$id,
            'loc_division_id' => 'required|int',
            'loc_district_id' => 'required|int',
            'loc_upazila_id' => 'required|int',
            'physically_disable' => 'nullable',
            'disable_status' => 'nullable',
            'physical_disabilities' => 'nullable',
            'gender' => 'required|int',
            'password' => [
                'nullable',
                'bail',
                'confirmed'
            ],
            'profile_pic' => [
                'mimes:jpeg,jpg,png,gif'
            ]
        ];

        if (AuthHelper::getAuthUser('youth')->id == $id && !empty($request->input('password'))) {
            $rules['old_password'] = [
                'bail',
                static function ($attribute, $value, $fail) {
                    if (!Hash::check($value, AuthHelper::getAuthUser('youth')->password)) {
                        $fail(__('Credentials does not match.'));
                    }
                }
            ];
        }

        return \Illuminate\Support\Facades\Validator::make($request->all(), $rules);
    }

    /**
     * @param array $data
     * @param $id
     * @return bool
     */
    public function updatePersonalInfo(array $data, $id): bool
    {
        $youth = Youth::find($id);

        if (!empty($data['profile_pic'])) {
            $filename = FileHandler::storePhoto($data['profile_pic'], Youth::PROFILE_PIC_FOLDER_NAME);
            $data['profile_pic'] = $filename ? Youth::PROFILE_PIC_FOLDER_NAME . '/' . $filename : Youth::DEFAULT_PROFILE_PIC;
        }

        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }else {
            unset($data['password']);
        }

        $youth->fill($data);
        return $youth->update();
    }
}
