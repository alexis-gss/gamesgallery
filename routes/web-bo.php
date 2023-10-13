<?php

use App\Http\Controllers\Bo\ActivityLogsController;
use App\Http\Controllers\Bo\HomeController;
use App\Http\Controllers\Bo\GameController;
use App\Http\Controllers\Bo\FolderController;
use App\Http\Controllers\Bo\StatisticController;
use App\Http\Controllers\Bo\TagController;
use App\Http\Controllers\Bo\UserController;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::prefix('bo')
    ->name('bo.')
    ->group(
        function () {
            // * AUTHENTICABLE ROUTES
            Route::middleware([])
                ->namespace('\App\Http\Controllers\Bo')
                ->group(function () {
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
                });
            Route::middleware(['auth:backend'])
                ->group(function () {
                    // * HOMEPAGE
                    Route::get('/', [HomeController::class, 'index'])->name('homepage');

                    // * STATS
                    Route::get('/stats', [StatisticController::class, 'index'])
                        ->name('statistics');

                    // * GAMES
                    Route::resource('games', GameController::class)->except('show');
                    Route::post('/games/{game}/change-order/{direction}', [GameController::class, 'changeOrder'])
                        ->where('direction', 'up|down')->name('games.change-order');
                    Route::post('/games/{game}/change-published', [GameController::class, 'changePublished'])
                        ->name('games.change-published');
                    Route::get('/games/{game}/duplicate', [GameController::class, 'duplicate'])
                        ->name('games.duplicate');
                    Route::post('/games/upload', [GameController::class, 'upload'])
                        ->name('games.upload');

                    // * FOLDERS
                    Route::resource('folders', FolderController::class)->except('show');
                    Route::post('/folders/{folder}/change-order/{direction}', [FolderController::class, 'changeOrder'])
                        ->where('direction', 'up|down')
                        ->name('folders.change-order');
                    Route::post('/folders/{folder}/change-published', [FolderController::class, 'changePublished'])
                        ->name('folders.change-published');
                    Route::get('/folders/{folder}/duplicate', [FolderController::class, 'duplicate'])
                        ->name('folders.duplicate');

                    // * TAGS
                    Route::resource('tags', TagController::class)->except('show');
                    Route::post('/tags/{tag}/change-order/{direction}', [TagController::class, 'changeOrder'])
                        ->where('direction', 'up|down')
                        ->name('tags.change-order');
                    Route::post('/tags/{tag}/change-published', [TagController::class, 'changePublished'])
                        ->name('tags.change-published');
                    Route::post('/tags/store', [TagController::class, 'jsonStore'])
                        ->name('tags.jsonStore');
                    Route::get('/tags/{tag}/duplicate', [TagController::class, 'duplicate'])
                        ->name('tags.duplicate');

                    // * USERS
                    Route::resource('users', UserController::class)->except('show');
                    Route::post('/users/{user}/change-order/{direction}', [UserController::class, 'changeOrder'])
                        ->where('direction', 'up|down')->name('users.change-order');
                    Route::get('/users/{user}/duplicate', [UserController::class, 'duplicate'])
                        ->name('users.duplicate');
                    Route::post('/users/{user}/change-published', [UserController::class, 'changePublished'])
                        ->name('users.change-published');

                    Route::middleware('can:isConceptor')->group(function () {
                        // * ACTIVITY LOGS.
                        Route::resource('activity_logs', ActivityLogsController::class)->only(['index', 'show']);
                    });
                });
            // * BOOTSTRAP THEMES.
            Route::post('theme/set', [Controller::class, 'setTheme'])->name('theme.set');
        }
    );
