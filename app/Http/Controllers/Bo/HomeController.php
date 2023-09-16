<?php

namespace App\Http\Controllers\Bo;

use App\Http\Controllers\Controller;
use Parsedown;
use Illuminate\Support\Facades\File;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index(): \Illuminate\Contracts\View\View
    {
        $parsedown = new Parsedown();
        $changelog = $parsedown->text(File::get(\app_path('../CHANGELOG.md')));

        return view('back.pages.home', compact('changelog'));
    }
}
