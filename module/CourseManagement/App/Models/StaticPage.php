<?php

namespace Module\CourseManagement\App\Models;

use App\Traits\CreatedByUpdatedByRelationTrait;
use Module\CourseManagement\App\Traits\ScopeAclTrait;
use App\Traits\ScopeRowStatusTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class StaticPage
 * @package App\Models
 * @property int content_type
 * @property int institute_id
 * @property string title_en
 * @property string title_bn
 * @property string page_id
 * @property string page_contents
 */

class StaticPage extends BaseModel
{
    use HasFactory, scopeRowStatusTrait, CreatedByUpdatedByRelationTrait, ScopeAclTrait;

    const PAGE_ID_ABOUT_US = 'aboutus';

    protected $table = 'static_pages';
    protected $guarded = ['id'];

    public function title(): ?string
    {
        return $this->title_bn || $this->title_en;
    }


    public function institute(): BelongsTo
    {
        return $this->belongsTo(Institute::class);
    }
}
