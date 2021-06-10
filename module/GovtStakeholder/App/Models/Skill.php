<?php

namespace Module\GovtStakeholder\App\Models;

use App\Traits\ScopeRowStatusTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class Skill
 * @package Module\GovtStakeholder\App\Models
 * @property int|null organization_id
 * @property string title_en
 * @property string title_bn
 * @property int | null description
 * @property-read Organization organization
 */

class Skill extends BaseModel
{
    use HasFactory, ScopeRowStatusTrait;

    protected $guarded = ['id'];

    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class);
    }
}
