<?php

namespace App\Policies;

use App\Models\Service;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ServicePolicy extends BasePolicy
{

    /**
     * Determine whether the user can view any models.
     *
     * @param \App\Models\User $user
     * @return mixed
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermission('view_any_service');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Service $service
     * @return mixed
     */
    public function view(User $user, Service $service)
    {
        return $user->hasPermission('view_single_service');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param \App\Models\User $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermission('create_service');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Service $service
     * @return mixed
     */
    public function update(User $user, Service $service)
    {
        return $user->hasPermission('update_service');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Service $service
     * @return mixed
     */
    public function delete(User $user, Service $service)
    {
        return $user->hasPermission('delete_service');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Service $service
     * @return mixed
     */
    public function restore(User $user, Service $service)
    {
        return $user->hasPermission('restore_service');
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Service $service
     * @return mixed
     */
    public function forceDelete(User $user, Service $service)
    {
        return $user->hasPermission('forse_delete_service');
    }
}
