<?php

namespace Module\GovtStakeholder\App\Policies;

use App\Models\User;
use Module\GovtStakeholder\App\Models\Service;

class ServicePolicy extends BasePolicy
{

    /**
     * Determine whether the user can view any models.
     *
     * @param User $user
     * @return mixed
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermission('view_any_service');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param User $user
     * @param Service $service
     * @return mixed
     */
    public function view(User $user, Service $service)
    {
        return $user->hasPermission('view_single_service');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param User $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermission('create_service');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param User $user
     * @param Service $service
     * @return mixed
     */
    public function update(User $user, Service $service)
    {
        return $user->hasPermission('update_service');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param User $user
     * @param Service $service
     * @return mixed
     */
    public function delete(User $user, Service $service)
    {
        return $user->hasPermission('delete_service');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param User $user
     * @param Service $service
     * @return mixed
     */
    public function restore(User $user, Service $service)
    {
        return $user->hasPermission('restore_service');
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param User $user
     * @param Service $service
     * @return mixed
     */
    public function forceDelete(User $user, Service $service)
    {
        return $user->hasPermission('force_delete_service');
    }
}
