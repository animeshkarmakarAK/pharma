<?php

namespace Softbd\Acl\Models;

use App\Abstracts\ModelAbstracts\BaseModel;
use App\Models\RowStatus;
use App\Traits\ModelTraits\ScopeRowStatusTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * Class UserType
 * @package Softbd\Acl\Models\UserType
 * @property string title
 * @property string code
 * @property int row_status
 * @method static Builder|UserType active()
 */
class UserType extends BaseModel
{
    use HasFactory, ScopeRowStatusTrait;

    protected $guarded = ['id'];
    public $timestamps = false;

    const USER_TYPE_SUPER_USER_CODE = '1';
    const USER_TYPE_SYSTEM_USER_CODE = '2';
    const USER_TYPE_INSTITUTE_USER_CODE = '3';
    const USER_TYPE_ORGANIZATION_USER_CODE = '4';

    public function rowStatus(): HasOne
    {
        return $this->hasOne(RowStatus::class, 'code', 'row_status');
    }

    public function roles(): HasOne
    {
        return $this->hasOne(Role::class, 'id', 'default_role_id');

    }
}


