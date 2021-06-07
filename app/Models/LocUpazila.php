<?php

namespace App\Models;

use App\Abstracts\ModelAbstracts\BaseModel;
use App\Traits\ModelTraits\CreatedByUpdatedByRelationTrait;
use App\Traits\ModelTraits\LocDistrictBelongsToRelation;
use App\Traits\ModelTraits\LocDivisionBelongsToRelation;
use App\Traits\ModelTraits\ScopeRowStatusTrait;
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
 * @property bool $row_status 1 => Active, 0 => Deactivate, 99 => Deleted
 * @property int $created_by
 * @property int $updated_by
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read \Softbd\Acl\Models\User $createdBy
 * @property-read \App\Models\LocDistrict $locDistrict
 * @property-read \App\Models\LocDivision $locDivision
 * @property-read int|null $loc_unions_count
 * @property-read \Softbd\Acl\Models\User $updatedBy
 * @method static Builder|LocUpazila acl()
 * @method static Builder|LocUpazila active()
 * @method static Builder|LocUpazila newModelQuery()
 * @method static Builder|LocUpazila newQuery()
 * @method static Builder|LocUpazila query()
 */
class LocUpazila extends BaseModel
{
    use  ScopeRowStatusTrait, CreatedByUpdatedByRelationTrait, LocDivisionBelongsToRelation, LocDistrictBelongsToRelation;

    protected $table = 'loc_upazilas';
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

    /**
     * Scope a query to only include the data access associate with the auth user.
     * @param Builder $query
     * @param string|null $alias
     * @return Builder
     */
    public function scopeAcl(Builder $query, string $alias = null): Builder
    {
        if (empty($alias)) {
            $alias = $this->getTable() . '.';
        }
        return $query;
    }
}
