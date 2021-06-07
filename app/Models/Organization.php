<?php

namespace App\Models;

use App\Abstracts\ModelAbstracts\BaseModel;
use App\Traits\ModelTraits\CreatedByUpdatedByRelationTrait;
use App\Traits\ModelTraits\ScopeRowStatusTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class Organization
 * @package App\Models
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
 * @property int loc_division_id
 * @property int loc_district_id
 * @property int loc_upazila_id
 * @property-read OrganizationType organizationType
 */
class Organization extends BaseModel
{
    use HasFactory, ScopeRowStatusTrait, CreatedByUpdatedByRelationTrait;
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
