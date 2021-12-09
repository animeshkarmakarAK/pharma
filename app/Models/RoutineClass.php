<?php

namespace App\Models;

use App\Traits\CreatedByUpdatedByRelationTrait;
use App\Traits\ScopeRowStatusTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Traits\ScopeAclTrait;
use App\Models\User;

/**
 * Class RoutineClass
 * @package App\Models
 * @property string title_en
 * @property int Batch_id
 * @property string|null address
 * @property string|null google_map_src
 * @method static \Illuminate\Database\Eloquent\Builder|Batch acl()
 * @method static Builder|Batch active()
 * @method static Builder|Batch newModelQuery()
 * @method static Builder|Batch newQuery()
 * @method static Builder|Batch query()
 */

class RoutineClass extends BaseModel
{
    public $timestamps = true;
    protected $guarded = ['id'];


    public function routine(): BelongsTo
    {
        return $this->belongsTo(Routine::class, 'routine_id');
    }
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

}
