<?php

namespace Module\CourseManagement\App\Policies;

use App\Models\User;
use Module\CourseManagement\App\Models\ApplicationFormType;

class ApplicationFormTypePolicy extends BasePolicy
{
    /**
     * Determine whether the user can view any models.
     *
     * @param User $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasPermission('view_any_application_form_type');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param User $user
     * @param ApplicationFormType $applicationFormType
     * @return mixed
     */
    public function view(User $user, ApplicationFormType $applicationFormType)
    {
        return $user->hasPermission('view_single_application_form_type');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param User $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermission('create_application_form_type');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param User $user
     * @param ApplicationFormType $applicationFormType
     * @return mixed
     */
    public function update(User $user, ApplicationFormType $applicationFormType)
    {
        return $user->hasPermission('update_application_form_type');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param User $user
     * @param ApplicationFormType $applicationFormType
     * @return mixed
     */
    public function delete(User $user, ApplicationFormType $applicationFormType)
    {
        return $user->hasPermission('delete_application_form_type');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param User $user
     * @param ApplicationFormType $applicationFormType
     * @return mixed
     */
    public function restore(User $user, ApplicationFormType $applicationFormType)
    {
        return $user->hasPermission('restore_application_form_type');
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param User $user
     * @param ApplicationFormType $applicationFormType
     * @return mixed
     */
    public function forceDelete(User $user, ApplicationFormType $applicationFormType)
    {
        return $user->hasPermission('force_delete_application_form_type');
    }
}
