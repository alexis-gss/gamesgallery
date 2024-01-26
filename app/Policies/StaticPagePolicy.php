<?php

namespace App\Policies;

use App\Enums\Users\RoleEnum;
use App\Models\User;
use App\Policies\Rules\UserStaticRules;

class StaticPagePolicy
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
     * @return boolean
     */
    public function view(User $authUser): bool
    {
        return UserStaticRules::atLeastRole($authUser, RoleEnum::conceptor);
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param \App\Models\User $authUser
     * @return boolean
     */
    public function update(User $authUser): bool
    {
        return UserStaticRules::atLeastRole($authUser, RoleEnum::conceptor);
    }

    /**
     * Determine whether the user can change the order model.
     *
     * @param \App\Models\User $authUser
     * @return boolean
     */
    public function changeOrder(User $authUser): bool
    {
        return UserStaticRules::atLeastRole($authUser, RoleEnum::admin);
    }
}
