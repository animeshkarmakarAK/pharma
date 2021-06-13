<?php

namespace Module\GovtStakeholder\App\Models;

use App\Traits\LocUpazilaBelongsToRelation;
use App\Traits\ScopeRowStatusTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Module\CourseManagement\App\Models\Institute;

/**
 * Class OccupationWiseStatistic
 * @package Module\GovtStakeholder\App\Models
 * @property int institute_id
 * @property int occupation_id
 * @property int current_month_skilled_youth
 * @property int next_month_skill_youth
 * @property-read Institute institute
 * @property-read Occupation occupation
 */

class OccupationWiseStatistic extends BaseModel
{
    use HasFactory, ScopeRowStatusTrait, LocUpazilaBelongsToRelation;

    protected $guarded = ['id'];

    public function institute(): BelongsTo
    {
        return $this->belongsTo(Institute::class);
    }

    public function occupation(): BelongsTo
    {
        return $this->belongsTo(Occupation::class);
    }

}
