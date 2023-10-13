<?php

namespace App\Providers;

use App\Models\ActivityLog;
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
        // Get data from composer.json.
        $appInfos = Cache::remember('composer', 360, function () {
            return json_decode(File::get(\app_path('../composer.json')));
        });
        // Share composer.json infos.
        View::share('globalName', $appInfos->name);
        View::share('globalVersion', $appInfos->version);
        View::share('globalLicense', $appInfos->license);

        if (!app()->runningInConsole()) {
            // Shares this data with all views.
            if (
                Schema::hasTable('games') and
                Schema::hasTable('folders') and
                Schema::hasTable('tags') and
                Schema::hasTable('users') and
                Schema::hasTable('activity_logs')
            ) {
                $globalGames      = Game::with('pictures')->orderBy('name', 'ASC')->get();
                $globalFolders    = Folder::with('games')->orderBy('name', 'ASC')->get();
                $globalTags       = Tag::with('games')->orderBy('name', 'ASC')->get();
                $globalUsers      = User::orderBy('last_name', 'ASC')->get();
                $globalActivities = ActivityLog::with('user')->get();
                View::share('globalGames', $globalGames);
                View::share('globalFolders', $globalFolders);
                View::share('globalTags', $globalTags);
                View::share('globalUsers', $globalUsers);
                View::share('globalActivities', $globalActivities);
            }

            // * FORCE BOOTSTRAP PAGINATOR (or custom if in front)
            // Early boot, request wont be filled as expected.
            if (collect(explode('/', \request()->getPathInfo()))->get(1) === 'bo') {
                Paginator::defaultView('back.modules.pagination');
            } else {
                Paginator::useBootstrapFive();
            }
        } //end if
    }
}
