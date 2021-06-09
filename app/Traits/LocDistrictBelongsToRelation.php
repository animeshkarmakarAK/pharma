<?php


namespace App\Traits;


use App\Models\LocDistrict;
use Illuminate\Database\Eloquent\Model;

trait LocDistrictBelongsToRelation
{
    public function locDistrict(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        /** @var Model $this */
        return $this->belongsTo(LocDistrict::class, 'loc_district_id')
            ->select(['id', 'loc_division_id', 'title_en', 'title', 'bbs_code']);
    }
}
