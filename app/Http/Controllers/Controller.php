<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Session;

class Controller extends BaseController
{
    use AuthorizesRequests;
    use DispatchesJobs;
    use ValidatesRequests;

    /**
     * Build Search query on specified fields
     * splitting search into words or using whole sentence
     *
     * @param \Illuminate\Database\Eloquent\Builder $query       The eloquent query builder.
     * @param string                                $search      The query string.
     * @param callable                              $searchQuery The query string.
     * @param string                                ...$fields   Either a simple array or a string
     *                                                           in case of a string the two fields
     *                                                           would be concatenate to make the search.
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function searchQuery(
        Builder $query,
        string $search,
        callable $searchQuery = null,
        string ...$fields
    ): Builder {
        if (count($fields)) {
            // Search using words.
            $words = explode(' ', $search);
            $query->where(function ($query) use ($searchQuery, $words, $search, $fields) {
                foreach ($words as $word) {
                    if (!strlen($word)) {
                        continue;
                    }
                    $this->searchOnFields($query, $word, $fields);
                } //end foreach
                // Search whole using whole sentence.
                $this->searchOnFields($query, $search, $fields);
                if ($searchQuery) {
                    $searchQuery($query);
                }
            });
        } //end if
        return $query;
    }

    /**
     * Build query search on all fields
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string                                $search
     * @param array                                 $fields
     * @return \Illuminate\Database\Eloquent\Builder
     */
    private function searchOnFields(Builder $query, string $search, array $fields): Builder
    {
        $table = $query->getModel()->getTable();
        foreach ($fields as $f) {
            $f = str_replace('?', '\?', $f);
            if (is_array($f)) {
                $query->orWhereRaw(
                    sprintf("UPPER(CONCAT(%s)) LIKE UPPER(?)", collect($f)->map(function ($q) use ($table) {
                        return "`$table`.`$q`";
                    })->implode(', \' \', ')),
                    ['%' . filter_var($search, FILTER_SANITIZE_STRING) . '%']
                );
            } else {
                $query->orWhereRaw(
                    "UPPER(`$table`.`$f`) LIKE UPPER(?)",
                    ['%' . filter_var($search, FILTER_SANITIZE_STRING) . '%']
                );
            }
        }
        return $query;
    }

    /**
     * Sort columns with a query
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param array                                 $ignore
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function sortQuery(Builder $query, array $ignore = []): Builder
    {
        $rName = request()->route()->getName();
        $table = $query->getModel()->getTable();
        if (request()->sort_col) {
            Session::put("$rName.sort_col", request()->sort_col);
            Session::put("$rName.sorted", true);
        }
        if (request()->sort_way) {
            Session::put("$rName.sort_way", request()->sort_way);
            Session::put("$rName.sorted", true);
        }
        if (request()->rst) {
            Session::remove("$rName.sorted");
            Session::remove("$rName.sort_col");
            Session::remove("$rName.sort_way");
        }
        if (request()->sort_col and request()->sort_way and Schema::hasColumn($table, request()->sort_col)) {
            if (
                !isset($ignore) or
                (isset($ignore) and !in_array(request()->sort_col, $ignore))
            ) {
                $query = $query->orderBy(\sprintf("$table.%s", request()->sort_col), request()->sort_way);
            }
        } elseif (Schema::hasColumn($table, 'order')) {
            $query = $query->orderBy('order', 'ASC');
            Session::put("$rName.sort_col", 'order');
            Session::put("$rName.sort_way", 'asc');
        }
        return $query;
    }
}
