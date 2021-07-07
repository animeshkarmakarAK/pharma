<?php

namespace Module\GovtStakeholder\App\Models;

use App\Traits\ScopeRowStatusTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Module\GovtStakeholder\App\Traits\ScopeAclTrait;

/**
 * Class Service
 * @package Module\GovtStakeholder\App\Models
 * @property int organization_id
 * @property string title_en
 * @property string title_bn
 * @property-read Organization organization
 * @method static \Illuminate\Database\Eloquent\Builder|Organization acl()
 * @method static Builder|Organization active()
 * @method static Builder|Organization newModelQuery()
 * @method static Builder|Organization newQuery()
 * @method static Builder|Organization query()
 */


class Service extends BaseModel
{
    use HasFactory, ScopeRowStatusTrait, ScopeAclTrait;

    protected $guarded = ['id'];

    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class);
    }
}
