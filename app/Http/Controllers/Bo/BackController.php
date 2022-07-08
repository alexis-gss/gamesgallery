<?php

namespace App\Http\Controllers\Bo;

use App\Http\Controllers\Controller;

class BackController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index(): \Illuminate\Contracts\View\View
    {
        return view('bo.home');
    }
}
