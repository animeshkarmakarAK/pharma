<?php

namespace Module\CourseManagement\App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Module\GovtStakeholder\App\Models\Organization;

/**
 * Class YouthOrganization
 * @package Module\CourseManagement\App\Models
 * @property int organization_id
 * @property int youth_id
 */

class YouthOrganization extends BaseModel
{
    protected $guarded = ['id'];
    protected $table = 'youth_organizations';

    const CURRENT_EMPLOYMENT_STATUS_WORKING = 1;
    const CURRENT_EMPLOYMENT_STATUS_NOT_WORKING = 0;

    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class);
    }
}
