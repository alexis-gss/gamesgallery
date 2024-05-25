<?php

namespace App\Http\Controllers\Fo;

use App\Enums\Pages\StaticPageTypeEnum;
use App\Http\Controllers\Controller;
use App\Models\StaticPage;

class RankController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index(): \Illuminate\Contracts\View\View
    {
        /** @var \App\Models\StaticPage $staticPageModel */
        $staticPageModel = StaticPage::query()->where('type', StaticPageTypeEnum::ranking->value())->first();

        return view('front.pages.ranking', [
            'staticPageModel' => $staticPageModel,
            'gameModels'      => $this->getGamesPublished(),
            'rankModels'      => $this->getRanksPublished(),
            'folderModels'    => $this->getFoldersPublished(),
            'tagModels'       => $this->getTagsPublished(),
        ]);
    }
}
