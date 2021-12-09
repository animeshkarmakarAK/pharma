<?php

namespace App\Traits;

use App\Helpers\Classes\AuthHelper;
use Illuminate\Database\Eloquent\Builder;

/**
 * Trait ScopeInstituteAclTrait
 * @package App\Traits\ModelTraits
 * @method static Builder|$this acl()
 */
trait ScopeAclMasterTrait
{
    /**
     * @param Builder $query
     * @param string|null $alias
     * @return Builder
     */
    public function scopeAcl(Builder $query, string $alias = null): Builder
    {
        if (empty($alias)) {
            $alias = $this->getTable() . '.';
        }

        if (AuthHelper::checkAuthUser()) {
            $authUser = AuthHelper::getAuthUser();
            if ($authUser->isInstituteUser()) {
                $query->where($alias. 'institute_id', $authUser->institute_id);
            }
        }

        return $query;
    }
}
