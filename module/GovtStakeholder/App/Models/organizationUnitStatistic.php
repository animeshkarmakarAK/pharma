<?php

namespace Module\GovtStakeholder\App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;


/**
 * Class organizationUnitStatistic
 * @package Module\GovtStakeholder\App\Models
 * @property int organization_unit_id
 * @property int total_occupied_position
 * @property int total_vacancy
 * @property int total_new_recruits
 * @property Carbon survey_date
 * @property-read OrganizationUnit organizationUnit
 */

class organizationUnitStatistic extends BaseModel
{
    use HasFactory;

    protected $guarded = ['id'];

    public function organizationUnit(): BelongsTo
    {
        return $this->belongsTo(OrganizationUnit::class);
    }


}
