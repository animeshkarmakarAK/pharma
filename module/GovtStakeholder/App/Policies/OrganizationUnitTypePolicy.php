<?php

namespace Module\GovtStakeholder\App\Policies;

use App\Models\User;
use Module\GovtStakeholder\App\Models\OrganizationUnitType;

class OrganizationUnitTypePolicy extends BasePolicy
{
    public function viewAny(User $user): bool
    {
        return true;
//        return $organizationUnitType->hasPermission('view_any_organization_unit_type');
    }

    public function view(User $user, OrganizationUnitType $organizationUnitType): bool
    {
        return true;
//        return $user->hasPermission('view_any_organization_unit_types');
    }


    public function create(User $user): bool
    {
        return true;
//        return $user->hasPermission('create_organization_unit_types');
    }

    /**
     * @param User $user
     * @param OrganizationUnitType $organizationUnitType
     * @return bool
     */
    public function update(User $user, OrganizationUnitType $organizationUnitType): bool
    {
        return true;
//        return $user->hasPermission('update_organization_unit_type');
    }

    /**
     * @param User $user
     * @param OrganizationUnitType $organizationUnitType
     * @return bool
     */
    public function delete(User $user, OrganizationUnitType $organizationUnitType)
    {
        return true;
//        return $user->hasPermission('delete_organization_unit_type');
    }

    /**
     * @param User $user
     * @param OrganizationUnitType $organizationUnitType
     * @return bool
     */
    public function restore(User $user, OrganizationUnitType $organizationUnitType)
    {
        return true;
//        return $user->hasPermission('restore_organization_unit_type');

    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param User $user
     * @param OrganizationUnitType $organizationUnitType
     * @return mixed
     */
    public function forceDelete(User $user, OrganizationUnitType $organizationUnitType)
    {
        return true;
//        return $user->hasPermission('force_delete_organization_unit_type');
    }
}
