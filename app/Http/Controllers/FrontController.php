<?php

namespace App\Http\Controllers;

use App\Models\Game;
use Illuminate\Contracts\View\View;

class FrontController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return View
     */
    public function index()
    {
        $games = Game::orderBy('order', 'ASC')->get();
        return view('front.home', compact('games'));
    }

    /**
     * Show the application dashboard.
     *
     * @param string $slug
     * @return View
     */
    public function show(string $slug)
    {
        $games = Game::orderBy('order', 'ASC')->get();
        $game  = Game::where('slug', $slug)->firstOrFail();

        return view('front.games.show', ['game' => $game], compact('games'));
    }
}
