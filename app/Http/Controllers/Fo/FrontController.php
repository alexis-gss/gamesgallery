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
        $gameModels        = Game::where('published', true)->orderBy('slug', 'ASC')->with('pictures')->get();
        $gameLatestModels  = Game::where('published', true)->orderBy('published_at', 'DESC')->take(10)->get();
        $gamesLatestString = "";
        foreach ($gameLatestModels as $gameModel) {
            $gamesLatestString = $gamesLatestString . $gameModel->name . " / ";
        }

        return view('front.pages.home', compact('gameModels', 'gamesLatestString'));
    }

    /**
     * Show a specific game.
     *
     * @param Request $request
     * @param string  $slug
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function show(
        Request $request,
        string $slug
    ): \Illuminate\Http\JsonResponse|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse {
        if (Game::where('published', true)->where('slug', $slug)->first()) {
            $gameModels = Game::where('published', true)->orderBy('slug', 'ASC')->with('pictures')->get();
            $gameModel  = Game::where('published', true)->where('slug', $slug)->firstOrFail();

            if (count($gameModel->pictures)) {
                $gamePictures = $this->customPaginate(
                    $gameModel->pictures,
                    (count($gameModel->pictures) <= 12) ? count($gameModel->pictures) : 12,
                    ['path' => Paginator::resolveCurrentPath()]
                );
            } else {
                $gamePictures = [];
            }

            if ($request->ajax()) {
                return response()->json(['data' => $gamePictures]);
            }

            return view('front.pages.game', compact('gameModels', 'gameModel', 'gamePictures'));
        } else {
            return redirect()->route('fo.homepage');
        } //end if
    }

    /**
     * The attributes that are mass assignable.
     *
     * @param \Illuminate\Support\Collection $items
     * @param integer                        $perPage
     * @param array                          $options
     * @param integer                        $page
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function customPaginate(
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
     * Return a list of games filtered.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getGamesFiltered(Request $request): \Illuminate\Http\JsonResponse
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
