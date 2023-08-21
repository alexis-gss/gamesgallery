<?php

namespace App\Enums\Users;

use App\Traits\Enums\BaseEnum;

enum RoleEnum: int
{
    use BaseEnum;

    case admin   = 1;
    case visitor = 99;

    /**
     * Optionnal labels definition
     */
    private const LABELS = [
        self::admin->name => 'Administrator',
        self::visitor->name => 'Visitor',
    ];
}
