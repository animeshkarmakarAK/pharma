<?php

namespace Module\GovtStakeholder\App\Policies;

use App\Models\User;
use Module\GovtStakeholder\App\Models\Skill;

class SkillPolicy extends BasePolicy
{

    /**
     * Determine whether the user can view any models.
     *
     * @param User $user
     * @return mixed
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermission('view_any_skill');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param User $user
     * @param Skill $skill
     * @return mixed
     */
    public function view(User $user, Skill $skill)
    {
        return $user->hasPermission('view_single_skill');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param User $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermission('create_skill');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param User $user
     * @param Skill $skill
     * @return mixed
     */
    public function update(User $user, Skill $skill)
    {
        return $user->hasPermission('update_skill');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param User $user
     * @param Skill $skill
     * @return mixed
     */
    public function delete(User $user, Skill $skill)
    {
        return $user->hasPermission('delete_skill');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param User $user
     * @param Skill $skill
     * @return mixed
     */
    public function restore(User $user, Skill $skill)
    {
        return $user->hasPermission('restore_skill');
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param User $user
     * @param Skill $skill
     * @return mixed
     */
    public function forceDelete(User $user, Skill $skill)
    {
        return $user->hasPermission('forse_delete_skill');
    }
}
