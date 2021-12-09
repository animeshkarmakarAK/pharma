<?php

namespace Module\CourseManagement\App\Models;

use App\Traits\ScopeRowStatusTrait;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Module\CourseManagement\App\Traits\ScopeAclTrait;

/**
 * Class Batch
 * @package Module\CourseManagement\App\Models
 * @property string title_en
 * @property string title_bn
 * @property string code
 * @property int institute_id
 * @property int branch_id
 * @property int training_center_id
 * @property int course_id
 * @property int publish_course_id
 * @property int programme_id
 * @property int application_form_type_id
 * @property int max_student_enrollment
 * @property string course_coordinator_signature
 * @property string course_director_signature
 * @property int created_by
 * @property int batch_status
 * @property Carbon start_date
 * @property Carbon end_date
 * @property Carbon start_time
 * @property Carbon end_time
 *@method static \Illuminate\Database\Eloquent\Builder|Institute acl()
 * @method static Builder|Institute active()
 * @method static Builder|Institute newModelQuery()
 * @method static Builder|Institute newQuery()
 * @method static Builder|Institute query()
 */

class Batch extends Model
{
    use HasFactory, ScopeAclTrait, ScopeRowStatusTrait;

    const BATCH_STATUS_ON_GOING = 1;
    const BATCH_STATUS_COMPLETE = 2;

    protected $guarded = ['id'];

    public function course(): BelongsTo
    {
        return $this->BelongsTo(Course::class);
    }

    public function institute(): BelongsTo
    {
        return $this->belongsTo(Institute::class);
    }

    public function publishCourse(): BelongsTo
    {
        return $this->belongsTo(PublishCourse::class);
    }

    public function trainingCenter(): BelongsTo
    {
        return $this->belongsTo(TrainingCenter::class);
    }
}
