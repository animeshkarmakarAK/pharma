<?php

namespace Module\GovtStakeholder\App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class HumanResource
 * @package Module\GovtStakeholder\App\Models
 * @property string title_en
 * @property string title_bn
 * @property int display_order
 * @property int human_resource_template_id
 * @property int organization_id
 * @property int organization_unit_id
 * @property int parent_id
 * @property int rank_id
 * @property int is_designation
 * @property int status
 * @property array skill_ids
 */

class HumanResource extends BaseModel
{
    use HasFactory;

    protected $guarded = ['id'];

    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class);
    }

    public function organizationUnit(): BelongsTo
    {
        return $this->belongsTo(OrganizationUnit::class);
    }

    public function humanResourceTemplate(): BelongsTo
    {
        return $this->belongsTo(HumanResourceTemplate::class);
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(HumanResourceTemplate::class);
    }

    public function children(): HasMany
    {
        return $this->hasMany(self::class, 'parent_id');
    }

    public function rank(): BelongsTo
    {
        return $this->belongsTo(Rank::class);
    }
}
