<?php

namespace Module\CourseManagement\App\Models;

use App\Traits\CreatedByUpdatedByRelationTrait;
use Module\CourseManagement\App\Traits\ScopeAclTrait;
use App\Traits\ScopeRowStatusTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class TrainingCenter
 * @package App\Models
 * @property string title_en
 * @property string title_bn
 * @property int institute_id
 * @property int branch_id
 * @property string|null address
 * @property string|null google_map_src
 */
class TrainingCenter extends BaseModel
{
    use HasFactory, CreatedByUpdatedByRelationTrait, ScopeRowStatusTrait, ScopeAclTrait;
    protected $guarded = ['id'];


    public function institute(): BelongsTo
    {
        return $this->belongsTo(Institute::class);
    }

    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branch::class);
    }

    public function publishCourses(): HasMany
    {
        return $this->hasMany(PublishCourse::class);
    }

}
