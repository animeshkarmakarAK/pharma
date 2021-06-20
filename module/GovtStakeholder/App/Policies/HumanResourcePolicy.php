<?php

namespace Module\GovtStakeholder\App\Policies;

use App\Models\User;
use Module\GovtStakeholder\App\Models\HumanResource;

class HumanResourcePolicy extends BasePolicy
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
        //        return $user->hasPermission('view_any_human_resource_templates');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param User $user
     * @param HumanResource $humanResource
     * @return mixed
     */
    public function view(User $user, HumanResource $humanResource)
    {
        return true;
        //        return $user->hasPermission('view_human_resource_templates');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param User $user
     * @return mixed
     */
    public function create(User $user)
    {
        return true;
        //        return $user->hasPermission('create_human_resource_templates');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param User $user
     * @param HumanResource $humanResource
     * @return mixed
     */
    public function update(User $user, HumanResource $humanResource)
    {
        return true;
        //        return $user->hasPermission('update_human_resource_templates');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param User $user
     * @param HumanResource $humanResource
     * @return mixed
     */
    public function delete(User $user, HumanResource $humanResource)
    {
        return true;
        //        return $user->hasPermission('delete_human_resource_templates');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param User $user
     * @param HumanResource $humanResource
     * @return mixed
     */
    public function restore(User $user, HumanResource $humanResource)
    {
        return true;
        //        return $user->hasPermission('restore_human_resource_templates');
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param User $user
     * @param HumanResource $humanResource
     * @return mixed
     */
    public function forceDelete(User $user, HumanResource $humanResource)
    {
        return true;
        //        return $user->hasPermission('force_delete_human_resource_templates');
    }
}
