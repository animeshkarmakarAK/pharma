<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy extends MasterBasePolicy
{
    /**
     * Determine whether the user can view any models.
     *
     * @param User $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasPermission('view_any_user');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param User $user
     * @param User $model
     * @return mixed
     */
    public function view(User $user, User $model)
    {
        return $user->id == $model->id || $user->hasPermission('view_single_user');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param User $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermission('create_user');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param User $user
     * @param User $model
     * @return mixed
     */
    public function update(User $user, User $model)
    {
        return $user->id == $model->id || $user->hasPermission('update_user');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param User $user
     * @param User $model
     * @return mixed
     */
    public function delete(User $user, User $model)
    {
        return $user->id != $model->id && $user->hasPermission('delete_user');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param User $user
     * @param User $model
     * @return mixed
     */
    public function restore(User $user, User $model)
    {
        return $user->id != $model->id && $user->hasPermission('restore_user');
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param User $user
     * @param User $model
     * @return mixed
     */
    public function forceDelete(User $user, User $model)
    {
        return $user->id != $model->id && $user->hasPermission('force_delete_user');
    }

    public function changePassword(User $user, User $model): bool
    {
        return $user->id == $model->id || $user->hasPermission('change_user_password');
    }

    public function viewUserPermission(User $user, User $model): bool
    {
        return $user->id == $model->id || $user->hasPermission('view_user_permission');
    }

    public function changeUserPermission(User $user, User $model): bool
    {
        return $this->viewUserPermission($user, $model) && $user->hasPermission('change_user_permission');
    }

    public function changeUserRole(User $user, User $model): bool
    {
        return $this->viewUserPermission($user, $model) && $user->hasPermission('change_user_role');
    }


    public function changeUserType(User $user, User $model): bool
    {
        return !($user->isDCUser() || $user->isInstituteUser() || $user->isOrganizationUser()) && !($user->id == $model->id);
    }
}
