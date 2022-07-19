<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(): void
    {
        Schema::defaultStringLength(191);
        Paginator::useBootstrap();
        URL::forceScheme('https');

        // Get data from composer.json.
        $appInfos = Cache::remember('composer', 360, function () {
            return json_decode(File::get(\app_path('../composer.json')));
        });
        View::share('name', $appInfos->name);
        View::share('version', $appInfos->version);
        View::share('license', $appInfos->license);
    }
}
