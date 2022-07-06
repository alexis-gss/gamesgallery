<?php

namespace App\Enums;

use Kwaadpepper\Enum\BaseEnumRoutable;

/**
 * @method static self visitor()
 * @method static self admin()
 */
class Role extends BaseEnumRoutable
{
    /**
     * @return array
     */
    protected static function values(): array
    {
        return [
            'visitor' => 0,
            'admin' => 1
        ];
    }

    /**
     * @return array
     */
    protected static function labels(): array
    {
        return [
            'visitor' => trans('Visitor'),
            'admin' => trans('Administrator')
        ];
    }
}
