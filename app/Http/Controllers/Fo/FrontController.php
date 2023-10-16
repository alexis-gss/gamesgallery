<?php

namespace App\Http\Controllers\Fo;

use App\Http\Controllers\Controller;
use App\Lib\Helpers\ToolboxHelper;
use App\Models\Folder;
use App\Models\Game;
use App\Models\Tag;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;

class FrontController extends Controller
{
    /**
     * Show the application homepage.
     *
     * @return Illuminate\Contracts\View\View
     */
    public function index(): \Illuminate\Contracts\View\View
    {
        $this->getModelsPublished();

        /** @var \Illuminate\Support\Collection $gameLatestModels */
        $gameLatestModels = Game::query()->where('published', true)->orderBy('published_at', 'DESC')->take(20)->get();

        /** @var string $gamesLatestString */
        $gamesLatestString = "";
        foreach ($gameLatestModels as $gameModel) {
            $gamesLatestString = $gamesLatestString . $gameModel->name . " / ";
        }

        return view('front.pages.home', [
            'gameModels'        => $this->gameModels,
            'gamesLatestString' => $gamesLatestString,
            'folderModels'      => $this->folderModels,
            'tagModels'         => $this->tagModels,
        ]);
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
        if ($gameModel = Game::query()->where('published', true)->where('slug', $slug)->first()) {
            $this->getModelsPublished();

            /** @var array $gamePictures */
            $gamePictures = [];
            if (count($gameModel->pictures)) {
                $gamePictures = ToolboxHelper::customPaginate(
                    $gameModel->pictures,
                    (count($gameModel->pictures) <= 12) ? count($gameModel->pictures) : 12,
                    ['path' => Paginator::resolveCurrentPath()]
                );
            }

            if ($request->ajax()) {
                return response()->json(['data' => $gamePictures]);
            }

            return view('front.pages.game', [
                'gameModels'   => $this->gameModels,
                'gameModel'    => $gameModel,
                'gamePictures' => $gamePictures,
                'folderModels' => $this->folderModels,
                'tagModels'    => $this->tagModels,
            ]);
        } else {
            return redirect()->route('fo.homepage');
        } //end if
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
        $gamesFiltered = Game::query()->where('published', true)
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
