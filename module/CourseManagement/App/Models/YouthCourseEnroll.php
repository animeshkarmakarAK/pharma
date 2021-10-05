<?php

namespace Module\CourseManagement\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class Youth
 * @package App\Models
 * @property int $id
 * @property string $enroll_status
 * @property string $payment_status
 */

class YouthCourseEnroll extends Model
{
    protected $guarded = ['id'];

    const ENROLL_STATUS_PROCESSING = 0;
    const ENROLL_STATUS_ACCEPT = 1;
    const ENROLL_STATUS_REJECT = 2;


    const PAYMENT_STATUS_PAID = 1;
    const PAYMENT_STATUS_UNPAID = 0;



    public function youth(): BelongsTo
    {
        return $this->belongsTo(Youth::class);
    }

    public function publishCourse(): BelongsTo
    {
        return $this->belongsTo(PublishCourse::class);
    }


}
