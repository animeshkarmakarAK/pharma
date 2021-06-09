<?php

namespace Module\CourseManagement\App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Module\CourseManagement\App\Traits\ScopeAclTrait;

/**
 * Class Batch
 * @package App\Models
 */
class Batch extends Model
{
    use HasFactory, ScopeAclTrait;

    protected $guarded = ['id'];

    public function course(): BelongsTo
    {
        return $this->BelongsTo(Course::class);
    }

    public function institute(): BelongsTo
    {
        return $this->belongsTo(Institute::class);

    }
}
