<?php

namespace App\Models;

use App\Abstracts\ModelAbstracts\BaseModel;
use App\Traits\ModelTraits\CreatedByUpdatedByRelationTrait;
use App\Traits\ModelTraits\ScopeRowStatusTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;


/**
 * App\Models\LocDivision
 *
 * @property int $id
 * @property string $title
 * @property string $title_en
 * @property string|null $bbs_code
 * @property bool $row_status 1 => Active, 0 => Deactivate, 99 => Deleted
 * @property int $created_by
 * @property int $updated_by
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read \Softbd\Acl\Models\User $createdBy
 * @property-read Collection|\App\Models\LocDistrict[] $locDistricts
 * @property-read int|null $loc_districts_count
 * @property-read Collection|\App\Models\LocUpazila[] $locUpazilas
 * @property-read int|null $loc_upazilas_count
 * @property-read \Softbd\Acl\Models\User $updatedBy
 * @method static Builder|LocDivision acl()
 * @method static Builder|LocDivision active()
 * @method static Builder|LocDivision newModelQuery()
 * @method static Builder|LocDivision newQuery()
 * @method static Builder|LocDivision query()
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
