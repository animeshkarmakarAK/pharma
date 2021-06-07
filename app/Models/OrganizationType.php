<?php

namespace App\Models;

use App\Abstracts\ModelAbstracts\BaseModel;
use App\Traits\ModelTraits\CreatedByUpdatedByRelationTrait;
use App\Traits\ModelTraits\ScopeRowStatusTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;


/**
 * Class OrganizationType
 * @package App\Models
 * @property string title_en
 * @property string title_bn
 * @property bool is_government
 */
class OrganizationType extends BaseModel
{
    use HasFactory, ScopeRowStatusTrait, CreatedByUpdatedByRelationTrait;

    protected $guarded = ['id'];

}
