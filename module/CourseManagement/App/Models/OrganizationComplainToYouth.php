<?php

namespace Module\CourseManagement\App\Models;

use App\Traits\ScopeRowStatusTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Module\GovtStakeholder\App\Models\Organization;

/**
 * Class OrganizationComplainToYouth
 * @package Module\GovtStakeholder\App\Models
 * @property int organization_id
 * @property int youth_id
 * @property int institute_id
 * @property string | null complain_title
 * @property string | null complain_msg
 * @property-read Organization organization
 * @property-read Institute institute
 * @property-read Youth youth
 */

class OrganizationComplainToYouth extends BaseModel
{
    use HasFactory, ScopeRowStatusTrait;

    protected $guarded = ['id'];

    /*public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class);
    }

    public function institute(): BelongsTo
    {
        return $this->belongsTo(Institute::class);
    }

    public function youths(): BelongsTo
    {
        return $this->belongsTo(Youth::class);
    }*/
}
