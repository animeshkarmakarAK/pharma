<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Traits\ScopeAclTrait;

/**
 * Class Batch
 * @package App\Models
 * @property string id
 * @property string publish_course_id
 * @property string youth_id
 * @property string certificate_path
 */

class CourseWiseYouthCertificate extends BaseModel
{
    use HasFactory, ScopeAclTrait;

    protected $guarded = ['id'];


}
