<?php

namespace App\Models;

use App\Traits\CreatedByUpdatedByRelationTrait;
use App\Traits\LocDistrictBelongsToRelation;
use App\Traits\LocDivisionBelongsToRelation;
use App\Traits\ScopeRowStatusTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;


/**
 * App\Models\LocUpazila
 *
 * @property int $id
 * @property string $title
 * @property string $title_en
 * @property int $loc_division_id
 * @property int $loc_district_id
 * @property string|null $district_bbs_code
 * @property bool $is_sadar_upazila
 * @property-read \App\Models\LocDistrict $locDistrict
 * @property-read \App\Models\LocDivision $locDivision
 * @property-read int|null $loc_unions_count
 */
class LocUpazila extends BaseModel
{
    use  ScopeRowStatusTrait, CreatedByUpdatedByRelationTrait, LocDivisionBelongsToRelation, LocDistrictBelongsToRelation;

    protected $guarded = ['id'];

    protected $casts = [
        'is_sadar_upazila' => 'boolean'
    ];

    public static function getIsSadarUpazilaOptions(): array
    {
        return [
            '0' => __('No'),
            '1' => __('Yes')
        ];
    }
}
