<?php

namespace Module\GovtStakeholder\App\Policies;

use App\Models\User;
use Module\GovtStakeholder\App\Models\OccupationWiseStatistic;

class OrganizationUnitStatisticPolicy extends BasePolicy
{

    /**
     * Determine whether the user can view any models.
     *
     * @param User $user
     * @return mixed
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermission('view_any_organization_unit_statistic');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param User $user
     * @param OccupationWiseStatistic $occupationWiseStatistic
     * @return mixed
     */
    public function view(User $user, OccupationWiseStatistic $occupationWiseStatistic)
    {
        return $user->hasPermission('view_single_organization_unit_statistic');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param User $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermission('create_organization_unit_statistic');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param User $user
     * @param OccupationWiseStatistic $occupationWiseStatistic
     * @return mixed
     */
    public function update(User $user, OccupationWiseStatistic $occupationWiseStatistic)
    {
        return $user->hasPermission('update_organization_unit_statistic');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param User $user
     * @param OccupationWiseStatistic $occupationWiseStatistic
     * @return mixed
     */
    public function delete(User $user, OccupationWiseStatistic $occupationWiseStatistic)
    {
        return $user->hasPermission('delete_organization_unit_statistic');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param User $user
     * @param OccupationWiseStatistic $occupationWiseStatistic
     * @return mixed
     */
    public function restore(User $user, OccupationWiseStatistic $occupationWiseStatistic)
    {
        return $user->hasPermission('restore_organization_unit_statistic');
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param User $user
     * @param OccupationWiseStatistic $occupationWiseStatistic
     * @return mixed
     */
    public function forceDelete(User $user, OccupationWiseStatistic $occupationWiseStatistic)
    {
        return $user->hasPermission('force_delete_organization_unit_statistic');
    }
}
