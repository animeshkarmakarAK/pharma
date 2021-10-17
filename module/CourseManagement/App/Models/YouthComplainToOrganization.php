<?php

namespace Module\CourseManagement\App\Models;

use App\Traits\ScopeRowStatusTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Module\GovtStakeholder\App\Models\Organization;

/**
 * Class YouthComplainToOrganization
 * @package Module\CourseManagement\App\Models
 * @property int organization_id
 * @property int youth_id
 * @property int institute_id
 * @property string | null complain_title
 * @property string | null complain_msg
 * @property-read Organization organization
 * @property-read Institute institute
 * @property-read Youth youth
 */

class YouthComplainToOrganization extends BaseModel
{
    use HasFactory, ScopeRowStatusTrait;

    protected $guarded = ['id'];
}
