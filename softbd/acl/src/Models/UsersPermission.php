<?php

namespace Softbd\Acl\Models;

use App\Abstracts\ModelAbstracts\BaseModel;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * Softbd\Acl\Models\UsersPermission
 *
 * @property int $id
 * @property int $user_id
 * @property int $permission_id
 * @property bool $status
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Permission $permission
 * @method static Builder|UsersPermission newModelQuery()
 * @method static Builder|UsersPermission newQuery()
 * @method static Builder|UsersPermission query()
 */
class UsersPermission extends BaseModel
{
    public $timestamps = true;

    protected $table = 'users_permissions';
    protected $fillable = ['user_id', 'permission_id', 'status'];
    protected $casts = [
        'status' => 'boolean',
    ];

    public function permission(): BelongsTo
    {
        return $this->belongsTo(Permission::class,'permission_id','id');
    }
}
