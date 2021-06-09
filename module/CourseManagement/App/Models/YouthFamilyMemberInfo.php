<?php

namespace Module\CourseManagement\App\Models;

use App\Traits\CreatedByUpdatedByRelationTrait;
use App\Traits\ScopeRowStatusTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * Class YouthFamilyMemberInfo
 * @package App\Models
 * @property int $youth_id
 * @property string|null $member_name_en
 * @property string|null member_name_bn
 * @property string|null mobile
 * @property string|null educational_qualification
 * @property string|null relation_with_youth
 * @property int|null is_guardian
 * @property int|null personal_monthly_income
 * @property int|null gender
 * @property int|null marital_status
 * @property string|null main_occupation
 * @property string|null other_occupations
 * @property string|null physical_ability
 * @property int|null disable_status
 * @property string|null nid
 * @property string|null birth_certificate_no
 * @property string|null passport_number
 * @property int|null religion
 * @property string|null nationality
 * @property Carbon|null date_of_birth
 */
class YouthFamilyMemberInfo extends BaseModel
{
    use HasFactory, CreatedByUpdatedByRelationTrait, ScopeRowStatusTrait;

    protected $table = "youths_family_member_info";
    protected $guarded = ['id'];

    public function currentMaritalStatus(): string
    {
        $maritalStatus = '';

        $maritalStatusArray = self::getMaritalOptions();

        if (empty($maritalStatusArray[$this->marital_status])) return $maritalStatus;

        $maritalStatus = $maritalStatusArray[$this->marital_status];

        return $maritalStatus;
    }

    public function getUserReligion(): string
    {
        $userReligion = '';

        $religionArray = self::getReligionOptions();

        if (empty($religionArray[$this->religion])) return $userReligion;

        return $religionArray[$this->religion];

    }


    public function getUserGender(): string
    {
        $userGender = '';

        $SexArray = self::getSexOptions();

        if (empty($SexArray[$this->gender])) return $userGender;

        return $SexArray[$this->gender];

    }

    public function getYouthFreedomFighterStatus(): string
    {
        $freedomFighterStatus = '';

        $freedomFighterStatusArray = self::getFreedomFighterStatusOptions();

        if (empty($freedomFighterStatusArray[$this->freedom_fighter_status])) return $freedomFighterStatus;

        return $freedomFighterStatusArray[$this->freedom_fighter_status];
    }


    /**
     * marital statuses
     */
    public const MARITAL_STATUS_MARRIED = 1;
    public const MARITAL_STATUS_SINGLE = 2;

    /**
     * freedom fighter options
     */
    public const FREEDOM_FIGHTER_SON = 1;
    public const FREEDOM_FIGHTER_GRANDSON = 2;
    public const FREEDOM_FIGHTER_NOT = 3;


    public static function getFreedomFighterStatusOptions(): array
    {
        return
            [
                self::FREEDOM_FIGHTER_SON => __('Freedom fighter son'),
                self::FREEDOM_FIGHTER_GRANDSON => __('Freedom fighter grandson'),
                self::FREEDOM_FIGHTER_NOT => __('Non freedom fighter'),
            ];
    }


    /**
     * religion options
     */
    public const RELIGION_ISLAM = 1;
    public const RELIGION_HINDU = 2;
    public const RELIGION_CHRISTIAN = 3;
    public const RELIGION_BUDDHIST = 4;
    public const RELIGION_JAIN = 5;
    public const RELIGION_OTHERS = 6;

    /**
     * gender statuses
     */
    public const GENDER_MALE = 1;
    public const GENDER_FEMALE = 2;
    /**
     * Hijra
     */
    public const GENDER_HERMAPHRODITE = 3;
    /**
     * Who transform gender
     */
    public const GENDER_TRANSGENDER = 4;


    /**
     * Guardian options
     */

    public const GUARDIAN_FATHER = 1;
    public const GUARDIAN_MOTHER = 2;
    public const GUARDIAN_OTHER = 3;


    /**
     * get sex options
     * @return array
     */
    public static function getSexOptions(): array
    {
        return [
            self::GENDER_MALE => __('Male'),
            self::GENDER_FEMALE => __('Female'),
            self::GENDER_HERMAPHRODITE => __('Hermaphrodite'),
            self::GENDER_TRANSGENDER => __('Transgender'),
        ];
    }

    public static function getMaritalOptions(): array
    {
        return [
            self::MARITAL_STATUS_MARRIED => __('Married'),
            self::MARITAL_STATUS_SINGLE => __('Single')
        ];
    }

    public static function getReligionOptions(): array
    {
        return [
            self::RELIGION_ISLAM => __('Islam'),
            self::RELIGION_HINDU => __('Hindu'),
            self::RELIGION_CHRISTIAN => __('Christian'),
            self::RELIGION_BUDDHIST => __('Buddhist'),
            self::RELIGION_OTHERS => __('Others'),
        ];
    }



    /**
     * physical disability status
     */
    public const PHYSICALLY_DISABLE_YES = 1;
    public const PHYSICALLY_DISABLE_NOT = 2;


    /**
     * physical disability options
     */
    public const PHYSICAL_DISABILITY_BRAIN_INJURY = 1;
    public const PHYSICAL_DISABILITY_EPILEPSY = 2;
    public const PHYSICAL_DISABILITY_CYSTIC_FIBROSIS = 3;
    public const PHYSICAL_DISABILITY_OTHERS = 4;

    public static function getPhysicalDisabilityOptions(): array
    {
        return [
            self::PHYSICAL_DISABILITY_BRAIN_INJURY => __('Brain injury'),
            self::PHYSICAL_DISABILITY_EPILEPSY => __('Epilepsy'),
            self::PHYSICAL_DISABILITY_CYSTIC_FIBROSIS => __('Cystic fibrosis'),
            self::PHYSICAL_DISABILITY_OTHERS => __('Others'),
        ];

    }


    public function youth(): BelongsTo
    {
        return $this->BelongsTo(Youth::class);
    }

}
