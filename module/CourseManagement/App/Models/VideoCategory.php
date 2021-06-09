<?php

namespace Module\CourseManagement\App\Models;


use Module\CourseManagement\App\Traits\ScopeAclTrait;
use App\Traits\ScopeRowStatusTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class VideoCategory
 * @package App\Models
 * @property int institute_id
 * @property int|null parent_id
 * @property string title_en
 * @property string title_bn
 */

class VideoCategory extends BaseModel
{
    use HasFactory, ScopeRowStatusTrait, ScopeAclTrait;
    protected $guarded = ['id'];

    public function institute(): BelongsTo
    {
        return $this->belongsTo(Institute::class);
    }
}
