<?php

namespace App\Http\Controllers\Bo;

use App\Http\Controllers\Controller;
use App\Models\Folder;
use App\Models\Game;
use App\Models\Tag;

class StatisticController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index(): \Illuminate\Contracts\View\View
    {
        $latestGame   = Game::where('published', true)->orderBy('published_at', 'DESC')->firstOrFail();
        $latestFolder = Folder::where('published', true)->orderBy('published_at', 'DESC')->firstOrFail();
        $latestTag    = Tag::where('published', true)->orderBy('published_at', 'DESC')->firstOrFail();

        return view('back.statistics.index', compact('latestGame', 'latestFolder', 'latestTag'));
    }
}
