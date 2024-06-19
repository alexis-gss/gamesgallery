<?php

namespace App\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;

/**
 * Custom cast Html Color
 */
class HtmlColor implements CastsAttributes
{
    /**
     * Cast the given value.
     *
     * @param \Illuminate\Database\Eloquent\Model $model
     * @param string                              $key
     * @param mixed                               $value
     * @param array                               $attributes
     * @return string
     * @phpcs:disable
     */
    public function get(Model $model, string $key, mixed $value, array $attributes): string
    {
        //phpcs:enable
        return "#" . $this->zeropad(dechex($value), 6);
    }

    /**
     * Prepare the given value for storage.
     *
     * @param \Illuminate\Database\Eloquent\Model $model
     * @param string                              $key
     * @param mixed                               $value
     * @param array                               $attributes
     * @return integer
     * @phpcs:disable
     */
    public function set(Model $model, string $key, mixed $value, array $attributes): int
    {
        //phpcs:enable
        return \intval(hexdec(ltrim($value, '#')));
    }

    /**
     * Pad with zeros a numeric string
     *
     * @param string  $num
     * @param integer $lim
     * @return string
     */
    protected function zeropad(string $num, int $lim): string
    {
        return (strlen($num) >= $lim) ? $num : $this->zeropad("0" . $num, $lim);
    }
}
