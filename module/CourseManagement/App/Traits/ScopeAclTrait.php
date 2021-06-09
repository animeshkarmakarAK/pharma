<?php

namespace Module\CourseManagement\App\Traits;


use Illuminate\Database\Eloquent\Builder;

/**
 * Trait ScopeInstituteAclTrait
 * @package Module\CourseManagement\App\Traits
 */
trait ScopeAclTrait
{
    public function scopeAcl(Builder $query, string $alias = null): Builder
    {
        return $query;
    }
}
