<?php

use App\Http\Controllers\Fo\FrontController;
use App\Http\Controllers\Fo\RankController;
use Illuminate\Support\Facades\Route;

Route::name('fo.')
    ->group(function () {
        Route::get('/', [FrontController::class, 'index'])
            ->name('homepage');
        Route::get('/game/{slug}', [FrontController::class, 'show'])
            ->where('slug', '^[a-zA-Z0-9-]*$')
            ->name('games.show');
        Route::post('/game/search/{filtersId}', [FrontController::class, 'getGamesFiltered'])
            ->name('games.filtered');

        // * RANKS
        Route::get('/ranking', [RankController::class, 'index'])
            ->name('ranks.index');
    });
