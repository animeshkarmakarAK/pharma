<?php

namespace App\Models;

use App\Traits\CreatedByUpdatedByRelationTrait;
use App\Traits\ScopeRowStatusTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;


/**
 * App\Models\LocDivision
 *
 * @property int $id
 * @property string $title
 * @property string $title_en
 * @property string|null $bbs_code
 * @property-read Collection|\App\Models\LocDistrict[] $locDistricts
 * @property-read int|null $loc_districts_count
 * @property-read Collection|\App\Models\LocUpazila[] $locUpazilas
 * @property-read int|null $loc_upazilas_count
 */
class LocDivision extends BaseModel
{
    use  ScopeRowStatusTrait, CreatedByUpdatedByRelationTrait;

    protected $table = 'loc_divisions';
    protected $guarded = ['id'];

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

    public function locDistricts(): HasMany
    {
        return $this->hasMany(LocDistrict::class);
    }

    public function locUpazilas(): HasManyThrough
    {
        return $this->hasManyThrough(LocUpazila::class, LocDistrict::class);
    }
}
