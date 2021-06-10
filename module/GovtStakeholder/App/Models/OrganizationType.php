<?php

namespace Module\GovtStakeholder\App\Models;

use App\Traits\CreatedByUpdatedByRelationTrait;
use App\Traits\ScopeRowStatusTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class OrganizationType
 * @package Module\GovtStakeholder\App\Models
 * @property string title_en
 * @property string title_bn
 * @property bool is_government
 */
class OrganizationType extends BaseModel
{
    use HasFactory, ScopeRowStatusTrait, CreatedByUpdatedByRelationTrait;

    protected $guarded = ['id'];

}
