<?php

namespace App\Models;

use App\Traits\CreatedByUpdatedByRelationTrait;
use App\Traits\ScopeRowStatusTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Traits\ScopeAclTrait;

/**
 * Class ExaminationType
 * @package App\Models
 * @property int institute_id
 * @property string|null title_en
 * @property int row_status
 * @method static \Illuminate\Database\Eloquent\Builder|Institute acl()
 * @method static Builder|Institute active()
 * @method static Builder|Institute newModelQuery()
 * @method static Builder|Institute newQuery()
 * @method static Builder|Institute query()
 */

class ExaminationType extends BaseModel
{
    use ScopeRowStatusTrait, ScopeAclTrait;

    public $timestamps = true;
    protected $guarded = ['id'];

    public function examination(): HasMany
    {
        return $this->hasMany(Examination::class, 'examination_type_id');
    }
}
