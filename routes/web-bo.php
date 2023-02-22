<?php

use App\Http\Controllers\Bo\BackController;
use App\Http\Controllers\Bo\GameController;
use App\Http\Controllers\Bo\FolderController;
use App\Http\Controllers\Bo\TagController;
use App\Http\Controllers\Bo\UserController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::prefix('bo')
    ->name('bo.')
    ->group(
        function () {
            Route::middleware([])
                ->namespace('\App\Http\Controllers\Bo')
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
                                    Route::get('/games/change-order/{game}/{direction}', [GameController::class, 'changeOrder'])
                                        ->where('direction', 'up|down')
                                        ->name('games.change-order');
                                    // phpcs:ignore Generic.Files.LineLength.TooLong
                                    Route::post('/games/{game}/change-published', [GameController::class, 'changePublished'])
                                        ->name('games.change-published');
                                    Route::resource('games', GameController::class)->except('show');

                                    // phpcs:ignore Generic.Files.LineLength.TooLong
                                    Route::get('/folders/change-order/{folder}/{direction}', [FolderController::class, 'changeOrder'])
                                        ->where('direction', 'up|down')
                                        ->name('folders.change-order');
                                    // phpcs:ignore Generic.Files.LineLength.TooLong
                                    Route::post('/folders/{folder}/change-published', [FolderController::class, 'changePublished'])
                                        ->name('folders.change-published');
                                    Route::resource('folders', FolderController::class)->except('show');

                                    // phpcs:ignore Generic.Files.LineLength.TooLong
                                    Route::get('/users/change-order/{user}/{direction}', [UserController::class, 'changeOrder'])
                                        ->where('direction', 'up|down')
                                        ->name('users.change-order');
                                    Route::resource('users', UserController::class)->except('show');

                                    // phpcs:ignore Generic.Files.LineLength.TooLong
                                    Route::get('/tags/change-order/{tag}/{direction}', [TagController::class, 'changeOrder'])
                                        ->where('direction', 'up|down')
                                        ->name('tags.change-order');
                                    Route::resource('tags', TagController::class)->except('show');
                                    Route::post('/tags/store', [TagController::class, 'jsonStore'])
                                        ->name('tags.jsonStore');
                                }
                            );

                        Route::get('/', [BackController::class, 'index'])->name('homepage');
                        Route::get('/games', [GameController::class, 'index'])->name('games.index');
                        Route::get('/folders', [FolderController::class, 'index'])->name('folders.index');
                        Route::get('/users', [UserController::class, 'index'])->name('users.index');
                        Route::get('/tags', [TagController::class, 'index'])->name('tags.index');
                    }
                );
        }
    );
