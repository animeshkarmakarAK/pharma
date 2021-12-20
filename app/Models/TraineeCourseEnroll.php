<?php

namespace App\Models;

use App\Traits\ScopeAclTrait;
use App\Traits\ScopeRowStatusTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;


/**
 * Class TraineeCourseEnroll
 * @package App\Models
 * @property int $id
 * @property int trainee_id
 * @property int course_id
 * @property string $enroll_status
 * @property string $payment_status
 * @property array $batch_preferences
 * @method static \Illuminate\Database\Eloquent\Builder|Institute acl()
 */
class TraineeCourseEnroll extends Model
{
    use ScopeRowStatusTrait, ScopeAclTrait;

    protected $guarded = ['id'];


    protected $casts = [
        'batch_preferences' => 'array'
    ];

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
