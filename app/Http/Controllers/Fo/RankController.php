<?php

namespace App\Http\Controllers\Fo;

use App\Http\Controllers\Controller;
use App\Models\Rank;

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
            'gameModels'   => $this->gameModels,
            'rankModels'   => $rankModels,
            'folderModels' => $this->folderModels,
            'tagModels'    => $this->tagModels,
        ]);
    }
}
