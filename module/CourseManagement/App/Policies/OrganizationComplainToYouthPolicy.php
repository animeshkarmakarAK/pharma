<?php

namespace Module\CourseManagement\App\Policies;

use Module\CourseManagement\App\Models\OrganizationComplainToYouth;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class OrganizationComplainToYouthPolicy extends BasePolicy
{

    /**
     * Determine whether the user can view any models.
     *
     * @param User  $user
     * @return mixed
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermission('view_any_organization_complain_to_youth');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param User  $user
     * @param OrganizationComplainToYouth $organizationComplainToYouth
     * @return mixed
     */
    public function view(User $user, OrganizationComplainToYouth $organizationComplainToYouth)
    {
        return $user->hasPermission('view_single_organization_complain_to_youth');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermission('create_organization_complain_to_youth');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param User  $user
     * @param OrganizationComplainToYouth $organizationComplainToYouth
     * @return mixed
     */
    public function update(User $user, OrganizationComplainToYouth $organizationComplainToYouth)
    {
        return $user->hasPermission('update_organization_complain_to_youth');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param User  $user
     * @param OrganizationComplainToYouth $organizationComplainToYouth
     * @return mixed
     */
    public function delete(User $user, OrganizationComplainToYouth $organizationComplainToYouth)
    {
        return $user->hasPermission('delete_organization_complain_to_youth');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param User  $user
     * @param OrganizationComplainToYouth $organizationComplainToYouth
     * @return mixed
     */
    public function restore(User $user, OrganizationComplainToYouth $organizationComplainToYouth)
    {
        return $user->hasPermission('restore_organization_complain_to_youth');
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param User  $user
     * @param OrganizationComplainToYouth $organizationComplainToYouth
     * @return mixed
     */
    public function forceDelete(User $user, OrganizationComplainToYouth $organizationComplainToYouth)
    {
        return $user->hasPermission('forse_delete_organization_complain_to_youth');
    }
}
