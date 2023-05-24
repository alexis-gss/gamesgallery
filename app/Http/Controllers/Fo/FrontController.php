<?php

namespace App\Http\Controllers\Fo;

use App\Http\Controllers\Controller;
use App\Models\Game;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class FrontController extends Controller
{
    /**
     * Show the application homepage.
     *
     * @return Illuminate\Contracts\View\View
     */
    public function index(): \Illuminate\Contracts\View\View
    {
        $games       = Game::where('published', true)->orderBy('slug', 'ASC')->get();

        return view('front.pages.home', compact('games'));
    }

    /**
     * Show a specific game.
     *
     * @param Request $request
     * @param string  $slug
     * @return Illuminate\Http\JsonResponse|Illuminate\Contracts\View\View
     */
    public function show(Request $request, string $slug)
    {
        $games = Game::where('published', true)->orderBy('slug', 'ASC')->get();
        $game  = Game::where('published', true)->where('slug', $slug)->firstOrFail();
        if (isset($game->pictures)) {
            $gamePictures = $this->paginate(
                $game->pictures,
                (count($game->pictures) <= 12) ? count($game->pictures) : 12,
                ['path' => Paginator::resolveCurrentPath()]
            );
        } else {
            $gamePictures = [];
        }

        if ($request->ajax()) {
            return response()->json(['data' => $gamePictures]);
        }

        return view('front.pages.game', compact('games', 'game', 'gamePictures'));
    }

    /**
     * The attributes that are mass assignable.
     *
     * @param array   $items
     * @param integer $perPage
     * @param array   $options
     * @param integer $page
     * @return App\Http\Controllers\LengthAwarePaginator
     */
    public function paginate(array $items, int $perPage, array $options, int $page = null)
    {
        $page   = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items  = $items instanceof Collection ? $items : Collection::make($items);
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
     * Return a list of games filtered.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function getGamesFiltered(Request $request)
    {
        $selectedTagId    = intval($request->FILTERSID[0] ?? 0);
        $selectedFolderId = intval($request->FILTERSID[1] ?? 0);
        /** @var HTMLCollection<\App\Models\Game> */
        $gamesFiltered = Game::where('published', true)
            ->when($selectedTagId, function ($query) use ($selectedTagId) {
                $query->whereHas('tags', function (Builder $query) use ($selectedTagId) {
                    $query->where('id', $selectedTagId);
                });
            })
            ->when($selectedFolderId, function ($query) use ($selectedFolderId) {
                $query->where('folder_id', $selectedFolderId);
            })
            ->orderBy('slug', 'ASC')
            ->get();
        return response()->json($gamesFiltered);
    }
}
