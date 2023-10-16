<?php

namespace App\Http\Controllers;

use App\Enums\Pagination\ItemsPerPaginationEnum;
use App\Enums\Theme\BootstrapThemeEnum;
use App\Lib\Helpers\ToolboxHelper;
use App\Models\Folder;
use App\Models\Game;
use App\Models\Tag;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class Controller extends BaseController
{
    use AuthorizesRequests;
    use ValidatesRequests;

    /** @var \Illuminate\Support\Collection $gameModels */
    protected $gameModels;

    /** @var \Illuminate\Support\Collection $folderModels */
    protected $folderModels;

    /** @var \Illuminate\Support\Collection $tagModels */
    protected $tagModels;

    /**
     * Get game/folder/tag models where are published.
     *
     * @return void
     */
    public function getModelsPublished(): void
    {
        $this->gameModels   = Game::query()->where('published', true)
            ->orderBy('slug', 'ASC')
            ->whereHas('folder', function ($q) {
                $q->where('published', true);
            })->with('pictures')->get();
        $this->folderModels = Folder::query()->where('published', true)->orderBy('slug', 'ASC')->get();
        $this->tagModels    = Tag::query()->where('published', true)->orderBy('slug', 'ASC')->get();
    }

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
    ): \Illuminate\Database\Eloquent\Builder {
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
    private function searchOnFields(
        Builder $query,
        string $search,
        array $fields
    ): \Illuminate\Database\Eloquent\Builder {
        $table = $query->getModel()->getTable();
        foreach ($fields as $field) {
            $field = str_replace('?', '\?', $field);
            if (is_array($field)) {
                $query->orWhereRaw(
                    sprintf("UPPER(CONCAT(%s)) LIKE UPPER(?)", collect($field)->map(function ($q) use ($table) {
                        return "`$table`.`$q`";
                    })->implode(', \' \', ')),
                    ['%' . htmlspecialchars($search) . '%']
                );
                return $query;
            }
            // Get models woth enum's label.
            if (is_array($this->getSearchValue($query, $search, $field))) {
                foreach ($this->getSearchValue($query, $search, $field) as $array) {
                    $query->orWhereRaw(
                        "UPPER(`$table`.`$field`) LIKE UPPER(?)",
                        ['%' . htmlspecialchars($array->value) . '%']
                    );
                }
                return $query;
            }
            // Get models with relation's name/label.
            if (Str::endsWith($field, '_id') && $query->getModel()->has(Str::remove('_id', $field))) {
                $query->orWhereHas(Str::remove('_id', $field), function ($queryRelation) use ($field, $search) {
                    if (Schema::hasColumn(Str::remove('_id', $field) . 's', 'name')) {
                        $queryRelation->where('name', 'like', '%' . $search . '%');
                    } elseif (Schema::hasColumn(Str::remove('_id', $field) . 's', 'label')) {
                        $queryRelation->where('label', 'like', '%' . $search . '%');
                    }
                });
                return $query;
            }
            $query->orWhereRaw(
                "UPPER(`$table`.`$field`) LIKE UPPER(?)",
                ['%' . htmlspecialchars($this->getSearchValue($query, $search, $field)) . '%']
            );
        } //end foreach
        return $query;
    }

    /**
     * Get the search value (on string or Enum).
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string                                $search
     * @param string                                $field
     * @return string|array
     */
    protected function getSearchValue(Builder $query, string $search, string $field): string|array
    {
        if (
            count($query->getModel()->getCasts()) and // Check if the model has casts.
            isset($query->getModel()->getCasts()[$field]) and // Check if there is cast about specific field.
            enum_exists($query->getModel()->getCasts()[$field]) // Check if the cast is an enum.
        ) {
            $cases = collect($query->getModel()->getCasts()[$field]::toArray());
            $enum  = $cases->filter(function ($item) use ($search) {
                return preg_match('/' . Str::of($search)->lower() . '/', Str::of($item->label)->lower());
            });
            return $enum->toArray();
        } else {
            return $search;
        }
    }

    /**
     * Sort columns with a query.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param array                                 $ignore
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function sortQuery(Builder $query, array $ignore = []): \Illuminate\Database\Eloquent\Builder
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
        } elseif (Schema::hasColumn($table, 'updated_at')) {
            $query = $query->orderBy('updated_at', 'DESC');
            Session::put("$rName.sort_col", 'updated_at');
            Session::put("$rName.sort_way", 'desc');
        } elseif (Schema::hasColumn($table, 'created_at')) {
            $query = $query->orderBy('created_at', 'DESC');
            Session::put("$rName.sort_col", 'created_at');
            Session::put("$rName.sort_way", 'desc');
        }
        return $query;
    }

    /**
     * Customize pagination with cache or config (default).
     *
     * @param \Illuminate\Database\Eloquent\Builder             $query
     * @param \App\Enums\Pagination\ItemsPerPaginationEnum|null $pagination
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    protected function paginate(
        Builder $query,
        ItemsPerPaginationEnum $pagination = null
    ): \Illuminate\Contracts\Pagination\LengthAwarePaginator {
        $currentRoutePath = Str::of(request()->route()->getName())->slug();
        $cacheKey         = "pagination.{$currentRoutePath}";
        $pagination       = $pagination ?? ItemsPerPaginationEnum::twelve;
        $pagination       = ToolboxHelper::getValidatedEnum(
            Cache::get($cacheKey, $pagination->value()),
            'pagination',
            '\App\Enums\Pagination\ItemsPerPaginationEnum',
        );
        if (Cache::get($cacheKey) !== $pagination) {
            Cache::put($cacheKey, $pagination);
        }
        $query = $query->paginate($pagination);
        return $query;
    }

    /**
     * Set the bootstrap theme or light (default).
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function setTheme(Request $request): \Illuminate\Http\RedirectResponse
    {
        $theme = ToolboxHelper::getValidatedEnum(
            $request->theme ?: Cache::get('theme', BootstrapThemeEnum::light->value()),
            'theme',
            '\App\Http\Controllers\BootstrapThemeEnum',
        );
        if (Cache::get("theme") !== $theme) {
            Cache::put("theme", $theme);
        }
        return redirect()->back()->with('success', __('crud.messages.theme_updated'));
    }
}
