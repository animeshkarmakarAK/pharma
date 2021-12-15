<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * Class Trainee
 * @package App\Models
 * @property int $id
 * @property int batch_id
 * @property int course_id
 * @property int batch_status
 * @property string batch_title
 * @property string $enroll_status
 * @property string $payment_status
 */

class TraineeCourseEnroll extends Model
{
    protected $guarded = ['id'];

    const ENROLL_STATUS_PROCESSING = 0;
    const ENROLL_STATUS_ACCEPT = 1;
    const ENROLL_STATUS_REJECT = 2;


    const PAYMENT_STATUS_PAID = 1;
    const PAYMENT_STATUS_UNPAID = 0;



    public function trainee(): BelongsTo
    {
        return $this->belongsTo(Trainee::class);
    }

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    public function traineeBatch(): HasOne
    {
        return $this->hasOne(traineeBatch::class);
    }
}
