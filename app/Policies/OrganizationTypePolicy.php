<?php

namespace App\Policies;

use App\Models\OrganizationType;

class OrganizationTypePolicy extends BasePolicy
{
    /**
     * Determine whether the user can view any models.
     *
     * @param \App\Models\User $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasPermission('view_any_organization_type');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\OrganizationType $model
     * @return mixed
     */
    public function view(User $user)
    {
        return $user->hasPermission('view_organization_type');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param \App\Models\User $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermission('create_organization_type');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\OrganizationType $model
     * @return mixed
     */
    public function update(User $user)
    {
        return $user->hasPermission('update_organization_type');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\OrganizationType $model
     * @return mixed
     */
    public function delete(User $user)
    {
        return  $user->hasPermission('delete_organization_type');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\OrganizationType $model
     * @return mixed
     */
    public function restore(User $user)
    {
        return $user->hasPermission('restore_organization_type');
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\OrganizationType $model
     * @return mixed
     */
    public function forceDelete(User $user)
    {
        return $user->hasPermission('force_delete_organization_type');
    }
}
