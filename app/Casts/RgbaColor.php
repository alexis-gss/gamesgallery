<?php

namespace App\Casts;

use Illuminate\Database\Eloquent\Model;

/**
 * Custom cast RGBA Color
 */
class RgbaColor extends HtmlColor
{
    /**
     * Cast the given value.
     *
     * @param \Illuminate\Database\Eloquent\Model $model
     * @param string                              $key
     * @param mixed                               $value
     * @param array                               $attributes
     * @return string
     * @phpcs:disable Generic.CodeAnalysis.UnusedFunctionParameter.FoundInExtendedClassBeforeLastUsed, Generic.CodeAnalysis.UnusedFunctionParameter.FoundInExtendedClassAfterLastUsed
     */
    public function get(Model $model, string $key, mixed $value, array $attributes): string
    {
        // @phpcs:enable
        $intValues = collect(\str_split($this->zeropad(\dechex(\intval($value)), 8), 2))->map(function ($hex) {
            return intval(\hexdec($hex));
        });
        // * Set Transparency as float
        // @phpstan-ignore-next-line
        $hexString = $intValues->push(\round($intValues->pop() / 100, 2))->implode(',');
        return "rgba($hexString)";
    }

    /**
     * Prepare the given value for storage.
     *
     * @param \Illuminate\Database\Eloquent\Model $model
     * @param string                              $key
     * @param mixed                               $value
     * @param array                               $attributes
     * @return integer
     * @phpcs:disable Generic.CodeAnalysis.UnusedFunctionParameter.FoundInExtendedClassBeforeLastUsed, Generic.CodeAnalysis.UnusedFunctionParameter.FoundInExtendedClassAfterLastUsed
     */
    public function set(Model $model, string $key, mixed $value, array $attributes): int
    {
        // @phpcs:enable
        $value     = \rtrim(\ltrim(\str_replace(' ', '', \str_replace('rgba', '', \strval($value))), '('), ')');
        $intValues = collect(\explode(',', $value))->map(function ($val) {
            return \floatval($val);
        });
        // * Set Transparency as int
        $hexConcat = $intValues->push($intValues->pop() * 100)->map(function ($value) {
            return $this->zeropad(dechex(\intval($value)), 2);
        })->implode('');

        return \intval(\hexdec($hexConcat));
    }
}
