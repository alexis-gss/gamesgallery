<?php

namespace App\Http\Controllers\Bo\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest:backend')->except('logout');
    }

    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard(): \Illuminate\Contracts\Auth\StatefulGuard
    {
        return Auth::guard('backend');
    }

    /**
     * Show the application's login form.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function showLoginForm(): \Illuminate\Contracts\View\View
    {
        return view('back.auth.login');
    }

    /**
     * Where to redirect users after login.
     *
     * @return string
     */
    protected function redirectTo(): string
    {
        return response()->redirectToIntended()->getTargetUrl();
    }

    /**
     * Attempt to log the user into the application.
     *
     * @param \Illuminate\Http\Request $request
     * @return boolean
     */
    protected function attemptLogin(Request $request): bool
    {
        $credentials = $this->credentials($request);
        // * Attempt login only using published users.
        $credentials['published'] = true;
        return $this->guard()->attempt(
            $credentials,
            $request->boolean('remember')
        );
    }
}
