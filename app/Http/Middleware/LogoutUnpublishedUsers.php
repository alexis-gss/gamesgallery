<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LogoutUnpublishedUsers
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure                 $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        /** @var \App\Models\User|null $userModel */
        $userModel = Auth::user();
        if (!is_null($userModel) && !$userModel->published) {
            Auth::logout();
            return redirect()->route('bo.login')->with('warning', trans('auth.unpublished_user'));
        }
        return $next($request);
    }
}
