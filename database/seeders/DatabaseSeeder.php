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
            RankSeeder::class,
            UserSeeder::class,
        ]);
    }
}
