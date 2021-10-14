<?php

namespace Module\CourseManagement\App\Models;

use App\Helpers\Classes\Helper;
use App\Models\AuthBaseModel;
use App\Models\LocDistrict;
use App\Models\LocDivision;
use App\Models\LocUpazila;
use App\Traits\AuthenticatableUser;
use App\Traits\ScopeRowStatusTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Module\GovtStakeholder\App\Models\Organization;

/**
 * Class Youth
 * @package App\Models
 * @property string $name_en
 * @property string $name_bn
 * @property string $mobile
 * @property int $present_address_division_bbs_code
 * @property int $present_address_district_bbs_code
 * @property int $present_address_upazila_bbs_code
 * @property string $present_address_house_address
 * @property int $permanent_address_division_bbs_code
 * @property int $permanent_address_district_bbs_code
 * @property int $permanent_address_upazila_bbs_code
 * @property string $permanent_address_house_address
 * @property string $ethnic_group
 * @property string|null youth_registration_no
 * @property int youth_course_enroll_id
 */
class Youth extends AuthBaseModel
{
    use AuthenticatableUser;

    use HasFactory, ScopeRowStatusTrait;

    protected $guarded = ['id'];

    protected $casts = [
        'present_address_house_address' => 'array',
        'permanent_address_house_address' => 'array',
    ];
    /**
     * @var mixed
     */

    public static function getUniqueAccessKey(): string
    {
        while (true) {
            $value = Helper::randomPassword(10, true);
            if (!Youth::where('access_key', $value)->count()) {
                break;
            }
        }

        return $value;
    }

    public function setYouthRegistrationNumber(): string
    {
        if (empty($this->youth_registration_no)) {
            $this->youth_registration_no = Helper::randomPassword(10, true);
        }

        return $this->youth_registration_no;
    }


    /**
     * ethnic group
     */
    public const ETHNIC_GROUP_YES = 1;
    public const ETHNIC_GROUP_NO = 2;



    /**
     * @return HasMany
     */
    public function youthFamilyMemberInfo(): HasMany
    {
        return $this->hasMany(YouthFamilyMemberInfo::class);
    }

    /**
     * @return HasMany
     */
    public function youthAcademicQualifications(): HasMany
    {
        return $this->hasMany(YouthAcademicQualification::class);
    }

    /**
     * @return HasOne
     */
    public function youthRegistration(): HasOne
    {
        return $this->hasOne(YouthRegistration::class);
    }

    public function presentAddressDistrict(): BelongsTo
    {
        return $this->belongsTo(LocDistrict::class, 'present_address_district_id', 'id');
    }

    public function presentAddressDivision(): BelongsTo
    {
        return $this->belongsTo(LocDivision::class, 'present_address_division_id', 'id');
    }

    public function presentAddressUpazila(): BelongsTo
    {
        return $this->belongsTo(LocUpazila::class, 'present_address_upazila_id', 'id');
    }

    public function permanentAddressDivision(): BelongsTo
    {
        return $this->belongsTo(LocDivision::class, 'permanent_address_division_id', 'id');
    }

    public function permanentAddressDistrict(): BelongsTo
    {
        return $this->belongsTo(LocDistrict::class, 'permanent_address_district_id', 'id');
    }

    public function permanentAddressUpazila(): BelongsTo
    {
        return $this->belongsTo(LocUpazila::class, 'permanent_address_upazila_id', 'id');
    }

    public function youthCourseEnroll(): HasOne
    {
        return $this->hasOne(YouthCourseEnroll::class);
    }

    public function youthOrganizations():BelongsToMany
    {
      return $this->belongsToMany(Organization::class,"youth_organizations");
    }


    public const HAVE_FAMILY_OWN_HOUSE = 1;
    public const HAVE_FAMILY_OWN_LAND = 1;
    public const  RECOMMENDED_BY_ORGANIZATION = 1;


    public const CURRENT_EMPLOYMENT_STATUS_YES = 1;
    public const CURRENT_EMPLOYMENT_STATUS_NO = 2;

    public static function getYouthCurrentEmploymentStatusOptions(): array
    {
        return [
            self::CURRENT_EMPLOYMENT_STATUS_YES => __('Yes'),
            self::CURRENT_EMPLOYMENT_STATUS_NO => __('No'),
        ];
    }


    public function getYouthCurrentEmploymentStatus(): string
    {
        $employmentStatus = 'Not specified';
        $employmentStatusArray = self::getYouthCurrentEmploymentStatusOptions();
        if (empty($employmentStatusArray[$this->current_employment_status])) return $employmentStatus;

        return $employmentStatusArray[$this->current_employment_status];
    }


    /**
     * Unique Reg No Generate function
     */
    public function genRegNo(): int
    {
        $regNumber = mt_rand(1000000000, 9999999999);
        if ($this->regNumberExists($regNumber)) {
            return $this->genRegNo();
        }
        return $regNumber;
    }
    public function regNumberExists($regNumber)
    {
        return Youth::where(['youth_registration_no'=>$regNumber])->exists();
    }


}
