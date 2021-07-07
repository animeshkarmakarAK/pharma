<?php

namespace Module\GovtStakeholder\App\Models;

use App\Traits\CreatedByUpdatedByRelationTrait;
use App\Traits\ScopeRowStatusTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Module\GovtStakeholder\App\Traits\ScopeAclTrait;
use PhpParser\Builder;

/**
 * Class Organization
 * @package Module\GovtStakeholder\App\Models
 * @property string title_en
 * @property string title_bn
 * @property string address
 * @property string mobile
 * @property string email
 * @property string fax_no
 * @property string contact_person_name
 * @property string contact_person_mobile
 * @property string contact_person_email
 * @property string contact_person_designation
 * @property string description
 * @property string logo
 * @property string domain
 * @property int organization_type_id
 * @property-read OrganizationType organizationType
 * @method static \Illuminate\Database\Eloquent\Builder|Organization acl()
 * @method static Builder|Organization active()
 * @method static Builder|Organization newModelQuery()
 * @method static Builder|Organization newQuery()
 * @method static Builder|Organization query()
 */
class Organization extends BaseModel
{
    use HasFactory, ScopeRowStatusTrait, CreatedByUpdatedByRelationTrait, ScopeAclTrait;

    const DEFAULT_LOGO = 'organizations/default.jpg';
    const LOGO_FOLDER_NAME = 'organizations';
    protected $guarded = ['id'];


    public function organizationType(): BelongsTo
    {
        return $this->belongsTo(OrganizationType::class);
    }

    public function logoIsDefault(): bool
    {
        return $this->logo === self::DEFAULT_LOGO;
    }


}
