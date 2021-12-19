<?php

namespace App\Models;

use App\Traits\ScopeAclTrait;
use App\Traits\ScopeRowStatusTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class Examination
 * @package App\Models
 * @property string code
 * @property int institute_id
 * @property int batch_id
 * @property int training_center_id
 * @property int examination_type_id
 * @property int pass_mark
 * @property int total_mark
 * @property int status
 * @property int row_status
 * @property int created_by
 * @property int $updated_by
 * @property string|null exam_details
 * @property mixed ExaminationResult $examinationResult
 * @method static \Illuminate\Database\Eloquent\Builder|Institute acl()
 * @method static Builder|Institute active()
 * @method static Builder|Institute newModelQuery()
 * @method static Builder|Institute newQuery()
 * @method static Builder|Institute query()
 */

class Examination extends BaseModel
{
    use HasFactory, ScopeAclTrait, ScopeRowStatusTrait;

    const EXAMINATION_ROW_STATUS_ACTIVE = 1;
    const EXAMINATION_ROW_STATUS_INACTIVE = 0;
    const EXAMINATION_STATUS_NOT_PUBLISH= 0;
    const EXAMINATION_STATUS_PUBLISH= 1;
    const EXAMINATION_STATUS_COMPLETE= 2;

    public $timestamps = true;
    protected $guarded = ['id'];



    public function batch(): BelongsTo
    {
        return $this->belongsTo(Batch::class, 'batch_id');
    }

    public function examinationType(): BelongsTo
    {
        return $this->belongsTo(ExaminationType::class, 'examination_type_id');
    }
    public function trainingCenter(): BelongsTo
    {
        return $this->belongsTo(TrainingCenter::class, 'training_center_id');
    }
    public function institute(): BelongsTo
    {
        return $this->belongsTo(Institute::class);
    }
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function examinationResult(): HasMany
    {
        return $this->hasMany(ExaminationResult::class,'examination_id');
    }


}
