<?php

namespace Module\CourseManagement\App\Models;

use Module\CourseManagement\App\Traits\ScopeAclTrait;
use App\Traits\ScopeRowStatusTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class Slider
 * @package App\Models
 * @property int institute_id
 * @property string title
 * @property string sub_title
 * @property string description
 * @property string link
 * @property int is_button_available
 * @property string button_text
 * @property string slider
 */
class Slider extends BaseModel
{
    use HasFactory, ScopeRowStatusTrait, ScopeAclTrait;

    protected $guarded = ['id'];

    const SLIDER_PIC_FOLDER_NAME = 'sliders';

    public const IS_BUTTON_AVAILABLE_YES = 1;
    public const IS_BUTTON_AVAILABLE_NO = 0;


    public function institute(): BelongsTo
    {
        return $this->belongsTo(Institute::class);
    }

}
