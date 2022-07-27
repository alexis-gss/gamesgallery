<?php

use App\Http\Controllers\Bo\BackController;
use App\Http\Controllers\Bo\GamesController;
use App\Http\Controllers\Bo\FoldersController;
use App\Http\Controllers\FrontController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::prefix('bo')
    ->name('bo.')
    ->group(
        function () {
            Route::middleware([])
                ->group(
                    function () {
                        Auth::routes(
                            [
                                'login'    => true,
                                'logout'   => true,
                                'register' => false,
                                'reset'    => false,
                                'confirm'  => false,
                                'verify'   => false,
                            ]
                        );
                    }
                );
            Route::middleware(['auth:web'])
                ->group(
                    function () {
                        Route::middleware(['can:isAdmin'])
                            ->group(
                                function () {
                                    // phpcs:ignore Generic.Files.LineLength.TooLong
                                    Route::get('/games/change-order/{game}/{direction}', [GamesController::class, 'changeOrder'])
                                        ->where('direction', 'up|down')
                                        ->name('games.change-order');
                                    Route::resource('games', GamesController::class)->except('show');

                                    // phpcs:ignore Generic.Files.LineLength.TooLong
                                    Route::get('/folders/change-order/{folder}/{direction}', [FoldersController::class, 'changeOrder'])
                                        ->where('direction', 'up|down')
                                        ->name('folders.change-order');
                                    Route::resource('folders', FoldersController::class)->except('show');
                                }
                            );

                        Route::get('/', [BackController::class, 'index'])->name('home');
                        Route::get('/games', [GamesController::class, 'index'])->name('games.index');
                        Route::get('/games/search', [GamesController::class, 'index'])->name('games.search');
                        Route::get('/folders', [FoldersController::class, 'index'])->name('folders.index');
                        Route::get('/folders/search', [FoldersController::class, 'index'])->name('folders.search');
                    }
                );
        }
    );

Route::get('/', [FrontController::class, 'index'])->name('homepage');
Route::get('/{slug}', [FrontController::class, 'show'])->name('games.specific')
    ->where('slug', '^[a-zA-Z0-9-]*$');
