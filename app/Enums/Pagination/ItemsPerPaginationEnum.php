<?php

namespace App\Enums\Pagination;

use App\Traits\Enums\BaseEnum;

enum ItemsPerPaginationEnum: int
{
    use BaseEnum;

    case five       = 5;
    case twelve     = 12;
    case twentytwo  = 25;
    case fifty      = 50;
    case onehundred = 100;
}
