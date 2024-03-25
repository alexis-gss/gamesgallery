<?php

use App\Http\Controllers\Bo\ActivityLogsController;
use App\Http\Controllers\Bo\HomeController;
use App\Http\Controllers\Bo\GameController;
use App\Http\Controllers\Bo\FolderController;
use App\Http\Controllers\Bo\PictureController;
use App\Http\Controllers\Bo\RankController;
use App\Http\Controllers\Bo\StaticPageController;
use App\Http\Controllers\Bo\StatisticController;
use App\Http\Controllers\Bo\TagController;
use App\Http\Controllers\Bo\UserController;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::prefix('bo')
    ->name('bo.')
    ->middleware('lang')
    ->group(
        function () {
            // * AUTHENTICABLE ROUTES
            Route::namespace('\App\Http\Controllers\Bo')
                ->group(function () {
                    Auth::routes(
                        [
                            'login'    => true,
                            'logout'   => true,
                            'reset'    => true,
                            'register' => false,
                            'confirm'  => false,
                            'verify'   => false,
                        ]
                    );
                });
            Route::middleware(['auth:backend'])
                ->group(function () {
                    // * HOMEPAGE
                    Route::get('/', [HomeController::class, 'index'])->name('homepage');

                    // * STATISTICS
                    Route::get('/statistics', [StatisticController::class, 'index'])
                        ->name('statistics.index');
                    Route::post('/statistics', [StatisticController::class, 'index'])
                        ->name('statistics.update');

                    // * GAMES
                    Route::resource('games', GameController::class);
                    Route::patch('/games/{game}/change-order/{direction}', [GameController::class, 'changeOrder'])
                        ->where('direction', 'up|down')->name('games.change-order');
                    Route::patch('/games/{game}/change-published', [GameController::class, 'changePublished'])
                        ->name('games.change-published');
                    Route::get('/games/{game}/duplicate', [GameController::class, 'duplicate'])
                        ->name('games.duplicate');

                    // * PICTURES
                    Route::post('/pictures/upload', [PictureController::class, 'upload'])
                        ->name('pictures.upload');

                    // * FOLDERS
                    Route::resource('folders', FolderController::class);
                    Route::patch('/folders/{folder}/change-order/{direction}', [FolderController::class, 'changeOrder'])
                        ->where('direction', 'up|down')
                        ->name('folders.change-order');
                    Route::patch('/folders/{folder}/change-published', [FolderController::class, 'changePublished'])
                        ->name('folders.change-published');
                    Route::get('/folders/{folder}/duplicate', [FolderController::class, 'duplicate'])
                        ->name('folders.duplicate');

                    // * TAGS
                    Route::resource('tags', TagController::class);
                    Route::patch('/tags/{tag}/change-order/{direction}', [TagController::class, 'changeOrder'])
                        ->where('direction', 'up|down')
                        ->name('tags.change-order');
                    Route::patch('/tags/{tag}/change-published', [TagController::class, 'changePublished'])
                        ->name('tags.change-published');
                    Route::post('/tags/store', [TagController::class, 'jsonStore'])
                        ->name('tags.jsonStore');
                    Route::get('/tags/{tag}/duplicate', [TagController::class, 'duplicate'])
                        ->name('tags.duplicate');

                    // * RANKS
                    Route::resource('ranks', RankController::class)->except(['show', 'edit']);
                    Route::post('/ranks/save-order/{ranks}', [RankController::class, 'saveOrder'])
                        ->name('ranks.save-order');
                    Route::get('/ranks/games', [RankController::class, 'getPublishedGamesInNotRanking'])
                        ->name('ranks.games');

                    // * STATIC PAGES
                    Route::resource('static_pages', StaticPageController::class)
                        ->only(['index', 'show', 'edit', 'update']);
                    Route::patch('/static_pages/{static_page}/change-order/{direction}', [
                        StaticPageController::class, 'changeOrder'
                    ])->where('direction', 'up|down')->name('static_pages.change-order');

                    // * USERS
                    Route::resource('users', UserController::class);
                    Route::patch('/users/{user}/change-order/{direction}', [UserController::class, 'changeOrder'])
                        ->where('direction', 'up|down')->name('users.change-order');
                    Route::patch('/users/{user}/change-published', [UserController::class, 'changePublished'])
                        ->name('users.change-published');
                    Route::get('/users/{user}/duplicate', [UserController::class, 'duplicate'])
                        ->name('users.duplicate');

                    // * ACTIVITY LOGS.
                    Route::resource('activity_logs', ActivityLogsController::class)->only(['index', 'show']);
                });

            // * CHANGE LANGUAGES.
            Route::post('/lang/set', [Controller::class, 'setLang'])->name('lang.set');

            // * BOOTSTRAP THEMES.
            Route::post('theme/set', [Controller::class, 'setTheme'])->name('theme.set');
        }
    );
