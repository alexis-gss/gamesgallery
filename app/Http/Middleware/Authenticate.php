<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Support\Facades\Session;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param mixed $request
     * @return string|null
     */
    protected function redirectTo(mixed $request): ?string
    {
        if (!$request->expectsJson()) {
            // * Notify must login
            Session::flash('warning', trans('auth.sign_in'));

            return route('bo.login');
        }
    }
}
