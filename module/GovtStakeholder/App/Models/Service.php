<?php

namespace Module\GovtStakeholder\App\Models;

use App\Traits\ScopeRowStatusTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class Service
 * @package Module\GovtStakeholder\App\Models
 * @property int organization_id
 * @property string title_en
 * @property string title_bn
 * @property-read Organization organization
 */


class Service extends BaseModel
{
    use HasFactory, ScopeRowStatusTrait;

    protected $guarded = ['id'];

    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class);
    }
}
