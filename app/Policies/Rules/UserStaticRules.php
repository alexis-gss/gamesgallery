<?php

namespace App\Policies\Rules;

use App\Enums\Users\RoleEnum;
use App\Models\User;

/**
 * Userlevel Policy Static Rules.
 */
abstract class UserStaticRules
{
    /**
     * Allow everyone.
     *
     * @return boolean
     */
    public static function everyOne(): bool
    {
        return true;
    }

    /**
     * Allow no one.
     *
     * @return boolean
     */
    public static function noOne(): bool
    {
        return false;
    }

    /**
     * At least a minimum role.
     *
     * @param \App\Models\User          $user
     * @param \App\Enums\Users\RoleEnum $minRole
     * @return boolean
     */
    public static function atLeastRole(User $user, RoleEnum $minRole): bool
    {
        return $user->role->value() <= $minRole->value();
    }
}
