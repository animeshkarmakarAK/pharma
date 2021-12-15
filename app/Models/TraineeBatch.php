<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class Tag
 * @package App\Models
 * @property carbon enrollment_date
 * @property int batch_id
 * @property int youth_registration_id
 * @property int youth_id
 * @property int enrollment_status
 * @property int created_by
 * @property int youth_enroll_id
 */

class YouthBatch extends BaseModel
{
    const ENROLLMENT_STATUS_PENDING = 0;
    const ENROLLMENT_STATUS_ENROLLED = 1;
    const ENROLLMENT_STATUS_REJECTED = 2;

    protected $guarded = ['id'];


    public function batch(): BelongsTo
    {
        return $this->belongsTo(Batch::class);
    }

    public function youthCourseEnroll(): BelongsTo
    {
        return $this->belongsTo(YouthCourseEnroll::class);
    }
}
