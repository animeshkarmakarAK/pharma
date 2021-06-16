<?php

namespace Module\CourseManagement\App\Models;

use Carbon\Carbon;
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
 * @property int created_by
 * @property Carbon start_date
 * @property Carbon end_date
 * @property Carbon start_time
 * @property Carbon end_time
 */

class Batch extends Model
{
    use HasFactory, ScopeAclTrait;

    protected $guarded = ['id'];

    public function course(): BelongsTo
    {
        return $this->BelongsTo(Course::class);
    }

    public function institute(): BelongsTo
    {
        return $this->belongsTo(Institute::class);

    }
}
