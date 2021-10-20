<?php

namespace Module\CourseManagement\App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Module\CourseManagement\App\Traits\ScopeAclTrait;

/**
 * Class Batch
 * @package Module\CourseManagement\App\Models
 * @property string id
 * @property string publish_course_id
 * @property string youth_id
 * @property string certificate_path
 */

class CourseWiseYouthCertificate extends BaseModel
{
    use HasFactory, ScopeAclTrait;

    protected $guarded = ['id'];

    public const CERTIFICATE_ROOT_PATH="youth-certificates/";

    public static function getCertificatePath($path):string
    {
        return self::CERTIFICATE_ROOT_PATH.date('Y/F/').$path;
    }

}
