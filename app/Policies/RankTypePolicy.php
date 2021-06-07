<?php

namespace App\Policies;

use App\Models\RankType;
use Softbd\Acl\Models\User;

class RankTypePolicy extends BasePolicy
{

    /**
     * Determine whether the user can view any models.
     *
     * @param User $user
     * @return mixed
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermission('view_any_rank_type');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param User $user
     * @param RankType $rankType
     * @return mixed
     */
    public function view(User $user, RankType $rankType)
    {
        return $user->hasPermission('view_single_rank_type');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param User $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermission('create_rank_type');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param User $user
     * @param RankType $rankType
     * @return mixed
     */
    public function update(User $user, RankType $rankType)
    {
        return $user->hasPermission('update_rank_type');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param User $user
     * @param RankType $rankType
     * @return mixed
     */
    public function delete(User $user, RankType $rankType)
    {
        return $user->hasPermission('delete_rank_type');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param User $user
     * @param RankType $rankType
     * @return mixed
     */
    public function restore(User $user, RankType $rankType)
    {
        return $user->hasPermission('restore_rank_type');
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param User $user
     * @param RankType $rankType
     * @return mixed
     */
    public function forceDelete(User $user, RankType $rankType)
    {
        return $user->hasPermission('force_delete_rank_type');
    }
}
