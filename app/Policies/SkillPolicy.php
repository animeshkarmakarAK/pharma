<?php

namespace App\Policies;

use App\Models\Skill;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class SkillPolicy extends BasePolicy
{

    /**
     * Determine whether the user can view any models.
     *
     * @param \App\Models\User $user
     * @return mixed
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermission('view_any_skill');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Skill $skill
     * @return mixed
     */
    public function view(User $user, Skill $skill)
    {
        return $user->hasPermission('view_single_skill');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param \App\Models\User $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermission('create_skill');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Skill $skill
     * @return mixed
     */
    public function update(User $user, Skill $skill)
    {
        return $user->hasPermission('update_skill');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Skill $skill
     * @return mixed
     */
    public function delete(User $user, Skill $skill)
    {
        return $user->hasPermission('delete_skill');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Skill $skill
     * @return mixed
     */
    public function restore(User $user, Skill $skill)
    {
        return $user->hasPermission('restore_skill');
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Skill $skill
     * @return mixed
     */
    public function forceDelete(User $user, Skill $skill)
    {
        return $user->hasPermission('forse_delete_skill');
    }
}
