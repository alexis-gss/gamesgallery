<?php

namespace App\Enums;

use Kwaadpepper\Enum\BaseEnumRoutable;

/**
 * @method static self up()
 * @method static self down()
 */
class ChangeOrder extends BaseEnumRoutable
{
    /**
     * @return array
     */
    protected static function values(): array
    {
        return [
            'up' => 'up',
            'down' => 'down'
        ];
    }
}
