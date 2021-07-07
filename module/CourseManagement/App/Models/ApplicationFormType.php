<?php

namespace Module\CourseManagement\App\Models;

use App\Traits\CreatedByUpdatedByRelationTrait;
use App\Traits\ScopeRowStatusTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Module\CourseManagement\App\Traits\ScopeAclTrait;

/**
 * Class ApplicationFormType
 * @package App\Models
 * @property int institute_id
 * @property string title_en
 * @property string title_bn
 * @method static \Illuminate\Database\Eloquent\Builder|Institute acl()
 * @method static Builder|Institute active()
 * @method static Builder|Institute newModelQuery()
 * @method static Builder|Institute newQuery()
 * @method static Builder|Institute query()
 */

class ApplicationFormType extends BaseModel
{
    use HasFactory, scopeRowStatusTrait, CreatedByUpdatedByRelationTrait, ScopeAclTrait;

    protected $table = "application_form_types";
    protected $guarded = ['id'];

    public function institute(): BelongsTo
    {
        return $this->belongsTo(Institute::class);
    }
}
