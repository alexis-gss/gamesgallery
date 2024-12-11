<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use LaravelActivityLogs\Seeders\ActivityLogSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run(): void
    {
        $this->call([
            ActivityLogSeeder::class,
            TagSeeder::class,
            FolderSeeder::class,
            GameSeeder::class,
            PictureSeeder::class,
            RankSeeder::class,
            RatingSeeder::class,
            UserSeeder::class,
            StaticPageSeeder::class
        ]);
    }
}
