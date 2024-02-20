<?php

namespace Database\Seeders;

use App\Models\Picture;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class PictureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        Picture::factory(20)->make()->each(function (Picture $picture) {
            $picture->saveQuietly();
            $folder = sprintf("pictures/%s", $picture->game->slug);
            Storage::disk("public")->makeDirectory($folder);
            File::copy(
                'database/factories/assets/games/default-game-picture.png',
                Storage::disk("public")->path($folder . "/" . $picture->uuid . '.webp')
            );
        });
    }
}
