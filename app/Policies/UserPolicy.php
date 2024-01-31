<?php

namespace App\Policies;

use App\Enums\Users\RoleEnum;
use App\Models\User;
use App\Policies\Rules\UserStaticRules;

class UserPolicy
{
    /**
     * Determine whether the user can view any models.
     *
     * @param \App\Models\User $authUser
     * @return boolean
     */
    public function viewAny(User $authUser): bool
    {
        return UserStaticRules::atLeastRole($authUser, RoleEnum::conceptor);
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param \App\Models\User $authUser
     * @param \App\Models\User $user
     * @return boolean
     */
    public function view(User $authUser, User $user): bool
    {
        return UserStaticRules::atLeastRole($authUser, RoleEnum::conceptor) and
            UserStaticRules::atLeastRole($authUser, $user->role);
    }

    /**
     * Determine whether the user can create a new model.
     *
     * @param \App\Models\User $authUser
     * @return boolean
     */
    public function create(User $authUser): bool
    {
        return UserStaticRules::atLeastRole($authUser, RoleEnum::conceptor);
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param \App\Models\User $authUser
     * @param \App\Models\User $user
     * @return boolean
     */
    public function update(User $authUser, User $user): bool
    {
        return $authUser->getRouteKey() === $user->getRouteKey() or
            (UserStaticRules::atLeastRole($authUser, RoleEnum::conceptor) and
                UserStaticRules::atLeastRole($authUser, $user->role));
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param \App\Models\User $authUser
     * @param \App\Models\User $user
     * @return boolean
     */
    public function delete(User $authUser, User $user): bool
    {
        return $authUser->getRouteKey() !== $user->getRouteKey() and
            UserStaticRules::atLeastRole($authUser, RoleEnum::conceptor) and
            UserStaticRules::atLeastRole($authUser, $user->role);
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param \App\Models\User $authUser
     * @param \App\Models\User $user
     * @return boolean
     */
    public function restore(User $authUser, User $user): bool
    {
        return $authUser->getRouteKey() !== $user->getRouteKey() and
            UserStaticRules::atLeastRole($authUser, RoleEnum::conceptor) and
            UserStaticRules::atLeastRole($authUser, $user->role);
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param \App\Models\User $authUser
     * @param \App\Models\User $user
     * @return boolean
     */
    public function forceDelete(User $authUser, User $user): bool
    {
        return $authUser->getRouteKey() !== $user->getRouteKey() and
            UserStaticRules::atLeastRole($authUser, RoleEnum::conceptor) and
            UserStaticRules::atLeastRole($authUser, $user->role);
    }

    /**
     * Determine whether the user can duplicate the model.
     *
     * @param \App\Models\User $authUser
     * @param \App\Models\User $user
     * @return boolean
     */
    public function duplicate(User $authUser, User $user): bool
    {
        return $authUser->getRouteKey() !== $user->getRouteKey() and
            UserStaticRules::atLeastRole($authUser, RoleEnum::conceptor) and
            UserStaticRules::atLeastRole($authUser, $user->role);
    }

    /**
     * Determine whether the user can change the order model.
     *
     * @param \App\Models\User $authUser
     * @param \App\Models\User $user
     * @return boolean
     */
    public function changeOrder(User $authUser, User $user): bool
    {
        return $authUser->getRouteKey() !== $user->getRouteKey() and
            UserStaticRules::atLeastRole($authUser, RoleEnum::conceptor) and
            UserStaticRules::atLeastRole($authUser, $user->role);
    }

    /**
     * Determine whether the user can publish/unpublish the model.
     *
     * @param \App\Models\User $authUser
     * @param \App\Models\User $user
     * @return boolean
     */
    public function changePublished(User $authUser, User $user): bool
    {
        return $authUser->getRouteKey() !== $user->getRouteKey() and
            UserStaticRules::atLeastRole($authUser, RoleEnum::conceptor) and
            UserStaticRules::atLeastRole($authUser, $user->role);
    }

    /**
     * Determine whether the user can send a email to the user for reset his password.
     *
     * @param \App\Models\User $authUser
     * @param \App\Models\User $user
     * @return boolean
     */
    public function resetPassword(User $authUser, User $user): bool
    {
        return $authUser->getRouteKey() !== $user->getRouteKey() and
            UserStaticRules::atLeastRole($authUser, RoleEnum::admin);
    }
}
