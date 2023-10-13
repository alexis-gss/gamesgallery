<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param \Illuminate\Http\Request $request
     * @return string|null
     */
    protected function redirectTo(Request $request): ?string
    {
        $logins = [
            'backend' => route('bo.login')
        ];
        if (!$request->expectsJson()) {
            // * Notify must login
            Session::flash('warning', trans('auth.sign_in'));

            foreach ($request->route()->gatherMiddleware() as $middleware) {
                if (\is_string($middleware) and strpos($middleware, 'auth:') !== false) {
                    $route = $logins[str_replace('auth:', '', $middleware)] ?? null;
                    if ($route) {
                        return $route;
                    }
                }
            }
            return route('login');
        }

        return null;
    }
}
