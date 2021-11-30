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
 * Class ExaminationResult
 * @package App\Models
 * @property string title_en
 * @property string title_bn
 * @property int institute_id
 * @property string|null address
 * @property string|null google_map_src
 * @method static \Illuminate\Database\Eloquent\Builder|Institute acl()
 * @method static Builder|Institute active()
 * @method static Builder|Institute newModelQuery()
 * @method static Builder|Institute newQuery()
 * @method static Builder|Institute query()
 */

class ExaminationResult extends BaseModel
{
    public $timestamps = true;
    protected $guarded = ['id'];

    public function institute(): BelongsTo
    {
        return $this->belongsTo(Institute::class, 'institute_id');
    }
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function youth(): BelongsTo
    {
        return $this->belongsTo(Youth::class, 'youth_id');
    }
    public function examination(): BelongsTo
    {
        return $this->belongsTo(Examination::class, 'examination_id');
    }
}
