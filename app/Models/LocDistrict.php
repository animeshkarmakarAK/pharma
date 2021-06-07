<?php

namespace App\Models;

use App\Abstracts\ModelAbstracts\BaseModel;
use App\Traits\ModelTraits\CreatedByUpdatedByRelationTrait;
use App\Traits\ModelTraits\LocDivisionBelongsToRelation;
use App\Traits\ModelTraits\ScopeRowStatusTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;


/**
 * App\Models\LocDistrict
 *
 * @property int $id
 * @property string $title
 * @property string|null $title_en
 * @property string|null $bbs_code
 * @property int $loc_division_id
 * @property bool|null $is_sadar_district
 * @property bool $row_status 1 => Active, 0 => Deactivate, 99 => Deleted
 * @property int $created_by
 * @property int $updated_by
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read \Softbd\Acl\Models\User $createdBy
 * @property-read \App\Models\LocDivision $locDivision
 * @property-read Collection|\App\Models\LocUpazila[] $locUpazilas
 * @property-read int|null $loc_upazilas_count
 * @property-read \Softbd\Acl\Models\User $updatedBy
 * @method static Builder|LocDistrict acl()
 * @method static Builder|LocDistrict active()
 * @method static Builder|LocDistrict newModelQuery()
 * @method static Builder|LocDistrict newQuery()
 * @method static Builder|LocDistrict query()
 */
class LocDistrict extends BaseModel
{
    use  ScopeRowStatusTrait, CreatedByUpdatedByRelationTrait, LocDivisionBelongsToRelation;

    protected $table = 'loc_districts';
    protected $guarded = ['id'];

    protected $casts = [
        'is_sadar_district' => 'boolean'
    ];

    public static function getIsSadarDistrictOptions(): array
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

    public function locUpazilas(): HasMany
    {
        return $this->hasMany(LocUpazila::class);
    }

}
