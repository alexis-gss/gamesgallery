<?php

namespace App\Http\Controllers\Bo;

use App\Http\Controllers\Controller;

class BackController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('bo.home');
    }
}
