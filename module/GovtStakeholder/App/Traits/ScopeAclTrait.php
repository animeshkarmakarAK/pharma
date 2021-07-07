<?php

namespace Module\GovtStakeholder\App\Traits;


use App\Helpers\Classes\AuthHelper;
use Illuminate\Database\Eloquent\Builder;

/**
 * Trait ScopeAclTrait
 * @package Module\GovtStakeholder\App\Traits
 */
trait ScopeAclTrait
{
    public function scopeAcl(Builder $query, string $alias = null, string $attribute = "organization_id"): Builder
    {
        if (empty($alias)) {
            $alias = $this->getTable() . '.';
        }

        if (AuthHelper::checkAuthUser()) {
            $authUser = AuthHelper::getAuthUser();
            if ($authUser->isOrganizationUser()) {
                $query->where($alias. $attribute, $authUser->organization_id);
            }
        }

        return $query;
    }
}
