<?php

namespace App\Providers;

use App\Models\Game;
use App\Models\Folder;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(): void
    {
        // Set default view of the paginator.
        Paginator::defaultView('back.modules.pagination');

        // Get data from composer.json.
        $appInfos = Cache::remember('composer', 360, function () {
            return json_decode(File::get(\app_path('../composer.json')));
        });
        View::share('globalName', $appInfos->name);
        View::share('globalVersion', $appInfos->version);
        View::share('globalLicense', $appInfos->license);

        // Shares this data with all views.
        if (
            Schema::hasTable('games') and
            Schema::hasTable('folders') and
            Schema::hasTable('tags') and
            Schema::hasTable('users')
        ) {
            $globalGames   = Game::orderBy('name', 'ASC')->where('published', true)->get();
            $globalFolders = Folder::orderBy('name', 'ASC')->where('published', true)->get();
            $globalTags    = Tag::orderBy('name', 'ASC')->where('published', true)->get();
            $globalUsers   = User::orderBy('name', 'ASC')->get();
            View::share('globalGames', $globalGames);
            View::share('globalFolders', $globalFolders);
            View::share('globalTags', $globalTags);
            View::share('globalUsers', $globalUsers);
        }
    }
}
