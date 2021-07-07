<?php

namespace Module\CourseManagement\App\Models;


use App\Traits\CreatedByUpdatedByRelationTrait;
use App\Traits\ScopeRowStatusTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\File;
use Module\CourseManagement\App\Traits\ScopeAclTrait;

/**
 * Class Course
 * @package App\Models
 * @property string|null title_en
 * @property string|null title_bn
 * @property string code
 * @property int institute_id
 * @property double course_fee
 * @property string description
 * @property string prerequisite
 * @property string eligibility
 * @property File cover_image
 * @method static \Illuminate\Database\Eloquent\Builder|Institute acl()
 * @method static Builder|Institute active()
 * @method static Builder|Institute newModelQuery()
 * @method static Builder|Institute newQuery()
 * @method static Builder|Institute query()
 */

class Course extends BaseModel
{
    use HasFactory, ScopeRowStatusTrait, CreatedByUpdatedByRelationTrait, ScopeAclTrait;

    protected $table = 'courses';
    protected $guarded = ['id'];
    const DEFAULT_COVER_IMAGE = 'course/course.jpeg';

    public function institute(): BelongsTo
    {
        return $this->belongsTo(Institute::class);
    }

    public function courseSessions(): HasMany
    {
        return $this->hasMany(CourseSession::class,'course_id','id');
    }

    public function publishCourses(): HasMany
    {
        return $this->hasMany(PublishCourse::class);
    }

}
