<?php

namespace App\Enums\Theme;

use App\Traits\Enums\BaseEnum;

enum BootstrapThemeEnum: int
{
    use BaseEnum;

    case light = 1;
    case dark  = 2;

    /**
     * Optionnal labels definition
     */
    private const LABELS = [
        self::light->name => 'Light',
        self::dark->name  => 'Dark',
    ];
}
