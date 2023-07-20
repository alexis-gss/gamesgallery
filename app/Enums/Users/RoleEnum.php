<?php

namespace App\Enums\Users;

use Kwaadpepper\Enum\BaseEnumRoutable;

/**
 * @method static self admin()
 * @method static self visitor()
 */
class RoleEnum extends BaseEnumRoutable
{
    /**
     * @return array
     */
    protected static function values(): array
    {
        return [
            'admin' => 0,
            'visitor' => 99,
        ];
    }

    /**
     * @return array
     */
    protected static function labels(): array
    {
        return [
            'admin' => trans('Administrator'),
            'visitor' => trans('Visitor'),
        ];
    }
}
