<?php

namespace App\Lib\Helpers;

use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ToolboxHelper
{
    /**
     * Mutltibyte string replace.
     *
     * @param mixed   $search
     * @param mixed   $replace
     * @param mixed   $subject
     * @param integer $count
     * @return mixed
     */
    public static function mbReplace(mixed $search, mixed $replace, mixed $subject, int &$count = 0)
    {
        if (!is_array($search) && is_array($replace)) {
            return false;
        }
        if (is_array($subject)) {
            // Call mb_replace for each single string in $subject .
            foreach ($subject as &$string) {
                $string = &self::mbReplace($search, $replace, $string, $count);
            }
        } elseif (is_array($search)) {
            if (!is_array($replace)) {
                foreach ($search as &$string) {
                    $subject = self::mbReplace($string, $replace, $subject, $count);
                }
            } else {
                $n = max(count($search), count($replace));
                while ($n--) {
                    $subject = self::mbReplace(current($search), current($replace), $subject, $count);
                    next($search);
                    next($replace);
                }
            }
        } else {
            $parts   = mb_split(preg_quote($search), $subject);
            $count   = count($parts) - 1;
            $subject = implode($replace, $parts);
        } //end if
        return $subject;
    }

    /**
     * Get validated pagination from request.
     *
     * @param integer $default
     * @param string  $field
     * @param string  $enumPath
     * @return integer
     */
    public static function getValidatedEnum(int $default, string $field, string $enumPath): int
    {
        try {
            return \intval(Validator::make(
                [$field => \request()->get($field)],
                [$field => new Enum($enumPath)]
            )->validated()[$field]);
        } catch (ValidationException $e) {
            return $default;
        }
    }

    /**
     * Create a custom pagination from collection.
     *
     * @param \Illuminate\Support\Collection $items
     * @param integer                        $perPage
     * @param array                          $options
     * @param integer                        $page
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public static function customPaginate(
        Collection $items,
        int $perPage,
        array $options,
        int $page = null
    ): \Illuminate\Pagination\LengthAwarePaginator {
        $page   = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $result = new LengthAwarePaginator(
            $items->forPage($page, $perPage),
            $items->count(),
            $perPage,
            $page,
            $options
        );
        return $result;
    }

    /**
     * Array merge recursive distinct.
     *
     * @param array<int|string, mixed> $array1
     * @param array<int|string, mixed> $array2
     *
     * @return array<int|string, mixed>
     */
    public static function arrayMergeRecursiveDistinct(array &$array1, array &$array2): array
    {
        $merged = $array1;
        foreach ($array2 as $key => &$value) {
            if (is_array($value) && isset($merged[$key]) && is_array($merged[$key])) {
                $merged[$key] = self::arrayMergeRecursiveDistinct($merged[$key], $value);
            } else {
                $merged[$key] = $value;
            }
        }

        return $merged;
    }
}
