<?php

namespace Module\CourseManagement\App\Traits;


use App\Helpers\Classes\AuthHelper;
use Illuminate\Database\Eloquent\Builder;

/**
 * Trait ScopeInstituteAclTrait
 * @package Module\CourseManagement\App\Traits
 */
trait ScopeAclTrait
{
    public function scopeAcl(Builder $query, string $alias = null, string $column = 'institute_id'): Builder
    {
        if (empty($alias)) {
            $alias = $this->getTable() . '.';
        }

        if (AuthHelper::checkAuthUser()) {
            $authUser = AuthHelper::getAuthUser();
            if ($authUser->isInstituteUser()) {
                $query->where($alias. $column, $authUser->institute_id);
            }
        }
        return $query;
    }
}
