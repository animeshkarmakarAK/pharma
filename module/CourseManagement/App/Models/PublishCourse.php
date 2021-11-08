<?php

namespace Module\CourseManagement\App\Models;

use App\Traits\CreatedByUpdatedByRelationTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Module\CourseManagement\App\Traits\ScopeAclTrait;
use App\Traits\ScopeRowStatusTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * Class PublishCourse
 * @package App\Models
 * @property int $publish_status
 * @property int $course_id
 * @property int $institute_id
 * @property int|null $programme_id
 * @property int|null $training_center_id
 * @property Carbon $start_date
 * @property Carbon $end_date
 * @property int $created_by
 * @property string|null $title_en
 * @property string|null $title_bn
 * @property-read Course course
 * @property-read CourseSession courseSessions
 * @property-read Institute institute
 * @method static \Illuminate\Database\Eloquent\Builder|Institute acl()
 * @method static Builder|Institute active()
 * @method static Builder|Institute newModelQuery()
 * @method static Builder|Institute newQuery()
 * @method static Builder|Institute query()
 */
class PublishCourse extends BaseModel
{
    use HasFactory, CreatedByUpdatedByRelationTrait, ScopeRowStatusTrait, ScopeAclTrait;

    public const PUBLISH_STATUS_DRAFT = 0;
    public const PUBLISH_STATUS_PENDING = 1;
    public const PUBLISH_STATUS_PUBLISH = 2;
    public const PUBLISH_STATUS_UNPUBLISHED = 3;

    protected $guarded = ['id'];

    protected $casts = [
        'training_center_id' => 'array',
    ];



    public static function getPublishStatus($decorated = false): array
    {
        return [
            self::PUBLISH_STATUS_DRAFT => sprintf($decorated ? '<span class="badge badge-danger"> %s </span>' : '%s', __('Draft')),
            self::PUBLISH_STATUS_PENDING => sprintf($decorated ? '<span class="badge badge-warning"> %s </span>' : '%s', __('Pending')),
            self::PUBLISH_STATUS_PUBLISH => sprintf($decorated ? '<span class="badge badge-success"> %s </span>' : '%s', __('Publish')),
            self::PUBLISH_STATUS_UNPUBLISHED => sprintf($decorated ? '<span class="badge badge-primary"> %s </span>' : '%s', __('Unpublished'))
        ];
    }

    public function currentPublishStatusLabel($decorated = false): string
    {
        $publishStatus = '';

        $publishStatusArray = self::getPublishStatus($decorated);

        if (empty($publishStatusArray[$this->publish_status])) {
            return $publishStatus;
        }

        return $publishStatusArray[$this->publish_status];
    }

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
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

    public function programme(): BelongsTo
    {
        return $this->belongsTo(Programme::class);
    }

    public function applicationFormType(): BelongsTo
    {
        return $this->belongsTo(ApplicationFormType::class);
    }

    public function youthRegistrations(): HasMany
    {
        return $this->hasMany(YouthRegistration::class);
    }

    public function courseSessions(): HasMany
    {
        return $this->hasMany(CourseSession::class);
    }

    public function batch(): HasOne
    {
        return $this->hasOne(Batch::class);
    }

}
