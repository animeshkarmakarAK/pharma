<?php

namespace App\Models;

use App\Traits\AuthenticatableUser;
use App\Traits\LocDistrictBelongsToRelation;
use App\Traits\LocDivisionBelongsToRelation;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Notifications\DatabaseNotificationCollection;
use Module\CourseManagement\App\Models\Institute;
use Module\GovtStakeholder\App\Models\Organization;

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
 * @property int loc_district_id
 * @property int loc_division_id
 * @property int institute_id
 * @property int organization_id
 * @property-read Collection|UsersPermission[] activePermissions
 * @property-read int|null active_permissions_count
 * @property-read Collection|UsersPermission[] inActivePermissions
 * @property-read int|null in_active_permissions_count
 * @property-read DatabaseNotificationCollection|DatabaseNotification[] notifications
 * @property-read int|null notifications_count
 * @property-read Role|null role
 * @property-read UserType userType
 * @property-read Institute institute
 * @property-read Organization organization
 * @property-read Collection|Role[] roles
 * @property-read int|null roles_count
 */
class User extends AuthBaseModel
{
    use AuthenticatableUser, LocDistrictBelongsToRelation, LocDivisionBelongsToRelation;

    const USER_TYPE_SUPER_USER_CODE = '1';
    const USER_TYPE_SYSTEM_USER_CODE = '2';
    const USER_TYPE_INSTITUTE_USER_CODE = '3';
    const USER_TYPE_ORGANIZATION_USER_CODE = '4';
    const USER_TYPE_DC_USER_CODE = '5';
    const USER_TYPE_DIVCOM_USER_CODE = '6';

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

    public function isDCUser(): bool
    {
        return $this->userType->code === self::USER_TYPE_DC_USER_CODE;
    }

    public function isDivcomUser(): bool
    {
        return $this->userType->code === self::USER_TYPE_DIVCOM_USER_CODE;
    }

    public function institute(): BelongsTo
    {
        return $this->belongsTo(Institute::class);
    }

    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class);
    }
}
