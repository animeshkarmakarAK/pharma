<?php

namespace Module\CourseManagement\App\Models;

class YouthBatch extends BaseModel
{
    const ENROLLMENT_STATUS_PENDING = '0';
    const ENROLLMENT_STATUS_ENROLLED = '1';
    const ENROLLMENT_STATUS_REJECTED = '2';

    protected $guarded = ['id'];
}
