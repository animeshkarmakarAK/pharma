<?php

namespace Module\CourseManagement\App\Policies;

use Module\CourseManagement\App\Models\YouthComplainToOrganization;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class YouthComplainToOrganizationPolicy extends BasePolicy
{

    /**
     * Determine whether the user can view any models.
     *
     * @param User  $user
     * @return mixed
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermission('view_any_youth_complain_to_organization');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param User  $user
     * @param YouthComplainToOrganization $youthComplainToOrganization
     * @return mixed
     */
    public function view(User $user, YouthComplainToOrganization $youthComplainToOrganization)
    {
        return $user->hasPermission('view_single_youth_complain_to_organization');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermission('create_youth_complain_to_organization');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param User  $user
     * @param YouthComplainToOrganization $youthComplainToOrganization
     * @return mixed
     */
    public function update(User $user, YouthComplainToOrganization $youthComplainToOrganization)
    {
        return $user->hasPermission('update_youth_complain_to_organization');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param User  $user
     * @param YouthComplainToOrganization $youthComplainToOrganization
     * @return mixed
     */
    public function delete(User $user, YouthComplainToOrganization $youthComplainToOrganization)
    {
        return $user->hasPermission('delete_youth_complain_to_organization');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param User  $user
     * @param YouthComplainToOrganization $youthComplainToOrganization
     * @return mixed
     */
    public function restore(User $user, YouthComplainToOrganization $youthComplainToOrganization)
    {
        return $user->hasPermission('restore_youth_complain_to_organization');
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param User  $user
     * @param YouthComplainToOrganization $youthComplainToOrganization
     * @return mixed
     */
    public function forceDelete(User $user, YouthComplainToOrganization $youthComplainToOrganization)
    {
        return $user->hasPermission('forse_delete_youth_complain_to_organization');
    }
}
