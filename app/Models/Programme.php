<?php

namespace App\Models;

use App\Traits\CreatedByUpdatedByRelationTrait;
use Illuminate\Database\Eloquent\Builder;
use App\Traits\ScopeAclTrait;
use App\Traits\ScopeRowStatusTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class Programme
 * @package App\Models
 * @property string title_en
 * @property string title_bn
 * @property int institute_id
 * @property string|null logo
 * @method static \Illuminate\Database\Eloquent\Builder|Institute acl()
 * @method static Builder|Institute active()
 * @method static Builder|Institute newModelQuery()
 * @method static Builder|Institute newQuery()
 * @method static Builder|Institute query()
 */
class Programme extends BaseModel
{
    use HasFactory, CreatedByUpdatedByRelationTrait, ScopeRowStatusTrait, ScopeAclTrait;

    protected $guarded = ['id'];

    const DEFAULT_LOGO = 'programme/default.jpg';


    public function institute(): BelongsTo
    {
        return $this->belongsTo(Institute::class);
    }
    public function publishCourses(): HasMany
    {
        return $this->hasMany(PublishCourse::class);
    }

    public function logoIsDefault(): bool
    {
        return $this->logo === self::DEFAULT_LOGO;
    }
}
