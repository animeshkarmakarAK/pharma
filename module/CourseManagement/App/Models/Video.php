<?php

namespace Module\CourseManagement\App\Models;


use Module\CourseManagement\App\Traits\ScopeAclTrait;
use App\Traits\ScopeRowStatusTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;

/**
 * Class Video
 * @package App\Models
 * @property int institute_id
 * @property int video_category_id
 * @property string title_en
 * @property string title_bn
 * @property string|null description
 * @property int video_type 1 => youtube video 2 => uploaded video
 * @property string|null youtube_video_id
 * @property string|null youtube_video_url
 * @property string|null uploaded_video_path
 */
class Video extends BaseModel
{
    use HasFactory, ScopeRowStatusTrait, ScopeAclTrait;

    protected $guarded = ['id'];

    const VIDEO_TYPE_YOUTUBE_VIDEO = 1;
    const VIDEO_TYPE_UPLOADED_VIDEO = 2;

    public const VIDEO_FOLDER_NAME = 'skill-videos';

    public static function getVideoTypesArray(): array
    {
        return [
            self::VIDEO_TYPE_YOUTUBE_VIDEO => __('Youtube Video'),
            self::VIDEO_TYPE_UPLOADED_VIDEO => __('Uploaded Video'),
        ];
    }
    public function institute(): belongsTo
    {
        return $this->belongsTo(Institute::class);
    }

    public function videoCategory(): belongsTo
    {
        return $this->belongsTo(VideoCategory::class);
    }

    public function tags(): MorphMany
    {
        return $this->morphMany(Tag::class, 'taggable');
    }

}
