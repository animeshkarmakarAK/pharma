<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class RowStatus
 * @package App\Models
 * @property string title
 * @property string code
 */
class RowStatus extends Model
{
    use HasFactory;
    protected $table = "row_status";

    /*public function userType()
    {
        return $this->belongsTo(userType::class, 'row_status','code');
    }*/

}
