<?php

namespace Module\GovtStakeholder\App\Policies;

use App\Models\User;
use Module\GovtStakeholder\App\Models\Rank;

class RankPolicy extends BasePolicy
{

    /**
     * Determine whether the user can view any models.
     *
     * @param User $user
     * @return mixed
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermission('view_any_rank');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param User $user
     * @param Rank $rank
     * @return mixed
     */
    public function view(User $user, Rank $rank)
    {
        return $user->hasPermission('view_single_rank');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param User $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermission('create_rank');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param User $user
     * @param Rank $rank
     * @return mixed
     */
    public function update(User $user, Rank $rank)
    {
        return $user->hasPermission('update_rank');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param User $user
     * @param Rank $rank
     * @return mixed
     */
    public function delete(User $user, Rank $rank)
    {
        return $user->hasPermission('delete_rank');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param User $user
     * @param Rank $rank
     * @return mixed
     */
    public function restore(User $user, Rank $rank)
    {
        return $user->hasPermission('restore_rank');
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param User $user
     * @param Rank $rank
     * @return mixed
     */
    public function forceDelete(User $user, Rank $rank)
    {
        return $user->hasPermission('force_delete_rank');
    }
}
