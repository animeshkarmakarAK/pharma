<?php

namespace Module\GovtStakeholder\App\Models;

use App\Traits\LocDistrictBelongsToRelation;
use App\Traits\LocDivisionBelongsToRelation;
use App\Traits\LocUpazilaBelongsToRelation;
use App\Traits\ScopeRowStatusTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class OrganizationUnit
 * @package Module\GovtStakeholder\App\Models
 * @property string title_en
 * @property string title_bn
 * @property int organization_id
 * @property int organization_unit_type_id
 * @property string address
 * @property string mobile
 * @property string email
 * @property string fax_no
 * @property string contact_person_name
 * @property string contact_person_email
 * @property string contact_person_mobile
 * @property string contact_person_designation
 * @property int employee_size
 * @property-read Organization organization
 * @property-read OrganizationUnitType organizationUnitType
 */
class OrganizationUnit extends BaseModel
{
    use HasFactory, ScopeRowStatusTrait, LocDistrictBelongsToRelation, LocDivisionBelongsToRelation, LocUpazilaBelongsToRelation;

    protected $guarded = ['id'];


    /**************************
     *   ----Relationships----
     **************************/
    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class, 'organization_id', 'id');
    }

    public function organizationUnitType(): BelongsTo
    {
        return $this->belongsTo(OrganizationUnitType::class);
    }
}
