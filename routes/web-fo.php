<?php

use App\Http\Controllers\Controller;
use App\Http\Controllers\Fo\GameController;
use App\Http\Controllers\Fo\StaticPageController;
use App\Http\Controllers\Fo\RatingController;
use Illuminate\Support\Facades\Route;

Route::name('fo.')
    ->group(function () {
        // * GAMES
        Route::get('/game/{slug}', [GameController::class, 'show'])
            ->where('slug', '^[a-zA-Z0-9-]*$')
            ->name('games.show');
        Route::post('/game/filtered/{filters_id}', [GameController::class, 'getGamesFiltered'])
            ->name('games.filtered');

        // * STATIC PAGES
        Route::get('/', [StaticPageController::class, 'home'])
            ->name('games.index');
        Route::get('/ranking', [StaticPageController::class, 'ranking'])
            ->name('ranks.index');

        // * RATINGS
        Route::post('/ratings/{picture_id}/{picture_place}', [RatingController::class, 'update'])
            ->name('ratings.update');

        // * CHANGE LANGUAGES.
        Route::post('/lang/set', [Controller::class, 'setLang'])->name('lang.set');
    });
