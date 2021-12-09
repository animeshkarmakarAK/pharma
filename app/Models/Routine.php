<?php

namespace App\Models;

use App\Traits\ScopeRowStatusTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Traits\ScopeAclTrait;
use Illuminate\Support\Facades\Session;

/**
 * Class Routine
 * @package App\Models
 * @property int institute_id
 * @property int batch_id
 * @property int training_id
 * @property int created_by
 * @property int updated_by
 * @property int row_status
 * @property string day
 * @method static \Illuminate\Database\Eloquent\Builder|Batch acl()
 * @method static Builder|Batch active()
 * @method static Builder|Batch newModelQuery()
 * @method static Builder|Batch newQuery()
 * @method static Builder|Batch query()
 */

class Routine extends BaseModel
{
    use HasFactory, ScopeAclTrait, ScopeRowStatusTrait;

    public $timestamps = true;
    protected $guarded = ['id'];


    public function batch(): BelongsTo
    {
        return $this->belongsTo(Batch::class, 'batch_id');
    }
    public function trainingCenter(): BelongsTo
    {
        return $this->belongsTo(TrainingCenter::class, 'training_center_id');
    }

    public function routineClass(): HasMany
    {
        if (@Session::get('user_id')){
            return $this->hasMany(RoutineClass::class,'routine_id')->where('user_id',Session::get('user_id'));
        }else{
            return $this->hasMany(RoutineClass::class,'routine_id');
        }
    }
}
