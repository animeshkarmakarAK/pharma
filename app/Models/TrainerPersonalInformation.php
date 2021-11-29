<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Module\CourseManagement\App\Models\Institute;

/**
 * App\Models\TrainerPersonalInformation
 *
 * @property int id
 * @property int user_id
 * @property string name
 * @property string|null email
 * @property string|null profile_pic
 * @property int institute_id
 * @property-read User user
 * @property-read Institute institute
 *
 */

class TrainerPersonalInformation extends BaseModel
{
    protected $guarded = ['id'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
