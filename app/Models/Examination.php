<?php

namespace App\Models;

use App\Traits\ScopeAclTrait;
use App\Traits\ScopeRowStatusTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
 * @method static \Illuminate\Database\Eloquent\Builder|Institute acl()
 * @method static Builder|Institute active()
 * @method static Builder|Institute newModelQuery()
 * @method static Builder|Institute newQuery()
 * @method static Builder|Institute query()
 */

class Examination extends BaseModel
{
    use HasFactory, ScopeAclTrait, ScopeRowStatusTrait;

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
}
