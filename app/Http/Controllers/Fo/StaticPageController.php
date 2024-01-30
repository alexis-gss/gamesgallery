<?php

namespace App\Http\Controllers\Fo;

use App\Enums\Pages\StaticPageTypeEnum;
use App\Http\Controllers\Controller;
use App\Models\Game;
use App\Models\Rank;
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
        $this->getModelsPublished();

        /** @var \App\Models\StaticPage $staticPageModel */
        $staticPageModel = StaticPage::query()->where('type', StaticPageTypeEnum::home->value())->first();

        /** @var \Illuminate\Support\Collection $gameLatestModels */
        $gameLatestModels = Game::query()->where('published', true)->orderBy('published_at', 'DESC')->take(20)->get();

        /** @var string $gamesLatestString */
        $gamesLatestString = "";
        foreach ($gameLatestModels as $key => $gameModel) {
            $gamesLatestString = $gamesLatestString .
                $gameModel->name .
                (($key !== count($gameLatestModels) - 1) ? " / " : "...");
        }

        return view('front.pages.home', [
            'staticPageModel'   => $staticPageModel,
            'gameModels'        => $this->gameModels,
            'gamesLatestString' => $gamesLatestString,
            'folderModels'      => $this->folderModels,
            'tagModels'         => $this->tagModels,
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function ranking(): \Illuminate\Contracts\View\View
    {
        $this->getModelsPublished();

        /** @var \App\Models\StaticPage $staticPageModel */
        $staticPageModel = StaticPage::query()->where('type', StaticPageTypeEnum::ranking->value())->first();

        /** @var \Illuminate\Database\Eloquent\Collection $rankModels */
        $rankModels = Rank::query()
            ->orderby('rank', 'ASC')
            ->with('game')
            ->get()
            ->each(function (Rank $rank) {
                // @phpstan-ignore-next-line
                $rank->game_name = $rank->game->name;
                // @phpstan-ignore-next-line
                $rank->game_slug = $rank->game->slug;
            });

        return view('front.pages.ranking', [
            'staticPageModel' => $staticPageModel,
            'gameModels'      => $this->gameModels,
            'rankModels'      => $rankModels,
            'folderModels'    => $this->folderModels,
            'tagModels'       => $this->tagModels,
        ]);
    }
}
