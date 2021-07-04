<?php

namespace Module\CourseManagement\App\Models;

use App\Models\RowStatus;
use App\Traits\CreatedByUpdatedByRelationTrait;
use App\Traits\ScopeRowStatusTrait;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * Class GalleryCategory
 * @package App\Models
 *
 * @property int $id
 * @property string title_en
 * @property string title_bn
 * @property string image
 * @property bool featured
 * @property int row_status
 * @property Carbon|null created_at
 * @property Carbon|null updated_at
 * @property int institute_id
 * @property-read Institute institute
 * @property-read Collection|Gallery galleries
 * @property-read RowStatus rowStatus
 */
class GalleryCategory extends BaseModel
{
    use HasFactory, ScopeRowStatusTrait, CreatedByUpdatedByRelationTrait;

    protected $guarded = ['id'];
    const DEFAULT_IMAGE = 'gallery-category/default.jpg';

    public function institute(): BelongsTo
    {
        return $this->belongsTo(Institute::class);
    }

    public function logoIsDefault(): bool
    {
        return $this->image === self::DEFAULT_IMAGE;
    }

    public function galleries(): HasMany
    {
        return $this->hasMany(Gallery::class);
    }

}
