<?php

namespace Module\GovtStakeholder\App\Policies;

use App\Models\User;
use Module\GovtStakeholder\App\Models\OrganizationType;

class OrganizationTypePolicy extends BasePolicy
{
    /**
     * Determine whether the user can view any models.
     *
     * @param User $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasPermission('view_any_organization_type');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param User $user
     * @param OrganizationType $model
     * @return mixed
     */
    public function view(User $user, OrganizationType $model)
    {
        return $user->hasPermission('view_organization_type');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param User $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermission('create_organization_type');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param User $user
     * @param OrganizationType $model
     * @return mixed
     */
    public function update(User $user, OrganizationType $model)
    {
        return $user->hasPermission('update_organization_type');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param User $user
     * @param OrganizationType $model
     * @return mixed
     */
    public function delete(User $user, OrganizationType $model)
    {
        return  $user->hasPermission('delete_organization_type');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param User $user
     * @param OrganizationType $model
     * @return mixed
     */
    public function restore(User $user, OrganizationType $model)
    {
        return $user->hasPermission('restore_organization_type');
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param User $user
     * @param OrganizationType $model
     * @return mixed
     */
    public function forceDelete(User $user, OrganizationType $model)
    {
        return $user->hasPermission('force_delete_organization_type');
    }
}
