<?php

namespace Database\Seeders;

use App\Enums\Pages\StaticPageTypeEnum;
use App\Models\StaticPage;
use Illuminate\Database\Seeder;

class StaticPageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $static_page                  = new StaticPage();
        $static_page->type            = StaticPageTypeEnum::home;
        $static_page->seo_title       = __('fo_home_title');
        $static_page->seo_description = __('fo_home_description');
        $static_page->title           = __('fo_home_title');
        $static_page->order           = StaticPageTypeEnum::home->value();
        $static_page->saveQuietly();

        $static_page                  = new StaticPage();
        $static_page->type            = StaticPageTypeEnum::ranking;
        $static_page->seo_title       = __('fo_ranking_title');
        $static_page->seo_description = __('fo_ranking_description');
        $static_page->title           = __('fo_ranking_title');
        $static_page->order           = StaticPageTypeEnum::ranking->value();
        $static_page->saveQuietly();
    }
}
