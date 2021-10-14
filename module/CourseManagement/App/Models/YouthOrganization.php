<?php

namespace Module\CourseManagement\App\Models;

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
}
