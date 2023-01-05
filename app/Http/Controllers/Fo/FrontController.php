<?php

namespace App\Http\Controllers\Fo;

use App\Http\Controllers\Controller;
use App\Models\Folder;
use App\Models\Game;
use App\Models\Tag;
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
        $games = Game::where('status', 1)->orderBy('slug', 'ASC')->get();

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
        $games = Game::where('status', 1)->orderBy('slug', 'ASC')->get();
        $game  = Game::where('status', 1)->where('slug', $slug)->firstOrFail();
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
}
