<?php

use App\Http\Controllers\Fo\FrontController;
use Illuminate\Support\Facades\Route;

Route::name('fo.')
    ->group(function () {
        Route::get('/', [FrontController::class, 'index'])
            ->name('homepage');
        Route::get('/{slug}', [FrontController::class, 'show'])
            ->where('slug', '^[a-zA-Z0-9-]*$')
            ->name('games.specific');
        Route::post('/search/{filtersId}', [FrontController::class, 'getGamesFiltered'])
            ->name('games.filtered');
    });
