<?php

namespace Module\GovtStakeholder\App\Models;

use App\Traits\LocUpazilaBelongsToRelation;
use App\Traits\ScopeRowStatusTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class Rank
 * @package Module\GovtStakeholder\App\Models
 * @property int job_sector_id
 * @property-read RankType rankType
 */

class UpazilaJobStatistic extends BaseModel
{
    use HasFactory, ScopeRowStatusTrait, LocUpazilaBelongsToRelation;

    protected $guarded = ['id'];

    public function jobSector(): BelongsTo
    {
        return $this->belongsTo(JobSector::class);
    }

}
