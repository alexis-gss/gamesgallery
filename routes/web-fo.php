<?php

use App\Http\Controllers\Controller;
use App\Http\Controllers\Fo\GameController;
use App\Http\Controllers\Fo\RankController;
use Illuminate\Support\Facades\Route;

Route::name('fo.')
    ->group(function () {
        // * GAMES
        Route::get('/', [GameController::class, 'index'])
            ->name('homepage');
        Route::get('/game/{slug}', [GameController::class, 'show'])
            ->where('slug', '^[a-zA-Z0-9-]*$')
            ->name('games.show');
        Route::post('/game/search/{filtersId}', [GameController::class, 'getGamesFiltered'])
            ->name('games.filtered');

        // * RANKS
        Route::get('/ranking', [RankController::class, 'index'])
            ->name('ranks.index');

        // * CHANGE LANGUAGES.
        Route::post('/lang/set', [Controller::class, 'setLang'])->name('lang.set');
    });
