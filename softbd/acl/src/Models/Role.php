<?php

namespace Softbd\Acl\Models;

use App\Abstracts\ModelAbstracts\BaseModel;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;


/**
 * Softbd\Acl\Models\Role
 *
 * @property int $id
 * @property string code
 * @property string title_en
 * @property string title_bn
 * @property string description
 * @property Carbon|null created_at
 * @property Carbon|null updated_at
 * @property-read Collection|Permission[] permissions
 * @property-read int|null permissions_count
 */
class Role extends BaseModel
{
    protected $guarded = [];

    public function users(): Builder
    {
        $userModel = User::class;

        return $this->belongsToMany($userModel, 'user_roles')
            ->select(app($userModel)->getTable() . '.*')
            ->union($this->hasMany($userModel))->getQuery();
    }

    public function permissions(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Permission::class);
    }
}
