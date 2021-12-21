<?php

namespace App\Models;

use App\Traits\CreatedByUpdatedByRelationTrait;
use App\Traits\ScopeRowStatusTrait;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\File;
use App\Traits\ScopeAclTrait;

/**
 * Class Course
 * @package App\Models
 * @property string title
 * @property string code
 * @property int institute_id
 * @property double course_fee
 * @property string course_duration
 * @property string target_group
 * @property string course_objects
 * @property string course_contents
 * @property string training_methodology
 * @property string evaluation_system
 * @property string description
 * @property string prerequisite
 * @property string eligibility
 * @property File cover_image
 * @property array application_form_settings
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

    protected $casts = [
        'application_form_settings' => 'array'
    ];

    public function runningBatches(): Collection
    {
        $instance = $this->hasMany(Batch::class)
            ->whereDate('application_start_date', '<=',  Carbon::now())
            ->whereDate('application_end_date', '>=', Carbon::now());

        return $instance->get();
    }

    public function institute(): BelongsTo
    {
        return $this->belongsTo(Institute::class);
    }

    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branch::class);
    }

    public function trainingCenter(): BelongsTo
    {
        return $this->belongsTo(TrainingCenter::class);
    }

    public function enrolledTrainees(): HasMany
    {
        return $this->hasMany(TraineeCourseEnroll::class);
    }

    public function batches(): HasMany
    {
        return $this->hasMany(Batch::class);
    }

}
