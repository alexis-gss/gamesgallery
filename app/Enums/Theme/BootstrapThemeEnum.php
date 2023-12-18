<?php

namespace App\Enums\Theme;

use App\Traits\Enums\BaseEnum;

enum BootstrapThemeEnum: int
{
    use BaseEnum;

    case light  = 1;
    case dark   = 2;
    case custom = 3;

    /**
     * Optionnal labels definition
     */
    private const LABELS = [
        self::light->name => 'enums.bootstrap-theme.light',
        self::dark->name  => 'enums.bootstrap-theme.dark',
        self::custom->name  => 'enums.bootstrap-theme.custom',
    ];
}
