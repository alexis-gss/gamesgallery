<?php

namespace App\Http\Controllers\Fo;

use App\Enums\Pages\StaticPageTypeEnum;
use App\Http\Controllers\Controller;
use App\Models\Game;
use App\Models\StaticPage;

class StaticPageController extends Controller
{
    /**
     * Show the application homepage.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function home(): \Illuminate\Contracts\View\View
    {
        /** @var \App\Models\StaticPage $staticPageModel */
        $staticPageModel = StaticPage::query()->where('type', StaticPageTypeEnum::home->value())->first();

        /** @var \Illuminate\Support\Collection $gameLatestModels */
        $gameLatestModels = Game::query()->where('published', true)->orderBy('published_at', 'DESC')->take(20)->get();

        /** @var string $gamesLatestString */
        $gamesLatestString = "";
        $gameLatestModels->map(function ($gameModel, $gameModelIndex) use ($gameLatestModels, &$gamesLatestString) {
            $gamesLatestString .= $gameModel->name . (
                ($gameModelIndex !== $gameLatestModels->count() - 1) ? " / " : "..."
            );
        });

        return view('front.pages.home', [
            'staticPageModel'   => $staticPageModel,
            'gamesLatestString' => $gamesLatestString,
            'gameModels'        => $this->getGamesPublished(true, $this->gamesPerPage),
            'folderModels'      => $this->getFoldersPublished(),
            'tagModels'         => $this->getTagsPublished(),
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function ranking(): \Illuminate\Contracts\View\View
    {
        /** @var \App\Models\StaticPage $staticPageModel */
        $staticPageModel = StaticPage::query()->where('type', StaticPageTypeEnum::ranking->value())->first();

        return view('front.pages.ranking', [
            'staticPageModel' => $staticPageModel,
            'gameModels'      => $this->getGamesPublished(true, $this->gamesPerPage),
            'folderModels'    => $this->getFoldersPublished(),
            'tagModels'       => $this->getTagsPublished(),
            'rankModels'      => $this->getRanksPublished(),
        ]);
    }
}
