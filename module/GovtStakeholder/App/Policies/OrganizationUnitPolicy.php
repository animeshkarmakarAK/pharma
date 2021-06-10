<?php

namespace Module\GovtStakeholder\App\Policies;
use App\Models\User;
use Module\GovtStakeholder\App\Models\OrganizationUnit;

class OrganizationUnitPolicy extends BasePolicy
{

    /**
     * Determine whether the user can view any models.
     *
     * @param User $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return true;
        //return $organizationUnitType->hasPermission('view_any_organization_units');

    }

    /**
     * Determine whether the user can view the model.
     *
     * @param User $user
     * @param OrganizationUnit $organizationUnit
     * @return mixed
     */
    public function view(User $user, OrganizationUnit $organizationUnit)
    {
        return true;
        //        return $user->hasPermission('view_organization_units');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param User $user
     * @return bool
     */
    public function create(User $user): bool
    {
        return true;
        //        return $user->hasPermission('create_organization_units');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param User $user
     * @param OrganizationUnit $organizationUnit
     * @return mixed
     */
    public function update(User $user, OrganizationUnit $organizationUnit)
    {
        return true;
        //        return $user->hasPermission('update_organization_units');

    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param User $user
     * @param OrganizationUnit $organizationUnit
     * @return mixed
     */
    public function delete(User $user, OrganizationUnit $organizationUnit)
    {
        return true;
        //        return $user->hasPermission('delete_organization_units');

    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param User $user
     * @param OrganizationUnit $organizationUnit
     * @return mixed
     */
    public function restore(User $user, OrganizationUnit $organizationUnit)
    {
        return true;
        //        return $user->hasPermission('restore_organization_units');
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param User $user
     * @param OrganizationUnit $organizationUnit
     * @return mixed
     */
    public function forceDelete(User $user, OrganizationUnit $organizationUnit)
    {
        return true;
        //        return $user->hasPermission('force_delete_organization_units');
    }
}
