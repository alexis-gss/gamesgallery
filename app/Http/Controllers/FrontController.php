<?php

namespace App\Http\Controllers;

use App\Models\Game;

class FrontController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return Illuminate\Contracts\View\View
     */
    public function index(): \Illuminate\Contracts\View\View
    {
        $games = self::sortGamesArray();

        return view('front.home', compact('games'));
    }

    /**
     * Show a specific game.
     *
     * @param string $slug
     * @return Illuminate\Contracts\View\View
     */
    public function show(string $slug): \Illuminate\Contracts\View\View
    {
        $games = self::sortGamesArray();
        $game  = Game::where('slug', $slug)->firstOrFail();

        return view('front.games.show', ['game' => $game], compact('games'));
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
        return $array;
    }
}
