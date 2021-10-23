<?php

namespace Module\CourseManagement\App\Models;

/**
 * Class BaseModel
 * @package Module\CourseManagement\App\Models
 */
abstract class BaseModel extends \App\Models\BaseModel
{
    /** BIRTHDATE FORMAT  */
    public const BIRTHDATE_FORMAT = "Y-m-d";
    /** MOBILE REGEX  */
    public const MOBILE_REGEX = 'regex: /^(1[3-9]\d{8})$/';

}
