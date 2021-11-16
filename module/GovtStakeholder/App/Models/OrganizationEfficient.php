<?php

namespace Module\GovtStakeholder\App\Models;

use App\Traits\CreatedByUpdatedByRelationTrait;
use App\Traits\ScopeRowStatusTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Module\CourseManagement\App\Models\Youth;
use Module\GovtStakeholder\App\Traits\ScopeAclTrait;
use PhpParser\Builder;

/**
 * Class OrganizationEfficient
 * @package Module\GovtStakeholder\App\Models
 * @property string employee_level_occupation
 * @property string senior_level_occupation
 * @property string middle_level_occupation
 * @property string junior_level_occupation
 * @property int organization_information_id
 * @property-read OrganizationType organizationType
 * @method static \Illuminate\Database\Eloquent\Builder|Organization acl()
 * @method static Builder|Organization active()
 * @method static Builder|Organization newModelQuery()
 * @method static Builder|Organization newQuery()
 * @method static Builder|Organization query()
 */
class OrganizationEfficient extends BaseModel
{
    use HasFactory, ScopeRowStatusTrait, CreatedByUpdatedByRelationTrait, ScopeAclTrait;


    protected $guarded = ['id'];


    public function organizationInformation(): BelongsTo
    {
        return $this->belongsTo(OrganizationInformation::class);
    }



}
