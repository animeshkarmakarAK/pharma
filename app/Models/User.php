<?php

namespace App\Models;

use App\Helpers\Classes\AuthHelper;
use App\Traits\AuthenticatableUser;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Notifications\DatabaseNotificationCollection;

/**
 * App\Models\User
 *
 * @property int id
 * @property int user_type_id
 * @property int|null role_id
 * @property string name_en
 * @property string name_bn
 * @property string|null email
 * @property string password
 * @property string|null remember_token
 * @property string|null profile_pic
 * @property bool row_status 1 => Active, 0 => Deactivate, 99 => Deleted
 * @property int created_by
 * @property \Illuminate\Support\Carbon|null created_at
 * @property \Illuminate\Support\Carbon|null updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|UsersPermission[] activePermissions
 * @property-read int|null active_permissions_count
 * @property-read \Illuminate\Database\Eloquent\Collection|UsersPermission[] inActivePermissions
 * @property-read int|null in_active_permissions_count
 * @property-read DatabaseNotificationCollection|DatabaseNotification[] notifications
 * @property-read int|null notifications_count
 * @property-read Role|null role
 * @property-read UserType userType
 * @property-read \Illuminate\Database\Eloquent\Collection|Role[] roles
 * @property-read int|null roles_count
 */
class User extends AuthBaseModel
{
    use AuthenticatableUser;

    const USER_TYPE_SUPER_USER_CODE = '1';
    const USER_TYPE_SYSTEM_USER_CODE = '2';
    const USER_TYPE_INSTITUTE_USER_CODE = '3';
    const USER_TYPE_ORGANIZATION_USER_CODE = '4';

    const DEFAULT_PROFILE_PIC = 'users/default.jpg';
    const PROFILE_PIC_FOLDER_NAME = 'users';

    protected $guarded = ['id'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $with = [
        'userType',
    ];

    /**
     * ---------------------------------------
     *  User Relationship start              *
     * ---------------------------------------
     */

    /**
     * @return BelongsTo
     */
    public function userType(): BelongsTo
    {
        return $this->belongsTo(UserType::class, 'user_type_id');
    }

    /**
     * ---------------------------------------
     *  User Relationship end                *
     * ---------------------------------------
     */

    /**
     * ---------------------------------------
     *  This related method start            *
     * ---------------------------------------
     */
    public function profilePicIsDefault(): bool
    {
        return $this->profile_pic === self::DEFAULT_PROFILE_PIC;
    }

    public function isSystemUser(): bool
    {
        return $this->userType->code === self::USER_TYPE_SYSTEM_USER_CODE;
    }


    public function isInstituteUser(): bool
    {
        return $this->userType->code === self::USER_TYPE_INSTITUTE_USER_CODE;
    }


    public function isOrganizationUser(): bool
    {
        return $this->userType->code === self::USER_TYPE_ORGANIZATION_USER_CODE;
    }

    public function isSuperUser(): bool
    {
        return $this->userType->code === self::USER_TYPE_SUPER_USER_CODE;
    }

}
