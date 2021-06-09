<?php

namespace App\Traits;


use App\Models\LocDistrict;
use Illuminate\Database\Eloquent\Model;

trait LocDivisionBelongsToRelation
{
    public function locDivision(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        /** @var Model $this */
        return $this->belongsTo(LocDistrict::class, 'loc_division_id')
            ->select(['id', 'title_en', 'title', 'bbs_code']);
    }
}
