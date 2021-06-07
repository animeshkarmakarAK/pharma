<?php

namespace App\Models;

use App\Abstracts\ModelAbstracts\BaseModel;
use App\Helpers\Classes\AuthHelper;
use App\Traits\ModelTraits\ScopeRowStatusTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * Class Skill
 * @package App\Models
 * @property int|null organization_id
 * @property string title_en
 * @property string title_bn
 * @property int | nuull description
 * @property Carbon|null created_at
 * @property Carbon|null updated_at
 * @property-read Organization organization
 * @method static Builder|Skill acl()
 */

class Skill extends BaseModel
{
    use HasFactory, ScopeRowStatusTrait;

    protected $guarded = ['id'];

    public function scopeAcl(Builder $query, string $alias = null): Builder
    {
        if (empty($alias)) {
            $alias = $this->getTable() . '.';
        }

        if (AuthHelper::checkAuthUser()) {
            $authUser = AuthHelper::getAuthUser();
            if ($authUser->isInstituteUser()) {
                $query->where($alias . 'institute_id', $authUser->institute_id);
            }
        }

        return $query;
    }

    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class);
    }
}
