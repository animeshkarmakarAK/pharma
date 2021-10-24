<?php

namespace Module\CourseManagement\App\Models;

use App\Traits\CreatedByUpdatedByRelationTrait;
use Carbon\Carbon;
use Module\CourseManagement\App\Traits\ScopeAclTrait;
use App\Traits\ScopeRowStatusTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class Event
 * @package App\Models
 * @property int institute_id
 * @property string caption
 * @property string image
 * @property Carbon date
 * @property string details
 */
class Event extends BaseModel
{
    use HasFactory, CreatedByUpdatedByRelationTrait, ScopeRowStatusTrait, ScopeAclTrait;

    protected $guarded = ['id'];

    const DEFAULT_IMAGE = 'event/default.jpg';

    public function institute(): BelongsTo
    {
        return $this->belongsTo(Institute::class);
    }

}
