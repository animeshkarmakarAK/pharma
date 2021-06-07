<?php

namespace Softbd\Acl\Models;


use App\Abstracts\ModelAbstracts\BaseModel;


/**
 * Softbd\Acl\Models\RolePermission
 *
 * @property int $permission_id
 * @property int $role_id
 */
class RolePermission extends BaseModel
{
    protected $table = 'permission_role';

}
