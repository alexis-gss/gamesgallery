<?php

namespace App\Traits;

use Kwaadpepper\Enum\Traits\CastsEnums;
use Spatie\Translatable\HasTranslations;

trait CastsEnumsHasTranslations
{
    use CastsEnums, HasTranslations {
        CastsEnums::getAttributeValue as enumGetAttributeValue;
        CastsEnums::setAttribute as enumSetAttribute;
        HasTranslations::getAttributeValue as transGetAttributeValue;
        HasTranslations::setAttribute as transSetAttribute;
    }

    /**
     * Manually mix getAttributeValue from CastsEnums and HasTranslations
     */
    public function getAttributeValue($key)
    {
        if ($this->hasEnumCast($key)) {
            return  $this->enumGetAttributeValue($key);
        }

        return $this->transGetAttributeValue($key);
    }

    /**
     * Manually mix setAttribute from CastsEnums and HasTranslations
     */
    public function setAttribute($key, $value)
    {
        if ($this->hasEnumCast($key)) {
            return $this->enumSetAttribute($key, $value);
        }

        return $this->transSetAttribute($key, $value);
    }
}
