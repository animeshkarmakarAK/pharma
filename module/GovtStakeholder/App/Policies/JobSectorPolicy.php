<?php

namespace Module\GovtStakeholder\App\Policies;

use App\Models\User;
use Module\GovtStakeholder\App\Models\JobSector;

class JobSectorPolicy extends BasePolicy
{
    /**
     * Determine whether the user can view any models.
     *
     * @param User $user
     * @return mixed
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermission('view_any_job_sector');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param User $user
     * @param JobSector $jobSector
     * @return mixed
     */
    public function view(User $user, JobSector $jobSector)
    {
        return $user->hasPermission('view_single_job_sector');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param User $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermission('create_job_sector');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param User $user
     * @param JobSector $jobSector
     * @return mixed
     */
    public function update(User $user, JobSector $jobSector)
    {
        return $user->hasPermission('update_job_sector');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param User $user
     * @param JobSector $jobSector
     * @return mixed
     */
    public function delete(User $user, JobSector $jobSector)
    {
        return $user->hasPermission('delete_job_sector');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param User $user
     * @param JobSector $jobSector
     * @return mixed
     */
    public function restore(User $user, JobSector $jobSector)
    {
        return $user->hasPermission('restore_job_sector');
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param User $user
     * @param JobSector $jobSector
     * @return mixed
     */
    public function forceDelete(User $user, JobSector $jobSector)
    {
        return $user->hasPermission('forse_delete_job_sector');
    }
}
