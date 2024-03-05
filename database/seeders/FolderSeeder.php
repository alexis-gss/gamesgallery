<?php

namespace Database\Seeders;

use App\Models\Folder;
use Illuminate\Database\Seeder;

class FolderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        Folder::factory(12)->make()->each(function (Folder $folder) {
            if ($folder->mandatory) {
                $locales          = config('app.locales');
                $fallbelLocaleKey = array_search(config('app.fallback_locale'), config('app.locales'));
                unset($locales[$fallbelLocaleKey]);
                foreach ($locales as $locale) {
                    $folder->setTranslation('name', $locale, fake()->unique()->word);
                }
            }
            $folder->save();
        });
    }
}
