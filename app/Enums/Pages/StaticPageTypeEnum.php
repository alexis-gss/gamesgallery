<?php

namespace App\Enums\Pages;

use App\Traits\Enums\BaseEnum;

enum StaticPageTypeEnum: int
{
    use BaseEnum;

    case home    = 1;
    case ranking = 2;

    /**
     * Optionnal labels definition.
     *
     * @phpstan-ignore-next-line
     */
    private const LABELS = [
        self::home->name    => 'fo_homepage',
        self::ranking->name => 'fo_ranking',
    ];
}
