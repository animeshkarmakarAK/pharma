<?php

namespace Module\CourseManagement\App\Models;

use App\Traits\CreatedByUpdatedByRelationTrait;
use App\Traits\ScopeRowStatusTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Module\CourseManagement\App\Traits\ScopeAclTrait;

/**
 * Class Examination
 * @package App\Models
 * @property string title_en
 * @property string title_bn
 * @property int Batch_id
 * @property string|null address
 * @property string|null google_map_src
 * @method static \Illuminate\Database\Eloquent\Builder|Batch acl()
 * @method static Builder|Batch active()
 * @method static Builder|Batch newModelQuery()
 * @method static Builder|Batch newQuery()
 * @method static Builder|Batch query()
 */

class Examination extends BaseModel
{
    public $timestamps = true;
    protected $guarded = ['id'];


    public function Batch(): BelongsTo
    {
        return $this->belongsTo(Batch::class, batch_id);
    }

    public function ExaminationType(): BelongsTo
    {
        return $this->belongsTo(ExaminationType::class, examination_type_id);
    }
    public function TrainingCenter(): BelongsTo
    {
        return $this->belongsTo(TrainingCenter::class, training_center_id);
    }
}
