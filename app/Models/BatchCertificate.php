<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class Batch
 * @package App\Models
 * @property string id
 * @property int batch_id
 * @property int authorized_by
 * @property int created_by
 * @property string tamplate
 * @property string signature
 * @property carbon issued_date
 */

class BatchCertificate extends BaseModel
{
    use HasFactory;

    protected $guarded = ['id'];
}
