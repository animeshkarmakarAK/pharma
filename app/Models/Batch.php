<?php

namespace App\Models;

use App\Traits\ScopeRowStatusTrait;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Traits\ScopeAclTrait;

/**
 * Class Batch
 * @package App\Models
 * @property string title
 * @property string code
 * @property int institute_id
 * @property int|null branch_id
 * @property int training_center_id
 * @property int course_id
 * @property int max_student_enrollment
 * @property string course_coordinator_signature
 * @property string course_director_signature
 * @property int created_by
 * @property int batch_status
 * @property Carbon start_date
 * @property Carbon end_date
 * @property Carbon start_time
 * @property Carbon end_time
 * @property-read Course course
 * @property-read Institute institute
 * @property-read Branch branch
 * @property-read TrainingCenter trainingCenter
 *@method static \Illuminate\Database\Eloquent\Builder|Batch acl()
 * @method static Builder|Batch active()
 * @method static Builder|Batch newModelQuery()
 * @method static Builder|Batch newQuery()
 * @method static Builder|Batch query()
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

    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branch::class);
    }

    public function trainingCenter(): BelongsTo
    {
        return $this->belongsTo(TrainingCenter::class);
    }
}
