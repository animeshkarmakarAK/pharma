<?php

namespace Module\CourseManagement\App\Models;

use App\Traits\CreatedByUpdatedByRelationTrait;
use App\Traits\ScopeRowStatusTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * Class GalleryCategory
 * @package App\Models
 *
 * @property int $id
 * @property string title_en
 * @property string title_bn
 * @property Carbon|null created_at
 * @property Carbon|null updated_at
 * @property int institute_id
 * @property-read Institute institute
 */

class GalleryCategory extends BaseModel
{
    use HasFactory, ScopeRowStatusTrait, CreatedByUpdatedByRelationTrait;

    protected $guarded = ['id'];

    public function institute(): BelongsTo
    {
        return $this->belongsTo(Institute::class);
    }
}
