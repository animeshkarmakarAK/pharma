<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * Class Youth
 * @package App\Models
 * @property int $id
 * @property int batch_id
 * @property int batch_status
 * @property string batch_title_en
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

    public function youthBatch(): HasOne
    {
        return $this->hasOne(youthBatch::class);
    }
}
