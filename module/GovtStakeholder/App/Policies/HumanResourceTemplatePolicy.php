<?php

namespace Module\GovtStakeholder\App\Policies;

use App\Models\User;
use Module\GovtStakeholder\App\Models\HumanResourceTemplate;

class HumanResourceTemplatePolicy extends BasePolicy
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
     * @param HumanResourceTemplate $humanResourceTemplate
     * @return mixed
     */
    public function view(User $user, HumanResourceTemplate $humanResourceTemplate)
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
     * @param HumanResourceTemplate $humanResourceTemplate
     * @return mixed
     */
    public function update(User $user, HumanResourceTemplate $humanResourceTemplate)
    {
        return true;
        //        return $user->hasPermission('update_human_resource_templates');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param User $user
     * @param HumanResourceTemplate $humanResourceTemplate
     * @return mixed
     */
    public function delete(User $user, HumanResourceTemplate $humanResourceTemplate)
    {
        return true;
        //        return $user->hasPermission('delete_human_resource_templates');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param User $user
     * @param HumanResourceTemplate $humanResourceTemplate
     * @return mixed
     */
    public function restore(User $user, HumanResourceTemplate $humanResourceTemplate)
    {
        return true;
        //        return $user->hasPermission('restore_human_resource_templates');
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param User $user
     * @param HumanResourceTemplate $humanResourceTemplate
     * @return mixed
     */
    public function forceDelete(User $user, HumanResourceTemplate $humanResourceTemplate)
    {
        return true;
        //        return $user->hasPermission('force_delete_human_resource_templates');
    }
}
