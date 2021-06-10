<?php

namespace Module\GovtStakeholder\App\Policies;

use App\Models\User;
use Module\GovtStakeholder\App\Models\UpazilaJobStatistic;

class UpazilaJobStatisticPolicy extends BasePolicy
{

    /**
     * Determine whether the user can view any models.
     *
     * @param User $user
     * @return mixed
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermission('view_any_upazila_job_statistic');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param User $user
     * @param UpazilaJobStatistic $upazilaJobStatistic
     * @return mixed
     */
    public function view(User $user, UpazilaJobStatistic $upazilaJobStatistic)
    {
        return $user->hasPermission('view_single_upazila_job_statistic');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param User $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermission('create_upazila_job_statistic');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param User $user
     * @param UpazilaJobStatistic $upazilaJobStatistic
     * @return mixed
     */
    public function update(User $user, UpazilaJobStatistic $upazilaJobStatistic)
    {
        return $user->hasPermission('update_upazila_job_statistic');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param User $user
     * @param UpazilaJobStatistic $upazilaJobStatistic
     * @return mixed
     */
    public function delete(User $user, UpazilaJobStatistic $upazilaJobStatistic)
    {
        return $user->hasPermission('delete_upazila_job_statistic');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param User $user
     * @param UpazilaJobStatistic $upazilaJobStatistic
     * @return mixed
     */
    public function restore(User $user, UpazilaJobStatistic $upazilaJobStatistic)
    {
        return $user->hasPermission('restore_upazila_job_statistic');
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param User $user
     * @param UpazilaJobStatistic $upazilaJobStatistic
     * @return mixed
     */
    public function forceDelete(User $user, UpazilaJobStatistic $upazilaJobStatistic)
    {
        return $user->hasPermission('forse_delete_upazila_job_statistic');
    }
}
