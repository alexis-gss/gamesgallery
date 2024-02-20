<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

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
