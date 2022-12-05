<?php

namespace App\Http\Controllers\Bo\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    /*
     *--------------------------------------------------------------------------
     * Login Controller
     *--------------------------------------------------------------------------
     *
     * This controller handles authenticating users for the application and
     * redirecting them to your home screen. The controller uses a trait
     * to conveniently provide its functionality to your applications.
     *
     */

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/bo';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Logout trait.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function logout(): \Illuminate\Http\RedirectResponse
    {
        Auth::logout();

        return redirect('bo/login');
    }
}
