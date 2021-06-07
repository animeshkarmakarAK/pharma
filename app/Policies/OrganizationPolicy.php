<?php

namespace App\Policies;

use App\Models\Organization;

class OrganizationPolicy extends BasePolicy
{
    /**
     * Determine whether the user can view any models.
     *
     * @param \App\Models\User $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasPermission('view_any_organization');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Organization $model
     * @return mixed
     */
    public function view(User $user, Organization $model)
    {
        return $user->hasPermission('view_organization');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param \App\Models\User $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermission('create_organization');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Organization $model
     * @return mixed
     */
    public function update(User $user, Organization $model)
    {
        return $user->hasPermission('update_organization');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Organization $model
     * @return mixed
     */
    public function delete(User $user, Organization $model)
    {
        return $user->hasPermission('delete_organization');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Organization $model
     * @return mixed
     */
    public function restore(User $user, Organization $model)
    {
        return $user->hasPermission('restore_organization');
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Organization $model
     * @return mixed
     */
    public function forceDelete(User $user, Organization $model)
    {
        return $user->hasPermission('force_delete_organization');
    }


}
