<?php

namespace App\Http\Controllers\Fo;

use App\Enums\Pages\StaticPageTypeEnum;
use App\Http\Controllers\Controller;
use App\Models\Rank;
use App\Models\StaticPage;

class RankController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index(): \Illuminate\Contracts\View\View
    {
        $this->getModelsPublished();

        /** @var \App\Models\StaticPage $staticPageModel */
        $staticPageModel = StaticPage::query()->where('type', StaticPageTypeEnum::ranking->value())->first();

        /** @var \Illuminate\Database\Eloquent\Collection $rankModels */
        $rankModels = Rank::query()
            ->orderby('rank', 'ASC')
            ->with('game')
            ->get()
            ->each(function ($rank) {
                $rank->name = $rank->game->name;
                $rank->slug = $rank->game->slug;
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
