<?php

namespace Module\CourseManagement\App\Policies;

use Module\CourseManagement\App\Models\PublishCourse;
use App\Models\User;

class PublishCoursePolicy extends BasePolicy
{

    /**
     * Determine whether the user can view any models.
     *
     * @param User  $user
     * @return mixed
     */
    public function viewAny(User $user): bool
    {

        return $user->hasPermission('view_any_publish_course');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param User  $user
     * @param PublishCourse  $publishCourse
     * @return mixed
     */
    public function view(User $user, PublishCourse $publishCourse): bool
    {
        return $user->hasPermission('view_single_publish_course');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermission('create_publish_course');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param User  $user
     * @param PublishCourse $publishCourse
     * @return mixed
     */
    public function update(User $user, PublishCourse $publishCourse): bool
    {
        return $user->hasPermission('update_publish_course');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param User  $user
     * @param PublishCourse  $publishCourse
     * @return mixed
     */
    public function delete(User $user, PublishCourse $publishCourse)
    {
        return $user->hasPermission('delete_publish_course');

    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param User  $user
     * @param PublishCourse  $publishCourse
     * @return mixed
     */
    public function restore(User $user, PublishCourse $publishCourse)
    {
        return $user->hasPermission('restore_publish_courses');
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param User  $user
     * @param PublishCourse  $publishCourse
     * @return mixed
     */
    public function forceDelete(User $user, PublishCourse $publishCourse)
    {
        return $user->hasPermission('force_delete_publish_courses');
    }
}
