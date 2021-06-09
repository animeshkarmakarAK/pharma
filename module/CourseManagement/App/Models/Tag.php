<?php

namespace Module\CourseManagement\App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Tag extends BaseModel
{
    use HasFactory;
    protected $guarded = ['id'];


    public function taggable(): MorphTo
    {
        return $this->morphTo();
    }

}
