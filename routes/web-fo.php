<?php

use App\Http\Controllers\Fo\FrontController;
use Illuminate\Support\Facades\Route;

Route::get('/', [FrontController::class, 'index'])->name('homepage');
Route::get('/{slug}', [FrontController::class, 'show'])->name('games.specific')->where('slug', '^[a-zA-Z0-9-]*$');
Route::post('/search/{filtersId}', [FrontController::class, 'getGamesFiltered'])->name('games.filtered');
