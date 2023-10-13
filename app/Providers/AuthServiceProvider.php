<?php

namespace App\Providers;

use App\Enums\Users\RoleEnum;
use App\Models\User;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot(): void
    {
        Gate::define('isConceptor', function (User $user) {
            return $user->role === RoleEnum::conceptor;
        });
    }
}
