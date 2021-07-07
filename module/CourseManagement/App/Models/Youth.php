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
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

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
}
