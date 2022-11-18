<?php

namespace App\Http\Controllers;

use App\Models\Game;
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
        $games        = self::sortGamesArray();
        $game         = Game::orderBy('slug', 'ASC')->first();
        $gamePictures = $this->paginate($game->pictures, 12, ['path' => Paginator::resolveCurrentPath()]);

        return view('front.games.show', ['game' => $game], compact('games', 'gamePictures'));
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
        $games        = self::sortGamesArray();
        $game         = Game::where('slug', $slug)->firstOrFail();
        $gamePictures = $this->paginate($game->pictures, 12, ['path' => Paginator::resolveCurrentPath()]);

        if ($request->ajax()) {
            return response()->json(['data' => $gamePictures]);
        }

        return view('front.games.show', ['game' => $game], compact('games', 'gamePictures'));
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
     * Created a table sorted alphabetically and by folder.
     *
     * @return array
     */
    public function sortGamesArray(): array
    {
        $array = [];
        $query = Game::orderBy('slug', 'ASC')->get();
        foreach ($query as $game) {
            if (!is_null($game->folder_id)) {
                if (isset($array[$game->folder->name])) {
                    array_push($array[$game->folder->name], $game);
                } else {
                    $array = array_merge($array, [$game->folder->name => [$game]]);
                }
            } else {
                $array = array_merge($array, [$game->name => [$game]]);
            }
        }
        ksort($array);
        return $array;
    }
}
