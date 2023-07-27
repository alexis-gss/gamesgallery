<?php

use App\Http\Controllers\Bo\HomeController;
use App\Http\Controllers\Bo\GameController;
use App\Http\Controllers\Bo\FolderController;
use App\Http\Controllers\Bo\StatisticController;
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
                                    /**
                                     * * STATS
                                     */
                                    Route::get('/stats', [StatisticController::class, 'index'])
                                        ->name('statistics');

                                    /**
                                     * * GAMES
                                     */
                                    Route::get('/games/change-order/{game}/{direction}', [
                                        GameController::class, 'changeOrder'
                                    ])->where('direction', 'up|down')->name('games.change-order');
                                    Route::post('/games/{game}/change-published', [
                                        GameController::class, 'changePublished'
                                    ])->name('games.change-published');
                                    Route::get('/games/{game}/duplicate', [
                                        GameController::class, 'duplicate'
                                    ])->name('games.duplicate');
                                    Route::post('/games/upload', [
                                        GameController::class, 'upload'
                                    ])->name('games.upload');

                                    /**
                                     * * FOLDERS
                                     */
                                    Route::get('/folders/change-order/{folder}/{direction}', [
                                        FolderController::class, 'changeOrder'
                                    ])->where('direction', 'up|down')->name('folders.change-order');
                                    Route::post('/folders/{folder}/change-published', [
                                        FolderController::class, 'changePublished'
                                    ])->name('folders.change-published');
                                    Route::get('/folders/{folder}/duplicate', [
                                        FolderController::class, 'duplicate'
                                    ])->name('folders.duplicate');

                                    /**
                                     * * TAGS
                                     */
                                    Route::get('/tags/change-order/{tag}/{direction}', [
                                        TagController::class, 'changeOrder'
                                    ])->where('direction', 'up|down')->name('tags.change-order');
                                    Route::post('/tags/{tag}/change-published', [
                                        TagController::class, 'changePublished'
                                    ])->name('tags.change-published');
                                    Route::post('/tags/store', [TagController::class, 'jsonStore'])
                                        ->name('tags.jsonStore');
                                    Route::get('/tags/{tag}/duplicate', [
                                        TagController::class, 'duplicate'
                                    ])->name('tags.duplicate');

                                    /**
                                     * * USERS
                                     */
                                    Route::get('/users/change-order/{user}/{direction}', [
                                        UserController::class, 'changeOrder'
                                    ])->where('direction', 'up|down')->name('users.change-order');
                                    Route::get('/users/{user}/duplicate', [
                                        UserController::class, 'duplicate'
                                    ])->name('users.duplicate');
                                }
                            );
                        Route::get('/', [HomeController::class, 'index'])->name('homepage');
                        Route::resource('games', GameController::class)->except('show');
                        Route::resource('folders', FolderController::class)->except('show');
                        Route::resource('tags', TagController::class)->except('show');
                        Route::resource('users', UserController::class)->except('show');
                    }
                );
        }
    );
