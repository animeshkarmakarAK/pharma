<?php

namespace App\Models;

use App\Abstracts\ModelAbstracts\BaseModel;
use App\Traits\ModelTraits\ScopeRowStatusTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * Class RankType
 * @package App\Models
 * @property int|null organization_id
 * @property string title_en
 * @property string title_bn
 * @property int|null description
 * @property Carbon|null created_at
 * @property Carbon|null updated_at
 * @property-read Organization organization
 */


class RankType extends BaseModel
{
    use HasFactory, ScopeRowStatusTrait;

    protected $guarded = ['id'];

    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class);
    }
}
