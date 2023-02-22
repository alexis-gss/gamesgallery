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
        View::share('name', $appInfos->name);
        View::share('version', $appInfos->version);
        View::share('license', $appInfos->license);

        // Shares this data with all views.
        if (
            Schema::hasTable('games') and
            Schema::hasTable('folders') and
            Schema::hasTable('tags') and
            Schema::hasTable('users')
        ) {
            $globalGames   = Game::orderBy('order', 'ASC')->where('status', true)->get();
            $globalFolders = Folder::orderBy('order', 'ASC')->where('status', true)->get();
            $globalTags    = Tag::orderBy('order', 'ASC')->where('status', true)->get();
            $globalUsers   = User::orderBy('order', 'ASC')->get();
            View::share('globalGames', $globalGames);
            View::share('globalFolders', $globalFolders);
            View::share('globalTags', $globalTags);
            View::share('globalUsers', $globalUsers);
        }
    }
}
