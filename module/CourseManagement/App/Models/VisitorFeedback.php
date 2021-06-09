<?php

namespace Module\CourseManagement\App\Models;


use App\Traits\CreatedByUpdatedByRelationTrait;
use Module\CourseManagement\App\Traits\ScopeAclTrait;
use App\Traits\ScopeRowStatusTrait;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class VisitorFeedback
 * @package App\Models
 * @property int institute_id
 * @property string name
 * @property string mobile
 * @property string email
 * @property string|null address
 * @property string comment
 * @property int form_type
 * @property Carbon read_at
 * @property-read Institute institute
 */
class VisitorFeedback extends BaseModel
{
    use HasFactory, ScopeRowStatusTrait, CreatedByUpdatedByRelationTrait, ScopeAclTrait;

    protected $guarded = ['id'];
    const FORM_TYPE_FEEDBACK = 1;
    const FORM_TYPE_CONTACT = 2;

    public function institute(): BelongsTo
    {
        return $this->belongsTo(Institute::class);
    }

}
