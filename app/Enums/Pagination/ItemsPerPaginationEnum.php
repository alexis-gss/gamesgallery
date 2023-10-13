<?php

namespace App\Enums\Pagination;

use Kwaadpepper\Enum\BaseEnumRoutable;

/**
 * @method static self five()
 * @method static self twelve()
 * @method static self twentytwo()
 * @method static self fifty()
 * @method static self onehundred()
 */
class ItemsPerPaginationEnum extends BaseEnumRoutable
{
    /**
     * @return array
     */
    protected static function values(): array
    {
        return [
            'five' => 5,
            'twelve' => 12,
            'twentytwo' => 25,
            'fifty' => 50,
            'onehundred' => 100,
        ];
    }
}
