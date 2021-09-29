<?php

namespace Module\CourseManagement\App\Models;

use App\Helpers\Classes\Helper;
use App\Traits\CreatedByUpdatedByRelationTrait;
use App\Traits\ScopeRowStatusTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class YouthRegistration
 * @package App\Models
 * @property string|null youth_registration_no
 * @property int youth_id
 * @property int publish_course_id
 * @property int|null recommended_by_organization
 * @property string|null recommended_org_name
 * @property int|null current_employment_status
 * @property int|null year_of_experience
 * @property int|null personal_monthly_income
 * @property int|null have_family_own_house
 * @property int|null have_family_own_land
 * @property string|null student_signature_pic
 */
class YouthRegistration extends BaseModel
{
    use HasFactory, CreatedByUpdatedByRelationTrait, ScopeRowStatusTrait;

    protected $guarded = ['id'];

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


    public function setYouthRegistrationNumber(): string
    {
        if (empty($this->youth_registration_no)) {
            $this->youth_registration_no = Helper::randomPassword(10, true);
        }

        return $this->youth_registration_no;
    }

    public function getYouthCurrentEmploymentStatus(): string
    {
        $employmentStatus = 'Not specified';
        $employmentStatusArray = self::getYouthCurrentEmploymentStatusOptions();
        if (empty($employmentStatusArray[$this->current_employment_status])) return $employmentStatus;

        return $employmentStatusArray[$this->current_employment_status];
    }

    /*public function youth(): BelongsTo
    {
        return $this->belongsTo(Youth::class);
    }

    public function publishCourse(): BelongsTo
    {
        return $this->belongsTo(PublishCourse::class);
    }*/

}
