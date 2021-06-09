<?php

namespace Module\CourseManagement\App\Models;

use App\Traits\CreatedByUpdatedByRelationTrait;
use Module\CourseManagement\App\Traits\ScopeAclTrait;
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
 */
class Programme extends BaseModel
{
    use HasFactory, CreatedByUpdatedByRelationTrait, ScopeRowStatusTrait, ScopeAclTrait;

    protected $guarded = ['id'];
    protected $fillable = ['title_en', 'title_bn', 'institute_id', 'code', 'description','logo'];


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
