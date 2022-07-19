<?php

namespace App\Http\Controllers\Bo;

use App\Http\Controllers\Controller;
use Parsedown;
use Illuminate\Support\Facades\File;

class BackController extends Controller
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

        return view('bo.home', ['changelog' => $changelog]);
    }
}
